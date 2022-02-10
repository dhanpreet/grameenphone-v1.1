<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>GSL | Tournaments</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?php echo base_url() ?>assets/admin/images/favicon.ico">

	<!-- plugins -->
	
	<link href="<?php echo base_url() ?>assets/admin/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/admin/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/admin/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/admin/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 

	<!-- App css -->
	<link href="<?php echo base_url() ?>assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/admin/css/icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/admin/css/app.min.css" rel="stylesheet" type="text/css" />
	<style>
		.form-control{
			border : 1px solid #b3b8d6 !important;
		}
	</style>
</head>

    <body>
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
			 <?php include ('topbar.php'); ?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
			 <?php include ('left_sidebar.php'); ?>
           <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                  <!-- Start Content-->
                    <div class="container-fluid">
                        <div class="row page-title">
                            <div class="col-md-12">
                                <nav aria-label="breadcrumb" class="float-right mt-1">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#">Tournaments</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Manage Tournament</li>
                                    </ol>
                                </nav>
                                <h4 class="mb-1 mt-0">Manage Tournament</h4>
                            </div>
                        </div>
						
						<div class="row">
                           <div class="col-lg-12">
								<?php if(@$this->session->flashdata('error')) { ?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<?php echo $this->session->flashdata('error'); ?>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
									</div>
								<?php } ?>
								<?php if(@$this->session->flashdata('success')) { ?>
									<div class="alert alert-success alert-dismissible fade show" role="alert">
										<?php echo $this->session->flashdata('success'); ?>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
									</div>
								<?php } ?>
							</div>
						</div> 
						
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                       <div class="row">
											<div class="col-6">
												<h4 class="header-title mt-0 mb-1">All Tournament</h4>
											</div>
											<div class="col-6 text-right">
												<a href="<?php echo site_url('Admin/NewTournament') ?>" class="btn btn-primary btn-rounded" >Create Tournament</a>
												<!-- <a href="javascript(0);" data-toggle="modal" data-target="#uploadBulk" class="btn btn-secondary btn-rounded" >Upload Bulk</a>
												-->
												<!-- <a class="btn btn-primary btn-rounded" href="<?php echo site_url('Admin/trucateData') ?>">Truncate all assignements </a>
												-->
											</div>  
										</div>
                                        
										<p class="sub-header">
                                            &nbsp; <br>
                                        </p>
										
										

                                         <table id="myDataTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tournament</th>
                                                    <th>Game Name</th>
                                                    <th>Starts On</th>
                                                    <th>Ends On</th>
                                                    <th>Type</th>
                                                    <th class="text-center">Status?</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
											<?php if(is_array($list) && count($list)>0){ $i=1;  ?>
											<?php foreach($list as $row){  ?>
                                                <tr>
                                                    <td><?php echo $i; $i++; ?></td>
                                                    <td><?php echo stripslashes(urldecode($row['tournament_name'])); ?></td>
                                                    <td><?php echo $row['tournament_game_name'] ?></td>
                                                    <td><?php echo date('d/M/Y', strtotime($row['tournament_start_date'])); ?> <?php echo date('h:i A', strtotime($row['tournament_start_time'])); ?></td>
                                                    <td><?php echo date('d/M/Y', strtotime($row['tournament_end_date'])); ?> <?php echo date('h:i A', strtotime($row['tournament_end_time'])); ?></td>
                                                    
													<td>
													<?php if($row['tournament_section'] == 2){ ?>
														<span class="badge badge-soft-primary">Weekly</span>
													<?php } else { if($row['tournament_section']==1) { ?>
														<span class="badge badge-soft-dark">Free</span>
													<?php } else {?>
														<span class="badge badge-soft-info">Daily</span>
														<?php } } ?>
													</td>
													
													
													<td class="text-center">
													<?php 
													$startDate = date('Y-m-d', strtotime($row['tournament_start_date'])).' '.date('h:i A', strtotime($row['tournament_start_time']));
													$startDate = strtotime($startDate);
													
													$endDate = date('Y-m-d', strtotime($row['tournament_end_date'])).' '.date('h:i A', strtotime($row['tournament_end_time']));
													$endDate = strtotime($endDate);
													 
													$todayDate = strtotime(date('Y-m-d h:i A')); 
													?>
														<?php if($startDate <= $todayDate && $endDate >= $todayDate){  ?>
															<span class="badge badge-soft-success">Live</span>
														<?php } else if($startDate > $todayDate){  ?>
															<span class="badge badge-soft-info">Created Only</span>
														<?php } else if($endDate > $todayDate){  ?>
															<span class="badge badge-soft-danger">Expired</span>
														<?php } else { ?>
															<span class="badge badge-soft-danger">Expired</span>
														<?php }  ?>
													</td>
													
													
													
													<td class="text-center">
														<a href="#" data-toggle="modal" data-target="#tournamentInfo_<?php echo $row['tournament_id'] ?>" data-id=""  class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="Details" data-original-title="Details">
															<i data-feather="info" class="text-success" width="24" height="24"></i>
														</a>
														&nbsp;&nbsp;
														
													<?php if($startDate > $todayDate ){  ?>
														<a href="<?php echo site_url('Admin/EditTournaments/'.base64_encode($row['tournament_id'])); ?>"><i data-feather="edit-3" width="24" height="24"></i></a>
														&nbsp;&nbsp;
														<a href="<?php echo site_url('admin/deleteTournaments/'.base64_encode($row['tournament_id'])); ?>" class="text-danger" onClick="return confirm('Are you sure to remove this tournament from the list?');"><i data-feather="trash-2" width="24" height="24"></i></a>
													
													<?php } else { ?>
														<a href="#" data-toggle="modal" data-target="#notEdit"><i data-feather="edit-3" width="24" height="24"></i></a>
														&nbsp;&nbsp;
														
														<a href="#" data-toggle="modal" data-target="#notEdit" class="text-danger"><i data-feather="trash-2" width="24" height="24"></i></a>
														
													<?php } ?>
													</td>
                                                </tr>
                                            <?php } ?>   
                                            <?php } ?>   
                                            </tbody>
                                        </table>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->

					</div> <!-- container-fluid -->
				</div> <!-- content -->

                

                <!-- Footer Start -->
                <?php include ('footer.php'); ?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
	                     
    
	<div id="notEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<h5 class="modal-title text-danger"> 
					The Tournament is already live or expired. <br>So you can't edit or delete this tournament now.	
					</h5>
					<br>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		
	</div>

	<?php if(is_array($list) && count($list)>0){ ?>	
		<?php foreach($list as $rows){ ?>
		<div class="modal fade bd-example-modal-lg" id="tournamentInfo_<?php echo $rows['tournament_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered fadeInDown" role="document">
				<div class="modal-content">
					<div style="padding: 1.25em;">
						<div class="row">
							<div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 text-left">
								<h5 class="modal-title"><?php echo stripslashes(urldecode(ucwords($rows['tournament_name']))); ?> <br>(<?php echo date("M d, Y",strtotime($rows['tournament_start_date']))." - ".date("M d, Y",strtotime($rows['tournament_end_date'])); ?>)</h5>
								<br>
							<?php if(!empty($rows['tournament_section']) && $rows['tournament_section'] !='' && $rows['tournament_section'] !='-' ){ ?>
								<b>
								<?php if($rows['tournament_section']==1) echo "Daily Free Tournament"; else if($rows['tournament_section']==2) echo "Weekly Premium Tournament"; else echo "Daily Premium Tournament"; ?>
								</b>
							<?php } ?>
							</div>
							<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-right">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
								</button>
							</div>
						</div>
					</div>
					<div class="modal-body">
						<!--
						<div class="row">
							<div class="col-md-12"><p class="text-justify modal-text"><?php echo urldecode($rows['tournament_desc']); ?></p></div>
							<div class="col-md-12"><hr></div>
						</div>
						-->
					
						
						<?php if(!empty($rows['tournament_game_name']) && $rows['tournament_game_name'] !='' && $rows['tournament_game_name'] !='-' ){ ?>
						<div class="row">
							<div class="col-md-6"><b>Game:</b></div>
							<div class="col-md-6">
							<p class=" modal-text"><?php echo $rows['tournament_game_name']; ?>
								<?php if(!empty($rows['tournament_category']) && $rows['tournament_category'] !='' && $rows['tournament_category'] !='-' ){ ?>
									<?php echo " (".$rows['tournament_category'].") "; ?>
								<?php } ?>
							</p>
								
							</div>
							<div class="col-md-12"><hr></div>
						</div>
						<?php } ?>
					<!--	
						<?php if(!empty($rows['tournament_start_time']) && $rows['tournament_start_time'] !='' && $rows['tournament_start_time'] !='-' ){ ?>
						<div class="row">
							<div class="col-md-6"><b>Start :</b></div>
							<div class="col-md-6"><p class=" modal-text"><?php echo $rows['tournament_start_time']; ?></p></div>
							<div class="col-md-12"><hr></div>
						</div>
						<?php } ?>
						
						
						<?php if(!empty($rows['tournament_end_time']) && $rows['tournament_end_time'] !='' && $rows['tournament_end_time'] !='-' ){ ?>
						<div class="row">
							<div class="col-md-6"><b>End:</b></div>
							<div class="col-md-6"><p class=" modal-text"><?php echo $rows['tournament_end_time']; ?></p></div>
							<div class="col-md-12"><hr></div>
						</div>
						<?php } ?>
						
						
						<?php if(!empty($rows['tournament_type']) && $rows['tournament_type'] !='' && $rows['tournament_type'] !='-' ){ ?>
						<div class="row">
							<div class="col-md-6"><b>Tournament Type:</b></div>
							<div class="col-md-6"><p class=" modal-text">
								<?php if($rows['tournament_type']==1) echo "Free"; else if($rows['tournament_type']==2) echo "Paid"; else echo "Contest"; ?></p></div>
							<div class="col-md-12"><hr></div>
						</div>
						<?php } ?>
					-->	
						
					
						<?php if(!empty($rows['fee_tournament_fee']) && $rows['fee_tournament_fee'] !='' && $rows['fee_tournament_fee'] !='-' ){ ?>
						<div class="row">
							<div class="col-md-6"><b>Tournament Fee:</b></div>
							<div class="col-md-6"><p class=" modal-text"><?php echo $rows['fee_tournament_fee']; ?> Play Coins</p></div>
							<div class="col-md-12"><hr></div>
						</div>
						<?php } ?>
						
						
						<?php if(!empty($rows['fee_tournament_rewards']) && $rows['fee_tournament_rewards'] !='' && $rows['fee_tournament_rewards'] !='-' ){ ?>
						<div class="row">
							<div class="col-md-6"><b>Reward Type:</b></div>
							<div class="col-md-6"><p class=" modal-text">
								<?php if($rows['fee_tournament_rewards']==4) echo " Daraz Voucher"; else echo "Reward Coins"; ?></p></div>
							<div class="col-md-12"><hr></div>
						</div>
						<?php } ?>
						
						
						<?php if(!empty($rows['fee_tournament_prize_1']) && $rows['fee_tournament_prize_1'] !='' && $rows['fee_tournament_prize_1'] !='-' ){ ?>
						<div class="row">
							<?php if(!empty($rows['tournament_section']) && $rows['tournament_section'] =='1' ){ ?>
							<div class="col-md-6"><b> Prize Rank 1st - 10th</b></div>
							<?php } else { ?>
							<div class="col-md-6"><b> Prize Rank 1st</b></div>
							<?php } ?>
							<div class="col-md-6"><p class=" modal-text">
								<?php foreach($voucher as $value){ 
									if($value['vt_id']==$rows['fee_tournament_prize_1']){ 
										echo number_format($value['vt_type'], 0);
										break;
									}
								} ?>
								</p>
							</div>
							<div class="col-md-12"><hr></div>
						</div>
						<?php } ?>
						
						
						<?php if(!empty($rows['fee_tournament_prize_2']) && $rows['fee_tournament_prize_2'] !='' && $rows['fee_tournament_prize_2'] !='-' ){ ?>
						<div class="row">
							<div class="col-md-6"><b> Prize Rank 2nd</b></div>
							<div class="col-md-6"><p class=" modal-text">
								<?php foreach($voucher as $value){ 
									if($value['vt_id']==$rows['fee_tournament_prize_2']){ 
										echo number_format($value['vt_type'], 0);
										break;
									}
								} ?>
								</p>
							</div>
							<div class="col-md-12"><hr></div>
						</div>
						<?php } ?>
						
						
						<?php if(!empty($rows['fee_tournament_prize_3']) && $rows['fee_tournament_prize_3'] !='' && $rows['fee_tournament_prize_3'] !='-' ){ ?>
						<div class="row">
							<div class="col-md-6"><b> Prize Rank 3rd</b></div>
							<div class="col-md-6"><p class=" modal-text">
								<?php foreach($voucher as $value){ 
									if($value['vt_id']==$rows['fee_tournament_prize_3']){ 
										echo number_format($value['vt_type'], 0);
										break;
									}
								} ?></p>
							</div>
							<div class="col-md-12"><hr></div>
						</div>
						<?php } ?>
						
						
						<?php if(!empty($rows['fee_tournament_prize_4']) && $rows['fee_tournament_prize_4'] !='' && $rows['fee_tournament_prize_4'] !='-' ){ ?>
						<div class="row">
							<div class="col-md-6"><b> Prize Rank 4th - 10th</b></div>
							<div class="col-md-6"><p class=" modal-text">
								<?php foreach($voucher as $value){ 
									if($value['vt_id'] == $rows['fee_tournament_prize_4']){ 
										echo number_format($value['vt_type'], 0);
										break;
									}
								} ?></p>
							</div>
							<div class="col-md-12"><hr></div>
						</div>
						<?php } ?>
						
						
						<?php if(!empty($rows['fee_tournament_prize_5']) && $rows['fee_tournament_prize_5'] !='' && $rows['fee_tournament_prize_5'] !='-' ){ ?>
						<div class="row">
							<?php if(!empty($rows['tournament_section']) && $rows['tournament_section'] =='3' ){ ?>
							<div class="col-md-6"><b> Prize Rank 11th - 20th</b></div>
							<?php } else { ?>
							<div class="col-md-6"><b> Prize Rank 11th - 50th</b></div>
							<?php }  ?>
							<div class="col-md-6"><p class=" modal-text">
								<?php foreach($voucher as $value){ 
									if($value['vt_id']==$rows['fee_tournament_prize_5']){ 
										echo number_format($value['vt_type'], 0);
										break;
									}
								} ?>
								</p>
							</div>
							
						</div>
						<?php } ?>
						
					<p class="modal-text"></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	<?php } ?>
	
	<div id="uploadBulk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-dark">
					<h5 class="modal-title text-white" id="myModalLabel">Upload Excelsheet</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" class="parsley-examples" action="<?php echo site_url('admin/processBulkTournaments') ?>" method="post" enctype="multipart/form-data">
                 
				<div class="modal-body">
				
				
					<div class="form-group row">
						<div class="col-md-12 text-right">
							<a  class="btn btn-dark btn-rounded" target="_blank" href="<?php echo base_url('uploads/format/tournaments_bulk.xlsx'); ?>">Download Excel Format</a>
						</div>
					</div>
					
					<div class="row"><div class="col-md-12"><br><br> </div></div>
					
					<div class="form-group row"><br>
						<label for="userfile" class="col-md-5 col-form-label">Upload Excelsheet </label>
						<div class="col-md-7">
							<input type="file" class="" id="userfile"  name="userfile"  required accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
						</div>
					</div>
									
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-dark">Upload</button>
				</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	
      
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
		
		<!-- Vendor js -->
        <script src="<?php echo base_url() ?>assets/admin/js/vendor.min.js"></script>

		<!-- datatable js -->
        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/responsive.bootstrap4.min.js"></script>
        
        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/buttons.bootstrap4.min.js"></script>
        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/buttons.flash.min.js"></script>
        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/buttons.print.min.js"></script>

        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url() ?>assets/admin/libs/datatables/dataTables.select.min.js"></script>

        <!-- Datatables init -->
        <script src="<?php echo base_url() ?>assets/admin/js/pages/datatables.init.js"></script>
		
		<!-- Plugin js-->
        <script src="<?php echo base_url() ?>assets/admin/libs/parsleyjs/parsley.min.js"></script>

        <!-- Validation init js-->
        <script src="<?php echo base_url() ?>assets/admin/js/pages/form-validation.init.js"></script>


        <!-- App js -->
        <script src="<?php echo base_url() ?>assets/admin/js/app.min.js"></script>

		<script>
		$('#myDataTable').dataTable( {
			"pageLength": 50
		});
		</script>
		<script>
			function tournamentDetail(id)
			{
				$.ajax({
					url: "<?php echo site_url('admin/getTournamentDetails') ?>",
					type: "POST",
					data: id,
					success: function(data){
						if(data){
							$("#tournament_game_id").html(data);
						} else {
							$("#tournament_game_id").val('');
						}
					}
				});
			}
		</script>

    </body>
</html>