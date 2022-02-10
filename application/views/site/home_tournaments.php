<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="theme-color" content="#000" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
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

	<br>		<br>	
	
	<?php  if ($this->vipTournamentEnabled == 1 && is_array($vipTournaments) && count(@$vipTournaments) > 0){ ?>
			<div class="row text-left"> <h5 class="text-bold theme-color" style="font-size:1.25em;">&nbsp;&nbsp; Tournament of the week (Premium)</h5> <br></div>
						
				<div class="row text-left">
				   <div id="hero-tournaments-slider" class="col-12 slider hero-tournaments-slider ">
			         <?php
						$count = 0;
						foreach ($vipTournaments as $heroRow)
						{

					?>			
				            <a aria-hidden="false" class="vipclick" href="<?php echo site_url('customLiveTournament/' . base64_encode($heroRow['tournament_id'])) ?>">
							    <?php
        if ($heroRow['uploaded'] == 1)
        { ?>
								  <img class="lazy" src="<?php echo base_url('uploads/tournaments-banners/' . $heroRow['banner_image_path']) ?>" /> 
					    <?php
        } ?>
					      <?php if ($heroRow['uploaded'] != 1)
        { ?>
								   <img class="lazy" src="<?php echo base_url('uploads/640X360/' . $heroRow['tournament_gameboost_id'] . '.jpg'); ?>" />
					    <?php
        } ?>

								<div class="row">
									<div class="col-xs-5">
									   <div class="live-ticker col-8"><span class="blink_me">LIVE</span></div>
									</div>
									<div class="col-xs-7">
									   <div data-countdown="<?php echo date('Y/m/d', strtotime($heroRow['tournament_end_date'])) ?> <?php echo $heroRow['tournament_end_time'] . ":00"; ?>" class="time-ticker" id="st-timer-<?php echo $heroRow['tournament_id']; ?>"> 
									   </div>
									</div>
								</div>
									
								<div class="row bottom-ticker">
									<div class="col-xs-12">
									    <h5 class="text-white text-left" style="text-align: center;margin-left:-5px;">Win Daraz Voucher worth 
										<span style="font-size:1.1em;">৳ <?php echo number_format($heroRow['voucherPrize'], 0); ?></span></h5>
									</div>								
								</div>				
							</a>
								
		  
								
							</div>
							<div class="row" style="width:98%;    margin: -35px 0px 0px 0px; text-align:center;">   
								         
											<h5 class=" btn btn-outline-green text-center" style="width:inherit !important;">
												<?php if ($heroRow['joinedStatus'])
        { ?>
                                                <b >Current Rank #<?php echo $heroRow['myRank']; ?></b>  
								         <?php
        }
        else
        { ?>
												Entry <img src="<?php echo base_url() ?>assets/frontend/img/gold-coins.png" style="width:18px; display:inline; margin-top:-3px;"><span style="font-size:1em;"><b> <?php echo number_format($heroRow['fee_tournament_fee'], 0); ?> Coins</b></span>
												<?php
        } ?>
											</h5>
										
							</div>
							
							  <?php $count++;
    } ?>
						</div>
		
		<?php
}   ?>
<br>
		<?php if ($this->payAndPlayTournamentEnabled == 1 && is_array($payAndPlayTournaments) && count(@$payAndPlayTournaments) > 0)
{ ?>
			<div class="row text-left"> <h5 class="text-bold theme-color" style="font-size:1.25em;">&nbsp;&nbsp; Tournament of the day (Premium)</h5> <br></div>
						
			<div class="row text-left">
				<div id="day-tournaments-slider" class="col-12 slider hero-tournaments-slider">
					<?php $count = 0;
    foreach ($payAndPlayTournaments as $dayRow)
    {
?>			
				             <a aria-hidden="false" class="Payplayclick" href="<?php echo site_url('customLiveTournament/' . base64_encode($dayRow['tournament_id'])) ?>">
									<img  class="lazy" src="<?php echo base_url('uploads/640X360/' . $dayRow['tournament_gameboost_id'] . '.jpg') ?>" /> 
										      

										<div class="row">
											<div class="col-xs-5">
												<div class="live-ticker col-8"><span class="blink_me">LIVE</span></div>
											</div>
											<div class="col-xs-7">
											<div data-countdown="<?php echo date('Y/m/d', strtotime($dayRow['tournament_end_date'])) ?> <?php echo $dayRow['tournament_end_time'] . ":00"; ?>" class="time-ticker" id="st-timer-<?php echo $dayRow['tournament_id']; ?>"> </div>
									
											</div>
										</div>
									
										<div class="row bottom-ticker">
											<div class="col-xs-12">
											<h5 class="text-white text-left" style="margin-left:-5px;text-align: center;">Win Daraz Voucher worth 
											<span style="font-size:1.1em;">৳ <?php echo number_format($dayRow['voucherPrize'], 0); ?></span></h5>
											</div>
											
										</div>

										
									</a>
								
								
								
							</div>
								<div class="row" style="width:98%;    margin: -35px 0px 0px 0px; text-align:center;">   
								         
											<h5 class=" btn btn-outline-green text-center" style="width:inherit !important;">
												
												<?php if ($dayRow['joinedStatus'])
        { ?>
                                                <b >Current Rank #<?php echo $dayRow['myRank']; ?></b>  
								         <?php
        }
        else
        { ?>
												Entry <img src="<?php echo base_url() ?>assets/frontend/img/gold-coins.png" style="width:18px; display:inline; margin-top:-3px;"><span style="font-size:1em;"><b> <?php echo number_format($dayRow['fee_tournament_fee'], 0); ?> Coins</b></span>
												<?php
        } ?>
											</h5>
										
										</div>
							<?php $count++;
    } ?>
						</div>
		
		<?php
}  ?>
	<br>	
	<?php if ($this->freeTournamentEnabled == 1 && is_array($freeTournaments) && count(@$freeTournaments) > 0)
{ ?>
			<div class="row text-left"> <h5 class="text-bold theme-color" style="font-size:1.25em;">&nbsp;&nbsp; Free tournament to play</h5> <br></div>
						
			<div class="row text-left">
				<div id="free-tournaments-slider" class="col-12 slider ">
			

								<?php $count = 0;
    foreach ($freeTournaments as $heroRow)
    {

?>		 <a aria-hidden="false" class="freeclick" href="<?php echo site_url('customLiveTournament/' . base64_encode($heroRow['tournament_id'])) ?>">
									         
									          	<img  class="lazy" style="border-radius:0 !important; border-top-left-radius:10px !important; border-top-right-radius:10px !important; " src="<?php echo base_url('uploads/640X360/' . $heroRow['tournament_gameboost_id'] . '.jpg') ?>" /> 
										      

										<div class="row">
											<div class="col-xs-5">
												<div class="live-ticker col-8"><span class="blink_me">LIVE</span></div>
											</div>
											<div class="col-xs-7">
											<div data-countdown="<?php echo date('Y/m/d', strtotime($heroRow['tournament_end_date'])) ?> <?php echo $heroRow['tournament_end_time'] . ":00"; ?>" class="time-ticker" id="st-timer-<?php echo $heroRow['tournament_id']; ?>"> </div>
									
											</div>
										</div>
									
									
								
								<?php $count++;
    } ?>
								
							</div>
								<div class="row" style="width:98%;  margin:0 auto; margin-top:-35px; background: #2c2c2c; border-bottom-right-radius: 10px;  border-bottom-left-radius: 10px;">   
								         <div class="col-xs-6">
											<h5 class="text-white text-left" style="margin-left:-5px; line-height:20px; font-size:0.85em;">Win Daraz Voucher worth <br>
											<span style="font-size:1.50em;">৳ <?php echo number_format($heroRow['voucherPrize'], 0); ?></span></h5>
											</div>
										  <div class="col-xs-6">	
											<h5 class=" text-right" style="line-height:20px; color: #3fff48;">
											
												<?php if ($heroRow['joinedStatus'])
    { ?>
                                                <b >Current Rank #<?php echo $heroRow['myRank']; ?></b>  
								         <?php
    }
    else
    { ?>
												Join For Free</b></span>
												<?php
    } ?>
											</h5>
										
										</div>
									</div>
									
							</a>
						</div>
		
		<?php
} ?>


		<br>			
			<div class="row text-left"><h5 class="text-bold  theme-color"  style="font-size:1.25em;">&nbsp;&nbsp;&nbsp;&nbsp;  Free games to play</h5> </div>
			
			<div class="row" style="margin-bottom:50px !important;"><br>
				<div class="glider-contain">
		        <div class="glider-2">
			            
						<div>
							<?php foreach ($actionGames as $rowAction)
{ ?>
								<a class="freegames1 free-games-click" href="<?php echo site_url('playGame/' . base64_encode($rowAction['id'])); ?>" data-id="<?php echo @$rowAction['gid']; ?>">
								<div class="row thumbnails">
									<div class="col-xs-3"><img class="lazy thumb-img" src="<?php echo base_url('uploads/games/' . $rowAction['ImageName']); ?>" ></div>
									<div class="col-xs-7 text-white text-left"><h3><?php echo $rowAction['Name']; ?></h3><span class="head-desc">Action</span></div>
									<div class="col-xs-2"><i class="fa fa-play"></i></div>
								</div>
								</a>
							<?php
} ?>
			            </div>
						
						<div>
							<?php foreach ($arcadeGames as $rowArcade)
{ ?>
								<a class="freegames2 free-games-click" href="<?php echo site_url('playGame/' . base64_encode($rowArcade['id'])); ?>" data-id="<?php echo @$rowArcade['gid']; ?>">
								<div class="row thumbnails">
									<div class="col-xs-3"><img class="lazy thumb-img" src="<?php echo base_url('uploads/games/' . $rowArcade['ImageName']); ?>" ></div>
									<div class="col-xs-7 text-white text-left"><h3><?php echo $rowArcade['Name']; ?></h3><span class="head-desc">Arcade</span></div>
									<div class="col-xs-2"><i class="fa fa-play"></i></div>
								</div>
								</a>
							<?php
} ?>
			            </div>
						
						<div>
							<?php foreach ($adventureGames as $rowAdventure)
{ ?>
								<a class="freegames3 free-games-click" href="<?php echo site_url('playGame/' . base64_encode($rowAdventure['id'])); ?>" data-id="<?php echo @$rowAdventure['gid']; ?>">
								<div class="row thumbnails">
									<div class="col-xs-3"><img class="lazy thumb-img" src="<?php echo base_url('uploads/games/' . $rowAdventure['ImageName']); ?>" ></div>
									<div class="col-xs-7 text-white text-left"><h3><?php echo $rowAdventure['Name']; ?></h3><span class="head-desc">Adventure</span></div>
									<div class="col-xs-2"><i class="fa fa-play"></i></div>
								</div>
								</a>
							<?php
} ?>
			            </div>
						
						<div>
							<?php foreach ($sportsGames as $rowSports)
{ ?>
								<a class="free-games-click"  href="<?php echo site_url('playGame/' . base64_encode($rowSports['id'])); ?>" data-id="<?php echo @$rowSports['gid']; ?>">
								<div class="row thumbnails">
									<div class="col-xs-3"><img class="lazy thumb-img" src="<?php echo base_url('uploads/games/' . $rowSports['ImageName']); ?>" ></div>
									<div class="col-xs-7 text-white text-left"><h3><?php echo $rowSports['Name']; ?></h3><span class="head-desc">Sports & Racing</span></div>
									<div class="col-xs-2"><i class="fa fa-play"></i></div>
								</div>
								</a>
							<?php
} ?>
			            </div>
						
						<div>
							<?php foreach ($puzzleGames as $rowPuzzle)
{ ?>
								<a class="free-games-click"  href="<?php echo site_url('playGame/' . base64_encode($rowPuzzle['id'])); ?>" data-id="<?php echo @$rowPuzzle['gid']; ?>">
								<div class="row thumbnails">
									<div class="col-xs-3"><img class="lazy thumb-img" src="<?php echo base_url('uploads/games/' . $rowPuzzle['ImageName']); ?>" ></div>
									<div class="col-xs-7 text-white text-left"><h3><?php echo $rowPuzzle['Name']; ?></h3><span class="head-desc">Puzzle & Logic</span></div>
									<div class="col-xs-2"><i class="fa fa-play"></i></div>
								</div>
								</a>
							<?php
} ?>
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



