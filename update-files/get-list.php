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

/*
	1. category
	2. subcategory
	3. question
	
	1. users
	2. tracker
	3. payment_requests
*/


if(isset($_GET['table']) && $_GET['table'] == 'category'){
	$offset = 0;$limit = 10;
	$sort = 'row_order'; $order = 'ASC';
	$where = '';
	$table = $_GET['table'];
	
	if(isset($_POST['id']))
		$id = $_POST['id'];
	if(isset($_GET['offset']))
		$offset = $_GET['offset'];
	if(isset($_GET['limit']))
		$limit = $_GET['limit'];
	if(isset($_GET['order']))
		$order = $_GET['order'];
	if(isset($_GET['search'])){
		$search = $_GET['search'];
		$where = " where (`id` like '%".$search."%' OR `category_name` like '%".$search."%' )";
	}
	
	$sql = "SELECT COUNT(*) as total FROM `category` ".$where;
	$db->sql($sql);
	$res = $db->getResult();
	foreach($res as $row){
		$total = $row['total'];
	}
	
	$sql = "SELECT * FROM `category` ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit;
	$db->sql($sql);
	$res = $db->getResult();
	
	$bulkData = array();
	$bulkData['total'] = $total;
	$rows = array();
	$tempRow = array();
	
	foreach($res as $row){
		$image = (!empty($row['image']))?'category/'.$row['image']:'';
		$operate = "<a class='btn btn-xs btn-primary edit-category' data-id='".$row['id']."' data-toggle='modal' data-target='#editCategoryModal' title='Edit'><i class='fas fa-edit'></i></a>";
		$operate .= "<a class='btn btn-xs btn-danger delete-category' data-id='".$row['id']."' data-image='".$image."' title='Delete'><i class='fas fa-trash'></i></a>";
		
		$tempRow['id'] = $row['id'];
		$tempRow['category_name'] = $row['category_name'];
		$tempRow['row_order'] = $row['row_order'];
		$tempRow['image'] = (!empty($row['image']))?'<img src="category/'.$row['image'].'" height=30 >':'<img src="images/logo.png" height=30>';
		$tempRow['operate'] = $operate;
		$rows[] = $tempRow;
	}
	
	$bulkData['rows'] = $rows;
	print_r(json_encode($bulkData));
}

if(isset($_GET['table']) && $_GET['table'] == 'subcategory'){
	$offset = 0;$limit = 10;
	$sort = 'row_order'; $order = 'ASC';
	$where = '';
	$table = $_GET['table'];
	
	if(isset($_POST['id']))
		$id = $_POST['id'];
	if(isset($_GET['offset']))
		$offset = $_GET['offset'];
	if(isset($_GET['limit']))
		$limit = $_GET['limit'];
	if(isset($_GET['order']))
		$order = $_GET['order'];
	if(isset($_GET['search'])){
		$search = $_GET['search'];
		$where = " where (`id` like '%".$search."%' OR `maincat_id` like '%".$search."%' OR `subcategory_name` like '%".$search."%' )";
	}
	
	$sql = "SELECT COUNT(*) as total FROM `subcategory` ".$where;
	$db->sql($sql);
	$res = $db->getResult();
	foreach($res as $row){
		$total = $row['total'];
	}
	
	$sql = "SELECT * FROM `subcategory` ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit;
	$db->sql($sql);
	$res = $db->getResult();
	
	$bulkData = array();
	$bulkData['total'] = $total;
	$rows = array();
	$tempRow = array();
	
	foreach($res as $row){
		$image = (!empty($row['image']))?'subcategory/'.$row['image']:'';
		$operate = "<a class='btn btn-xs btn-primary edit-subcategory' data-id='".$row['id']."' data-toggle='modal' data-target='#editCategoryModal' title='Edit'><i class='fas fa-edit'></i></a>";
		$operate .= "<a class='btn btn-xs btn-danger delete-subcategory' data-id='".$row['id']."' data-image='".$image."' title='Delete'><i class='fas fa-trash'></i></a>";
		
		$tempRow['id'] = $row['id'];
		$tempRow['maincat_id'] = $row['maincat_id'];
		$tempRow['subcategory_name'] = $row['subcategory_name'];
		$tempRow['row_order'] = $row['row_order'];
		$tempRow['image'] = (!empty($row['image']))?'<img src="subcategory/'.$row['image'].'" height=30 >':'<img src="images/logo.png" height=30>';
		$tempRow['status'] = ($row['status'])?'<label class="label label-success">Active</label>':'<label class="label label-danger">Deactive</label>';
		$tempRow['operate'] = $operate;
		$rows[] = $tempRow;
	}
	
	$bulkData['rows'] = $rows;
	print_r(json_encode($bulkData));
}



