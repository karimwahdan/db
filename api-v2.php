<?php
header("Content-Type: application/json");
    header("Expires: 0");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
	
include('library/crud.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$db->sql("SET NAMES 'utf8'");

$response = array();
$access_key = "6808";

/* 	API methods
	-------------------------
	1. get_categories()
	2. get_subcategory_by_maincategory()
	3. get_questions_by_subcategory()
	4. get_questions_by_category()
	5. report_question()
	6. get_privacy_policy_settings()
*/

// 1. get_categories() - get category details
if(isset($_POST['access_key']) && isset($_POST['get_categories'])){
	/* Parameters to be passed
		access_key:6808
		get_categories:1
		id:31 //{optional}
	*/
	if($access_key != $_POST['access_key']){
		$response['error'] = "true";
		$response['message'] = "Invalid Access Key";
		print_r(json_encode($response));
		return false;
	}
	if(isset($_POST['id'])){
		$id = $db->escapeString($_POST['id']);
		$sql = "SELECT *,(SELECT @no_of_subcategories := count(*) from subcategory s WHERE s.maincat_id = c.id and s.status = 1 ) as no_of, if(@no_of_subcategories = 0, (SELECT @maxlevel := MAX(`level`) from question q WHERE c.id = q.category ),@maxlevel := 0) as `maxlevel` FROM `category` c WHERE c.id = $id ORDER By c.row_order ASC";
		$db->sql($sql);
		$result = $db->getResult();
		// print_r($result);
		if (!empty($result)) {
			$result[0]['image'] = (!empty($result[0]['image']))?DOMAIN_URL.'category/'.$result[0]['image']:'';
			$response['error'] = "false";
			$response['data'] = $result[0];
		}else{
			$response['error'] = "true";
			$response['message'] = "No data found!";
		}
		print_r(json_encode($response));
	}else{
		$sql = "SELECT *,(SELECT @no_of_subcategories := count(*) from subcategory s WHERE s.maincat_id = c.id and s.status = 1 ) as no_of, if(@no_of_subcategories = 0, (SELECT @maxlevel := MAX(`level`) from question q WHERE c.id = q.category ),@maxlevel := 0) as `maxlevel` FROM `category` c ORDER By c.row_order ASC";
		$db->sql($sql);
		$result = $db->getResult();
		// print_r($result);
		if (!empty($result)) {
			for($i=0;$i<count($result);$i++){
				$result[$i]['image'] = (!empty($result[$i]['image']))?DOMAIN_URL.'category/'.$result[$i]['image']:'';
			}
			$response['error'] = "false";
			$response['data'] = $result;
		}else{
			$response['error'] = "true";
			$response['message'] = "No data found!";
		}
		print_r(json_encode($response));
	}
}

// 2. get_subcategory_by_maincategory() - get sub category details
if(isset($_POST['access_key']) && isset($_POST['get_subcategory_by_maincategory'])){
	/* Parameters to be passed
		access_key:6808
		get_subcategory_by_maincategory:1
		main_id:31
	*/
	if($access_key != $_POST['access_key']){
		$response['error'] = "true";
		$response['message'] = "Invalid Access Key";
		print_r(json_encode($response));
		return false;
	}
	if(isset($_POST['main_id'])){
		$id = $db->escapeString($_POST['main_id']);
		$sql = "SELECT *,(select max(level) from question where question.subcategory=subcategory.id ) as maxlevel FROM `subcategory` WHERE `maincat_id`='$id' and `status`=1 ORDER BY row_order ASC";
		$db->sql($sql);
		$result = $db->getResult();
		// print_r($result);
		if (!empty($result)) {
			for($i=0;$i<count($result);$i++){
				$result[$i]['image'] = (!empty($result[$i]['image']))?DOMAIN_URL.'subcategory/'.$result[$i]['image']:'';
				$result[$i]['maxlevel'] = ($result[$i]['maxlevel'] == '' || $result[$i]['maxlevel'] == null )?'':$result[$i]['maxlevel'];
			}
			$response['error'] = "false";
			$response['data'] = $result;
		}else{
			$response['error'] = "true";
			$response['message'] = "No data found!";
		}
		print_r(json_encode($response));
	}
}
// 3. get_questions_by_subcategory() - get sub category questions
if(isset($_POST['access_key']) && isset($_POST['get_questions_by_subcategory'])){
	/* Parameters to be passed
		access_key:6808
		get_questions_by_subcategory:1
		subcategory:115
	*/
	if($access_key != $_POST['access_key']){
		$response['error'] = "true";
		$response['message'] = "Invalid Access Key";
		print_r(json_encode($response));
		return false;
	}
	if(isset($_POST['subcategory'])){
		$id = $db->escapeString($_POST['subcategory']);
		$sql = "SELECT * FROM `question` where subcategory=".$id." ORDER by RAND()";
		$db->sql($sql);
		$result = $db->getResult();
		// print_r($result);
		if (!empty($result)) {
			for($i=0;$i<count($result);$i++){
				$result[$i]['image'] = (!empty($result[$i]['image']))?DOMAIN_URL.'images/questions/'.$result[$i]['image']:'';
			}
			$response['error'] = "false";
			$response['data'] = $result;
		}else{
			$response['error'] = "true";
			$response['message'] = "No data found!";
		}
		print_r(json_encode($response));
	}
}
// 4. get_questions_by_category() - get category questions
if(isset($_POST['access_key']) && isset($_POST['get_questions_by_category'])){
	/* Parameters to be passed
		access_key:6808
		get_questions_by_category:1
		category:115
	*/
	if($access_key != $_POST['access_key']){
		$response['error'] = "true";
		$response['message'] = "Invalid Access Key";
		print_r(json_encode($response));
		return false;
	}
	if(isset($_POST['category'])){
		$id = $db->escapeString($_POST['category']);
		$sql = "SELECT * FROM `question` WHERE category=".$id." ORDER BY id DESC";
		$db->sql($sql);
		$result = $db->getResult();
		// print_r($result);
		if (!empty($result)) {
			for($i=0;$i<count($result);$i++){
				$result[$i]['image'] = (!empty($result[$i]['image']))?DOMAIN_URL.'images/questions/'.$result[$i]['image']:'';
			}
			$response['error'] = "false";
			$response['data'] = $result;
		}else{
			$response['error'] = "true";
			$response['message'] = "No data found!";
		}
	}
	print_r(json_encode($response));
}
//5. report_question() - report a question by user
if(isset($_POST['report_question']) && isset($_POST['access_key']) ){
	/* Parameters to be passed
		access_key:6808
		report_question:1
		question_id:115
		message: Any reporting message
	*/
	if($access_key != $_POST['access_key']){
		$response['error'] = "true";
		$response['message'] = "Invalid Access Key";
		print_r(json_encode($response));
		return false;
	}
	
	$question_id = $_POST['question_id'];
	$message = $_POST['message'];
	if(!empty($question_id) && !empty($message)){
		$data = array(
			'question_id'	 => $question_id,
			'message' => $message,
			'date' => date("Y-m-d")//$datetime->format('Y\-m\-d\ h:i:s'),
		);
		// print_r($data);
		// return false;
		
		$db->insert('question_reports',$data);  // Table name, column names and respective values
		$res = $db->getResult();
		
		$response['error'] = false;
		$response['message'] = "Report submitted successfully";
		$response['id'] = $res[0];
	}else{
		$response['error'] = true;
		$response['message'] = "Please fill all the data and submit!";
	}
	print_r(json_encode($response));
}
// 6. get_privacy_policy_settings()
if(isset($_POST['access_key']) && isset($_POST['privacy_policy_settings']) AND $_POST['privacy_policy_settings']==1){
	/* Parameters to be passed
		access_key:6808
		privacy_policy_settings:1
	*/
	if($access_key != $_POST['access_key']){
		$response['error'] = "true";
		$response['message'] = "Invalid Access Key";
		print_r(json_encode($response));
		return false;
	}
	
	if(!empty($_POST['access_key'])){
		$sql = "SELECT * FROM `tbl_privacy_policy` WHERE id=1 LIMIT 1";
        $db->sql($sql);
		$res = $db->getResult();
		if(!empty($res)) {
			$response['error'] = "false";
			$response['data'] = $res[0]['privacy_policy'];
		}else{
			$response['error'] = "true";
			$response['message'] = "No data found!";
		}
	}else{
		$response['error'] = "true";
		$response['message'] = "Please pass all the fields";
	}
	print_r(json_encode($response));
}


/*firebase send message function*/
function send_message($token,$title,$message,$type){
	
/*
	Title 	: Transaction Details
	Message :
	Today Bottles 3
	Total Amount - 50 | Total Balance - 100
*/
	
	require_once 'library/firebase.php';
	require_once 'library/push.php';
	
	$firebase = new Firebase();
	$push = new Push();
	
	// optional payload
	$payload = array();
	$payload['team'] = 'India';
	$payload['score'] = '5.6';
	
	$push->setTitle($title);
	$push->setMessage($message);
	// $push->setImage('');
	$push->setType($type);
	
	$push->setIsBackground(FALSE);
	$push->setPayload($payload);
	
	$json = $response = '';
	
	$json = $push->getPush();
	$response = $firebase->send($token, $json);
	return $response;
}

?>