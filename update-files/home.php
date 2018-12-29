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
        <title>Home | <?=ucwords($_SESSION['company_name'])?> </title>
        <?php include 'include-css.php';?>
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
                        <div role="main">
                            <!-- top tiles -->
                            <h1 style="color:black;font-size:29px;text-align:center;">Welcome to <?=ucwords($_SESSION['company_name'])?> - Admin Panel</h1>
                            <hr>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fas fa-user-friends"></i>
                                    </div>
                                    <div class="count"><?=get_count('id','category','');?></div>
                                    <h3>Total Categories</h3>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fas fa-users"></i>
                                    </div>
                                    <div class="count"><?=get_count('id','subcategory');?></div>
                                    <h3>Total Sub Categories</h3>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fas fa-rupee-sign"></i>
                                    </div>
                                    <!--<div class="count"><?php //echo get_count('id','question',' DATE(`date`) = CURDATE()');?></div>-->
                                    <div class="count"><?=get_count('id','question','');?></div>
                                    <h3>Total Questions</h3>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fas fa-recycle"></i>
                                    </div>
                                    <div class="count"><?=get_count('id','tbl_devices','');?></div>
                                    <h3>Registered Devices</h3>
                                </div>
                            </div>
                            <!-- /top tiles -->
                        </div>
                    </div>
                </div>
            </div>
			<!-- /page content -->
            <div class="modal fade" id='editPartyModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit Party Order Details</h4>
                        </div>
                        <div class="modal-body">
                            <form id="register_form"  method="POST" action ="db_operations.php" data-parsley-validate class="form-horizontal form-label-left">
                                <input type='hidden' name="order_id" id="order_id" value=''/>
                                <input type='hidden' name="update_party_order" id="update_party_order" value='1'/>
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobile">Mobile <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="mobile"  name="mobile" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea id="address" class="form-control col-md-7 col-xs-12" name="address" placeholder='#Door no, Street, Area, City'></textarea>
                                    </div>
                                </div>
								<div class="form-group">
									<h5>Filled Bottles</h5>
									<hr>
									<label class="col-md-4 col-xs-12" for="hot">Hot Water Bottles
										<input type="number" id="filled_hot" name="filled_hot" class="form-control " placeholder="number of bottles" min="0">
									</label>
									<label class="col-md-4 col-xs-12" for="cold">Cold Water Bottles
										<input type="number" id="filled_cold" name="filled_cold" class="form-control " placeholder="number of bottles" min="0">
									</label>
									<label class="col-md-4  col-xs-12" for="small">Small Cold Water Bottles
										<input type="number" id="filled_small" name="filled_small" class="form-control " placeholder="number of bottles" min="0">
									</label>
								</div>
								<div class="form-group">
									<h5>Empty Bottles</h5>
									<label class="col-md-4 col-xs-12" for="hot">Hot Water Bottles
										<input type="number" id="empty_hot" name="empty_hot" class="form-control " placeholder="number of bottles" min="0">
									</label>
									<label class="col-md-4 col-xs-12" for="cold">Cold Water Bottles
										<input type="number" id="empty_cold" name="empty_cold" class="form-control " placeholder="number of bottles" min="0">
									</label>
									<label class="col-md-4  col-xs-12" for="small">Small Cold Water Bottles
										<input type="number" id="empty_small" name="empty_small" class="form-control " placeholder="number of bottles" min="0">
									</label>
								</div>
								<hr>
                                <div class="form-group">
									<label for="advance" class="control-label col-md-3 col-sm-3 col-xs-12">Advance Payment</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="advance" class="form-control col-md-7 col-xs-12" type="number" name="advance" placeholder='Advance payment in rupees' min='0'>
									</div>
								</div>
								<div class="form-group">
									<label for="total" class="control-label col-md-3 col-sm-3 col-xs-12">Total Bill</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="total" class="form-control col-md-7 col-xs-12" type="number" name="total" placeholder='Total Bill' min='0'>
									</div>
								</div>
								<div class="form-group">
									<label for="order_delivery" class="control-label col-md-3 col-sm-3 col-xs-12">Order Delivery Date & Time</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="order_delivery" class="form-control col-md-7 col-xs-12" type="text" name="order_delivery" placeholder='Order Delivery Date & Time' >
									</div>
								</div>
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div id="status" class="btn-group" >
                                            <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="0">  Pending 
                                            </label>
                                            <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="1"> Completed
                                            </label>
                                            <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="2"> Closed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="id" name="id">
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" id="submit_btn" class="btn btn-success">Submit</button>
                                    </div>
								</div>
                            </form>
                            <div class="row"><div  class="col-md-offset-3 col-md-8" style ="display:none;" id="result"></div></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'footer.php';?>
        </div>
        <!-- jQuery -->
		<script>
            window.actionEvents = {
            	'click .edit-party-order': function (e, value, row, index) {
            		// alert('You click remove icon, row: ' + JSON.stringify(row));
					var id=row.id;
					$.ajax({
						type:'POST',
						url: 'db_operations.php',
						data:'get_party_order=1&id='+id,
						dataType:'json',
						success:function(result){
							// alert(result.filled_bottles['small']);
							$('#filled_hot').val(result.filled_bottles['hot']);
							$('#filled_cold').val(result.filled_bottles['cold']);
							$('#filled_small').val(result.filled_bottles['small cold']);
							if(result.empty_bottles !=''){
								$('#empty_hot').val(result.empty_bottles['hot']);
								$('#empty_cold').val(result.empty_bottles['cold']);
								$('#empty_small').val(result.empty_bottles['small cold']);
							}else{
								$('#empty_hot').val(0);
								$('#empty_cold').val(0);
								$('#empty_small').val(0);
							}
						}
					});
					$('#order_id').val(row.id);
            		$('#name').val(row.name);
            		$('#mobile').val(row.mobile);
            		$('#address').val(row.address);
            		$('#advance').val(row.advance);
            		$('#total').val(row.total);
            		$('#order_delivery').val(row.order_delivery);
            		(row.status=='Active')?$("input[name=status][value=1]").prop('checked', true):$("input[name=status][value=0]").prop('checked', true);
            	}
            };
        </script>
        <script>
            $('#register_form').validate({
            	rules:{
					name:"required",
					mobile:"required",
					address:"required",
					status:"required",
            	}
            });
        </script>
        <script>
            $('#register_form').on('submit',function(e){
            	e.preventDefault();
            	var formData = new FormData(this);
            	if($("#register_form").validate().form()){
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
						$('#result').show().delay(3000).fadeOut();
						$('#submit_btn').html('Submit');
					}
					});
            	}
            }); 
        </script>
    </body>
</html>	