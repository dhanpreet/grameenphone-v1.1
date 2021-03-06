<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class Site extends CI_Controller {
		
	var $unreadNotifications = '0';
	var $quickTournamentEnabled = 0;
	var $createTournamentEnabled = 0;
	var $freeTournamentEnabled = 0;
	var $vipTournamentEnabled = 0;
	var $globalLeaderboardEnabled = 0;
	var $practiceBannersEnabled = 0;
	var $redemptionCoinsEnabled = 0;
	var $redemptionDataPackEnabled = 0;
	var $redemptionTalkTimeEnabled = 0;
	var $redemptionGameAccessEnabled = 0;
	var $payAndPlayTournamentEnabled	=	0;
	var $unseenTournamentsResults	=	array();
	
	 public  function __construct(){
        parent:: __construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('text');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->model('site_model','SITEDBAPI');
		//$this->load->helper('timezone');
        //timezone();  // timezone set using helper 
		 date_default_timezone_set("Asia/Dhaka");
		
		
		
		//$userId = $this->session->userdata('userId');	
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
		} else {
			$userId = base64_decode($this->uri->segment(2));
		}
		
		$notifyCount	= $this->SITEDBAPI->getUserUnreadNotificationsCount($userId);
		$this->unreadNotifications	= $notifyCount['rows_count'];
		
		// Get unseen tournaments results
		$prizeUnseen	= $this->SITEDBAPI->getUserUnseenResults($userId);
		$this->unseenTournamentsResults = $prizeUnseen;
		
		//Get The portal enabled/ disabled settings
		$portalSettings	= $this->SITEDBAPI->getPortalSettings();
		
	
		if( $this->search_exif($portalSettings, 'vip_tournaments') ){ 
			$this->vipTournamentEnabled	= 1;
		}
		if( $this->search_exif($portalSettings, 'free_tournaments') ){ 
			$this->freeTournamentEnabled	= 1;
		}
	
		if( $this->search_exif($portalSettings, 'pay_and_play_tournaments') ){ 
			$this->payAndPlayTournamentEnabled	= 1;
		}
    }
	
	function search_exif($exif, $field){
		foreach ($exif as $data){
			if ($data['name'] == $field)
				return $data['enabled'];
		}
	}
	
	
	public function demo()	{
		echo "Old Server"; die;
	}
	
	public function error()	{
		$this->load->view('site/error');
	}
	public function JwtError(){
    	$this->load->view('site/jwt_error');
    }
	public function privacyPolicy()	{
		$this->load->view('site/privacy_policy');
	}
	
	public function terms()	{
		$this->load->view('site/terms_of_use');
	}
	
	function createShareCode($length){
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		return substr(str_shuffle($str_result), 0, $length);
	}

	function createOTP($length){
		$str_result = '0123456789';
		return substr(str_shuffle($str_result), 0, $length);
	}


	public function index()	{
		$userId = '';
		$user_login_type = '1';   //1=manual  2=Facebook  3=Google 4=gpApp
		// Get Test user details
		if(!empty($_GET['token'])) {
			$id = base64_decode($_GET['token']);  
			$userInfo = $this->SITEDBAPI->validateUser($id);

			if(!empty($userInfo['user_id'])){
				$userId = $userInfo['user_id'];  
				$user_login_type = $userInfo['user_login_type'];
				if($userInfo['user_status'] == 1){
					if(empty($userInfo['skillpod_player_id'])){
						$personEmail = $userInfo['user_email'];
						//$this->createGameboostId($userId, $personEmail);
					}
				} else {
					redirect('error');
				}			
			} else {
				//redirect('Login');
			}
		} else {
			if($this->uri->segment(2)=='User'){
                $id = base64_decode($this->uri->segment(3));
			} else {
				$id = base64_decode($this->uri->segment(2));
			}
			
			if(!empty($id)){
				$userInfo = $this->SITEDBAPI->validateUser($id);
				if(!empty($userInfo['user_id'])){
					$userId = $userInfo['user_id'];  
					$user_login_type = $userInfo['user_login_type'];
					if($userInfo['user_status'] == 1){
						if(empty($userInfo['skillpod_player_id'])){
							$personEmail = $userInfo['user_email'];
							//$this->createGameboostId($userId, $personEmail);
						}
					} else {
						redirect('error');
					}			
				} else {
					redirect('error');
				}
			} else {
				redirect('error');
			}
		}
		
		
		if(empty($userId) || $userId==''){
			$this->session->set_flashdata("error","Error! Please login first to access this portal.");
			redirect('error');
		} 
	
		// avoid session
		//	$this->session->set_userdata('userId', $userId);
		//	$this->session->set_userdata('user_login_type', $user_login_type);
	
		$data['userInfo'] = $this->SITEDBAPI->getSiteUserDetail($userId);
		$data['userToken'] = base64_encode($userId);
		
		
		//set popup value 0 for the premium user
		$this->db->where('user_id', $userId);
        $this->db->update('site_users', array('user_subscription_popup' => '0'));
		
		
		// get user unseen tournament rewards list
		$data['unseenTournamentsResults'] = $this->unseenTournamentsResults;
		$this->SITEDBAPI->setUpdateUnseenTournamentsResults($data['unseenTournamentsResults']);
		
		
		if($this->vipTournamentEnabled == 1){
			//$data['vipTournaments'] = $this->SITEDBAPI->getVipTournamentList($limit=1);
			
				$data['vipTournaments'] = array();
				//$heroTournaments = $this->SITEDBAPI->getVipTournamentList($limit=1);
				$heroTournaments = $this->SITEDBAPI->getPortalTournamentList($section='2',$limit=1);
				$heroCount = 0;
				
				foreach($heroTournaments as $row){
					$checkJoinedTounament = $this->SITEDBAPI->checkJoinedTournamentPlayer($row['tournament_id'], $userId);
					$data['vipTournaments'][$heroCount] = $row;
					$myRank = 0;
					$myScore = 0;
					$joinedStatus = false;
					
					if($checkJoinedTounament > 0){
						// set user joined the tournament
						$joinedStatus = true;
						$heroTournamentPlayers = $this->SITEDBAPI->getLiveTournamentPlayersListDESC($row['tournament_id']);
						
						if(is_array($heroTournamentPlayers) && count($heroTournamentPlayers)>0){
							
							$highest_score = $heroTournamentPlayers[0]['player_score'];
							$rank = 1;
							
							foreach($heroTournamentPlayers as $rowPlayer){
								if($rowPlayer['user_id'] == $userId){
									$myScore = $rowPlayer['player_score'];
								}
								if($highest_score !=0 && $rowPlayer['player_score'] == $highest_score){
								} else {
									if($rowPlayer['player_score'] > 0 ){
										//$rank++;
									}  else {
										$rank = 0;
									}
									$highest_score = $rowPlayer['player_score'];
								}
								
								if($rowPlayer['user_id'] == $userId){
									$myRank = $rank;
								}
								$rank++;
							}
						}
					}	
					
					if($row['fee_tournament_rewards'] == 4){
						$voucherPrize = ($this->SITEDBAPI->getVoucherdetailbyid($row['fee_tournament_prize_1'])['vt_type'] + 
						$this->SITEDBAPI->getVoucherdetailbyid($row['fee_tournament_prize_2'])['vt_type'] + 
						$this->SITEDBAPI->getVoucherdetailbyid($row['fee_tournament_prize_3'])['vt_type'] + 
						(@$this->SITEDBAPI->getVoucherdetailbyid($row['fee_tournament_prize_4'])['vt_type'] * 7) + 
						(@$this->SITEDBAPI->getVoucherdetailbyid($row['fee_tournament_prize_5'])['vt_type'] * 40));
						
						$data['vipTournaments'][$heroCount]['voucherPrize'] = $voucherPrize;
					}
					
					$data['vipTournaments'][$heroCount]['joinedStatus'] = $joinedStatus;
					$data['vipTournaments'][$heroCount]['myScore'] = $myScore;
					$data['vipTournaments'][$heroCount]['myRank'] = $myRank;
					
					$heroCount++;
				}
		}
		
		if($this->freeTournamentEnabled == 1){
			//$data['freeTournaments'] = $this->SITEDBAPI->getFreeTournamentList($limit=1);
				$data['freeTournaments'] = array();
				//$freeTournaments = $this->SITEDBAPI->getFreeTournamentList($limit=1);
				$freeTournaments = $this->SITEDBAPI->getPortalTournamentList($section='1',$limit=1);
				$freeCount = 0;
				
				foreach($freeTournaments as $freeRow){
					$checkJoinedTounament = $this->SITEDBAPI->checkJoinedTournamentPlayer($freeRow['tournament_id'], $userId);
					$data['freeTournaments'][$freeCount] = $freeRow;
					$myRank = 0;
					$myScore = 0;
					$joinedStatus = false;
					
					if($checkJoinedTounament > 0){
						// set user joined the tournament
						$joinedStatus = true;
						$heroTournamentPlayers = $this->SITEDBAPI->getLiveTournamentPlayersListDESC($freeRow['tournament_id']);
						
						if(is_array($heroTournamentPlayers) && count($heroTournamentPlayers)>0){
							
							$highest_score = $heroTournamentPlayers[0]['player_score'];
							$rank = 1;
							
							foreach($heroTournamentPlayers as $rowPlayer){
								if($rowPlayer['user_id'] == $userId){
									$myScore = $rowPlayer['player_score'];
								}
								if($highest_score !=0 && $rowPlayer['player_score'] == $highest_score){
								} else {
									if($rowPlayer['player_score'] > 0 ){
										//$rank++;
									}  else {
										$rank = 0;
									}
									$highest_score = $rowPlayer['player_score'];
								}
								
								if($rowPlayer['user_id'] == $userId){
									$myRank = $rank;
								}
								$rank++;
							}
						}
					}	
					
					if($freeRow['fee_tournament_rewards'] == 4){
						//$voucherPrize = ($this->SITEDBAPI->getVoucherdetailbyid($freeRow['fee_tournament_prize_1']) ['vt_type'] * 10);
						
						if($freeRow['fee_tournament_prize_1']>0 && $freeRow['fee_tournament_prize_2']>0 && $freeRow['fee_tournament_prize_3']>0){
							$voucherPrize = ($this->SITEDBAPI->getVoucherdetailbyid($freeRow['fee_tournament_prize_1']) ['vt_type']+$this->SITEDBAPI->getVoucherdetailbyid($freeRow['fee_tournament_prize_2']) ['vt_type']+$this->SITEDBAPI->getVoucherdetailbyid($freeRow['fee_tournament_prize_3']) ['vt_type']);
						} else {
							$voucherPrize = ($this->SITEDBAPI->getVoucherdetailbyid($freeRow['fee_tournament_prize_1']) ['vt_type'] * 10);
						}
						$data['freeTournaments'][$freeCount]['voucherPrize'] = $voucherPrize;
					}
					
					$data['freeTournaments'][$freeCount]['joinedStatus'] = $joinedStatus;
					$data['freeTournaments'][$freeCount]['myScore'] = $myScore;
					$data['freeTournaments'][$freeCount]['myRank'] = $myRank;
					
					$freeCount++;
				}
		}

		if($this->payAndPlayTournamentEnabled==1){
			//$data['payAndPlayTournaments'] = $this->SITEDBAPI->getPayAndPlayTournamentList($limit=1);
			
			
				$data['payAndPlayTournaments'] = array();
				//$payAndPlayTournaments = $this->SITEDBAPI->getPayAndPlayTournamentList($limit=1);
				$payAndPlayTournaments = $this->SITEDBAPI->getPortalTournamentList($section='3',$limit=1);
				$ppCount = 0;
				
				foreach($payAndPlayTournaments as $ppRow){
					$checkJoinedTounament = $this->SITEDBAPI->checkJoinedTournamentPlayer($ppRow['tournament_id'], $userId);
					$data['payAndPlayTournaments'][$ppCount] = $ppRow;
					$myRank = 0;
					$myScore = 0;
					$joinedStatus = false;
					
					if($checkJoinedTounament > 0){
						// set user joined the tournament
						$joinedStatus = true;
						$heroTournamentPlayers = $this->SITEDBAPI->getLiveTournamentPlayersListDESC($ppRow['tournament_id']);
						
						if(is_array($heroTournamentPlayers) && count($heroTournamentPlayers)>0){
							
							$highest_score = $heroTournamentPlayers[0]['player_score'];
							$rank = 1;
							
							foreach($heroTournamentPlayers as $rowPlayer){
								if($rowPlayer['user_id'] == $userId){
									$myScore = $rowPlayer['player_score'];
								}
								if($highest_score !=0 && $rowPlayer['player_score'] == $highest_score){
								} else {
									if($rowPlayer['player_score'] > 0 ){
										//$rank++;
									}  else {
										$rank = 0;
									}
									$highest_score = $rowPlayer['player_score'];
								}
								
								if($rowPlayer['user_id'] == $userId){
									$myRank = $rank;
								}
								$rank++;
							}
						}
					}	
					
					if($ppRow['fee_tournament_rewards'] == 4){
						$voucherPrize = ($this->SITEDBAPI->getVoucherdetailbyid($ppRow['fee_tournament_prize_1']) ['vt_type'] + 
						$this->SITEDBAPI->getVoucherdetailbyid($ppRow['fee_tournament_prize_2']) ['vt_type'] + 
						$this->SITEDBAPI->getVoucherdetailbyid($ppRow['fee_tournament_prize_3']) ['vt_type'] + 
						(@$this->SITEDBAPI->getVoucherdetailbyid($ppRow['fee_tournament_prize_4']) ['vt_type'] * 7) + 
						(@$this->SITEDBAPI->getVoucherdetailbyid($ppRow['fee_tournament_prize_5']) ['vt_type'] * 10));
						
						$data['payAndPlayTournaments'][$ppCount]['voucherPrize'] = $voucherPrize;
					}
			
					$data['payAndPlayTournaments'][$ppCount]['joinedStatus'] = $joinedStatus;
					$data['payAndPlayTournaments'][$ppCount]['myScore'] = $myScore;
					$data['payAndPlayTournaments'][$ppCount]['myRank'] = $myRank;
					
					$ppCount++;
				}
			
		}
		
		$data['actionGames'] = $this->SITEDBAPI->getHomeGenreGamesList($type='action', $limit=5);
		$data['arcadeGames'] = $this->SITEDBAPI->getHomeGenreGamesList($type='arcade', $limit=5);
		$data['adventureGames'] = $this->SITEDBAPI->getHomeGenreGamesList($type='adventure', $limit=5);
		$data['sportsGames'] = $this->SITEDBAPI->getHomeGenreGamesList($type='sports', $limit=5);
		$data['puzzleGames'] = $this->SITEDBAPI->getHomeGenreGamesList($type='puzzle', $limit=5);
		$data['session_page_type']=1;
		$this->load->view('site/home',$data);
		
	}
	
	
	function getUser($id){
		$this->db->select("user_id, user_phone, user_email", FALSE);
		$this->db->where('user_id', $id);
		return  $this->db->get('site_users')->row();
    }
	
	public function createGameboostId($userId, $gameboostEmail=''){
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
			  //CURLOPT_URL => 'https://games.igpl.pro/xml-api/register_player',
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
	
	
	public function showPortal(){
		
		//$token = base64_decode(@$_GET['token']);
		$token = @$_GET['token'];
		
		if(empty($token)){
			redirect('error');
		} else {
			$data['token'] = $token;
			$this->load->view('site/welcome_screen', $data);
		}	
	}
	
		
	public function useraccess(){
		$token = base64_decode(@$_GET['token']);
		if(empty($token)){
			redirect('error');
		} else {
			
			$tokenArr = explode("-", $token);
			
			$uid = $tokenArr[0];
			//$id = $tokenArr[1];
			$msisdn = $tokenArr[1];
			
			//$userInfo = $this->SITEDBAPI->getSiteUserDetail($id);
			$userInfo = $this->db->query("SELECT user_id, user_type, user_subscription_popup FROM tbl_site_users WHERE user_phone = '$msisdn' ")->row_array();
			$id = $userInfo['user_id'];
			// Get unseen tournaments results
			$prizeUnseen	= $this->SITEDBAPI->getUserUnseenResults($id);
			$this->unseenTournamentsResults = $prizeUnseen;
		
			if($userInfo['user_type']=='1' && $userInfo['user_subscription_popup']=='1'){
				//premium
				$url = site_url("Welcome/".base64_encode($id));
				
				// update the popup value to hide welcome screen
				$updateData['user_subscription_popup'] = '0';
				$this->db->where('user_id', $id);
				$this->db->update('site_users', $updateData);
				
			} else{
				//$url = base_url()."home/".base64_encode($id)."/".$uid;
				$url = site_url("home/".base64_encode($id));
			}
			redirect($url);
		}	
	}
	
	
    public function PremiumUser(){
		$this->load->view('site/subscription_welcome.php');	
	}
	 
	public function userNameupdate(){
		$this->load->view('site/name_update.php');	
	}

	public function updateusername(){
		$data['name']=$_POST['user_name'];
		$data['id']=base64_decode($_POST['token']);
		$userId = $this->SITEDBAPI->signup_name($data);
		
		//add Notification
		$notifyData['notify_user_id'] =  $data['id'];
		$notifyData['notify_type'] =  '5';  //1=TournamentCreated   2=Spin&Win   3=RedeemCoins   4=TournamentRewardAdded   5=UpdateProfileName    6=SubscriptionCoins   7=RewardAdded  8=RewardClaimed  9=VoucherExpired

		$notifyData['notify_title'] =  "Profile Settings";
		$notifyData['notify_desc'] =  "Profile name updated successfully.";
		$notifyData['notify_status'] =  '0';
		$notifyData['notify_date'] =  date('Y-m-d');
		$notifyData['notify_added_on'] =  time();
		$this->db->insert('user_notifications', $notifyData);
				
	    redirect('home/'.$_POST["token"]);
	}

	
	
// *****************************   *************************************** ********************************** //
// *****************************   Live  VIP/Pay&Play/Free Tournaments Starts Here ********************************** //
// *****************************   *************************************** ********************************** //


	public function getLiveTournament($id){
		
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
		}
		
		$userInfo = $this->SITEDBAPI->getSiteUserDetail($userId);
		$id = base64_decode($id);
		
		//check playerid first
		if(empty($userInfo['skillpod_player_id'])){
			$personEmail = $userInfo['user_email'];
			$this->createGameboostId($userId, $personEmail);
		}
		
		//print_r($userInfo);
		//$this->session->set_userdata('sess_tournament_id', base64_encode($id));
		// Get tournament info
		//$this->session->set_userdata('tournament','VIP');
		
		$data['tournamentInfo'] = $this->SITEDBAPI->getLiveTournamentInfo($id);
		if(is_array($data['tournamentInfo']) && count($data['tournamentInfo'])>0){
			
			$data['playersCount'] = $this->SITEDBAPI->getLiveTournamentPlayersCount($id);
			$data['playersInfo'] = $this->SITEDBAPI->getLiveTournamentPlayersListDESC($id);
			$data['checkPlayerEntry'] = $this->SITEDBAPI->checkLiveTournamentPlayer($userId, $id);
			$data['totalPlayersCount'] = count($data['playersInfo']);
			
			$myRank = 0;
			$myScore = 0;
			$iCount = 0;
			$joinedStatus = false;
			
			// the user already joined this tournament
			if(!empty($data['checkPlayerEntry']['player_id'])){
			
				// set user joined the tournament
				$joinedStatus = true;
				
				if(is_array($data['playersInfo']) && count($data['playersInfo'])>0){
					/*
					$highest_score = $data['playersInfo'][0]['player_score'];
					$rank = 1;
					
					foreach($data['playersInfo'] as $rowPlayer){
						if($rowPlayer['user_id'] == $userId){
							$myScore = $rowPlayer['player_score'];
						}
						if($highest_score !=0 && $rowPlayer['player_score'] == $highest_score){
						} else {
							if($rowPlayer['player_score'] > 0 ){
								$rank++;
							} 
							$highest_score = $rowPlayer['player_score'];
						}
						
						if($rowPlayer['user_id'] == $userId){
							$myRank = $rank;
						}
					}
					*/
					
					$highest_score = $data['playersInfo'][0]['player_score'];
					$rank = 1;
					
					foreach($data['playersInfo'] as $rowPlayer){
						if($rowPlayer['player_score'] >0){
							if($highest_score !=0 && $rowPlayer['player_score'] == $highest_score){
								// don't change the rank for user
							} else {
								if($rowPlayer['player_score'] > 0 ){
									//$rank++;
								} else {
									$rank = 0;
								}
							$highest_score = $rowPlayer['player_score'];
							}
							
							if($rowPlayer['user_id'] == $userId){
								$myRank = $rank;
								$myScore = $rowPlayer['player_score'] ;
								break;
							}
							//$iCount++;
							$rank++;
						
						}
					}
					
				}
			}	
		
			$data['joinedStatus'] = $joinedStatus;
			$data['myScore'] = $myScore;
			$data['myRank'] = $myRank;
			
			$data['userInfo']  = $this->SITEDBAPI->getSiteUserDetail($userId);
			$data['checkPlayerEntry'] = $this->SITEDBAPI->checkLiveTournamentPlayer($userId, $id);
			if($data['checkPlayerEntry']){
				$data['joined']=true;
			}
			else{
				$data['joined']=false;
			}
			$data['session_page_type']=2;
			$data['session_tournament_id']=$id;
			$data['session_game_id']=$data['tournamentInfo']['tournament_game_id'];
/* 			
			
echo "<pre>";
print_r($data);
echo "</pre>";
			 */
			$this->load->view('site/live_tournament_info', $data);

		} else {
			redirect();
		}
	}

	public function managePlayCoinsHistory($userId, $section, $coin_type, $coins, $tournament_id=''){
		if(!empty($userId)){
			$coin['coin_user_id']           =   	$userId;
			$coin['coin_date']              =   	date("Y-m-d");
			$coin['coin_section']           =   	$section;
			if($coin_type == 'add')
				$coin['coin_play_coins_add']    =   $coins;
			if($coin_type == 'redeem')
				$coin['coin_play_coins_redeem']    =  $coins;
			
			$coin['coin_tournament_id']		=		$tournament_id;
			$coin['coin_type']              =   	1;
			$coin['coin_added_on']          =   	time();
			$this->db->insert('tbl_user_coins_history' , $coin);
		}
	}
	
	public function updateUserPlayCoins($userId, $coin_type, $coins){
		if(!empty($userId)){
			$userInfo = $this->SITEDBAPI->getSiteUserDetail($userId);
			$userPlayCoins = $userInfo['user_play_coins'];
			
			if($coin_type == 'add')
				$dataCoins['user_play_coins']    =   ($userPlayCoins+$coins);
			if($coin_type == 'redeem')
				$dataCoins['user_play_coins']    = ($userPlayCoins-$coins);
			
			$this->db->where('user_id' , $userId);
			$this->db->update('tbl_site_users' , $dataCoins);
		}
	}
	

	public function playLiveTournament($id){
		
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
			$userToken = base64_encode($userId);
		}
		
		$tournament_id = base64_decode($id); 
		$joinedStatus = false;

		if(!empty($userId) && !empty($tournament_id)){
			
			//check playerid first
			$userInfo = $this->SITEDBAPI->getSiteUserDetail($userId);
			if(empty($userInfo['skillpod_player_id'])){
				$personEmail = $userInfo['user_email'];
				$this->createGameboostId($userId, $personEmail);
			}
			
			
			// Get tournament info
			$data['tournamentInfo'] = $this->SITEDBAPI->getLiveTournamentInfo($tournament_id);
			$data['userInfo'] = $this->SITEDBAPI->getSiteUserDetail($userId);
			$data['checkPlayerEntry'] = $this->SITEDBAPI->checkLiveTournamentPlayer($userId, $tournament_id);
			if(!empty($data['checkPlayerEntry']['player_id'])){
				$joinedStatus = true;
			}
			
			if($data['userInfo']['user_type'] == '2' && $data['tournamentInfo']['tournament_section']!='1' && $joinedStatus == false){
				redirect('LiveTournament/'.$id.'/?token='.$userToken);
			}

			$userPlayCoins = $data['userInfo']['user_play_coins'];
			$entryFee = $data['tournamentInfo']['fee_tournament_fee'];
			
			if(!$joinedStatus){
				
				// Join the user 
				$savePlayer['player_t_id'] = $tournament_id;
				$savePlayer['player_user_id'] = $userId;
				$savePlayer['player_score'] = 0;
				$savePlayer['player_type'] = '2';
				$savePlayer['player_added_on'] = time();
				$this->db->insert('tournaments_players', $savePlayer);
		
				$this->updateUserPlayCoins($userId, $coin_type='redeem', $coins=$entryFee);
				$this->managePlayCoinsHistory($userId, $section='6', $coin_type='redeem', $coins=$entryFee, $tournament_id);
				
				//Save User Notification
				if($entryFee > 0){
					$notifyDesc = "<b>{$entryFee} Play Coins</b> redeemed for participating a tournament.";
					$this->saveUserNotification($userId, $type='1', $notifyDesc);
				}
						
			}
				
			$gameId = $data['tournamentInfo']['tournament_gameboost_id'];
			$playerProfileId = $data['userInfo']['skillpod_player_id'];
			
			// Update the Report for the user wise tournament game play count
			$this->addReportUserGamePlay($type=2, $gameId, $tournament_id);

			$data['game_id'] = $gameId;
			$data['player_profile_id'] = $playerProfileId;
			$data['tournament_id'] = $tournament_id;
			$data['session_page_type']=4;
			$data['session_tournament_id']=$tournament_id;
			$data['session_game_id']=$data['tournamentInfo']['tournament_game_id'];
			
			$this->load->view('site/live_tournament_play_game', $data);
			//$this->load->view('site/live_tournament_play_game_new', $data);
			
		} else {
			redirect();
		}
	}


	public function updateLiveTournamentPlayerScore($tournament_id='', $game_id='', $skillpod_player_id='', $redirect=''){
	
		if(!empty($tournament_id) && !empty($game_id) && !empty($skillpod_player_id) && !empty($redirect)){
			
			//$userId = $this->session->userdata('userId');
			if(!empty($_GET['token'])){
				$userId = base64_decode($_GET['token']);
				//$data['userToken'] = base64_encode($userId);
			}
			
			$tournament_id =  base64_decode($tournament_id);
			$game_id = $game_id;
			$skillpod_player_id =  $skillpod_player_id;
			$redirect_path =  $redirect;
			
			$tournamentInfo = $this->SITEDBAPI->getLiveTournamentInfo($tournament_id);
			
			// Get current user score starts
			$postArray = array('game_id' => $game_id,'player_id' => $skillpod_player_id);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			 // CURLOPT_URL => 'https://games.igpl.pro/xml-api/get_player_scores',
			  CURLOPT_URL => 'https://games.igpl.pro/xml-api/get_player_scores_gp', 
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => $postArray,
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJwYXJ0bmVyX2NvZGUiOiJ0ZXN0LTAwMSIsInBhcnRuZXJfcGFzc3dvcmQiOiJ0ZXN0LTAwMSJ9.GQp4_XWFc1FkHHGoy6XWVe40_QHCUt4ityt57ahXoEMW2AhNHo27V_wJmypgZshbw1w6345mKffaGtf9XowGOA'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			
			$responseXML = simplexml_load_string($response);
			$responseJSON = json_encode($responseXML);

			// Convert into associative array
			$responseArray = json_decode($responseJSON, true);
		 	$userScore = @$responseArray['get_player_scores']['player_scores']['player_score_0']['score'];
		 	$scoreDate = @$responseArray['get_player_scores']['player_scores']['player_score_0']['time'];
			$scoreDate = date('Y-m-d', strtotime($scoreDate.'+6 hours'));
			
			$t_start_date = $tournamentInfo['tournament_start_date'];
			$t_end_date = $tournamentInfo['tournament_end_date'];
			
			if($t_start_date <= $scoreDate &&  $t_end_date >= $scoreDate ){
				if(!empty($userScore)){
					$currentScore = $userScore;
				} else {
					$currentScore = 0;
				}
			} else {
				$currentScore = 0;
			}
			
			//Get User last saved score
			$scoreInfo = $this->SITEDBAPI->getLiveTournamentPlayerScore($tournament_id, $userId);
			$lastScore = @$scoreInfo['player_score'];
			$player_id = @$scoreInfo['player_id'];
			
			if($currentScore > $lastScore){
				$saveScore['player_score'] = $currentScore;
				$saveScore['player_score_updated'] = date('Y-m-d H:i:s');
				$this->db->where('player_id', $player_id);
				$this->db->update('tournaments_players', $saveScore);
			}
			
			if($redirect_path == 'redirect_leaderboard'){
				redirect('LiveTournamentLeaderboard/'.base64_encode($tournament_id).'/?token='.base64_encode($userId));
			} else {
				
				redirect('LiveTournament/'.base64_encode($tournament_id).'/?token='.base64_encode($userId));
			}
			
		} else {
			redirect('LiveTournament/'.base64_encode($tournament_id).'/?token='.base64_encode($userId));
		}
	}



	public function updateLiveTournamentGameboostPlayerScore(){
		
		//$userId = $this->session->userdata('userId');
		$userId = base64_decode(@$_POST['token']);
		$tournament_id = @$_POST['tournament_id'];
		$game_id = @$_POST['game_id'];
		$skillpod_player_id = @$_POST['skillpod_player_id'];
		
		if(!empty($tournament_id) && !empty($game_id) && !empty($skillpod_player_id)){
			
			$tournamentInfo = $this->SITEDBAPI->getLiveTournamentInfo($tournament_id);
		
			// Get current user score starts
			$postArray = array('game_id' => $game_id,'player_id' => $skillpod_player_id);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://games.igpl.pro/xml-api/get_player_scores',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => $postArray,
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJwYXJ0bmVyX2NvZGUiOiJ0ZXN0LTAwMSIsInBhcnRuZXJfcGFzc3dvcmQiOiJ0ZXN0LTAwMSJ9.GQp4_XWFc1FkHHGoy6XWVe40_QHCUt4ityt57ahXoEMW2AhNHo27V_wJmypgZshbw1w6345mKffaGtf9XowGOA'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			
			$responseXML = simplexml_load_string($response);
			$responseJSON = json_encode($responseXML);

			// Convert into associative array
			$responseArray = json_decode($responseJSON, true);
		 	$userScore = @$responseArray['get_player_scores']['player_scores']['player_score_0']['score'];
		 	$scoreDate = @$responseArray['get_player_scores']['player_scores']['player_score_0']['time'];
			$scoreDate = date('Y-m-d', strtotime($scoreDate.'+6 hours'));
			
		 	$t_start_date = $tournamentInfo['tournament_start_date'];
			$t_end_date = $tournamentInfo['tournament_end_date'];
			
			if($t_start_date <= $scoreDate &&  $t_end_date >= $scoreDate ){
				if(!empty($userScore)){
					$currentScore = $userScore;
				} else {
					$currentScore = 0;
				}
			} else {
				$currentScore = 0;
			}
			
			$scoreInfo = $this->SITEDBAPI->getLiveTournamentPlayerScore($tournament_id, $userId);
			$lastScore = @$scoreInfo['player_score'];
			$player_id = @$scoreInfo['player_id'];
			if($currentScore > $lastScore){
				$saveScore['player_score'] = $currentScore;
				$this->db->where('player_id', $player_id);
				$this->db->update('tournaments_players', $saveScore);
			}
		}
	}
	
	
	public function getLiveTournamentLeaderboard($id){
		$id = base64_decode($id); 
		 
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
		}
		
		if(!empty($userId) && !empty($id) ){
		
			// Get tournament info
			$data['tournamentInfo'] = $this->SITEDBAPI->getLiveTournamentInfo($id);
			
			if(is_array($data['tournamentInfo']) && count($data['tournamentInfo'])>0){
				$data['userInfo'] = $this->SITEDBAPI->getSiteUserDetail($userId);
			
				$data['playersInfo'] = $this->SITEDBAPI->getLiveTournamentPlayersListDESC($id);
				$data['checkPlayerEntry'] = $this->SITEDBAPI->checkLiveTournamentPlayer($userId, $id);
			
				$data['user_id'] = $userId;
				$data['tournament_id'] = $id;
				
				$myRank = 0;
				$myScore = 0;
				$iCount = 0;
				$totalPlayers =  count($data['playersInfo']);
				if(is_array($data['playersInfo']) && count($data['playersInfo'])>0){
					
					$highest_score = $data['playersInfo'][0]['player_score'];
					$rank = 1;
					
					foreach($data['playersInfo'] as $row){
						if($row['player_score'] >0){
							if($highest_score !=0 && $row['player_score'] == $highest_score){
								// don't change the rank for user
							} else {
								if($row['player_score'] > 0 ){
									//$rank++;
								}  else {
									$rank = 0;
								}
							$highest_score = $row['player_score'];
							}
							
							if($row['user_id'] == $userId){
								$myRank = $rank;
								$myScore = $row['player_score'] ;
								break;
							}
							//$iCount++;
							$rank++;
						
						}
					}
				}
				
				$data['myRank'] = $myRank;
				$data['myScore'] = $myScore;
				if($totalPlayers > 0 && $myScore>0){ // check the join players number count
					$data['myRank'] = $myRank;
					$data['myScore'] = $myScore;
				} else {
					$data['myRank'] = 0;
					$data['myScore'] = 0;
				}
			    $data['session_page_type']=7;
				$data['session_tournament_id']=$id;
				$data['session_game_id']=$data['tournamentInfo']['tournament_game_id'];
				$this->load->view('site/live_tournament_leaderboard', $data);
			
			} else {
				redirect();
			}
		} else {
			redirect();
		}
	}


	public function practiceTournamentGame($gameId, $tournamentId){
		
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
		}
		
		$gameId = base64_decode($gameId); // gameboost game id
		$tournamentId = base64_decode($tournamentId); // gameboost game id
		
		if(!empty($gameId)){
			$data['gameId'] = $gameId;
			$data['gameInfo'] = $this->SITEDBAPI->getGameboostGameInfo($gameId);
			
			// Update the Report for the user wise practice game play count
			$this->addReportUserGamePlay($type=3, $gameId, $tournamentId);
			$data['session_page_type']=3;
			$data['session_tournament_id']=$tournamentId;
			$data['session_game_id']=$data['gameInfo']['gid'];
			$this->load->view('site/play_game', $data);
		} else {
			redirect();
		}
	}

		
	public function addReportUserGamePlay($type, $gameId, $tournamentId='0'){
		
		$userId = $this->session->userdata('userId');
		if(!empty($userId)){
			if($type == '1'){
				// Update the genre practice game count
				$lastPracticeSession =  $this->SITEDBAPI->getUserPracticeGameReport($userId, $gameId);
				if(!empty($lastPracticeSession['report_id'])){
					$reportData['report_practice_counts'] = ($lastPracticeSession['report_practice_counts']+1);
					$this->db->where('report_id', $lastPracticeSession['report_id']);
					$this->db->update('report_game_play', $reportData);
				} else {
					$reportData['report_user_id'] = $userId;
					$reportData['report_date'] = date('Y-m-d');
					$reportData['report_game_id'] = $gameId;
					$reportData['report_practice_counts'] = '1';
					$reportData['report_last_updated'] = time();
					$this->db->insert('report_game_play', $reportData);
				}
				
			} else if($type == '2'){
				
				if(!empty($tournamentId)){
					// Update the Tournament practice game count
					$lastPracticeSession =  $this->SITEDBAPI->getUserTournamentGameReport($userId, $gameId, $tournamentId);
					
					if(!empty($lastPracticeSession['report_id'])){
						$reportData['report_tournament_counts'] = ($lastPracticeSession['report_tournament_counts']+1);
						$this->db->where('report_id', $lastPracticeSession['report_id']);
						$this->db->update('report_game_play', $reportData);
					} else {
						$reportData['report_user_id'] = $userId;
						$reportData['report_date'] = date('Y-m-d');
						$reportData['report_game_id'] = $gameId;
						$reportData['report_tournament_id'] = $tournamentId;
						$reportData['report_tournament_counts'] = '1';
						$reportData['report_last_updated'] = time();
						$this->db->insert('report_game_play', $reportData);
					}
				} 
			} else if($type == '3'){
				
				if(!empty($tournamentId)){
					// Update the Tournament practice game count
					$lastPracticeSession =  $this->SITEDBAPI->getUserTournamentGameReport($userId, $gameId, $tournamentId);
					
					if(!empty($lastPracticeSession['report_id'])){
						$reportData['report_tournament_practice_counts'] = ($lastPracticeSession['report_tournament_practice_counts']+1);
						$this->db->where('report_id', $lastPracticeSession['report_id']);
						$this->db->update('report_game_play', $reportData);
					} else {
						$reportData['report_user_id'] = $userId;
						$reportData['report_date'] = date('Y-m-d');
						$reportData['report_game_id'] = $gameId;
						$reportData['report_tournament_id'] = $tournamentId;
						$reportData['report_tournament_practice_counts'] = '1';
						$reportData['report_last_updated'] = time();
						$this->db->insert('report_game_play', $reportData);
					}
				} 
			} 
			
		}
	}
	
	
	public function tournamentHistory()	{
		
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
		}
		if(!empty($userId)){
			
			$data['userInfo'] = $this->SITEDBAPI->getSiteUserDetail($userId);
			$data['tournamentsList'] = $this->SITEDBAPI->getUserTournamentsList($userId, $limit=10, $offset=0);
			
			$tournamentsListCounts = $this->SITEDBAPI->getUserTournamentsTotal($userId);
			$data['offset'] = 0;
			
			if($tournamentsListCounts % 10 == 0){
				$data['total_pages'] = floor($tournamentsListCounts/10);
			} else {
				$data['total_pages'] = floor($tournamentsListCounts/10)+1;
			}
			//echo $data['total_pages']; die;
			$data['session_page_type']=9;
			$this->load->view('site/tournament_history',$data);
		} else {
			redirect();
		}
	}


	public function getTournamentsMore($userToken, $offset){
		//$userId = $this->session->userdata('userId');
		$userId = base64_decode($userToken);
		
		if( !empty($userId)){	
			$data['tournamentsList'] = $this->SITEDBAPI->getUserTournamentsList($userId, $limit=10, $offset);
			$this->load->view('site/tournament_history_more', $data);	
			
		} else {
			redirect();
		}
	}
	

	
	public function tournamentLeaderboard($id){
		 $id = base64_decode($id); 
		//get loggedin  user id
		$userId = $this->session->userdata('userId');
		if(!empty($userId) && !empty($id) ){
		
			// Get tournament info
			$data['tournamentInfo'] = $this->SITEDBAPI->getTournamentInfo($id);
			
			if(is_array($data['tournamentInfo']) && count($data['tournamentInfo'])>0){
		
				$today = time();

				$startDate = $data['tournamentInfo']['t_start_date']." ".$data['tournamentInfo']['t_start_time'].":00";
				$startDate = strtotime($startDate);

				$endDate = $data['tournamentInfo']['t_end_date']." ".$data['tournamentInfo']['t_end_time'].":00";
				$endDate = strtotime($endDate);

				$status = 0;     //1=CurrentlyWorking   2=Expired   3=futureTournament
				if($startDate > $today){
					$status = 3;
				} else if($endDate < $today){
					$status = 2;
				} else if($startDate <= $today && $endDate >= $today){
					$status = 1;
				}
				$data['t_current_status'] = $status;
				$data['user_id'] = $userId;
				$data['tournament_id'] = $id;
				$data['playersInfo'] = $this->SITEDBAPI->getTournamentPlayersListDESC($id);

				$this->load->view('site/tournament_leaderboard', $data);
			
			
			} else {
				redirect();
			}
		} else {
			redirect();
		}
	}


	
	
	
