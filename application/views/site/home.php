<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="theme-color" content="#000" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, minimal-ui" />
    
	<title>Gaming Social League</title> 
	<meta name="description" content="Play your private battles with Friends & Family!">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Gaming Social League" />
	<meta property="og:title" content="Gaming Social League">
	<meta property="og:url" content="https://playpt.igpl.pro">
	<meta property="og:description" content="Play your private battles with Friends & Family!">
	<meta property="og:image" content="<?php echo base_url() ?>assets/frontend/img/gpl.png" />
	<meta content="<?php echo base_url() ?>assets/frontend/img/gpl.png" property="thumbnail" />
	
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/bootstrap.min.css">
	<script src="<?php echo base_url() ?>assets/frontend/js/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/frontend/js/bootstrap.min.js"></script>
	
	<!-- For fontawesome icons -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/fontawesome-5.15.1/css/all.css" rel="stylesheet">
	
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/css/style_theme_2.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/css/home.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/css/fireworks.css">
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/css/slick.css">
	<script type="text/javascript" src="<?php echo base_url() ?>assets/frontend/js/slick.js"></script>
	
	
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/glider/glider.css" />
  
	<script src="<?php echo base_url() ?>assets/frontend/glider/glider.js"></script>
	<script>
      window.addEventListener('load',function(){
        
		window._ = new Glider(document.querySelector('.glider-2'), {
            slidesToShow: 1.3, //'auto',
            slidesToScroll: 1,
            itemWidth: 150,
            draggable: true,
            scrollLock: false,
            dots: '#dots',
            rewind: true,
            arrows: false,
            responsive: [
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2.1, 
                    }
                },
             ]
           
        });
       
       
      });
    </script>
	
	
	
	<style type="text/css">
		.slide-menu.glider.draggable {
			position: fixed;
			bottom: 0;
			background: #202123;
			z-index: 1;
			border-top: 1px solid #4a4a4a;
			padding: 10px 0px;
		}
    </style>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.4/jquery.lazy.min.js"></script>

	
</head>
<body>
<div id="load"></div>

	<!-- Header-Content -->
		<?php include "header.php"; ?>
	<!-- Header Content End -->

	<!-- Sidebar-Content -->
		<?php include "sidebar.php"; ?>
	<!-- Sidebar Content End -->

<section class="main-wrapper" align="center"><br>

<div class="container">
<br><br>



