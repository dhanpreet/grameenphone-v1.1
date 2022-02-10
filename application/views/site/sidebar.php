<?php
function obfuscate_email($email){
	$em   = explode("@",$email);
   return @$em[0]; 
	
}
?>


<?php
// Get Unsubscribe User Access Duration
$accessUnsubscribe = true;

?>
 <style>
 .f1vou0gj{
	 text-transform: inherit !important;
 }
 </style>
 
<div id="mySidenav" class="sidenav">
		<div class="fykrs1m">
		   <div id="sidebarProfile" class="f1wvou2n">
		  			
				<div class="f1m7l5pe">
				<a href="<?php echo site_url('updateProfileImage') ?>">
				<?php if(!empty($userInfo['user_image'])){ ?>
					
					<?php if($userInfo['user_login_type'] == '1') { ?>
						<img class="lazy" src="<?php echo base_url() ?>uploads/site_users/<?php echo @$userInfo['user_image'] ?>" width="50">
					<?php } else { ?>
						<img class="lazy" src="<?php echo base_url().'uploads/site_users/'.@$userInfo['user_image'] ?>" width="50">
					<?php } ?>
				<?php } else { ?>
					<img  class="lazy" src="<?php echo base_url() ?>uploads/default-user.png" width="50" alt="">
				<?php }  ?>
				</a>
				</div>
			

				<div class="f10r1kbh">	
					<div class="ftumkjx">
					<a href="<?php echo site_url('ManageProfile') ?>" class="text-white">
					<?php
					if(!empty($userInfo['user_full_name'])){
						//$phone = substr($userInfo['user_phone'],0, 12);
						$phone = substr($userInfo['user_phone'],0, 13);
						echo ucwords($userInfo['user_full_name'])."<br>".substr($phone, 0, 3).'xxxxxx'.substr($phone, 10, 3);
					
					} else if(!empty($userInfo['user_email'])){
						echo obfuscate_email($userInfo['user_email']);
					
					} else if(!empty($userInfo['user_phone'])){
						$prefix = "+".substr($userInfo['user_phone'],0, 2);
						$ph = substr($userInfo['user_phone'],2, 10);
						echo $prefix.substr($ph, 0, 3).'XXXX'.substr($ph, 7, 3); 
					}
					?>
					</a>
					
					</div>
				</div>
				
				<div class="f1o3noum" style="cursor:pointer !important;">
				 <picture class="fc39scl">
					
					<img id="close-sidebar" onclick="closeNav()" class="f1mgyl9u" src="<?php echo base_url() ?>assets/frontend/img/close.png" alt="arrow">
				 </picture>
				</div>
			 </div> 

		</div>
		<div class="f1g1xeuz">
		   <div class="f108ghxs">
			  
			  <?php if($userInfo['user_login_type'] == '1' || $userInfo['user_login_type'] == '4') { ?>
			  <a id="sidebarWithdraw" class="fflrbt6" href="#">
				 <div class="fmn8x67">
					<div class="f1efquwu">Play Coins Balance</div>
					<div class="fddsvlq">
					   <div class="fn5go5s"><img src="<?php echo base_url() ?>assets/frontend/img/gold-coins.png" alt=""></div>
					   <div class="fgtyo0p"><?php echo number_format(@$userInfo['user_play_coins'], 0); ?></div>
					</div>
				 </div>
				  <?php if($userInfo['user_subscription_expiry_date']!='0000-00-00'){ ?>
				 <div class="f1vou0gj">Valid till <?php echo date('j M y', strtotime($userInfo['user_subscription_expiry_date'])); ?></div>
				<?php } ?>
			  </a>
			  <?php } ?>
			  
			
		   </div>
		</div>
	
		
		<div class="side-menu">
			<ul>
				<li><a href="<?php echo site_url('updateProfileImage') ?>"><i class="f1h2vptk fa fa-user-circle fa-lg"></i><span>Select Profile Image</span></a></li>
				<li><a href="<?php echo site_url('ManageProfile') ?>"><i class="f1h2vptk fa fas fa-user-edit fa-lg"></i> <span>Manage Profile</span></a></li>
					<li><a href="<?php echo site_url('Spin-Win') ?>" id="spinwheel"><i class="f1h2vptk fa fa-spinner fa-lg"></i><span>Spin & Win</span></a></li>
				<li><a href="<?php echo site_url('tournamentHistory') ?>"><i class="f1h2vptk fa fa-boxes fa-lg"></i><span>Tournament History</span></a></li>
				<li><a href="<?php echo site_url('Notifications') ?>"><i class="f1h2vptk fa fa-bell fa-lg"></i><span>Notifications <span class="badge bg-danger" style="background:red !important;"><?php if(!empty($this->unreadNotifications) && $this->unreadNotifications>0) { echo @$this->unreadNotifications; }  ?></span></span></a></li>
				
			</ul>
		
			<ul>
				<?php if($userInfo['user_type']=='2'){ ?>
				<li><a href="#" class="buy-bundle"><i class="f1h2vptk fa fa-cart-arrow-down"></i><span>Buy a Bundle</span></a></li>
			<?php } ?>
				<!--<li><a href="#"><i class="f1h2vptk fa fa-file-contract fa-lg"></i><span>Terms & Conditions</span></a></li>
				<li><a href="#"><i class="f1h2vptk fa fa-shield-alt fa-lg"></i><span>Privacy Policy</span></a></li>
				-->
				<li><a href="#" class="gpl_support"><i class="f1h2vptk fa fa-headset fa-lg"></i><span>Support</span></a></li>
				
				
			</ul>
		</div>
	</div>