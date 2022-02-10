<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Subscription Interface </title>
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
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.4/jquery.lazy.min.js"></script>
	
	<style>
	body  {
		background: #ededed  !important;
	}
	
	[disabled], [readonly] {background-color:#ffffff !important; color:#555555 !important; }
	
	.thumb-container > img {
		text-align: center !important;
		max-width:100%;
	}
	
	.header-text-2{
		padding:5px 0 5px 0 !important; 
		color:#fff;
		
		background: rgb(2,11,116);
		background: linear-gradient(103deg, rgba(2,11,116,1) 0%, rgba(91,1,115,1) 47%);
		border-radius: 0 50px 50px 0 ; 
	}
	
	
	</style>
	<style>
		input {
			border: 0 !important;
		}
		.form-control{
			height:45px !important;
			border-radius: 0 !important;
			border:2px solid #efefef !important;
		}
		.text-field{
			
			border:2px solid #efefef !important;
		}
		
		.input-group-addon{
			background: #fff !important;
			color: #2b2b2b !important;
			border:2px solid #efefef !important;
			padding: 12px 15px !important;
			border-radius: 0 !important;
		}
		

		.text-box-position2{
		   background:rgba(255,255,255,0.3); 
		    padding-bottom: 10px !important;
		    padding:20px;
		    border-radius: 10px;
		    margin:0 0px;
		    display: inline-block;
			width: 99.5%
			min-height:90vh !important;
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
		  /*position: absolute;
		  bottom: 0;
		      left: 50%;
		    transform: translate(-50%, 0px);
		    width: 100%;*/
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
	background-image: url(<?php echo base_url() ?>assets/frontend/img/bg/2.jpg); 
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	z-index: -1;
	background-size:cover;
	background-position:bottom;
}
.f234 {
    align-items: center;
    align-items: center;
    background: linear-gradient(to bottom,#202125,#202125);
    box-shadow: 0 2px 5px 2px rgb(1 1 1 / 40%);
    
    height: 60px;
    left: 0;
    margin: 0 auto;
    max-width: 600px;
    position: fixed;
    right: 0;
    top: 0;
    width: 100%;
    z-index: 3;
}
	</style>
	
</head>
<body >


	<section>
		<center><div class="f234">
		<h3 style="color:white;">  Subscription Interface</h3></div></center>
	
	<form action="<?php echo site_url('subscription/subInterfacesubmit') ?>" method="post" autocomplete="none">
						
      <div class="container">
        <div class="row">   <br><br><br><br>		</div>
		
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 padd position-absolute" align="center">
				<br>
				<div class="row text-box-position2 white-bg">
				
				
						
						
				
						
				<br><br><br>
				
			
					
						<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
						<br>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user-alt"></i></span> 
							<input  type="text" name="msisdn" class="form-control text-field"  placeholder="Mobile Number"  autocomplete="none"  /><br>
						</div>
						</div>

						<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
						<br>
						<div class="input-group col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<span class="input-group-addon"><i class="fa fa-book"></i></span><select name="sub_type" class="form-control" required id="sub_type">
								<option value="">Subscription Type</option>
								<option value="regular">Regular</option>
								<option value="premium">Premium</option>
							</select>
						</div>
						</div>


						<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd" id="expirydate">
						<br>
						<label style="text-align: left;">Select Expiry Date</label>
						<div class="input-group ">
							<span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
							<input  type="date" name="expirydate" class="form-control text-field"  placeholder="Select Expiry Date"  autocomplete="none"  /><br>
						<!-- <span class="input-group-addon"><i class="fa fa-check-circle  echo 'text-success'; } else { echo 'text-disabled'; } ?>" aria-hidden="true"></i></span> 
							-->
							
							
						</div>
						</div>
						
						
					
						
					 <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t-15 padd">
						 <br><br><br><br>	
					 </div>
				</div>
				
			</div>
		

         <a class="bottom-fixed-btn"><button type="submit" id="choose_game" class="btn btn-bottom btn-active">Submit </button></a>  
      </div>
	  
	   </form>
	</section>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($("#sub_type").val()=='premium'){
                  $('#expirydate').show();
				}else{
                  $('#expirydate').hide();
				}
			$("#sub_type").change(function(){
				if($("#sub_type").val()=='premium'){
                  $('#expirydate').show();
				}else{
                  $('#expirydate').hide();
				}

		});
			});
	</script>
	
	
	

  

 
	


 

 

  	








 

 



</body>
</html>