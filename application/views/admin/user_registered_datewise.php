<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>GSL | User Registered</title>
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
                                        <li class="breadcrumb-item active" aria-current="page">User Registered</li>
                                    </ol>
                                </nav>
                                <h4 class="mb-1 mt-0">User Registered</h4>
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
												<h4 class="header-title mt-0 mb-1">
												
												
												
												</h4>
											</div>
											
											<div class="col-md-6 float-md-right" style="float:right;"> 
											</div>
											
										</div>
                                        
									
                                        
										<p class="sub-header">
                                            &nbsp; <br>
                                        </p>
										
										

                                        <table id="myDataTable" class="table ">
                                            <thead>
                                                <tr>
                                                    <th width="10%"># <br>&nbsp; </th>
                                                    <th width="20%">User Mobile <br>&nbsp; </th>
                                                    <th width="20%">User Name <br>&nbsp; </th>
                                                    <th width="25%" class="text-center">Subscribed</th>
                                                    <!-- <th width="15%" class="text-center"></th> -->
                                                    <!-- <th width="10%" class="text-center">Action <br>&nbsp; </th> -->
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
											<?php if(is_array($result) && count($result)>0){ $i=1;  ?>
											<?php foreach($result as $row){  ?>
												<tr>
                                                    <td width="10%"><?php echo $i; $i++; ?></td>
                                                    <td width="20%"><?php echo $row['user_phone']; ?></td>
                                                    <td width="20%">
													<?php 
														echo $row['user_full_name'];
													?>
													
													</td>
                                                    <td width="25%" class="text-center"><?php if($row['user_subscription']==1) echo "Subscribed"; else echo "Non-Subscribed"; ?></td>
                                                    <!-- <td width="15%" class="text-center"><?php echo $row['total_users'] - $row['subscribed']; ?></td> -->
                                                    
													
													<!-- <td width="10%" class="text-center">
                                                        
                                                        &nbsp;&nbsp;
														<a href="<?php echo site_url('Admin/UserPlayStats/'.base64_encode($row['date'])); ?>" data-toggle="tooltip" data-title="Stats"><i data-feather="trending-up" width="24" height="24"></i></a>
														
													</td> -->
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
		  <form action="<?php echo site_url('Admin/DateFilterUserRegistered'); ?>" method="post"> 
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