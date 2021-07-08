<?php
include 'modules_functions/user_function.php';
include 'modules_functions/faqs_functions.php';
include 'modules_functions/event_functions.php';
include 'modules_functions/testimonial_functions.php';
include 'modules_functions/services_functions.php';
include 'modules_functions/questions_functions.php';
include 'modules_functions/video_functions.php';
include 'modules_functions/settings_functions.php';
include 'modules_functions/pages_functions.php';
include 'modules_functions/poll_functions.php';
include 'modules_functions/menu_functions.php';
include 'modules_functions/catagory_functions.php';
include 'modules_functions/product_functions.php';
include 'modules_functions/client_functions.php';


function test_input($data)
{
    $data = trim($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    return $data;
}
function admin_login($connection_string, $email)
{
    $get_data = array();
    $get_admin_info = "SELECT * FROM `admin_users` WHERE `admin_email` = '$email'";

    $get_admin_info_result = mysqli_query($connection_string, $get_admin_info);
    if (mysqli_num_rows($get_admin_info_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_object($get_admin_info_result);
        return array('status' => 1, 'get_info' => $get_data);
    }
}

function get_maximum_order($connection_string, $table_name, $column_name)
{
    $max_order = 0;
    $maximum_order_query = "SELECT MAX($column_name) max_order FROM `$table_name` LIMIT 1";
    $maximum_order_query_result = mysqli_query($connection_string, $maximum_order_query);
    $max_order_result = mysqli_fetch_object($maximum_order_query_result);
    if ($max_order_result) {
        $max_order = $max_order_result->max_order;
        return  $max_order;
    } else {
        return $max_order;
    }
}
function get_count_records_by_table($connection_string, $table_name)
{
    $count_query = "SELECT COUNT(*) AS total_count FROM $table_name";
    $count_query_result = mysqli_query($connection_string, $count_query);
    $count_result = mysqli_fetch_object($count_query_result);
    return $count_result->total_count;
}
/*********Email Validation Function******/
function email_validation($email)
{
    $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
    if (preg_match($pattern, $email) === 1) {
        return $email;
    } else {
        return false;
    }
}

function api_calling($request_Type, $data, $api_url, $header, $base_url)
{
    if ($request_Type == "POST") {
        $url_path = $base_url . $api_url;
        $ch = curl_init($url_path); // Initialise cURL
        $post = json_encode($data); // Encode the data array into a JSON string
        //curl_setopt($ch, CURLOPT_PORT, 4285);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); // Inject the token into the header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $result = curl_exec($ch); // Execute the cURL statement
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return array('response' => $result, 'httpcode' => $httpcode);
    }
    if ($request_Type == "GET") {
        $url_path = $base_url . $api_url;
        $ch = curl_init($url_path); // Initialise cURL

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); // Inject the token into the header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $result = curl_exec($ch); // Execute the cURL statement
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return array('response' => $result, 'httpcode' => $httpcode);
    }
}

function active_campign($first_name, $sur_name, $email, $url_campagin, $token, $list_id, $error_support, $error, $success, $connection_string)
{

    // Checking Values Should not Empty
    if (empty($first_name)) {
        $error = 'First Name is required. ';
    } else if (empty($sur_name)) {
        $error = 'Sur Name is required. ';
    } else if ($email == false) {
        $error = 'Invalid Email. ';
    } else if (email_exist($connection_string, $email) == false) {
        $error = 'Email Exist Already. ';
    }

    if (empty($error)) {
        $full_name = $first_name . ' ' . $sur_name;
        // If campaign url and token is set
        if ((!empty($token)) and (!empty($url_campagin))) {
            $campagin_auth = "Api-Token:" . $token;
            $postdata = array(
                'contact' => array(
                    "email" => $email,
                    "firstName" => $first_name,
                    "lastName" => $sur_name,
                    // "phone" => $phone
                ),
            );
            $request_Type = "POST";
            $api_url = "/api/3/contacts";
            $content_Type = "Content-Type: application/json";
            $header = array($content_Type, $campagin_auth);
            // print_r($header);die;
            $response = callAPI($request_Type, $postdata, $api_url, $header, $url_campagin);
            $httpcode = $response['httpcode'];
            $response_decoded = $response['response'];
            $result_decoded = json_decode($response_decoded, true);
            $ac_id = 0;
            $ac_id_status = false;

            if ($httpcode    ==    201) {
                //Get User ID on Active Campign to into list
                $ac_id  =   $result_decoded['contact']['id'];
                $ac_id_status = true;
            }

            if ($httpcode == 422) {
                $code = $result_decoded['errors'][0]['code'];

                //If user already exist
                if ($code == "duplicate") {
                    $request_Type = "GET";
                    $api_url = "/api/3/contacts?search=$email";
                    $content_Type = "Content-Type: application/json";
                    $header = array($content_Type, $campagin_auth);
                    $response = callAPI($request_Type, $postdata, $api_url, $header, $url_campagin);
                    $httpcode_search = $response['httpcode'];
                    $response_decoded = $response['response'];
                    $result_decoded = json_decode($response_decoded, true);
                    if ($httpcode_search == 200) {
                        $ac_id = $result_decoded['contacts'][0]['id'];
                        $ac_id_status = true;
                    }
                }
            }
            if ((!empty($list_id)) and ($ac_id_status == true)) {
                //Adding User into List if list_id is given
                $postdata = array(
                    'contactList' => array(
                        "list" => $list_id,
                        "contact" => $ac_id,
                        "status" => 1
                    )
                );
                $request_Type = "POST";
                $api_url = "/api/3/contactLists";
                $content_Type = "Content-Type: application/json";
                $header = array($content_Type, $campagin_auth);
                $response = callAPI($request_Type, $postdata, $api_url, $header, $url_campagin);
                $httpcode_list = $response['httpcode'];
                $response_decoded = $response['response'];
                $result_decoded = json_decode($response_decoded, true);
                if ($httpcode_list    ==    200) {
                    // $success = "User added in list.";
                } else {
                    // $error = "User not added in list.";
                }
            }
        }

        //Adding User to the Database
        $subscribers_query = "INSERT INTO `subscribers` (`first_name`,`sur_name`,`email`) VALUES ('$first_name','$sur_name','$email')";
        if (!$subscribers_query_result = mysqli_query($connection_string, $subscribers_query)) {
            $error = $error_support;
        } else {
            $success = "Thanks for Subscription";

            //Send Email to the Admin
            // $email_subject = 'Freedom Series Registration Message';
            // $headers = 'MIME-Version: 1.0' . "\r\n";
            // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // $headers .= 'From:' . $full_name_1 . "\r\n";
            // $message = "<p>New Registration requests was submitted from Freedom Series website. Following are the details of Registration request</p>";
            // $message .= '<p><strong>Name: </strong>' . $full_name_1 . '</p>';
            // $message .= '<p><strong>Phone: </strong>' . $phone_1 . '</p>';
            // $message .= '<p><strong>Email: </strong>' . $email_1 . '</p>';

            // //mail(To, Subject, Message, Header(From))
            // if (mail($admin_email, $email_subject, $message, $headers)) {
            //     if (json_encode(array("statusCode" => 200))) {
            //         $consult_success = "User added Successfuly.";
            //         $first_name_1 = '';
            //         $sur_name_1 = '';
            //         $phone_1 = '';
            //         $email_1 = '';
            //     } else {
            //         $error_1 = $error_support;
            //     }
            // }
        }
    }
    if ($error != '') {
        return array('status' => "0", 'message' => $error);
    } else {
        return array('status' => "1", 'message' => $success);
    }
}




function invokeApipost($api_method, $url, $data = '')
{
    $api_key = "111111111111111111111";
    // print_r($url . $api_key);
    // die;
    // $url = constant("api_base_url") . $url;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt(
        $curl,
        CURLOPT_HTTPHEADER,
        array(
            "Content-Type:multipart/form-data",
            "api_key:$api_key"
        )
    );
    switch ($api_method) {
        case "GET":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            break;
        case "POST":
            curl_setopt($curl, CURLOPT_POSTFIELDS, ($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_POSTFIELDS, ($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
    }
    $curl_response = curl_exec($curl);
    $err = curl_error($curl);
    if ($err) {
        echo ("curl_exec threw error . $err . ");
    }
    $data = json_decode($curl_response, true);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if ($httpCode == 401) {
        return array('httpCode' => $httpCode, 'data' => $data);
        // header('location: include/login/logout.php');
    } else {
        return array('httpCode' => $httpCode, 'data' => $data);
    }
}
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function invokeApi($method, $url, $data = false)
{
    // print_r($data);

    $api_key = constant("X-Api-Key");
    $curl = curl_init();
    curl_setopt(
        $curl,
        CURLOPT_HTTPHEADER,
        array(
            "Content-Type:multipart/form-data",
            "X-Api-Key:$api_key"
        )
    );
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, $data);
    }

    // Optional Authentication:
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);



    curl_close($curl);

    return $result;
}



