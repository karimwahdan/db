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
        <title>Create and Manage Sub Category | <?=ucwords($_SESSION['company_name'])?> - Admin Panel </title>
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
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Create Sub Category</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class='row'>
										<div class='col-md-6 col-sm-12'>
											<form id="category_form" method="POST" action="db_operations.php" class="form-horizontal form-label-left" enctype="multipart/form-data">
												<input type="hidden" id="add_subcategory" name="add_subcategory" required="" value="1" aria-required="true">
												<div class="form-group">
													<?php $db->sql("SET NAMES 'utf8'");
													$sql = "select * from category order by id DESC";
													$db->sql($sql);
													$categories = $db->getResult();
													?>
													<label class="" for="maincat_id">Main Category</label>
													<select id="maincat_id" name="maincat_id" required class="form-control col-md-7 col-xs-12">
														<option value=''>Select Options</option>
														<?php foreach($categories as $category){?>
														<option value='<?=$category['id']?>'><?=$category['category_name']?></option>
														<?php }?>
													</select>
												</div>
												<div class="form-group">
													<label class="" for="name">Sub Category Name</label>
													<input type="text" id="name" name="name" required class="form-control col-md-7 col-xs-12">
												</div>
												<div class="form-group">
													<label class="" for="image">Image</label>
													<input type='file' name="image" id="image" >
												</div>
												<div class="ln_solid"></div>
												<div id="result"></div>
												<div class="form-group">
													<div class="col-md-6 col-sm-6 col-xs-12">
														<button type="submit" id="submit_btn" class="btn btn-warning">Add New</button>
													</div>
												</div>
											</form>
										</div>
										<div class='col-md-6 col-sm-12'>
											<div id="toolbar">
												<select id='export_select' class="form-control" >
													<option value="basic">Export This Page</option>
													<option value="all">Export All</option>
													<option value="selected">Export Selected</option>
												</select>
											</div>
											<table class='table-striped' id='category_list'
												data-toggle="table"
		                                        data-url="get-list.php?table=subcategory"
		                                        data-click-to-select="true"
		                                        data-side-pagination="server"
		                                        data-pagination="true"
		                                        data-page-list="[5, 10, 20, 50, 100, 200]"
		                                        data-search="true" data-show-columns="true"
		                                        data-show-refresh="true" data-trim-on-search="false"
												data-sort-name="row_order" data-sort-order="asc"
												data-mobile-responsive="true"
												data-toolbar="#toolbar" data-show-export="true"
												data-maintain-selected="true"
												data-export-types='["txt","excel"]'
												data-export-options='{
													"fileName": "subcategory-list-<?=date('d-m-y')?>",
													"ignoreColumn": ["state"]	
												}'
												data-query-params="queryParams">
												<thead>
													<tr>
														<th data-field="state" data-checkbox="true"></th>
														<th data-field="id" data-sortable="true">ID</th>
														<th data-field="row_order" data-visible='false' data-sortable="true">Order</th>
														<th data-field="maincat_id" data-sortable="true">Main Category</th>
														<th data-field="subcategory_name" data-sortable="true">Category Name</th>
														<th data-field="image" data-sortable="true">Image</th>
														<th data-field="status" data-sortable="true">Status</th>
														<th data-field="operate" data-sortable="true" data-events="actionEvents">Operate</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
            <div class="modal fade" id='editCategoryModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit Sub Category</h4>
                        </div>
                        <div class="modal-body">
                            <form id="update_form"  method="POST" action ="db_operations.php" data-parsley-validate class="form-horizontal form-label-left">
                                <input type='hidden' name="update_subcategory" id="update_subcategory" value='1'/>
								<input type='hidden' name="subcategory_id" id="subcategory_id" value=''/>
								<input type='hidden' name="image_url" id="image_url" value=''/>
								<label class="" for="update_maincat_id">Main Category</label>
								<select id="update_maincat_id" name="maincat_id" required class="form-control col-md-7 col-xs-12">
									<option value=''>Select Options</option>
									<?php foreach($categories as $category){?>
									<option value='<?=$category['id']?>'><?=$category['category_name']?></option>
									<?php }?>
								</select>
                                <div class="form-group">
									<label>Sub Category Name</label>
									<input type="text" name="name" id="update_name" placeholder="Category Name" class='form-control' required>
								</div>
                                <div class="form-group">
									<label class="" for="image">Image <small>( Leave it blank for no change )</small></label>
									<input type="file" name="image" id="update_image" aria-required="true">
								</div>
								<div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div id="status" class="btn-group" >
                                            <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="0">  Deactive 
                                            </label>
                                            <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="1"> Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
								<input type="hidden" id="id" name="id">
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" id="update_btn" class="btn btn-success">Update</button>
                                    </div>
								</div>
                            </form>
                            <div class="row"><div  class="col-md-offset-3 col-md-8" style ="display:none;" id="update_result"></div></div>
                        </div>
                    </div>
                </div>
            </div>
			<!-- footer content -->
            <?php include 'footer.php';?>
            <!-- /footer content -->
        </div>
        </div>
        <!-- jQuery -->
		
		<script>
            window.actionEvents = {
            	'click .edit-subcategory': function (e, value, row, index) {
            		// alert('You click remove icon, row: ' + JSON.stringify(row));
					var regex = /<img.*?src="(.*?)"/;
					var src = regex.exec(row.image)[1];
					
					$("input[name=status][value=1]").prop('checked', true);
            		if($(row.status).text() == 'Deactive')
						$("input[name=status][value=0]").prop('checked', true);
					
					$('#subcategory_id').val(row.id);
					$('#update_maincat_id').val(row.maincat_id);
					$('#update_name').val(row.subcategory_name);
					$('#image_url').val(src);
            	}
            };
        </script>
		<script>
            $('#update_form').on('submit',function(e){
            	e.preventDefault();
            	var formData = new FormData(this);
            	if($("#update_form").validate().form()){
					$.ajax({
					type:'POST',
					url: $(this).attr('action'),
					data:formData,
					beforeSend:function(){$('#update_btn').html('Please wait..');},
					cache:false,
					contentType: false,
					processData: false,
					success:function(result){
						$('#update_result').html(result);
						$('#update_result').show().delay(4000).fadeOut();
						$('#update_btn').html('Update');
						$('#update_image').val('');
						$('#update_form')[0].reset();
						$('#category_list').bootstrapTable('refresh');
						setTimeout(function() {$('#editCategoryModal').modal('hide');}, 3000);
					}
					});
            	}
            }); 
        </script>
		<script>
		function queryParams(p){
			return {
				limit:p.limit,
				sort:p.sort,
				order:p.order,
				offset:p.offset,
				search:p.search
			};
		}
		</script>
		<script>
            $('#category_form').validate({
            	rules:{
				name:"required",
				maincat_id:"required"
				}
            });
        </script>
		<script>
            $('#category_form').on('submit',function(e){
            	e.preventDefault();
            	var formData = new FormData(this);
            	if( $("#category_form").validate().form() ){
					if(confirm('Are you sure?Want to create Quiz')){
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
						$('#result').show().delay(6000).fadeOut();
						$('#submit_btn').html('Submit');
						$('#category_form')[0].reset();
						$('#category_list').bootstrapTable('refresh');
					}
					});
            	}
            	}
            }); 
        </script>
		<script>
		$(document).on('click','.delete-subcategory',function(){
			if(confirm('Are you sure? Want to delete sub category? All related questions will also be deleted')){
				id = $(this).data("id");
				image = $(this).data("image");
				$.ajax({
					url : 'db_operations.php',
					type: "get",
					data: 'id='+id+'&image='+image+'&delete_subcategory=1',
					success: function(result){
						// alert(result);
						if(result==1){
							$('#category_list').bootstrapTable('refresh');
						}else
							alert('Error! Category could not be deleted');
					}
				});
			}
		});
		</script>
    </body>
</html>