<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog box-center ">
    
      <!-- Modal content-->
       <div class="modal-content modal-bg  modal-bg-error" align="center">

         <div class="modal-body">
           <img src="<?php echo base_url('assets/frontend/img/sad-face.png') ?>" />
          <br>
		  <?php if (@$userInfo['user_reward_coins'] <= 0)
{ ?>
				<h4> <b> Sorry!</b></h4>
				<p>Right now you don't have enough reward coins to get the access of this section. </p>
				<br><br>
				<button type="button" class="btn modal-btn-dark" data-dismiss="modal">Close</button>
		
		  <?php
}
else
{ ?>
				<h4> <b> Access Restriced!</b></h4>
				<p>You can redeem your reward coins to free access this section. <br>Do you want to proceed further? </p>
			  
			   <br><br>
				<button type="button" class="btn modal-btn-dark" data-dismiss="modal">Close</button>
				<a href="<?php echo site_url('RedeemCoins') ?>"><button type="button" class="btn modal-btn-dark">Proceed</button></a>
       
		  <?php
} ?>
		  
		   </div>
      </div>
      
    </div>
  </div>
  
  
<div class="modal fade" id="successModal" role="dialog">
    <div class="modal-dialog box-center">
      <div class="modal-content modal-bg  modal-bg-success" align="center">
        
        <div class="modal-body">
          <img src="<?php echo base_url('assets/frontend/img/happy-face.png') ?>" />
          <br>
		  <h4 class="text-white"> <b> Success! </b></h4>
          <p class="text-white"><?php echo @$this
    ->session
    ->flashdata('success') ?></p>
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
          <p><?php echo @$this
    ->session
    ->flashdata('error') ?></p>
		   <br><br>
		  <button type="button" class="btn modal-btn-dark" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  
 