// *****************************   *************************************** ********************************** //
// *****************************   Live  VIP/Pay&Play/Free Tournaments Ends Here ********************************** //
// *****************************   *************************************** ********************************** //


	
// *****************************   **************************** ********************************** //
// *****************************   Free Genre Games Starts Here ********************************** //
// *****************************   **************************** ********************************** //


	public function getallGenreGames(){
		
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
		}
		$data['userInfo'] = $this->SITEDBAPI->validateUser($userId);
		
		$data['actiongamesList'] = $this->SITEDBAPI->getGenreGamesList('Action', $limit='6');
		$data['arcadegamesList'] = $this->SITEDBAPI->getGenreGamesList('Arcade', $limit='6');
		$data['adventuregamesList'] = $this->SITEDBAPI->getGenreGamesList('Adventure', $limit='6');
		$data['sportsgamesList'] = $this->SITEDBAPI->getGenreGamesList('Sports', $limit='6');
		$data['puzzlegamesList'] = $this->SITEDBAPI->getGenreGamesList('Puzzle', $limit='6');
		$this->load->view('site/all_games_list', $data);		
	}
	

	public function getGenreGames($type){
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
		}
		$data['gamesList'] = $this->SITEDBAPI->getGenreGamesList($type);
		$data['type'] = $type;		
		if($type == 'Action')
			$data['genreName'] = 'Action';
		else if($type == 'Arcade')
			$data['genreName'] = 'Arcade';
		else if($type == 'Adventure')
					$data['genreName'] = 'Adventure';
		else if($type == 'Sports')
					$data['genreName'] = 'Sports & Racing';
		else if($type == 'Puzzle')
			$data['genreName'] = 'Puzzle & Logic';
	
		$this->load->view('site/genre_games_list', $data);	
		
	}
	
	
	
	public function playGame__old($id){
		$id = base64_decode($id); // gameboost game id
		
		if(!empty($id)){
			$data['gameId'] = $id;
			$data['gameInfo'] = $this->SITEDBAPI->getGameboostGameInfo($id);
			
			// Update the Report for the user wise practice game play count
			$this->addReportUserGamePlay($type=1, $id);
			
			$data['session_page_type']=5;
			$data['session_game_id']=$data['gameInfo']['gid'];
			$this->load->view('site/play_game', $data);
		} else {
			redirect();
		}
	}

	public function playGame($id){
		$id = base64_decode($id); // gameboost game id
		
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
		}
		if(!empty($id)){
			$data['gameId'] = $id;
			$data['gameInfo'] = $this->SITEDBAPI->getGameboostGameInfo($id);
			
			// Update the Report for the user wise practice game play count
			$this->addReportUserGamePlay($type=1, $id);
			
			$data['session_page_type']=5;
			$data['session_game_id']=$data['gameInfo']['gid'];
			$this->load->view('site/play_game', $data);
			//$this->load->view('site/play_game_new', $data);
		} else {
			redirect();
		}
	}

	
