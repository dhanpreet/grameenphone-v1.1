<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
    <meta name="theme-color" content="#000" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Update Name | Gaming Social League</title>
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
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/fontawesome-5.15.1/css/brands.css" rel="stylesheet">
	<script defer src="<?php echo base_url() ?>assets/frontend/fontawesome-5.15.1/js/all.js"></script>
	<script defer src="<?php echo base_url() ?>assets/frontend/fontawesome-5.15.1/js/brands.js"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/css/style.css">
	
	
	<!-- For animations -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/animations.css">
	
	
<!-- for google sign in -->
<meta name="google-signin-client_id" content="931603219860-h3bpksbdd0basc0gjmmjeqq48tr8e6oe.apps.googleusercontent.com">
<meta name="google-signin-scope" content="profile email">
 <script src="https://apis.google.com/js/platform.js" async defer></script> 
 
<!-- for google sign in ends-->
 
	
	<style type="text/css">

		.form-control{
			height:45px !important;
			background: rgba(255,255,255,0.5) !important;
			border:  1px solid #cecece !important;
			border-top-right-radius: 20px !important;
			border-bottom-right-radius: 20px !important;
			
		}
		
		.input-group-addon{
			background: #fff !important;
			color: #2b2b2b !important;
			border-top:  1px solid #cecece !important;
			border-left:  2px solid #cecece !important;
			border-bottom:  1px solid #cecece !important;
			border-top-left-radius: 20px !important;
			border-bottom-left-radius: 20px !important;
			padding: 12px 15px !important;
		}
		

		.text-box-position2{
		   background:rgba(255,255,255,1); 
		    padding-bottom: 10px !important;
		    padding:20px;
		    border-radius: 10px;
		    margin:0 0px;
		    display: inline-block;
			width: 90%;
		}
		
		.text-btn2 {
		    width: 50%;
		    padding: 10px 5px;
		    border-radius: 20px;
			color:#fff !important;
		    background: #392963 !important;
		    font-size: 15px;
		    font-weight: 600 !important;
			border:none !important;
		}
		.bottom-text{
		    font-size: 14px;
		    color: #fff;
		}

		.bottom-position{
		    margin-top: 15px;
		}

		div.relative > input, div.spacing > select {
		    padding-left: 72px !important;
		}
		h5.text-with-line {
		  overflow: hidden;
		  text-align: center;
		  color: #efefef;
		}

		h5.text-with-line:before,
		h5.text-with-line:after {
		  background-color: #efefef;
		  content: "";
		  display: inline-block;
		  height: 1px;
		  position: relative;
		  vertical-align: middle;
		  width: 20%;
		}

		h5.text-with-line:before {
		  right: 0.5em;
		  margin-left: -50%;
		}

		h5.text-with-line:after {
		  left: 0.5em;
		  margin-right: -50%;
		}



		.loginBtn {
			min-width:60%;
		    position: relative;

			padding: 5px 10px 5px 10px;
			border: none;
			text-align: left;
			line-height: 36px;
			white-space: nowrap;
			border-radius: 8px;
			font-size: 16px;
			font-weight:600;
			color: #FFF;
			box-shadow: 0 -1px 0 #354C8C;
		}
		@media only screen and (min-width: 600px) {
		  .loginBtn {
		    min-width:40%;
			text-align:center;
		  }
		  
		  .g-signin2 .abcRioButtonBlue{
				text-align: center !important;
				min-width:60% !important;
				margin:0 auto !important;
			}
		}

		/* Facebook */
		.loginBtn--facebook {
		  background-color: #3479ea;

		}

		/* Google */
		.loginBtn--google {
		  background: #de4a39;
		  color:#fff;
		}
		
		
		/*   For Google defined custome button */
		
		.g-signin2 .abcRioButtonBlue{
			text-align: center !important;
			min-width:40% !important;
			margin:0 auto !important;
		}
		
		.abcRioButton, .abcRioButtonBlue{
			height: 48px !important;
			width: 230px !important;
			border-radius: 10px !important;
			background: #fff !important;
			color: #2b2b2b !important;
		}
		
		.abcRioButtonContentWrapper{
			text-align:center !important; 
		}
		.abcRioButtonContents{
			font-family: 'Ubuntu', sans-serif !important; 
			font-weight: 600 !important; 
			margin-left : 2px !important; 
			float: left !important; 
		}
		
.bg-image{
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	z-index: -1;
	background-size:cover;
	background-position:bottom;
}


.bg-float{
	background:#fff;
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	z-index: -1;
	
}
.bg-float-layer{
	background: rgba(0,0,0,0.8) !important;
	
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	z-index: 0;
	
}
.float-img{
	display:inline-block;
	position: relative !important;
	min-width: 100% !important;
	max-width: 100% !important;
	border-radius: 10px !important;
	margin: 5px 5px 5px 5px !important;
	
}
	.col-md-2{
		padding-left:5px !important;
		padding-right:5px !important;
	}

@media only screen and (max-width: 767px) {
	.col-xs-4, .col-xs-6, .col-sm-6{
		padding-left:5px !important;
		padding-right:5px !important;
	}
	.float-img{
		display:inline-block;
		position: relative !important;
		min-width: 100% !important;
		max-width: 100% !important;
		border-radius: 10px !important;
		margin: 5px 5px 5px 5px !important;
	}
}

</style>



<style>

.grid {
  margin-left: -10%;
  margin-right: -10%;
 width:120%;
}

img {
  height: auto;
  max-width: 100%;
  vertical-align: middle;
}

.masonry__item:nth-child(odd) img {
	margin-top:-100px !important;
}




/* vendor/masonry.css */

