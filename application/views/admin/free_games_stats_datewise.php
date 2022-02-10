<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>GSL | Instant Games</title>
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
                                        <li class="breadcrumb-item"><a href="<?php echo site_url('Analytics') ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Practice Games Stats</li>
                                    </ol>
                                </nav>
                                <h4 class="mb-1 mt-0">Practice Games Stats</h4>
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
												<h4 class="header-title mt-0 mb-1">Stats for <span class="text-danger"><?php echo $gameInfo['Name']; ?><span>  </h4>
											
												<?php if($filter == 'customDates'){ ?> 
													<br><h4 class="header-title mt-0 mb-1"> Custom Filters <span class="text-danger"> <?php echo date('d/M/y', strtotime($startDate)); ?> </span> To <span class="text-danger"><?php echo date('d/M/y', strtotime($endDate)); ?> </span>  </h4><br>
												<?php } ?>
											
											
											</div>
											
											<div class="col-md-6 float-md-right" style="float:right;"> 
											<form action="<?php echo site_url('Admin/getFreeGamesStatsFilter/?type=1&game='.$game_id); ?>" method="post"> 
												<div class="form-group row" style=" text-align:right; ">
													<label class="col-md-2 label-control text-bold-700" ><h4><b>&nbsp; </b></h4></label>
													<div class="col-md-6" style="padding: 0 !important;"> 
														<select class="form-control" name="search" id="search">
															<option value='' <?php if(@$filter == '') { echo "selected"; } ?>>Choose Filter</option>
															<option value='1' <?php if(@$filter == '1') { echo "selected"; } ?>>Yesterday</option>
															<option value='7' <?php if(@$filter == '7') { echo "selected"; } ?>>Last 7 days</option>
															<option value='15' <?php if(@$filter == '15') { echo "selected"; } ?>>Last 15 days</option>
															<option value='30' <?php if(@$filter == '30') { echo "selected"; } ?>>Last 30 days</option>
															<option value='month' <?php if(@$filter == 'month') { echo "selected"; } ?>>MTD - Month Till Date</option>										
															<option value='custom' <?php if(@$filter == 'custom') { echo "selected"; } ?>>Custom Dates</option>										
														</select>
													</div>
													<div class="col-md-2 text-center" style="padding: 0 !important;"> 
														<button type="submit" name="Go" class="btn btn-primary"><i data-feather="search"></i></button>
													</div>
													<div class="col-md-2 text-center" style="padding: 0 !important;"> 
														<?php if($filter == 'customDates'){ ?>
															<a href="<?php echo site_url('admin/exportFreeGamesStatsRange/?&game='.$game_id.'&start='.$startDate.'&end='.$endDate) ?>" id="download-sheet-0" target="_blank"  name="Download" class="btn btn-success"><i data-feather="download"></i></a>
														<?php } else { ?>
															<a href="<?php echo site_url('admin/exportFreeGamesStats/?type=1&game='.$game_id.'&filter='.$filter) ?>" id="download-sheet-0" target="_blank"  name="Download" class="btn btn-success"><i data-feather="download"></i></a>
														<?php }  ?>
													</div>
													
												</div>
												
											</form>
											</div>
											
										</div>
										
										<!-- <div class="row">
											<div class="col-6">
												<br><h4 class="header-title mt-0 mb-1"> Total Game-plays: <?php echo number_format($freeStats['total_game_plays'], 0); ?></h4>
											</div>
											
											<div class="col-6 text-right">
												<br><h4 class="header-title mt-0 mb-1"> Unique Users: <?php echo number_format($freeStats['unique_plays'], 0); ?></h4>
											</div>
										</div> -->
                                        
										<p class="sub-header">
                                            &nbsp; <br>
                                        </p>
										
										

                                        <table id="myDataTable" class="table ">
                                            <thead>
                                                <tr>
                                                   
                                                    <th width="5%">Date</th>
                                                    <th width="15%">Game</th>
													<th width="15%" class="text-center">Play Counts</th>
													<th width="15%" class="text-center">Unique Users</th>
													
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
											<?php if(is_array($list) && count($list)>0){ $i=1;  ?>
											<?php foreach($list as $row){  ?>
										
												<tr>
                                                  
                                                    <td width="15%"><?php echo date('d/M/Y', strtotime($row['report_date'])); ?></td>
                                                    <td width="15%"><?php echo $row['Name']; ?></td>
												    
													<td width="15%" class="text-center"><?php echo $row['total_game_plays']; ?></td>
													<td width="15%" class="text-center"><?php echo $row['unique_plays']; ?></td>
													
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
	                     
   
	
	<!-- Modal -->
	<div class="modal fade" id="customDates" tabindex="-1" aria-labelledby="customDatesLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bd-primary">
			<h5 class="modal-title" id="customDatesLabel">Filter Data For Custom Dates</h5>
			</div>
		  <form action="<?php echo site_url('Admin/getFreeGamesStatsDateFilter/?type=1&game='.$game_id); ?>" method="post"> 
		  <div class="modal-body">
			
				<div class="form-group row">
					<label class="col-md-12 label-control text-bold-700" ><h6>Please choose a date range</h6></label>
				</div>	
				
				<div class="form-group row">
					<label class="col-md-4 label-control text-bold-700" ><h6>Start Date</h6></label>
					<div class="col-md-8" style="padding: 0 !important;"> 
						<input type="date" class="form-control" name="startDate" id="startDate">
					</div>										
				</div>	
				
				<div class="form-group row">
					<label class="col-md-4 label-control text-bold-700" ><h6>End Date </h6></label>
					<div class="col-md-8" style="padding: 0 !important;"> 
						<input type="date" class="form-control" name="endDate" id="endDate">
					</div>										
				</div>												
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Search</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
     
      
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
		
		<script>
		$(document).ready( function() {
			$('#search').change( function() {
				var filter = $(this).val();
				if(filter == 'custom'){
					$("#go-btn").attr('disabled','true');
					$("#customDates").modal('show');
				}  else {
					$("#customDates").hide('show');
					$("#go-btn").removeAttr('disabled');
				} 
			});
		});
		</script>



    </body>
</html>