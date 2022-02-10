<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title> Tournaments</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">


	<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/css/bootstrap.min.css">
	<script src="<?php echo base_url() ?>assets/frontend/js/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/frontend/js/bootstrap.min.js"></script>
	
	<!-- For fontawesome icons -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/fontawesome-5.15.1/css/all.css" rel="stylesheet">
	<script defer src="<?php echo base_url() ?>assets/frontend/fontawesome-5.15.1/js/all.js"></script>
	
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/css/style_theme_2.css">
	
	<style>
		
		
		.btn-outline{
			color:#fff;
			border-radius:20px;
		}
		.btn-outline:hover{
			background:linear-gradient(to right,#5505d8, #f34b6a);
			color:#fff;
			font-weight:600;
		}
		
		.btn-filled{
			background:#3fd53f !important;
		
			color:#fff;
			border-radius:20px;
			/*  font-weight:600;
			width:75%;  */
		
		}
		.btn-filleddanger{
			background:red !important;
		
			color:#fff;
			border-radius:20px;
			font-weight:600;
			width:75%;
		}
		.btn-filled:hover{
			background:linear-gradient(to right,#5505d8, #f34b6a);
			color:#fff;
			font-weight:600;
		}
		
		
		

		.come-in {
		  transform: translateY(150px);
		  animation: come-in 0.5s ease forwards;
		}
		.come-in:nth-child(odd) {
		  animation-duration: 0.3s;
		}
		.already-visible {
		  transform: translateY(0);
		  animation: none;
		}

		@keyframes come-in {
		  to { transform: translateY(0); }
		}
		
		.modal-btn-dark {
			background: rgba(72, 254, 72,0.95) !important;
	
		}
		
		.label-text{
			color: #666;
			font-weight: 500;
		}
		
		
		
		.dark-side{
			
			background:#5fc35f !important;
			color:#fff !important;
			border-top-left-radius:10px;
			border-bottom-left-radius:10px;
			height:inherit;
			min-height:175px;
			
			padding:10px;
			vertical-align: middle;
			
		}
		.dark-side-v2{
			
			background:#f5f5f5 !important;
			color:#202125 !important;
			 border: 3px dotted #d3d3d3;
			border-radius:10px;
			height:inherit;
			min-height:175px;
			width:100%;
			margin:0 auto;
		
			vertical-align: middle;
			
		}
		
		.light-side-full{
			
			 border: 3px dotted #d3d3d3;
			background-color: #e2e2e2;
			color:#202125 !important;
			border-radius:10px;
			min-height:175px;
			width:100%;
			margin:0 auto;
		
			vertical-align: middle;

		}

		
	</style>
	<style>
	
		.ribbon1 {
		  position: absolute;
		  top: -29px;
		  right: 5px;
		}
		.ribbon1:after {
		  position: absolute;
		  content: "";
		  width: 0;
		  height: 0;
		  border-left: 50px solid transparent;
		  border-right: 40px solid transparent;
		  border-top: 10px solid #3fd53f;
		  left:0;
		}
		.ribbon1 span {
		  position: relative;
		  display: block;
		  text-align: center;
		  background: #3fd53f;
		  font-size: 14px;
		  line-height: 1;
		  padding: 12px 8px 10px;
		  border-top-right-radius: 8px;
		  width: 90px;
		  color:#fff;
		  font-family: inherit;
		}
		.ribbon1 span:before, .ribbon1 span:after {
		  position: absolute;
		  content: "";
		}
		.ribbon1 span:before {
		 height: 6px;
		 width: 6px;
		 left: -6px;
		 top: 0;
		 background: #3fd53f;
		}
		.ribbon1 span:after {
		 height: 6px;
		 width: 8px;
		 left: -8px;
		 top: 0;
		 border-radius: 8px 8px 0 0;
		 background: #3fd53f;
		}
		
		.bullet-txt:after{
			content:"•";
			padding: 0 0 0 5px;
			vertical-align: 5%;
			color: #959595;
		}
		
		
		
		.ribbon-red {
		  position: absolute;
		  top: -29px;
		  right: 5px;
		}
		.ribbon-red:after {
		  position: absolute;
		  content: "";
		  width: 0;
		  height: 0;
		  border-left: 50px solid transparent;
		  border-right: 40px solid transparent;
		  border-top: 10px solid #de3535;
		  left:0;
		}
		.ribbon-red span {
		  position: relative;
		  display: block;
		  text-align: center;
		  background: #de3535;
		  font-size: 14px;
		  line-height: 1;
		  padding: 12px 8px 10px;
		  border-top-right-radius: 8px;
		  width: 90px;
		  color:#fff;
		  font-family: inherit;
		}
		.ribbon-red span:before, .ribbon-red span:after {
		  position: absolute;
		  content: "";
		}
		.ribbon-red span:before {
		 height: 6px;
		 width: 6px;
		 left: -6px;
		 top: 0;
		 background: #de3535;
		}
		.ribbon-red span:after {
		 height: 6px;
		 width: 8px;
		 left: -8px;
		 top: 0;
		 border-radius: 8px 8px 0 0;
		 background: #de3535;
		}
		
			
	</style>
	
</head>
<body>
<div id="load"></div>

	<section>
		<div class="f1lhk7ql">
			<a href="<?php echo site_url('') ?>"><img class="f1iowekn" src="<?php echo base_url() ?>assets/frontend/img/icons/back.png" height="14"></a>
			<div class="f1py95a7" style="text-transform: capitalize; color: rgb(255, 255, 255);">Tournament History</div>
		</div>
		
		<div class="container">
			<div class="row" style="margin-bottom: 80px">
				<div class="col-xs-12 padd auto-margin games_area"> 
					
				</div>
			</div>
			<?php if(is_array($tournamentsList) && count($tournamentsList)>0 ){ ?>
				<div id="tournaments-rows" class="row" style="clear:both; width:95vw;  margin:0 auto;">
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
				
			<div class="row <?php if($tRow['redeem_prize'] == 1 ){ echo "light-side-full"; } else { echo "dark-side-v2"; } ?> module">
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
									
								<?php }else { ?>
                                       <p><i>This prize reward voucher  is no longer available after <?php echo date('F j, Y', strtotime($tRow['redeem_expiry_date'])); ?></i></p>
									<br>
									
								<?php } ?>
							</div>
							<?php } ?>
							
					</div>
				<div class="row"> <br><br> </div>
				<?php } ?>
				</div>
					<div class="row"> <br><br> </div>
					<?php if($total_pages >1) { ?>
					<div id="more-rows" class="row" style=" width:95vw; margin:0 auto; ">
					
						<input type="hidden" class="form-control" value="<?php echo (@$offset+1); ?>" id="offset" />
						<input type="hidden" class="form-control" value="<?php echo (@$total_pages); ?>" id="total_pages" />
						<input type="hidden" class="form-control" value="1" id="current_page" />
						<div style="text-align:center;">
							<img id="loading-gif" style="display:none" src="<?php echo base_url('assets/frontend/img/ajax-loader.gif') ?>" width="25%" /><br>
							<div class='more-rows-content text-small'>Load More</div>
						</div>
					</div>
					
					<?php } ?>
					
					<div class="row"> <br><br> </div>
					
					
				<?php } else { ?>
					<div class="row"> <br><br> <br><br> <br><br>  </div>
					
					<div class="row">
						<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"> 
							<img src="<?php echo base_url('assets/frontend/img/no-tournaments.png') ?>" width="30%"/><br>
							
							<h3 class="text-bold text-white" style="margin-top:10px !important;"> No  history found yet!</h3>
							<br>
							
						</div>
					</div>
				
				<?php }  ?>
				
				<div class="row"> <br><br> </div>
					<div class="row"> <br><br> </div>
					
		   
		</div>
	</section>
	
	<!-- Footer-Content -->
		<?php include "footer.php"; ?>
		  <script type="text/javascript">

			$(document).on("click", ".redeemclass", function () {
			var id1 = $(this).attr('id');
			var n = id1.split('/');
              var id = n[0]; 
               var playerid = n[1];
				//alert(id);
				$.ajax({
				url: "<?php echo base_url(); ?>RedeemModalData",
				type: "POST",
				data: "id="+id+"&player_id="+playerid,
				datatype: "json",
				success: function(data){
					//alert(data)
					var data = JSON.parse(data);
					$('#vouchername').text(data.voucher_name);
					$('#v_description').text(data.voucher_description);
                    $('#couponcode').val(data.voucher_code);
                    $('#expiry').text(data.voucher_expiry);
                    $('#reedemmodal').modal('show');
                    $('#reedemmodal-terms').modal('show');
					if(data.voucher_website != null )
						$('#redeembutton').html('<a href="<?php echo base_url(); ?>RedeemVoucher/'+ id+'/'+playerid+'"  class="btn modal-btn-dark claimsuccess" ><i class="fa fa-gift"></i>&nbsp;&nbsp;Redeem Now</button>');
				}
				});
			});

			// $(document).on("click", ".claimsuccess", function () {
			// 	var id = $(this).attr('id');

			// 	$.ajax({
			// 	url: "<?php echo base_url(); ?>site/RedeemVoucher",
			// 	type: "POST",
			// 	data: "id="+id,
			// 	success: function(data){
			// 		}
			// 	});

			// });

  </script>
	<!-- Footer Content End -->
	