// *****************************   **************************** ********************************** //
// *****************************   Free Genre Games Ends Here ********************************** //
// *****************************   **************************** ********************************** //



	
// *****************************   **************************** ********************************** //
// *****************************   Manage Profile Avatars Starts Here ********************************** //
// *****************************   **************************** ********************************** //

		
	public function manageProfile(){
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
		}
		$userInfo = $this->SITEDBAPI->validateUser($userId);
		if( !empty($userInfo['user_id'])){	
			$data['userInfo'] = $userInfo;
			$data['session_page_type']=6;
			$this->load->view('site/manage_profile', $data);	
			
		} else {
			redirect('Login');
		}
	}


	public function updateUserProfile(){
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
			$userToken = base64_encode($userId);
		}
		$userInfo = $this->SITEDBAPI->validateUser($userId);
		if( !empty($userInfo['user_id'])){	
			
			$update['user_full_name'] = $_POST['user_full_name'];
			$update['user_email_2'] = $_POST['user_email_2'];
			if($_POST['user_email_2'] != $userInfo['user_email_2']){
				$otp = $this->createOTP(6);
				$update['user_email_verified'] = 0;
				$update['user_email_otp'] = $otp;
			} else {
				$otp = $this->createOTP(6);
				$update['user_email_verified'] = $userInfo['user_email_verified'];
				$update['user_email_otp'] = $otp;
			}
			
			$this->db->where('user_id', $userId);
			if($this->db->update('site_users', $update)){
				
				//if($update['user_email_verified'] == 0){
				//	$this->sendEmailVerificationOTP($update['user_email_2'], $update['user_email_otp']);
				//} else {
					
					//Save User Notification
					$notifyDesc = "Profile information updated successfully.";
					$this->saveUserNotification($userId, $type='5', $notifyDesc);
				
				
					$this->session->set_flashdata("success","Profile information updated successfully.");
					redirect('ManageProfile/?token='.$userToken);
				//}
				
				
			} else {
				$this->session->set_flashdata("error","Sorry! Unable to update profile information. Please try after sometime.");
				redirect('ManageProfile/?token='.$userToken);
				
			}
		} else {
			redirect('error');
		}
	}
	
	public function sendEmailVerificationOTP($email, $emailOTP){
		
		if(!empty($email)){

			// Sanitize E-mail Address
			$email =filter_var($email, FILTER_SANITIZE_EMAIL);
			// Validate E-mail Address
			$email= filter_var($email, FILTER_VALIDATE_EMAIL);
			if($email){

					$otp = $emailOTP;

					$row['content']='';
					$row['content'] .= "<p> <br> <b>{$otp}</b> is the One Time Password (OTP) to verify your email address. Do not share the OTP with anyone. </p>";
					$row['content'] .= "<p><br><br> <b>IMPORTANT</b>: Please do not reply to this message or mail address.</p>";
					$row['content'] .= "<p><b>DISCLAIMER</b>: This communication is confidential and privileged and is directed to and for the use of the addressee only. The recipient if not the addressee should not use this message if erroneously received, and access and use of this e-mail in any manner by anyone other than the addressee is unauthorized.</p>";
				
					$row['subject'] = "Your GSL Email Verification OTP";
					
					
				// Enable this when shift to live server
					
					$this->load->library("PhpMailerLib");
					$mail = $this->phpmailerlib->load();
					
					try {
						//Server settings
						$mail->SMTPDebug = 0;                                 // Enable verbose debug output
						$mail->isSMTP();                                      // Set mailer to use SMTP
						$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
						$mail->SMTPAuth = true;                               // Enable SMTP authentication
					//	$mail->Username = 'gpl.gamenow@gmail.com';                 // SMTP username
					//	$mail->Password = 'gpl@123*';                           // SMTP password
						$mail->Username = 'adxdigitalsg@gmail.com';                 // SMTP username
						$mail->Password = 'adxd@123';                           // SMTP password
						$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
						$mail->Port = 465;                                    // TCP port to connect to
						//Recipients
						$mail->setFrom('adxdigitalsg@gmail.com', 'GSL');
						$mail->addAddress($email);     // Add a recipient
						$mail->addReplyTo('adxdigitalsg@gmail.com', 'GSL');
						$mail->addBCC('vaish.nisha55@gmail.com');

						//Content
						$mail->isHTML(true);                                  // Set email format to HTML
						$mail->Subject = $row['subject'];
						$mail->Body    = $row['content'];
					
						$mail->send();
						$this->session->set_flashdata('otp_success','<strong>Success! </strong> OTP request sent on the specified email address.');

						$this->session->set_userdata('person_verify_email', $email);
						$this->session->set_userdata('person_verify_otp', $otp);
						redirect('ManageProfile');
						
					} catch (Exception $e) {
						$this->session->set_flashdata('error','<strong>Error! </strong> Unable to send OTP request to your specified email address. Please try again.');
					
						redirect("ManageProfile");
					}
					
					
			}	else {
				redirect();
			}
		} else {
			redirect();
		}
	}
	
	public function processEmailVerification(){
		$userId = $this->session->userdata('userId');
		$userInfo = $this->SITEDBAPI->validateUser($userId);
		if( !empty($userInfo['user_id'])){	
			
			$email_otp = $_POST['email_otp'];
			
			if($userInfo['user_email_otp'] ==  $email_otp){
				
				$update['user_email_verified'] = 1;
				$this->db->where('user_id', $userId);
				if($this->db->update('site_users', $update)){
					
					//Save User Notification
					$notifyDesc = "Email address verified successfully.";
					$this->saveUserNotification($userId, $type='5', $notifyDesc);
				
				
					$this->session->set_flashdata("success","Email address verified successfully.");
					redirect('ManageProfile');
				
				} else {
					$this->session->set_flashdata("error","Sorry! Unable to verify OTP. Please try again.");
					redirect('ManageProfile');
				}
			} else {
				$this->session->set_flashdata("error","Sorry! Unable to verify OTP. Please try again.");
				redirect('ManageProfile');
			}
		} else {
			redirect('Login');
		}
	}
	
	public function updateProfileImage(){
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
			$userToken = base64_encode($userId);
			
			$data['maleList'] = $this->SITEDBAPI->getMaleProfileImages();
			$data['femaleList'] = $this->SITEDBAPI->getFemaleProfileImages();
			$this->load->view('site/user_images_list', $data);	
		} else {
			redirect('error');
		}
	}
	
	public function setProfileImage($userId, $imgId){
		//$userId = $this->session->userdata('userId');	
		if(!empty($userId)){
			$userId = base64_decode($userId);
			$data['userToken'] = base64_encode($userId);
			$userToken = base64_encode($userId);
		}		
		$imgId = base64_decode($imgId);
		$dataUser['user_image'] = $imgId.".png";
		$this->db->where('user_id', $userId);
		if($this->db->update('site_users', $dataUser)){
			
			//Save User Notification
			$notifyDesc = "Profile image updated successfully.";
			$this->saveUserNotification($userId, $type='5', $notifyDesc);
				
			$this->session->set_flashdata("success","Profile image updated successfully.");
			redirect('home/'.$userToken);
		} else {
			$this->session->set_flashdata("error","Unable to update profile image. Please try again.");
			redirect('home/'.$userToken);
		}
		
	}
	
	