<?php if ($this->vipTournamentEnabled == 1 && is_array($vipTournaments) && count(@$vipTournaments) == 0){ ?>
<div class="row text-left"> <h5 class="text-bold theme-color" style="font-size:1.25em;">&nbsp;&nbsp; Tournament of the week (Premium)</h5></div>
<div class="row text-left">
	<div id="hero-tournaments-slider" class="col-12 slider hero-tournaments-slider ">
		<img class="lazy" src="<?php echo base_url('uploads/banner-weekly.gif') ?>" /> 
			 
	 </div>
</div>
<?php }  ?>
		
	
<?php if ($this->vipTournamentEnabled == 1 && is_array($vipTournaments) && count(@$vipTournaments) > 0){ ?>
	<div class="row text-left"> <h5 class="text-bold theme-color" style="font-size:1.25em;">&nbsp;&nbsp; Tournament of the week (Premium)</h5> <br></div>
	<div class="row text-left">
		<div id="hero-tournaments-slider" class="col-12 slider hero-tournaments-slider ">
			<?php $count = 0; ?>	
			<?php foreach ($vipTournaments as $heroRow){ ?>			
				<a aria-hidden="false" class="vipclick" href="<?php echo site_url('LiveTournament/' . base64_encode($heroRow['tournament_id'])) ?>">
					<?php if ($heroRow['uploaded'] == 1){ ?>
					  <img class="lazy" src="<?php echo base_url('uploads/tournaments-banners/' . $heroRow['banner_image_path']) ?>" /> 
					<?php } else { ?>
					   <img class="lazy" src="<?php echo base_url('uploads/640X360/' . $heroRow['tournament_gameboost_id'] . '.jpg'); ?>" />
					<?php } ?>

					<div class="row">
						<div class="col-xs-5">
						   <div class="live-ticker col-8"><span class="blink_me">LIVE</span></div>
						</div>
						<div class="col-xs-7">
						   <div data-countdown="<?php echo date('Y-m-d', strtotime($heroRow['tournament_end_date'])) ?> <?php echo $heroRow['tournament_end_time'] . ":59"; ?>" class="time-ticker" id="st-timer-<?php echo $heroRow['tournament_id']; ?>"> 
						   </div>
						</div>
					</div>
					<?php if($heroRow['fee_tournament_rewards']==4){ ?>	
					<div class="row bottom-ticker">
						<div class="col-xs-12">
							<h5 class="text-white text-left" style="text-align: center;margin-left:-5px;">Win Daraz Voucher worth 
							<span style="font-size:1.1em;">৳ <?php echo number_format($heroRow['voucherPrize'], 0); ?></span></h5>
						</div>								
					</div>	
					<?php } ?>
				</a>	
		</div>
				<div class="row" style="width:98%;    margin: -35px 0px 0px 0px; text-align:center;">   
					<h5 class=" btn btn-outline-green text-center" style="width:inherit !important;">
					<?php if ($heroRow['joinedStatus']){ ?>
						 <b >Current Rank #<?php echo $heroRow['myRank']; ?></b>  
					<?php } else { ?>
						Entry <img src="<?php echo base_url() ?>assets/frontend/img/gold-coins.png" style="width:18px; display:inline; margin-top:-3px;"><span style="font-size:1em;"><b> <?php echo number_format($heroRow['fee_tournament_fee'], 0); ?> Coins</b></span>
					<?php } ?>
					</h5>
				</div>
			<?php $count++; ?>
		<?php } ?>
		
	</div>
<br>

<?php }   ?>


