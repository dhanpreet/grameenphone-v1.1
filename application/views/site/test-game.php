<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="GPL">
    <meta name="mobile-web-app-capable" content="yes">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	
	<!-- Java Script -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	
	<!-- For fontawesome icons -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	
    <title><?php echo $gameInfo['Name'] ?></title>

    
    <!-- Event snippet for PK Jazz conversion page -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
	
		body {
           background-color: #212121 !important;
			font-family: 'Ubuntu', sans-serif; 
        }
		
		.red-bg {
			background-color: #212121 !important;
		}
			
        .show {
            visibility: visible;
        }

        .hide {
            visibility: hidden;
        }

        .bg {
           background-color: #212121 !important;
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        iframe {
            background: #212121 !important;
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
    </style>
</head>
<body>
 <?php $gameScreenOrientation =  $gameInfo['screen']; ?>

    <div id="myvideofull">
        <div class="padd relative col-md-12">
            <div class="header-height red-bg" style="height: 40px"> </div>
			<div class="nav-back " style="width:99%;" align="center">
				<p id="timer" class="inline-block"><?php echo $gameInfo['Name'] ?></p>
			</div>
			
			<span class="arrow-absolute">
				<a href="javascript: history.go(-1)" class="text-white" style="cursor: pointer;color:#fff !important; margin-top: 5px;">	
					<img src="<?php echo base_url() ?>assets/frontend/img/icons/back.png" height="14">
				</a>
            </span>
        </div>
		
        <div class="relative">
			<!-- 
			<div>
				<span class="full-absolute"><button onclick="goFullscreen('myvideofull');" class="btn anch-white btn-show" id="expandbtn"><i class="fa fa-expand"></i></button></span>
				<span class="full-absolute btn-hide"><button onclick="closeFullscreen();" id="collapsebtn" class="btn anch-white btn-hide"><i class="fa fa-compress"></i></button></span>
			</div>
			-->
			
			<div id="area-landscape" style="display:none;">
				<?php if($gameScreenOrientation == 'Portrait' || $gameScreenOrientation == 'Potrait') { ?>
						<img src="<?php echo base_url('assets/frontend/img/device-rotate-potrait.png') ?>" />
				<?php } else { ?>
					<img src="<?php echo base_url('assets/frontend/img/device-rotate-landscape.png') ?>" />
				<?php } ?>
			</div>

            <iframe id="myvideo" src="https://games.igpl.pro/xml-api/play-game?partnercode=test-001&gameid=<?php echo $gameId; ?>&seemless=true&fullscreen=true" frameborder="0"  allowtransparency="true" style="z-index:1;" allow="autoplay"></iframe>
						
          
        </div>
        
    </div>
   
    <script type="text/javascript">
        function goFullscreen(id) {
            // Get the element that we want to take into fullscreen mode
            var element = document.getElementById(id);
            var collapseElement = document.getElementById("collapsebtn");
            //  var a = collapseElement.attributes("style");
            $('#expandbtn').removeClass('anch-white btn-show');
            $('#expandbtn').addClass('anch-white btn-hide');
            $('#collapsebtn').removeClass('anch-white btn-hide');
            $('#collapsebtn').addClass('anch-white btn-show');
         //   $('.videoWrapper').css('height','100vh');

          
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
			
            $('#expandbtn').removeClass('anch-white btn-hide');
            $('#expandbtn').addClass('anch-white btn-show');
            $('#collapsebtn').removeClass('anch-white btn-show');
            $('#collapsebtn').addClass('anch-white btn-hide');
		//	$('.videoWrapper').css('height','94vh');
            if (document.exitFullscreen) { 
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {  /* Firefox */
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


<script>
/*
jQuery(document).ready(function() {
	
	var gameOrientation = "<?php echo $gameScreenOrientation; ?>";
	if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
		
		if(gameOrientation == 'Landscape' || gameOrientation == 'landscape'){
			window.webkit.messageHandlers.onChangeOrientation.postMessage({mode:"landscape", isLandscape: true});
		} else {
		   window.webkit.messageHandlers.onChangeOrientation.postMessage({mode:"portrait", isLandscape: false});
		}
		
	} else {
		if(gameOrientation == 'Landscape' || gameOrientation == 'landscape'){
			changeOrientation(mode: "landscape", isLandscape: true);
		} else {
		   changeOrientation(mode: "landscape", isLandscape: false);
		}
	}
	
	var dataStr = "user_id=<?php echo $this->session->userdata('userId'); ?>&eventfun=eventexecute&event_name=changeOrientation&page=practice-game";
	//console.log(dataStr)
	$.ajax({
		url:"<?php echo site_url('site/EventCapture') ?>", 
		data: dataStr,
		type: "POST",
		async: false,
		success: function(response){
		}
	});
	
});
*/
</script>	

</body>
</html>