<style>	
.modal-backdrop {
   background-color: rgba(0,0,0,0.9);
}
</style>	
	
<div class="modal fade"  id="reedemmodal" role="dialog" style="margin-top:20px !important; width:90% !important;">
    <div class="modal-dialog box-center  modal-lg">
   
      <!-- Modal content-->
       <div class="modal-content modal-bg" align="center" style="color:#000;">
			<div class="modal-body" style="background: #4d4d4d;    border-radius: 10px;" >
			<div style="text-align: right;" onclick="window.location.reload()"><i class="fa fa-times text-white"></i></div>
			
			<br>
			<div class="row text-white">
				<b style="font-size:34px;">You Won! </b><br>
			</div>
			
			<div class="row">
			
				<div class="col-xs-12 col-md-12 text-white"> <h4 id="vouchername"></h4><br></div>
				
				
				<div class="col-md-12 col-xs-12">
					<input type="text" class="col-xs-12 col-md-12" id="couponcode" readonly style="background-color: #202125;border: 1px solid #f0ffffb5; color: #fff; border-radius: 20px; padding:10px;">
				<span style="right: 22px; position: fixed;  color: #fff;     margin-top: 2vmin; font-size: 1.05em;  background: #46fa46; padding: 3px; border-radius: 20px;   width: 20%;" onclick="myFunction()" aria-hidden="true">
				Copy</span>
				
				</div>
				
				
				<div class="col-xs-12 col-md-12"> 
					<br><i><span id="expiry" style="font-size:1em; color:#ccc; "></span></i><br>
				</div>	
			
				<div class="col-xs-12 col-md-12"> 
					<br><i><span style="font-size:1em; color:#ccc; ">For more details visit www.daraz.com.bd</span></i><br>
				</div>	
			
				<!-- <div class="col-xs-12 col-md-12"> <span id="redeembutton"></span> </div>	-->
				<div class="col-xs-12 col-md-12"> 	<br><br> </div>	
				
			</div>	
			
		   </div>
      </div>
      
    </div>
  </div>
 	
	
	<!-- Footer Content End -->