<?php if ($this->payAndPlayTournamentEnabled == 1 && is_array($payAndPlayTournaments) && count(@$payAndPlayTournaments) > 0){ ?>
	<div class="row text-left"> <h5 class="text-bold theme-color" style="font-size:1.25em;">&nbsp;&nbsp; Tournament of the day (Premium)</h5> <br></div>
	<div class="row text-left">
		<div id="day-tournaments-slider" class="col-12 slider hero-tournaments-slider">
		<?php $count = 0; ?>
		<?php foreach ($payAndPlayTournaments as $dayRow){ ?>			
			<a aria-hidden="false" class="Payplayclick" href="<?php echo site_url('LiveTournament/' . base64_encode($dayRow['tournament_id'])) ?>">
				<img  class="lazy" src="<?php echo base_url('uploads/640X360/' . $dayRow['tournament_gameboost_id'] . '.jpg') ?>" /> 
				<div class="row">
					<div class="col-xs-5">
						<div class="live-ticker col-8"><span class="blink_me">LIVE</span></div>
					</div>
					<div class="col-xs-7">
						<div data-countdown="<?php echo date('Y-m-d', strtotime($dayRow['tournament_end_date'])) ?> <?php echo $dayRow['tournament_end_time'] . ":59"; ?>" class="time-ticker" id="st-timer-<?php echo $dayRow['tournament_id']; ?>"> </div>
					</div>
				</div>
				<?php if($dayRow['fee_tournament_rewards']==4){ ?>
					<div class="row bottom-ticker">
						<div class="col-xs-12">
						<h5 class="text-white text-left" style="margin-left:-5px;text-align: center;">Win Daraz Voucher worth 
						<span style="font-size:1.1em;">৳ <?php echo number_format($dayRow['voucherPrize'], 0); ?></span></h5>
						</div>
						
					</div>
				<?php } ?>
			</a>
		</div>
			<div class="row" style="width:98%;    margin: -35px 0px 0px 0px; text-align:center;">   
				<h5 class=" btn btn-outline-green text-center" style="width:inherit !important;">
				<?php if ($dayRow['joinedStatus']){ ?>
					<b >Current Rank #<?php echo $dayRow['myRank']; ?></b>  
				<?php } else { ?>
					Entry <img src="<?php echo base_url() ?>assets/frontend/img/gold-coins.png" style="width:18px; display:inline; margin-top:-3px;"><span style="font-size:1em;"><b> <?php echo number_format($dayRow['fee_tournament_fee'], 0); ?> Coins</b></span>
				<?php } ?>
				</h5>
			</div>
		<?php $count++; ?>
		<?php  } ?>
	</div>
	<br>
<?php  } ?>
	
	
<?php   if ($this->freeTournamentEnabled == 1 && is_array($freeTournaments) && count(@$freeTournaments) > 0){ ?>
	<div class="row text-left"> <h5 class="text-bold theme-color" style="font-size:1.25em;">&nbsp;&nbsp; Free tournament to play</h5> <br></div>
	<div class="row text-left">
		<div id="free-tournaments-slider" class="col-12 slider ">
		
			<?php $count = 0; ?>	
			<?php foreach ($freeTournaments as $heroRow){ ?>		
				<a aria-hidden="false" class="freeclick" href="<?php echo site_url('LiveTournament/' . base64_encode($heroRow['tournament_id'])) ?>">
					<img  class="lazy" style="border-radius:0 !important; border-top-left-radius:10px !important; border-top-right-radius:10px !important; " src="<?php echo base_url('uploads/640X360/' . $heroRow['tournament_gameboost_id'] . '.jpg') ?>" /> 
					
					<div class="row">
						<div class="col-xs-5">
							<div class="live-ticker col-8"><span class="blink_me">LIVE</span></div>
						</div>
						<div class="col-xs-7">
							<div data-countdown="<?php echo date('Y-m-d', strtotime($heroRow['tournament_end_date'])) ?> <?php echo $heroRow['tournament_end_time'] . ":59"; ?>" class="time-ticker" id="st-timer-<?php echo $heroRow['tournament_id']; ?>"> </div>
						</div>
					</div>	
				
					<div class="row" style="width:98%;  margin:0 auto; margin-top:-35px; background: #2c2c2c; border-bottom-right-radius: 10px;  border-bottom-left-radius: 10px;">   
						<?php if($heroRow['fee_tournament_rewards']==4){ ?>
						<div class="col-xs-6">
							<h5 class="text-white text-left" style="margin-left:-5px; line-height:20px; font-size:0.85em;">Win Daraz Voucher worth <br>
							<span style="font-size:1.50em;">৳ <?php echo number_format($heroRow['voucherPrize'], 0); ?></span></h5>
						</div>
						<?php } ?>
						
						<div class="col-xs-6">	
							<h5 class=" text-right" style="line-height:20px; color: #3fff48;">
								<?php if ($heroRow['joinedStatus']){ ?>
									<b>Current Rank #<?php echo $heroRow['myRank']; ?></b>  
								<?php  } else { ?>
									Join For Free</b></span>
								<?php } ?>
							</h5>
						</div>
					</div>
				</a>
			<?php $count++; ?>
			<?php } ?>	
		</div>
	</div>
<?php }  ?>