<div class="modal fade" id="redemptionErrorModal" role="dialog">
    <div class="modal-dialog box-center">
      <div class="modal-content modal-bg modal-bg-error" align="center">
      
        <div class="modal-body">
           <img src="<?php echo base_url('assets/frontend/img/sad-face.png') ?>" />
          <br>
		  <h4> <b> OOPS ! </b></h4>
          <p><?php echo @$this
    ->session
    ->flashdata('redemption_error') ?></p>
		   <br><br>
		  <button type="button" class="btn modal-btn-dark" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
 
<div class="modal fade" id="less_play_coins" role="dialog">
    <div class="modal-dialog box-center">
      <div class="modal-content modal-bg modal-bg-error" align="center">
      
        <div class="modal-body">
           <img src="<?php echo base_url('assets/frontend/img/sad-face.png') ?>" />
          <br>
		  <h4> <b> OOPS ! </b></h4>
          <p><?php echo @$this
    ->session
    ->flashdata('less_play_coins') ?></p>
		   <br><br>
		  <button type="button" class="btn modal-btn-dark">Buy Play Coins</button><br><br>
		  <a class="text-white" href="javascript:(0);" data-dismiss="modal">Close</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="less_custom_tournament" role="dialog">
    <div class="modal-dialog box-center">
      <div class="modal-content modal-bg modal-bg-error" align="center">
      
        <div class="modal-body">
           <img src="<?php echo base_url('assets/frontend/img/sad-face.png') ?>" />
          <br>
		  <h4> <b> OOPS ! </b></h4>
          <p><?php echo @$this
    ->session
    ->flashdata('less_custom_tournament') ?></p>
		   <br><br>
		  <a class="btn modal-btn-dark" href="javascript:(0);" data-dismiss="modal">Close</a>
        </div>
      </div>
    </div>
  </div>
  


	  <div class="modal fade modal_custom" id="name_update" tabindex="-1" role="dialog" aria-labelledby="example" aria-hidden="true" >
		<div class="modal-dialog" role="document" style="top: 15%;">
			<div class="modal-content">
			
			<div class="modal-body" style="padding: 0px;">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 padd position-absolute" align="center">
				
				<div class="row text-box-position2 white-bg ">
					
						<h3 class="text-bold " >Tell us about yourself </h3> 
						<br>

					<form action="<?php echo site_url('site/updateusername') ?>" method="post" autocomplete="none">
						<div id="login_with_phone">
							<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
							 <div class="input-group" style="    margin: 20px;">
								<span class="input-group-addon" style="    border-top-left-radius: 20px !important;border-bottom-left-radius: 20px !important;"><i class="fa fa-user"></i></span>
								<input  type="text" name="user_name" class="form-control" style="    height: 45px !important;background: rgba(255,255,255,0.5) !important;border: 1px solid #cecece !important;border-top-right-radius: 20px !important;border-bottom-right-radius: 20px !important;" placeholder="Enter your name..."  autocomplete="none" required /><br>
							 </div>
							</div>
                            <?php if (isset($_GET['token']))
{
    $token = $_GET['token'];
}
elseif ($this
    ->uri
    ->segment(2) != '')
{
    $token = $this
        ->uri
        ->segment(2);
}
else
{
    $token = $this
        ->uri
        ->segment(3);
} ?>
							<input type="hidden" name="token" value="<?php echo $token; ?>">
							
							<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
							
							<br>
							 <button type="submit" class="text-btn2 text-white text-bold" style="background:#202125 !important;">Submit</button>
						   </div>
						   
						   
						    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
								 <br>
							 </div>
							 
					 
					 
					   </div>
					</form>
						
					 
				</div>
			
			</div>
			</div>
			<div class="modal-footer">
				
			</div>
			</div>
		</div>
	</div>