// *****************************   **************************** ********************************** //
// *****************************   Manage Profile  Ends Here ********************************** //
// *****************************   **************************** ********************************** //


	
// *****************************   **************************** ********************************** //
// *****************************   Manage Spin & Win  Starts Here ********************************** //
// *****************************   **************************** ********************************** //

	public function spinWheel(){
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
			$userToken = base64_encode($userId);
		}	
		$userInfo = $this->SITEDBAPI->validateUser($userId);
		if( !empty($userInfo['user_id'])){	
			
			$userSpinInfo = $this->SITEDBAPI->getUserLastSpin($userId);
			if($userSpinInfo)
			{
				$spinDate = $userSpinInfo['spin_date'];
				$spinDate = strtotime($spinDate);
				$today = strtotime(date('Y-m-d'));
				if($today !== @$spinDate){
					$data['session_page_type']=8;
					$this->load->view('site/spin', $data);	
				} else {
					$this->session->set_flashdata("error","Sorry, You already used Spin & Win today.  Come back tomorrow to spin again.");
					redirect('home/'.$userToken);
				}
			}
			else{
				$data['session_page_type']=8;
				$this->load->view('site/spin', $data);
			}
				
		} else {
			redirect('Login');
		}
	}
	
	
	public function getSpinJSON(){
		
		header('Content-type: application/json');
		
		$list  =  $this->SITEDBAPI->getSpinWheelSections();
		$spinArray = array();
		
		foreach($list as $row){
			$aa = array();
			$aa['id'] = $row['wheel_id'];
			$aa['type'] = "string";
			$aa['win'] = true;
			
			if( $row['wheel_type'] == 1){
				 $str = " COINS";
			}  else if( $row['wheel_type'] == 2){
				 $str = " MB DATA";
			}  else if( $row['wheel_type'] == 3){
				 $str = " GB DATA";
			}  else if( $row['wheel_type'] == 4){
				 $str = " RS. TALKTIME ";
			}
			
			$aa['value'] = $row['wheel_value'].$str;
			$aa['resultText'] = "YOU WON ".$row['wheel_value'].$str;
			array_push($spinArray, $aa);
		}
		
		$data = array(
		"colorArray" => array("#364C62", "#F1C40F", "#E67E22", "#E74C3C", "#98985A", "#95A5A6", "#16A085", "#27AE60", "#2980B9", "#8E44AD", "#2C3E50", "#F39C12", "#D35400", "#C0392B", "#BDC3C7","#1ABC9C", "#2ECC71", "#E87AC2", "#3498DB", "#9B59B6", "#7F8C8D"),

		"segmentValuesArray" => $spinArray,
		"svgWidth" => 1024,
		"svgHeight" => 768,
		"wheelStrokeColor" => "#3fd53f",
		"wheelStrokeWidth" => 18,
		"wheelSize" => 700,
		"wheelTextOffsetY" => 80,
		"wheelTextColor" => "#EDEDED",
		"wheelTextSize" => "2.2em",
		"wheelImageOffsetY" => 40,
		"wheelImageSize" => 50,
		"centerCircleSize" => 250,
		"centerCircleStrokeColor" => "#ffffff",
		"centerCircleStrokeWidth" => 12,
		"centerCircleFillColor" => "#efefef",
		"segmentStrokeColor" => "#E2E2E2",
		"segmentStrokeWidth" => 5,
		"centerX" => 512,
		"centerY" => 384,  
		"hasShadows" => false,
		"numSpins" => 1 ,
		"spinDestinationArray" => array(),
		"minSpinDuration" => 6,
		"gameOverText" => "COME BACK TOMORROW TO PLAY AGAIN!",
		"invalidSpinText" =>"INVALID SPIN. PLEASE SPIN AGAIN.",
		"introText" => "CLICK TO SPIN IT! ",
		"hasSound" => true,
		"gameId" => "9a0232ec06bc431114e2a7f3aea03bbe2164f1aa",
		"clickToSpin" => true

		);

		echo json_encode( $data);
	}
	
	
	public function processSpinWin($id){
		$userId = $this->session->userdata('userId');
		$userInfo = $this->SITEDBAPI->validateUser($userId);
		
		if( !empty($userInfo['user_id'])){	
			
			// Get Spin Wheel section info 
			$spinInfo = $this->SITEDBAPI->getSpinWheelInfo($id);
			
			$data['spin_user_id'] = $userId;
			$data['spin_date'] = date('Y-m-d');
			if($spinInfo['wheel_type'] == 1){
				$data['spin_reward'] = '1';  // 1=WinCoin   0=NoCoin
				$data['spin_coins'] = $spinInfo['wheel_value'];
			} else {
				$data['spin_reward'] = '0';
				$data['spin_coins'] = '0';
			}
				
			$data['spin_reward_type'] = $spinInfo['wheel_type'];  // 1=PlayCoins   2=Data-MB  3=Data-GB  4=TalkTime
			$data['spin_reward_value'] = $spinInfo['wheel_value'];  
			
			
			$data['spin_added_on'] = time();
			if($this->db->insert('user_spinwin', $data)){
				
				if($spinInfo['wheel_type'] == 1){
					// If User Wins Play Coins,   then Update the Play Coins in main Users table
					$playCoins = $userInfo['user_play_coins'];
					$updatedPlayCoins = $playCoins+$spinInfo['wheel_value'];
					$dataCoins['user_play_coins'] = $updatedPlayCoins;
					$this->db->where('user_id', $userId);
					$this->db->update('site_users', $dataCoins);
				}
				
				// Update a row for managing coins history				
				$coinHistory['coin_user_id'] = $userId;
				$coinHistory['coin_date'] = date('Y-m-d');				
				$coinHistory['coin_section'] = '2';  //1=AddCoins  2=SpinWin  3=RedeemRewardCoins  4=CreateTournament  5=TournamentReward
				
				// Create User Notificatio desc parameter
				$notifyDesc = '';
						
				if($spinInfo['wheel_type'] == 1){
					$coinHistory['coin_play_coins_add'] = $spinInfo['wheel_value'];
					$coinHistory['coin_type'] = '1';  // 1=PlayCoins  2=RewardCoins  3=Both
					
					$notifyDesc = "<b>{$spinInfo['wheel_value']} Coins</b> added to your account.";
					
				} else if($spinInfo['wheel_type'] == 2){
					$coinHistory['coin_data_pack_value'] = $spinInfo['wheel_value'];
					$coinHistory['coin_data_pack_unit'] = 'MB';
					$coinHistory['coin_type'] = '0';  
					
					$notifyDesc = "<b>{$spinInfo['wheel_value']} MB </b> data added to your account.";
				
				} else if($spinInfo['wheel_type'] == 3){
					$coinHistory['coin_data_pack_value'] = $spinInfo['wheel_value'];
					$coinHistory['coin_data_pack_unit'] = 'GB';
					$coinHistory['coin_type'] = '0'; 
					
					$notifyDesc = "<b>{$spinInfo['wheel_value']} GB </b> data added to your account.";
				
				} else if($spinInfo['wheel_type'] == 4){
					$coinHistory['coin_talk_time_value'] = $spinInfo['wheel_value'];
					$coinHistory['coin_type'] = '0'; 
					
					$notifyDesc = "<b> {$spinInfo['wheel_value']} Rs. </b> recharge done on your account.";
				}
				$coinHistory['coin_added_on'] = time();
				$this->db->insert('user_coins_history', $coinHistory);
				
				//Save User Notification
				$this->saveUserNotification($userId, $type='2', $notifyDesc);
				
				
				//$this->session->set_flashdata("success","$coins coins added to your account successfully.");
				redirect();
			} else {
				$this->session->set_flashdata("error","Something went wrong. Please try again after sometime.");
				redirect();
			}
			
		} else {
			redirect('Login');
		}
	}
	
	public function processSpinWinAjax($token, $id){
		//$userId = $this->session->userdata('userId');
		if(!empty($token)){
			$userId = base64_decode($token);
			$userToken = base64_encode($userId);
		}
		$userInfo = $this->SITEDBAPI->validateUser($userId);
		
		if( !empty($userInfo['user_id'])){	
			
			// Get Spin Wheel section info 
			$spinInfo = $this->SITEDBAPI->getSpinWheelInfo($id);
			
			$data['spin_user_id'] = $userId;
			$data['spin_date'] = date('Y-m-d');
			if($spinInfo['wheel_type'] == 1){
				$data['spin_reward'] = '1';  // 1=WinCoin   0=NoCoin
				$data['spin_coins'] = $spinInfo['wheel_value'];
			} else {
				$data['spin_reward'] = '0';
				$data['spin_coins'] = '0';
			}
				
			$data['spin_reward_type'] = $spinInfo['wheel_type'];  // 1=PlayCoins   2=Data-MB  3=Data-GB  4=TalkTime
			$data['spin_reward_value'] = $spinInfo['wheel_value'];  
			
			$data['spin_added_on'] = time();
			if($this->db->insert('user_spinwin', $data)){
				
				if($spinInfo['wheel_type'] == 1){
					// If User Wins Play Coins,   then Update the Play Coins in main Users table
					$playCoins = $userInfo['user_play_coins'];
					$updatedPlayCoins = $playCoins+$spinInfo['wheel_value'];
					$dataCoins['user_play_coins'] = $updatedPlayCoins;
					$this->db->where('user_id', $userId);
					$this->db->update('site_users', $dataCoins);
				}
				
				// Update a row for managing coins history				
				$coinHistory['coin_user_id'] = $userId;
				$coinHistory['coin_date'] = date('Y-m-d');				
				$coinHistory['coin_section'] = '2';  //1=AddCoins  2=SpinWin  3=RedeemRewardCoins  4=CreateTournament  5=TournamentReward
				
				// Create User Notificatio desc parameter
				$notifyDesc = '';
				
				
				if($spinInfo['wheel_type'] == 1){
					$coinHistory['coin_play_coins_add'] = $spinInfo['wheel_value'];
					$coinHistory['coin_type'] = '1';  // 1=PlayCoins  2=RewardCoins  3=Both
					
					$notifyDesc = "<b>{$spinInfo['wheel_value']} Coins</b> added to your account.";
					
				} else if($spinInfo['wheel_type'] == 2){
					$coinHistory['coin_data_pack_value'] = $spinInfo['wheel_value'];
					$coinHistory['coin_data_pack_unit'] = 'MB';
					$coinHistory['coin_type'] = '0';  
					
					$notifyDesc = "<b>{$spinInfo['wheel_value']} MB </b> data added to your account.";
					
				} else if($spinInfo['wheel_type'] == 3){
					$coinHistory['coin_data_pack_value'] = $spinInfo['wheel_value'];
					$coinHistory['coin_data_pack_unit'] = 'GB';
					$coinHistory['coin_type'] = '0';
	
					$notifyDesc = "<b>{$spinInfo['wheel_value']} GB </b> data added to your account.";
					
				} else if($spinInfo['wheel_type'] == 4){
					$coinHistory['coin_talk_time_value'] = $spinInfo['wheel_value'];
					$coinHistory['coin_type'] = '0'; 
					
					$notifyDesc = "<b> {$spinInfo['wheel_value']} Rs. </b> recharge done on your account.";
					
				}
				$coinHistory['coin_added_on'] = time();
				$this->db->insert('user_coins_history', $coinHistory);
				
				
				//Save User Notification
				$this->saveUserNotification($userId, $type='2', $notifyDesc);
				
				
				echo "success";
				
			} else {
				$this->session->set_flashdata("error","Something went wrong. Please try again after sometime.");
				redirect();
			}
			
		} else {
			redirect('error');
		}
	}
	
