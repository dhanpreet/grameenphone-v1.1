<?php   
require APPPATH . 'libraries/REST_Controller.php';
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Gp extends REST_Controller {
    public function __construct() {
        parent::__construct();        
        $this->load->database();
        $this->load->model('gp_model','GPDBAPI');
        $this->load->library('user_agent');
        $this->load->helper('jwt');
       date_default_timezone_set("Asia/Dhaka");
    }
	public function index_get(){
		redirect('error');
	}  
	
	private function base64url_encode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}
	
	public function getToken_post(){
	   $data = json_decode(file_get_contents('php://input'), true);
	   if(empty($data)){		   
			$status = (string) parent::HTTP_UNAUTHORIZED;
			$response = ['status' =>'FAIL', 'message' => 'Invalid Request!'];
			$this->response($response, $status);		  
	    } else {
			$msisdn = $data['msisdn'];
			$client_id = $data['client_id'];
			$client_secret = $data['client_secret'];
			$subscription_status = @$data['subscription_status'];
			$subscription_expiry = date('Y-m-d', strtotime(@$data['subscription_expiry']));
			$today = date('Y-m-d');
			//used if user subscribe from regular to premium on tournament page play button
			$consent = @$data['consent'];
			$referenceId = @$data['referenceId'];
			if(!empty($msisdn) && !empty($client_id) && !empty($client_secret)){
				if($client_id == GP_CLIENT_ID && $client_secret == GP_CLIENT_SECRET){
					if(isset($data['subscription_status']) && $data['subscription_status'] == true && ($subscription_expiry < $today) ){ 
						$status = (string) parent::HTTP_UNAUTHORIZED;
						$response = ['status' =>'FAIL', 'message' => 'Invalid Subscription Request!'];
						$this->response($response, $status);
					} else {
						
						//$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
						$requestHeader = array("alg"=> "HS256", "typ"=> "JWT");
					
						$token_start_date = date('Y-m-d H:i:s');
						$token_end_date = date('Y-m-d')." 23:59:59";
						$exp = strtotime($token_end_date);
						$iat = strtotime($token_start_date);
						if(isset($data['subscription_status']) && $data['subscription_status'] == true){
							//$payload = json_encode(['data' => ['msisdn' => $msisdn,'subscription_status' => $subscription_status,'subscription_expiry' => $subscription_expiry ],'iat' => $iat, 'exp' => $exp]);
						
							$requestPayload = array("data"=> array("msisdn"=> $msisdn, "subscription_status"=> $subscription_status, "subscription_expiry"=> $subscription_expiry), 'iat' => $iat, 'exp' => $exp);

						} else {
							$subscription_status = "";
							$subscription_expiry = "";
							//$payload = json_encode(['data' => ['msisdn' => $msisdn,'subscription_status' => false],'iat' => $iat, 'exp' => $exp]);
							$requestPayload = array("data"=> array("msisdn"=> $msisdn, "subscription_status"=> false), 'iat' => $iat, 'exp' => $exp);
						}
						//$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
						//$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
						
						$base64UrlHeader = $this->base64url_encode(json_encode($requestHeader));
						$base64UrlPayload = $this->base64url_encode(json_encode($requestPayload));
						$signature = hash_hmac('SHA256', $base64UrlHeader. "." .$base64UrlPayload, GP_CLIENT_SECRET, true);
						$base64UrlSignature = $this->base64url_encode($signature);
						$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
						
						//jwt token logs
						$loginJWT['log_msisdn'] = $msisdn;
						$loginJWT['log_token_start_date'] = $iat;
						$loginJWT['log_token_end_date'] = $exp;
						$loginJWT['log_subscription_status'] = $subscription_status;
						$loginJWT['log_subscription_expiry'] = $subscription_expiry;
						$loginJWT['log_jwt_token'] = $jwt;
						$loginJWT['log_user_consent'] = $consent;
						$loginJWT['log_consent_reference_id'] = $referenceId;
						$loginJWT['log_date_time'] = date('Y-m-d H:i:s');
						$loginJWT['log_default_utc_time'] = gmdate('Y-m-d H:i:s');
						$loginJWT['log_added_on'] = time();
						if($this->db->insert('user_login_token_logs', $loginJWT)){
							$log_id = $this->db->insert_id();
							
							
							//update the user status if regular becomes premium or vica versa
							if(isset($data['subscription_status']) && $data['subscription_status']==true){ //for premium customer
								$data['subscription_info'] = "Premium";
							} else {    
								$data['subscription_info'] = "regular";
								$data['subscription_status'] = "";
								$data['subscription_expiry'] = "";	
							}  
							
							$userId = $this->GPDBAPI->saveLoginSubscriptionUpdate($data); 

							if(!empty($userId)){
								
								$status = (string) parent::HTTP_OK;
								$response = ['token' => $jwt];
								$this->response($response, $status);
							
							} else {
								$status = (string) parent::HTTP_UNAUTHORIZED;
								$response = ['status' =>'FAIL', 'message' => 'Invalid Request!'];
								$this->response($response, $status);
							}
							
							
							/*
							if(!empty($consent) && !empty($referenceId)){
								//update the user status if regular becomes premium or vica versa
								if(isset($data['subscription_status']) && $data['subscription_status']==true){ //for premium customer
									$data['subscription_info'] = "Premium";
								} else {    
									$data['subscription_info'] = "regular";
									$data['subscription_status'] = "";
									$data['subscription_expiry'] = "";	
								}  
								$userId = $this->GPDBAPI->saveLoginSubscriptionUpdate($data); 
								if(!empty($userId)){
									$upLog['log_handled'] = '1';
									$this->db->where('log_id', $log_id);
									$this->db->update('user_login_token_logs', $upLog);
								}
							}
							
							$status = (string) parent::HTTP_OK;
							$response = ['token' => $jwt];
							$this->response($response, $status);
							
							*/
							
						} else {
							$status = (string) parent::HTTP_UNAUTHORIZED;
							$response = ['status' =>'FAIL', 'message' => 'Invalid Request!'];
							$this->response($response, $status);
						}
					} 
		        } else{
					$status = (string) parent::HTTP_UNAUTHORIZED;
					$response = ['status' =>'FAIL', 'message' => 'Invalid Client Secret!'];
					$this->response($response, $status);
		        }
	        } else {
				$status = (string) parent::HTTP_UNAUTHORIZED;
				$response = ['status' =>'FAIL', 'message' => 'Invalid Request!'];
				$this->response($response, $status);
	        }
        }
    }
	
	private function getClientIP() {
	   $ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	
	
	public function updateUserLogin1_get(){		
		$header=$this->input->request_headers(); // fetch header from gp request
        if(isset($header['USER-TOKEN'])){
        	$jwttoken = $header['USER-TOKEN'];
        }elseif (isset($header['user-token'])){
        	$jwttoken = $header['user-token'];
        }
        if(!empty($jwttoken)){
        	$jwt = new JWT();
		    try { 
				$arr = $jwt->decode($jwttoken, GP_CLIENT_SECRET, 'HS256');
				$jwt_decode_arr = (array)$arr;
				$iat = $jwt_decode_arr['iat'];
				$exp = $jwt_decode_arr['exp'];
				$data = (array)$jwt_decode_arr['data'];
				$json = json_encode($data);
				$token_expiry_date = $exp; //  expiry date fetch after decoding the token 
				$tokenExpiryDate = date('Y-m-d H:i:s', $token_expiry_date);
				$today = date('Y-m-d H:i:s');
		        if($tokenExpiryDate >= $today){ //check token validity from expiry of token 
					if($json){
						// Update user login access logs starts
						$timestamp = time();
						$userData['uniqid'] = $timestamp;
						$userData['msisdn'] = $data['msisdn'];
						$userData['ip'] = $this->getClientIP();
						if( !isset( $_SERVER['HTTP_USER_AGENT'])){  // fetch user agent for log purpose
						  $userData['user_agent'] = "none";
						} else {
						   $userData['user_agent'] = strtolower($_SERVER['HTTP_USER_AGENT']);
						}
						$userData['jwt_token'] = $jwttoken;
						$userData['token_expiry_date'] = $token_expiry_date;
						$userData['date_time'] = date('Y-m-d H:i:s');
						$userData['default_time'] = gmdate('Y-m-d H:i:s');
						if(isset($data['subscription_status']) && $data['subscription_status']==true){ //for premium customer
							$userData['subscription_info'] = "Premium";
							$userData['subscription_status']=$data['subscription_status'];
							$userData['subscription_expiry']=$data['subscription_expiry'];
						} else {         // for regular customer
							$userData['subscription_info'] = "regular";
							$userData['subscription_status'] = "";
							$userData['subscription_expiry'] = "";	
						}  
						$this->db->insert('user_login_access_logs',$userData);
						// Update user login access logs ends
						$userId = $this->GPDBAPI->checkTokenRequest($userData); 
						if($userId){
							$loginToken = time().'-'.$userId;
							$loginToken = base64_encode($loginToken);					
							$loginAccessURL = site_url('UserAccess/?token='.$loginToken);
							redirect($loginAccessURL);
						} else {
							
							$this->session->set_userdata('loginerror', 'Invalid Token Identified!');
							$errorUrl = site_url('LoginError');
							redirect($errorUrl);
						}
					} else {
					
						$this->session->set_userdata('loginerror', 'Empty Token Identified!');
						$errorUrl = site_url('LoginError');
						redirect($errorUrl);
					}
				} else {
					
					$this->session->set_userdata('loginerror', 'Token has been expired!');
					$errorUrl = site_url('LoginError');
					redirect($errorUrl);
				}
			} catch (\Exception $e) { // Also tried JwtException
				
				$this->session->set_userdata('loginerror', 'Invalid Token Identified!');
				$errorUrl = site_url('LoginError');
				redirect($errorUrl);
			}
	    } else {
			
	    	$this->session->set_userdata('loginerror', 'Invalid Token Identified!');
			$errorUrl = site_url('LoginError');
			redirect($errorUrl);
	    }
    }
	
	
	public function updateUserLogin_get(){		
		$header=$this->input->request_headers(); // fetch header from gp request
        if(isset($header['USER-TOKEN'])){
        	$jwttoken = $header['USER-TOKEN'];
        }elseif (isset($header['user-token'])) {
        	$jwttoken = $header['user-token'];
        }
		//echo $jwttoken; die;
        if(!empty($jwttoken)){
        	$jwt = new JWT();
			
		    try { 
				$arr = $jwt->decode($jwttoken, GP_CLIENT_SECRET, 'HS256');
				$jwt_decode_arr = (array)$arr;
			
				$iat = $jwt_decode_arr['iat'];
				$exp = $jwt_decode_arr['exp'];
				$data = (array)$jwt_decode_arr['data'];
				$json = json_encode($data);
				$token_expiry_date = $exp; //  expiry date fetch after decoding the token 
				$tokenExpiryDate = date('Y-m-d H:i:s', $token_expiry_date);
				$today = date('Y-m-d H:i:s');
			
		        if($tokenExpiryDate >= $today){ //check token validity from expiry of token 
					if($json){						
						if(!empty($data['msisdn'])){
							$loginToken = time().'-'.$data['msisdn'];
							$loginToken = base64_encode($loginToken);					
							$loginAccessURL = base_url().'UserAccessPortal/?token='.$loginToken;
							redirect($loginAccessURL);
						
						} else {
							$this->session->set_userdata('loginerror', 'Invalid Token Identified!');
							$errorUrl = site_url('LoginError');
							redirect($errorUrl);
						}
					} else {					
						$this->session->set_userdata('loginerror', 'Empty Token Identified!');
						$errorUrl = site_url('LoginError');
						redirect($errorUrl);
					}
				} else {
					$this->session->set_userdata('loginerror', 'Token has been expired!');
					$errorUrl = site_url('LoginError');
					redirect($errorUrl);
				}
			} catch (\Exception $e) { // Also tried JwtException
				$this->session->set_userdata('loginerror', 'Invalid Token Identified!');
				$errorUrl = site_url('LoginError');
				redirect($errorUrl);
			}
	    } else {
	    	$this->session->set_userdata('loginerror', 'Invalid Token Identified!');
			$errorUrl = site_url('LoginError');
			redirect($errorUrl);
	    }
    }

	
	
	
	
	public function updateUserCallback_get(){		
		/*$this->db->select("*");
		$this->db->from("user_login_token_logs");
		$this->db->where("log_handled",'0');
		$list = $this->db->get()->result_array();
		if(is_array($list) && count($list)>0){
			//echo "<pre>"; print_r($list); echo "</pre>";
			foreach($list as $row){
				$log_id = $row['log_id'];
				$data['msisdn'] = $row['log_msisdn'];
				if(isset($row['log_subscription_status']) && $row['log_subscription_status']==1){ //for premium customer
					$data['subscription_info'] = "Premium";
					$data['subscription_status'] = "1";
					$data['subscription_expiry'] = $row['log_subscription_expiry'];
				} else {    
					$data['subscription_info'] = "regular";
					$data['subscription_status'] = "";
					$data['subscription_expiry'] = "";	
				}
				$userId = $this->GPDBAPI->saveLoginSubscriptionUpdate($data); 
				if(!empty($userId)){
					$upLog['log_handled'] = '1';
					$this->db->where('log_id', $log_id);
					$this->db->update('user_login_token_logs', $upLog);
				}
			}
		}  */ 
    }
	
	
	public function updateGameboostId_get(){		
		$this->db->select("*");
		$this->db->from("site_users");
		$this->db->where("skillpod_player_id IS NULL ");
		$this->db->order_by("user_id");
		//$this->db->limit("1000");
		$list = $this->db->get()->result_array();
		if(is_array($list) && count($list)>0){
			echo "<pre>"; print_r($list); echo "</pre>";
			foreach($list as $row){
				$userId = $row['user_id'];
				$this->GPDBAPI->createGameboostIdGP($userId);
			}
		} 
    }
	
}