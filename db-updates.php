<?php 
/* adding status & row_order fields in subcategory table */
$db->sql("ALTER TABLE `subcategory` ADD `status` INT NOT NULL AFTER `image`, ADD `row_order` VARCHAR(4) NOT NULL AFTER `status`;");
$db-sql("ALTER TABLE `question` CHANGE `optiona` `optiona` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `optionb` `optionb` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `optionc` `optionc` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `optiond` `optiond` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `answer` `answer` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
$db-sql("ALTER TABLE `question` ADD `image` VARCHAR(256) NOT NULL AFTER `subcategory`;");
$db-sql("CREATE TABLE `question_reports` ( `id` int(11) NOT NULL, `question_id` int(11) NOT NULL, `message` varchar(512) NOT NULL, `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
$db-sql("ALTER TABLE `category` ADD `row_order` VARCHAR(4) NOT NULL AFTER `image`;");
$db-sql("ALTER TABLE `tbl_fcm_key` CHANGE `fcm_key` `fcm_key` VARCHAR(1024) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;");
?>