// *****************************   **************************** ********************************** //
// *****************************   Manage Spin & Win  Ends Here ********************************** //
// *****************************   **************************** ********************************** //



	
// *****************************   **************************** ********************************** //
// *****************************   Manage Notifications Starts Here ********************************** //
// *****************************   **************************** ********************************** //
	public function manageNotifications(){
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
			$userToken = base64_encode($userId);
		}
		if(!empty($userId) ){
			$updateRead['notify_status'] = '1';
			$this->db->where('notify_user_id', $userId);
			$this->db->update('user_notifications', $updateRead);
			$data['list'] = $this->SITEDBAPI->getUserNotifications($userId);
			$data['session_page_type']=14;
			$this->load->view('site/notifications', $data);
		} else {
			redirect('Login');
		}
	}
		
	
	public function deleteNotification($id){
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
			$userToken = base64_encode($userId);
		}
		if(!empty($userId) ){
			$notify_id =base64_decode($id);
			
			$this->db->where('notify_id', $notify_id);
			$this->db->where('notify_user_id', $userId);
			if($this->db->delete('user_notifications')){
				redirect('Notifications/?token='.$userToken);
			} else {
				redirect('Notifications/?token='.$userToken);
			}
			
		} else {
			redirect('error');
		}
	}
		
	
	public function clearNotifications(){
		//$userId = $this->session->userdata('userId');
		if(!empty($_GET['token'])){
			$userId = base64_decode($_GET['token']);
			$data['userToken'] = base64_encode($userId);
			$userToken = base64_encode($userId);
		}
		if(!empty($userId) ){
			
			$this->db->where('notify_user_id', $userId);
			if($this->db->delete('user_notifications')){
				
				redirect('Notifications/?token='.$userToken);
			} else {
				redirect('Notifications/?token='.$userToken);
			}
			
		} else {
			redirect('error');
		}
	}
		
	
	public function saveUserNotification($userId, $type, $notifyDesc='', $winner_user_id =''){
		
		if(!empty($userId) &&  !empty($type)){
			if($type == '1'){
				// Tournament Joined
				$notifyData['notify_user_id'] =  $userId;
				$notifyData['notify_type'] =  '1';
				$notifyData['notify_title'] =  "Tournament Joined";
				$notifyData['notify_desc'] = $notifyDesc;
				$notifyData['notify_status'] =  '0';
				$notifyData['notify_date'] =  date('Y-m-d');
				$notifyData['notify_added_on'] =  time();
				
				$this->db->insert('user_notifications', $notifyData);
				
			} else if($type == '2'){
				
				// Spin & Win Reward 
				$notifyData['notify_user_id'] =  $userId;
				$notifyData['notify_type'] =  '2';
				$notifyData['notify_title'] =  "Spin & Win Reward";
				$notifyData['notify_desc'] =  $notifyDesc;
				$notifyData['notify_status'] =  '0';
				$notifyData['notify_date'] =  date('Y-m-d');
				$notifyData['notify_added_on'] =  time();
				
				$this->db->insert('user_notifications', $notifyData);
				
			} else if($type == '3'){
				
				// Spin & Win Reward 
				$notifyData['notify_user_id'] =  $userId;
				$notifyData['notify_type'] =  '3';
				$notifyData['notify_title'] =  "Redeem Coins";
				$notifyData['notify_desc'] =  $notifyDesc;
				$notifyData['notify_status'] =  '0';
				$notifyData['notify_date'] =  date('Y-m-d');
				$notifyData['notify_added_on'] =  time();
				
				$this->db->insert('user_notifications', $notifyData);
			
			} else if($type == '4'){
				if(!empty($winner_user_id)){
					// Tournament Reward 
					$notifyData['notify_user_id'] =  $winner_user_id;
					$notifyData['notify_type'] =  '4';
					$notifyData['notify_title'] =  "Tournament Reward";
					$notifyData['notify_desc'] =  $notifyDesc;
					$notifyData['notify_status'] =  '0';
					$notifyData['notify_date'] =  date('Y-m-d');
					$notifyData['notify_added_on'] =  time();
					
					$this->db->insert('user_notifications', $notifyData);
				}
				
			} else if($type == '5'){
				
				// Update profile name or email
				$notifyData['notify_user_id'] =  $userId;
				$notifyData['notify_type'] =  '5';  //1=TournamentCreated   2=Spin&Win   3=RedeemCoins   4=TournamentRewardAdded   5=UpdateProfileName    6=SubscriptionCoins   7=RewardAdded  8=RewardClaimed  9=VoucherExpired

				$notifyData['notify_title'] =  "Profile Settings";
				$notifyData['notify_desc'] =  $notifyDesc;
				$notifyData['notify_status'] =  '0';
				$notifyData['notify_date'] =  date('Y-m-d');
				$notifyData['notify_added_on'] =  time();
				$this->db->insert('user_notifications', $notifyData);
				
			} else if($type == '6'){
				
				// Update profile verify email
				$notifyData['notify_user_id'] =  $userId;
				$notifyData['notify_type'] =  '6';
				$notifyData['notify_title'] =  "Profile Settings";
				$notifyData['notify_desc'] =  $notifyDesc;
				$notifyData['notify_status'] =  '0';
				$notifyData['notify_date'] =  date('Y-m-d');
				$notifyData['notify_added_on'] =  time();
				
				$this->db->insert('user_notifications', $notifyData);
				
			}
			
		} 
		
	} 
		
