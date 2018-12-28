<?php
session_start();
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])){
	header("location:index.php");
	return false;
}
include('library/crud.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
/*
1. add_category()
2. update_category()
3. delete_category()
4. add_subcategory()
5. update_subcategory()
6. delete_subcategory()
7. get_subcategories_of_category()
8. add_question()
9. update_question()
10. delete_question()
11. send_notifications()
12. update_fcm_server_key()


1. update_user()
2. update_admin()
3. update_payment_request()
6. delete_category()

*/
//1. add_category 
if(isset($_POST['name']) and isset($_POST['add_category'])){
	$name = $db->escapeString($_POST['name']);
	$filename = '';
	// common image file extensions
	if($_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		// $extension = explode(".", $_FILES["image"]["name"]);
		// $extension = end($extension);
		$extension = pathinfo($_FILES["image"]["name"])['extension'];
		if(!(in_array($extension, $allowedExts))){
			$response['error']=true;
			$response['message']='Image type is invalid';
			echo json_encode($response);
			return false;
		}
		$target_path = 'category/';
		$filename = microtime(true).'.'. strtolower($extension);
		$full_path = $target_path."".$filename;
		if(!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)){
			$response['error']=true;
			$response['message']='Image type is invalid';
			echo json_encode($response);
			return false;
		}
	}
	
	$sql = "INSERT INTO `category` (`category_name`, `image`) VALUES ('".$name."','".$filename."')";
	// echo $sql;
	// return false;
	$db->sql($sql);
	echo '<label class="alert alert-success">Category created successfully!</label>';
}

//2. update_category
if(isset($_POST['category_id']) && isset($_POST['update_category'])){
	$id = $_POST['category_id'];
	$name = $db->escapeString($_POST['name']);
	
	if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0)
	{
		//image isn't empty and update the image
		$image_url = $db->escapeString($_POST['image_url']);
		
		// common image file extensions
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		// $extension = end(explode(".", $_FILES["image"]["name"]));
		$extension = pathinfo($_FILES["image"]["name"])['extension'];
		if(!(in_array($extension, $allowedExts))){
			echo '<p class="alert alert-danger">Image type is invalid</p>';
			return false;
		}
		$target_path = 'category/';
		$filename = microtime(true).'.'. strtolower($extension);
		$full_path = $target_path."".$filename;
		if(!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)){
			echo '<p class="alert alert-danger">Image type is invalid</p>';
			return false;
		}
		unlink($image_url);
		$sql = "Update category set `image`='".$filename."' where `id`=".$id;
		$db->sql($sql);
    } 
	
	$sql = "Update category set `category_name`='".$name."' where `id`=".$id;
	
	// echo $sql;
	// return false;
	$db->sql($sql);
	echo "<p class='alert alert-success'>Category updated successfully!</p>";
}

//3. delete_category
if(isset($_GET['delete_category']) && $_GET['delete_category'] != '' ) {
    $id = $_GET['id'];
    $image = $_GET['image'];
    
	$sql = 'DELETE FROM `category` WHERE `id`='.$id;
	if($db->sql($sql)){
		if(!empty($image))
			unlink($image);
		
		// select sub category images & delete it
		$sql = 'select `image` FROM `subcategory` WHERE `maincat_id`='.$id;
		$db->sql($sql);
		$sub_category_images = $db->getResult();
		// print_r($sub_category_images);
		if(!empty($sub_category_images)){
			foreach($sub_category_images as $image)
			{
				if(!empty($image['image']))
					unlink('subcategory/'.$image['image']);
			}
		}
		
		$sql = 'DELETE FROM `subcategory` WHERE `maincat_id`='.$id;
		$db->sql($sql);
		
		$sql = 'DELETE FROM `question` WHERE `category`='.$id;
		$db->sql($sql);
		echo 1;
	}else{
		echo 0;
	}
}

//4. add_subcategory
if(isset($_POST['name']) and isset($_POST['add_subcategory'])){
	$name = $db->escapeString($_POST['name']);
	$maincat_id = $db->escapeString($_POST['maincat_id']);
	
	$filename = '';
	// common image file extensions
	if($_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		// $extension = explode(".", $_FILES["image"]["name"]);
		// $extension = end($extension);
		$extension = pathinfo($_FILES["image"]["name"])['extension'];
		if(!(in_array($extension, $allowedExts))){
			$response['error']=true;
			$response['message']='Image type is invalid';
			echo json_encode($response);
			return false;
		}
		$target_path = 'subcategory/';
		$filename = microtime(true).'.'. strtolower($extension);
		$full_path = $target_path."".$filename;
		if(!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)){
			$response['error']=true;
			$response['message']='Image type is invalid';
			echo json_encode($response);
			return false;
		}
	}
	
	$sql = "INSERT INTO `subcategory` (`maincat_id`,`subcategory_name`, `image`) VALUES ('".$maincat_id."','".$name."','".$filename."')";
	// echo $sql;
	// return false;
	$db->sql($sql);
	echo '<label class="alert alert-success">Sub Category created successfully!</label>';
}

