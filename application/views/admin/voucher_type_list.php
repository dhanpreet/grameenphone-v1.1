<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>GSL | Voucher Type</title>
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
                                        <li class="breadcrumb-item active" aria-current="page">Manage Voucher's Type </li>
                                    </ol>
                                </nav>
                                <h4 class="mb-1 mt-0">Manage Voucher's Type </h4>
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
												<h4 class="header-title mt-0 mb-1"> Voucher Types List</h4>
											</div>
											<div class="col-4 text-right">
												<button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#addSection">Add New Type</button>
											
											</div>  
										</div>
                                        
										<p class="sub-header">
                                            &nbsp; <br>
                                        </p>
										
										

                                        <table id="myDataTable" class="table">
                                            <thead>
                                               <tr>
													<th>#</th>
													<th>Voucher Type</th>
													<th class="text-center"> Total </th>
													<th class="text-center"> Assigned </th>
													<th class="text-center"> Claimed </th>
													<th class="text-center"> Expired </th>
												   <th class="text-center"> Available </th>
												  
													<th class="text-center">Status</th>
													<!-- <th class="text-center">Actions</th> -->
													
												</tr>
                                            </thead>
                                        
                                        
                                            <tbody>
											<?php if( is_array(@$list) && count(@$list)>0){ $i=1; ?>
											<?php foreach($list as $row){ ?>
												<tr>
													<td><?php echo $i; $i++; ?></td>
													<td><?php echo $row['vt_type']; ?></td>
												
													<td class="text-center"><?php echo $row['vt_total_coupons'];  ?></td>
													<td class="text-center"><?php echo $row['vt_assign_coupons'];  ?></td>
													<td class="text-center"><?php echo $row['vt_claimed_coupons'];  ?></td>
													<td class="text-center"><?php echo $row['vt_expired_coupons'];  ?></td>
													<td class="text-center"><?php echo $row['vt_balance_coupons'];  ?></td>
													<td class="text-center">
													
													<?php if($row['vt_status'] ==  '1') { ?>
														<span class="badge badge-success">Active</span>
													<?php } else { ?>
														<span class="badge badge-danger">Deactived</span>
													<?php }	?>
														
													</td>
													

													<!-- <td class="text-center">
														<a href="#" data-toggle="modal" data-target="#edit_<?php echo $row['vt_id']; ?>" ><i data-feather="edit-3" width="24" height="24"></i></a>
														&nbsp; &nbsp;
														<a class="text-danger" href="<?php echo site_url('admin/removeVoucherType/'.base64_encode($row['vt_id'])); ?>" onClick="return confirm('Are you sure to deactivate this voucher type from the list?');" ><i data-feather="trash-2" width="24" height="24"></i></a>
													
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
		
	<div id="addSection" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">New Voucher Type</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" class="parsley-examples" action="<?php echo site_url('admin/processVoucherType') ?>" method="post">
                 
				<div class="modal-body">
				
					<div class="form-group row">
						<label for="vt_type" class="col-md-4 col-form-label">Voucher Type</label>
						<div class="col-md-8">
							<input type="text"  class="form-control" id="vt_type"  name="vt_type"  required />
								
						</div>
					</div>

					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
<?php if( is_array(@$list) && count(@$list)>0){ $i=1; ?>
<?php foreach($list as $rows){  ?>
	<div class="modal fade" id="edit_<?php echo $rows['vt_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Update Section</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<form action="<?php echo site_url('admin/processVoucherType') ?>" method="post">
				<input type="hidden" name="vt_id" value="<?php echo base64_encode($rows['vt_id']); ?>" required />
				
				<div class="form-group row">
					<label for="vt_type" class="col-md-4 col-form-label">Voucher type</label>
					<div class="col-md-8">
						<input type="text"  class="form-control" id="vt_type"  name="vt_type" value="<?php echo $rows['vt_type']; ?>" required />
							
					</div>
				</div>
					
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Update</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
<?php } ?>
<?php } ?>

      
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
		
    </body>
</html>