<?php if ($this->payAndPlayTournamentEnabled == 1 && is_array($payAndPlayTournaments) && count(@$payAndPlayTournaments) == 0){ ?>
	<div class="row text-left"> <h5 class="text-bold theme-color" style="font-size:1.25em;">&nbsp;&nbsp; Tournament of the day (Premium)</h5></div>
	<div class="row text-left">
		<div id="hero-tournaments-slider" class="col-12 slider hero-tournaments-slider ">
			<img class="lazy" src="<?php echo base_url('uploads/banner-daily.gif') ?>" /> 
				 
		 </div>
	</div>
<?php } ?>		
		
		
	<br>			
	<div class="row text-left"><h5 class="text-bold  theme-color"  style="font-size:1.25em;">&nbsp;&nbsp;&nbsp;&nbsp;  Free games to play</h5> </div>
			
	<div class="row" style="margin-bottom:50px !important;"><br>
		<div class="glider-contain">
			<div class="glider-2">
				<div>
					<?php foreach ($arcadeGames as $rowArcade){ ?>
						<a class="freegames2 free-games-click" data-href="<?php echo site_url('playGame/' . base64_encode($rowArcade['id'])); ?>" data-id="<?php echo @$rowArcade['gid']; ?>">
						<div class="row thumbnails">
							<div class="col-xs-3"><img class="lazy thumb-img" src="<?php echo base_url('uploads/games/' . $rowArcade['ImageName']); ?>" ></div>
							<div class="col-xs-7 text-white text-left"><h3><?php echo $rowArcade['Name']; ?></h3><span class="head-desc">Arcade</span></div>
							<div class="col-xs-2"><i class="fa fa-play"></i></div>
						</div>
						</a>
					<?php } ?>
				</div>
				
				<div>
					<?php foreach ($actionGames as $rowAction){ ?>
						<a class="freegames1 free-games-click" data-href="<?php echo site_url('playGame/' . base64_encode($rowAction['id'])); ?>" data-id="<?php echo @$rowAction['gid']; ?>">
						<div class="row thumbnails">
							<div class="col-xs-3"><img class="lazy thumb-img" src="<?php echo base_url('uploads/games/' . $rowAction['ImageName']); ?>" ></div>
							<div class="col-xs-7 text-white text-left"><h3><?php echo $rowAction['Name']; ?></h3><span class="head-desc">Action</span></div>
							<div class="col-xs-2"><i class="fa fa-play"></i></div>
						</div>
						</a>
					<?php } ?>
				</div>
				
			
				<div>
					<?php foreach ($adventureGames as $rowAdventure){ ?>
						<a class="freegames3 free-games-click" data-href="<?php echo site_url('playGame/' . base64_encode($rowAdventure['id'])); ?>" data-id="<?php echo @$rowAdventure['gid']; ?>">
						<div class="row thumbnails">
							<div class="col-xs-3"><img class="lazy thumb-img" src="<?php echo base_url('uploads/games/' . $rowAdventure['ImageName']); ?>" ></div>
							<div class="col-xs-7 text-white text-left"><h3><?php echo $rowAdventure['Name']; ?></h3><span class="head-desc">Adventure</span></div>
							<div class="col-xs-2"><i class="fa fa-play"></i></div>
						</div>
						</a>
					<?php } ?>
				</div>
				
			
				<div>
					<?php foreach ($puzzleGames as $rowPuzzle){ ?>
						<a class="free-games-click"  data-href="<?php echo site_url('playGame/' . base64_encode($rowPuzzle['id'])); ?>" data-id="<?php echo @$rowPuzzle['gid']; ?>">
						<div class="row thumbnails">
							<div class="col-xs-3"><img class="lazy thumb-img" src="<?php echo base_url('uploads/games/' . $rowPuzzle['ImageName']); ?>" ></div>
							<div class="col-xs-7 text-white text-left"><h3><?php echo $rowPuzzle['Name']; ?></h3><span class="head-desc">Puzzle & Logic</span></div>
							<div class="col-xs-2"><i class="fa fa-play"></i></div>
						</div>
						</a>
					<?php } ?>
				</div>
				
				<div>
					<?php foreach ($sportsGames as $rowSports){ ?>
						<a class="free-games-click"  data-href="<?php echo site_url('playGame/' . base64_encode($rowSports['id'])); ?>" data-id="<?php echo @$rowSports['gid']; ?>">
						<div class="row thumbnails">
							<div class="col-xs-3"><img class="lazy thumb-img" src="<?php echo base_url('uploads/games/' . $rowSports['ImageName']); ?>" ></div>
							<div class="col-xs-7 text-white text-left"><h3><?php echo $rowSports['Name']; ?></h3><span class="head-desc">Sports & Racing</span></div>
							<div class="col-xs-2"><i class="fa fa-play"></i></div>
						</div>
						</a>
					<?php } ?>
				</div>
				
				
				
			</div>
		</div>
	</div>
		
	<div class="row"> 
		<div class="col-xs-12 col-sm-12 col-md-12 text-left theme-color"><br><br></div>
	</div>
		
	</div>
