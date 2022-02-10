<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="GPL">
    <meta name="mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url('assets/frontend/css/play-game.css') ?>" rel="text/css" />
     
	<!-- For fontawesome icons -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	
	<title>Play Tournament | iGPL</title>

    <script>

        var elem = document.documentElement;
        function openFullscreen() {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) { /* Firefox */
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE/Edge */
                elem.msRequestFullscreen();
            }

        }

        function closeFullscreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }
    </script>
    
    <!-- Event snippet for PK Jazz conversion page -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
        body, html {
			font-family: 'Ubuntu', sans-serif;  
			max-width:99vw !important;
            height: 100%;
            margin: 0;
			 background: #212121;
        }
        .show {
            visibility: visible;
        }

        .hide {
            visibility: hidden;
        }
		
		 .red-bg {
               background: #212121;
            }

        .bg {
            /* The image used */
            background-image: url("img_girl.jpg");
            /* Full height */
            height: 100%;
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        iframe {
            /*display: block;*/
            background: #000;
            border: none;
            height: 90vh;
            width: 100vw;
        }

        .back-arrow {
            width: 18px;
            margin-right: 20px;
            margin-top: -3px;
        }

        .arrow-absolute {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #fff;
        }

        .full-absolute {
            position: absolute;
            top: 50px;
            right: 10px;
            color: #fff;
        }

		.full-absolute i {
			color: #103c42 !important;
		}

        .padd {
            padding: 0px;
            margin: 0px;
        }

        .nav-back {
            position: absolute;
            top: 10px;
            color: #fff;
            left: 10px;
        }

        .leader-board {
            position: absolute;
            top: 6px;
            color: #fff;
            right: 10px;
        }

        .anch-white, .anch-white:focus {
            color: #fff;
        }
		
		#timer{
			font-size:1.2em !important;
			margin-top: -4px;
		}
		
		#area-landscape{
			width: 100vw  !important;
			height: 80vh  !important;
			text-align: center;
			background: #212121;
		}
		
		#area-landscape img{
			max-width: 100vw  !important;
		}
		
    </style>
