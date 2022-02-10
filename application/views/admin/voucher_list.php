<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>GSL | Vouchers</title>
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
                                        <li class="breadcrumb-item active" aria-current="page">Manage Voucher Section</li>
                                    </ol>
                                </nav>
                                <h4 class="mb-1 mt-0">Manage Voucher Section</h4>
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
												<h4 class="header-title mt-0 mb-1"> Voucher List</h4>
											</div>
											<div class="col-4 text-right">
										
												<button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#addSection">Add Voucher</button>
												<a href="javascript(0);" data-toggle="modal" data-target="#uploadBulk" class="btn btn-secondary btn-rounded" >Upload Bulk</a>
											
											</div>  
										</div>
                                        
										<p class="sub-header">
                                            &nbsp; <br>
                                        </p>
										
										

                                        <table id="myDataTable" class="table ">
                                            <thead>
                                               <tr>
													<th width="5%">#</th>
													<th width="8%">Voucher ID</th>
													<th width="10%"> Voucher </th>
													<th width="10%"> Starts From</th>
													<th width="10%"> Valid Upto</th>
													<th width="10%" class="text-center">Voucher Status </th>
													<!-- <th width="10%" class="text-center">Assignment Status </th>-->
													<th width="10%" class="text-center">Actions </th>
													
												</tr>
                                            </thead>
                                        
                                        
                                            <tbody>
											<?php if( is_array(@$list) && count(@$list)>0){ $i=1; ?>
												 <?php foreach($list as $row){  ?>

												<tr>
													<td width="5%"><?php echo $i; $i++; ?></td>
													<th width="8%">#VC_<?php echo $row['voucher_id']; ?></th>
													<td width="10%"><?php echo $row['vt_type']."  ৳  Voucher";  ?></td>
													<td width="10%"><?php echo date('j M, Y', strtotime($row['voucher_validity_starts'])); ?></td>
													<td width="10%"><?php echo date('j M, Y', strtotime($row['voucher_validity_ends'])); ?></td>
												
													<td width="10%" class="text-center">
														<?php if($row['voucher_status'] == '0'){ ?>
															 <span class="badge badge-soft-secondary">Created Only </span>
														<?php } else if($row['voucher_status'] == '1'){ ?>
																<span class="badge badge-success"> Assigned to Tournament </span> 
														<?php } else if($row['voucher_status'] == '2'){ ?>
																<span class="badge badge-success"> Assigned to User </span> 
														<?php } else if($row['voucher_status'] == '3'){ ?>
																<span class="badge badge-success"> Claimed by User </span> 
														<?php } else if($row['voucher_status'] == '4'){ ?>
																<span class="badge badge-danger"> Expired</span> 
														<?php } else if($row['voucher_status'] == '5'){ ?> 
															<span class="badge badge-soft-danger">Deactivated by Admin</span>
                                                    	
                                                    	<?php } else if($row['voucher_status'] == '6'){ ?> 
															<span class="badge badge-soft-danger">Near Expiration Period</span>
                                                    	
                                                    	<?php }  ?> 
													</td>
                                                    	 
                                                    	
                                                    
                                                    <td width="10%" class="text-center">
													<!-- <a href="#" data-toggle="modal" data-target="#journey_<?php echo $row['voucher_id']; ?>" ><i data-feather="info" class="text-success" width="24" height="24"></i></a>	   -->
														<?php if($row['voucher_status'] == 0){ ?>
															<a href="#" onclick="getVoucherJourney('<?php echo $row['voucher_id']; ?>')" id="getJourney"><i data-feather="info" class="text-success" width="24" height="24"></i></a>
																<a href="#" data-toggle="modal" data-target="#edit_<?php echo $row['voucher_id']; ?>" ><i data-feather="edit-3" width="24" height="24"></i></a>
																&nbsp; &nbsp;
																
																<a class="text-danger" href="<?php echo site_url('admin/removeVoucher/'.base64_encode($row['voucher_id'])); ?>" onClick="return confirm('Are you sure to deactivate this voucher from the list?');" ><i data-feather="trash-2" width="24" height="24"></i></a>
															
														<?php } else { ?>
															<a href="#" onclick="getVoucherJourney('<?php echo $row['voucher_id']; ?>')" id="getJourney"><i data-feather="info" class="text-success" width="24" height="24"></i></a>
																<a href="#" data-toggle="modal" data-target="#assined_status_check_modal" ><i data-feather="edit-3" width="24" height="24"></i></a>
																&nbsp; &nbsp;
																<a href="#" data-toggle="modal" data-target="#assined_status_check_modal" ><i data-feather="trash-2" width="24" height="24"></i></a>
																
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
    
	
	<div id="uploadBulk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-dark">
					<h5 class="modal-title text-white" id="myModalLabel">Upload Excelsheet</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" class="parsley-examples" action="<?php echo site_url('admin/processBulkVouchers') ?>" method="post" enctype="multipart/form-data">
                 
				<div class="modal-body">
				
				
					<div class="form-group row">
						<div class="col-md-12 text-right">
							<a  class="btn btn-dark btn-rounded" target="_blank" href="<?php echo base_url('uploads/format/vouchers_upload_template.xlsx'); ?>" download="vouchers_upload_template">Download Excel Format</a>
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


	<!-- Modal -->
	<?php if( is_array(@$list) && count(@$list)>0){ $i=1; ?>
	<?php foreach($list as $rows){    ?>
		<div class="modal fade" id="journey_<?php echo $rows['voucher_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Voucher Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo $rows['voucher_id']; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
			</div>
		</div>
		</div>
	<?php } ?>
	<?php } ?>
	<div id="assined_status_check_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<h5 class="modal-title text-danger"> 
					This voucher is already assigend to a tournament or user. So you can't edit or delete this voucher now.	
					</h5>
					<br>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	
		
	<div id="addSection" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">Add New Voucher</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form role="form" class="parsley-examples" action="<?php echo site_url('admin/processVoucher') ?>" method="post">
                 
				<div class="modal-body">
				
					<div class="form-group row">
						<label for="coupon_code" class="col-md-4 col-form-label">Voucher Type</label>
						<div class="col-md-8">
							<select class="form-control" name="voucher_type_id" id="voucher_type_id" required >
								<option value="">Choose option</option>
								<?php foreach($voucherTypes as $typelist){ ?>
                                 <option value="<?php echo $typelist['vt_id'] ?>" ><?php echo $typelist['vt_type'] ?></option>
								<?php } ?>
						</select>
								
						</div>
					</div>

				<!--
					<div class="form-group row">
						<label for="voucher_name" class="col-md-4 col-form-label">Voucher Name</label>
						<div class="col-md-8">
							<input type="text"  class="form-control" id="voucher_name"  name="voucher_name"  required />
								
						</div>
					</div>
				-->
				
					<div class="form-group row">
						<label for="coupon_code" class="col-md-4 col-form-label">Coupon Code</label>
						<div class="col-md-8">
							<input type="text"  class="form-control" id="voucher_code" name="voucher_code"  oninvalid="this.setCustomValidity('Special character not allowed in Coupon code')"  required />
								
						</div>
					</div>

					<div class="form-group row">
						<label for="voucher_validity_starts" class="col-md-4 col-form-label">Validity Starts From</label>
						<div class="col-md-8">
							<input type="date"  class="form-control" id="voucher_validity_starts"  name="voucher_validity_starts" value="<?php echo date('Y-m-d'); ?>"  />
								
						</div>
					</div>
					
					
					<div class="form-group row">
						<label for="voucher_validity_ends" class="col-md-4 col-form-label">Validity Ends On</label>
						<div class="col-md-8">
							<input type="date"  class="form-control" id="voucher_validity_ends"  name="voucher_validity_ends" value="<?php echo @$new_voucher_ends; ?>"  />
								
						</div>
					</div>
					
					
					<div class="form-group row">
						<label for="website" class="col-md-4 col-form-label">Website <br>  (if Available)</label>
						<div class="col-md-8">
							<input type="url"  class="form-control" id="voucher_website"  name="voucher_website"   />
								
						</div>
					</div>

					
					<div class="form-group row">
						<label for="website" class="col-md-4 col-form-label">Description <br>  (if Available)</label>
						<div class="col-md-8">
							<textarea rows="5" class="form-control" id="voucher_description"  name="voucher_description" ></textarea>
								
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
	
	<!-- Voucher Journey Modal -->
	<div class="modal fade" id="voucherJourney" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		
	</div>


<?php if( is_array(@$list) && count(@$list)>0){ $i=1; ?>
<?php foreach($list as $rows){    ?>
	<div class="modal fade" id="edit_<?php echo $rows['voucher_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Update Voucher</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<form action="<?php echo site_url('admin/processVoucher') ?>" method="post">
				<input type="hidden" name="voucher_id" value="<?php echo base64_encode($rows['voucher_id']); ?>" required />
					
				<!-- 
				<div class="form-group row">
					<label for="voucher_name" class="col-md-4 col-form-label">Voucher Name</label>
					<div class="col-md-8">
						<input type="text"  class="form-control" id="voucher_name"  name="voucher_name" value="<?php echo $rows['voucher_name']; ?>"  required />
							
					</div>
				</div>
				-->
				
					<div class="form-group row">
						<label for="coupon_code" class="col-md-4 col-form-label">Voucher Type</label>
						<div class="col-md-8">
							<select class="form-control" name="voucher_type_id" id="voucher_type_id" required >
								<option value="">Choose option</option>
								<?php foreach($voucherTypes as $typelist){ ?>
                                 <option <?php if($typelist['vt_id'] == $rows['voucher_type_id']){ echo "selected"; } ?> value="<?php echo $typelist['vt_id'] ?>" ><?php echo $typelist['vt_type'] ?></option>
								<?php } ?>
						</select>
								
						</div>
					</div> 
					
					
					<div class="form-group row">
						<label for="voucher_code" class="col-md-4 col-form-label">Coupon Code</label>
						<div class="col-md-8">
							<input type="text"  class="form-control" id="voucher_code" name="voucher_code" value="<?php echo $rows['voucher_code']; ?>" oninvalid="this.setCustomValidity('Special character not allowed in Coupon code')"  required />
								
						</div>
					</div>

					<div class="form-group row">
						<label for="voucher_validity_starts" class="col-md-4 col-form-label">Validity Starts From</label>
						<div class="col-md-8">
							<input type="date"  class="form-control" id="voucher_validity_starts"  name="voucher_validity_starts" value="<?php echo $rows['voucher_validity_starts']; ?>" required />
								
						</div>
					</div> 
					
					<div class="form-group row">
						<label for="voucher_validity_ends" class="col-md-4 col-form-label">Valid From</label>
						<div class="col-md-8">
							<input type="date"  class="form-control" id="voucher_validity_ends"  name="voucher_validity_ends" value="<?php echo $rows['voucher_validity_ends']; ?>" required />
								
						</div>
					</div> 
					

					<div class="form-group row">
						<label for="voucher_website" class="col-md-4 col-form-label">Website <br> (if available)</label>
						<div class="col-md-8">
							<input type="url"  class="form-control" id="voucher_website"  name="voucher_website" value="<?php echo $rows['voucher_website']; ?>"  />
								
						</div>
					</div>

					
					<div class="form-group row">
						<label for="voucher_description" class="col-md-4 col-form-label">Description <br> (if available)</label>
						<div class="col-md-8">
							<textarea class="form-control" id="voucher_description"  name="voucher_description" ><?php echo stripslashes(urldecode($rows['voucher_description'])); ?></textarea>
								
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
			function getVoucherJourney(id)
			{
				// $('#voucherJourney').modal('show');
				$.ajax({
					url : '<?php echo site_url('admin/voucherLogs'); ?>',
					type : 'POST',
					data : {id : id},
					success : function(data){
						if(data)
						{
							$('#voucherJourney').html(data);
							$('#voucherJourney').modal('show');
						}
					}
				})
			}
		</script>
		<script>
		$('#myDataTable').dataTable( {
			"pageLength": 50
		});
		</script>
		
    </body>
</html>