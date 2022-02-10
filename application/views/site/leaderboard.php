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
	
	
	
	
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.4/jquery.lazy.min.js"></script>

	<script>
	/*  document.onreadystatechange = function () {
	  var state = document.readyState
	  if (state == 'complete') {
			document.getElementById('load').style.visibility="hidden";
	  }
	}  */
	</script>

	
	<style>
		body{
			background:#202125 !important;
		}
		
		
		#timer{
			font-size:1em !important;
			font-weight: 400 !important;
		}
		
		.bg-leaderboard{
			padding:15px 5px;
			border-radius: 20px 20px 0 0;
			background:#2b2b2b !important;
			color:#fff;
		}
		.bg-dark{
			padding:15px 5px;
			border-radius: 0 0 20px 20px;
			background:#2b2b2b !important;
			color:#fff;
		}
		
		.bg-dark-2{
			padding:10px 5px;
			
		/*	background:#2c2b4d !important;  */
			color:#fff;
			background: rgb(44,43,77);
			background: linear-gradient(242deg, rgba(44,43,77,1) 0%, rgba(53,56,81,1) 49%, rgba(44,85,134,1) 100%);

		}
		
		.btn-outline-dark{
			border:2px solid #fff;
			color:#fff;
			border-radius:20px;
			font-weight:600;
			background:#5c71db !important;
		}
		.btn-outline-dark:hover{
			background:#5c71db !important;
			border:2px solid #5c71db;
			color:#fff;
			font-weight:600;
		}
		
		
		
		.nav-tabs li{
			width: 50% !important;
			border-bottom: 0 !important;
			color:#fff; 
		}
		
		
		
	</style>
	

	<style type="text/css">
		
		img {
			max-width: 100%;
			height: auto;
			
		}
		
		.winner{
			max-width: 70%;
			height: auto;
			vertical-align: middle;
		}
	</style>
	
	
	<style>
	.leader-header{
		align-items: center;
		display: flex;
		height: 60px;
		left: 50%;
		max-width: 600px;
		position: absolute;
		transform: translate(-50%,0px);
		width: 100%;
		z-index: 2;
    }
    .lederboard-inner{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
    }
    span.second-position {
    display: block;
    background: #8d80b8;
    color: #fff;
    border-radius: 50%;
    height: 50px;
    width: 50px;
    vertical-align: middle;
    line-height: 50px;
    font-size: 18px;
    font-weight: 600;
}
span.first-position {
    display: block;
    background: #a694c4;
    border-radius: 50%;
    height: 100px;
    width: 100px;
    line-height: 100px;
}
span.second-text {
    color: #fff;
    position: relative;
    top: 4px;
}
span.first-text {
    color: #fff;
    position: relative;
    top: 4px;
    font-size: 20px;
}
.modal_custom{
	margin-top:17%;
}
span.second-position, span.second-text {
    position: relative;
    top: 30px;
}
.leader-table
{
  position: relative;
  top:-44px;
}
table.table.leaderboard-table td {
    border: 0;
    text-align: center;
    line-height: 3;
}
table.table.leaderboard-table
{
      position: relative;
    width: 100%;
    top: -60px;
    left: 0;
}
table.table.leaderboard-table tr.selected-board td {
    color: #fff;
}
.header-center
{
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    /* margin-left: 20px; */
    text-transform: capitalize;
    display: block;
    width: 80%;
    text-align: center;
}