:root {
  --masonryGutter: 0%;
}

.masonry {
  margin: calc(6% * -1);
  margin: calc(var(--masonryGutter) * -1);
}

.masonry__item {
  margin: calc(6% / 4);
  margin: calc(var(--masonryGutter) / 4);
  width: calc(100% / 4 - 6%);
  width: calc(100% / 4 - var(--masonryGutter));
}

@media (min-width: 30em) {

  .masonry__item {
    width: calc(100% / 4 - 4%);
    width: calc(100% / 4 - var(--masonryGutter));
  }

}

@media (min-width: 1200px) {

  .masonry__item {
    width: calc(100% / 8 - 3%);
    width: calc(100% / 8 - var(--masonryGutter));
  }

}

</style>


</head>
<body>
<div class="bg-image"></div>


<div class="bg-float grid">


 
</div>
 
<div class="bg-float-layer">
</div>

<div id="load"></div>



	<section>
		 <div class="continer padd relative" style="padding: 18px; height: 100vh; ">
			<br>
			<div class="row text-center">
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" >
					<br><img  src="<?php echo base_url() ?>assets/frontend/img/logo-new.png" style="width:20%;">
					<br><br>
				</div>
			</div>
			
			<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 padd position-absolute" align="center">
				<br>
				<div class="row text-box-position2 white-bg ">
					
						<h3 class="text-bold " style="font-family: initial;">Tell us about yourself 
							<?php $referer= $_SERVER['HTTP_REFERER'];
							if (strpos($referer, 'welcomesub2') !== false) {
							    echo 'true';
							}
							?> </h3><br><br>

					<form action="<?php echo site_url('site/updateusername') ?>" method="post" autocomplete="none">
						<div id="login_with_phone">
							<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
							 <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input  type="text" name="user_name" class="form-control" placeholder="Tell your name..."  autocomplete="none" required /><br>
							 </div>
							</div>
							<input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
							
							<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
							
							<br>
							 <button type="submit" class="text-btn2 text-white text-bold" style="background:#202125 !important;">Submit</button>
						   </div>
						   
						   
						    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
								 <br><br>
								<br><br>
							 </div>
							 
					 
					 
					   </div>
					</form>
						
					 
				</div>
				</div>
		</div>
	</section>
	



<script>
jQuery(document).ready(function() {
    jQuery('#load').fadeOut("slow");
});
</script>
 

<script>
$(document).ready(function() {
    $('#login_manual_email').click(function(){
		$("#login_with_phone").hide('fast');
		$("#login_div").show('fast');
	});
});
</script>


<script>
$(document).ready(function() {
    $('#login_manual_phone').click(function(){
		$("#login_div").hide('fast');
		$("#login_with_phone").show('fast');
	});
});
</script>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src='<?php echo base_url() ?>assets/frontend/css3-animate-it.js'></script>



<script>
$(document).ready(function(){
	
	$.doTimeout(200, function(){
		$('.repeat1').addClass('go');
		return true;
	});
	$.doTimeout(300, function(){
		$('.repeat2').addClass('go');
		return true;
	});
	$.doTimeout(400, function(){
		$('.repeat3').addClass('go');
		return true;
	});
	$.doTimeout(500, function(){
		$('.repeat4').addClass('go');
		return true;
	});
	$.doTimeout(600, function(){
		$('.repeat5').addClass('go');
		return true;
	});
	$.doTimeout(700, function(){
		$('.repeat6').addClass('go');
		return true;
	});
	$.doTimeout(800, function(){
		$('.repeat7').addClass('go');
		return true;
	});
	$.doTimeout(900, function(){
		$('.repeat8').addClass('go');
		return true;
	});
	$.doTimeout(1000, function(){
		$('.repeat9').addClass('go');
		return true;
	});
	$.doTimeout(1100, function(){
		$('.repeat10').addClass('go');
		return true;
	});
	$.doTimeout(1200, function(){
		$('.repeat11').addClass('go');
		return true;
	});
	$.doTimeout(1300, function(){
		$('.repeat12').addClass('go');
		return true;
	});
	$.doTimeout(1400, function(){
		$('.repeat13').addClass('go');
		return true;
	});
	$.doTimeout(1500, function(){
		$('.repeat14').addClass('go');
		return true;
	});
	$.doTimeout(1600, function(){
		$('.repeat15').addClass('go');
		return true;
	});
	$.doTimeout(1700, function(){
		$('.repeat16').addClass('go');
		return true;
	});
	$.doTimeout(1800, function(){
		$('.repeat17').addClass('go');
		return true;
	});
	$.doTimeout(1900, function(){
		$('.repeat18').addClass('go');
		return true;
	});
	
	$.doTimeout(2000, function(){
		$('.repeat19').addClass('go');
		return true;
	});
	
	$.doTimeout(2100, function(){
		$('.repeat20').addClass('go');
		return true;
	});
	
	$.doTimeout(2200, function(){
		$('.repeat21').addClass('go');
		return true;
	});
	
	$.doTimeout(2300, function(){
		$('.repeat22').addClass('go');
		return true;
	});
	
	$.doTimeout(2400, function(){
		$('.repeat23').addClass('go');
		return true;
	});
	
	$.doTimeout(2500, function(){
		$('.repeat24').addClass('go');
		return true;
	});
	
	$.doTimeout(2600, function(){
		$('.repeat25').addClass('go');
		return true;
	});
	
	$.doTimeout(2700, function(){
		$('.repeat26').addClass('go');
		return true;
	});
	
	$.doTimeout(2800, function(){
		$('.repeat27').addClass('go');
		return true;
	});
});

</script>



</body>
</html>
