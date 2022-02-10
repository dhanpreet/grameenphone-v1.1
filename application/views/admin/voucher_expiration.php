<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Voucher</title>
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
                                        <li class="breadcrumb-item active" aria-current="page">Voucher</li>
                                    </ol>
                                </nav>
                                <h4 class="mb-1 mt-0">Voucher expires in 3 months</h4>
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
									  		<div class="col-11 mb-2">

											</div>
											<div class="col-1 mb-2">
												<a href="<?php echo site_url('admin/exportVoucherExpiration'); ?>" class="btn btn-success">
                                                <i data-feather="download"></i>
												</a>
											</div>
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
                                                    <th width="5%"># <br>&nbsp; </th>
                                                    <th width="25%">Voucher ID<br>&nbsp; </th>
                                                    <th width="25%">Voucher<br>&nbsp; </th>
                                                    <th width="15%" class="text-center">Starts From</th>
                                                    <th width="15%" class="text-center">Valid Upto</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
											<?php
											$count=0;
											if(is_array($list) && count($list)>0){ $i=1;  ?>
											<?php foreach($list as $row){  ?>
												<tr>
                                                    <td width="5%"><?php echo $i; $i++; ?></td>
                                                    <td width="25%">#VC_<?php echo $row['voucher_id']; ?></td>
                                                    <td width="25%"><?php echo $row['vt_type']."  ৳  Voucher";  ?></td>
                                                    <td width="15%" class="text-center"><?php echo date('j M, Y', strtotime($row['voucher_validity_starts'])); ?></td>
                                                    <td width="25%" class="text-center"><?php echo date('j M, Y', strtotime($row['voucher_validity_ends'])); ?></td>
                                                </tr>
                                            <?php
											$count++;
											 } ?>   
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
		  <form action="<?php echo site_url('Analytics/TouramentsDateFilters'); ?>" method="post"> 
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