</section>


<!-- Footer-Content -->
	<?php include "footer.php"; ?>
<!-- Footer Content End -->


 
  
<div class="modal fade" id="successModal" role="dialog">
    <div class="modal-dialog box-center">
      <div class="modal-content modal-bg  modal-bg-success" align="center">
        
        <div class="modal-body">
          <img src="<?php echo base_url('assets/frontend/img/happy-face.png') ?>" />
          <br>
		  <h4 class="text-white"> <b> Success! </b></h4>
          <p class="text-white"><?php echo @$this->session->flashdata('success') ?></p>
		  <br><br>
		  <button type="button" class="btn modal-btn-dark" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
 

 
<div class="modal fade" id="errorModal" role="dialog">
    <div class="modal-dialog box-center">
      <div class="modal-content modal-bg  modal-bg-error" align="center">
      
        <div class="modal-body">
           <img src="<?php echo base_url('assets/frontend/img/sad-face.png') ?>" />
          <br>
		  <h4> <b> OOPS ! </b></h4>
          <p><?php echo @$this->session->flashdata('error') ?></p>
		   <br><br>
		  <button type="button" class="btn modal-btn-dark" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
  
 
  

<div class="modal fade " id="name_update"  style="width:90%; margin-top:20% !important; " tabindex="-1" role="dialog" aria-labelledby="example" aria-hidden="true" >
	<div class="modal-dialog" >
		<div class="modal-content"  style=" border-radius: 10px 10px 10px 10px; background: #202125 !important;">
			<div class="modal-body">
				<div class="row ">
					<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
				
						<h4 class="text-white" >Tell us about yourself </h4><br>

						<form action="<?php echo site_url('site/updateusername') ?>" method="post" autocomplete="none">
						
							<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
							 <div class="input-group" style="    margin: 20px;">
								<span class="input-group-addon" style="    border-top-left-radius: 20px !important;border-bottom-left-radius: 20px !important;"><i class="fa fa-user"></i></span>
								<input  type="text" name="user_name" class="form-control" style="    height: 45px !important;background: rgb(238,238,238) !important;border: 1px solid #cecece !important;border-top-right-radius: 20px !important;border-bottom-right-radius: 20px !important;" placeholder="Enter your name..."  autocomplete="none" required /><br>
							 </div>
							</div>
                            <?php 
								if (isset($_GET['token'])){
									$token = $_GET['token'];
								} elseif ($this->uri->segment(2) != ''){
									$token = $this->uri->segment(2);
								} else{
									$token = $this->uri->segment(3);
								} 
							?>
							<input type="hidden" name="token" value="<?php echo $token; ?>">
							
							<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
							
							<br>
							 <button type="submit" class="text-btn2 text-white text-bold" style="background: #48ff48 !important;">Submit</button>
						   </div>
						   
						   
						    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
								 <br>
							 </div>
							 
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	

