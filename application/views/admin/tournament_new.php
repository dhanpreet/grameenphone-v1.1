<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>GSL | New Tournament</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/admin/images/favicon.ico">

        <!-- App css -->
        <link href="<?php echo base_url() ?>assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/admin/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/admin/css/app.min.css" rel="stylesheet" type="text/css" />
		<style>
			.form-control{
				border : 1px solid #b3b8d6 !important;
			}
			input:disabled{
				background-color:rgba(83,105,248,.25)!important;
			}
			input:readonly{
				background-color:rgba(83,105,248,.25)!important;
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
                                        <li class="breadcrumb-item"><a href="#">Manage Tournaments</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Create Tournament</li>
                                    </ol>
                                </nav>
                                <h4 class="mb-1 mt-0">Create New Tournament</h4>
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
						
						<form role="form" class="parsley-examples" action="<?php echo site_url('admin/processTournament') ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-soft-primary ">
									 <h4 class="header-title mt-0 mb-1"> Basic Information</h4>
									</div>
                                    <div class="card-body">
                                       
										<div class="form-group row">
											<div class="col-md-6">
												<label for="tournament_name" class="col-md-12 col-form-label">Tournament Name <span class="text-danger">*</span></label>
												<div class="col-md-12">
													<input type="text" class="form-control" name="tournament_name" id="tournament_name"  required />
												</div>
											</div>
											
											<div class="col-md-6">
												<label for="tournament_type" class="col-md-12 col-form-label">Type <span class="text-danger">*</span></label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_type" id="tournament_type" required >
															<option value="">Choose option</option>
															<option value="1" >Free</option>
															<option value="2" selected>Paid</option>
															<option value="3">Contest</option>
													</select>
												</div>
											</div>
											
										</div>
										
										<div class="form-group row">
											<div class="col-md-6">
												<label for="tournament_category_id" class="col-md-12 col-form-label">Category <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    <select class="form-control" name="tournament_category_id" id="tournament_category_id" required >
															<option value="">Choose Category</option> 
															<?php foreach($categories as $category){ ?>
																<option value="<?php echo $category['category_id']; ?>" > <?php echo $category['category_name']; ?> </option> 
															<?php } ?>
													</select>
                                                </div>
											</div>
											
											<div class="col-md-6">
												<label for="tournament_game_id" class="col-md-12 col-form-label">Game <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    <select class="form-control" name="tournament_game_id" id="tournament_game_id" required >
															<option value="">Choose Game</option> 
													</select>
                                                </div>
											</div>
										</div>
										
										<div class="form-group row">
											<div class="col-md-6">
												<label for="tournament_start_date" class="col-md-12 col-form-label">Start Time <span class="text-danger">*</span></label>
												<div class="row">
													<div class="col-md-6">
														<input type="date" class="form-control" name="tournament_start_date" id="tournament_start_date"  value="<?php  echo date('Y-m-d', strtotime('1 day')) ?>" required />
													</div>
													<div class="col-md-6">
														<input type="time" class="form-control" name="tournament_start_time" id="tournament_start_time"  value="<?php  echo date('00:00') ?>" required />
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												<label for="tournament_end_date" class="col-md-12 col-form-label">End Time <span class="text-danger">*</span></label>
												<div class="row">
													<div class="col-md-6">
														<input type="date" class="form-control" name="tournament_end_date" id="tournament_end_date"  value="<?php  echo date("Y-m-d", strtotime("+ 1 day")); ?>"   required />
													</div>
													<div class="col-md-6">
														<input type="time" class="form-control" name="tournament_end_time" id="tournament_end_time" value="<?php echo date('23:59') ?>" required />
													</div>
												</div>
											</div>
										</div>
											
										<div class="form-group row">
											<div class="col-md-6">
												<label for="tournament_section" class="col-md-12 col-form-label">Tournament Section Zone <span class="text-danger">*</span></label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_section" id="tournament_section" required >
														<option value="">Choose option</option>
														<option value="2" selected>Weekly Tournament (Premium)</option>
														<option value="3">Daily Tournament (Premium)</option>
														<option value="1" >Free Tournament To Play</option>
														
														
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<label for="tournament_desc" class="col-md-12 col-form-label">Description <span class="text-danger">*</span></label>
												<div class="col-md-12">
													<textarea class="form-control" name="tournament_desc" id="tournament_desc"  >This is dummy description</textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php $count=0; 
						 foreach($country as $row)
						{
							$count++;
						?>
						<div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-soft-primary ">
									 <h4 class="header-title mt-0 mb-1">Fee & Rewards Distribution <!-- <?php echo 'For'.' '.ucfirst($row['c_name']); ?> --> </h4>
									</div>
                                    <div class="card-body">
										<input type="hidden" name="country_id[]" value="<?php echo $row['c_id']; ?>">
                                       	<input type="hidden" name="country[]"  value="<?php echo $row['c_name']; ?>">
										
										<div class="form-group row">
											<div class="col-md-4">
												<label for="tournament_fee_<?php echo $row['c_id']; ?>" class="col-md-12 col-form-label">Fee (in Coins)<span class="text-danger">*</span></label>
												<div class="col-md-12">
													<input type="text" class="form-control" name="tournament_fee[]" id="tournament_fee_<?php echo $row['c_id']; ?>"  required />
												</div>
											</div>
											
											
											
											<div class="col-md-4">
												<label for="tournament_reward_type_<?php echo $row['c_id']; ?>" class="col-md-12 col-form-label">Reward Type <span class="text-danger">*</span></label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_reward_type[]" onchange="changeType(<?php echo $row['c_id']; ?>)" id="tournament_reward_type_<?php echo $row['c_id']; ?>" required >
															<option value="">Choose option</option>
														
															<option value="4" selected>Vouchers</option>
															<option value="1" >Coins</option>
													</select>
												</div>
											</div>
										</div>
										
									<div id="voucherid">
										<div class="form-group row">
											<div class="col-md-4" id="v_1">
												<label for="tournament_prize_10_<?php echo $row['c_id']; ?>" class="col-md-12 col-form-label">1st Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_prize_1[]"  id="tournament_prize_10_<?php echo $row['c_id']; ?>" required >
															<option value="">Choose option</option>
															<?php if(!empty($voucherListFirstPrize)){ foreach ($voucherListFirstPrize as $list) { 
																 ?>
																<option value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']. " (Available: ".$list['vt_balance_coupons'].")";
													     
														
													 ?></option>
															<?php } } ?>
													</select>
												</div>
											</div>
										
											<div class="col-md-4" id="v_2">
												<label for="tournament_prize_10_<?php echo $row['c_id']; ?>" class="col-md-12 col-form-label">2nd Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_prize_2[]"  id="tournament_prize_11_<?php echo $row['c_id']; ?>" required >
															<option value="">Choose option</option>
															<?php if(!empty($voucherListFirstPrize)){ foreach ($voucherListFirstPrize as $list) { 
																 ?>
																<option value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']. " (Available: ".$list['vt_balance_coupons'].")"; 
													     
														
													 ?></option>
															<?php  } } ?>
													</select>
												</div>
											</div>
										
											<div class="col-md-4" id="v_3">
												<label for="tournament_prize_10_<?php echo $row['c_id']; ?>" class="col-md-12 col-form-label">3rd Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_prize_3[]"  id="tournament_prize_12_<?php echo $row['c_id']; ?>" required >
															<option value="">Choose option</option>
															<?php if(!empty($voucherListFirstPrize)){ foreach ($voucherListFirstPrize as $list) { 
																 ?>
																<option value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']. " (Available: ".$list['vt_balance_coupons'].")";
													     
														
													 ?></option>
															<?php } } ?>
													</select>
												</div>
											</div>

											<div class="col-md-4" id="v_4t10">
												<label for="tournament_prize_10_<?php echo $row['c_id']; ?>" class="col-md-12 col-form-label">4th to 10th Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_prize_4[]"  id="tournament_prize_13_<?php echo $row['c_id']; ?>"  >
															<option value="">Choose option</option>
															<?php if(!empty($voucherlistForthPrize)){ foreach ($voucherlistForthPrize as $list) { 
																 ?>
																<option value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']. " (Available: ".$list['vt_balance_coupons'].")"; 
													     
														
													 ?></option>
															<?php } } ?>
													</select>
												</div>
											</div>

											<div class="col-md-4" id="v_11t50">
												<label for="tournament_prize_10_<?php echo $row['c_id']; ?>" class="col-md-12 col-form-label">11th to 50th Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_prize_5[]"  id="tournament_prize_14_<?php echo $row['c_id']; ?>"  >
															<option value="">Choose option</option>
															<?php if(!empty($voucherlistFifthPrize)){ foreach ($voucherlistFifthPrize as $list) { 
																?>
																<option value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']. " (Available: ".$list['vt_balance_coupons'].")";
													     
														
													 ?></option>
															<?php } } ?>
													</select>
												</div>
											</div>

											<div class="col-md-4" id="v_11t20">
												<label for="tournament_prize_10_<?php echo $row['c_id']; ?>" class="col-md-12 col-form-label">11th to 20th Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_prize_5[]"  id="tournament_prize_15_<?php echo $row['c_id']; ?>"  >
															<option value="">Choose option</option>
															<?php  if(!empty($voucherlistFree_day)){ foreach ($voucherlistFree_day as $list) { 
																 ?>
																<option value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']. " (Available: ".$list['vt_balance_coupons'].")";
													     
														
													 ?></option>
															<?php } } ?>
													</select>
												</div>
											</div>

											<div class="col-md-4" id="v_1t10">
												<label for="tournament_prize_10_<?php echo $row['c_id']; ?>" class="col-md-12 col-form-label">1st to 10th Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_prize_1[]"  id="tournament_prize_16_<?php echo $row['c_id']; ?>" required >
															<option value="">Choose option</option>
															<?php if(!empty($voucherlistFree_day)){ foreach ($voucherlistFree_day as $list) { 
																 ?>
																<option value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']. " (Available: ".$list['vt_balance_coupons'].")"; 
													     
														
													 ?></option>
															<?php } } ?>
													</select>
												</div>
											</div>
										</div>
										
									</div>
										
										
                                    </div>
                                </div> <!-- end card -->

                            </div> <!-- end col -->
                        </div>
						<?php } 
							if($count==0)
							{
							?>
							<div class="row">
                            	<div class="col-lg-12">
                                	<div class="card">
                                    	<div class="card-header bg-soft-primary ">
									 		<h4 class="header-title mt-0 mb-1">Fee & Rewards Distribution </h4>
										</div>
                                    	<div class="card-body">
											<p>Please active atleast one country to publish tournaments.  <a href="<?php echo site_url('Admin/ManageCountry'); ?>">Click here</a>	</p>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
                        <!-- end row -->
						
						
						<div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-soft-primary ">
									 <h4 class="header-title mt-0 mb-1">Upload Banner</h4>
									</div>
                                    <div class="card-body">
                                       	
										<div class="form-group row">
											<label for="banner_location" class="col-md-4 col-form-label">Banner Page Location </label>
											<div class="col-md-6">
												<select class="form-control" name="banner_location" id="banner_location"  >
														<option value="">Choose Location</option> 
														<option value="1">Home Page</option> 
														<option value="2">Practice Zone Page</option> 
														
												</select>
											</div>
										</div>
										
										<div class="form-group row">
											<label for="banner_position" class="col-md-4 col-form-label">Banner Position  </label>
											<div class="col-md-6">
												<select class="form-control" name="banner_position" id="banner_position"  >
														<option value="">Choose Position</option> 
														<option value="1">Header</option> 
														<option value="2">Footer</option> 
														
												</select>
											</div>
										</div>
											
										
										<div class="form-group row">
											<label for="banner_image_path" class="col-md-4 col-form-label">Banner Image </label>
											<div class="col-md-6">
												<input type="file"  name="banner_image_path" id="banner_image_path"  />
													
											</div>
										</div>
											
											
											
                                 
											<div class="form-group row">
                                               <div class="col-md-12"> <br> </div>
                                            </div>
											
											
                                           
                                 
                                            <div class="form-group row">
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit"  class="btn btn-primary btn-lg mr-1"> Save Tournament</button>
                                                    <button type="reset" class="btn btn-secondary btn-lg"> Reset </button>
                                                </div>
                                            </div>
                                       
                                    </div>
                                </div> <!-- end card -->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
					
					
					
					</form>
                     
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

      

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="<?php echo base_url() ?>assets/admin/js/vendor.min.js"></script>

        <!-- Plugin js-->
        <script src="<?php echo base_url() ?>assets/admin/libs/parsleyjs/parsley.min.js"></script>

        <!-- Validation init js-->
        <script src="<?php echo base_url() ?>assets/admin/js/pages/form-validation.init.js"></script>

        <!-- App js -->
        <script src="<?php echo base_url() ?>assets/admin/js/app.min.js"></script>
        
		
		<script>
		$(document).ready(function(){
			$("#tournament_category_id").change(function(){
				var category = $(this).val();
				var dataStr = "category="+category;
				$.ajax({
					url: "<?php echo site_url('admin/getCategoryGamesAjax') ?>",
					type: "POST",
					data: dataStr,
					success: function(data){
						if(data){
							$("#tournament_game_id").html(data);
						} else {
							$("#tournament_game_id").val('');
						}
					}
				});
			});
		});
		</script>
		<script>
			$(document).ready(function() {
				var ab='<?php echo $count ?>';
				if(ab==0)
				{
					$('#submit').attr('disabled', 'true');
				}
			})
		</script>
		<script>
			$(document).ready(function() {
				$('#voucherid').hide();
				<?php foreach($country as $row){ ?>
				changeType(<?php echo $row['c_id']; ?>);
				<?php } ?>
				});
		function changeType(id){
			// $("#tournament_reward_type_"+id).change(function(){
				var type = $("#tournament_reward_type_"+id).val();
				if(type!='4'){
					$('#tournament_prize_10_'+id).removeAttr('required');
					$('#tournament_prize_11_'+id).removeAttr('required');
					$('#tournament_prize_12_'+id).removeAttr('required');
					$('#tournament_prize_13_'+id).removeAttr('required');
					$('#tournament_prize_14_'+id).removeAttr('required');
					$('#tournament_prize_15_'+id).removeAttr('required');
					$('#tournament_prize_16_'+id).removeAttr('required');
				}
				if(type== '1'){
					$('#voucherid').hide();
					$("#novoucher").show();
					$('.reward_type'+id).empty();
					$('.reward_type'+id).append('Coins');
				} else if(type== '2'){
					$('#voucherid').hide();
					$("#novoucher").show();
					$('.reward_type'+id).empty();
					$('.reward_type'+id).append('Data Pack');
				} else if(type== '3'){
					$('#voucherid').hide();
					$("#novoucher").show();
					$('.reward_type'+id).empty();
					$('.reward_type'+id).append('Talk Time');
				}else if(type== '4'){
					$("#novoucher").hide();
					$('#voucherid').show();
					for (var i = 1; i <=9; i++) {
						$('#tournament_prize_'+i+3).removeAttr('required');
					}
					var t_sec = $('#tournament_section').val();
						if(t_sec=='1'){
							$('#v_1').hide();
							$('#tournament_prize_10_'+id).removeAttr('required');
							$('#tournament_prize_10_'+id).val('');
							$('#v_2').hide();
							$('#tournament_prize_11_'+id).removeAttr('required');
							$('#tournament_prize_11_'+id).val('');
							$('#v_3').hide();
							$('#tournament_prize_12_'+id).removeAttr('required');
							$('#tournament_prize_12_'+id).val('');
							$('#v_4t10').hide();
							$('#tournament_prize_13_'+id).removeAttr('required');
							$('#tournament_prize_13_'+id).val('');
							$('#v_11t50').hide();
							$('#tournament_prize_14_'+id).removeAttr('required');
							$('#tournament_prize_14_'+id).val('');
							$('#v_11t20').hide();
							$('#tournament_prize_15_'+id).removeAttr('required');
							$('#tournament_prize_15_'+id).val('');
							$('#v_1t10').show();
						/*	$('#tournament_prize_16_'+id).attr("required", true);
						*/
						}else if(t_sec=='3'){
                            $('#v_1').show();
							$('#v_2').show();
							$('#v_3').show();
							$('#v_4t10').show();
							$('#v_11t50').hide();
							$('#tournament_prize_14_'+id).removeAttr('required');
							$('#tournament_prize_14_'+id).val('');
							$('#v_11t20').show();
							$('#v_1t10').hide();
							$('#tournament_prize_16_'+id).removeAttr('required');
						/*	$('#tournament_prize_10_'+id).attr("required", true);
							$('#tournament_prize_11_'+id).attr("required", true);
							$('#tournament_prize_12_'+id).attr("required", true);
							$('#tournament_prize_13_'+id).attr("required", true);
							$('#tournament_prize_15_'+id).attr("required", true);
							*/
						}else{
                            $('#v_1').show();
							$('#v_2').show();
							$('#v_3').show();
							$('#v_4t10').show();
							$('#v_11t50').show();
							$('#v_11t20').hide();
							$('#tournament_prize_15_'+id).removeAttr('required');
							$('#tournament_prize_15_'+id).val('');
							$('#v_1t10').hide();
							$('#tournament_prize_16_'+id).removeAttr('required');
							$('#tournament_prize_16_'+id).val('');

						/*	$('#tournament_prize_10_'+id).attr("required", true);
							$('#tournament_prize_11_'+id).attr("required", true);
							$('#tournament_prize_12_'+id).attr("required", true);
							$('#tournament_prize_13_'+id).attr("required", true);
							$('#tournament_prize_14_'+id).attr("required", true);
							*/
						}

					
				} else {
					$('.reward_type'+id).empty();
					$('.reward_type'+id).append('Coins');
				}
			// });
		}
		
		</script>
		
		<script>
			$(document).ready(function(){
				<?php foreach($country as $row){ ?>
						$('#tournament_fee_<?php echo $row['c_id']; ?>').val(3000);
						$('#tournament_fee_<?php echo $row['c_id']; ?>').removeAttr('disabled');
						$('#tournament_prize_10_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==1)
							{
								//$('#tournament_prize_10_<?php echo $row['c_id']; ?>').append(`<option value=1 selected> 10000</option>`);
								$('#tournament_prize_10_'+<?php echo $row['c_id']; ?>).val(1).change();
							}
						})
						$('#tournament_prize_11_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==2)
							{
								//$('#tournament_prize_11_<?php echo $row['c_id']; ?>').append(`<option value=2 selected> 5000</option>`);
								$('#tournament_prize_11_'+<?php echo $row['c_id']; ?>).val(2).change();
							}
						})
						$('#tournament_prize_12_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==3)
							{
								//$('#tournament_prize_12_<?php echo $row['c_id']; ?>').append(`<option value=3 selected> 3000</option>`);
								$('#tournament_prize_12_'+<?php echo $row['c_id']; ?>).val(3).change();
							}
						})
						$('#tournament_prize_13_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==4)
							{
								//$('#tournament_prize_13_<?php echo $row['c_id']; ?>').append(`<option value=4 selected> 2000</option>`);
								$('#tournament_prize_13_'+<?php echo $row['c_id']; ?>).val(4).change();
							}
						})
						$('#tournament_prize_14_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==8)
							{
								//$('#tournament_prize_14_<?php echo $row['c_id']; ?>').append(`<option value=8 selected> 500</option>`);
								$('#tournament_prize_14_'+<?php echo $row['c_id']; ?>).val(8).change();
							}
						})
						<?php } ?>
			});
		</script>
		<script>
			$(document).ready(function(){
				$('#tournament_section').change(function(){  
					changeType(<?php echo $row['c_id']; ?>);
					if(this.value==1){
						<?php foreach($country as $row){ ?>
						$('#tournament_fee_<?php echo $row['c_id']; ?>').val('0');
						$('#tournament_fee_<?php echo $row['c_id']; ?>').attr('disabled' , true);
						$('#tournament_prize_16_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==10)
							{
								//$('#tournament_prize_16_'+<?php echo $row['c_id']; ?>).append(`<option value=10 selected> 50</option>`);
								$('#tournament_prize_16_'+<?php echo $row['c_id']; ?>).val(10).change();
							}
						})
						<?php } ?>
					} else if(this.value==2){
						<?php foreach($country as $row){ ?>
						$('#tournament_fee_<?php echo $row['c_id']; ?>').val(3000);
						$('#tournament_fee_<?php echo $row['c_id']; ?>').removeAttr('disabled');
						$('#tournament_prize_10_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==1)
							{
								//$('#tournament_prize_10_<?php echo $row['c_id']; ?>').append(`<option value=1 selected> 10000</option>`);
								$('#tournament_prize_10_'+<?php echo $row['c_id']; ?>).val(1).change();
							}
						})
						$('#tournament_prize_11_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==2)
							{
								//$('#tournament_prize_11_<?php echo $row['c_id']; ?>').append(`<option value=2 selected> 5000</option>`);
								$('#tournament_prize_11_'+<?php echo $row['c_id']; ?>).val(2).change();
							}
						})
						$('#tournament_prize_12_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==3)
							{
								//$('#tournament_prize_12_<?php echo $row['c_id']; ?>').append(`<option value=3 selected> 3000</option>`);
								$('#tournament_prize_12_'+<?php echo $row['c_id']; ?>).val(3).change();
							}
						})
						$('#tournament_prize_13_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==4)
							{
								//$('#tournament_prize_13_<?php echo $row['c_id']; ?>').append(`<option value=4 selected> 2000</option>`);
								$('#tournament_prize_13_'+<?php echo $row['c_id']; ?>).val(4).change();
							}
						})
						$('#tournament_prize_14_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==8)
							{
								//$('#tournament_prize_14_<?php echo $row['c_id']; ?>').append(`<option value=8 selected> 500</option>`);
								$('#tournament_prize_14_'+<?php echo $row['c_id']; ?>).val(8).change();
							}
						})
						<?php } ?>
					
					} else {
						<?php foreach($country as $row){ ?>
						$('#tournament_fee_<?php echo $row['c_id']; ?>').val(1000);
						$('#tournament_fee_<?php echo $row['c_id']; ?>').removeAttr('disabled');
						$('#tournament_prize_10_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==5)
							{
								//$('#tournament_prize_10_<?php echo $row['c_id']; ?>').append(`<option value=5 selected> 1500</option>`);
								$('#tournament_prize_10_'+<?php echo $row['c_id']; ?>).val(5).change();
							}
						})
						$('#tournament_prize_11_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==6)
							{
								//$('#tournament_prize_11_<?php echo $row['c_id']; ?>').append(`<option value=6 selected> 1000</option>`);
								$('#tournament_prize_11_'+<?php echo $row['c_id']; ?>).val(6).change();
							}
						})
						$('#tournament_prize_12_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==7)
							{
								//$('#tournament_prize_12_<?php echo $row['c_id']; ?>').append(`<option value=7 selected> 800</option>`);
								$('#tournament_prize_12_'+<?php echo $row['c_id']; ?>).val(7).change();
							}
						})
						$('#tournament_prize_13_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==8)
							{
								//$('#tournament_prize_13_<?php echo $row['c_id']; ?>').append(`<option value=8 selected> 500</option>`);
								$('#tournament_prize_13_'+<?php echo $row['c_id']; ?>).val(8).change();
							}
						})
						$('#tournament_prize_15_<?php echo $row['c_id']; ?>').children().each((i,j)=>{
							if(j.value==9)
							{
								//$('#tournament_prize_15_<?php echo $row['c_id']; ?>').append(`<option value=9 selected> 100</option>`);
								$('#tournament_prize_15_'+<?php echo $row['c_id']; ?>).val(9).change();
							}
						})
						<?php } ?>
					}
				})
			})
		</script>
		<script>  
			$(function() {  
			  $('#tournament_start_time').datetimepicker();  
			});  
		</script>  
		
    </body>
</html>