if(isset($_GET['table']) && $_GET['table'] == 'users'){
	$offset = 0;$limit = 10;
	$sort = 'id'; $order = 'DESC';
	$where = '';
	$table = $_GET['table'];
	
	if(isset($_POST['id']))
		$id = $_POST['id'];
	if(isset($_GET['offset']))
		$offset = $_GET['offset'];
	if(isset($_GET['limit']))
		$limit = $_GET['limit'];
	
	if(isset($_GET['sort']))
		$sort = $_GET['sort'];
	if(isset($_GET['order']))
		$order = $_GET['order'];
	
	if(isset($_GET['status'])){
		$status = $_GET['status'];
		if($_GET['status']!= '')
			$where = "where (`status` = ".$status.")";
	}
	
	if(isset($_GET['search'])){
		$search = $_GET['search'];
		if($_GET['status']!= '')
			$where .= " AND (`id` like '%".$search."%' OR `name` like '%".$search."%' OR `username` like '%".$search."%' OR `email` like '%".$search."%' OR `refer` like '%".$search."%' OR `ip_address` like '%".$search."%' OR `date_registered` like '%".$search."%' )";
		else
			$where = " where (`id` like '%".$search."%' OR `name` like '%".$search."%' OR `username` like '%".$search."%' OR `email` like '%".$search."%' OR `refer` like '%".$search."%' OR `ip_address` like '%".$search."%' OR `date_registered` like '%".$search."%' )";
	}
	
	$sql = "SELECT COUNT(*) as total FROM `users` ".$where;
	$db->sql($sql);
	$res = $db->getResult();
	foreach($res as $row){
		$total = $row['total'];
	}
	
	$sql = "SELECT * FROM `users` ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit;
	$db->sql($sql);
	$res = $db->getResult();
	
	$bulkData = array();
	$bulkData['total'] = $total;
	$rows = array();
	$tempRow = array();
	$icon = array('email' => 'far fa-envelope-open', 'gmail' => 'fab fa-google-plus-square text-danger', 'fb' => 'fab fa-facebook-square text-primary');
	
	foreach($res as $row){
		$operate = "<a class='btn btn-xs btn-primary edit-users' data-id='".$row['id']."' data-toggle='modal' data-target='#editUserModal' title='Edit'><i class='far fa-edit'></i></a>";
		$operate .= "<a class='btn btn-xs btn-success' href='activity-tracker.php?username=".$row['username']."' target='_blank' title='Track Activities'><i class='far fa-chart-bar'></i></a>";
		$operate .= "<a class='btn btn-xs btn-danger' href='payment-requests.php?username=".$row['username']."' target='_blank' title='Payment Requests'><i class='fas fa-rupee-sign'></i></a>";
		
		$tempRow['id'] = $row['id'];
		$tempRow['name'] = $row['name'];
		$tempRow['username'] = $row['username'];
		$tempRow['email'] = $row['email'];
		$tempRow['type'] = '<i class="'.$icon[$row['type']].' fa-2x"></i>';
		$tempRow['fcm_id'] = $row['fcm_id'];
		$tempRow['points'] = $row['points'];
		$tempRow['refer'] = $row['refer'];
		$tempRow['ip_address'] = $row['ip_address'];
		$tempRow['date_registered'] = $row['date_registered'];
		$tempRow['status'] = ($row['status'])?"<label class='label label-danger'>Deactive</label>":"<label class='label label-success'>Active</label>";
		$tempRow['operate'] = $operate;
		$rows[] = $tempRow;
	}
	
	$bulkData['rows'] = $rows;
	print_r(json_encode($bulkData));
}

if(isset($_GET['table']) && $_GET['table'] == 'tracker'){
	$offset = 0;$limit = 10;
	$sort = 'id'; $order = 'DESC';
	$where = '';
	$table = $_GET['table'];
	
	if(isset($_POST['id']))
		$id = $_POST['id'];
	if(isset($_GET['offset']))
		$offset = $_GET['offset'];
	if(isset($_GET['limit']))
		$limit = $_GET['limit'];
	
	if(isset($_GET['sort']))
		$sort = $_GET['sort'];
	if(isset($_GET['order']))
		$order = $_GET['order'];
	
	if(isset($_GET['username'])){
		$username = $_GET['username'];
		if($_GET['username']!= '')
			$where = "where (`username` = '".$username."')";
	}
	
	if(isset($_GET['search'])){
		$search = $_GET['search'];
		if($_GET['username']!= '')
			$where .= " AND (`id` like '%".$search."%' OR `username` like '%".$search."%' OR `points` like '%".$search."%' OR `type` like '%".$search."%' OR `date` like '%".$search."%' )";
		else
			$where = " where (`id` like '%".$search."%' OR `username` like '%".$search."%' OR `points` like '%".$search."%' OR `type` like '%".$search."%' OR `date` like '%".$search."%' )";
	}
	
	$sql = "SELECT COUNT(*) as total FROM `tracker` ".$where;
	$db->sql($sql);
	$res = $db->getResult();
	foreach($res as $row){
		$total = $row['total'];
	}
	
	$sql = "SELECT * FROM `tracker` ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit;
	$db->sql($sql);
	$res = $db->getResult();
	
	$bulkData = array();
	$bulkData['total'] = $total;
	$rows = array();
	$tempRow = array();
	
	foreach($res as $row){
		$tempRow['id'] = $row['id'];
		$tempRow['username'] = $row['username'];
		$tempRow['points'] = $row['points'];
		$tempRow['type'] = $row['type'];
		$tempRow['date'] = $row['date'];
		$rows[] = $tempRow;
	}
	
	$bulkData['rows'] = $rows;
	print_r(json_encode($bulkData));
}