function invokeApi1($api_method, $url, $data = '')
{
    $api_key = constant("api_key");
    // $url = constant("api_base_url") . $url;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt(
        $curl,
        CURLOPT_HTTPHEADER,
        array(
            "Content-Type:multipart/form-data",
            "api_key:$api_key"
        )
    );
    switch ($api_method) {
        case "GET":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            break;
        case "POST":
            curl_setopt($curl, CURLOPT_POSTFIELDS, ($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_POSTFIELDS, ($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
    }
    $curl_response = curl_exec($curl);
    $err = curl_error($curl);
    if ($err) {
        echo ("curl_exec threw error . $err . ");
    }
    $data = json_decode($curl_response, true);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if ($httpCode == 401) {
        $a = array('httpCode' => $httpCode, 'data' => $data);
        // header('location: include/login/logout.php');
    } else {
        $a = array('httpCode' => $httpCode, 'data' => $data);
    }

    echo json_encode($a);
}



// function callAPI($method, $url, $data)
// {
//     $curl = curl_init();
//     switch ($method) {
//         case "POST":
//             curl_setopt($curl, CURLOPT_POST, 1);
//             if ($data)
//                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//             break;
//         case "PUT":
//             curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
//             if ($data)
//                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//             break;
//         default:
//             if ($data)
//                 $url = sprintf("%s?%s", $url, http_build_query($data));
//     }
//     // OPTIONS:
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//         'api_key: 111111111111111111111',
//         'Content-Type: application/json',
//     ));
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//     // EXECUTE:
//     $result = curl_exec($curl);
//     $result1 = json_decode($result, true);

//     print_r($result1);
//     if (!$result) {
//         die("Connection Failure");
//     }
//     curl_close($curl);
//     return $result;
// }
//validate api methos and requested method
function validate_api_key_and_method($api_method, $get_api_method, $get_api_key)
{ //to check api method and api kay
    $api_key = constant("api_key");
    // if ($api_key != $get_api_key) {
    // return array('status' => 0, 'message' => "please provide correct api key");
    // }
    if ($api_method != $get_api_method) {
        return array('status' => 0, 'message' => "Http method not allowed");
    } else {
        return array('status' => 1, 'message' => "success");
    }
}


function api_calling_2($request_Type, $api_url, $data = null, $header = null)
{
    if ($request_Type == "POST") {
        $url_path = $api_url;
        $ch = curl_init($url_path); // Initialise cURL
        $post = json_encode($data); // Encode the data array into a JSON string
        //curl_setopt($ch, CURLOPT_PORT, 4285);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); // Inject the token into the header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $result = curl_exec($ch); // Execute the cURL statement
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array('response' => $result, 'httpcode' => $httpcode);
    } else if ($request_Type == "GET") {
        $postdata = $data;
        $url_path = $api_url;
        $ch = curl_init($url_path);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $a = array('response' => $result, 'httpcode' => $httpcode);
        print_r($a);
    }
}



//Call Api 

function ApiCalling($api_method, $url, $data = '')
{
    $api_key = constant("X-Api-Key");
    $url = constant("api_base_url") . $url;
    $curl = curl_init($url);
    // print_r($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt(
        $curl,
        CURLOPT_HTTPHEADER,
        array(
            "Content-Type:multipart/form-data",
            "X-Api-Key:$api_key"
        )
    );
    switch ($api_method) {
        case "GET":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            break;
        case "POST":
            curl_setopt($curl, CURLOPT_POSTFIELDS, ($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_POSTFIELDS, ($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
    }
    $curl_response = curl_exec($curl);
    $err = curl_error($curl);
    if ($err) {
        echo ("curl_exec threw error . $err . ");
    }
    $data = json_decode($curl_response, true);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($httpCode == 401) {
        return array('httpCode' => $httpCode, 'data' => $data);
        // header('location: include/login/logout.php');
    } else {
        return array('httpCode' => $httpCode, 'data' => $data);
    }
}

//change status and payment
function perform_http_request($method, $url, $data = false)
{
    $api_key = constant("X-Api-Key");
    $url = constant("api_base_url") . $url;
    $curl = curl_init($url);
    curl_setopt(
        $curl,
        CURLOPT_HTTPHEADER,
        array(
            "Content-Type:multipart/form-data",
            "X-Api-Key:$api_key"
        )
    );
    // $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, $data);
    }

    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
//Call Active Compaign Function

function callAPI($request_Type, $data = false, $api_url, $header, $url_campagin)
{
    $url = $url_campagin . $api_url;
    $curl = curl_init();
    // print_r($data);
    // die;
    $data = json_encode($data);
    switch ($request_Type) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, $data);
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return array('response' => $result, 'httpcode' => $httpcode);
}