//5. update_subcategory
if(isset($_POST['subcategory_id']) && isset($_POST['update_subcategory'])){
	$id = $_POST['subcategory_id'];
	$name = $db->escapeString($_POST['name']);
	$maincat_id = $db->escapeString($_POST['maincat_id']);
	
	if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0)
	{
		//image isn't empty and update the image
		$image_url = $db->escapeString($_POST['image_url']);
		
		// common image file extensions
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		// $extension = end(explode(".", $_FILES["image"]["name"]));
		$extension = pathinfo($_FILES["image"]["name"])['extension'];
		if(!(in_array($extension, $allowedExts))){
			echo '<p class="alert alert-danger">Image type is invalid</p>';
			return false;
		}
		$target_path = 'subcategory/';
		$filename = microtime(true).'.'. strtolower($extension);
		$full_path = $target_path."".$filename;
		if(!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)){
			echo '<p class="alert alert-danger">Image type is invalid</p>';
			return false;
		}
		unlink($image_url);
		$sql = "Update subcategory set `image`='".$filename."' where `id`=".$id;
		$db->sql($sql);
    } 
	
	$sql = "Update subcategory set `maincat_id`='".$maincat_id."', `subcategory_name`='".$name."' where `id`=".$id;
	
	// echo $sql;
	// return false;
	$db->sql($sql);
	echo "<p class='alert alert-success'>Sub category updated successfully!</p>";
}
//6. delete_subcategory
if(isset($_GET['delete_subcategory']) && $_GET['delete_subcategory'] != '' ) {
    $id = $_GET['id'];
    $image = $_GET['image'];
    
	$sql = 'DELETE FROM `subcategory` WHERE `id`='.$id;
	if($db->sql($sql)){
		if(!empty($image))
			unlink($image);
		
		$sql = 'DELETE FROM `question` WHERE `subcategory`='.$id;
		$db->sql($sql);
		echo 1;
	}else{
		echo 0;
	}
}

//7. get_subcategories_of_category - ajax dropdown menu options 
if(isset($_POST['get_subcategories_of_category']) && $_POST['get_subcategories_of_category'] != '' ) {
    $id = $_POST['category_id'];
    if(empty($id)){
		echo '<option value="">Select Sub Category</option>';
		return false;
	}
	$sql = 'select id,`subcategory_name` FROM `subcategory` WHERE `maincat_id`='.$id;
	// echo $sql;
	$db->sql($sql);
	$res = $db->getResult();
	$options = '<option value="">Select Sub Category</option>';
	foreach($res as $option){
		$options .="<option value='".$option['id']."'>".$option['subcategory_name']."</option>";
	}
	echo $options;
}
//8. add_question
if(isset($_POST['question']) and isset($_POST['add_question'])){
	
	$question = $db->escapeString($_POST['question']);
	$category = $db->escapeString($_POST['category']);
	$subcategory = $db->escapeString($_POST['subcategory']);
	$a = $db->escapeString($_POST['a']);
	$b = $db->escapeString($_POST['b']);
	$c = $db->escapeString($_POST['c']);
	$d = $db->escapeString($_POST['d']);
	$level = $db->escapeString($_POST['level']);
	$answer = $db->escapeString($_POST['answer']);
	$note = $db->escapeString($_POST['note']);
	
	$sql = "INSERT INTO `question`(`category`, `subcategory`, `question`, `optiona`, `optionb`, `optionc`, `optiond`, `level`, `answer`, `note`) VALUES 
	('".$category."','".$subcategory."','".$question."','".$a."','".$b."','".$c."','".$d."','".$level."','".$answer."','".$note."')";
	
	$db->sql($sql);
	$res = $db->getResult();
	echo '<label class="alert alert-success">Question created successfully!</label>';
}
//9. update_question
if(isset($_POST['question_id']) && isset($_POST['update_question'])){
	$id = $_POST['question_id'];
	$question = $db->escapeString($_POST['question']);
	$category = $db->escapeString($_POST['category']);
	$subcategory = $db->escapeString($_POST['subcategory']);
	$a = $db->escapeString($_POST['a']);
	$b = $db->escapeString($_POST['b']);
	$c = $db->escapeString($_POST['c']);
	$d = $db->escapeString($_POST['d']);
	$level = $db->escapeString($_POST['level']);
	$answer = $db->escapeString($_POST['answer']);
	$note = $db->escapeString($_POST['note']);
	
	$sql = "Update `question` set `question`='".$question."', `category`='".$category."', `subcategory`='".$subcategory."',`optiona`='".$a."',`optionb`='".$b."' ,`optionc`='".$c."' ,`optiond`='".$d."' ,`answer`='".$answer."' ,`level`='".$level."',`note`='".$note."' where `id`=".$id;
	
	// echo $sql;
	// return false;
	$db->sql($sql);
	echo "<p class='alert alert-success'>Question updated successfully!</p>";
}
//10. delete_question
if(isset($_GET['delete_question']) && $_GET['delete_question'] != '' ) {
    $id		= $_GET['id'];
    $sql = 'DELETE FROM `question` WHERE `id`='.$id;
	if($db->sql($sql)){
		echo 1;
	}else{
		echo 0;
	}
}