// *****************************   **************************** ********************************** //
// *****************************   Manage Notifications Ends Here ********************************** //
// *****************************   **************************** ********************************** //


	public function captureTimeToLeave(){
		$userId = $this->session->userdata('userId');
		$paymayaProfileId = $this->session->userdata('paymayaProfileId');
		// echo $session_page = $_POST['session_page'];
		$session_page=$_POST['session_page'];
		// die();
		$time = $_POST['time'];
		$endTime =$_POST['endTime'];
		$timeSpend = $this->time2sec($time);
		
		// Used in case of practice game play
		$game_id = @$_POST['game_id'];  // This is gameboost game id
		
		// Used in case of tournament game play
		$tournament_id = @$_POST['tournament_id'];
		
		$lastLoginSession =  $this->SITEDBAPI->getUserLastLoginReport($userId, $session_page, $game_id , $tournament_id);
		
		if($lastLoginSession)
		{
			if($lastLoginSession['report_page'] == $session_page){
				// echo "mani";
				if($timeSpend > $lastLoginSession['report_avg_time']){
					$reportUser['report_avg_time'] = $timeSpend;
				}
				$reportUser['report_logout_time'] = date('Y-m-d H:i:s', strtotime($endTime));
				$reportUser['report_page'] = $session_page;
				
				//echo  $lastLoginSession['report_id'];
				
				$this->db->where('report_id', $lastLoginSession['report_id']);
				$this->db->update('report_users', $reportUser);
			
			}
	 	} else {
			// echo "anc";
			$reportUser['report_user_id'] = $userId;
			// $reportUser['report_paymaya_id'] = 1;
			$reportUser['report_date'] = date('Y-m-d');
			$reportUser['report_login_time'] = date('H:i:s A');
			$reportUser['report_logout_time'] = date('Y-m-d H:i:s', strtotime($endTime));
			$reportUser['report_tournament_id'] = $tournament_id;
			$reportUser['report_game_id'] = $game_id;
			$reportUser['report_avg_time'] = $timeSpend;
			$reportUser['report_page'] = $session_page;  //1=Home-Page  2=Live Tournament Info  3=Practice-Game-Play  4=Tournament-Detail  5=Tournament-Game-Play  6=Tournament-Practice-Game-Play  7=User-Profile  8=Tournaments-History
			$reportUser['report_last_updated'] = time();
			$this->db->insert('report_users', $reportUser);
		}
		
		//echo "Saved: ".$timeSpend;
		
	}

	public function time2sec($time){
		$durations = array_reverse(explode(':', $time));
		$second = array_shift($durations);
		foreach ($durations as $duration) {
			$second += (60 * $duration);
		}
		return $second;
	}
	
	public function EventCapture(){
		
		if(!empty($_POST['user_id'])){
			$data['user_id'] = $_POST['user_id'];
		} else {
			$data['user_id'] = $this->session->userdata('userId');
		}
		
		if(!empty($_POST['gameid'])){
			$data['event_game_id'] = $_POST['gameid'];
		}
		
		if(!empty($_POST['tid'])){
			$data['event_tournament_id'] = $_POST['tid'];
			$data['event_game_access'] = 'play-tournament';
		}
		
		if(!empty($_POST['tgid'])){
			$data['event_tournament_game_id'] = $_POST['tgid'];
		}
		
		if(!empty($_POST['type'])){
			$data['event_game_access'] = $_POST['type'];
		}
		
		
		$data['event_function'] = $_POST['eventfun'];
		$data['event_name'] = $_POST['event_name'];
		$data['page'] = $_POST['page'];
		$data['date_time'] = date('Y-m-d H:i:s');
		$this->db->insert('event_capture', $data);
	}
	



	public function liveTournamentsResults(){
		
		/* 	
		$todayHrsStart =  date('Y-m-d', strtotime('-1 day'));
		$todayHrsEnd =  date('Y-m-d');
		$list = $this->db->query("SELECT `tbl_tournaments`.tournament_id,`tbl_tournaments`.tournament_section, `tbl_tournaments_fee_rewards`.fee_tournament_prize_1, `tbl_tournaments_fee_rewards`.fee_tournament_prize_2,`tbl_tournaments_fee_rewards`.fee_tournament_prize_3,`tbl_tournaments_fee_rewards`.fee_tournament_prize_4,`tbl_tournaments_fee_rewards`.fee_tournament_prize_5,`tbl_tournaments_fee_rewards`.fee_tournament_prize_6,`tbl_tournaments_fee_rewards`.fee_tournament_prize_7,`tbl_tournaments_fee_rewards`.fee_tournament_prize_8 FROM tbl_tournaments left join tbl_tournaments_fee_rewards on `tbl_tournaments_fee_rewards`.fee_turnament_id = `tbl_tournaments`.tournament_id WHERE  `tbl_tournaments`.tournament_end_date = '$todayHrsStart' ")->result_array();
		*/
	
	
		$todayHrsStart =  date('Y-m-d', strtotime('-1 day'));
		$todayHrsEnd =  date('Y-m-d');
		
		$startHrs =  date('H:i', strtotime('-10 minutes'));
		$endHrs =  date('H:i');
		
		$list = $this->db->query("SELECT `tbl_tournaments`.tournament_id,`tbl_tournaments`.tournament_section, `tbl_tournaments_fee_rewards`.fee_tournament_prize_1, `tbl_tournaments_fee_rewards`.fee_tournament_prize_2,`tbl_tournaments_fee_rewards`.fee_tournament_prize_3,`tbl_tournaments_fee_rewards`.fee_tournament_prize_4,`tbl_tournaments_fee_rewards`.fee_tournament_prize_5,`tbl_tournaments_fee_rewards`.fee_tournament_prize_6,`tbl_tournaments_fee_rewards`.fee_tournament_prize_7,`tbl_tournaments_fee_rewards`.fee_tournament_prize_8 FROM tbl_tournaments left join tbl_tournaments_fee_rewards on `tbl_tournaments_fee_rewards`.fee_turnament_id = `tbl_tournaments`.tournament_id WHERE  `tbl_tournaments`.tournament_end_date BETWEEN '$todayHrsStart' AND '$todayHrsEnd'  AND  `tbl_tournaments`.tournament_end_time BETWEEN '$startHrs' AND '$endHrs' ")->result_array();
	
	/* 	echo $this->db->last_query();
		
		echo "<pre>";
		print_r($list);
		echo "</pre>";
	//	die; */
			
			
		if(is_array($list) && count($list)>0){
		
			/*  echo "<pre>";
			print_r($list);
			echo "</pre>";
			die; */
			 
			foreach($list as $tRow){
				
				$t_id = $tRow['tournament_id'];
				
				// Get the tournament result status
				
				 $tResult = $this->db->query("SELECT count(*) as no_rows FROM tbl_tournaments_results WHERE result_t_id = '$t_id' ")->row_array();
		
				 if($tResult['no_rows']<=0){
					 
					 
					/*  echo "<pre>";
					print_r($list);
					echo "</pre>";
					die; */
					
					// Manage a aaray for rank-wise prizes
					$t_prize_1 = $tRow['fee_tournament_prize_1'];  // For 1st rank
					$t_prize_2 = $tRow['fee_tournament_prize_2'];  // For 2nd rank
					$t_prize_3 = $tRow['fee_tournament_prize_3'];  // For 3rd rank
					$t_prize_4 = $tRow['fee_tournament_prize_4']; // For 4-5 rank 
					$t_prize_5 = $tRow['fee_tournament_prize_5'];  // For 6-10 rank
					$t_prize_6 = $tRow['fee_tournament_prize_6'];  // For 11-25 rank
					$t_prize_7 = $tRow['fee_tournament_prize_7'];  // For 26-50 rank
					$t_prize_8 = $tRow['fee_tournament_prize_8']; // For 51-100 rank
					
					$array['prizes'] = array("1"=>$t_prize_1, "2"=>$t_prize_2, "3"=>$t_prize_3);
					
					if($tRow['tournament_section']=='2'){ // for weekly prizes 
						if($t_prize_1 > 0)
						  $array['prizes']["1"] = $t_prize_1;
						if($t_prize_2 > 0)
						  $array['prizes']["2"] = $t_prize_2;
						if($t_prize_3 > 0)
						   $array['prizes']["3"] = $t_prize_3;
						if($t_prize_4 > 0){
						   for($i=4; $i<=10; $i++)
							  $array['prizes'][$i] = $t_prize_4;
						}
						if($t_prize_5 > 0){
						
						for($i=11; $i<=50; $i++)
							$array['prizes'][$i] = $t_prize_5;
						}

					}elseif ($tRow['tournament_section']=='3') {  //// for daily prizes 
						if($t_prize_1 > 0)
						  $array['prizes']["1"] = $t_prize_1;
						if($t_prize_2 > 0)
						  $array['prizes']["2"] = $t_prize_2;
						if($t_prize_3 > 0)
						   $array['prizes']["3"] = $t_prize_3;
						if($t_prize_4 > 0){
						   for($i=4; $i<=10; $i++)
							  $array['prizes'][$i] = $t_prize_4;
						}
						if($t_prize_5 > 0){
						for($i=11; $i<=20; $i++)
							$array['prizes'][$i] = $t_prize_5;
						}
					}else{    // for free game prize
                        
						/*
						if($t_prize_1 > 0){
						   for($i=1; $i<=10; $i++)
							  $array['prizes'][$i] = $t_prize_1;
						}
						*/
						
						if($t_prize_1 > 0 && $t_prize_2 > 0 && $t_prize_3 >0){
							if($t_prize_1 > 0)
							  $array['prizes']["1"] = $t_prize_1;
							if($t_prize_2 > 0)
							  $array['prizes']["2"] = $t_prize_2;
							if($t_prize_3 > 0)
							   $array['prizes']["3"] = $t_prize_3;
						} else {
							if($t_prize_1 > 0){
							   for($i=1; $i<=10; $i++)
								  $array['prizes'][$i] = $t_prize_1;
							}
						}
						
						
						
					}
					
					/* echo "<pre>";
						print_r($array['prizes']);
						echo "</pre>";
						die;
					*/
					
				
					// Get the tournament players
					$no_player_selected = count($array['prizes']);
					 $playersList = $this->db->query("SELECT * FROM tbl_tournaments_players WHERE player_t_id = '$t_id' AND player_score > '0' ORDER BY player_score DESC, player_score_updated  ASC LIMIT $no_player_selected")->result_array();
	
					/* 	echo "<pre>";
						print_r($playersList);
						echo "</pre>";
						die; */
	
					if(is_array($playersList) && count($playersList)>0){
						
						$highest_score = $playersList[0]['player_score'];
						$rank = 1;
						$arrIndex = 1;
						
						foreach($playersList as $player){
							if($player['player_score'] >0){
								
								$userId = $player['player_user_id'];
								$userInfo = $this->SITEDBAPI->validateUser($userId);
								
								
								$voucherDetail = $this->SITEDBAPI->getUserRankVoucher($rank, $t_id);								

								// Update the player prize & rank in tournament player's table
								$dataPlayerRow['player_reward_updated'] = date('Y-m-d H:i:s');
								$dataPlayerRow['player_reward_rank'] = $rank;
								$dataPlayerRow['prize_voucher_id'] = $voucherDetail['voucher_id'];
								$dataPlayerRow['player_reward_prize'] = $voucherDetail['vt_type'];
								$dataPlayerRow['redeem_expiry_date'] = date("Y-m-d",strtotime(" +3 months"));
								$dataPlayerRow['redeem_prize'] = 0;
								$this->db->where('player_id', $player['player_id']);
								$this->db->where('player_t_id', $t_id);
								$this->db->update('tournaments_players', $dataPlayerRow);


								//status update of voucher assign
								$voucherow['tv_assigned_status'] = '2';  // assigne to user
								$this->db->where('tv_tournament_id', $t_id);
								$this->db->where('tv_prize_rank', $rank);
								$this->db->where('tv_voucher_id', $voucherDetail['voucher_id']);
								$this->db->update('tournament_voucher_detail', $voucherow);
                                
								
								//status update of voucher assign
								$voucherUpdate['voucher_status'] = '2';  // assigne to user
								$this->db->where('voucher_id', $voucherDetail['voucher_id']);
								$this->db->update('voucher_detail', $voucherUpdate);
                                
								
								// finally update logs
								$logs['log_voucher_id'] =  $voucherDetail['voucher_id'];
								$logs['log_tournament_id'] = $t_id;
								$logs['log_user_id'] = $userInfo['user_id'];
								$logs['log_voucher_status'] = '2';  // assigne to user
								$logs['log_message'] = 'assigned_to_user';
								$logs['log_date_time'] = date('Y-m-d H:i:s');
								$logs['log_added_on'] = time();
								$this->db->insert('voucher_logs', $logs);
								
								
								//add Notification for tournament rewards added
								$notifyData['notify_user_id'] =  $userInfo['user_id'];
								$notifyData['notify_type'] =  '7';  //1=TournamentCreated   2=Spin&Win   3=RedeemCoins   4=TournamentRewardAdded   5=UpdateProfileName    6=SubscriptionCoins   7=RewardAdded  8=RewardClaimed  9=VoucherExpired
								$notifyData['notify_title'] =  "Tournament Reward";
								$notifyData['notify_desc'] =  "You have won a Daraz voucher worth <b>".number_format($voucherDetail['vt_type'], 0)." BDT</b> for participating the tournament.";
								$notifyData['notify_status'] =  '0';
								$notifyData['notify_date'] =  date('Y-m-d');
								$notifyData['notify_added_on'] =  time();
								$this->db->insert('user_notifications', $notifyData);
							
							} 
							
							$rank++;
						}
					}
					
					$updateResult['result_t_id'] = $t_id;
					$updateResult['result_added_on'] = time();
					$this->db->insert('tournaments_results', $updateResult);
					
				} 
			}
			
			// Reassign the tournament vouchers back to main voucher table
			$this->reassignTournamentVouchers();
					
		}
	}
	
    public function reassignTournamentVouchers(){
    	
		/*
		$previous_date =  date('Y-m-d', strtotime('-1 day'));
		$list = $this->db->query("SELECT tournament_id FROM tbl_tournaments WHERE tournament_end_date = '$previous_date' ")->result_array();
    	*/
		
		$list = $this->db->query("SELECT result_t_id as tournament_id FROM tbl_tournaments_results WHERE result_release_vouchers = '0' ")->result_array();
	
		/* echo $this->db->last_query();
		echo "<pre>";
		print_r($unassigendVouchers);
		echo "</pre>";
		die; */
		
        if(is_array($list) && count($list)>0){
        	foreach($list as $tRow){
				
				$unassigendVouchers = $this->SITEDBAPI->getUnassignedTournamentVouchers($tRow['tournament_id']);
        	   
				if(is_array($unassigendVouchers) && count($unassigendVouchers)>0){
				   
				  foreach($unassigendVouchers as $vRow){
					  
						 //status update of voucher assign
						$voucherRow['tv_assigned_status'] = '3';  // reissued to main vouchers
						$this->db->where('tv_id', $vRow['tv_id']);
						$this->db->update('tournament_voucher_detail', $voucherRow);
						
						
						//status update of voucher assign
						$voucherUpdate['voucher_status'] = '0';  // Not assigned to any tournament
						$this->db->where('voucher_id', $vRow['tv_voucher_id']);
						$this->db->update('voucher_detail', $voucherUpdate);
                         
						 
						// deduct coupon from the voucher type and update balance
						$updatedCount = $this->SITEDBAPI->getUpdatedVoucherCounts($vRow['vt_id']);
						$vtAssignCoupons = $updatedCount['vt_assign_coupons'];
						$vtBalanceCoupons = $updatedCount['vt_balance_coupons'];
						
						$updateCoupon['vt_assign_coupons'] = ($vtAssignCoupons-1);
						$updateCoupon['vt_balance_coupons'] = ($vtBalanceCoupons+1);
						$this->db->where('vt_id', $vRow['vt_id']);
						$this->db->update('voucher_type', $updateCoupon);
						
						
						// finally update logs
						$logs['log_voucher_id'] =  $vRow['tv_voucher_id'];
						$logs['log_tournament_id'] = $vRow['tv_tournament_id'];
						$logs['log_voucher_status'] = '6'; //reissued after reward distribution
						$logs['log_message'] = 'reissued_unassigned_reward_voucher';
						$logs['log_date_time'] = date('Y-m-d H:i:s');
						$logs['log_added_on'] = time();
						$this->db->insert('voucher_logs', $logs);
						 
					}
				}
			
			
				// update the tournament resullts table with updated voucher release
				$tRowUpdate['result_release_vouchers'] = '1';
				$this->db->where('result_t_id', $tRow['tournament_id']);
				$this->db->update('tournaments_results', $tRowUpdate);
				
			}
        }
    }


    public function reassignExpiredVouchers(){
    	$previous_date =  date('Y-m-d', strtotime('-1 day'));

    	$list = $this->db->query("SELECT * FROM tbl_tournaments_players WHERE redeem_expiry_date = '$previous_date' AND redeem_prize = '0' ")->result_array();
	  
	/*	echo $this->db->last_query();
		echo "<pre>";
		print_r($list);
		echo "</pre>";
		die; 
		*/  
        if(is_array($list) && count($list)>0){
        	foreach($list as $tRow){
				
				$tournamentId = $tRow['player_t_id'];
				$userId = $tRow['player_user_id'];
				$voucherId = $tRow['prize_voucher_id'];
				$playerId = $tRow['player_id'];
				
				
				//expired voucher to to player table
				$playerData['redeem_prize'] = '1';  // expired
				$this->db->where('player_id', $playerId);
				$this->db->update('tournaments_players', $playerData);
				
				//status update of voucher assign
				$voucherRow['tv_assigned_status'] = '5';  // expired from user so reassign to main voucher table
				$this->db->where('tv_tournament_id', $tournamentId);
				$this->db->where('tv_voucher_id', $voucherId);
				$this->db->update('tournament_voucher_detail', $voucherRow);
								
				//status update of voucher assign
				$voucherUpdate['voucher_status'] = '0';  // reissued to main vouchers after user expiration
				$this->db->where('voucher_id', $voucherId);
				$this->db->update('voucher_detail', $voucherUpdate);
                     
					 
				// deduct coupon from the voucher type and update balance
				$voucherDetail = $this->SITEDBAPI->getVoucherDetail($voucherId);
				$vtAssignCoupons = $voucherDetail['vt_assign_coupons'];
				$vtBalanceCoupons = $voucherDetail['vt_balance_coupons'];
				
				$updateCoupon['vt_assign_coupons'] = ($vtAssignCoupons-1);
				$updateCoupon['vt_balance_coupons'] = ($vtBalanceCoupons+1);
				$this->db->where('vt_id', $voucherDetail['vt_id']);
				$this->db->update('voucher_type', $updateCoupon);		 
				

				// finally update logs
				$logs['log_voucher_id'] =  $voucherId;
				$logs['log_tournament_id'] = $tournamentId;
				$logs['log_voucher_status'] = '9'; //reissued after user not claimed
				$logs['log_message'] = 'reissued_not_claimed_voucher';
				$logs['log_date_time'] = date('Y-m-d H:i:s');
				$logs['log_added_on'] = time();
				$this->db->insert('voucher_logs', $logs);
				
				//add Notification for tournament rewards claimed 
				$notifyData['notify_user_id'] =  $userId;
				$notifyData['notify_type'] =  '9';  //1=TournamentCreated   2=Spin&Win   3=RedeemCoins   4=TournamentRewardAdded   5=UpdateProfileName    6=SubscriptionCoins   7=RewardAdded  8=RewardClaimed  9=VoucherExpired
				$notifyData['notify_title'] =  "Tournament Reward Expired";
				$notifyData['notify_desc'] =  "A daraz voucher worth <b>".number_format($voucherDetail['vt_type'], 0)." BDT </b>, not claimed, is expired.";
				$notifyData['notify_status'] =  '0';
				$notifyData['notify_date'] =  date('Y-m-d');
				$notifyData['notify_added_on'] =  time();
				$this->db->insert('user_notifications', $notifyData);
				
			}
        }

    }

	public function expireExistingVoucher(){
		$expireDate = date("Y-m-d");
		$date=date("Y-m-d" , strtotime('+3 months' , strtotime($expireDate)));
		$notExpired = $this->db->query("SELECT * FROM tbl_voucher_detail WHERE voucher_validity_ends <= '$date' AND voucher_status='0'")->result_array();
		if(is_array($notExpired) && count($notExpired)>0){
			foreach($notExpired as $value){

				$voucherUpdate['voucher_status'] = '6';  // expire voucher
				$this->db->where('voucher_id', $value['voucher_id']);
				$this->db->update('voucher_detail', $voucherUpdate);
			
				// Update Voucher Balance
				$voucherDetail = $this->SITEDBAPI->getVoucherDetail($value['voucher_id']);
				$updateCoupon['vt_expired_coupons'] = $voucherDetail['vt_expired_coupons'] +1;
				$updateCoupon['vt_balance_coupons'] = $voucherDetail['vt_balance_coupons'] -1;
				$this->db->where('vt_id' , $voucherDetail['vt_id']);
				$this->db->update('voucher_type', $updateCoupon);
				
				// Update Logs 
				$log['log_voucher_id'] = $value['voucher_id'];
				$log['log_tournament_id'] = 0;
				$log['log_user_id'] = 0;
				$log['log_voucher_status'] = 10;  // Not AvailableForAssignment
				$log['log_message'] = 'Expire_in_90_days';
				$log['log_date_time'] = date("Y-m-d H:i:s");
				$log['log_added_on'] = time();
				$this->db->insert('tbl_voucher_logs', $log);
			}
		}
		
		$expiredVouchers = $this->db->query("SELECT * FROM tbl_voucher_detail WHERE voucher_validity_ends <= '$expireDate' AND  voucher_status='6' ")->result_array();
		// echo "<pre>";
		// print_r($expiredVouchers);
		// die();
		if(is_array($expiredVouchers) && count($expiredVouchers) >0){
			foreach($expiredVouchers as $row){
				$voucherUpdate['voucher_status'] = '4';  // expire voucher
				$this->db->where('voucher_id', $row['voucher_id']);
				$this->db->update('voucher_detail', $voucherUpdate);

				// Update Logs 
				$log['log_voucher_id'] = $row['voucher_id'];
				$log['log_tournament_id'] = 0;
				$log['log_user_id'] = 0;
				$log['log_voucher_status'] = 5;  // Voucher Expired
				$log['log_message'] = 'Voucher_expired';
				$log['log_date_time'] = date("Y-m-d H:i:s");
				$log['log_added_on'] = time();
				$this->db->insert('tbl_voucher_logs', $log);
			}
		}

	}

	
