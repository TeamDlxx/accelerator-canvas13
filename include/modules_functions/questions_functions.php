<?php
//Get question info 
function get_questions_info($connection_string)
{
    $get_info = array();
    $questions_info_query = "SELECT subscribers.first_name,subscribers.sur_name,subscribers.organization,questions.id,questions.question,questions.status,questions.answered FROM `subscribers`INNER JOIN `questions`ON subscribers.id=questions.user_id";
    $questions_info_query_result = mysqli_query($connection_string, $questions_info_query);
    if (mysqli_num_rows($questions_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        while ($questions_result = mysqli_fetch_array($questions_info_query_result)) {
            $get_info[] = $questions_result;
        }
        return array('status' => "1", 'get_info' => $get_info);
    }
}
//reply answer by id
function update_answer_by_id($connection_string, $answer_id)
{
    $get_info = array();
    $questions_info_query = "SELECT `answered` FROM `questions`Where id=$answer_id";
    $questions_info_query_result = mysqli_query($connection_string, $questions_info_query);
    if (mysqli_num_rows($questions_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $questions_result = mysqli_fetch_object($questions_info_query_result);
    }
    return array('status' => "1", 'get_info' => $questions_result);
}

//get question by id
function get_question_by_id($connection_string, $question_id)
{
    $get_info = array();
    $question_info_query = "SELECT `question`,`user_id` FROM `questions`Where id='$question_id'";
    $question_info_query_result = mysqli_query($connection_string, $question_info_query);
    if (mysqli_num_rows($question_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $question_result = mysqli_fetch_object($question_info_query_result);
    }
    return array('status' => "1", 'get_info' => $question_result);
}
//reply answer by id
function get_answer_by_id($connection_string, $answer_id)
{
    $get_info = array();
    $answer_info_query = "SELECT `question_answer` FROM `question_answer`Where question_id='$answer_id'";
    $answer_info_query_result = mysqli_query($connection_string, $answer_info_query);
    if (mysqli_num_rows($answer_info_query_result) == 0) {
        return array('status' => "0", 'get_info' => $get_info);
    } else {
        $answer_result = mysqli_fetch_object($answer_info_query_result);
    }
    return array('status' => "1", 'get_info' => $answer_result);
}
function get_user_info_by_user_id($connection_string, $user_id)
{
    $get_data = array();
    $select_uesr_query = "SELECT * FROM `subscribers` where `id`=$user_id ";
    $select_uesr_query_result = mysqli_query($connection_string, $select_uesr_query);
    if (mysqli_num_rows($select_uesr_query_result) == 0) {
        return array('status' => 0, 'get_info' => $get_data);
    } else {
        $get_data = mysqli_fetch_object($select_uesr_query_result);
        return array('status' => 1, 'get_info' => $get_data);
    }
}