</head>
<body>

 <?php $gameScreenOrientation =  @$tournamentInfo['tournament_game_screen'] ?>

    <div id="myvideofull">
        <div class="padd relative col-md-12">
            <div class="header-height red-bg" style="height: 40px"> </div>
			<div class="nav-back " style="width:98vw;" align="center">
				<img  src="<?php echo base_url() ?>assets/frontend/img/time.png" height="20" style="margin-top: -6px;"> 
				<span data-countdown="<?php echo $tournamentInfo['tournament_end_date'].' '.$tournamentInfo['tournament_end_time'].':59'; ?>"></span>
			</div>
				
        </div>
        <div class="relative">

			<iframe id="myvideo" src="https://games.igpl.pro/xml-api/play-game?partnercode=test-001&playerid=<?php echo $player_profile_id; ?>&gameid=<?php echo $game_id; ?>&seemless=true&fullscreen=true"></iframe>
									
			<span class="arrow-absolute">
			
				<?php $logged_user_id = $this->session->userdata('userId'); ?>
				
				<a href="<?php echo site_url('site/updateLiveTournamentPlayerScore/'.base64_encode($tournament_id).'/'.@$game_id.'/'.@$player_profile_id.'/redirect_tournament') ?>"  style="cursor: pointer;color:#fff !important; margin-top: 5px;">
					<img src="<?php echo base_url() ?>assets/frontend/img/icons/back.png" height="14">
				</a>
            </span>

            <div>
               <!-- <span class="full-absolute"><button onclick="goFullscreen('myvideofull');" class="anch-white show" id="expandbtn"><i class="fa fa-expand"></i></button></span>
                <span class="full-absolute" style="right:50px"><button onclick="closeFullscreen();" id="collapsebtn" class="anch-white hide"><i class="fa fa-compress"></i></button></span>
               -->

			   <div id="area-landscape" style="display:none;">
					<?php if($gameScreenOrientation == 'Portrait' || $gameScreenOrientation == 'Potrait') { ?>
							<img src="<?php echo base_url('assets/frontend/img/device-rotate-potrait.png') ?>" />
					<?php } else { ?>
						<img src="<?php echo base_url('assets/frontend/img/device-rotate-landscape.png') ?>" />
					<?php } ?>
				</div>
            </div>
            
        </div>
        
    </div>
    <script src="<?php echo base_url('assets/frontend/js/play-game.js') ?>"></script>
	
   
	<script>
      $(document).ready(function() {
        var dataStr = "tournament_id=<?php echo $tournament_id; ?>"+"&game_id=<?php echo $game_id; ?>"+"&skillpod_player_id=<?php echo $player_profile_id; ?>";
        setInterval(function() {
          $.ajax({
            crossDomain: true,
            async: true,
            type: "POST",
			data: dataStr,
            url: "<?php echo site_url('site/updateLiveTournamentGameboostPlayerScore') ?>",
            success: function(result) {
              },
            jsonpCallback: 'callbackFnc',
            failure: function() {},
            complete: function() {}
          });
        }, 5000);
      });

    </script>
	 
    <script type="text/javascript">
        function goFullscreen(id) {
            // Get the element that we want to take into fullscreen mode
            var element = document.getElementById(id);
            var collapseElement = document.getElementById("collapsebtn");
            //  var a = collapseElement.attributes("style");
            $('#expandbtn').removeClass('anch-white show');
            $('#expandbtn').addClass('anch-white hide');
            $('#collapsebtn').removeClass('anch-white hide');
            $('#collapsebtn').addClass('anch-white show');

            // collapseElement.style("visibility: visible");
            // These function will not exist in the browsers that don't support fullscreen mode yet,
            // so we'll have to check to see if they're available before calling them.

            if (element.mozRequestFullScreen) {
                // This is how to go into fullscren mode in Firefox
                // Note the "moz" prefix, which is short for Mozilla.
                element.mozRequestFullScreen();
            } else if (element.webkitRequestFullScreen) {
                // This is how to go into fullscreen mode in Chrome and Safari
                // Both of those browsers are based on the Webkit project, hence the same prefix.
                element.webkitRequestFullScreen();
            }
            // Hooray, now we're in fullscreen mode!
        }
        function closeFullscreen() {
            $('#expandbtn').removeClass('anch-white hide');
            $('#expandbtn').addClass('anch-white show');
            $('#collapsebtn').removeClass('anch-white show');
            $('#collapsebtn').addClass('anch-white hide');
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { /* Firefox */
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE/Edge */
                document.msExitFullscreen();
            }
        }
        function requestFullScreen(element) {
            // Supports most browsers and their versions.
            var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(element);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        document.addEventListener("keydown", function (e) {
            if (e.keyCode == 13) {
                toggleFullScreen();
            }
        }, false);
        var videoElement = document.getElementById("myvideo");
        function toggleFullScreen() {
            if (!document.mozFullScreen && !document.webkitFullScreen) {
                if (videoElement.mozRequestFullScreen) {
                    videoElement.mozRequestFullScreen();
                } else {
                    videoElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else {
                    document.webkitCancelFullScreen();
                }
            }
        }
    </script>


 
<script>

var gameOrientation = "<?php echo $gameScreenOrientation; ?>";
var screenWidth = window.screen.width;

if((gameOrientation == 'Landscape' || gameOrientation == 'landscape')){
	var orientation = window.screen.orientation;
	var orientation = (screen.orientation || {}).type || screen.mozOrientation || screen.msOrientation;
	var iOS_Orientation = window.orientation;
	if (orientation === "landscape-primary" || orientation === "landscape-secondary" || iOS_Orientation ==90 || iOS_Orientation== -90) {
		if(gameOrientation == 'Landscape' || gameOrientation == 'landscape'){
			$("#area-landscape").css("display", "none");
			$("#myvideo").css("display", "inline-block");
			resizeIframe("myvideo");
		} else {
			$("#myvideo").css("display", "none");
			$("#area-landscape").css("display", "inline-block");
			resizeIframe("myvideo");
		}
	} else if (orientation === "portrait-secondary" || orientation === "portrait-primary" || iOS_Orientation ==0) {
		if(gameOrientation == 'Landscape' || gameOrientation == 'landscape'){
			$("#myvideo").css("display", "none");
			$("#area-landscape").css("display", "inline-block");
			resizeIframe("myvideo");
		} else {
			$("#area-landscape").css("display", "none");
			$("#myvideo").css("display", "inline-block");
			resizeIframe("myvideo");
		}
	} else if (orientation === undefined) {}

} else {
	
	var orientation = window.screen.orientation;
	var orientation = (screen.orientation || {}).type || screen.mozOrientation || screen.msOrientation;
	var iOS_Orientation = window.orientation;
	
	if (orientation === "landscape-primary" || orientation === "landscape-secondary" || iOS_Orientation ==90 || iOS_Orientation== -90) {
		if(gameOrientation == 'Landscape' || gameOrientation == 'landscape'){
			$("#area-landscape").css("display", "none");
			$("#myvideo").css("display", "inline-block");
			resizeIframe("myvideo");
		} else {
			$("#myvideo").css("display", "none");
			$("#area-landscape").css("display", "inline-block");
			resizeIframe("myvideo");
		}
	} else if (orientation === "portrait-secondary" || orientation === "portrait-primary" || iOS_Orientation ==0) {
		if(gameOrientation == 'Landscape' || gameOrientation == 'landscape'){
			$("#myvideo").css("display", "none");
			$("#area-landscape").css("display", "inline-block");
			resizeIframe("myvideo");
		} else {
			$("#area-landscape").css("display", "none");
			$("#myvideo").css("display", "inline-block");
			resizeIframe("myvideo");
		}
	} else if (orientation === undefined) {}
}
	
</script>

<script>
window.addEventListener("orientationchange", function() {
	var orientation = window.screen.orientation;
	var orientation = (screen.orientation || {}).type || screen.mozOrientation || screen.msOrientation;
	var iOS_Orientation = window.orientation;
	if (orientation === "landscape-primary" || orientation === "landscape-secondary" || iOS_Orientation ==90 || iOS_Orientation== -90) {
		if(gameOrientation == 'Landscape' || gameOrientation == 'landscape'){
			$("#area-landscape").css("display", "none");
			$("#myvideo").css("display", "inline-block");
			resizeIframe("myvideo");
		} else {
			$("#myvideo").css("display", "none");
			$("#area-landscape").css("display", "inline-block");
			resizeIframe("myvideo");
		}
	} else if (orientation === "portrait-secondary" || orientation === "portrait-primary" || iOS_Orientation ==0) {
		if(gameOrientation == 'Landscape' || gameOrientation == 'landscape'){
			$("#myvideo").css("display", "none");
			$("#area-landscape").css("display", "inline-block");
			resizeIframe("myvideo");
		} else {
			$("#area-landscape").css("display", "none");
			$("#myvideo").css("display", "inline-block");
			resizeIframe("myvideo");
		}
	} else if (orientation === undefined) {}
}, false);
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.4.0/moment-timezone-with-data-2010-2020.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js" integrity="sha512-lteuRD+aUENrZPTXWFRPTBcDDxIGWe5uu0apPEn+3ZKYDwDaEErIK9rvR0QzUGmUQ55KFE2RqGTVoZsKctGMVw==" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
	$('[data-countdown]').each(function() { 
		var $_this = $(this);
		var finalDate = moment.tz($_this.data('countdown'), "Asia/Dhaka");
		$_this.countdown(finalDate.toDate(), function(event) {
		$_this.html(event.strftime('%D:%H:%M:%S'));
	
	  });
	});
});
</script>
</body>
</html>