<div class="modal fade"  id="reedemmodal-terms" role="dialog" style=" min-height: 50px;  max-height: 50px;">
    <div class="modal-dialog box-center  modal-lg" style="  position:fixed;  margin:0 auto; width:100%; left: 0; bottom:0;  height: 60%;">
   
      <!-- Modal content-->
       <div class="modal-content modal-bg" align="center" style="color:#000; height: 60%; border-radius:5px !important; bottom: 0 !important; position: fixed;">
			<div class="modal-body"  style=" max-height: calc(100% - 10px); overflow-y: scroll;">
			
			<br>
			
			<div class="row">
			
				<div class="col-xs-12 col-md-12 text-left" style="padding: 0 10px !important;"> 
					<h4><b>How to redeem a Daraz voucher</b></h4>
					<ol>
					<li> Download Daraz Online Shopping App or visit www.daraz.com.bd   </li>
					<li> Choose products of your choice and add them in cart </li>
					<li> Login/Signup with your mobile number or email </li>
					<li> Go to your cart and add the voucher code here </li>
					<li> Proceed with checkout and complete the shipping and payment options </li>
					<li> Note the order number for tracking the products </li>
					</ol>


					<h4><b> Important Notes: </b></h4>
					<ul>
					<li> Voucher can be used Once at a time. Need to consume the full amount at a once. </li>

					<li> Delivery Charge is not applicable in the voucher amount. Customer must pay the
					delivery charge through payment gateway. Only One voucher can be used in an
					order. (Delivery charge will be added as per Daraz policy) </li>

					<li> If the order amount is higher than the voucher amount, Client have to pay remaining
					balance through Cash on Delivery/ Credit/ Debit Card. </li>

					<li> Cash on delivery is not applicable, if the remaining balance is below 100 tk. Client
					will get 72 hours to pay the remaining balance through Bkash only. </li>

					<li> In some locations out side Dhaka , Product will deliver by 3rd party logistic company
					(pathao, shundorban etc). The client has to pick the product from the nearest branch
					of this logistic companies. </li>

					<li> Overseas Category product delivery lead time will be 30-45 days. Domestic product
					delivery lead time will be 4-7 working days. </li>

					<li> For better experience, try to order from “Daraz Mall” and good rating sellers. </li>

					</ul>
						<br>   
						
						
				</div>	
				<div class="col-xs-12 col-md-12"> 	<br><br> </div>	
				
			</div>	
			
		   </div>
      </div>
      
    </div>
  </div>
  
  
  

