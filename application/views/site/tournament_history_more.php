<?php foreach($tournamentsList as $tRow ){ ?>
				
				<?php 
					$today = time();
					$startDate = $tRow['tournament_start_date']." ".$tRow['tournament_start_time'].":00";
					$startDate = strtotime($startDate);

					$endDate = $tRow['tournament_end_date']." ".$tRow['tournament_end_time'].":00";
					$endDate = strtotime($endDate);

					$t_current_status = 0;     //1=CurrentlyWorking   2=Expired   3=futureTournament
					if($startDate > $today){
						$t_current_status = 3;
					} else if($endDate < $today){
						$t_current_status = 2;
					} else if($startDate <= $today && $endDate >= $today){
						$t_current_status = 1;
					}
				?>
				
					<div class="row <?php if($tRow['redeem_prize'] == 1){ echo "light-side-full"; } else { echo "dark-side-v2"; } ?> module">
						<?php  if($t_current_status == 1) { ?>
							<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right"> 
								<h5 class="text-danger blink_me"><i class="fa fa-play"></i> Live </h5>
							</div>
						<?php }  else { echo "<br>"; }  ?>
					
						
							<div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left " style="padding:5px;">
								
								<img class="img-responsive " style="padding:3px; border:2px solid #ccc; border-radius:10px; " src="<?php echo base_url('uploads/games/'.$tRow['tournament_game_image']) ?>" />
							</div>
							
							<div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 text-left ">
								<?php if($tRow['player_reward_rank'] >0){ ?>
									<?php if($tRow['redeem_prize'] == '2'){ ?>
										 <span class="ribbon1"><span style="font-size:1.15em;">Claimed </span></span>
									<?php }elseif($tRow['redeem_prize'] == '1'){ ?>
										<span class="ribbon-red"><span style="font-size:1.15em;">Expired </span></span>
									<?php } ?>
								<?php } ?>
									
								
								<h4 class="text-bold text-dark" style="margin-top:5px !important;" > <?php echo $tRow['tournament_game_name']; ?></h4>
								<p class="text-dark">
								
									<i class="fa fa-calendar-alt"></i> &nbsp;
									<?php echo date('j M', strtotime($tRow['tournament_start_date'])); ?> 
									<?php if($tRow['tournament_start_date'] != $tRow['tournament_end_date']) { ?>
									- <?php echo date('j M', strtotime($tRow['tournament_end_date'])); ?>
									<?php } ?>
									
								<br>	
									<i class="fa fa-clock"></i> &nbsp; 
										<?php echo date('h:i A', strtotime($tRow['tournament_start_time'])); ?> 
										- <?php echo date('h:i A', strtotime($tRow['tournament_end_time'])); ?> 
								</p>
								
								<div class="row">
									<div class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3 text-left">
										<p class="text-dark"><i class="label-text">Rank</i> <br><b>#<?php echo $tRow['player_reward_rank']; ?></b>
									</div>
									<div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left">
										<p class="text-dark"><i class="label-text">Prize</i> </br>
										<?php if($tRow['player_reward_rank'] >0){ ?>
										<b> Daraz voucher of ৳ <?php echo number_format($tRow['player_reward_prize'], 0); ?></b>
										<?php } else { ?>
											NA
										<?php } ?>
									</div>
								</div>
							
							</div>
							
							<?php if($tRow['player_reward_rank'] >0){ ?>
							<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="">
                                <?php if($tRow['redeem_prize'] == '0' && date('Y-m-d',strtotime($tRow['redeem_expiry_date'])) >= date('Y-m-d')){ ?>
									<a id="<?php  echo $tRow['prize_voucher_id']."/".$tRow['player_id']; ?>" class="btn btn-filled redeemclass">Claim &nbsp;<i class="fa fa-angle-right"></i></a>
									<br><br>
								<?php } else if($tRow['redeem_prize'] == '2' && date('Y-m-d',strtotime($tRow['redeem_expiry_date'])) >= date('Y-m-d')){ ?>
									 <a id="<?php  echo $tRow['prize_voucher_id']."/".$tRow['player_id']; ?>" class="btn btn-filled redeemclass" >Claimed on <?php echo date('F j, Y', strtotime($tRow['prize_claimed_date'])); ?> &nbsp;</a>
									<br><br>
									
								<?php }else{ ?>
                                       <p><i>This prize reward voucher  is no longer available after <?php echo date('F j, Y', strtotime($tRow['redeem_expiry_date'])); ?></i></p>
									<br>
									
								<?php } ?>
							</div>
							<?php } ?>
							
					</div>
				<div class="row"> <br><br> </div>
				<?php } ?>