<script>
	$(document).ready(function(){
		
		 $(document).on("click", ".free-games-click", function (e) {
          
/*		  e.preventDefault();
           var link = $(this).attr('href');
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
			}  */
            location.href = link;
		});
		
		
		
		/*  ---------------------   Unused code   ---------------------------  */
		
		
		
		/*$(document).on("click", ".vipclick", function (e) {
           e.preventDefault();
           var link = $(this).attr('href');
			
			$.ajax({
				url:"<?php echo site_url('site/EventCapture') ?>", 
				data: "eventfun=eventexecute&event_name=weeklyTournament&page=home",
				type: "POST",
				async: false,
				success: function(response){
					//console.log("Time "+response);
				}
		    });
			
			if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
          	   window.webkit.messageHandlers.onEventExecute.postMessage({name: "weeklyTournament", params: {"page": "home"} });
			} else {
				eventExecute( "weeklyTournament", "page, home");
			}
			location.href = link;
			
            
		});
		*/
		
		/*
		$(document).on("click", ".Payplayclick", function (e) {
           e.preventDefault();
           var link = $(this).attr('href');
          
			$.ajax({
				url:"<?php echo site_url('site/EventCapture') ?>", 
				data: "eventfun=eventexecute&event_name=dailyTournament&page=home",
				type: "POST",
				async: false,
				success: function(response){
					//console.log("Time "+response);
				}
		    });
			
			if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
				window.webkit.messageHandlers.onEventExecute.postMessage({name: "dailyTournament", params: {"page": "home"} });
          	} else{
				eventExecute( "dailyTournament", "page,home");
			}
            location.href = link;
		});
		
		*/

       
	/*
        $(document).on("click", ".freeclick", function (e) {
           e.preventDefault();
           var link = $(this).attr('href');
         
			$.ajax({
				url:"<?php echo site_url('site/EventCapture') ?>", 
				data: "eventfun=eventexecute&event_name=dailyFreeTournament&page=home",
				type: "POST",
				async: false,
				success: function(response){
					//console.log("Time "+response);
				}
		    });
			
			if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
				window.webkit.messageHandlers.onEventExecute.postMessage({name: "dailyFreeTournament", params: {"page": "home"} });
          	} else {
				eventExecute( "dailyFreeTournament", "page,home");
			}
            location.href = link;
		});

		$(document).on("click", ".freegames1", function (e) {
			e.preventDefault();
			var link = $(this).attr('href');
           
			$.ajax({
				url:"<?php echo site_url('site/EventCapture') ?>", 
				data: "eventfun=eventexecute&event_name=playFreeGame&page=home",
				type: "POST",
				async: false,
				success: function(response){
					//console.log("Time "+response);
				}
		    });
			if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
            	window.webkit.messageHandlers.onEventExecute.postMessage({name: "playFreeGame", params: {"page": "home"} });
          	} else {
				eventExecute( "playFreeGame", "page,home");
			}
			location.href = link;
		});

		$(document).on("click", ".freegames2", function (e) {
			e.preventDefault();
			var link = $(this).attr('href');
		   
			$.ajax({
				url:"<?php echo site_url('site/EventCapture') ?>", 
				data: "eventfun=eventexecute&event_name=playFreeGame&page=home",
				type: "POST",
				async: false,
				success: function(response){
					//console.log("Time "+response);
				}
		    });
			if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
				window.webkit.messageHandlers.onEventExecute.postMessage({name: "playFreeGame", params: {"page": "home"} });
          	} else {
				eventExecute( "playFreeGame", "page,home");
			}
			 location.href = link;
		});

		$(document).on("click", ".freegames3", function (e) {
			e.preventDefault();
			var link = $(this).attr('href');
			$.ajax({
				url:"<?php echo site_url('site/EventCapture') ?>", 
				data: "eventfun=eventexecute&event_name=playFreeGame&page=home",
				type: "POST",
				async: false,
				success: function(response){
					//console.log("Time "+response);
				}
		    });
			if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
          	   window.webkit.messageHandlers.onEventExecute.postMessage({name: "playFreeGame", params: {"page": "home"} });
			} else{
				eventExecute( "playFreeGame", "page,home");
			}
			location.href = link;
		});
		
	*/
		
	});

