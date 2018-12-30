<?php

$file_path = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/';
include('library/crud.php');
	$db = new Database();
	$db->connect();
	$db->sql("SET NAMES 'utf8'");
if ($_GET) {
    
	$response = array();
   if (isset($_GET['cate_list'])) {
       
        $sql = "select * from `category` order by id ASC";
		$db->sql($sql);
		$catedata = $db->getResult();
		
        $cate = array();
        if (is_array($catedata)) {
            foreach ($catedata as $row) {
                // print_r($row);
				$cdata['id'] = $row['id'];
                $cdata['cate'] = $row['category_name'];
                $cdata['image'] = $file_path . 'category/' . $row['image'];
         
                $sql = "SELECT *,(select max(level) from question qs where qs.subcategory=subcategory.id ) as maxlevel FROM `subcategory` where maincat_id=".$row['id']." ORDER BY `subcategory`.`maincat_id` ASC";
				$db->sql($sql);
				$subdata = $db->getResult();
				
				$subcate = array();
                if (is_array($subdata)) {
                    foreach ($subdata as $srow) {
                        // print_r($srow);
						$sdata['id'] = $srow['id'];
                        $sdata['cat_id'] = $srow['maincat_id'];
                        $sdata['subcate_name'] = $srow['subcategory_name'];
                        $sdata['image'] = $file_path . 'subcategory/' . $srow['image'];
                      
                        if ($srow['maxlevel'] == '') {
                            $sdata['maxlevel'] = '';
                        } else {
                            $sdata['maxlevel'] = $srow['maxlevel'];
                        }

                        $sql = "SELECT * FROM `question` where subcategory=".$srow['id']." ORDER by RAND()";
						$db->sql($sql);
						$quedata = $db->getResult();
						
						$qdata = array();
                        if (is_array($quedata)) {
                            foreach ($quedata as $qrow) {
                                // print_r($qrow);
								$qudata['id'] = $qrow['id'];
                                $qudata['cat_id'] = $qrow['category'];
                                $qudata['subcat_id'] = $qrow['subcategory'];
                                $qudata['question'] = $qrow['question'];
                                $qudata['option_a'] = $qrow['optiona'];
                                $qudata['option_b'] = $qrow['optionb'];
                                $qudata['option_c'] = $qrow['optionc'];
                                $qudata['option_d'] = $qrow['optiond'];
                                $qudata['answer'] = $qrow['answer'];
                                $qudata['level'] = $qrow['level'];
                            
                                $qudata['note'] = $qrow['note'];
                                array_push($qdata, $qudata);
                            }
                        }
                            $sdata['question'] = $qdata;                        
                            array_push($subcate, $sdata);
                       
                    }
                }
                $cdata['subcate'] = $subcate;               
                array_push($cate, $cdata);
            }
        }
        $response = $cate;
        echo json_encode(array('data' => $response));
    } elseif (isset($_GET['category'])) {
        $sql = "select * from category order by id desc";
		$db->sql($sql);
		$data = $db->getResult();
		
        foreach ($data as $row) {
            // print_r($row);
			$dataa['id'] = $row['id'];
            $dataa['cate'] = $row['category_name'];
            $dataa['image'] = $file_path . 'category/' . $row['image'];
            $dataa['lang_id'] = null;
            array_push($response, $dataa);
        }
        echo json_encode(array('data' => $response));
    } elseif (isset($_GET['maincate_id'])) {
        $sql = "select *,(select max(level) from question qs where qs.subcategory=subcategory.id ) as maxlevel from subcategory where `maincat_id`=".$_GET['maincate_id']." order by id desc";
		$db->sql($sql);
		$data = $db->getResult();
		$tempData = array();
		foreach($data as $row){
			$temp = array($row['id'],$row['maincat_id'],$row['subcategory_name'],$row['image'],$row['maxlevel']);
			$tempData[] = $temp;
			unset($temp);
		}
		$response = array("status" => TRUE, "data" => $tempData, "msg" => "data fetch successfully");
        echo json_encode($response);
    } elseif (isset($_GET['subcate_id']) && isset($_GET['limit'])) {
        $sql = "select * from question where subcategory=".$_GET['subcate_id']." ORDER BY RAND()";
		$db->sql($sql);
		$data = $db->getResult();
		foreach($data as $row){
			$temp = array($row['id'],$row['category'],$row['subcategory'],$row['question'],$row['optiona'],$row['optionb'],$row['optionc'],$row['optiond'],$row['answer'],$row['level'],$row['note']);
			$tempData[] = $temp;
			unset($temp);
		}
		
		// $data = $dba->getRow("question", array("*"), "subcategory=" . $_GET['subcate_id'] . " and level=" . $_GET['level'] . " ORDER BY RAND() limit " . $_GET['limit']);
        $response = array("status" => TRUE, "data" => $tempData, "msg" => "data fetch successfully");
        echo json_encode($response);
    } else {
		echo json_encode($response);
    }
}

if (!function_exists("array_column")) {

    function array_column(array $input, $columnKey, $indexKey = null) {

        $array = array();

        foreach ($input as $value) {

            if (!isset($value[$columnKey])) {

                trigger_error("Key \"$columnKey\" does not exist in array");

                return false;
            }

            if (is_null($indexKey)) {

                $array[] = $value[$columnKey];
            } else {

                if (!isset($value[$indexKey])) {

                    trigger_error("Key \"$indexKey\" does not exist in array");

                    return false;
                }

                if (!is_scalar($value[$indexKey])) {

                    trigger_error("Key \"$indexKey\" does not contain scalar value");

                    return false;
                }

                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }

        return $array;
    }

}
?>