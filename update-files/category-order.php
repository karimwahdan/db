<?php
    session_start();
    if(!isset($_SESSION['id']) && !isset($_SESSION['username']))
    	header("location:index.php");
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Category Order | <?=ucwords($_SESSION['company_name'])?> Admin Panel</title>
        <?php include 'include-css.php';?>
        <style>
          #sortable-row li { margin-bottom:4px; padding:10px; background-color:#ededed;cursor:move;} 
          #sortable-row li.ui-state-highlight { height: 1.0em; background-color:#F0F0F0;border:#ccc 2px dotted;}
          #sortable-row-2 li { margin-bottom:4px; padding:10px; background-color:#ededed;cursor:move;} 
          #sortable-row-2 li.ui-state-highlight { height: 1.0em; background-color:#F0F0F0;border:#ccc 2px dotted;}
        </style>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php include 'sidebar.php';?>
                <!-- page content -->
                <div class="right_col" role="main">
                    <!-- top tiles -->
                    <br />
                    <div class="row">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Category Order Settings <small>Update Category Order here</small></h2>
                                <div class="clearfix"></div>
							</div>
                            <div class="x_content">
                                <?php $db->sql("SET NAMES 'utf8'");
								$sql = "SELECT * FROM category ORDER BY row_order ASC";
								$db->sql($sql);
								$res = $db->getResult();
								?>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <h2>Main Category</h2><hr>
    								<form id="category_form"  method="POST" action="db_operations.php"data-parsley-validate class="form-horizontal form-label-left">
    								<input type="hidden" id="update_category" name="update_category" required value='1'/>
    								<div class="form-group" style="overflow-y:scroll;height:400px;">
                                        <input type = "hidden" name="row_order" id="row_order" required readonly/> 
                                        <ol id="sortable-row">
                                        <?php foreach($res as $category){ ?>
                                        <li id=<?php echo $category["id"]; ?>>
                                            <?php if(!empty($category["image"])){
                                                echo "<big>".$category["row_order"].".</big> &nbsp;<img src='category/$category[image]' height=30 > ".$category["category_name"];
                                            }else{ 
                                                echo "<big>".$category["row_order"].".</big> &nbsp;<img src='images/logo.png' height=30 > ".$category["category_name"];
                                            } ?>
                                        </li>
                                        <?php } ?>
                                        </ol>
                                    </div>
    									<div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <button type="submit" id="submit_btn" class="btn btn-success">Save Order</button>
                                            </div>
    									</div>
                                        <div class="row">
                                            <div style ="display:none;" id="result">
                                        </div>
                                </div>
                                    </form>
                                </div>

                                <?php $db->sql("SET NAMES 'utf8'");
                                $sql = "SELECT * FROM subcategory ORDER BY row_order ASC";
                                $db->sql($sql);
                                $res = $db->getResult();
                                ?>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <h2>Sub Category</h2><hr>
                                    <form id="subcategory_form"  method="POST" action="db_operations.php"data-parsley-validate class="form-horizontal form-label-left">
                                    <input type="hidden" id="update_subcategory" name="update_subcategory" required value='1'/>
                                    <div class="form-group" style="overflow-y:scroll;height:400px;">
                                        <input type = "hidden" name="row_order_2" id="row_order_2" required readonly/> 
                                        <ol id="sortable-row-2">
                                        <?php foreach($res as $category){ ?>
                                        <li id=<?php echo $category["id"]; ?>>
                                            <?php if(!empty($category["image"])){
                                                echo "<big>".$category["row_order"].".</big> &nbsp;<img src='subcategory/$category[image]' height=30 > ".$category["subcategory_name"];
                                            }else{
                                                echo "<big>".$category["row_order"].".</big> &nbsp;<img src='images/logo.png' height=30 > ".$category["subcategory_name"];
                                            } ?>
                                        </li>
                                        <?php } ?>
                                        </ol>
                                    </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <button type="submit" id="submit_btn_2" class="btn btn-success">Save Order</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div style ="display:none;" id="result_2"></div>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->
                <!-- footer content -->
                <?php include 'footer.php';?>
                <!-- /footer content -->
            </div>
        </div>
        <!-- jQuery -->
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script>
          $(function() {
            $( "#sortable-row" ).sortable({
            placeholder: "ui-state-highlight"
            });
            $( "#sortable-row-2" ).sortable({
            placeholder: "ui-state-highlight"
            });
          });
          $('#category_form').on('submit',function(e){
            	e.preventDefault();
                var selectedLanguage = new Array();
                $('ol#sortable-row li').each(function() {
                selectedLanguage.push($(this).attr("id"));
                });
                $("#row_order").val(selectedLanguage);
            	var formData = new FormData(this);
            	if($("#category_form").validate().form()){
    				$.ajax({
    					type:'POST',
    					url: $(this).attr('action'),
    					data:formData,
    					beforeSend:function(){$('#submit_btn').html('Please wait..');},
    					cache:false,
    					contentType: false,
    					processData: false,
    					success:function(result){
    						$('#result').html(result);
    						$('#result').show().delay(5000).fadeOut();
    						$('#submit_btn').html('Save Order');
    					}
    				});
            	}
            });
          $('#subcategory_form').on('submit',function(e){
                e.preventDefault();
                var selectedLanguage = new Array();
                $('ol#sortable-row-2 li').each(function() {
                selectedLanguage.push($(this).attr("id"));
                });
                $("#row_order_2").val(selectedLanguage);
                var formData = new FormData(this);
                if($("#subcategory_form").validate().form()){
                    $.ajax({
                        type:'POST',
                        url: $(this).attr('action'),
                        data:formData,
                        beforeSend:function(){$('#submit_btn_2').html('Please wait..');},
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(result){
                            $('#result_2').html(result);
                            $('#result_2').show().delay(5000).fadeOut();
                            $('#submit_btn_2').html('Save Order');
                        }
                    });
                }
            });
        </script>
    </body>
</html>