<script>
	function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("couponcode");

  /* Select the text field */
  copyText.select();
  document.execCommand("copy");
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

   /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText.value);

  /* Alert the copied text */
  
}
(function($) {

  $.fn.visible = function(partial) {
    
      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
    
    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };
    
})(jQuery);

var win = $(window);

var allMods = $(".module");


allMods.each(function(i, el) {
  var el = $(el);
  if (el.visible(true)) {
     el.addClass("already-visible"); 
  } 
});

win.scroll(function(event) {
  
  allMods.each(function(i, el) {
    var el = $(el);
    if (el.visible(true)) {
      el.addClass("come-in"); 
    } 
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
	$(".more-rows-content").click(function() {
		$("#loading-gif").show('fast');
		setTimeout(function(){
			var offset = $("#offset").val();
			offset = parseInt(offset);
			
			var total_pages = $("#total_pages").val();
			total_pages = parseInt(total_pages);
			
			var current_page = $("#current_page").val();
			current_page = parseInt(current_page);
			current_page = (current_page+1);
			
			var dataStr = "offset="+offset;
			
			$.ajax({
				url: "<?php echo site_url('site/getTournamentsMore/') ?>"+offset,
				success: function(response){
					
					if(response){
						$('#tournaments-rows').append(response);
						$('#offset').val(offset+1);
						$('#current_page').val(current_page);
						//$('#more-rows').show('fast');
					} 
					
					$("#loading-gif").hide('fast');
					
					if(total_pages === current_page)
						$('#more-rows').hide('fast');
					
				}
			});
		}, 1000);
	});
});
</script>	



 <?php include "page_session_timeout.php";	
?>

</body>
</html>