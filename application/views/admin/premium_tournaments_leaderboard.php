<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>GSL | Tournament Leaderboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?php echo base_url() ?>assets/admin/images/paymaya.png">

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
                                        <li class="breadcrumb-item"><a href="<?php echo site_url('Admin') ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="<?php echo site_url('Admin/Tournaments') ?>">Tournaments Master</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Tournament Leaderboard</li>
                                    </ol>
                                </nav>
                                <h4 class="mb-1 mt-0">Tournament Leaderboard</h4>
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
											<div class="col-8">
												<h4 class="header-title mt-0 mb-1"><?php echo stripslashes(urldecode($tournamentInfo['tournament_name'])) ?></h4>
												<p>
													(<?php 
														if($tournamentInfo['tournament_start_date'] == $tournamentInfo['tournament_end_date']){
															echo date('M d, Y', strtotime($tournamentInfo['tournament_start_date']));
														} else {
															echo date('M d', strtotime($tournamentInfo['tournament_start_date'])); ?> - <?php echo date('M d', strtotime($tournamentInfo['tournament_end_date']));
														}
													?>
													| 
													<?php echo date('h:i A', strtotime($tournamentInfo['tournament_start_time'])); ?> - <?php echo date('h:i A', strtotime($tournamentInfo['tournament_end_time'])); ?>
                                                  )  
											</p>
											
											</div>
											<div class="col-4 text-right">
												<button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#rewards">Reward Distribution</button>
											</div>
										</div>
                                        
										<p class="sub-header">
                                            &nbsp; <br>
                                        </p>
										
										

                                        <table id="myDataTable" class="table ">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="10%">Player Name</th>
                                                    <th width="15%" class="text-center">Score On-board</th>
                                                    <th width="10%" class="text-center">Ranking On-board</th>
                                                    <th width="10%" class="text-center">Reward Coins</th>
                                                   
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
											<?php 
											
											if(is_array($list) && count($list)>0){ $i=1;
												$highest_score = $list[0]['player_score'];
												$rank = 1;
												$arrIndex = 1;
												$today = date('Y-m-d');
											?>
											<?php foreach($list as $row){  ?>
                                                <tr>
                                                    <td width="5%"><?php echo $i; $i++; ?></td>
                                                    <td width="10%"><?php echo stripslashes(urldecode($row['user_full_name'])); ?></td>
                                                    <td width="10%" class="text-center"><?php echo number_format($row['player_score'], 0); ?></td>
                                                    <td width="10%" class="text-center">
													
													
														<?php
															if($highest_score !=0 && $row['player_score'] == $highest_score){
																echo "<b>".@$rank."</b>"; 
																
															} else {
																if($row['player_score'] > 0 ){
																	
																	echo "<b>".@$rank."</b>"; 
																} else{
																	echo "0"; 
																}
																$highest_score = $row['player_score'];
															}
														$rank++;
														?>
													
													</td>
                                                    
													<td width="10%" class="text-center">
													<?php 
													if($tournamentInfo['tournament_end_date'] < $today){ 
														echo number_format($row['player_reward_prize'], 0); 
													} else {
														echo "RA";
													}
													?>
													
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
	                     
   	
	<div id="rewards" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">Rewards per ranking</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				  
				<div class="modal-body">
				
					<div class="col-xs-12 padd reward-ranking">
						<table class="table">
							<?php if(!empty($tournamentInfo['fee_tournament_prize_1']) ){ ?>
								<tr><td>Rank 1</td>
									<td>
									<?php foreach($voucher as $value){ 
										if($value['vt_id']==$tournamentInfo['fee_tournament_prize_1']){ 
											echo number_format($value['vt_type'], 0);
											break;
										}
									} ?>
									</td>
								</tr>
							<?php } ?>
							<?php if(!empty($tournamentInfo['fee_tournament_prize_2']) ){ ?>
								<tr><td>Rank 2</td>
									<td>
									<?php foreach($voucher as $value){ 
										if($value['vt_id']==$tournamentInfo['fee_tournament_prize_2']){ 
											echo number_format($value['vt_type'], 0);
											break;
										}
									} ?>
									</td>
								</tr>
							<?php } ?>
							<?php if(!empty($tournamentInfo['fee_tournament_prize_3']) ){ ?>
								<tr><td>Rank 3</td>
									<td>
									<?php foreach($voucher as $value){ 
										if($value['vt_id']==$tournamentInfo['fee_tournament_prize_3']){ 
											echo number_format($value['vt_type'], 0);
											break;
										}
									} ?>
									</td>
								</tr>
							<?php } ?>
							<?php if(!empty($tournamentInfo['fee_tournament_prize_4']) ){ ?>
								<tr><td>Rank 4th- Rank 10th</td>
									<td>
									<?php foreach($voucher as $value){ 
										if($value['vt_id']==$tournamentInfo['fee_tournament_prize_4']){ 
											echo number_format($value['vt_type'], 0);
											break;
										}
									} ?>
									</td>
								</tr>
							<?php } ?>
							<?php if($tournamentInfo['tournament_section']==2){ ?>
								<?php if(!empty($tournamentInfo['fee_tournament_prize_5']) ){ ?>
								<tr><td>Rank 11th- Rank 50th</td>
									<td>
									<?php foreach($voucher as $value){ 
										if($value['vt_id']==$tournamentInfo['fee_tournament_prize_5']){ 
											echo number_format($value['vt_type'], 0);
											break;
										}
									} ?>
									</td>
								</tr>
							<?php } ?>
							<?php } else {?>
								<?php if(!empty($tournamentInfo['fee_tournament_prize_5']) ){ ?>
								<tr><td>Rank 11th- Rank 20th</td>
									<td>
									<?php foreach($voucher as $value){ 
										if($value['vt_id']==$tournamentInfo['fee_tournament_prize_5']){ 
											echo number_format($value['vt_type'], 0);
											break;
										}
									} ?>
									</td>
								</tr>
							<?php } ?>
							<?php } ?>
							
							
							
						</table>

		</div>
	
									
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					
				</div>
				
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
			"pageLength": 10
		});
		</script>
		

    </body>
</html>