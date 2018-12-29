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
        <title>Question Reports by users | <?=ucwords($_SESSION['company_name'])?> - Admin Panel </title>
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
                                    <h2>Questions Reported by Users</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class='row'>
										<div class='col-md-12'>
											<table class='table-striped' id='report_list'
												data-toggle="table"
												data-url="get-list.php?table=question_reports"
												data-click-to-select="true"
												data-side-pagination="server"
												data-pagination="true"
												data-page-list="[5, 10, 20, 50, 100, 200]"
												data-search="true" data-show-columns="true"
												data-show-refresh="true" data-trim-on-search="false"
												data-sort-name="id" data-sort-order="desc"
												data-mobile-responsive="true"
												data-toolbar="#toolbar" 
												data-maintain-selected="true"
												data-show-export="false" data-export-types='["txt","excel"]'
												data-export-options='{
													"fileName": "users-list-<?=date('d-m-y')?>",
													"ignoreColumn": ["state"]	
												}'
												data-query-params="queryParams_1"
												>
												<thead>
													<tr>
														<th data-field="state" data-checkbox="true"></th>
														<th data-field="id" data-sortable="true">ID</th>
														<th data-field="question_id" data-sortable="true">Question ID</th>
														<th data-field="message" data-sortable="true">Message</th>
														<th data-field="date" data-sortable="true">Date</th>
														<th data-field="operate" data-sortable="true">Operate</th>
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
            <!-- footer content -->
            <?php include 'footer.php';?>
            <!-- /footer content -->
        </div>
        </div>
        <!-- jQuery -->
		<script>
		$(document).on('click','.delete-report',function(){
			if(confirm('Are you sure? Want to delete report')){
				id = $(this).data("id");
				$.ajax({
					url : 'db_operations.php',
					type: "get",
					data: 'id='+id+'&delete_question_report=1',
					success: function(result){
						if(result==1){
							$('#report_list').bootstrapTable('refresh');
						}else
							alert('Error! Question could not be deleted');
					}
				});
			}
		});
		</script>
	</body>
</html>