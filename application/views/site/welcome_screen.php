<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="theme-color" content="#000" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>iGPL </title>
		<meta name="description" content="Play your private battles with Friends & Family!">
		<meta property="og:type" content="website">
		<meta property="og:site_name" content="Gaming Social League" />
		<meta property="og:title" content="Gaming Social League">
		<meta property="og:url" content="https://playpt.igpl.pro">
		<meta property="og:description" content="Play your private battles with Friends & Family!">
		<meta property="og:image" content="<?php echo base_url() ?>assets/frontend/img/gpl.png" />
		<meta content="<?php echo base_url() ?>assets/frontend/img/gpl.png" property="thumbnail" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/frontend/css/style.css">
	
		<style>
		@import url('https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

		body{
			max-width: 100vw;
			max-height: 100vh;
			background: #202125;
			color: #fff; 
		}
		
		.btn-dark{
			background: #3fd53f;
			color: #fff;
			font-family: 'Mulish', sans-serif !important;
			padding: 10px 20px;
			border-radius: 20px;
			font-size:1.25em;
			width:40%;
		}
		
		img{
			max-width:90vw;
			margin:0 auto;
		}
		h1,h2,h3{
			font-size:1.75em;
			font-weight:400;
			
		}
		</style>
	</head>
	<body>
		<section>
			<div align="center">
				<div class="row text-box-position2 white-bg">
				<br>
				<img src="<?php echo base_url() ?>assets/frontend/img/logo-new.png" alt="logo" width="25%">
					<br>
					<h1>Welcome to the world of gaming</h1><br>
					
					<img src="<?php echo base_url() ?>assets/frontend/img/gameimg.png" width="80%">
					<br><br>
					<h2>Play & Win Daraz Voucher <br> Worth of ৳  52,000  </h2>
					
					 <br>
					<a href="<?php echo site_url('UserAccess/?token='.$token) ?>" class="btn-dark">Continue to Play</a>
				</div>
			</div>
		</section>
		
	</body>
</html>