function openNav() {
  document.getElementById("mySidenav").style.width = "80%";
}

function closeNav() {
  //document.getElementById("mySidenav").style.width = "0";
}


</script>
<?php if (isset($_SERVER['HTTP_REFERER']))
{
    $referer = $_SERVER['HTTP_REFERER'];

    if ((strpos($referer, 'PremiumUser') !== false || strpos($referer, 'Welcome') !== false) && $userInfo['user_full_name'] == '')
    { ?>
<script type="text/javascript">
	$(document).ready(function(){
    $('#name_update').modal({
    backdrop: 'static',
    keyboard: false
})
    $("#name_update").modal();
 
});


</script>
<?php
    }
} ?>

<?php
if ($userInfo['user_type'] == '2')
{
    if ($userInfo['user_full_name'] == '' || $userInfo['user_full_name'] == NULL)
    {
?>

<script type="text/javascript">
	
	$(document).ready(function(){
    $('#name_update').modal({
    backdrop: 'static',
    keyboard: false
})
    $("#name_update").modal();
 
});
</script>
<?php
    }
} ?>


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



<?php if ($this
    ->session
    ->flashdata('redemption_error'))
{ ?>
<script>
jQuery(document).ready(function ($) {
	jQuery('#redemptionErrorModal').modal('show');
}); 
</script>
<?php
} ?>