if(isset($_GET['table']) && $_GET['table'] == 'payment_requests'){
	$offset = 0;$limit = 10;
	$sort = 'id'; $order = 'DESC';
	$where = '';
	$table = $_GET['table'];
	
	if(isset($_POST['id']))
		$id = $_POST['id'];
	if(isset($_GET['offset']))
		$offset = $_GET['offset'];
	if(isset($_GET['limit']))
		$limit = $_GET['limit'];
	
	if(isset($_GET['sort']))
		$sort = $_GET['sort'];
	if(isset($_GET['order']))
		$order = $_GET['order'];
	
	if(isset($_GET['username'])){
		$username = $_GET['username'];
		if($_GET['username']!= '')
			$where = "where (`username` = '".$username."')";
	}
	
	if(isset($_GET['search'])){
		$search = $_GET['search'];
		if($_GET['username']!= '')
			$where .= " AND (`id` like '%".$search."%' OR `username` like '%".$search."%' OR `payment_address` like '%".$search."%' OR `request_type` like '%".$search."%' OR `request_amount` like '%".$search."%' OR `points_used` like '%".$search."%' OR `date` like '%".$search."%' )";
		else
			$where = " where (`id` like '%".$search."%' OR `username` like '%".$search."%' OR `payment_address` like '%".$search."%' OR `request_type` like '%".$search."%' OR `request_amount` like '%".$search."%' OR `points_used` like '%".$search."%' OR `date` like '%".$search."%' )";
	}
	
	$sql = "SELECT COUNT(*) as total FROM `payment_requests` ".$where;
	$db->sql($sql);
	$res = $db->getResult();
	foreach($res as $row){
		$total = $row['total'];
	}
	
	$sql = "SELECT * FROM `payment_requests` ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit;
	$db->sql($sql);
	$res = $db->getResult();
	
	$bulkData = array();
	$bulkData['total'] = $total;
	$rows = array();
	$tempRow = array();
	
	foreach($res as $row){
		$operate = "<a class='btn btn-xs btn-primary edit-status' data-id='".$row['id']."' data-toggle='modal' data-target='#editStatusModal' title='Edit'><i class='far fa-edit'></i></a>";
		
		$tempRow['id'] = $row['id'];
		$tempRow['username'] = $row['username'];
		$tempRow['payment_address'] = $row['payment_address'];
		$tempRow['request_type'] = $row['request_type'];
		$tempRow['request_amount'] = $row['request_amount'];
		$tempRow['points_used'] = $row['points_used'];
		$tempRow['remarks'] = $row['remarks'];
		$tempRow['status'] = ($row['status'])?"<label class='label label-success'>Completed</label>":"<label class='label label-warning'>Pending</label>";
		$tempRow['date'] = $row['date'];
		$tempRow['operate'] = $operate;
		$rows[] = $tempRow;
	}
	
	$bulkData['rows'] = $rows;
	print_r(json_encode($bulkData));
}
if(isset($_GET['table']) && $_GET['table'] == 'question'){
	$offset = 0;$limit = 10;
	$sort = 'id'; $order = 'DESC';
	$where = '';
	$table = $_GET['table'];
	
	if(isset($_POST['id']))
		$id = $_POST['id'];
	if(isset($_GET['offset']))
		$offset = $_GET['offset'];
	if(isset($_GET['limit']))
		$limit = $_GET['limit'];
	
	if(isset($_GET['sort']))
		$sort = $_GET['sort'];
	if(isset($_GET['order']))
		$order = $_GET['order'];
	
	if(isset($_GET['category']) && !empty($_GET['category'])){
		$where = 'where `category` = '.$_GET['category'];
		if(isset($_GET['subcategory']) && !empty($_GET['subcategory'])){
			$where .= ' and `subcategory`='.$_GET['subcategory'];
		}
	}
	
	if(isset($_GET['search'])){
		$search = $_GET['search'];
		$where = " where (`id` like '%".$search."%' OR `question` like '%".$search."%' OR `optiona` like '%".$search."%' OR `optionb` like '%".$search."%' OR `optionc` like '%".$search."%' OR `optiond` like '%".$search."%' OR `answer` like '%".$search."%' )";
		if(isset($_GET['category']) && !empty($_GET['category'])){
			$where .= ' and `category` = '.$_GET['category'];
			if(isset($_GET['subcategory']) && !empty($_GET['subcategory'])){
				$where .= ' and `subcategory`='.$_GET['subcategory'];
			}
		}
	}
	
	$sql = "SELECT COUNT(*) as total FROM `question` ".$where;
	$db->sql($sql);
	$res = $db->getResult();
	foreach($res as $row){
		$total = $row['total'];
	}
	
	$sql = "SELECT * FROM `question` ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit;
	// echo $sql;
	$db->sql($sql);
	$res = $db->getResult();
	
	$bulkData = array();
	$bulkData['total'] = $total;
	$rows = array();
	$tempRow = array();
	
	foreach($res as $row){
		$image = (!empty($row['image']))?'images/questions/'.$row['image']:'';
		$operate = "<a class='btn btn-xs btn-primary edit-question' data-id='".$row['id']."' data-toggle='modal' data-target='#editQuestionModal' title='Edit'><i class='fas fa-edit'></i></a>";
		$operate .= "<a class='btn btn-xs btn-danger delete-question' data-id='".$row['id']."' data-image='".$image."' title='Delete'><i class='fas fa-trash'></i></a>";
		
		$tempRow['id'] = $row['id'];
		$tempRow['category'] = $row['category'];
		$tempRow['subcategory'] = $row['subcategory'];
		$tempRow['image'] = (!empty($row['image']))?'<a data-fancybox="Question-Image" href="images/questions/'.$row['image'].'" data-caption="'.$row['question'].'"><img src="images/questions/'.$row['image'].'" height=30 ></a>':'No image';
		$tempRow['question'] = $row['question'];
		$tempRow['optiona'] = $row['optiona'];
		$tempRow['optionb'] = $row['optionb'];
		$tempRow['optionc'] = $row['optionc'];
		$tempRow['optiond'] = $row['optiond'];
		$tempRow['answer'] = $row['answer'];
		$tempRow['level'] = $row['level'];
		$tempRow['note'] = $row['note'];
		$tempRow['operate'] = $operate;
		$rows[] = $tempRow;
	}
	
	$bulkData['rows'] = $rows;
	print_r(json_encode($bulkData));
}

