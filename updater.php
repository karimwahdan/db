<?php 
session_start();
error_reporting(true);
// sleep(5);
// include "convert-latin1-to-utf8.php";
if(!isset($_SESSION["count"]) && $_SESSION["count"]!="applied"){
include('../library/crud.php');
$db = new Database();
$db->connect();

/* adding columns and altering fields in database table */
$db->sql("ALTER TABLE `subcategory` ADD `status` INT NOT NULL AFTER `image`, ADD `row_order` VARCHAR(4) NOT NULL AFTER `status`");
$db->sql("ALTER TABLE `question` CHANGE `optiona` `optiona` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `optionb` `optionb` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `optionc` `optionc` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `optiond` `optiond` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `answer` `answer` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
$db->sql("ALTER TABLE `question` ADD `image` VARCHAR(256) NOT NULL AFTER `subcategory`");
$db->sql("CREATE TABLE `question_reports` ( `id` int(11) NOT NULL, `question_id` int(11) NOT NULL, `message` varchar(512) NOT NULL, `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1");
$db->sql("ALTER TABLE `category` ADD `row_order` VARCHAR(4) NOT NULL AFTER `image`");
$db->sql("ALTER TABLE `tbl_fcm_key` CHANGE `fcm_key` `fcm_key` VARCHAR(1024) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");

/* converting the database to unicode */
// question - TABLE
$db->sql("ALTER TABLE question MODIFY question TEXT CHARACTER SET utf8, MODIFY optiona VARCHAR(100) CHARACTER SET utf8, MODIFY optionb VARCHAR(100) CHARACTER SET utf8, MODIFY optionc VARCHAR(100) CHARACTER SET utf8, MODIFY optionc VARCHAR(100) CHARACTER SET utf8, MODIFY optiond VARCHAR(100) CHARACTER SET utf8, MODIFY answer VARCHAR(100) CHARACTER SET utf8, MODIFY note VARCHAR(100) CHARACTER SET utf8");

$db->sql("UPDATE question SET question = CONVERT(cast(CONVERT(question USING latin1) AS BINARY) USING utf8),optiona = CONVERT(cast(CONVERT(optiona USING latin1) AS BINARY) USING utf8), optionb = CONVERT(cast(CONVERT(optionb USING latin1) AS BINARY) USING utf8), optionc = CONVERT(cast(CONVERT(optionc USING latin1) AS BINARY) USING utf8), optiond = CONVERT(cast(CONVERT(optiond USING latin1) AS BINARY) USING utf8), answer = CONVERT(cast(CONVERT(answer USING latin1) AS BINARY) USING utf8), level = CONVERT(cast(CONVERT(level USING latin1) AS BINARY) USING utf8), note = CONVERT(cast(CONVERT(note USING latin1) AS BINARY) USING utf8)");

// category - TABLE
$db->sql("ALTER TABLE category MODIFY category_name VARCHAR(256) CHARACTER SET utf8");

$db->sql("UPDATE category SET category_name = CONVERT(cast(CONVERT(category_name USING latin1) AS BINARY) USING utf8)");

// sub-category - TABLE
$db->sql("ALTER TABLE subcategory MODIFY subcategory_name VARCHAR(256) CHARACTER SET utf8");

$db->sql("UPDATE subcategory SET subcategory_name = CONVERT(cast(CONVERT(subcategory_name USING latin1) AS BINARY) USING utf8)");

// question_reports - TABLE
$db->sql("ALTER TABLE question_reports MODIFY message VARCHAR(512) CHARACTER SET utf8");

$db->sql("UPDATE question_reports SET message = CONVERT(cast(CONVERT(message USING latin1) AS BINARY) USING utf8)");

// tbl_privacy_policy - TABLE
$db->sql("ALTER TABLE tbl_privacy_policy MODIFY privacy_policy VARCHAR(1024) CHARACTER SET utf8");

$db->sql("UPDATE tbl_privacy_policy SET privacy_policy = CONVERT(cast(CONVERT(privacy_policy USING latin1) AS BINARY) USING utf8)");

$_SESSION['count'] = "applied";
// echo "Operation done successfully! Do not perform this second time! ";
}else{
	exit("Operation already applied! Cannot perform this second time!");
}

copy('update-files/api.php', '../api.php');
copy('update-files/api-docs.txt', '../api-docs.txt');
copy('update-files/api-v2.php', '../api-v2.php');
copy('update-files/category-order.php', '../category-order.php');
copy('update-files/change_password.php', '../change_password.php');
copy('update-files/check_login.php', '../check_login.php');
copy('update-files/db_operations.php', '../db_operations.php');
copy('update-files/footer.php', '../footer.php');
copy('update-files/get-list.php', '../get-list.php');
copy('update-files/home.php', '../home.php');
copy('update-files/import-questions.php', '../import-questions.php');
copy('update-files/include-css.php', '../include-css.php');
copy('update-files/index.php', '../index.php');
copy('update-files/logout.php', '../logout.php');
copy('update-files/main-category.php', '../main-category.php');
copy('update-files/notification-settings.php', '../notification-settings.php');
copy('update-files/password.php', '../password.php');
copy('update-files/question-reports.php', '../question-reports.php');
copy('update-files/questions.php', '../questions.php');
copy('update-files/RegisterDevice.php', '../RegisterDevice.php');
copy('update-files/send-notifications.php', '../send-notifications.php');
copy('update-files/sidebar.php', '../sidebar.php');
copy('update-files/sub-category.php', '../sub-category.php');

echo "Congratulations! You have successfully upgraded your system!";

?>