<?php $rewardsUnseen = $this->unseenTournamentsResults; ?>
<?php if(is_array($rewardsUnseen) && count($rewardsUnseen)>0){ ?>
<div class="modal fade" id="rewardsUnseenModal" role="dialog" style="width:100%; margin-top:50px !important; ">
    <div class="modal-dialog box-center ">
      <!-- Modal content-->
       <div class="modal-content modal-bg " align="center" style=" border-radius: 10px 10px 10px 10px; background: #202125 !important;">

        <div class="modal-body pyro">
			
				  <div class="before"></div>
				  <div class="after"></div>
			
          <div style="text-align: right;" data-dismiss="modal"><i class="fa fa-times text-white"></i></div>
			
				<div class="row" >
				
					<div class="col-xs-12 col-md-12 text-center"> 
						<img src="<?php echo base_url('assets/frontend/img/congo-reward.png') ?>" width="30%" />
						<br>
						<h4 class="text-white"> <b> Congratulations!</b></h4><br>
						<p class="text-white">You have won daraz vouchers in tournaments <br> you participated.  </p>
						<br><br>
					</div>
					
					<div class="col-xs-6 col-md-6 text-white text-center"> 
						<p class="text-white" style="color:#5f5f5f !important;"><i>Tournament</i></p>
					</div>
					
					<div class="col-xs-6 col-md-6 text-white text-center"> 
						<p class="text-white" style="color:#5f5f5f !important;"><i>Daraz voucher(s)</i></p>
					</div>
					
					
					<?php foreach($rewardsUnseen as $rowUnseen){ ?>
						<div class="col-xs-6 col-md-6 text-white text-center"> 
							<p style="font-size:1.05em"><?php echo stripslashes(urldecode($rowUnseen['tournament_name'])); ?> <?php echo "(Rank #".$rowUnseen['player_reward_rank'].")"; ?></p>
						</div>
						
						<div class="col-xs-6 col-md-6 text-white text-center"> 
							<p style="font-size:1.05em">  ৳  <?php echo $rowUnseen['player_reward_prize']; ?></p>
						</div>
					<div class="col-xs-12 col-md-12"><br></div>	
					<?php } ?>
					
					
					<div class="col-xs-12 col-md-12"><br></div>	
					<div class="col-xs-12 col-md-12"> 
						<a href="<?php echo site_url('tournamentHistory') ?>" class="btn modal-btn-dark">Claim Now</a>
					</div>	
					
					<div class="col-xs-12 col-md-12"><br><br></div>	
				
				</div>	
		   </div>
		</div>
      
    </div>
  </div>
  
  
<script>
	$(document).ready(function(){
		$("#rewardsUnseenModal").modal('show');
	});
</script>
  
<?php } ?>	
	


<!--  For support -->
<div class="modal fade" id="support_popup" role="dialog" style="width:100%; margin-top:50px !important; ">
    <div class="modal-dialog box-center ">
      <!-- Modal content-->
       <div class="modal-content modal-bg " align="center" style=" border-radius: 10px 10px 10px 10px; background: #202125 !important;">

        <div class="modal-body">
          <div style="text-align: right;" data-dismiss="modal"><i class="fa fa-times text-white"></i></div>
			
				<div class="row" >
				
					<div class="col-xs-12 col-md-12 text-center"> 
						<img src="<?php echo base_url('assets/frontend/img/support.png') ?>" width="30%" />
						<br><br><br>
						<p class="text-white">For any enquiry or feedback you can write us an email and send it on <span class="theme-color" style="font-size:1.25em;"><b>techsupport@adxdigitalsg.com </b></span></p>
						<br><br>
					</div>
					
					<div class="col-xs-12 col-md-12"><br></div>	
					<!--<a class="btn btn-outline-green" target="_blank" href="mailto:techsupport@adxdigitalsg.com">Send Mail</a>
					<div class="col-xs-12 col-md-12"><br></div>	-->
				
				</div>	
		   </div>
		</div>
      
    </div>
  </div>
  
  
<script>
	$(document).ready(function(){
		$(".gpl_support").click(function(){
			$("#support_popup").modal('show');
		});
	});
</script>
	
	
<script>
$(document).ready(function(){
	$(document).on("click", ".free-games-click", function (e) {
		e.preventDefault();
		var link = $(this).attr('data-href');
		var gameid = $(this).attr('data-id');
	 
		$.ajax({
			url:"<?php echo site_url('site/EventCapture') ?>", 
			data: "eventfun=eventexecute&event_name=play_instant_games&page=home&gameid="+gameid,
			type: "POST",
			async: false,
			success: function(response){
				//console.log("Time "+response);
			}
		});
		
		if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
			window.webkit.messageHandlers.onEventExecute.postMessage({name: "play_instant_games", params: {"page": "home"} });
		} else {
			
			window.jsInterface.eventExecute( "play_instant_games", "page,home");
		}  
		location.href = link;
	});

});
</script>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "80%";
}

