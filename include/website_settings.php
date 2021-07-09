<?php
// Setting Information
$get_setting_query = "SELECT * FROM `setting` WHERE `id`=1";
$get_setting_query_result = mysqli_query($connection_string, $get_setting_query);
$get_setting_info  = mysqli_fetch_object($get_setting_query_result);

// Meta Information
$meta_title = $get_setting_info->meta_title;
$meta_description = $get_setting_info->meta_description;
$meta_keyword = $get_setting_info->meta_keyword;
$admin_email = $get_setting_info->admin_email;
$admin_phone = $get_setting_info->admin_phone;
$admin_fex = $get_setting_info->admin_fex;
$button1_title = $get_setting_info->button1_text;
$button1_link = $get_setting_info->button1_link;
$button2_title = $get_setting_info->button2_text;
$button3_title = $get_setting_info->button3_text;

$google_map_code = stripslashes(htmlspecialchars_decode($get_setting_info->welcome_video_embed_code));

// Pixel Code Information
$facebook_pixal_code = stripslashes(htmlspecialchars_decode($get_setting_info->facebook_pixal_code));
$facebook_pixal_code_body = stripslashes(htmlspecialchars_decode($get_setting_info->facebook_pixal_code_body));
$google_analytics = stripslashes(htmlspecialchars_decode($get_setting_info->google_analytics));
$google_analytics_body = stripslashes(htmlspecialchars_decode($get_setting_info->google_analytics_body));

// Brand Logo
$logo_brand = $get_setting_info->brand_logo;
$brand_title = $get_setting_info->brand_title;

// Active Campaign Information
$url_campagin = $get_setting_info->active_compaign_url;
$token = $get_setting_info->active_compaign_token;
$list_id = $get_setting_info->active_compaign_list_id;

$show_logo = $get_setting_info->show_logo;
$business_title = $get_setting_info->business_title;
$fav_icons = $get_setting_info->fav_icon;
$email_subject1 = $get_setting_info->email_subject;
$contact_email_message = stripslashes(htmlspecialchars_decode($get_setting_info->contact_email_message));
$admin_logo = $get_setting_info->admin_logo;
// Website Content
$get_website_query = "SELECT * FROM `dashboard` WHERE `id`=1";
$get_website_query_result = mysqli_query($connection_string, $get_website_query);
$get_website_info  = mysqli_fetch_object($get_website_query_result);
$home_description = stripslashes(htmlspecialchars_decode($get_website_info->home_description));
$home_description_2 = stripslashes(htmlspecialchars_decode($get_website_info->home_description_2));
$home_heading = stripslashes(htmlspecialchars_decode($get_website_info->home_heading));
$contact_form_button_text = stripslashes(htmlspecialchars_decode($get_website_info->who_we_are));

$banner_image = stripslashes(htmlspecialchars_decode($get_website_info->banner_image));
$banner_image_2 = stripslashes(htmlspecialchars_decode($get_website_info->banner_image_2));
$banner_image3 = stripslashes(htmlspecialchars_decode($get_website_info->banner_image3));
$banner_image4 = stripslashes(htmlspecialchars_decode($get_website_info->banner_image4));
$banner_image5 = stripslashes(htmlspecialchars_decode($get_website_info->image_2));
$benifint_heading =  stripslashes(htmlspecialchars_decode($get_website_info->faq_heading));
$service_image = stripslashes(htmlspecialchars_decode($get_website_info->image_1));

// $client_image = $get_setting_info->image_1;

$welcome_content = stripslashes(htmlspecialchars_decode($get_website_info->welcome_content));
$service_content = stripslashes(htmlspecialchars_decode($get_website_info->what_we_do));
$address_content = stripslashes(htmlspecialchars_decode($get_website_info->who_we_are));
$contact_form_content = stripslashes(htmlspecialchars_decode($get_website_info->keep_in_touch));
$footer_content = stripslashes(htmlspecialchars_decode($get_website_info->footer_content));

$service_button_text = stripslashes(htmlspecialchars_decode($get_website_info->twitter_link));
$about_heading = stripslashes(htmlspecialchars_decode($get_website_info->facebook_link));
$pinterest_link = stripslashes(htmlspecialchars_decode($get_website_info->pinterest_link));
$github_link = stripslashes(htmlspecialchars_decode($get_website_info->gmail_link));
$linkedin_link = stripslashes(htmlspecialchars_decode($get_website_info->linkedin_link));

$slider_button1_title = stripslashes(htmlspecialchars_decode($get_website_info->button1_text));
$slider_button2_title = stripslashes(htmlspecialchars_decode($get_website_info->button2_text));
$slider_button1_link = stripslashes(htmlspecialchars_decode($get_website_info->button1_link));
$slider_button2_link = stripslashes(htmlspecialchars_decode($get_website_info->button2_link));
$video_title1 = stripslashes(htmlspecialchars_decode($get_website_info->video_title1));
$video_title2 = stripslashes(htmlspecialchars_decode($get_website_info->video_title2));
$video_title3 = stripslashes(htmlspecialchars_decode($get_website_info->video_title3));
$video_title4 = stripslashes(htmlspecialchars_decode($get_website_info->video_title4));
$contact_support = stripslashes(htmlspecialchars_decode($get_website_info->contact_support));

$client_content = stripslashes(htmlspecialchars_decode($get_website_info->client_content));
$contact_us_content = stripslashes(htmlspecialchars_decode($get_website_info->contact_us_content));


//Services
$services = array();
$service_query = "SELECT * FROM services order by service_order asc";
$service_query_result = mysqli_query($connection_string, $service_query);
if (mysqli_num_rows($service_query_result) > 0) {
    while ($data = mysqli_fetch_assoc($service_query_result)) {
        $services[] = $data;
    }
}
