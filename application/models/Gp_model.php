<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gp_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
    public function saveLoginSubscriptionUpdate($data){  
        $this->db->select("*", FALSE);
        $this->db->where('user_phone', $data['msisdn']);
        $this->db->order_by('user_id', 'DESC');
        $this->db->limit('1');
        $userData = $this->db->get('site_users');    //check msisdn exist or not

        if($userData->num_rows()>0){  //update data in site_user table

            $userInfo = $userData->result();
            $user_id = $userInfo[0]->user_id;
            $user_type = $userInfo[0]->user_type;
            $userSubscriptionExpiry = date("Y-m-d",strtotime($userInfo[0]->user_subscription_expiry_date));
			$newSubscriptionExpiry = date("Y-m-d", strtotime($data['subscription_expiry']));
			$today = date('Y-m-d');
            
			if($data['subscription_info'] == 'Premium' ){  //check if user new login is as premium 
			
				if($userSubscriptionExpiry == '0000-00-00' && $user_type == '2'){
					// if a premium user previously was a regular user 
					//coins update
					$userPlayCoins = '10000';
					$coin['coin_user_id'] 			=      $user_id;
					$coin['coin_date']              =       date("Y-m-d");
					$coin['coin_section']           =       7;
					$coin['coin_play_coins_add']    =   	$userPlayCoins;
					$coin['coin_type']              =       1;
					$coin['coin_added_on']          =       time();
					$this->db->insert('user_coins_history' , $coin);
					
					//add Notification for coins added
					$notifyData['notify_user_id'] =  $user_id;
					$notifyData['notify_type'] =  '6';  //1=TournamentCreated   2=Spin&Win   3=RedeemCoins   4=TournamentRewardAdded   5=UpdateProfileName    6=SubscriptionCoins   7=RewardAdded  8=RewardClaimed  9=VoucherExpired
					$notifyData['notify_title'] =  "Premium Subscription Coins";
					$notifyData['notify_desc'] =  "<b>10,000 Play Coins</b> added to your account for purchasing premium subscription.";
					$notifyData['notify_status'] =  '0';
					$notifyData['notify_date'] =  date('Y-m-d');
					$notifyData['notify_added_on'] =  time();
					$this->db->insert('user_notifications', $notifyData);
							
					$this->db->where('user_id', $user_id);
					$this->db->update('site_users', array('user_subscription_popup'=>'1', 'user_type' => '1','user_subscription_expiry_date' => $newSubscriptionExpiry, 'user_subscription' => '1', 'user_play_coins' => $userPlayCoins, 'user_updated_on' => time()));
				  
					//update skillpodid if not exists
					if(empty($userInfo[0]->skillpod_player_id)){
						$this->createGameboostId($user_id);
					}
				
				   return $user_id;
					
				} else {
					
					if($newSubscriptionExpiry == $userSubscriptionExpiry){
						//update skillpodid if not exists
						if(empty($userInfo[0]->skillpod_player_id)){
							$this->createGameboostId($user_id);
						}
						return $user_id;
					
					} else if($newSubscriptionExpiry > $userSubscriptionExpiry){
						
						$nextRenewalDate = date("Y-m-d", strtotime($userSubscriptionExpiry. '+ 1 day'));
						if($nextRenewalDate >= $today){
							
							$userPlayCoins = '10000';
							//coins update
							$coin['coin_user_id'] 			=      $user_id;
							$coin['coin_date']              =       date("Y-m-d");
							$coin['coin_section']           =       7;
							$coin['coin_play_coins_add']    =   	$userPlayCoins;
							$coin['coin_type']              =       1;
							$coin['coin_added_on']          =       time();
							$this->db->insert('user_coins_history' , $coin);
							
							//add Notification for coins added
							$notifyData['notify_user_id'] =  $user_id;
							$notifyData['notify_type'] =  '6';  //1=TournamentCreated   2=Spin&Win   3=RedeemCoins   4=TournamentRewardAdded   5=UpdateProfileName    6=SubscriptionCoins   7=RewardAdded  8=RewardClaimed  9=VoucherExpired
							$notifyData['notify_title'] =  "Premium Subscription Coins";
							$notifyData['notify_desc'] =  "<b>10,000 Play Coins</b> added to your account for purchasing premium subscription.";
							$notifyData['notify_status'] =  '0';
							$notifyData['notify_date'] =  date('Y-m-d');
							$notifyData['notify_added_on'] =  time();
							$this->db->insert('user_notifications', $notifyData);
							
							// add coins to user table
							$renewCoinsValue =  ($userInfo[0]->user_play_coins + $userPlayCoins);
							$this->db->where('user_id', $user_id);
							$this->db->update('site_users', array('user_subscription_popup'=>'1', 'user_type' => '1','user_subscription_expiry_date' => $newSubscriptionExpiry, 'user_subscription' => '1', 'user_play_coins' => $renewCoinsValue, 'user_updated_on' => time()));
							
							//update skillpodid if not exists
							if(empty($userInfo[0]->skillpod_player_id)){
								$this->createGameboostId($user_id);
							}
					
							return $user_id;
							
						} else {
							 //coins update
							if($userInfo[0]->user_play_coins >0){
								$coin['coin_user_id']  =      $user_id;
								$coin['coin_date']              =       $nextRenewalDate; 
								$coin['coin_section']           =       9;
								$coin['coin_play_coins_redeem']    =    $userInfo[0]->user_play_coins;
								$coin['coin_type']              =       1;
								$coin['coin_added_on']          =       time();
								$this->db->insert('user_coins_history' , $coin);
							}
							
							$userPlayCoins =  '10000';
							
							// add coins to user history table
							$coin2['coin_user_id'] 			=      $user_id;
							$coin2['coin_date']              =       date("Y-m-d");
							$coin2['coin_section']           =       7;
							$coin2['coin_play_coins_add']    =   	$userPlayCoins;
							$coin2['coin_type']              =       1;
							$coin2['coin_added_on']          =       time();
							$this->db->insert('user_coins_history' , $coin2);
							
							//add Notification for coins added
							$notifyData['notify_user_id'] =  $user_id;
							$notifyData['notify_type'] =  '6';  //1=TournamentCreated   2=Spin&Win   3=RedeemCoins   4=TournamentRewardAdded   5=UpdateProfileName    6=SubscriptionCoins   7=RewardAdded  8=RewardClaimed  9=VoucherExpired
							$notifyData['notify_title'] =  "Premium Subscription Coins";
							$notifyData['notify_desc'] =  "<b>10,000 Play Coins</b> added to your account for purchasing premium subscription.";
							$notifyData['notify_status'] =  '0';
							$notifyData['notify_date'] =  date('Y-m-d');
							$notifyData['notify_added_on'] =  time();
							$this->db->insert('user_notifications', $notifyData);
							
							
							// add coins to user table
							$this->db->where('user_id', $user_id);
							$this->db->update('site_users', array('user_subscription_popup'=>'1', 'user_type' => '1','user_subscription_expiry_date' => $newSubscriptionExpiry, 'user_subscription' => '1', 'user_play_coins' => $userPlayCoins, 'user_updated_on' => time()));
							
							//update skillpodid if not exists
							if(empty($userInfo[0]->skillpod_player_id)){
								$this->createGameboostId($user_id);
							}
					
							return $user_id;
						}
					
					} else {
						
						//update skillpodid if not exists
						if(empty($userInfo[0]->skillpod_player_id)){
							$this->createGameboostId($user_id);
						}
						return $user_id;
					}
				}
			
            } else {
				if($userInfo[0]->user_type == '1' && $userInfo[0]->user_play_coins >0){  
					// if  last time user was a premium user and have coins in db
					$coin['coin_user_id']  =      $user_id;
					$coin['coin_date']              =       date("Y-m-d", strtotime($userSubscriptionExpiry. '+ 1 day'));
					$coin['coin_section']           =       9;
					$coin['coin_play_coins_redeem']    =    $userInfo[0]->user_play_coins;
					$coin['coin_type']              =       1;
					$coin['coin_added_on']          =       time();
					$this->db->insert('user_coins_history' , $coin);
				}

                $this->db->where('user_phone', $data['msisdn']);
                $this->db->update('site_users', array('user_type' => '2','user_subscription' => '0','user_subscription_expiry_date' => '0000-00-00','user_play_coins'=>'0','user_updated_on' => time()));
                
				//update skillpodid if not exists
				if(empty($userInfo[0]->skillpod_player_id)){
					$this->createGameboostId($user_id);
				}
				
				return $user_id;
            }
        } else { //insert data in site_user table
            
			$updateData = array(
				'user_phone' => $data['msisdn'],
				'user_image' => 'default.png',
				'user_login_type' => '4',
				'user_registered_on' => date('Y-m-d H:i:s'),
				'user_added_on' => time(),
				'user_updated_on' => time()
			);
			
			$userPlayCoins = '10000';
			
			if($data['subscription_info'] == 'Premium'){  //check user premium or regular
				$newSubscriptionExpiry = date("Y-m-d", strtotime($data['subscription_expiry']));
				$today = date('Y-m-d');
				
                if( $newSubscriptionExpiry >= $today){
					//if expiry date of given json greater than or equal to today date
                    $updateData['user_type']  = '1';
                    $updateData['user_subscription']  = '1';
                    $updateData['user_play_coins']  = $userPlayCoins;
                    $updateData['user_subscription_expiry_date']  = $data['subscription_expiry'];
                    $updateData['user_subscription_popup']  = '1';
					
				} else {
                    $updateData['user_type']  = '2';
                    $updateData['user_subscription']  = '0';
                    $updateData['user_play_coins']  = '0';
					$updateData['user_subscription_expiry_date']  = '0000-00-00';
                }
            } else {
                $updateData['user_type']  = '2';
                $updateData['user_subscription']  = '0';
                $updateData['user_play_coins']  = '0';
				$updateData['user_subscription_expiry_date']  = '0000-00-00';
            }
			
			if($this->db->insert('site_users', $updateData)){
				
				$insertId = $this->db->insert_id();
				
				//create new gameboost id
				$this->createGameboostId($insertId);
				
				if($updateData['user_type']  == '1'){
				// add coins to user history table
					$coinNew['coin_user_id'] 			=      $insertId;
					$coinNew['coin_date']              =       date("Y-m-d");
					$coinNew['coin_section']           =       7;
					$coinNew['coin_play_coins_add']    =   	$userPlayCoins;
					$coinNew['coin_type']              =       1;
					$coinNew['coin_added_on']          =       time();
					$this->db->insert('user_coins_history' , $coinNew);
					
					
					//add Notification for coins added
					$notifyData['notify_user_id'] =  $insertId;
					$notifyData['notify_type'] =  '6';  //1=TournamentCreated   2=Spin&Win   3=RedeemCoins   4=TournamentRewardAdded   5=UpdateProfileName    6=SubscriptionCoins   7=RewardAdded  8=RewardClaimed  9=VoucherExpired

					$notifyData['notify_title'] =  "Premium Subscription Coins";
					$notifyData['notify_desc'] =  "<b>10,000 Play Coins</b> added to your account for purchasing premium subscription.";
					$notifyData['notify_status'] =  '0';
					$notifyData['notify_date'] =  date('Y-m-d');
					$notifyData['notify_added_on'] =  time();
					$this->db->insert('user_notifications', $notifyData);
				
				}
				
				return  $insertId;
				
			} else {
				return false;
			}
        }
    }
	
	
    public function checkTokenRequest($data){  
        $this->db->select("user_id", FALSE);
        $this->db->where('user_phone', $data['msisdn']);
        $userData = $this->db->get('site_users');    //check msisdn exist or not

        if($userData->num_rows()>0){  //update data in site_user table

            $userInfo = $userData->result();
            $user_id = $userInfo[0]->user_id;
            return $user_id;
        } 
		return false;
    }
	
	
    public function checkTokenRequest__new($data){  
        $this->db->select("*", FALSE);
        $this->db->where('user_phone', $data['msisdn']);
        $userData = $this->db->get('site_users');    //check msisdn exist or not

        if($userData->num_rows()>0){  //update data in site_user table

            $userInfo = $userData->result();
            $user_id = $userInfo[0]->user_id;
            return $user_id;
        } else {
			
			//print_r($data);
			
			$updateData = array(
				'user_phone' => $data['msisdn'],
				'user_image' => 'default.png',
				'user_login_type' => '4',
				'user_registered_on' => date('Y-m-d H:i:s'),
				'user_added_on' => time(),
				'user_updated_on' => time()
			);
			
			$userPlayCoins = '10000';
			
			if($data['subscription_info'] == 'Premium'){  //check user premium or regular
				$newSubscriptionExpiry = date("Y-m-d", strtotime($data['subscription_expiry']));
				$today = date('Y-m-d');
				
                if( $newSubscriptionExpiry >= $today){
					//if expiry date of given json greater than or equal to today date
                    $updateData['user_type']  = '1';
                    $updateData['user_subscription']  = '1';
                    $updateData['user_play_coins']  = $userPlayCoins;
                    $updateData['user_subscription_expiry_date']  = $data['subscription_expiry'];
                    $updateData['user_subscription_popup']  = '1';
					
					
				} else {
                    $updateData['user_type']  = '2';
                    $updateData['user_subscription']  = '0';
                    $updateData['user_play_coins']  = '0';
					$updateData['user_subscription_expiry_date']  = '0000-00-00';
                }
            } else {
                $updateData['user_type']  = '2';
                $updateData['user_subscription']  = '0';
                $updateData['user_play_coins']  = '0';
				$updateData['user_subscription_expiry_date']  = '0000-00-00';
            }
			
			if($this->db->insert('site_users', $updateData)){
				
				$insertId = $this->db->insert_id();
				
				//create new gameboost id
				$this->createGameboostId($insertId);
				
				if($updateData['user_type']  == '1'){
				// add coins to user history table
					$coinNew['coin_user_id'] 			=      $insertId;
					$coinNew['coin_date']              =       date("Y-m-d");
					$coinNew['coin_section']           =       7;
					$coinNew['coin_play_coins_add']    =   	$userPlayCoins;
					$coinNew['coin_type']              =       1;
					$coinNew['coin_added_on']          =       time();
					$this->db->insert('user_coins_history' , $coinNew);
					
					
					//add Notification for coins added
					$notifyData['notify_user_id'] =  $insertId;
					$notifyData['notify_type'] =  '6';  //1=TournamentCreated   2=Spin&Win   3=RedeemCoins   4=TournamentRewardAdded   5=UpdateProfileName    6=SubscriptionCoins   7=RewardAdded  8=RewardClaimed  9=VoucherExpired

					$notifyData['notify_title'] =  "Premium Subscription Coins";
					$notifyData['notify_desc'] =  "<b>10,000 Play Coins</b> added to your account for purchasing premium subscription.";
					$notifyData['notify_status'] =  '0';
					$notifyData['notify_date'] =  date('Y-m-d');
					$notifyData['notify_added_on'] =  time();
					$this->db->insert('user_notifications', $notifyData);
				
				}
				
				return  $insertId;
				
			} else {
				return false;
			}
		}
		
		//return false;
    }
	
	
	
	function getUserInfo($msisdn){
		$this->db->select("*", FALSE);
		$this->db->where('user_phone', $msisdn);
		return  $this->db->get('site_users');
    }
	
	function getUser($id){
		$this->db->select("*", FALSE);
		$this->db->where('user_id', $id);
		return  $this->db->get('site_users')->row();
    }
     
	function createShareCode($length){
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		return substr(str_shuffle($str_result), 0, $length);
	}

	function createGameboostId($userId){
		/* if(!empty($userId)){
			$userInfo = $this->getUser($userId);
			
			$gameboostMSISDN = $userInfo->user_phone;
			$gameboostNickname = "gpbd_".$userId;
			$gameboostEmail = "gpbd_".$userInfo->user_phone."@igpl.pro";
			$gameboostPassword = $this->createShareCode(12);
			
			$postArray = array(
			'nickname' => $gameboostNickname,
			'email' => $gameboostEmail,
			'msisdn' => $gameboostMSISDN,
			'password' => $gameboostPassword,
			'gender' => 'male',
			'date_of_birth' => '1990-01-01'
			);
			
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			 // CURLOPT_URL => 'https://games.igpl.pro/xml-api/register_player',
			  CURLOPT_URL => 'https://games.igpl.pro/xml-api/register_player_gp',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => $postArray,
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJwYXJ0bmVyX2NvZGUiOiJ0ZXN0LTAwMSIsInBhcnRuZXJfcGFzc3dvcmQiOiJ0ZXN0LTAwMSJ9.GQp4_XWFc1FkHHGoy6XWVe40_QHCUt4ityt57ahXoEMW2AhNHo27V_wJmypgZshbw1w6345mKffaGtf9XowGOA'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
				
			$xmlResponse = simplexml_load_string($response);
			
			$status = $xmlResponse->register_player->result;
			
			if(!empty($status) && $status == 'success'){
				$skillpod_player_id = $xmlResponse->register_player->skillpod_player_id;
				$skillpod_player_key = $xmlResponse->register_player->skillpod_player_key;
				
				$dataUser['user_email'] = $gameboostEmail;
				$dataUser['skillpod_nickname'] = $gameboostNickname;
				$dataUser['skillpod_password'] = $gameboostPassword;
				$dataUser['skillpod_object_id'] = $gameboostMSISDN;
				$dataUser['skillpod_player_id'] = $skillpod_player_id;
				$dataUser['skillpod_player_key'] = $skillpod_player_key;
				
				$this->db->where('user_id', $userId);
				$this->db->update('site_users', $dataUser);
			}  
		} */  
	}
	
	
	function createGameboostIdGP($userId){
		 if(!empty($userId)){
			$userInfo = $this->getUser($userId);
			
			$gameboostMSISDN = $userInfo->user_phone;
			$gameboostNickname = "gpbd_".$userId;
			$gameboostEmail = "gpbd_".$userInfo->user_phone."@igpl.pro";
			$gameboostPassword = $this->createShareCode(12);
			
			$postArray = array(
			'nickname' => $gameboostNickname,
			'email' => $gameboostEmail,
			'msisdn' => $gameboostMSISDN,
			'password' => $gameboostPassword,
			'gender' => 'male',
			'date_of_birth' => '1990-01-01'
			);
			
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			 // CURLOPT_URL => 'https://games.igpl.pro/xml-api/register_player',
			  CURLOPT_URL => 'https://games.igpl.pro/xml-api/register_player_gp',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => $postArray,
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJwYXJ0bmVyX2NvZGUiOiJ0ZXN0LTAwMSIsInBhcnRuZXJfcGFzc3dvcmQiOiJ0ZXN0LTAwMSJ9.GQp4_XWFc1FkHHGoy6XWVe40_QHCUt4ityt57ahXoEMW2AhNHo27V_wJmypgZshbw1w6345mKffaGtf9XowGOA'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
				
			$xmlResponse = simplexml_load_string($response);
			
			$status = $xmlResponse->register_player->result;
			
			if(!empty($status) && $status == 'success'){
				$skillpod_player_id = $xmlResponse->register_player->skillpod_player_id;
				$skillpod_player_key = $xmlResponse->register_player->skillpod_player_key;
				
				$dataUser['user_email'] = $gameboostEmail;
				$dataUser['skillpod_nickname'] = $gameboostNickname;
				$dataUser['skillpod_password'] = $gameboostPassword;
				$dataUser['skillpod_object_id'] = $gameboostMSISDN;
				$dataUser['skillpod_player_id'] = $skillpod_player_id;
				$dataUser['skillpod_player_key'] = $skillpod_player_key;
				
				$this->db->where('user_id', $userId);
				$this->db->update('site_users', $dataUser);
			}  
		}   
	}
	
	

	
}