function closeNav() {
  //document.getElementById("mySidenav").style.width = "0";
}
</script>


<?php if (isset($_SERVER['HTTP_REFERER'])){ ?>
<?php $referer = $_SERVER['HTTP_REFERER']; ?>
	<?php if ((strpos($referer, 'PremiumUser') !== false || strpos($referer, 'Welcome') !== false) && $userInfo['user_full_name'] == ''){ ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#name_update').modal({
					backdrop: 'static',
					keyboard: false
				});
			});
		</script>
	<?php  } ?>
<?php  } ?>




<?php if ($userInfo['user_type'] == '2'){ ?>
	<?php if ($userInfo['user_full_name'] == '' || $userInfo['user_full_name'] == NULL){  ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#name_update').modal({
					backdrop: 'static',
					keyboard: false
				});
			});
		</script>
	<?php } ?>
<?php } ?>


<script>
jQuery(document).ready(function ($) {
	jQuery("#close-sidebar").on('click', function () {
		jQuery("#mySidenav").css('width','0');
	});
}); 
</script>

<script>
jQuery(document).ready(function ($) {
	jQuery(".unauthorized").on('click', function () {
		jQuery('#myModal').modal('show');
	});
}); 
</script>





<?php if ($this->session->flashdata('error')){ ?>
<script>
	jQuery(document).ready(function ($) {
		jQuery('#errorModal').modal('show');
	}); 
</script>
<?php } ?>


<?php if ($this->session->flashdata('success')){ ?>
<script>
	jQuery(document).ready(function ($) {
		jQuery('#successModal').modal('show');
	}); 
</script>
<?php } ?>