//11. send_notifications - send notifications to users
if(isset($_POST['title']) and isset($_POST['send_notifications'])){
	$sql = 'select `fcm_key` from `tbl_fcm_key` where id=1';
	$db->sql($sql);
	$res = $db->getResult();
	
	define('API_ACCESS_KEY', $res[0]['fcm_key']);
	
	//creating a new push
	$title = $db->escapeString($_POST['title']);
	$message = $db->escapeString($_POST['message']);
	// $users = $db->escapeString($_POST['users']);
	
	/* if($users == 'all'){
		$sql = "select `fcm_id` from `users` ";
		$db->sql($sql);
		$res = $db->getResult();
		$fcm_ids = array();
		foreach($res as $fcm_id){
			$fcm_ids[] = $fcm_id['fcm_id'];
		}
	}elseif($users == 'selected'){
		$selected_list = $_POST['selected_list'];
		if(empty($selected_list)){
			$response['error']=true;
			$response['message']='Please Select the users from the table';
			echo json_encode($response);
			return false;
		}
		$fcm_ids = array();
		$fcm_ids = explode(",",$selected_list);
	} */
	
	
	$sql = "select `token` from `tbl_devices` ";
	$db->sql($sql);
	$res = $db->getResult();
	$fcm_ids = array();
	foreach($res as $fcm_id){
		$fcm_ids[] = $fcm_id['token'];
	}
	
	$registrationIDs = $fcm_ids;
	// print_r($fcm_ids);
	// return false;
	
	/*dynamically getting the domain of the app*/
	$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	$url .= $_SERVER['SERVER_NAME'];
	$url .= $_SERVER['REQUEST_URI'];
	$server_url = dirname($url).'/';
		
	$push = null;
	$include_image = (isset($_POST['include_image']) && $_POST['include_image'] == 'on') ? TRUE : FALSE;
	if($include_image){
		// common image file extensions
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		// $extension = end(explode(".", $_FILES["image"]["name"]));
		$extension = pathinfo($_FILES["image"]["name"])['extension'];
		if(!(in_array($extension, $allowedExts))){
			$response['error']=true;
			$response['message']='Image type is invalid';
			echo json_encode($response);
			return false;
		}
		$target_path = 'images/notifications/';
		$filename = microtime(true).'.'. strtolower($extension);
		$full_path = $target_path."".$filename;
		if(!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)){
			$response['error']=true;
			$response['message']='Image type is invalid';
			echo json_encode($response);
			return false;
		}
		/* $sql = "INSERT INTO `notifications`(`title`, `message`, `image`) VALUES 
			('".$title."','".$message."','".$full_path."')"; */
	}else{
		/* $sql = "INSERT INTO `notifications`(`title`, `message`) VALUES 
			('".$title."','".$message."')"; */
	}
	// $db->sql($sql);
	
	$newMsg = array();
	
	//first check if the push has an image with it
	if($include_image){
		$fcmMsg = array(
			'title' => $title,
			'message' => $message,
			'image' => DOMAIN_URL.'/'.$full_path
			//'image' => $server_url.''.$full_path
			//'sound' => "default",
			// 'color' => "#203E78" 
		);
		
		$newMsg['data'] = $fcmMsg;
	}else{
		//if the push don't have an image give null in place of image
		$fcmMsg = array(
			'title' => $title,
			'message' => $message,
			'image' => ''
			//'sound' => "default",
			// 'color' => "#203E78" 
		);
		$newMsg['data'] = $fcmMsg;
	}
	//print_r($fcmMsg);
	$fcmFields = array(
		// 'to' => $singleID,
		'registration_ids' => $registrationIDs,  // expects an array of ids
		'priority' => 'high',
		'data' => $newMsg
	);
	//print_r(json_encode($fcmFields));
	$headers = array(
		'Authorization: key=' . API_ACCESS_KEY,
		'Content-Type: application/json'
	);
	 
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
	$result = json_decode($result,1);
	echo '<label class="label label-success">'.$result['success'].' user(s) Sent Successfully</label><label class="label label-danger">'.$result['failure'].' user(s) Couldn\'t Send</label><br></br>';
}
//12. update_fcm_server_key()
if(isset($_POST['update_fcm_server_key'])){
	$fcm_key = $db->escapeString($_POST['fcm_key']);
	
	$sql = "Update `tbl_fcm_key` set `fcm_key`='".$fcm_key."' where `id`=1";
	// echo $sql;
	// return false;
	//$db->sql($sql);
	$res = $db->getResult(); 
	echo "<p class='alert alert-success'>FCM Key Updated Successfully!</p><br>";
}

?>