/*
    public function VoucherCancel(){
    	$previous_date =  date('Y-m-d', strtotime('-1 day'));

    	$list = $this->db->query("SELECT * FROM tbl_tournaments_players  WHERE  Date(`tbl_tournaments_players`.redeem_expiry_date)='$previous_date' and redeem_prize='0'")->result_array();
		
        if(is_array($list) && count($list)>0){
        	foreach($list as $tRow){
        	     $data['redeem_prize'] = '1';
				 $this->db->where('player_id', $tRow['player_id']);
				 $this->db->update('tournaments_players', $data);
                 $voucher_detail = $this->SITEDBAPI->getVoucherInfo($tRow['prize_voucher_id']);
                 $voucher_type_id = $voucher_detail['voucher_typeid'];
                 
                 //coupon balance change 
				 $this->db->set('balance_coupon', 'balance_coupon+1',false);
				 $this->db->where('vouchertype_id', $voucher_type_id);
				 $this->db->update('tbl_voucher_type');

                 //coupon assigned status change
				 $this->db->set('status', '3',false);
				 $this->db->where('tournament_id', $tRow['player_t_id']);
				 $this->db->where('voucher_id', $tRow['prize_voucher_id']);
				 $this->db->where('user_rank', $tRow['player_reward_rank']);
				 $this->db->update('tbl_tournament_voucher_detail');
			}
        }

    }
*/
	public function RedeemModalData(){
		$voucher_id= $_POST['id'];
		$player_id= $_POST['player_id'];
		
		$this->SITEDBAPI->updateVoucherClaimed($player_id, $voucher_id);
		
		$voucherDetail = $this->SITEDBAPI->getVoucherDetail($voucher_id);
		$expiry = $this->db->query("SELECT redeem_prize,redeem_expiry_date FROM tbl_tournaments_players WHERE player_id = '$player_id'")->row();
		
		$data['voucher_id'] = $voucherDetail['voucher_id'];
		$data['voucher_name'] = "Daraz Voucher of  ???  ".$voucherDetail['vt_type'];
		$data['voucher_code'] = $voucherDetail['voucher_code'];
		$data['voucher_website'] = $voucherDetail['voucher_website'];
		$data['voucher_description'] = $voucherDetail['voucher_description'];
		$data['voucher_redeem'] = $expiry->redeem_prize;
		$data['voucher_expiry'] = "Valid till ".date('F j, Y', strtotime($expiry->redeem_expiry_date));
		
		echo json_encode($data);

	}
/*
	public function RedeemVoucher(){
		$voucher_prize= $this->uri->segment(2);
		$player_id= $this->uri->segment(3);
		$data['voucherDetail']=$this->SITEDBAPI->getVoucherdetailbyPrize($voucher_prize);
        $website = $data['voucherDetail']['website'];
		//$this->SITEDBAPI->RedeemVoucherUpdate($player_id);
		header('Location: '.$website);

	}
*/
	
}