<script>
jQuery(document).ready(function ($) {
  $("#practice-banners-slider").slick({
    dots: false,
    infinite: true,
    speed: 500,
    slidesToShow: 2,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    arrows: false,
    responsive: [
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 400,
        settings: {
          arrows: false,
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
    ]
  });
});

</script>


<script>
jQuery(document).ready(function ($) {
  $("#hero-tournaments-slider").slick({
    dots: false,
    infinite: true, 
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 4000,
	arrows: false,


    responsive: [
      {
        breakpoint: 600,
        settings: {
		arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 400,
        settings: {
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
});

jQuery(document).ready(function ($) {
  $("#day-tournaments-slider").slick({
    dots: false,
    infinite: true, 
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 4000,
	arrows: false,


    responsive: [
      {
        breakpoint: 600,
        settings: {
		arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 400,
        settings: {
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
});
jQuery(document).ready(function ($) {
  $("#free-tournaments-slider").slick({
    dots: false,
    infinite: true, 
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 4000,
	arrows: false,


    responsive: [
      {
        breakpoint: 600,
        settings: {
		arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 400,
        settings: {
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
});
</script>



<script>
jQuery(document).ready(function ($) {
  $("#medium-tournaments-slider").slick({
    dots: false,
    infinite: true, 
    speed: 500,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 4000,
    arrows: false,
    responsive: [
      {
        breakpoint: 600,
        settings: {
		arrows: false,
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 400,
        settings: {
          arrows: false,
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
    ]
  });
});

</script>




<script>
jQuery(document).ready(function ($) {
  $("#small-tournaments-slider").slick({
    dots: false,
    infinite: true, 
    speed: 500,
    slidesToShow: 2,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 4000,
    arrows: false,
    responsive: [
      {
        breakpoint: 600,
        settings: {
		arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 400,
        settings: {
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
});

</script>



<script>
jQuery(document).ready(function ($) {
  $("#main-slider").slick({
    dots: false,
    infinite: true,
    speed: 500,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: false,
    responsive: [
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 400,
        settings: {
          arrows: false,
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
    ]
  });
});

</script>



<script>
jQuery(document).ready(function ($) {
  $(".genre_games").slick({
    dots: false,
    infinite: false,
    speed: 500,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    arrows: false,

    responsive: [
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 400,
        settings: {
          arrows: false,
          slidesToShow: 3,
          slidesToScroll: 1
        }
      }
    ]
  });
});

</script>
<script>
jQuery(document).ready(function() {
    jQuery('#load').fadeOut("slow");
});
</script>


<script>
!function(window){
  var $q = function(q, res){
        if (document.querySelectorAll) {
          res = document.querySelectorAll(q);
        } else {
          var d=document
            , a=d.styleSheets[0] || d.createStyleSheet();
          a.addRule(q,'f:b');
          for(var l=d.all,b=0,c=[],f=l.length;b<f;b++)
            l[b].currentStyle.f && c.push(l[b]);

          a.removeRule(0);
          res = c;
        }
        return res;
      }
    , addEventListener = function(evt, fn){
        window.addEventListener
          ? this.addEventListener(evt, fn, false)
          : (window.attachEvent)
            ? this.attachEvent('on' + evt, fn)
            : this['on' + evt] = fn;
      }
    , _has = function(obj, key) {
        return Object.prototype.hasOwnProperty.call(obj, key);
      }
    ;

  function loadImage (el, fn) {
    var img = new Image()
      , src = el.getAttribute('data-src');
    img.onload = function() {
      if (!! el.parent)
        el.parent.replaceChild(img, el)
      else
        el.src = src;

      fn? fn() : null;
    }
    img.src = src;
  }

  function elementInViewport(el) {
    var rect = el.getBoundingClientRect()

    return (
       rect.top    >= 0
    && rect.left   >= 0
    && rect.top <= (window.innerHeight || document.documentElement.clientHeight)
    )
  }

    var images = new Array()
      , query = $q('img.lazy')
      , processScroll = function(){
          for (var i = 0; i < images.length; i++) {
            if (elementInViewport(images[i])) {
              loadImage(images[i], function () {
                images.splice(i, i);
              });
            }
          };
        }
      ;
    // Array.prototype.slice.call is not callable under our lovely IE8 
    for (var i = 0; i < query.length; i++) {
      images.push(query[i]);
    };

    processScroll();
    addEventListener('scroll',processScroll);

}(this);
</script>



<!--
<script src="<?php echo base_url() ?>assets/frontend/js/jquery.countdown.min.js" integrity="" crossorigin="allow"></script>
-->
<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.0/moment-timezone-with-data-2010-2020.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js" integrity="sha512-lteuRD+aUENrZPTXWFRPTBcDDxIGWe5uu0apPEn+3ZKYDwDaEErIK9rvR0QzUGmUQ55KFE2RqGTVoZsKctGMVw==" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
	$('[data-countdown]').each(function() {
	  var $this = $(this), finalDate = $(this).data('countdown');
	  $this.countdown(finalDate, function(event) {
		$this.html(event.strftime('%Dd : %Hh : %Mm : %Ss'));
	  });
	  

	});
});
</script>
-->

 	
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.0/moment-timezone-with-data-2010-2020.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js" integrity="sha512-lteuRD+aUENrZPTXWFRPTBcDDxIGWe5uu0apPEn+3ZKYDwDaEErIK9rvR0QzUGmUQ55KFE2RqGTVoZsKctGMVw==" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
	$('[data-countdown]').each(function() {
		var $this = $(this), finalDate = moment.tz($this.data('countdown'), "Asia/Dhaka");
		$this.countdown(finalDate.toDate(), function(event) {
		$this.html(event.strftime('%Dd : %Hh : %Mm : %Ss'));
	  });
	});
});
</script>
	
 




 <?php include "page_session_timeout.php";
?>
</body>
</html>
