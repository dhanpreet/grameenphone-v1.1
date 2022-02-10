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
                                        <li class="breadcrumb-item active" aria-current="page">Update Tournament</li>
                                    </ol>
                                </nav>
                                <h4 class="mb-1 mt-0">Update Tournament</h4>
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
						
						<form role="form" class="parsley-examples" action="<?php echo site_url('admin/processEditTournament/'.$tournament_id) ?>" method="post" enctype="multipart/form-data">
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
													<input type="text" class="form-control" name="tournament_name" id="tournament_name" value="<?php echo stripslashes(urldecode($tournamentInfo['tournament_name'])); ?>" required />
												</div>
											</div>
											
											<div class="col-md-6">
												<label for="tournament_type" class="col-md-12 col-form-label">Type <span class="text-danger">*</span></label>
												<div class="col-md-12">
													<input type="hidden" id="voucher" name="voucher">
													<select class="form-control" name="tournament_type" id="tournament_type" required >
															<option value="">Choose option</option>
															<option value="1" <?php  if($tournamentInfo['tournament_type'] == '1'){ echo "selected"; } ?> >Free</option>
															<option value="2" <?php  if($tournamentInfo['tournament_type'] == '2'){ echo "selected"; } ?>>Paid</option>
															<option value="3" <?php  if($tournamentInfo['tournament_type'] == '3'){ echo "selected"; } ?>>Contest</option>
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
																<option value="<?php echo $category['category_id']; ?>" <?php  if($tournamentInfo['tournament_category_id'] == $category['category_id']){ echo "selected"; } ?> > <?php echo $category['category_name']; ?> </option> 
															<?php } ?>
													</select>
                                                </div>
											</div>
											
											<div class="col-md-6">
												<label for="tournament_game_id" class="col-md-12 col-form-label">Game <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    <select class="form-control" name="tournament_game_id" id="tournament_game_id" required >
															<option value="">Choose Game</option> 
															<?php foreach($games as $game){ ?>
																<option value="<?php echo $game['gid']; ?>" <?php  if($tournamentInfo['tournament_game_id'] == $game['gid']){ echo "selected"; } ?> > <?php echo $game['Name']; ?> </option> 
															<?php } ?>
													</select>
                                                </div>
											</div>
										</div>
										
										<div class="form-group row">
											<div class="col-md-6">
												<label for="tournament_start_date" class="col-md-12 col-form-label">Start Time <span class="text-danger">*</span></label>
												<div class="row">
													<div class="col-md-6">
														<input type="date" class="form-control" name="tournament_start_date" id="tournament_start_date"  value="<?php echo date('Y-m-d', strtotime($tournamentInfo['tournament_start_date'])); ?>" required />
													</div>
													<div class="col-md-6">
														<input type="time" class="form-control" name="tournament_start_time" id="tournament_start_time"  value="<?php echo date('H:i', strtotime($tournamentInfo['tournament_start_time'])); ?>" required />
													</div>
												</div>
											</div>
											
											<div class="col-md-6">
												<label for="tournament_end_date" class="col-md-12 col-form-label">End Time <span class="text-danger">*</span></label>
												<div class="row">
													<div class="col-md-6">
														<input type="date" class="form-control" name="tournament_end_date" id="tournament_end_date"  value="<?php echo date('Y-m-d', strtotime($tournamentInfo['tournament_end_date'])); ?>"   required />
													</div>
													<div class="col-md-6">
														<input type="time" class="form-control" name="tournament_end_time" id="tournament_end_time" value="<?php echo date('H:i', strtotime($tournamentInfo['tournament_end_time'])); ?>" required />
													</div>
												</div>
											</div>
										</div>
											
										<div class="form-group row">
											
											<div class="col-md-6">
												<label for="tournament_section" class="col-md-12 col-form-label">Tournament Section Zone <span class="text-danger">*</span></label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_section" id="tournament_section" disabled required >
														<option value="">Choose option</option>
														<option value="2" <?php  if($tournamentInfo['tournament_section'] == 2){ echo "selected"; } ?>>Weekly Tournament (Premium)</option>
														<option value="3" <?php  if($tournamentInfo['tournament_section'] == 3){ echo "selected"; } ?>>Daily Tournament (Premium)</option>
														<option value="1" <?php  if($tournamentInfo['tournament_section'] == 1){ echo "selected"; } ?>>Free Tournament To Play</option>
													</select>
													<small id="section" >You cant change the tournamemt section.</small>
												</div>
											</div>
										
											<div class="col-md-6">
												<label for="tournament_desc" class="col-md-12 col-form-label">Description <span class="text-danger">*</span></label>
												<div class="col-md-12">
													<textarea class="form-control" name="tournament_desc" id="tournament_desc"  required ><?php echo stripslashes(urldecode(nl2br($tournamentInfo['tournament_desc']))); ?></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php 
						$count=0; 
						foreach($rewardInfo as $row){
						?>
						<div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-soft-primary ">
									 <h4 class="header-title mt-0 mb-1">Fee & Rewards Distribution <!-- <?php echo "For ".ucfirst($row['fee_country_name']); ?> --> </h4>
									</div>
                                    <div class="card-body">
									<input type="hidden" name="id[]" value="<?php echo $row['fee_id']; ?>">
									<input type="hidden" name="country_id[]" value="<?php echo $row['fee_country_id']; ?>">
                                       	<input type="hidden" name="country[]"  value="<?php echo $row['fee_country_name']; ?>">
										<div class="form-group row">
											<div class="col-md-4">
												<label for="tournament_fee_<?php echo $row['fee_id']; ?>" class="col-md-12 col-form-label">Fee (in Coins)<span class="text-danger">*</span></label>
												<div class="col-md-12">
													<input type="text" class="form-control" name="tournament_fee[]" id="tournament_fee_<?php echo $row['fee_id']; ?>" value="<?php echo $row['fee_tournament_fee']; ?>" required />
												</div>
											</div>
											
											<div class="col-md-4">
												<label for="tournament_reward_type_<?php echo $row['fee_id']; ?>" class="col-md-12 col-form-label">Reward Type <span class="text-danger">*</span></label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_reward_type[]" onchange="changeType(<?php echo $row['fee_id']; ?>)"  id="tournament_reward_type_<?php echo $row['fee_id']; ?>" required >
															<option value="">Choose option</option>
															<option value="1" <?php  if($tournamentInfo['tournament_reward_type'] == '1'){ echo 'selected'; } ?>>Coins</option>
															<option value="4" <?php  if($tournamentInfo['tournament_reward_type'] == '4'){ echo "selected"; } ?>>Voucher</option>
													</select>
												</div>
											</div>
										</div>
										
							
							
									<div id="voucherid">
										<div class="form-group row">
											<div class="col-md-4" id="v_1">
												<label for="tournament_prize_10_<?php echo $row['fee_id']; ?>" class="col-md-12 col-form-label">1st Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control prize_1" name="tournament_prize_1[]"  id="tournament_prize_10_<?php echo $row['fee_id']; ?>" required >
															<option value="">Choose option</option>

															<?php if(!empty($voucherListFirstPrize)){ 
																foreach ($voucherListFirstPrize as $list) {  ?>
																	<option <?php if($list['vt_id']==$row['fee_tournament_prize_1']){ echo "selected"; } ?> value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']; 	 ?></option>
																<?php }  ?>
															<?php }  else { ?>
																<?php 
																$vouchers_first = $this->ADMINDBAPI->getvoucherSectionsByCount(1); 
																if(is_array($vouchers_first) && count($vouchers_first)>0){
																	foreach ($vouchers_first as $firstRow) { ?>
																	<option value="<?php echo $firstRow['vt_id']; ?>"><?php echo $firstRow['vt_type']. " (Available: ".$firstRow['vt_balance_coupons'].")";   ?></option>
																<?php }
																}
																?>
															<?php }?>
															
													</select>
												</div>
											</div>
										
											<div class="col-md-4" id="v_2">
												<label for="tournament_prize_11_<?php echo $row['fee_id']; ?>" class="col-md-12 col-form-label">2nd Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control prize_2" name="tournament_prize_2[]"  id="tournament_prize_11_<?php echo $row['fee_id']; ?>" required >
															<option value="">Choose option</option>
															<?php if(!empty($voucherListsecondPrize)){ 
																foreach ($voucherListsecondPrize as $list) {  ?>
																	<option <?php if($list['vt_id']==$row['fee_tournament_prize_2']){ echo "selected"; } ?> value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']; ?></option>
																<?php }  ?>
															<?php }  else { ?>
																<?php 
																$vouchers_second = $this->ADMINDBAPI->getvoucherSectionsByCount(1); 
																if(is_array($vouchers_second) && count($vouchers_second)>0){
																	foreach ($vouchers_second as $secondRow) { ?>
																	<option value="<?php echo $secondRow['vt_id']; ?>"><?php echo $secondRow['vt_type']. " (Available: ".$secondRow['vt_balance_coupons'].")";   ?></option>
																<?php }
																}
																?>
															<?php }?>
													</select>
												</div>
											</div>
										
											<div class="col-md-4" id="v_3">
												<label for="tournament_prize_12_<?php echo $row['fee_id']; ?>" class="col-md-12 col-form-label">3rd Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control prize_3" name="tournament_prize_3[]"  id="tournament_prize_12_<?php echo $row['fee_id']; ?>" required >
															<option value="">Choose option</option>
															<?php if(!empty($voucherlistthirdPrize)){ 
																foreach ($voucherlistthirdPrize as $list) { ?>
																	<option <?php if($list['vt_id']==$row['fee_tournament_prize_3']){ echo "selected"; } ?> value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']; ?></option>
																<?php }  ?>
															<?php }  else { ?>
																<?php 
																$vouchers_third = $this->ADMINDBAPI->getvoucherSectionsByCount(1); 
																if(is_array($vouchers_third) && count($vouchers_third)>0){
																	foreach ($vouchers_third as $thirdRow) { ?>
																	<option value="<?php echo $thirdRow['vt_id']; ?>"><?php echo $thirdRow['vt_type']. " (Available: ".$thirdRow['vt_balance_coupons'].")";   ?></option>
																<?php }
																}
																?>
															<?php }?>
													</select>
												</div>
											</div>

											<div class="col-md-4" id="v_4t10">
												<label for="tournament_prize_13_<?php echo $row['fee_id']; ?>" class="col-md-12 col-form-label">4th to 10th Rank Prize (in Vouchers) </label>
												<div class="col-md-12">
													<select class="form-control prize_4" name="tournament_prize_4[]"  id="tournament_prize_13_<?php echo $row['fee_id']; ?>" required >
															<option value="">Choose option</option>
															<?php if(!empty($voucherlistfourthPrize)){ 
																foreach ($voucherlistfourthPrize as $list) { ?>
																	<option <?php if($list['vt_id']==$row['fee_tournament_prize_4']){ echo "selected"; } ?> value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']; ?></option>
																<?php }  ?>
															<?php }  else { ?>
																<?php 
																$vouchers_4to10 = $this->ADMINDBAPI->getvoucherSectionsByCount(7); 
																if(is_array($vouchers_4to10) && count($vouchers_4to10)>0){
																	foreach ($vouchers_4to10 as $forthRow) { ?>
																	<option value="<?php echo $forthRow['vt_id']; ?>"><?php echo $forthRow['vt_type']. " (Available: ".$forthRow['vt_balance_coupons'].")";   ?></option>
																<?php }
																}
																?>
															<?php }?>
													</select>
												</div>
											</div>

											<div class="col-md-4" id="v_11t50">
												<label for="tournament_prize_14_<?php echo $row['fee_id']; ?>" class="col-md-12 col-form-label">11th to 50th Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control prize_5" name="tournament_prize_5[]"  id="tournament_prize_14_<?php echo $row['fee_id']; ?>" required >
															<option value="">Choose option</option>
															<?php if(!empty($voucherlistfifthPrize)){ 
																foreach ($voucherlistfifthPrize as $list) {  ?>
																	<option <?php if($list['vt_id']==$row['fee_tournament_prize_5']){ echo "selected"; } ?> value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']; ?></option>
																<?php }  ?>
															<?php }  else { ?>
																<?php 
																$vouchers_11to50 = $this->ADMINDBAPI->getvoucherSectionsByCount(40); 
																if(is_array($vouchers_11to50) && count($vouchers_11to50)>0){
																	foreach ($vouchers_11to50 as $fortyRow) { ?>
																	<option value="<?php echo $fortyRow['vt_id']; ?>"><?php echo $fortyRow['vt_type']. " (Available: ".$fortyRow['vt_balance_coupons'].")";   ?></option>
																<?php }
																}
																?>
															<?php }?>
													</select>
												</div>
											</div>

											<div class="col-md-4" id="v_11t20">
												<label for="tournament_prize_15_<?php echo $row['fee_id']; ?>" class="col-md-12 col-form-label">11th to 20th Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control prize_2" name="tournament_prize_5[]"  id="tournament_prize_15_<?php echo $row['fee_id']; ?>" required >
															<option value="">Choose option</option>
															<?php if(!empty($voucherlistfifthPrize)){ 
																foreach ($voucherlistfifthPrize as $list) { ?>
																	<option <?php if($list['vt_id']==$row['fee_tournament_prize_5']){ echo "selected"; } ?> value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']; 	 ?></option>
																<?php }  ?>
															<?php }  else { ?>
																<?php 
																$vouchers_11to20 = $this->ADMINDBAPI->getvoucherSectionsByCount(10); 
																if(is_array($vouchers_11to20) && count($vouchers_11to20)>0){
																	foreach ($vouchers_11to20 as $fifthRow) { ?>
																	<option value="<?php echo $fifthRow['vt_id']; ?>"><?php echo $fifthRow['vt_type']. " (Available: ".$fifthRow['vt_balance_coupons'].")";   ?></option>
																<?php }
																}
																?>
															<?php }?>
													</select>
												</div>
											</div>

											<div class="col-md-4" id="v_1t10">
												<label for="tournament_prize_16_<?php echo $row['fee_id']; ?>" class="col-md-12 col-form-label">1st to 10th Rank Prize (in Vouchers)</label>
												<div class="col-md-12">
													<select class="form-control" name="tournament_prize_1[]"  id="tournament_prize_16_<?php echo $row['fee_id']; ?>" required >
															<option value="">Choose option</option>
															<?php if(!empty($voucherlistFree_day)){ ?>
																<?php foreach ($voucherlistFree_day as $list) {  ?>
																	<option <?php if($list['vt_id'] == $row['fee_tournament_prize_1']){ echo "selected"; } ?> value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']; ?></option>
																<?php }  ?>
															<?php }  else { ?>
																<?php 
																$freeVouchers = $this->ADMINDBAPI->getvoucherSectionsByCount(10); 
																if(is_array($freeVouchers) && count($freeVouchers)>0){
																	foreach ($freeVouchers as $list) { ?>
																	
																	<option value="<?php echo $list['vt_id']; ?>"><?php echo $list['vt_type']. " (Available: ".$list['vt_balance_coupons'].")";   ?></option>
													     
																	<?php }
																}
																
																?>
															
															<?php }?>
													</select>
												</div>
											</div>
										</div>
										
									</div>
								
										
                                       
                                    </div>
                                </div> <!-- end card -->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
						<?php $count++; } ?>
						
						
							
						<div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-soft-primary ">
									 <h4 class="header-title mt-0 mb-1">Update Banner</h4>
									</div>
                                    <div class="card-body">
                                       	
										<div class="form-group row">
											<label for="banner_location" class="col-md-4 col-form-label">Banner Page Location </label>
											<div class="col-md-6">
												<select class="form-control" name="banner_location" id="banner_location"  >
														<option value="">Choose Location</option> 
														<option value="1" <?php if($bannerInfo['banner_location'] == '1') { echo "selected"; } ?>>Home Page</option> 
														<option value="2" <?php if($bannerInfo['banner_location'] == '2') { echo "selected"; } ?>>Practice Zone Page</option> 
														
												</select>
											</div>
										</div>
										
										<div class="form-group row">
											<label for="banner_position" class="col-md-4 col-form-label">Banner Page Location </label>
											<div class="col-md-6">
												<select class="form-control" name="banner_position" id="banner_position"  >
														<option value="">Choose Position</option> 
														<option value="1" <?php if($bannerInfo['banner_position'] == '1') { echo "selected"; } ?>>Header</option> 
														<option value="2" <?php if($bannerInfo['banner_position'] == '2') { echo "selected"; } ?>>Footer</option> 
														
												</select>
											</div>
										</div>
										<?php if(!empty($bannerInfo['banner_image_path'])){ ?>
										<div class="form-group row">
											<?php if($bannerInfo['uploaded']==1){ ?>
											<label for="banner_image_path" class="col-md-4 col-form-label">Uploaded Image</label>
											<div class="col-md-5">
												<img src="<?php echo base_url() ?>uploads/tournaments-banners/<?php echo $bannerInfo['banner_image_path']; ?>" class="img-responsive" style="max-width:80%; border:2px solid #ccc; padding:3px; border-radius:5px;" />
											
											</div>
											<?php } ?>
											<?php if($bannerInfo['uploaded']==0){ ?>
											<label for="banner_image_path" class="col-md-4 col-form-label">Default Image</label>
											<div class="col-md-5">
												<img src="<?php echo base_url() ?>uploads/640X360/<?php echo $tournamentInfo['tournament_game_image']; ?>" class="img-responsive" style="max-width:80%; border:2px solid #ccc; padding:3px; border-radius:5px;" />	
											</div>
											<?php } ?>
										</div>
										
										<div class=" row"><div class="col-md-12"><br></div></div>
										<?php } ?>
										<div class="form-group row">
											<label for="banner_image_path" class="col-md-4 col-form-label">Upload New  Image   <br>  (Only if want to change the already uploaded image)</label>
											<div class="col-md-6">
												<input type="file"  name="banner_image_path" id="banner_image_path"  />
													
											</div>
										</div>
										
										<div class="form-group row">
										   <div class="col-md-12"> <br> </div>
										</div>
										
										<div class="form-group row">
											<div class="col-md-8 offset-md-4">
												<button id="submit" class="btn btn-primary btn-lg mr-1"> Save Tournament</button>
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
			$(document).ready(function()
			{
				var voucher ={}
				var voucherValue={}
				var id=<?php echo $rewardInfo[0]['fee_id'] ?>;
				<?php foreach($voucher as $list)
				{
				?>
				// var	voucher_<?php echo "_".$list['vt_id'] ?> ='<?php echo $list['vt_balance_coupons']; ?>';
				// console.log("voucher<?php echo '_'.$list['vt_id'];?> :- == "+voucher_<?php echo "_".$list['vt_id']; ?>)
				voucher['voucher<?php echo "_".$list['vt_id'] ?>']=parseInt('<?php echo $list['vt_balance_coupons']; ?>');
				<?php 
				}
				?>

				<?php foreach($voucher as $list)
				{
				?>
					voucherValue['<?php echo $list['vt_id'] ?>']=parseInt('<?php echo $list['vt_type']; ?>');
				<?php 
				}
				?>
				
				arrangeVoucher(voucher, id);
				//  To get previous value of tag after onchange
				$('#tournament_prize_10_'+id).on('focusin', function(){
					$(this).data('val', $(this).val());
					arrangeVoucher(voucher, id);
				});
				$('#tournament_prize_11_'+id).on('focusin', function(){
					$(this).data('val', $(this).val());
					arrangeVoucher(voucher, id);
				});
				$('#tournament_prize_12_'+id).on('focusin', function(){
					$(this).data('val', $(this).val());
					arrangeVoucher(voucher, id);
				});
				$('#tournament_prize_13_'+id).on('focusin', function(){
					$(this).data('val', $(this).val());
					arrangeVoucher(voucher, id);
				});
				$('#tournament_prize_14_'+id).on('focusin', function(){
					$(this).data('val', $(this).val());
					arrangeVoucher(voucher, id);
				});
				$('#tournament_prize_15_'+id).on('focusin', function(){
					$(this).data('val', $(this).val());
					arrangeVoucher(voucher, id);
				});
				$('#tournament_prize_16_'+id).on('focusin', function(){
					$(this).data('val', $(this).val());
					arrangeVoucher(voucher, id);
				});
				//  To get previous value of tag after onchange

				//  To Update The no of voucher
				$('#tournament_prize_10_'+id).change(function(){
					var value=1;
					var oldValue = $(this).data('val');
					var newValue=$(this).val();
					voucher['voucher_'+oldValue] = voucher['voucher_'+oldValue] +value;
					voucher['voucher_'+newValue] = voucher['voucher_'+newValue] -value;
					addVoucher(voucher ,id, oldValue, voucherValue , 'tournament_prize_10_'+id);
					arrangeVoucher(voucher, id);
				})

				$('#tournament_prize_11_'+id).change(function(){
					var value=1;
					var oldValue = $(this).data('val');
					var newValue=$(this).val();
					voucher['voucher_'+oldValue] = voucher['voucher_'+oldValue] +value;
					voucher['voucher_'+newValue] = voucher['voucher_'+newValue] -value;
					addVoucher(voucher ,id, oldValue, voucherValue , 'tournament_prize_11_'+id);
					arrangeVoucher(voucher, id);
				})

				$('#tournament_prize_12_'+id).change(function(){
					var value=1;
					var oldValue = $(this).data('val');
					var newValue=$(this).val();
					voucher['voucher_'+oldValue] = voucher['voucher_'+oldValue] +value;
					voucher['voucher_'+newValue] = voucher['voucher_'+newValue] -value;
					addVoucher(voucher ,id, oldValue, voucherValue , 'tournament_prize_12_'+id);
					arrangeVoucher(voucher, id);
				})
				$('#tournament_prize_13_'+id).change(function(){
					var value=7;
					var oldValue = $(this).data('val');
					var newValue=$(this).val();
					voucher['voucher_'+oldValue] = voucher['voucher_'+oldValue] +value;
					voucher['voucher_'+newValue] = voucher['voucher_'+newValue] -value;
					addVoucher(voucher ,id, oldValue, voucherValue , 'tournament_prize_13_'+id);
					// console.log(voucher)
					arrangeVoucher(voucher, id);
				})
				$('#tournament_prize_14_'+id).change(function(){
					var value=40;
					var oldValue = $(this).data('val');
					var newValue=$(this).val();
					voucher['voucher_'+oldValue] = voucher['voucher_'+oldValue] +value;
					voucher['voucher_'+newValue] = voucher['voucher_'+newValue] -value;
					addVoucher(voucher ,id, oldValue, voucherValue , 'tournament_prize_14_'+id);
					// console.log(voucher)
					arrangeVoucher(voucher, id);
				})
				$('#tournament_prize_15_'+id).change(function(){
					var value=10;
					var oldValue = $(this).data('val');
					var newValue=$(this).val();
					voucher['voucher_'+oldValue] = voucher['voucher_'+oldValue] +value;
					voucher['voucher_'+newValue] = voucher['voucher_'+newValue] -value;
					addVoucher(voucher ,id, oldValue, voucherValue, 'tournament_prize_15_'+id);
					// console.log(voucher)
					arrangeVoucher(voucher, id);
				})

				$('#tournament_prize_16_'+id).change(function(){
					var value=10;
					var oldValue = $(this).data('val');
					var newValue=$(this).val();
					voucher['voucher_'+oldValue] = voucher['voucher_'+oldValue] +value;
					voucher['voucher_'+newValue] = voucher['voucher_'+newValue] -value;
					addVoucher(voucher ,id, oldValue, voucherValue , 'tournament_prize_16_'+id);
					// console.log(voucher)
					arrangeVoucher(voucher, id);
				})

				$('#tournament_reward_type_'+id).change(function(){
					var reward_id = $(this).val();
					if(reward_id==1)
					{
						var newValue = $('#tournament_prize_10_'+id).val();
						var value = 1;
						$('#tournament_prize_10_'+id).val('');
						voucher['voucher_'+newValue] = voucher['voucher_'+newValue] +value;

						var newValue = $('#tournament_prize_11_'+id).val();
						var value = 1;
						$('#tournament_prize_11_'+id).val('');
						voucher['voucher_'+newValue] = voucher['voucher_'+newValue] +value;

						var newValue = $('#tournament_prize_12_'+id).val();
						var value = 1;
						$('#tournament_prize_12_'+id).val('');
						voucher['voucher_'+newValue] = voucher['voucher_'+newValue] +value;

						var newValue = $('#tournament_prize_13_'+id).val();
						var value = 7;
						$('#tournament_prize_13_'+id).val('');
						voucher['voucher_'+newValue] = voucher['voucher_'+newValue] +value;
						
						<?php if($tournamentInfo['tournament_section']==2){ ?>
							var newValue = $('#tournament_prize_14_'+id).val();
							var value = 40;
							$('#tournament_prize_14_'+id).val('');
							voucher['voucher_'+newValue] = voucher['voucher_'+newValue] +value;
						<?php } 
						else if($tournamentInfo['tournament_section']==3){ ?>
						var newValue = $('#tournament_prize_15_'+id).val();
						var value = 10;
						$('#tournament_prize_15_'+id).val('');					
						voucher['voucher_'+newValue] = voucher['voucher_'+newValue] +value;
						<?php } else {?>
							var newValue = $('#tournament_prize_16_'+id).val();
							var value = 10;
							$('#tournament_prize_16_'+id).val('');					
							voucher['voucher_'+newValue] = voucher['voucher_'+newValue] +value;
						<?php } ?>
						arrangeVoucher(voucher , id);
					}
				})
				// End Update Voucher

				//  To Arrange Voucher
				// $('#tournament_prize_10_'+id).click(function(){
				// 	var value = 1;
				// 	var tagId =$(this).attr('id');
				// 	var havingValue= $(this).data('val');
				// 	var newValue=$(this).val();
				// 	arrangeVoucher(voucher , id, value , tagId,havingValue);
				// })

				// $('#tournament_prize_11_'+id).click(function(){
				// 	var value = 1;
				// 	var tagId =$(this).attr('id');
				// 	var havingValue= $(this).data('val');
				// 	var newValue=$(this).val();
				// 	arrangeVoucher(voucher , id, value , tagId,havingValue,newValue);
				// })

				// $('#tournament_prize_12_'+id).click(function(){
				// 	var value = 1;
				// 	var tagId =$(this).attr('id');
				// 	var havingValue= $(this).data('val');
				// 	var newValue=$(this).val();
				// 	arrangeVoucher(voucher , id, value , tagId,havingValue,newValue);
				// })

				// $('#tournament_prize_13_'+id).click(function(){
				// 	var value = 7;
				// 	var tagId =$(this).attr('id');
				// 	var havingValue= $(this).data('val');
				// 	var newValue=$(this).val();
				// 	arrangeVoucher(voucher , id, value , tagId,havingValue,newValue);
				// })

				// $('#tournament_prize_14_'+id).click(function(){
				// 	var value = 40;
				// 	var tagId =$(this).attr('id');
				// 	var havingValue= $(this).data('val');
					
				// 	// alert(havingValue);
				// 	var newValue=$(this).val();
				// 	arrangeVoucher(voucher , id, value , tagId,havingValue,newValue);
				// })

				// $('#tournament_prize_15_'+id).click(function(){
				// 	var value = 10;
				// 	var tagId =$(this).attr('id');
				// 	var havingValue= $(this).data('val');
					
				// 	var newValue=$(this).val();
				// 	arrangeVoucher(voucher , id, value , tagId,havingValue,newValue);
				// })
				//  End Arrange Voucher

			})
		</script>
		<script>
			function addVoucher(voucher , id , releaseId , voucherValue , prizeId)
			{
				if(prizeId != 'tournament_prize_10_'+id)
				{
					var havingValue=false;
					$('#tournament_prize_10_'+id).children().each((i,j)=>{
						console.log(j);
						if(j.value==releaseId)
						{
							havingValue= true;
						}
					})
					if(!havingValue)
						$('#tournament_prize_10_'+id).append(`<option value=${releaseId} > ${voucherValue[releaseId]}</option>`);
				}
				
				if(prizeId != 'tournament_prize_11_'+id)
				{
					var havingValue=false;
					$('#tournament_prize_11_'+id).children().each((i,j)=>{
						if(j.value==releaseId)
						{
							havingValue= true;
						}
					})
					if(!havingValue)
						$('#tournament_prize_11_'+id).append(`<option value=${releaseId} > ${voucherValue[releaseId]}</option>`);
				}

				if(prizeId != 'tournament_prize_12_'+id)
				{
					var havingValue=false;
					$('#tournament_prize_12_'+id).children().each((i,j)=>{
						if(j.value==releaseId)
						{
							havingValue= true;
						}
					})
					if(!havingValue)
						$('#tournament_prize_12_'+id).append(`<option value=${releaseId} > ${voucherValue[releaseId]}</option>`);
				}

				if(prizeId != 'tournament_prize_13_'+id)
				{
					var havingValue=false;
					$('#tournament_prize_13_'+id).children().each((i,j)=>{
						if(j.value==releaseId)
						{
							havingValue= true;
						}
					})
					if(!havingValue)
						$('#tournament_prize_13_'+id).append(`<option value=${releaseId} > ${voucherValue[releaseId]}</option>`);
				}

				if(prizeId != 'tournament_prize_14_'+id)
				{
					var havingValue=false;
					$('#tournament_prize_14_'+id).children().each((i,j)=>{
						if(j.value==releaseId)
						{
							havingValue= true;
						}
					})
					if(!havingValue)
						$('#tournament_prize_14_'+id).append(`<option value=${releaseId} > ${voucherValue[releaseId]}</option>`);
				}

				if(prizeId != 'tournament_prize_15_'+id)
				{
					var havingValue=false;
					$('#tournament_prize_15_'+id).children().each((i,j)=>{
						if(j.value==releaseId)
						{
							havingValue= true;
						}
					})
					if(!havingValue)
						$('#tournament_prize_15_'+id).append(`<option value=${releaseId} > ${voucherValue[releaseId]}</option>`);	
				}

				if(prizeId != 'tournament_prize_16_'+id)
				{
					var havingValue=false;
					$('#tournament_prize_16_'+id).children().each((i,j)=>{
						if(j.value==releaseId)
						{
							havingValue= true;
						}
					})
					if(!havingValue)
						$('#tournament_prize_16_'+id).append(`<option value=${releaseId} > ${voucherValue[releaseId]}</option>`);				
				}
			}
		</script>
		<!-- <script>
			function arrangeVoucher(voucher , id, value , tagId,havingValue , newValue)
			{
				$('#'+tagId).children().each((i,j, k)=>{
					if(voucher['voucher_'+j.value]<value)
					{
						if(j.value!= havingValue || j.value!= newValue)
						{
							j.remove();
						}
					}
					
				});
				console.log(voucher);
			}
		</script> -->
		<script>
			function arrangeVoucher(voucher, id)
			{
				var first = $('#tournament_prize_10_'+id).val();
				var second = $('#tournament_prize_11_'+id).val();
				var third = $('#tournament_prize_12_'+id).val();
				var fourth = $('#tournament_prize_13_'+id).val();
				var fifth = $('#tournament_prize_14_'+id).val();
				var sixth = $('#tournament_prize_15_'+id).val();
				var seventh = $('#tournament_prize_16_'+id).val();
				$('#tournament_prize_10_'+id).children().each((i,j, k)=>{
					if(voucher['voucher_'+j.value]==0)
					{
						if(j.value!= first)
							j.remove();
					}
				});
				$('#tournament_prize_11_'+id).children().each((i,j, k)=>{
					if(voucher['voucher_'+j.value]==0)
					{
						if(j.value!= second)
						j.remove();
					}
				});
				$('#tournament_prize_12_'+id).children().each((i,j, k)=>{
					if(voucher['voucher_'+j.value]==0)
					{
						if(j.value!= third)
						j.remove();
					}
				});
				$('#tournament_prize_13_'+id).children().each((i,j, k)=>{
					if(voucher['voucher_'+j.value]< 7)
					{
						if(j.value!= fourth)
						j.remove();
					}
				});
				$('#tournament_prize_14_'+id).children().each((i,j, k)=>{
					if(voucher['voucher_'+j.value]< 40)
					{
						if(j.value!= fifth)
						j.remove();
					}
				});
				$('#tournament_prize_15_'+id).children().each((i,j, k)=>{
					if(voucher['voucher_'+j.value]< 10)
					{
						if(j.value!= sixth)
						j.remove();
					}
				});
				$('#tournament_prize_16_'+id).children().each((i,j, k)=>{
					if(voucher['voucher_'+j.value]< 10)
					{
						if(j.value!=seventh )
						j.remove();
					}
				});
				
				$('#voucher').val(JSON.stringify(voucher));
			}
		</script>
		<script>
		$(document).ready(function()
		{
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
           
       $(document).ready(function(){
       
			<?php foreach($rewardInfo as $row){ ?>
				changeType(<?php echo $row['fee_id']; ?>);
			<?php } ?>
			
			$('#tournament_section').change(function(){
				var feeid = "<?php echo $row['fee_id']; ?>";
				changeType(feeid);
				
				if($(this).val()==1){
					<?php foreach($country as $row){ ?>
					$('#tournament_fee_'+feeid).val('0');
					$('#tournament_fee_'+feeid).attr('disabled' , true);
					<?php } ?>
				} else {
					<?php foreach($country as $row){ ?>
					$('#tournament_fee_'+feeid).val('');
					$('#tournament_fee_'+feeid).removeAttr('disabled');
					<?php } ?>
				}
			});

       });
	   
		function changeType(id){
			// $("#tournament_reward_type_"+id).change(function(){
				var type = $("#tournament_reward_type_"+id).val();
				//alert(type)
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
				
				} else if(type== '4'){
					$("#novoucher").hide();
					$('#voucherid').show();
					for (var i = 1; i <=9; i++) {
						$('#tournament_prize_'+i+3).removeAttr('required');
					}
					var t_sec = $('#tournament_section').val();

						if(t_sec=='1'){
							
							//alert('tournament_prize_16_'+id);
							
							$('#v_1').hide();
							$('#tournament_prize_10_'+id).removeAttr('required');
							$('#v_2').hide();
							$('#tournament_prize_11_'+id).removeAttr('required');
							$('#v_3').hide();
							$('#tournament_prize_12_'+id).removeAttr('required');
							$('#v_4t10').hide();
							$('#tournament_prize_13_'+id).removeAttr('required');
							$('#v_11t50').hide();
							$('#tournament_prize_14_'+id).removeAttr('required');
							$('#v_11t20').hide();
							$('#tournament_prize_15_'+id).removeAttr('required');
							$('#v_1t10').show();

							$('#tournament_prize_16_'+id).attr("required", true);
							//$('#tournament_prize_2_'+id).removeAttr('required');
							//$('#tournament_prize_3_'+id).removeAttr('required');

						}else if(t_sec=='3'){
                            $('#v_1').show();
							$('#v_2').show();
							$('#v_3').show();
							$('#v_4t10').show();
							$('#v_11t50').hide();
							$('#tournament_prize_14_'+id).removeAttr('required');
							$('#v_11t20').show();
							$('#v_1t10').hide();
							$('#tournament_prize_16_'+id).removeAttr('required');

							$('#tournament_prize_10_'+id).attr("required", true);
							$('#tournament_prize_11_'+id).attr("required", true);
							$('#tournament_prize_12_'+id).attr("required", true);
							$('#tournament_prize_13_'+id).attr("required", true);
							$('#tournament_prize_15_'+id).attr("required", true);
						}else{
                            $('#v_1').show();
							$('#v_2').show();
							$('#v_3').show();
							$('#v_4t10').show();
							$('#v_11t50').show();
							$('#v_11t20').hide();
							$('#tournament_prize_15_'+id).removeAttr('required');
							$('#v_1t10').hide();
							$('#tournament_prize_16_'+id).removeAttr('required');

							$('#tournament_prize_10_'+id).attr("required", true);
							$('#tournament_prize_11_'+id).attr("required", true);
							$('#tournament_prize_12_'+id).attr("required", true);
							$('#tournament_prize_13_'+id).attr("required", true);
							$('#tournament_prize_14_'+id).attr("required", true);
						}

					
				} else {
					$('.reward_type'+id).empty();
					$('.reward_type'+id).append('Coins');
				}
			// });
		}
		</script>
    </body>
</html>