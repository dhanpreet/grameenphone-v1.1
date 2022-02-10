<!--
<section class="footer-wrapper" align="center">
	<div class="container">
		<div class="row footer-dark"  style="padding:15px">
			<div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
				<a  href="<?php echo site_url() ?>" class="homefooterclick <?php if($this->uri->segment(1)=='' || ($this->uri->segment(1)=='site' && $this->uri->segment(2)=='index')){ echo "theme-color"; }else{ echo "text-white"; } ?>"> 
					<i class="f1h2vptk fa fa-home <?php if($this->uri->segment(1)=='' || ($this->uri->segment(1)=='site' && $this->uri->segment(2)=='index')){ echo "theme-color"; }else{ echo "text-white"; } ?>"></i><span>
					<br>  Home 
				</a>
			</div>
			
			<div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
				<a  href="<?php echo site_url('Games') ?>" class="gamesfooterclick <?php if($this->uri->segment(1)=='Games'){ echo "theme-color"; }else{ echo "text-white"; } ?>"> 
					<i class="f1h2vptk fa fa-gamepad <?php if($this->uri->segment(1)=='Games'){ echo "theme-color"; }else{ echo "text-white"; } ?>"></i><span>
					<br>  Games
				</a>
			</div>
			
			<div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
				<a  href="<?php echo site_url('tournamentHistory') ?>#" class="historyfooterclick <?php if($this->uri->segment(1)=='tournamentHistory'){ echo "theme-color"; }else{ echo "text-white"; } ?>">
					<i class="f1h2vptk fa fa-boxes <?php if($this->uri->segment(1)=='tournamentHistory'){ echo "theme-color"; }else{ echo "text-white"; } ?>"></i><span>
					<br> History
				</a>
			</div>
	   </div>
	</div>
</section>
-->
<section class="footer-wrapper" align="center">
	
	<div class="container">
		
			<div class="row footer-dark"  style="padding:15px">
				<?php if($userInfo['user_type']=='2'){ ?>
			<div class="col-2 col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">
			<?php }else{ ?>
				<div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
			<?php } ?>
				<a  href="<?php echo site_url() ?>" class="homefooterclick <?php if($this->uri->segment(1)=='' || ($this->uri->segment(1)=='site' && $this->uri->segment(2)=='index')){ echo "theme-color"; }else{ echo "text-white"; } ?>"> 
					<i class="f1h2vptk fa fa-home <?php if($this->uri->segment(1)=='' || ($this->uri->segment(1)=='site' && $this->uri->segment(2)=='index')){ echo "theme-color"; }else{ echo "text-white"; } ?>"></i><span>
					<br>  Home 
				</a>
			</div>
			
			<div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
				<a  href="<?php echo site_url('Games') ?>" class="gamesfooterclick <?php if($this->uri->segment(1)=='Games'){ echo "theme-color"; }else{ echo "text-white"; } ?>"> 
					<i class="f1h2vptk fa fa-gamepad <?php if($this->uri->segment(1)=='Games'){ echo "theme-color"; }else{ echo "text-white"; } ?>"></i><span>
					<br>  Games
				</a>
			</div>
			
			<?php if($userInfo['user_type']=='2'){ ?>
			<div class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
			<?php }else{ ?>
			<div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
			<?php } ?>
			
				<a  href="<?php echo site_url('tournamentHistory') ?>#" class="historyfooterclick <?php if($this->uri->segment(1)=='tournamentHistory'){ echo "theme-color"; }else{ echo "text-white"; } ?>">
					<i class="f1h2vptk fa fa-boxes <?php if($this->uri->segment(1)=='tournamentHistory'){ echo "theme-color"; }else{ echo "text-white"; } ?>"></i><span>
					<br> History
				</a>
			</div>
			<?php if($userInfo['user_type']=='2'){ ?>
			<div class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
				<a  href="#" class="buy-bundle text-white">
					<i class="f1h2vptk fa fa-cart-arrow-down text-white"></i><span>
					<br>Buy Bundle 
				 
				 </a>
			</div>
		<?php } ?>
			
	   </div>
	</div>
</section>

<script type="text/javascript">
	$(document).on("click", ".buy-bundle", function (e) {
           e.preventDefault();
           var link = $(this).attr('href');
		   
			var event_ajaxdata = "user_id=<?php echo $userInfo['user_id']; ?>&eventfun=eventExecute&event_name=buy_bundle&page=home";
			var content_ajaxdata = "user_id=<?php echo $userInfo['user_id']; ?>&eventfun=contentChange&event_name=buy_bundle&page=home";

			$.ajax({
				url:"<?php echo site_url('site/EventCapture') ?>", 
				data: event_ajaxdata,
				type: "POST",
				async: false,
				success: function(response){
					//console.log("Time "+response);
				}
			});
			$.ajax({
				url:"<?php echo site_url('site/EventCapture') ?>", 
				data: content_ajaxdata,
				type: "POST",
				async: false,
				success: function(response){
					//console.log("Time "+response);
				}
			});	
	
			if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
				window.webkit.messageHandlers.onEventExecute.postMessage({name: "buy_bundle", params: {"page": "home"} });
				window.webkit.messageHandlers.onContentChange.postMessage({contentUrl:"<?php echo site_url() ?>", isPremium: true});
			} else {
				window.jsInterface.eventExecute("buy_bundle", "page, home");
				window.jsInterface.contentChange("<?php echo site_url() ?>", true);
			}
		   
		    //location.href = link;          
	});
</script>