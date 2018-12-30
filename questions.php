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
        <title>Questions for Quiz | <?=ucwords($_SESSION['company_name'])?> - Admin Panel </title>
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
                                    <h2>Questions for Quiz <small>Create New Question</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
										<form id="register_form" method="POST" action="db_operations.php" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="novalidate">
											<h4 class="col-md-offset-1"><b>Create a Question</b></h4>
											<input type="hidden" id="add_question" name="add_question" required="" value="1" aria-required="true">
											<div class="form-group">
												<label class="control-label col-md-1 col-sm-3 col-xs-12" for="category">Category</label>
												<div class="col-md-4 col-sm-6 col-xs-12">
												<?php 
												$db->sql("SET NAMES 'utf8'");
												$sql = "select id,`category_name` from `category` order by id desc";
													$db->sql($sql);
													$res = $db->getResult();
												?>
													<select name='category' id='category' class='form-control' required>
														<option value=''>Select Main Category</option>
														<?php foreach($res as $row){?>
														<option value='<?=$row['id']?>'><?=$row['category_name']?></option>
														<?php }?>
													</select>
												</div>
												<label class="control-label col-md-2 col-sm-3 col-xs-12" for="subcategory">Sub Category</label>
												<div class="col-md-4 col-sm-6 col-xs-12">
													<select name='subcategory' id='subcategory' class='form-control' >
														<option value=''>Select Sub Category</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-1 col-sm-3 col-xs-12" for="question">Question</label>
												<div class="col-md-10 col-sm-6 col-xs-12">
													<!--<input type="text" id="question" name="question" required="required" class="form-control col-md-7 col-xs-12" aria-required="true">-->
													<textarea id="question" name="question" class="form-control col-md-7 col-xs-12" required></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-1 col-sm-3 col-xs-12" for="image">Image for Question <small>( if any )</small></label>
												<div class="col-md-10 col-sm-6 col-xs-12">
													<input type="file" id="image" name="image" class="form-control col-md-7 col-xs-12" aria-required="true">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-1 col-sm-3 col-xs-12" for="a">Options</label>
												<div class="col-md-8 col-sm-6 col-xs-12"></div>
											</div>
											<div class="form-group">
												<label for="a" class="control-label col-md-1 col-sm-3 col-xs-12">A</label>
												<div class="col-md-4 col-sm-6 col-xs-12">
													<input id="a" class="form-control col-md-7 col-xs-12" type="text" name="a">
												</div>
												<label for="b" class="control-label col-md-1 col-sm-3 col-xs-12">B</label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input id="b" class="form-control col-md-7 col-xs-12" type="text" name="b">
												</div>
											</div>
											<div class="form-group">
												<label for="c" class="control-label col-md-1 col-sm-3 col-xs-12">C</label>
												<div class="col-md-4 col-sm-6 col-xs-12">
													<input id="c" class="form-control col-md-7 col-xs-12" type="text" name="c">
												</div>
												<label for="d" class="control-label col-md-1 col-sm-3 col-xs-12">D</label>
												<div class="col-md-5 col-sm-6 col-xs-12">
													<input id="d" class="form-control col-md-7 col-xs-12" type="text" name="d">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-1 col-sm-3 col-xs-12" for="level">Level</label>
												<div class="col-md-10 col-sm-6 col-xs-12">
													<input type='text' name='level' id='level' class='form-control' required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-1 col-sm-3 col-xs-12" for="answer">Answer</label>
												<div class="col-md-10 col-sm-6 col-xs-12">
													<select name='answer' id='answer' class='form-control'>
														<option value=''>Select Right Answer</option>
														<option value='a'>A</option>
														<option value='b'>B</option>
														<option value='c'>C</option>
														<option value='d'>D</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-1 col-sm-3 col-xs-12" for="note">Note</label>
												<div class="col-md-10 col-sm-6 col-xs-12">
													<textarea name='note' id='note' class='form-control'></textarea>
												</div>
											</div>
											
											<div class="ln_solid"></div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-1">
													<button type="submit" id="submit_btn" class="btn btn-success">Create Now</button>
												</div>
											</div>
											<div class="row">
												<div  class="col-md-offset-3 col-md-4" style ="display:none;" id="result">
												</div>
											</div>
										</form>
										<div class="col-md-12"><hr></div>
									</div>
									<div class='row'>
										<div class='col-md-12'>
											<h2>Questions of Quiz <small>View / Update / Delete</small></h2>
										</div>
										<div class='col-md-4'>
											<select id='filter_category' class='form-control' required>
												<option value=''>Select Main Category</option>
												<?php foreach($res as $row){?>
												<option value='<?=$row['id']?>'><?=$row['category_name']?></option>
												<?php }?>
											</select>
										</div>
										<div class='col-md-4'>
											<select id='filter_subcategory' class='form-control' required>
												<option value=''>Select Sub Category</option>
											</select>
										</div>
										<div class='col-md-4'>
											<button class='btn btn-primary btn-block' id='filter_btn'>Filter Questions</button>
										</div>
										<div class='col-md-12'><hr></div>
									</div>
									<div id="toolbar">
										<select id='export_select' class="form-control" >
											<option value="basic">Export This Page</option>
											<option value="all">Export All</option>
											<option value="selected">Export Selected</option>
										</select>
									</div>
									<table class='table-striped' id='questions'
                                        data-toggle="table"
                                        data-url="get-list.php?table=question"
                                        data-click-to-select="true"
                                        data-side-pagination="server"
                                        data-pagination="true"
                                        data-page-list="[5, 10, 20, 50, 100, 200]"
                                        data-search="true" data-show-columns="true"
                                        data-show-refresh="true" data-trim-on-search="false"
										data-sort-name="id" data-sort-order="desc"
										data-mobile-responsive="true"
										data-toolbar="#toolbar" data-show-export="true"
										data-maintain-selected="true"
										data-export-types='["txt","excel"]'
										data-export-options='{
											"fileName": "questions-list-<?=date('d-m-y')?>",
											"ignoreColumn": ["state"]	
										}'
										data-query-params="queryParams_1"
										>
										<thead>
											<tr>
                                                <th data-field="state" data-checkbox="true"></th>
                                                <th data-field="id" data-sortable="true">ID</th>
                                                <th data-field="category" data-sortable="true" data-visible='false'>Category</th>
                                                <th data-field="subcategory" data-sortable="true" data-visible='false'>Sub Category</th>
                                                <th data-field="image" data-sortable="true">Image</th>
                                                <th data-field="question" data-sortable="true">Question</th>
                                                <th data-field="optiona" data-sortable="true">Option A</th>
                                                <th data-field="optionb" data-sortable="true">Option B</th>
                                                <th data-field="optionc" data-sortable="true">Option C</th>
                                                <th data-field="optiond" data-sortable="true">Option D</th>
                                                <th data-field="answer" data-sortable="true">Answer</th>
                                                <th data-field="level" data-sortable="true">Level</th>
                                                <th data-field="note" data-sortable="true">Note</th>
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
            <!-- /page content -->
            <div class="modal fade" id='editQuestionModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit Question Details</h4>
                        </div>
                        <div class="modal-body">
                            <form id="update_form"  method="POST" action ="db_operations.php" data-parsley-validate class="form-horizontal form-label-left">
                                <input type='hidden' name="question_id" id="question_id" value=''/>
                                <input type='hidden' name="update_question" id="update_question" value='1'/>
								<input type='hidden' name="image_url" id="image_url" value=''/>
								<div class="form-group">
									<label class="control-label col-md-1 col-sm-3 col-xs-12" for="category">Category</label>
									<div class="col-md-4 col-sm-6 col-xs-12">
										<select name='category' id='edit_category' class='form-control' required>
											<option value=''>Select Main Category</option>
											<?php foreach($res as $row){?>
											<option value='<?=$row['id']?>'><?=$row['category_name']?></option>
											<?php }?>
										</select>
									</div>
									<label class="control-label col-md-2 col-sm-3 col-xs-12" for="subcategory">Sub Category</label>
									<div class="col-md-4 col-sm-6 col-xs-12">
										<select name="subcategory" id="edit_subcategory" class="form-control" >
											<option value="">Select Sub Category</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-5 col-sm-3 col-xs-12" for="image">Image for Question <small>( Leave it blank for no change )</small></label>
									<div class="col-md-10 col-md-offset-1 col-sm-6 col-xs-12">
										<input type="file" id="edit_image" name="image" class="form-control col-md-7 col-xs-12" aria-required="true">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-1 col-sm-3 col-xs-12" for="question">Question</label>
									<div class="col-md-10 col-sm-6 col-xs-12">
										<input type="text" id="edit_question" name="question" required="required" class="form-control col-md-7 col-xs-12" aria-required="true">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-1 col-sm-3 col-xs-12" for="a">Options</label>
									<div class="col-md-8 col-sm-6 col-xs-12"></div>
								</div>
								<div class="form-group">
									<label for="a" class="control-label col-md-1 col-sm-3 col-xs-12">A</label>
									<div class="col-md-4 col-sm-6 col-xs-12">
										<input id="edit_a" class="form-control col-md-7 col-xs-12" type="text" name="a">
									</div>
									<label for="b" class="control-label col-md-1 col-sm-3 col-xs-12">B</label>
									<div class="col-md-5 col-sm-6 col-xs-12">
										<input id="edit_b" class="form-control col-md-7 col-xs-12" type="text" name="b">
									</div>
								</div>
								<div class="form-group">
									<label for="c" class="control-label col-md-1 col-sm-3 col-xs-12">C</label>
									<div class="col-md-4 col-sm-6 col-xs-12">
										<input id="edit_c" class="form-control col-md-7 col-xs-12" type="text" name="c">
									</div>
									<label for="d" class="control-label col-md-1 col-sm-3 col-xs-12">D</label>
										<div class="col-md-5 col-sm-6 col-xs-12">
										<input id="edit_d" class="form-control col-md-7 col-xs-12" type="text" name="d">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-1 col-sm-3 col-xs-12" for="level">Level</label>
									<div class="col-md-10 col-sm-6 col-xs-12">
										<input type="text" id="edit_level" name="level" required="required" class="form-control col-md-7 col-xs-12" aria-required="true">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-1 col-sm-3 col-xs-12" for="answer">Answer</label>
									<div class="col-md-10 col-sm-6 col-xs-12">
										<select name="answer" id="edit_answer" class="form-control">
											<option value="">Select Right Answer</option>
											<option value="a">A</option>
											<option value="b">B</option>
											<option value="c">C</option>
											<option value="d">D</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-1 col-sm-3 col-xs-12" for="note">Note</label>
									<div class="col-md-10 col-sm-6 col-xs-12">
										<textarea name="note" id="edit_note" class="form-control"></textarea>
									</div>
								</div>
								
								<div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" id="update_btn" class="btn btn-success">Update Question</button>
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
		$('#category').on('change',function(e){
			var category_id = $('#category').val();
			$.ajax({
				type:'POST',
				url: "db_operations.php",
				data:'get_subcategories_of_category=1&category_id='+category_id,
				beforeSend:function(){$('#subcategory').html('Please wait..');},
				success:function(result){
					// alert(result);
					$('#subcategory').html(result);
				}
			});
		});
		</script>
		<script>
		$('#edit_category').on('change',function(e, row_category, row_subcategroy){
			var category_id = $('#edit_category').val();
			$.ajax({
				type:'POST',
				url: "db_operations.php",
				data:'get_subcategories_of_category=1&category_id='+category_id,
				beforeSend:function(){$('#edit_subcategory').html('Please wait..');},
				success:function(result){
					// alert(result);
					$('#edit_subcategory').html(result);
					if(category_id == row_category && row_subcategroy != 0 )
						$('#edit_subcategory').val(row_subcategroy);
				}
			});
		});
		</script>
		<script>
		$('#filter_category').on('change',function(e){
			var category_id = $('#filter_category').val();
			$.ajax({
				type:'POST',
				url: "db_operations.php",
				data:'get_subcategories_of_category=1&category_id='+category_id,
				beforeSend:function(){$('#filter_subcategory').html('<option>Please wait..</option>');},
				success:function(result){
					// alert(result);
					$('#filter_subcategory').html(result);
				}
			});
		});
		</script>
		<script>
		$('#filter_btn').on('click',function(e){
			$('#questions').bootstrapTable('refresh');
		});
		</script>
		
		<script>
            $('#register_form').validate({
            	rules:{
				question:"required",
				category:"required",
				a:"required",
            	b:"required",
            	c:"required",
            	d:"required",
            	level:"required",
            	answer:"required",
				}
            });
        </script>
		<script>
            $('#register_form').on('submit',function(e){
            	e.preventDefault();
            	var formData = new FormData(this);
            	if($("#register_form").validate().form()){
					var category = $('#category').val();
					var subcategory = $('#subcategory').val();
					$.ajax({
						type:'POST',
						url: $(this).attr('action'),
						data:formData,
						beforeSend:function(){$('#submit_btn').html('Please wait..');$('#submit_btn').prop('disabled', true);},
						cache:false,
						contentType: false,
						processData: false,
						success:function(result){
							$('#submit_btn').html('Create Now');
							$('#result').html(result);
							$('#result').show().delay(8000).fadeOut();
							$('#register_form')[0].reset();
							$('#category').val(category);
							$('#subcategory').val(subcategory);
							$('#submit_btn').prop('disabled', false);
							$('#questions').bootstrapTable('refresh');
						}
					});
            	}
            }); 
        </script>
		<script>
			var $table = $('#questions');
			$('#toolbar').find('select').change(function () {
				$table.bootstrapTable('refreshOptions', {
					exportDataType: $(this).val()
				});
			});
		</script>
		<script>
		function queryParams_1(p){
			return {
				"category": $('#filter_category').val(),
				"subcategory": $('#filter_subcategory').val(),
				limit:p.limit,
				sort:p.sort,
				order:p.order,
				offset:p.offset,
				search:p.search
			};
		}
		</script>
		<script>
            window.actionEvents = {
            	'click .edit-question': function (e, value, row, index) {
            		// alert('You click remove icon, row: ' + JSON.stringify(row));
					if(row.image != 'No image'){
						var regex = /<img.*?src="(.*?)"/;
						var src = regex.exec(row.image)[1];
						$('#image_url').val(src);
					}else{
						$('#image_url').val('');
					}
					$('#question_id').val(row.id);
					$('#edit_question').val(row.question);
					$('#edit_category').val(row.category).trigger("change",[row.category,row.subcategory]);
					$('#edit_a').val(row.optiona);
					$('#edit_b').val(row.optionb);
					$('#edit_c').val(row.optionc);
					$('#edit_d').val(row.optiond);
					$('#edit_answer').val(row.answer);
					$('#edit_level').val(row.level);
					$('#edit_note').val(row.note);
					$('#edit_subcategory').val(row.subcategory);
            	}
            };
        </script>
        <script>
            $('#update_form').validate({
            	rules:{
					edit_question:"required",
					update_quiz_id:"required",
					update_a:"required",
					update_b:"required",
					update_c:"required",
					update_d:"required",
					update_answer:"required",
            	}
            });
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
						$('#update_result').show().delay(8000).fadeOut();
						$('#update_btn').html('Update Question');
						$('#edit_image').val('');
						$('#questions').bootstrapTable('refresh');
						setTimeout(function() {$('#editQuestionModal').modal('hide');}, 3000);
					}
					});
            	}
            }); 
        </script>
		<script>
		$(document).on('click','.delete-question',function(){
			if(confirm('Are you sure? Want to delete question')){
				id = $(this).data("id");
				image = $(this).data("image");
				$.ajax({
					url : 'db_operations.php',
					type: "get",
					data: 'id='+id+'&image='+image+'&delete_question=1',
					success: function(result){
						if(result==1){
							$('#questions').bootstrapTable('refresh');
						}else
							alert('Error! Question could not be deleted');
					}
				});
			}
		});
		</script>
    </body>
</html>