if(isset($_GET['table']) && $_GET['table'] == 'question_reports'){
	$offset = 0;$limit = 10;
	$sort = 'id'; $order = 'DESC';
	$where = '';
	$table = $_GET['table'];
	
	if(isset($_POST['id']))
		$id = $_POST['id'];
	if(isset($_GET['offset']))
		$offset = $_GET['offset'];
	if(isset($_GET['limit']))
		$limit = $_GET['limit'];
	
	if(isset($_GET['sort']))
		$sort = $_GET['sort'];
	if(isset($_GET['order']))
		$order = $_GET['order'];
	
	if(isset($_GET['search'])){
		$search = $_GET['search'];
		$where = " where (`id` like '%".$search."%' OR `username` like '%".$search."%' OR `payment_address` like '%".$search."%' OR `request_type` like '%".$search."%' OR `request_amount` like '%".$search."%' OR `points_used` like '%".$search."%' OR `date` like '%".$search."%' )";
	}
	
	$sql = "SELECT COUNT(*) as total FROM `question_reports` ".$where;
	$db->sql($sql);
	$res = $db->getResult();
	foreach($res as $row){
		$total = $row['total'];
	}
	
	$sql = "SELECT * FROM `question_reports` ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit;
	$db->sql($sql);
	$res = $db->getResult();
	
	$bulkData = array();
	$bulkData['total'] = $total;
	$rows = array();
	$tempRow = array();
	
	foreach($res as $row){
		$operate = "<a class='btn btn-xs btn-danger delete-report' data-id='".$row['id']."' title='Delete'><i class='fas fa-trash'></i></a>";
		
		$tempRow['id'] = $row['id'];
		$tempRow['question_id'] = $row['question_id'];
		$tempRow['message'] = $row['message'];
		$tempRow['date'] = $row['date'];
		$tempRow['operate'] = $operate;
		$rows[] = $tempRow;
	}
	
	$bulkData['rows'] = $rows;
	print_r(json_encode($bulkData));
}
?>