.header-text{
	padding:5px 0 5px 0 !important; 
	color:#fff;
	background: linear-gradient(to right,#fa687e,#fdb165);
	border-radius: 0 15px;
}

.header-text-2{
	 padding:5px 0 5px 0 !important; 
	color:#fff;
	/* background: linear-gradient(to left,#ababd1,#5a74a6);  */
	
	/* background: rgb(2,11,116);
	background: linear-gradient(103deg, rgba(2,11,116,1) 0%, rgba(91,1,115,0.8) 85%);  */
	
	/*  background:  linear-gradient(120deg, rgb(91, 1, 115) 10%, rgb(232, 29, 98) 80%);  */
	
	/*  background: linear-gradient(120deg, #6524e4 10%, #e91e63 80%);  */
	background: linear-gradient(to left,#2b2b2b,#000000);
/*	
background: #D06D9F;
background: -webkit-linear-gradient(right, #D06D9F, #8D589E);
background: -moz-linear-gradient(right, #D06D9F, #8D589E);
background: linear-gradient(to left, #D06D9F, #8D589E);
*/

	
	
	

}

.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover{
	
	 background: #5a599d;
	 color:#fff;
	 border-radius: 0 !important;
}

.nav-item, .nav-pills>li>a{ 
	 border-radius: 0 !important;
	  text-align:center !important;
}

.fw-400{
	font-weight:400 !important;
}

.small-txt{
	color:#333;
	font-weight:400 !important;
	padding-left:5px;
}

#small-tournaments-slider img{
	border-radius:0 !important;
	border-top-right-radius: 10px !important;
	border-top-left-radius: 10px !important;
}
#small-tournaments-slider .slick-list{padding:0 40% 0 0 !important; }
#small-tournaments-slider .time-ticker{
	text-align:center;
	font-size:1.15em;
	border-radius:0 !important;
	border-bottom-right-radius: 10px !important;
	border-bottom-left-radius: 10px !important;
	background:rgba(72, 254, 72,0.5);
	color:#efefef;
	position:relative;
	margin-top:0;
	padding:3px 0 3px 0;
	
}


.small-tournaments-slider img{
	border-radius:0 !important;
	border-top-right-radius: 10px !important;
	border-top-left-radius: 10px !important;
}
.small-tournaments-slider .slick-list{padding:0 40% 0 0 !important; }
.small-tournaments-slider .time-ticker{
	text-align:center;
	font-size:1.15em;
	border-radius:0 !important;
	border-bottom-right-radius: 10px !important;
	border-bottom-left-radius: 10px !important;
	background:rgba(72, 254, 72,0.5);
	color:#efefef;
	position:relative;
	margin-top:0;
	padding:3px 0 3px 0;
	
}

#medium-tournaments-slider {
	text-align:center !important;
}

#medium-tournaments-slider img{
	border-radius:0 !important;
	border-top-right-radius: 10px !important;
	border-top-left-radius: 10px !important;
}
#medium-tournaments-slider .slick-list{padding:0 10% 0 0 !important; }
#medium-tournaments-slider .time-ticker{
	text-align:center;
	font-size:1.05em;
	border-radius:0 !important;
	border-bottom-right-radius: 10px !important;
	border-bottom-left-radius: 10px !important;
	background:rgba(72, 254, 72,0.5);
	color:#efefef;
	position:relative;
	margin-top:0;
	padding:5px 0 5px 0;
	
}

#hero-tournaments-slider{
	position:relative;
	
}
#hero-tournaments-slider .slick-list{padding:0 10% 0 0 !important; }


#hero-tournaments-slider .lazy{
	
	border-radius:10px !important;
	background-color: rgb(68,68,68); /* Needed for IEs */

	-moz-box-shadow: 5px 5px 5px rgba(68,68,68,0.9);
	-webkit-box-shadow: 5px 5px 5px rgba(68,68,68,0.9);
	box-shadow: 5px 5px 5px rgba(68,68,68,0.9);

	filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=3,MakeShadow=true,ShadowOpacity=0.30);
	-ms-filter: "progid:DXImageTransform.Microsoft.Blur(PixelRadius=3,MakeShadow=true,ShadowOpacity=0.30)";
	zoom: 1;
}



#hero-tournaments-slider .live-ticker{
	
	font-size:1em;
	border-radius:0 !important;
	border-top-left-radius: 10px !important;
	
	border-bottom-right-radius: 5px !important;
	color:#fff !important;
	background:rgba(255, 87, 51, 0.75) !important;
	color:#efefef;
	position:fixed;
	top:0;
	padding-left:12px;
	padding-right:12px;
	padding-bottom:2px;
	font-weight:600;

}