<?php if ($this
    ->session
    ->flashdata('less_play_coins'))
{ ?>
<script>
jQuery(document).ready(function ($) {
	jQuery('#less_play_coins').modal('show');
}); 
</script>
<?php
} ?>

<?php if ($this
    ->session
    ->flashdata('less_custom_tournament'))
{ ?>
<script>
jQuery(document).ready(function ($) {
	jQuery('#less_custom_tournament').modal('show');
}); 
</script>
<?php
} ?>



<?php if ($this
    ->session
    ->flashdata('error'))
{ ?>
<script>
jQuery(document).ready(function ($) {
	jQuery('#errorModal').modal('show');
}); 
</script>
<?php
} ?>


<?php if ($this
    ->session
    ->flashdata('success'))
{ ?>
<script>
jQuery(document).ready(function ($) {
	jQuery('#successModal').modal('show');
}); 
</script>
<?php
} ?>


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
  $("#suggested").slick({
    dots: false,
    infinite: true,
    speed: 500,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
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
jQuery(document).ready(function ($) {
  $("#trending").slick({
    dots: false,
    infinite: true,
    speed: 500,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
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
          slidesToShow:3,
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
$(document).ready(function() {
    $.ajax({
		url:"<?php echo site_url('site/globalLeaderboardHomepage') ?>",
		type:"POST",
		cache:false,
		success: function(data){
			//alert(data);
			$("#global_leaderboard").empty();
			$("#global_leaderboard").html(data);
		}
	});
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


 <?php // include "page_session_timeout.php";
?>
</body>
</html>