#hero-tournaments-slider .time-ticker{
	text-align:center;
	font-size:1em;
	border-radius:0 !important;
	border-top-right-radius: 10px !important;

	border-bottom-left-radius: 5px !important;
	background:rgba(0,0,0,0.75);
	color:#efefef;
	position:fixed;
	top:0;
	padding: 2px 32px 4px 32px;
}

#hero-tournaments-slider .bottom-ticker{
	text-align:center;
	font-size:1em;
	border-radius:0 !important;
	border-bottom-right-radius: 10px !important;
	border-bottom-left-radius: 10px !important;
	
	background:rgba(0,0,0,0.75);
	color:#efefef;
	position:fixed;
	
	width:100%;
	margin: 5px auto;
	width: inherit;
margin: 5px auto;
bottom: -4px;
	
}

.btn-entry-fee{
	
	border: 1px solid #48ff48;
	border-radius: 3px;
	display: inline-block;
	padding:5px 15px;
}


.btn-outline-green, .btn-outline-green:active, .btn-outline-green:hover, .btn-outline-green:focus {
	border: 1px solid #48ff48;
	border-radius: 3px;
	display: inline-block;
	padding: 5px 5px;
    color: #48ff48;
    width: 33%;
}


.btn i{

    border: 1px solid #48ff48;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    text-align: center;
    padding-left: 1px;
    line-height: 15px;
    font-size: 5px;
    color: #48ff48;
   
}
.small-tournaments-slider .fee-ticker{
	text-align:center;
	font-size:1.15em;
	border-radius:0 !important;

	border-bottom-left-radius: 10px !important;
	border-top-right-radius: 10px !important;
	background: rgba(0, 0, 0, 0.8);
    color: #efefef;
    position: absolute;
    top: 0vmin;
    right: 0px;
    padding: 8px;
    margin-top: 10px;
    margin-right: -5px;
}
</style>
	
</head>
<body>
<div id="load"></div>

	<!-- Header-Content -->
		<?php include "header.php"; ?>
	<!-- Header Content End -->

	<!-- Sidebar-Content -->
		<?php //include "sidebar.php"; ?>
	<!-- Sidebar Content End -->

<section class="main-wrapper" align="center"><br>

<div class="container">

	<div class="row"> <br><br> </div>
		
		
		<div class="container">
			<div class="row">

			

			</div>
		</div>
		

	
		
		<br><br>
		
		<div class="row"> 
			<div class="col-xs-12 col-sm-12 col-md-12 text-left theme-color"><br><br></div>
		</div>
		
		
		
	</div>
</section>


	<!-- Footer-Content -->
		<?php include "footer.php"; ?>
	<!-- Footer Content End -->


<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "80%";
}

function closeNav() {
  //document.getElementById("mySidenav").style.width = "0";
}
</script>



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



<?php if($this->session->flashdata('redemption_error')){ ?>
<script>
jQuery(document).ready(function ($) {
	jQuery('#redemptionErrorModal').modal('show');
}); 
</script>
<?php } ?>



<?php if($this->session->flashdata('less_play_coins') ){ ?>
<script>
jQuery(document).ready(function ($) {
	jQuery('#less_play_coins').modal('show');
}); 
</script>
<?php } ?>

<?php if($this->session->flashdata('less_custom_tournament') ){ ?>
<script>
jQuery(document).ready(function ($) {
	jQuery('#less_custom_tournament').modal('show');
}); 
</script>
<?php } ?>



<?php if($this->session->flashdata('error')){ ?>
<script>
jQuery(document).ready(function ($) {
	jQuery('#errorModal').modal('show');
}); 
</script>
<?php } ?>


<?php if($this->session->flashdata('success')){ ?>
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
    slidesToShow: 1.5,
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
   /* $(function() {
        $('.lazy').lazy();
    });  */
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


<?php 

	?>
</body>
</html>