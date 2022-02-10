<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
require_once dirname(__FILE__) . '/xlsxwriter.class.php';
class Admin extends CI_Controller {
	
	
	public  function __construct(){
		parent:: __construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('text');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->library('encryption');	
		$this->load->model('admin_model','ADMINDBAPI');
	
		date_default_timezone_set("Asia/Dhaka");
		
    }

	public function index()	{	
	
	//echo "1"; die;
		if($this->session->userdata('admin_logged_in'))
			redirect('Admin/Home');
		else{
			$this->load->view('admin/login');
		}
	}
	
	
	public function processLogin(){
		
	 	$username = trim($_POST['username']);
		$password  = trim($_POST['password']);
	
		if(!($username && $password)){
			$this->session->set_flashdata('error','<strong>Error! </strong> Email and Password Both Fields Required.');
			redirect('Admin');
		}	else{
			$status = $this->ADMINDBAPI->getLoginStatus($username,$password);
			
			if(count($status) == 0){
				
				$this->session->set_flashdata('error','<strong>Error! </strong> Invalid Email or Password.');
				redirect('Admin');
			} else{
				$profile = $this->ADMINDBAPI->getUserInfo($status['user_id']);
		
				$user_login_data = array(
				   'username'     => $username,
				   'name'     => $status['name'],
				   'user_id'      => @$status['user_id'],
				   
			   );
				$user_login_data['admin_logged_in'] = TRUE;					
				$this->session->set_userdata($user_login_data);
				redirect('Admin/Home');		
			}
		}	
	}
	
	
	public function alert(){
		$this->session->sess_destroy();	
		redirect('Admin');			
	}
	
	public function error(){
		//$this->session->sess_destroy();
		//redirect('Admin');	
		$this->load->view('admin/error');	
	}
		
	public function logout(){	
		$this->session->sess_destroy();		
		redirect('Admin');
	}
	
	

	public function home(){
		if($this->session->userdata('admin_logged_in')){
			$data['allGames'] = $this->ADMINDBAPI->getAllGamesCount();
			$data['allPublishedGames'] = $this->ADMINDBAPI->getPublishedGamesCount();
			$data['allTournaments'] = $this->ADMINDBAPI->getTournamentsCount();
			$data['liveTournaments'] = $this->ADMINDBAPI->getLiveTournamentsCount();
			
			$this->load->view('admin/dashboard', $data);
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
			
		}
	}
	


	//******************************************************************************************//
	//************************     Update Password Starts         ************************//
	//******************************************************************************************//
	
	public function updatePassword(){
		if($this->session->userdata('admin_logged_in')){
			$user_id = $this->session->userdata('user_id');
			$data['info'] = $this->ADMINDBAPI->getUserInfo($user_id);
			$this->load->view('admin/update_password', $data);
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
			
		}
	}
	
	public function processUpdatePassword(){
		if($this->session->userdata('admin_logged_in')){
			$user_id = $this->session->userdata('user_id');
			
			$info = $this->ADMINDBAPI->getUserInfo($user_id);
		//	print_r($info); die;
			if(is_array($info) && count($info)>0){
				
				$old_password = $_POST['old_password'];
				$new_password = $_POST['new_password'];
				$confirm_password = $_POST['confirm_password'];
				
			if($old_password == $info['password']){
				$this->db->where('user_id', $user_id);
				
				if($new_password == $confirm_password){
				
					$user['password'] = $new_password;
					if($this->db->update('login', $user)){
						$this->session->set_flashdata('success','<strong> Success!</strong>  Profile settings updated successfully.');
						redirect("Admin/UpdatePassword");
					} else {
						$this->session->set_flashdata('error','<strong> Error!</strong>  Something went wrong while updating information. Please try again later.');
						redirect("Admin/UpdatePassword");
					}
				
				} else {
					$this->session->set_flashdata('error',"<strong>Error! </strong> New password and confirm password doesn't match.");
					redirect("Admin/UpdatePassword");
				}
			
			} else {
				$this->session->set_flashdata('error','<strong>Error! </strong> Old password is incorrect.');
				redirect("Admin/UpdatePassword");
			}
				
			} else {
				$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
				redirect('Admin');
			
			}
		
		} else {
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
			
		}
		
	}
	
	//******************************************************************************************//
	//************************     Update Password Ends         ************************//
	//******************************************************************************************//
	
	
	
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Games Categories Section Starts **************************************//
	//  **************************************   ***************************** **************************************//
	
	
	
	public function getCategories(){
		if($this->session->userdata('admin_logged_in')){
			$data['list'] = $this->ADMINDBAPI->getCategoriesList();
			$this->load->view('admin/categories_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	
	public function processCategory(){
		if($this->session->userdata('admin_logged_in')){
			
			$id = base64_decode(@$_POST['category_id']); 
			foreach($_POST as $key=>$val){
				$data[$key] = $val;
			}	
			unset($data['category_id']);
			
			
			if($id){
				$data['category_updated_on'] = time();
				$this->db->where('category_id', $id);				
				if($this->db->update('categories', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Category information updated successfully. ');
					redirect("Admin/ManageCategories");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to update category information. Please try again.');
					redirect("Admin/ManageCategories");
				}				
			} else {
				$data['category_added_on'] = time();
				$data['category_updated_on'] = time();
				
				if($this->db->insert('categories', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Category information added successfully. ');
					redirect("Admin/ManageCategories");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to add new category information. Please try again.');
					redirect("Admin/ManageCategories");
				}
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Games Categories Section Ends **************************************//
	//  **************************************   ***************************** **************************************//
	
	
	
	
	
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Games Section Starts **************************************//
	//  **************************************   ***************************** **************************************//
	
	public function getGames(){
		if($this->session->userdata('admin_logged_in')){
			$data['categories'] = $this->ADMINDBAPI->getCategoriesList();
			$data['list'] = $this->ADMINDBAPI->getGamesList();
			$this->load->view('admin/games_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function getPlayGame($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$data['gameInfo'] = $this->ADMINDBAPI->getGamesInfoByGameboostId($id);
			$data['gameId'] = $id;
			$this->load->view('admin/play_game', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function updateGameInfo(){
		if($this->session->userdata('admin_logged_in')){
		
			$id = @$_POST['id']; 
			$gid = @$_POST['gid']; 
			foreach($_POST as $key=>$val){
				$data[$key] = $val;
			}	
			unset($data['id']);
			unset($data['gid']);
			
			$category_id = $_POST['portalCategoryId'];
			$categoryInfo = $this->ADMINDBAPI->getCategoriesInfo($category_id);
			$data['portalCategory'] = $categoryInfo['category_name'];
			
		
			if($id && $gid){				
				$this->db->where('id', $id);				
				$this->db->where('gid', $gid);				
				if($this->db->update('games', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Game information updated successfully. ');
					redirect("Admin/ManageGames");
					
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to update game information. Please try again.');
					redirect("Admin/ManageGames");
				}				
			} else {
				$this->session->set_flashdata('error','<strong> Error! </strong> Unable to update game information. Please try again.');
				redirect("Admin/ManageGames");
			}			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Account.');
			redirect('Admin');			
		}
	}
	
	
	public function getPracticeBanners(){
		if($this->session->userdata('admin_logged_in')){
		
			$data['games'] = $this->ADMINDBAPI->getPublishedGamesList();
			$data['list'] = $this->ADMINDBAPI->getPractiseBannersList();
			$this->load->view('admin/practise_banners_list', $data);
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Account.');
			redirect('Admin');			
		}
	}
		
	public function processPracticeBanner(){
		if($this->session->userdata('admin_logged_in')){
			
			if(!empty($_POST['banner_game_id']) && !empty($_FILES['banner_image_path']['name'])){
				
				$data = array();
				foreach($_POST as $key=>$val){
					$data[$key] = $val;
				}

				$banner_game_id = $_POST['banner_game_id'];
				$gameInfo = $this->ADMINDBAPI->getGamesInfo($banner_game_id);
				
				$data['banner_game_id'] = $gameInfo['gid'];
				$data['banner_gameboost_id'] = $gameInfo['id'];
				$data['banner_game_name'] = $gameInfo['Name'];
				$data['banner_game_image'] = $gameInfo['GameImage'];
				
				
				$filename = $_FILES["banner_image_path"]["name"];
				$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
				$file_ext = substr($filename, strripos($filename, '.')); // get file name
					
				//$newfilename = md5($file_basename).'_'.time().'_ITR_'. $file_ext;
				$newfilename = md5($file_basename).'-'.time(). $file_ext;
			
				if(move_uploaded_file($_FILES["banner_image_path"]["tmp_name"], "uploads/practise-banners/".$newfilename))
					$data['banner_image_path']	= $newfilename; 
			
			
				$data['banner_added_on'] = time();
				$data['banner_updated_on'] = time();
				
				if($this->db->insert('practise_banners', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Practice zone banner information added successfully. ');
					redirect("Admin/PracticeBanners");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to add practice zone banner information. Please try again.');
					redirect("Admin/PracticeBanners");
				}
			} else {
				$this->session->set_flashdata('error',"<strong> Error! </strong> Required parameters are missing for uploading a new practice zone banner.Please add all mandatory fields.");
				redirect("Admin/PracticeBanners");
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
		
	public function updatePractiseBannerStatusAjax(){
		if($this->session->userdata('admin_logged_in')){
			
			if(!empty($_POST['id'])){
				$banner_id = $_POST['id'];
				$bannerInfo = $this->ADMINDBAPI->getPractiseBannersInfo($banner_id);
				
				if($bannerInfo['banner_status'] == '1'){
					$data['banner_status'] = '2';
				} else {
					$data['banner_status'] = '1';
				}
				
				$data['banner_updated_on'] = time();
				$this->db->where('banner_id', $banner_id);
				if($this->db->update('practise_banners', $data)){
					echo "success";
				} else {
					echo "error";
				}
			} else {
				echo "error";
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function deletePracticeBanner($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			
			// finally remove practise banner
			$this->db->where('banner_id', $id);
			if($this->db->delete('practise_banners')){
				$this->session->set_flashdata('success','<strong> Success! </strong> Practice banner information deleted successfully. ');
				redirect("Admin/PracticeBanners");
			} else {
				$this->session->set_flashdata('error','<strong> Error! </strong> Unable to delete practice banner information. Please try again.');
				redirect("Admin/PracticeBanners");
			}
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	//  **************************************   ***************************** **************************************//
	//  **************************************   Games Section Ends **************************************//
	//  **************************************   ***************************** **************************************//
	


	//  **************************************   ***************************** **************************************//
	//  **************************************    Manage Country Starts **************************************//
	//  **************************************   ***************************** **************************************//
	
		public function manageCountry()
		{
			if($this->session->userdata('admin_logged_in'))
			{
				$data['list']	=	$this->ADMINDBAPI->getCountryList();
				$this->load->view('admin/country_list', $data );
			}
			else
				redirect('Admin');
		}

		public function processCountry()
		{
			if($this->session->userdata('admin_logged_in'))
			{
				$data['c_name']	=	$this->input->post('c_name');
				$data['c_country_code']	=	$this->input->post('c_country_code');	
				$data['c_currency_code']	=	$this->input->post('c_currency_code');
				$data['c_timezone']	=	$this->input->post('c_timezone');
				$data['c_status']	=	$this->input->post('c_status');
				$result		=	$this->ADMINDBAPI->setCountry($data);
				if($result)
					$this->session->set_flashdata('success' , '<strong> Success!</strong> New country addedd successfully.');
				else
					$this->session->set_flashdata('error' , '<strong> Error! </strong> Unable to add new country. Please try again');
					
				redirect(site_url('admin/manageCountry'));
			}
			else
				redirect('Admin');
		}

		public function updateCountry()
		{
			if($this->session->userdata('admin_logged_in'))
			{
				$c_id	=	base64_decode($this->input->post('c_id'));
				$data['c_name']	=	$this->input->post('c_name');
				$data['c_country_code']= $this->input->post('c_country_code');
				$data['c_currency_code']=$this->input->post('c_currency_code');
				$data['c_timezone']=$this->input->post('c_timezone');
				$data['c_status']=$this->input->post('c_status');
				$result		=	$this->ADMINDBAPI->updateCountry($c_id, $data);
				if($result)
					$this->session->set_flashdata('success', '<strong> Success! </strong> Country information updated successfully. ');
				else
					$this->session->set_flashdata('error', '<strong> Error! </strong> Unable to update country information. Please try again.');
				redirect('Admin/ManageCountry');
			}
			else
				redirect('Admin');
		}
		public function deleteCountry($id)
		{
			if($this->session->userdata('admin_logged_in'))
			{
				$id=base64_decode($id);
				$result		=	$this->ADMINDBAPI->deteleCountry($id);
				$this->session->set_flashdata('success' , '<strong>Success! </strong> Country information deleted successfully.');
				redirect('Admin/ManageCountry');
			}
			else
				redirect('Admin');
		}

	//  **************************************   ***************************** **************************************//
	//  **************************************   Manage Country Ends **************************************//
	//  **************************************   ***************************** **************************************//
	
	
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Tournament Section Starts **************************************//
	//  **************************************   ***************************** **************************************//
	
	public function getTournaments(){
		if($this->session->userdata('admin_logged_in')){
			//$data['categories'] = $this->ADMINDBAPI->getCategoriesList();
			$data['list'] = $this->ADMINDBAPI->getTournamentsList();
			$data['voucher'] = $this->ADMINDBAPI->getVoucher();
			// echo "<pre>";
			// print_r($data['list']);
			// die();
			$this->load->view('admin/tournament_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function  resultcount(){
		$result = $this->ADMINDBAPI->getvoucherSectionsByCount(2);
		print_r($result);
	}
	
	public function newTournament(){
		if($this->session->userdata('admin_logged_in')){
			$data['categories'] = $this->ADMINDBAPI->getCategoriesList();
			$data['country']	=	$this->ADMINDBAPI->getActiveCountryList();
			$data['voucherListFirstPrize']	=	$this->ADMINDBAPI->getvoucherSectionsByCount(1);
			$data['voucherlistForthPrize']	=	$this->ADMINDBAPI->getvoucherSectionsByCount(7);
			$data['voucherlistFifthPrize']	=	$this->ADMINDBAPI->getvoucherSectionsByCount(40);
			$data['voucherlistFree_day']	=	$this->ADMINDBAPI->getvoucherSectionsByCount(10);
			$data['vouchertypelist']	=	$this->ADMINDBAPI->getVoucherTypes();
			
			$this->load->view('admin/tournament_new', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function getCategoryGamesAjax(){
		if($this->session->userdata('admin_logged_in')){
			$category = $_POST['category'];
			if(!empty($category) && $category !==''){
				$games = $this->ADMINDBAPI->getCategoryGamesList($category);
				echo "<option value=''>Choose Game</option>";
				if(is_array($games) && count($games)>0){
					foreach($games as $row){
						echo "<option value='".$row['gid']."'>".$row['Name']."</option>";
					}
				}
			} else {
				echo "<option value=''>Choose Game</option>";
			}
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	public function processTournament(){
		if($this->session->userdata('admin_logged_in')){
			if(!empty($_POST['tournament_reward_type'][0]) && $_POST['tournament_reward_type'][0]=='4'){
                foreach($_POST as $key=>$val){
					if($val!=''){
						if(is_array($val)){
		                    if(!empty($val)){
						       foreach($val as $value){
							       if($value!=''){
								      $data[$key] = (array)$value;
								      break;
							        }else{
								      $data[$key] = (array)"";
							        }			
						        }
					        }else{
						       $data[$key] = (array)"";
					        }
						}else{
		                  $data[$key] = $val;
						}	
					}
		        }
			}else{
				foreach($_POST as $key=>$val){
				
					$data[$key] = $val;
				
				}
	    	}
			
			/*
			$result= $this->ADMINDBAPI->checkExistingTournament($data['tournament_section'] , $data['tournament_start_date']);
			if($result)
			{	
				if($data['tournament_section']==1)
					$section = "Free";
				else if($data['tournament_section']==2)
				{
					$section = "Weekly (Premium)";
				}
				else
				{
					$section = "Daily (Permium) ";
				}
				$this->session->set_flashdata('error','<strong> Error! </strong> You already created '.$section.' tournament for '.date("d/M/Y" , strtotime($data['tournament_start_date'])).'.');
				redirect("Admin/ManageTournaments");
			}
			*/
			
			$voucher = $this->ADMINDBAPI->getVoucher();
			/*
			if($data['tournament_section']==2)
			{
				foreach($voucher as $row)
				{
					$data2[$row['vt_id']] = $row['vt_balance_coupons'];
				}
				$data2[$data['tournament_prize_1'][0]] = $data2[$data['tournament_prize_1'][0]] -1;
				$data2[$data['tournament_prize_2'][0]] = $data2[$data['tournament_prize_2'][0]] -1; 
				$data2[$data['tournament_prize_3'][0]] = $data2[$data['tournament_prize_3'][0]] -1;
				$data2[$data['tournament_prize_4'][0]] = $data2[$data['tournament_prize_4'][0]] -7;
				$data2[$data['tournament_prize_5'][0]] = $data2[$data['tournament_prize_5'][0]] -40;
				
				foreach($data2 as $value)
				{
					if($value<0)
					{
						$this->session->set_flashdata('error','<strong> Error! </strong> Wrong voucher distribution. Please try again');
						redirect("Admin/ManageTournaments");
					}
				}
			}
			if($data['tournament_section']==3)
			{
				foreach($voucher as $row)
				{
					$data2[$row['vt_id']] = $row['vt_balance_coupons'];
				}
				$data2[$data['tournament_prize_1'][0]] = $data2[$data['tournament_prize_1'][0]] -1;
				$data2[$data['tournament_prize_2'][0]] = $data2[$data['tournament_prize_2'][0]] -1; 
				$data2[$data['tournament_prize_3'][0]] = $data2[$data['tournament_prize_3'][0]] -1;
				$data2[$data['tournament_prize_4'][0]] = $data2[$data['tournament_prize_4'][0]] -7;
				$data2[$data['tournament_prize_5'][0]] = $data2[$data['tournament_prize_5'][0]] -10;
				
				foreach($data2 as $value)
				{
					if($value<0)
					{
						$this->session->set_flashdata('error','<strong> Error! </strong> Wrong voucher distribution. Please try again');
						redirect("Admin/ManageTournaments");
					}
				}
			}
			*/
			unset($data['banner_location']);
			unset($data['banner_position']);
			$data['tournament_start_date'] = $_POST['tournament_start_date'];
			$data['tournament_end_date'] = $_POST['tournament_end_date'];
			$data['country']=$this->input->post('country');
			$tournament_game_id = $_POST['tournament_game_id'];
		
			$gameInfo = $this->ADMINDBAPI->getGamesInfo($tournament_game_id);
			
			$tournament_category_id = $_POST['tournament_category_id'];
			$categoryInfo = $this->ADMINDBAPI->getCategoriesInfo($tournament_category_id);
			$data['tournament_category'] = $categoryInfo['category_name'];
			
			$data['tournament_game_id'] = $gameInfo['gid'];
			$data['tournament_gameboost_id'] = $gameInfo['id'];
			$data['tournament_game_name'] = $gameInfo['Name'];
			$data['tournament_game_image'] = $gameInfo['GameImage'];
			$data['tournament_status'] = '1';
			$data['tournament_added_on'] = time();
			$data['tournament_updated_on'] = time();
			
			/* echo "<pre>";
			print_r($data);
			echo "</pre>";
			
			die; */
			
			$result  =		$this->ADMINDBAPI->addNewTournaments($data);
			if($result){
				$tournament_id=$result;
				if(!empty($_FILES['banner_image_path']['name'])){
					
					$dataBanner = array();
					$dataBanner['banner_tournament_id'] = $tournament_id;		
					$dataBanner['banner_position'] = $_POST['banner_position'];		
					$dataBanner['banner_location'] = $_POST['banner_location'];		
					$dataBanner['banner_added_on'] = time();
					$dataBanner['banner_updated_on'] = time();
					$dataBanner['uploaded']		=		'1';
					
					$filename = $_FILES["banner_image_path"]["name"];
					$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
					$file_ext = substr($filename, strripos($filename, '.')); // get file name
						
					//$newfilename = md5($file_basename).'_'.time().'_ITR_'. $file_ext;
					$newfilename = md5($file_basename).'-'.time(). $file_ext;
				
					if(move_uploaded_file($_FILES["banner_image_path"]["tmp_name"], "uploads/tournaments-banners/".$newfilename))
						$dataBanner['banner_image_path']	= $newfilename; 
				
					//Add the banner info in db
					$this->db->insert('tournament_banners', $dataBanner);
					
				}
				if(empty($_FILES['banner_image_path']['name']))
				{
					$dataBanner = array();
					$dataBanner['banner_tournament_id'] = $tournament_id;		
					$dataBanner['banner_position'] = $_POST['banner_position'];		
					$dataBanner['banner_location'] = $_POST['banner_location'];		
					$dataBanner['banner_added_on'] = time();
					$dataBanner['banner_updated_on'] = time();
					$dataBanner['uploaded']		=		'0';
					$dataBanner['banner_image_path']	=	$gameInfo['GameImage'];
					$this->db->insert('tournament_banners', $dataBanner);
				}
				
				$this->session->set_flashdata('success','<strong> Success! </strong> Tournament information added successfully. ');
				redirect("Admin/ManageTournaments");
				
			} else {
				$this->session->set_flashdata('error','<strong> Error! </strong> Unable to update tournament information. Please try again.');
				redirect("Admin/ManageTournaments");
			}				
						
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Account.');
			redirect('Admin');			
		}
	}
	
	

	public function editTournaments($tid){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($tid);
			$data['tournamentInfo'] = $this->ADMINDBAPI->getTournamentInfo($id);
			$data['rewardInfo']	=	$this->ADMINDBAPI->getRewardInfo($id);
			$data['bannerInfo'] = $this->ADMINDBAPI->getTournamentBannerInfoByTid($id);
			$data['country']	=	$this->ADMINDBAPI->getActiveCountryList();
			//$data['voucherlist']	=	$this->ADMINDBAPI->getVouchersList();
			// $data['']
			$prizelist = $this->ADMINDBAPI->getRewardInfo($id);
         //print_r($prizelist);
			
         	switch($data['tournamentInfo']['tournament_section']){
         		case '1':
					$data['voucherlistFree_day'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((10-10), $prizelist[0]['fee_tournament_prize_1'], $id);
         			break;
         
         		case '2': 
					$data['voucherListFirstPrize'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((1-1), $prizelist[0]['fee_tournament_prize_1'], $id);
					$data['voucherListsecondPrize'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((1-1), $prizelist[0]['fee_tournament_prize_2'], $id);
					$data['voucherlistthirdPrize'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((1-1), $prizelist[0]['fee_tournament_prize_3'], $id);
					$data['voucherlistfourthPrize'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((7-7), $prizelist[0]['fee_tournament_prize_4'], $id);
					$data['voucherlistfifthPrize'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((40-40), $prizelist[0]['fee_tournament_prize_5'], $id);
         			break;
         		case '3':
                    $data['voucherListFirstPrize'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((1-1), $prizelist[0]['fee_tournament_prize_1'], $id);
					$data['voucherListsecondPrize'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((1-1), $prizelist[0]['fee_tournament_prize_2'], $id);
					$data['voucherlistthirdPrize'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((1-1), $prizelist[0]['fee_tournament_prize_3'], $id);
					$data['voucherlistfourthPrize'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((7-7), $prizelist[0]['fee_tournament_prize_4'], $id);
					$data['voucherlistfifthPrize'] = $this->ADMINDBAPI->getvoucherSectionsByCountEdit((10-10), $prizelist[0]['fee_tournament_prize_5'], $id);
         			break;
         	}
         	
			//$data['vouchertypelist']	=	$this->ADMINDBAPI->GetVoucherTypeSections(); 
			$category = $data['tournamentInfo']['tournament_category_id'];
			$data['categories'] = $this->ADMINDBAPI->getCategoriesList();
			$data['games'] = $this->ADMINDBAPI->getCategoryGamesList($category);
			$data['voucher'] = $this->ADMINDBAPI->getVoucher();
			$data['tournament_id'] = $tid;
			
			/* echo "<pre>";
			print_r($data);
			echo "</pre>";
			die;
			 */
			
			$this->load->view('admin/tournament_edit', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function processEditTournament($id){
		if($this->session->userdata('admin_logged_in')){
			//print_r($_POST);
			$tournament_id = base64_decode($id);
			if(!empty($_POST['tournament_reward_type'][0])){
                foreach($_POST as $key=>$val){
					if($val!=''){
						if(is_array($val)){
		                    if(!empty($val)){
						       foreach($val as $value){
							       if($value!=''){
								      $data[$key] = (array)$value;
								      break;
							        }else{
								      $data[$key] = (array)"";
							        }			
						        }
					        }else{
						       $data[$key] = (array)"";
					        }
						}else{
		                  $data[$key] = $val;
						}	
					}
		        }
			}else{
				foreach($_POST as $key=>$val){
				
					$data[$key] = $val;
				
				}
	    	}
			unset($data['banner_location']);
			unset($data['banner_position']);
			
			
			$data['tournament_start_date'] = date('Y-m-d', strtotime($_POST['tournament_start_date']));
			$data['tournament_end_date'] = date('Y-m-d', strtotime($_POST['tournament_end_date']));
			
			$data['tournament_name'] = addslashes(urlencode($_POST['tournament_name']));
			$data['tournament_desc'] = addslashes(urlencode($_POST['tournament_desc']));
			
			$tournament_game_id = $_POST['tournament_game_id'];
			
			$gameInfo = $this->ADMINDBAPI->getGamesInfo($tournament_game_id);
			
			$tournament_category_id = $_POST['tournament_category_id'];
			$categoryInfo = $this->ADMINDBAPI->getCategoriesInfo($tournament_category_id);
			$data['tournament_category'] = $categoryInfo['category_name'];
			
			$data['tournament_game_id'] = $gameInfo['gid'];
			$data['tournament_gameboost_id'] = $gameInfo['id'];
			$data['tournament_game_name'] = $gameInfo['Name'];
			$data['tournament_game_image'] = $gameInfo['GameImage'];
			$data['tournament_updated_on'] = time();
			/*	
				echo "<pre>";
				print_r($data);
				echo "</pre>";
				die;
			*/
			$tournament_section = $this->ADMINDBAPI->getTournamentSection($tournament_id);
			$result = $this->ADMINDBAPI->getTournamentVoucherDetails($tournament_id);
			if($data['tournament_reward_type'][0]==1)
			{	
				foreach($result as $row)
				{
					$result2 = $this->ADMINDBAPI->getVoucher();
					foreach($result2 as $value)
					{
						if($value['vt_id']== $row['vt_id'])
						{
							$value['vt_assign_coupons'] = $value['vt_assign_coupons'] -1;
							$value['vt_balance_coupons'] = $value['vt_balance_coupons'] +1;
							unset($value['vt_id']);
							$this->db->where('vt_id' , $row['vt_id']);
							$this->db->update('tbl_voucher_type' , $value);			// Update Total Voucher One by one
						}
					}

					$voucher['voucher_status'] = 0;
					$this->db->where('voucher_id' , $row['voucher_id']);
					$this->db->update('tbl_voucher_detail' , $voucher);			// Free All voucher

					$this->db->where('tv_id' , $row['tv_id']);
					$this->db->delete('tbl_tournament_voucher_detail');			// Delete Tournament Voucher Details
				}
			}
			// else if($result)
			// {

			// }
			// else 
			// {

			// }
			// $result = $this->ADMINDBAPI->getTournamentVoucherDetails($tournament_id);
			// echo "<pre>";
			// print_r($data);
			// die();
			// foreach($data['abc'] as $key=>$value)
			// {
			// 	$data2['vt_balance_coupons']=$value;
			// 	$id=str_replace("voucher_","",$key);
			// 	$this->db->where('vt_id', $id);
			// 	$this->db->update('tbl_voucher_type' , $data2);
			// }
			
			if($data['country'])
			{
				$result		=		$this->ADMINDBAPI->updateTournamentInfo($tournament_id, $data , $tournament_section);
			}
			else{
				$this->db->where('tournament_id', $tournament_id);
				$result=	$this->db->update('tournaments', $data);
			}
			if($result){
				
				if(!empty($_FILES['banner_image_path']['name'])){
					
					$dataBanner = array();
					$dataBanner['banner_tournament_id'] = $tournament_id;		
					$dataBanner['banner_position'] = $_POST['banner_position'];		
					$dataBanner['banner_location'] = $_POST['banner_location'];		
					$dataBanner['banner_added_on'] = time();
					$dataBanner['banner_updated_on'] = time();
					$dataBanner['uploaded']		=		'1';
				
					
					$filename = $_FILES["banner_image_path"]["name"];
					$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
					$file_ext = substr($filename, strripos($filename, '.')); // get file name
						
					//$newfilename = md5($file_basename).'_'.time().'_ITR_'. $file_ext;
					$newfilename = md5($file_basename).'-'.time(). $file_ext;
				
					if(move_uploaded_file($_FILES["banner_image_path"]["tmp_name"], "uploads/tournaments-banners/".$newfilename))
						$dataBanner['banner_image_path']	= $newfilename; 
				
				
					// remove the previous uploaded banner 
					$this->db->where('banner_tournament_id', $tournament_id);
					$this->db->delete('tournament_banners');
					
					//update the banner info in db
					$this->db->insert('tournament_banners', $dataBanner);
				
				}
				if(empty($_FILES['banner_image_path']['name']))
				{
					$this->db->where('banner_tournament_id', $tournament_id);
					$this->db->delete('tournament_banners');
					$dataBanner = array();
					$dataBanner['banner_tournament_id'] = $tournament_id;		
					$dataBanner['banner_position'] = $_POST['banner_position'];		
					$dataBanner['banner_location'] = $_POST['banner_location'];		
					$dataBanner['banner_added_on'] = time();
					$dataBanner['banner_updated_on'] = time();
					$dataBanner['uploaded']		=		'0';
					$dataBanner['banner_image_path']	=	$gameInfo['GameImage'];
					$this->db->insert('tournament_banners', $dataBanner);
				}
				$this->session->set_flashdata('success','<strong> Success! </strong> Tournament information updated successfully. ');
				redirect("Admin/ManageTournaments");
				
			} else {
				$this->session->set_flashdata('error','<strong> Error! </strong> Unable to update tournament information. Please try again.');
				redirect("Admin/ManageTournaments");
			}				
						
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Account.');
			redirect('Admin');			
		}
	}
	
	
	public function deleteTournaments($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$tournamentInfo = $this->ADMINDBAPI->getTournamentInfo($id);
			$tournament_start_date = strtotime($tournamentInfo['tournament_start_date'].' '.$tournamentInfo['tournament_start_time']);
			$tournament_end_date = strtotime($tournamentInfo['tournament_end_date'].' '.$tournamentInfo['tournament_end_time']);
			$today = strtotime(date('Y-m-d H:i')); 
			
			if($tournament_start_date > $today){
				
				// finally remove tournament
				$this->db->where('tournament_id', $id);
				if($this->db->delete('tournaments')){
					
					//remove rewards
					$this->db->where('fee_turnament_id', $id);
					$this->db->delete('tournaments_fee_rewards');
					
					//remove rewards
					$this->db->where('banner_tournament_id', $id);
					$this->db->delete('tournament_banners');
					
					//get the rewards vouchers and reissue them
					$assignedVouchers = $this->db->select('*')->from('tournament_voucher_detail')->where('tv_tournament_id', $id)->get()->result_array(); 
					if(is_array($assignedVouchers) && count($assignedVouchers)>0){
						foreach($assignedVouchers as $vRow){
							$this->db->set('voucher_status', '0', false);  // 0=NotAssigned 1=Assigned-Tournament 2=Assigned-User 3=Claimed 4=Expired   5=Deactivated
							$this->db->where('voucher_id', $vRow['tv_voucher_id']);
							$this->db->update('voucher_detail');
							
							// deduct coupon from the voucher type and update balance
							$getVoucherTypes = $this->db->select('voucher_type_id')->from('voucher_detail')->where('voucher_id', $vRow['tv_voucher_id'])->get()->row_array(); 
						
							$voucherType = $this->ADMINDBAPI->getVoucherTypes($getVoucherTypes['voucher_type_id']);
							
							$vtAssignCoupons = $voucherType[0]['vt_assign_coupons'];
							$vtBalanceCoupons = $voucherType[0]['vt_balance_coupons'];
							
							$updateCoupon['vt_assign_coupons'] = ($vtAssignCoupons-1);
							$updateCoupon['vt_balance_coupons'] = ($vtBalanceCoupons+1);
							$this->db->where('vt_id', $voucherType[0]['vt_id']);
							$this->db->update('voucher_type', $updateCoupon);
							
							// finally update logs
							$logs['log_voucher_id'] =  $vRow['tv_voucher_id'];
							$logs['log_tournament_id'] = $id;
							$logs['log_voucher_status'] = '8';
							$logs['log_message'] = 'removed_from_tournament_and_recreated';
							$logs['log_date_time'] = date('Y-m-d H:i:s');
							$logs['log_added_on'] = time();
							$this->db->insert('voucher_logs', $logs);
						}
						
						//finally remove the voucher from tournament
						$this->db->where(array('tv_tournament_id'=>$id));
						$this->db->delete('tournament_voucher_detail');
					}
					
					
					$this->session->set_flashdata('success','<strong> Success! </strong> Tournament information deleted successfully. ');
					redirect("Admin/ManageTournaments");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to delete tournament information. Please try again.');
					redirect("Admin/ManageTournaments");
				}
				
				
			
			} else if($tournament_start_date < $today  && $tournament_end_date > $today ){
				$this->session->set_flashdata('error',"<strong> Sorry! </strong>  You can't delete this tournament information. This tournament is in live mode.");
				redirect("Admin/ManageTournaments");
			
			} else {
				$this->session->set_flashdata('error',"<strong> Sorry! </strong> You can't delete this tournament information. This tournament is already expired.");
				redirect("Admin/ManageTournaments");
			}
		
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	
// 	public function trucateData(){
// 		if($this->session->userdata('admin_logged_in')){
			
// 			$this->db->truncate('tbl_tournaments');
// 			$this->db->truncate('tbl_tournaments_fee_rewards');
// 			$this->db->truncate('tbl_tournaments_fee_vouchers');
// 			$this->db->truncate('tbl_tournaments_players');
// 			$this->db->truncate('tbl_tournaments_results');
// 			$this->db->truncate('tbl_tournament_banners');
// 			$this->db->truncate('tbl_tournament_voucher_detail');
// 			$this->db->truncate('tbl_voucher_detail');
// 			$this->db->truncate('tbl_voucher_logs');
			
// 			$this->db->query('UPDATE `tbl_voucher_type` SET 
// `vt_total_coupons`=0,
// `vt_assign_coupons`=0,
// `vt_expired_coupons`=0,
// `vt_balance_coupons`=0
// ');
			
			
// 			$this->session->set_flashdata('success','<strong> Success! </strong> Data Truncated. ');
// 			redirect("Admin/ManageTournaments");
			
// 		} else{
// 			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
// 			redirect('Admin');
// 		}
// 	}
	
	public function trucateData(){
		if($this->session->userdata('admin_logged_in')){
			
			$this->db->truncate('tbl_tournaments');
			$this->db->truncate('tbl_tournaments_fee_rewards');
			$this->db->truncate('tbl_tournaments_fee_vouchers');
			$this->db->truncate('tbl_tournaments_players');
			$this->db->truncate('tbl_tournaments_results');
			$this->db->truncate('tbl_tournament_banners');
			$this->db->truncate('tbl_tournament_voucher_detail');
			$this->db->truncate('tbl_voucher_detail');
			$this->db->truncate('tbl_voucher_logs');
			
			$this->db->query('UPDATE `tbl_voucher_type` SET 
			`vt_total_coupons`=0,
			`vt_assign_coupons`=0,
			`vt_expired_coupons`=0,
			`vt_claimed_coupons`=0,
			`vt_balance_coupons`=0
			');
						
			
			$this->session->set_flashdata('success','<strong> Success! </strong> Data Truncated. ');
			redirect("Admin/ManageTournaments");
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function tournamentBannersList(){
		if($this->session->userdata('admin_logged_in')){
			$data['list'] = $this->ADMINDBAPI->getTournamentsBannersList();
			$this->load->view('admin/tournament_banners_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
		
	public function uploadTournamentBanner(){
		if($this->session->userdata('admin_logged_in')){
			$data['tournaments'] = $this->ADMINDBAPI->getTournamentsList();			
			$this->load->view('admin/tournament_banner_upload', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
		
	public function processTournamentBanner(){
		if($this->session->userdata('admin_logged_in')){
			
			if(!empty($_FILES['banner_image_path']['name'])){
				
				$data = array();
				foreach($_POST as $key=>$val){
					$data[$key] = $val;
				}				
				$filename = $_FILES["banner_image_path"]["name"];
				$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
				$file_ext = substr($filename, strripos($filename, '.')); // get file name
					
				//$newfilename = md5($file_basename).'_'.time().'_ITR_'. $file_ext;
				$newfilename = md5($file_basename).'-'.time(). $file_ext;
			
				if(move_uploaded_file($_FILES["banner_image_path"]["tmp_name"], "uploads/tournaments-banners/".$newfilename))
					$data['banner_image_path']	= $newfilename; 
			
			
				$data['banner_added_on'] = time();
				$data['banner_updated_on'] = time();
				
				if($this->db->insert('tournament_banners', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Tournament banner information added successfully. ');
					redirect("Admin/TournamentBanners");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to add tournament banner information. Please try again.');
					redirect("Admin/UploadTournamentBanner");
				}
			} else {
				$this->session->set_flashdata('error',"<strong> Error! </strong> Required parameters are missing for uploading a new banner.Please add all mandatory fields.");
				redirect("Admin/UploadTournamentBanner");
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	
	public function editTournamentBanner($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$data['bannerInfo'] = $this->ADMINDBAPI->getTournamentBannerInfo($id);
			$data['tournaments'] = $this->ADMINDBAPI->getTournamentsList();	
			$data['banner_id'] = base64_encode($id);
			
			$this->load->view('admin/tournament_banner_edit', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function processEditTournamentBanner($id){
		if($this->session->userdata('admin_logged_in')){
			
			$banner_id = base64_decode($id);
			foreach($_POST as $key=>$val){
				$data[$key] = $val;
			}	
			
			if(!empty($_FILES['banner_image_path']['name'])){
							
				$filename = $_FILES["banner_image_path"]["name"];
				$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
				$file_ext = substr($filename, strripos($filename, '.')); // get file name
					
				//$newfilename = md5($file_basename).'_'.time().'_ITR_'. $file_ext;
				$newfilename = md5($file_basename).'-'.time(). $file_ext;
			
				if(move_uploaded_file($_FILES["banner_image_path"]["tmp_name"], "uploads/tournaments-banners/".$newfilename))
					$data['banner_image_path']	= $newfilename; 
			}
			
			$data['banner_updated_on'] = time();
			$this->db->where('banner_id', $banner_id);
			if($this->db->update('tournament_banners', $data)){
				$this->session->set_flashdata('success','<strong> Success! </strong> Tournament Banner information updated successfully. ');
				redirect("Admin/TournamentBanners");
				
			} else {
				$this->session->set_flashdata('error','<strong> Error! </strong> Unable to update tournament banner information. Please try again.');
				redirect("Admin/TournamentBanners");
			}				
						
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Account.');
			redirect('Admin');			
		}
	}
	
	public function deleteTournamentBanner($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			
			// finally remove tournament banner
			$this->db->where('banner_id', $id);
			if($this->db->delete('tournament_banners')){
				$this->session->set_flashdata('success','<strong> Success! </strong> Tournament banner information deleted successfully. ');
				redirect("Admin/TournamentBanners");
			} else {
				$this->session->set_flashdata('error','<strong> Error! </strong> Unable to delete tournament banner information. Please try again.');
				redirect("Admin/TournamentBanners");
			}
			
			
		
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function getQuickTournaments(){
		if($this->session->userdata('admin_logged_in')){
		
			$data['publishedGames'] = $this->ADMINDBAPI->getPublishedGamesList();
			$data['list'] = $this->ADMINDBAPI->getQuickTournamnetGamesList();
			$this->load->view('admin/quick_tournaments_list', $data);
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Account.');
			redirect('Admin');			
		}
	}
	
	public function saveQuickTournamentGame(){
		if($this->session->userdata('admin_logged_in')){
			
			$gid = $_POST['game_id'];
			$gameInfo = $this->ADMINDBAPI->getGamesInfo($gid);
			
			$checkGameInfo = $this->ADMINDBAPI->checkQuickTournamnetGame($gid, $gameInfo['id']);
			
			if($checkGameInfo['no_rows'] == 0){
				$data['quick_gid'] = $gid;
				$data['quick_gameboost_id'] = $gameInfo['id'];
				$data['quick_added_on'] = time();
				
				$this->db->insert('quick_tournaments', $data);
				
				$this->session->set_flashdata('success','<strong> Success! </strong> Game added to quick tournaments section successfully.');
				redirect('Admin/QuickTournaments');
			
			} else {
				$this->session->set_flashdata('error','<strong> Error! </strong> Game already added in quick tournaments section. Please add another game.');
				redirect('Admin/QuickTournaments');
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function removeQuickTournamentGame($id){
		if($this->session->userdata('admin_logged_in')){
			
			$id = base64_decode($id);
			$checkGamesCount = $this->ADMINDBAPI->getQuickTournamnetGameRows();
			if($checkGamesCount['no_rows'] > 3){
				
				$this->db->where('quick_tid', $id);
				$this->db->delete('quick_tournaments');
				$this->session->set_flashdata('success','<strong> Success! </strong> Game removed from quick tournaments section successfully.');
				redirect('Admin/QuickTournaments');
			
			} else {
				$this->session->set_flashdata('error',"<strong> Error! </strong> You can't delete the row. Minimum three games are required for quick tournaments section.");
				redirect('Admin/QuickTournaments');
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function processBulkTournaments(){
		if($this->session->userdata('admin_logged_in')){
			
			if($_FILES['userfile']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['userfile']['type'] == 'application/vnd.ms-excel'){
		
				$file_name='';
				$config['upload_path'] = './uploads/tournaments-excel/';
				$config['allowed_types'] = 'xls|xlsx';
				$config['file_name'] = time();
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload()){
					echo $this->upload->display_errors();
				}else {
					$data2 = $this->upload->data();
					$file_name = $data2['file_name'];			
				}	 
				
				
				// $tournament_section = $_POST['tournament_section'];
				
				$this->load->library("PHPExcel"); 
				$objReader = PHPExcel_IOFactory::createReaderForFile("./uploads/tournaments-excel/".$file_name);
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load("uploads/tournaments-excel/".$file_name);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);  
				$objWorksheet1 = $objPHPExcel->getActiveSheet();
				$lastRow      = $objWorksheet1->getHighestRow(2);  
			
				$insertArrayValues = array();
			  
				for($i=2; $i<=$lastRow; $i++){
					
					$dataUpload = array();
					
					$sno = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
					$tournament_name = $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
					$tournament_desc = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
					$tournament_type = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
					$duration = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
					$category = $objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
					$game = $objWorksheet->getCellByColumnAndRow(6,$i)->getValue();
					$operator = $objWorksheet->getCellByColumnAndRow(7,$i)->getValue();
					$tournament_fee = $objWorksheet->getCellByColumnAndRow(8,$i)->getValue();
					$tournament_prize_1 = $objWorksheet->getCellByColumnAndRow(9,$i)->getValue();
					$tournament_prize_2 = $objWorksheet->getCellByColumnAndRow(10,$i)->getValue();
					$tournament_prize_3 = $objWorksheet->getCellByColumnAndRow(11,$i)->getValue();
					
					$start_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(12,$i)->getValue()));
					$start_time = $objWorksheet->getCellByColumnAndRow(13,$i)->getFormattedValue();
					$start_time_field = PHPExcel_Shared_Date::ExcelToPHP($start_time);
					$start_time = gmdate("H:i", $start_time_field);
					
					$end_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(14,$i)->getValue()));
					$end_time = $objWorksheet->getCellByColumnAndRow(15,$i)->getFormattedValue();
					$end_time_field = PHPExcel_Shared_Date::ExcelToPHP($end_time);
					$end_time = gmdate("H:i", $end_time_field);
					
					$reward_type = $objWorksheet->getCellByColumnAndRow(16,$i)->getValue();
					$tournament_prize_4 = $objWorksheet->getCellByColumnAndRow(17,$i)->getValue();
					$tournament_prize_5 = $objWorksheet->getCellByColumnAndRow(18,$i)->getValue();
					$tournament_prize_6 = $objWorksheet->getCellByColumnAndRow(19,$i)->getValue();
					$tournament_prize_7 = $objWorksheet->getCellByColumnAndRow(20,$i)->getValue();
					$tournament_prize_8 = $objWorksheet->getCellByColumnAndRow(21,$i)->getValue();
					$tournament_section = $objWorksheet->getCellByColumnAndRow(22,$i)->getValue();
					
					$dataUpload['tournament_name'] = addslashes(urlencode($tournament_name));
					$dataUpload['tournament_desc'] = addslashes(urlencode($tournament_desc));
					
					
					if($tournament_type == 'Free' || $tournament_type == 'free')
						$dataUpload['tournament_type'] = '1';
					else if($tournament_type == 'Paid' || $tournament_type == 'paid')
						$dataUpload['tournament_type'] = '2';
					else if($tournament_type == 'Contest' || $tournament_type == 'contest')
						$dataUpload['tournament_type'] = '3';
					else 
						$dataUpload['tournament_type'] = '1';
						
					$categoryInfo = $this->ADMINDBAPI->getCategoriesInfoByName($category);
					$dataUpload['tournament_category_id'] = $categoryInfo['category_id'];
					$dataUpload['tournament_category'] = $categoryInfo['category_name'];
					
					$gameInfo = $this->ADMINDBAPI->getGameInfoByName($game);	
					$dataUpload['tournament_game_id'] = $gameInfo['gid'];
					$dataUpload['tournament_gameboost_id'] = $gameInfo['id'];
					$dataUpload['tournament_game_name'] = $gameInfo['Name'];
					$dataUpload['tournament_game_image'] = $gameInfo['GameImage'];
					
					
					if($reward_type == 'Coins' || $reward_type == 'coins')
						$dataUpload['tournament_reward_type'] = '1';
					else if($reward_type == 'DataPack' || $reward_type == 'datapack' || $reward_type == 'data_pack' || $reward_type == 'data-pack' || $reward_type == 'data pack' || $reward_type == 'Data Pack')
						$dataUpload['tournament_reward_type'] = '2';
					else if($reward_type == 'Talktime' || $reward_type == 'talktime' || $reward_type == 'TalkTime' || $reward_type == 'Talk Time' || $reward_type == 'talk time' || $reward_type == 'talk-time' || $reward_type == 'talk_time')
						$dataUpload['tournament_reward_type'] = '3';
					else 
						$dataUpload['tournament_reward_type'] = '1';
					
					$dataUpload['tournament_fee'] = $tournament_fee;
					$dataUpload['tournament_prize_1'] = $tournament_prize_1;
					$dataUpload['tournament_prize_2'] = $tournament_prize_2;
					$dataUpload['tournament_prize_3'] = $tournament_prize_3;
					$dataUpload['tournament_prize_4'] = $tournament_prize_4;
					$dataUpload['tournament_prize_5'] = $tournament_prize_5;
					$dataUpload['tournament_prize_6'] = $tournament_prize_6;
					$dataUpload['tournament_prize_7'] = $tournament_prize_7;
					$dataUpload['tournament_prize_8'] = $tournament_prize_8;
					
					$dataUpload['tournament_start_date'] = $start_date;
					$dataUpload['tournament_start_time'] = $start_time;
					$dataUpload['tournament_end_date'] = $end_date;
					$dataUpload['tournament_end_time'] = $end_time;
					$dataUpload['tournament_added_on'] = time();
					$dataUpload['tournament_updated_on'] = time();
					
					if($tournament_section == 'Hero' || $tournament_section == 'hero')
						$dataUpload['tournament_section'] = '1';
					else 
						$dataUpload['tournament_section'] = '2';
					
					
					
					$insertArrayValues[] = $dataUpload;
					
				}
				
				/*
				echo "<pre>";
				print_r($insertArrayValues);
				echo "</pre>";
				*/
				
				if(is_array($insertArrayValues) && count($insertArrayValues)>0){
					
					$this->db->insert_batch('tournaments', $insertArrayValues);
					$this->session->set_flashdata('success',  '<strong> Success! </strong> Tournaments excelsheet uploaded successfully. Please add the banners in respective list.');
					redirect('Admin/ManageTournaments');
				
				} else {
					$this->session->set_flashdata('error',  '<strong> Error! </strong> No rows found in excelsheet. Please upload correct excelsheet file.');
					redirect('Admin/ManageTournaments');
				}
				
			} else {
				$this->session->set_flashdata('error',  '<strong> Error! </strong> Upload file format is not acceptable. Upload only .xls or .xlsx file.');
				redirect('Admin/ManageTournaments');
			} 
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Tournament Section Ends **************************************//
	//  **************************************   ***************************** **************************************//
	
	
	
		
	public function getPrivateTournamentGames(){
		if($this->session->userdata('admin_logged_in')){
			
			$data['gameslist'] = $this->ADMINDBAPI->getPublishedGamesList();
			$data['list'] = $this->ADMINDBAPI->getPTGamesList();
			$this->load->view('admin/private_tournament_games', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
		
	public function savePrivateTournamentGame(){
		if($this->session->userdata('admin_logged_in')){
			$id = $_POST['game_id'];
			$update['private_tournament'] = '1';
			$this->db->where('gid', $id);
			$this->db->update('games', $update);
			$this->session->set_flashdata('success','<strong> Success! </strong> Game added to private tournaments section successfully.');
			redirect('Admin/PrivateTournamentGames');
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	public function removePrivateTournamentGames($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$update['private_tournament'] = '0';
			$this->db->where('gid', $id);
			$this->db->update('games', $update);
			$this->session->set_flashdata('success','<strong> Success! </strong> Game removed from private tournaments section successfully.');
			redirect('Admin/PrivateTournamentGames');
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
		
	public function getSuggestedGames(){
		if($this->session->userdata('admin_logged_in')){
			
			$data['gameslist'] = $this->ADMINDBAPI->getPublishedGamesList();
			$data['list'] = $this->ADMINDBAPI->getSuggestedGamesList();
			$this->load->view('admin/suggested_games_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
		
	public function saveSuggestedGame(){
		if($this->session->userdata('admin_logged_in')){
			$id = $_POST['game_id'];
			$update['IsSuggested'] = '1';
			$this->db->where('gid', $id);
			$this->db->update('games', $update);
			$this->session->set_flashdata('success','<strong> Success! </strong> Game added to suggested section successfully.');
			redirect('Admin/SuggestedGames');
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	public function removeSuggestedGame($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$update['IsSuggested'] = '0';
			$this->db->where('gid', $id);
			$this->db->update('games', $update);
			$this->session->set_flashdata('success','<strong> Success! </strong> Game removed from suggested section successfully.');
			redirect('Admin/SuggestedGames');
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function getTopGames(){
		if($this->session->userdata('admin_logged_in')){			
			$data['gameslist'] = $this->ADMINDBAPI->getPublishedGamesList();
			$data['list'] = $this->ADMINDBAPI->getTopGamesList();
			$this->load->view('admin/top_games_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function saveTopGame(){
		if($this->session->userdata('admin_logged_in')){
			$id = $_POST['game_id'];
			$update['IsTop'] = '1';
			$this->db->where('gid', $id);
			$this->db->update('games', $update);
			$this->session->set_flashdata('success','<strong> Success! </strong> Game added to top trending games section successfully.');
			redirect('Admin/TopGames');
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	public function removeTopGame($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$update['IsTop'] = '0';
			$this->db->where('gid', $id);
			$this->db->update('games', $update);
			$this->session->set_flashdata('success','<strong> Success! </strong> Game removed from top trending games section successfully.');
			redirect('Admin/TopGames');
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
		
	public function getGenreGames($type){
		if($this->session->userdata('admin_logged_in')){
			
			$data['list'] = $this->ADMINDBAPI->getGenreGamesList($type);			
			$data['gameslist'] = $this->ADMINDBAPI->getPublishedGamesList();
			$data['type'] = $type;				
			$this->load->view('admin/genre_games_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Spin Wheel Section Starts Here **************************************//
	//  **************************************   ***************************** **************************************//
	
	public function getVoucherTypes(){
		if($this->session->userdata('admin_logged_in')){
			$data['list'] = $this->ADMINDBAPI->getVoucherTypes();
			$this->load->view('admin/voucher_type_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	public function processVoucherType(){
		if($this->session->userdata('admin_logged_in')){
			if (isset($_POST['vt_id'])) {
				$id = base64_decode(@$_POST['vt_id']);
			}
			if(!empty($id)){
				$data['vt_type'] = $_POST['vt_type'];
				
				$this->db->where('vt_id', $id);				
				if($this->db->update('voucher_type', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Section information updated successfully. ');
					redirect("Admin/VoucherType");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to update section information. Please try again.');
					redirect("Admin/VoucherType");
				}				
			} else {
			
				$data['vt_type'] = $_POST['vt_type'];
				$data['vt_date_time'] = date('Y-m-d H:i:s');
				$data['vt_added_on'] = time();
				$data['vt_updated_on'] = time();
				$data['vt_status']= '1';

				if($this->db->insert('voucher_type', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Section information added successfully. ');
					redirect("Admin/VoucherType");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to add new section information. Please try again.');
					redirect("Admin/VoucherType");
				}
			}
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	public function removeVoucherType($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$data['vt_status'] = 0;
			// First check if the total segements count is less than 3 , then stop the user to delete the section
			$this->db->where('vt_id', $id);				
				if($this->db->update('voucher_type', $data)){
				$this->session->set_flashdata('success','<strong> Success! </strong> Section information removed successfully.');
				redirect('Admin/VoucherType');
			} else {
				$this->session->set_flashdata('success','<strong> Success! </strong> Section information not removed.');
				redirect('Admin/VoucherType');
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	
	public function getVouchersList(){
		if($this->session->userdata('admin_logged_in')){
			$data['list'] = $this->ADMINDBAPI->getVouchersList();
			$data['voucherTypes'] = $this->ADMINDBAPI->getVoucherTypes();
			$data['new_voucher_start'] = date('Y-m-d');
			$data['new_voucher_ends'] = date('Y-m-d', strtotime('+1 year'));
			$this->load->view('admin/voucher_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	
	public function processVoucher(){
		if($this->session->userdata('admin_logged_in')){
			
			if (isset($_POST['voucher_id'])) {
				$id = base64_decode(@$_POST['voucher_id']);
			}
			
			$getVoucherType =  $this->ADMINDBAPI->getVoucherTypes($_POST['voucher_type_id']);
			$vtTotalCoupons = $getVoucherType[0]['vt_total_coupons'];
			$vtBalanceCoupons = $getVoucherType[0]['vt_balance_coupons'];
			
			if (is_array($_POST) && count($_POST)>0) {
				foreach($_POST as $key=>$val){
					$data[$key] = $val;
				}
			}
			$data['voucher_name'] = addslashes(urlencode("BDT ".$getVoucherType['vt_type']." Voucher"));
			$data['voucher_description'] = addslashes(urlencode($_POST['voucher_description']));	
			$data['voucher_date_time'] = date('Y-m-d H:i:s');	
			unset($data['voucher_id']);
			
			
			if(!empty($id)){
				$data['voucher_updated_on'] = time();
				$this->db->where('voucher_id', $id);				
				if($this->db->update('voucher_detail', $data)){
					
					$this->session->set_flashdata('success','<strong> Success! </strong> Voucher information updated successfully. ');
					redirect("Admin/Vouchers");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to update voucher information. Please try again.');
					redirect("Admin/Vouchers");
				}				
			} else {
			
				$data['voucher_added_on'] = time();
				$data['voucher_updated_on'] = time();
				if($this->db->insert('voucher_detail', $data)){
					
					$voucherId = $this->db->insert_id();
					// Update the voucher count in voucher type table
					$updateCoupon['vt_total_coupons'] = ($vtTotalCoupons+1);
					$updateCoupon['vt_balance_coupons'] = ($vtBalanceCoupons+1);
					$this->db->where('vt_id', $_POST['voucher_type_id']);
					$this->db->update('voucher_type', $updateCoupon);
					
					//update voucher logs
					$voucherLog['log_voucher_id'] = $voucherId;
					$voucherLog['log_message'] = 'voucher_created';
					$voucherLog['log_date_time'] = date('Y-m-d H:i:s');	
					$voucherLog['log_added_on'] = time();
					$this->db->insert('voucher_logs', $voucherLog);
					
					
					$this->session->set_flashdata('success','<strong> Success! </strong> Voucher information added successfully. ');
					redirect("Admin/Vouchers");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to add new voucher information. Please try again.');
					redirect("Admin/Vouchers");
				}
				
			}
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}


	public function removeVoucher($id){
	if($this->session->userdata('admin_logged_in')){
		$id = base64_decode($id);
		$voucherInfo = $this->ADMINDBAPI->getVouchersList($id);
		
		if($voucherInfo[0]['voucher_status'] == 0){
			//only delete voucher when it is not assigned to any tournament or user
			$data['voucher_status'] = 5;
			$this->db->where('voucher_id', $id);				
				if($this->db->update('voucher_detail', $data)){
				$this->session->set_flashdata('success','<strong> Success! </strong> Voucher information removed successfully.');
				redirect('Admin/Vouchers');
			} else {
				$this->session->set_flashdata('success','<strong> Success! </strong> Unable to deactivate voucher.');
				redirect('Admin/Vouchers');
			}
		} else {
			$this->session->set_flashdata('success',"<strong> Success! </strong> You can't delete a assigned voucher.");
			redirect('Admin/Vouchers');
		}
	} else{
		$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
		redirect('Admin');
	}
}

	
	public function processBulkVouchers(){
		if($this->session->userdata('admin_logged_in')){
			
			if($_FILES['userfile']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['userfile']['type'] == 'application/vnd.ms-excel'){
		
				$file_name='';
				$config['upload_path'] = './uploads/voucher-excel/';
				$config['allowed_types'] = 'xls|xlsx';
				$config['file_name'] = time();
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload()){
					echo $this->upload->display_errors();
				}else {
					$data2 = $this->upload->data();
					$file_name = $data2['file_name'];			
				}	 
				
				$this->load->library("PHPExcel"); 
				$objReader = PHPExcel_IOFactory::createReaderForFile("./uploads/voucher-excel/".$file_name);
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load("uploads/voucher-excel/".$file_name);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);  
				$objWorksheet1 = $objPHPExcel->getActiveSheet();
				$lastRow      = $objWorksheet1->getHighestRow(2);  
			
				$insertVouchersBatch = array();
			  
				for($i=2; $i<=$lastRow; $i++){
					
					$dataUpload = array();
					$amount = '';
					$coupon_code = '';
					
					$sno = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
					$coupon_code = $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
					$amount = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
					$amount = str_replace(",", "", $amount);
					
					$voucherTypeInfo = $this->ADMINDBAPI->getVoucherTypeByAmount($amount);
					if(!empty($voucherTypeInfo['vt_id'])){
						$voucher_type_id =  $voucherTypeInfo['vt_id'];
						$voucher_name =  addslashes(urlencode("BDT ".$voucherTypeInfo['vt_type']." Voucher"));
					} else {
						$vType['vt_type'] = $amount;
						$vType['vt_date_time'] = date('Y-m-d H:i:s');
						$vType['vt_added_on'] = time();
						$vType['vt_updated_on'] = time();
						$vType['vt_status']= '1';
						$this->db->insert('voucher_type', $vType);
						$vTypeId = $this->db->insert_id();
						
						$voucher_type_id =  $vTypeId;
						$voucher_name =  addslashes(urlencode("BDT ".$amount." Voucher"));
					}
					
					
					$dataUpload['voucher_name'] = $voucher_name;
					$dataUpload['voucher_code'] = $coupon_code;
					$dataUpload['voucher_type_id'] = $voucher_type_id;
					$dataUpload['voucher_date_time'] = date('Y-m-d H:i:s');
					$dataUpload['voucher_status'] = 0;
					$dataUpload['voucher_validity_starts'] = date('Y-m-d');
					$dataUpload['voucher_validity_ends'] = date('Y-m-d', strtotime('+1 year'));
					$dataUpload['voucher_added_on'] = time();
					$dataUpload['voucher_updated_on'] = time();
					$insertVouchersBatch[] = $dataUpload;
					
					if(!empty($dataUpload['voucher_type_id'])){
						// Update the voucher count in voucher type table
						$voucherType = $this->ADMINDBAPI->getVoucherTypes($voucher_type_id);
						$vtTotalCoupons = $voucherType[0]['vt_total_coupons'];
						$vtBalanceCoupons = $voucherType[0]['vt_balance_coupons'];
						$updateCoupon['vt_total_coupons'] = ($vtTotalCoupons+1);
						$updateCoupon['vt_balance_coupons'] = ($vtBalanceCoupons+1);
						$this->db->where('vt_id', $voucher_type_id);
						$this->db->update('voucher_type', $updateCoupon);
					}
					
				}
				
				
				if(is_array($insertVouchersBatch) && count($insertVouchersBatch)>0 ){
					//$this->db->insert_batch('voucher_detail', $insertVouchersBatch);
					//insert_batch doesn't give the correct insert_id if the bulk upload is more that 99 rows. So use insert() to get correct voucher_id for log table
					
					$insertVoucherslogs = array();
					foreach($insertVouchersBatch as $voucherRow){
						$this->db->insert('voucher_detail', $voucherRow);
						$voucherId = $this->db->insert_id();
						//update voucher logs
						if(!empty($voucherId)){
							$voucherLog = array();
							$voucherLog['log_voucher_id'] = $voucherId;
							$voucherLog['log_message'] = 'voucher_created';
							$voucherLog['log_date_time'] = date('Y-m-d H:i:s');	
							$voucherLog['log_added_on'] = time();
							$insertVoucherslogs[] = $voucherLog;
						}
					}
					
					
					if(is_array($insertVoucherslogs) && count($insertVoucherslogs)>0 ){
						$this->db->insert_batch('voucher_logs', $insertVoucherslogs);
					}
					
					$this->session->set_flashdata('success',  '<strong> Success! </strong> Voucher excelsheet uploaded successfully.');
					redirect('Admin/Vouchers');
				
				} else {
					$this->session->set_flashdata('error',  '<strong> Error! </strong> No rows found in excelsheet. Please upload correct excelsheet file.');
					redirect('Admin/Vouchers');
				}
				
			} else {
				$this->session->set_flashdata('error',  '<strong> Error! </strong> Upload file format is not acceptable. Upload only .xls or .xlsx file.');
				redirect('Admin/voucher');
			} 
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	
	
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Spin Wheel Section Starts Here **************************************//
	//  **************************************   ***************************** **************************************//
	
	public function getSpinWheelSections(){
		if($this->session->userdata('admin_logged_in')){
			
			$data['list'] = $this->ADMINDBAPI->getSpinWheelSections();
			$this->load->view('admin/spin_wheel_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	public function processSpinWheel(){
		if($this->session->userdata('admin_logged_in')){
			
			$id = base64_decode(@$_POST['wheel_id']); 
			foreach($_POST as $key=>$val){
				$data[$key] = $val;
			}	
			unset($data['wheel_id']);
			
			
			if($id){
				$data['wheel_updated_on'] = time();
				$this->db->where('wheel_id', $id);				
				if($this->db->update('spinwheel_data', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Section information updated successfully. ');
					redirect("Admin/SpinWheel");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to update section information. Please try again.');
					redirect("Admin/SpinWheel");
				}				
			} else {
				$data['wheel_added_on'] = time();
				$data['wheel_updated_on'] = time();
				
				if($this->db->insert('spinwheel_data', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Section information added successfully. ');
					redirect("Admin/SpinWheel");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to add new section information. Please try again.');
					redirect("Admin/SpinWheel");
				}
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	public function removeWheelSection($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			
			// First check if the total segements count is less than 3 , then stop the user to delete the section
			$countSections = count($this->ADMINDBAPI->getSpinWheelSections());
			$countSections = $countSections-1;
			if($countSections <= 3){
				$this->session->set_flashdata('error',"<strong> Sorry! </strong> You can't delete this section. Minimum 3 sections are required for the Spin & Win.");
				redirect('Admin/SpinWheel');
			} else {
				$this->db->where('wheel_id', $id);
				$this->db->delete('spinwheel_data');
				$this->session->set_flashdata('success','<strong> Success! </strong> Section information removed successfully.');
				redirect('Admin/SpinWheel');
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
		
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Spin Wheel Section Ends Here  **************************************//
	//  **************************************   ***************************** **************************************//
	
	
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Portal Settings Section Starts Here **************************************//
	//  **************************************   ***************************** **************************************//
	
		
	public function getPortalSettings(){
		if($this->session->userdata('admin_logged_in')){
			
			$data['list'] = $this->ADMINDBAPI->getPortalSettings();
			$this->load->view('admin/portal_settings', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	function search_exif($exif, $field){
		foreach ($exif as $data)
		{
			if ($data['name'] == $field)
				return $data['enabled'];
		}
	}
	
	public function processPortalSettings(){
		if($this->session->userdata('admin_logged_in')){
			
			// remove the old settings			
			$this->db->truncate('portal_settings');
			
			// add new updated  settings	
			foreach($_POST as $key=>$val){
				$data['name'] = $key;
				$data['enabled'] = 1;
				$data['last_updated'] = time();
				$this->db->insert('portal_settings', $data);
			}	
				
			$this->session->set_flashdata('success','<strong> Success! </strong> Portal settings updated successfully.');
			redirect("Admin/PortalSettings");
				
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

		
	public function manageRedemption(){
		if($this->session->userdata('admin_logged_in')){
			
			$data['list'] = $this->ADMINDBAPI->getRedemptionsList();
			$this->load->view('admin/redemption_list', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	

	public function saveRedemptionOption(){
		if($this->session->userdata('admin_logged_in')){
			
			$id = base64_decode(@$_POST['redeem_id']); 
			foreach($_POST as $key=>$val){
				$data[$key] = $val;
			}
			if(isset($_POST['redeem_status']))	
				$data['redeem_status'] = '1';
			else 
				$data['redeem_status'] = '0';
			
			unset($data['redeem_id']);
			$data['redeem_updated_on'] = time();
			
			if($id){
				
				$this->db->where('redeem_id', $id);				
				if($this->db->update('redemption_settings', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Redemption option information updated successfully. ');
					redirect("Admin/ManageRedemption");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to update redemption option information. Please try again.');
					redirect("Admin/ManageRedemption");
				}				
			} else {
				
				if($this->db->insert('redemption_settings', $data)){
					$this->session->set_flashdata('success','<strong> Success! </strong> Redemption option information added successfully. ');
					redirect("Admin/ManageRedemption");
				} else {
					$this->session->set_flashdata('error','<strong> Error! </strong> Unable to add new redemption option  information. Please try again.');
					redirect("Admin/ManageRedemption");
				}
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}


	public function removeRedemptionOption($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			
			$this->db->where('redeem_id', $id);
			$this->db->delete('redemption_settings');
			$this->session->set_flashdata('success','<strong> Success! </strong> Redemption option information removed successfully.');
			redirect('Admin/ManageRedemption');
			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Portal Settings Section Ends Here **************************************//
	//  **************************************   ***************************** **************************************//
	
	##################################### Premium Tournament Starts ####################################

	public function getPremiumTournament(){
		if($this->session->userdata('admin_logged_in')){
			
			$list = $this->ADMINDBAPI->getPremiumTournamentList($filter = 'all');
			$tournamentTotalPC = 0;
			
			foreach($list as $k=>$row){
				$reportPlayCounts = $this->db->query("SELECT sum(report_tournament_counts) as total_rows,  sum(report_tournament_practice_counts) as total_practice_rows  
				FROM tbl_report_game_play 
				WHERE report_tournament_id = ".$row['tournament_id']."
				")->row_array(); 
				
				$list[$k]['total_rows'] = $reportPlayCounts['total_rows'];
				$list[$k]['total_practice_rows'] = $reportPlayCounts['total_practice_rows'];
				
				$tournamentTotalPC = $tournamentTotalPC + $reportPlayCounts['total_rows'];
			}
			
			$data['list'] = $list;
			$data['filter'] = 'all';
			$data['tournamentTotalPC'] = $tournamentTotalPC;
			$this->load->view('admin/premium_tournaments_report', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	public function getPremiumTournamentsFilter(){
		if($this->session->userdata('admin_logged_in')){
			
			if(!empty($_POST['search'])){
				
				$tournamentTotalPC = 0;
				$filter = @$_POST['search'];
				
				if($filter == '1'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getPremiumTournamentList($filter = '1');
				
				} else if($filter == '7'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getPremiumTournamentList($filter = '7');
				
				} else if($filter == '15'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getPremiumTournamentList($filter = '15');
					
				} else if($filter == '30'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getPremiumTournamentList($filter = '30');
					
				} else if($filter == 'all'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getPremiumTournamentList($filter = 'all');
					
				} else if($filter == 'month'){
					$stat_month = date('m');
					$stat_year = date('Y');				
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getPremiumTournamentList($filter = 'month', $stat_month, $stat_year);
				}
				
				foreach($list as $k=>$row){
					$reportPlayCounts = $this->db->query("SELECT sum(report_tournament_counts) as total_rows,  sum(report_tournament_practice_counts) as total_practice_rows  
					FROM tbl_report_game_play 
					WHERE report_tournament_id = ".$row['tournament_id']."
					")->row_array(); 
					
					$list[$k]['total_rows'] = $reportPlayCounts['total_rows'];
					$list[$k]['total_practice_rows'] = $reportPlayCounts['total_practice_rows'];
					
					$tournamentTotalPC = $tournamentTotalPC + $reportPlayCounts['total_rows'];
				}
			
				$data['list'] = $list;
				$data['tournamentTotalPC'] = $tournamentTotalPC;
				
				$data['stat_month'] = @$stat_month;
				$data['stat_year'] = @$stat_year;
				$data['filter'] = $filter;
				
				$this->load->view('admin/premium_tournaments_report', $data);	
			} else {
				redirect('Admin/Tournaments');
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	public function getPremiumTouramentsDateFilters(){
		if($this->session->userdata('admin_logged_in')){
			$startDate = @$_POST['startDate'];
			$endDate = @$_POST['endDate'];
			
			if(!empty($startDate) && !empty($endDate)){
				if($startDate > $endDate){
					
					$this->session->set_flashdata('error','<strong> Error! </strong> Invalid date range passed in custom filters.  <b>End Date</b> value can not be less than the <b>Start Date</b> value.');
					redirect('Admin/Tournaments');
					
				} else {
					
					$tournamentTotalPC = 0;
					$list = $this->ADMINDBAPI->getPremiumTournamentsListDateRange($startDate, $endDate);
					foreach($list as $k=>$row){
						$reportPlayCounts = $this->db->query("SELECT sum(report_tournament_counts) as total_rows,  sum(report_tournament_practice_counts) as total_practice_rows  
						FROM tbl_report_game_play 
						WHERE report_tournament_id = ".$row['tournament_id']."
						")->row_array(); 
						
						$list[$k]['total_rows'] = $reportPlayCounts['total_rows'];
						$list[$k]['total_practice_rows'] = $reportPlayCounts['total_practice_rows'];
						
						$tournamentTotalPC = $tournamentTotalPC + $reportPlayCounts['total_rows'];
					}
				
					$data['list'] = $list;
					$data['tournamentTotalPC'] = $tournamentTotalPC;
					
					$data['startDate'] = @$startDate;
					$data['endDate'] = @$endDate;
					$data['filter'] = 'customDates';
					$this->load->view('admin/premium_tournaments_report', $data);	
				}
			} else {
				redirect('Admin/Tournaments');
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	public function getPremiumTournamentLeaderboard($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$data['tournamentInfo'] = $this->ADMINDBAPI->getTournamentsInfoFeeRewards($id);
			$data['list'] = $this->ADMINDBAPI->getLiveTournamentPlayersDESC($id);
			$data['voucher'] = $this->ADMINDBAPI->getVoucher();
			$this->load->view('admin/premium_tournaments_leaderboard', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	

	public function getPremiumTournamentPlayStats($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$data['tournamentInfo'] = $this->ADMINDBAPI->getTournamentsInfoFeeRewards($id);
			$data['list'] = $this->ADMINDBAPI->getTournamentPlayerPlayStats($id);
		//	echo $this->db->last_query(); die;
			$this->load->view('admin/premium_tournaments_play_stats', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	################################################ END ###############################################
	
	
	
	//  **************************************   ***************************** **************************************//
	//  **************************************   Tournament Section Starts **************************************//
	//  **************************************   ***************************** **************************************//
	
	public function getTournament(){
		if($this->session->userdata('admin_logged_in')){
			
			$list = $this->ADMINDBAPI->getTournamentList($filter = 'all');
			$tournamentTotalPC = 0;
			
			foreach($list as $k=>$row){
				$reportPlayCounts = $this->db->query("SELECT sum(report_tournament_counts) as total_rows,  sum(report_tournament_practice_counts) as total_practice_rows  
				FROM tbl_report_game_play 
				WHERE report_tournament_id = ".$row['tournament_id']."
				")->row_array(); 
				
				$list[$k]['total_rows'] = $reportPlayCounts['total_rows'];
				$list[$k]['total_practice_rows'] = $reportPlayCounts['total_practice_rows'];
				
				$tournamentTotalPC = $tournamentTotalPC + $reportPlayCounts['total_rows'];
			}
			
			$data['list'] = $list;
			$data['filter'] = 'all';
			$data['tournamentTotalPC'] = $tournamentTotalPC;
			$this->load->view('admin/tournaments_report', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	
	
	
	public function getTournamentsFilter(){
		if($this->session->userdata('admin_logged_in')){
			
			if(!empty($_POST['search'])){
				
				$tournamentTotalPC = 0;
				$filter = @$_POST['search'];
				
				if($filter == '1'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getTournamentList($filter = '1');
				
				} else if($filter == '7'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getTournamentList($filter = '7');
				
				} else if($filter == '15'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getTournamentList($filter = '15');
					
				} else if($filter == '30'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getTournamentList($filter = '30');
					
				} else if($filter == 'all'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getTournamentList($filter = 'all');
					
				} else if($filter == 'month'){
					$stat_month = date('m');
					$stat_year = date('Y');				
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getTournamentList($filter = 'month', $stat_month, $stat_year);
				}
				
				foreach($list as $k=>$row){
					$reportPlayCounts = $this->db->query("SELECT sum(report_tournament_counts) as total_rows,  sum(report_tournament_practice_counts) as total_practice_rows  
					FROM tbl_report_game_play 
					WHERE report_tournament_id = ".$row['tournament_id']."
					")->row_array(); 
					
					$list[$k]['total_rows'] = $reportPlayCounts['total_rows'];
					$list[$k]['total_practice_rows'] = $reportPlayCounts['total_practice_rows'];
					
					$tournamentTotalPC = $tournamentTotalPC + $reportPlayCounts['total_rows'];
				}
			
				$data['list'] = $list;
				$data['tournamentTotalPC'] = $tournamentTotalPC;
				
				$data['stat_month'] = @$stat_month;
				$data['stat_year'] = @$stat_year;
				$data['filter'] = $filter;
				
				$this->load->view('admin/tournaments_report', $data);	
			} else {
				redirect('Admin/Tournaments');
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	
	public function getTouramentsDateFilters(){
		if($this->session->userdata('admin_logged_in')){
			$startDate = @$_POST['startDate'];
			$endDate = @$_POST['endDate'];
			
			if(!empty($startDate) && !empty($endDate)){
				if($startDate > $endDate){
					
					$this->session->set_flashdata('error','<strong> Error! </strong> Invalid date range passed in custom filters.  <b>End Date</b> value can not be less than the <b>Start Date</b> value.');
					redirect('Admin/Tournaments');
					
				} else {
					
					$tournamentTotalPC = 0;
					$list = $this->ADMINDBAPI->getTournamentsListDateRange($startDate, $endDate);
					foreach($list as $k=>$row){
						$reportPlayCounts = $this->db->query("SELECT sum(report_tournament_counts) as total_rows,  sum(report_tournament_practice_counts) as total_practice_rows  
						FROM tbl_report_game_play 
						WHERE report_tournament_id = ".$row['tournament_id']."
						")->row_array(); 
						
						$list[$k]['total_rows'] = $reportPlayCounts['total_rows'];
						$list[$k]['total_practice_rows'] = $reportPlayCounts['total_practice_rows'];
						
						$tournamentTotalPC = $tournamentTotalPC + $reportPlayCounts['total_rows'];
					}
				
					$data['list'] = $list;
					$data['tournamentTotalPC'] = $tournamentTotalPC;
					
					$data['startDate'] = @$startDate;
					$data['endDate'] = @$endDate;
					$data['filter'] = 'customDates';
					$this->load->view('admin/tournaments_report', $data);	
				}
			} else {
				redirect('Admin/Tournaments');
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	
	public function getTournamentLeaderboard($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$data['tournamentInfo'] = $this->ADMINDBAPI->getTournamentsInfoFeeRewards($id);
			$data['list'] = $this->ADMINDBAPI->getLiveTournamentPlayersDESC($id);
			$data['voucher'] = $this->ADMINDBAPI->getVoucher();
			$this->load->view('admin/tournament_leaderboard', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	

	public function getTournamentPlayStats($id){
		if($this->session->userdata('admin_logged_in')){
			$id = base64_decode($id);
			$data['tournamentInfo'] = $this->ADMINDBAPI->getTournamentsInfoFeeRewards($id);
			$data['list'] = $this->ADMINDBAPI->getTournamentPlayerPlayStats($id);
		//	echo $this->db->last_query(); die;
			$this->load->view('admin/tournament_play_stats', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	

	//  **************************************   ***************************** **************************************//
	//  **************************************   Tournament Section Ends **************************************//
	//  **************************************   ***************************** **************************************//

	public function getInstantGameFilter(){
		if($this->session->userdata('admin_logged_in')){
			if(!empty($_POST['search'])){
				
				$filter = @$_POST['search'];
				
				if($filter == '1'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getInstantGameFilterList($filter = '1');
				
				} else if($filter == '7'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getInstantGameFilterList($filter = '7');
				
				} else if($filter == '15'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getInstantGameFilterList($filter = '15');
					
				} else if($filter == '30'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getInstantGameFilterList($filter = '30');
					
				} else if($filter == 'all'){
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getInstantGameFilterList($filter = 'all');
					
				} else if($filter == 'month'){
					$stat_month = date('m');
					$stat_year = date('Y');				
					$data['filter'] = $filter;
					$list = $this->ADMINDBAPI->getInstantGameFilterList($filter = 'month', $stat_month, $stat_year);
				}
				
				$data['game'] = $list;
				// echo "<pre>";
				// print_r($data);
				// die();
				$data['filter'] = $filter;
				$this->load->view('admin/game_report', $data);	
			} else {
				redirect('Admin/GameReport');
			}
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	public function getInstantGameReport(){
		if($this->session->userdata('admin_logged_in')){
		$data['game'] = $this->ADMINDBAPI->getInstantPlayedGames();
		// $data['getGameCount']= $this->ADMINDBAPI->getUserPlayCount($data['game']);
		$data['filter'] = 'All';
		$this->load->view('admin/game_report', $data);
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}


	public function exportCSV(){
			$result = $this->ADMINDBAPI->getDailyReport();
			// file name 
			// echo "<pre>";
			// print_r($result);
			// die();
			$filename = 'Game:-'.date('M d Y').'.csv'; 
			header("Content-Description: File Transfer"); 
			header("Content-Disposition: attachment; filename=$filename"); 
			header("Content-Type: application/csv; ");
			
			// get data 
		 
			// file creation 
			$file = fopen('php://output', 'w');
		  
			$header = array("Date" ,"MSISDN","Name","Game Name","Practice Count" ); 
			fputcsv($file, $header);
			if(is_array($result) && count($result)>0){
				foreach ($result as $row){ 
					if($row['report_practice_counts']!=0)
					{
						$data = array(date('M d Y') ,$row['user_phone'] , $row['user_full_name'] , $row['Name'] , $row['report_practice_counts'],   );
						fputcsv($file,$data);
					}
				}
			}
			fclose($file); 
			exit; 
	}
	
	public function exportFreeTournamentCSV(){
			$result = $this->ADMINDBAPI->getDailyTournamentReport();
			$filename = 'Tournament_'.date('M d Y').'.csv'; 
			header("Content-Description: File Transfer"); 
			header("Content-Disposition: attachment; filename=$filename"); 
			header("Content-Type: application/csv; ");
			
			// get data 
			// file creation 
			$file = fopen('php://output', 'w');
		  
			$header = array("Date","MSISDN","Name","Tournament Name", "Tournament Section ", "Tournament Reward"," Game Name ","Practice Count" , "Play Count"  ); 
			fputcsv($file, $header);
			if(is_array($result) && count($result)>0){
				foreach ($result as $row){ 
					if($row['tournament_section']==1)
					{
						$section = "Daily Free Tournament";
						if($row['tournament_reward_type'] == 1)
							$reward = "Coin";
						else 
							$reward = "Voucher";
						$data = array(date('M d Y'),$row['user_phone'] , $row['user_full_name'] , $row['tournament_name'] , $section , $reward , $row['Name'] , $row['report_practice_counts'], $row['report_tournament_counts'] );
						fputcsv($file,$data);
					}
						 
				}
			}
			fclose($file); 
			exit; 
	}

	public function exportPaidTournamentCSV(){
			$result = $this->ADMINDBAPI->getDailyTournamentReport();
			$filename = 'Tournament_'.date('M d Y').'.csv'; 
			header("Content-Description: File Transfer"); 
			header("Content-Disposition: attachment; filename=$filename"); 
			header("Content-Type: application/csv; ");
			
			// get data 
			// file creation 
			$file = fopen('php://output', 'w');
		  
			$header = array("Date" ,"MSISDN","Name","Tournament Name", "Tournament Section ", "Tournament Reward"," Game Name ","Practice Count" , "Play Count" ); 
			fputcsv($file, $header);
			if(is_array($result) && count($result)>0){
				foreach ($result as $row){ 
					if($row['tournament_section']!=1)
					{
						if($row['tournament_section']==2)
						{
							$section = "Weekly Tournament (Premium)";
						}
						else
							$section = "Daily Tournament (premium)";
						if($row['tournament_reward_type'] == 1)
							$reward = "Coin";
						else 
							$reward = "Voucher";
						$data = array(date('M d Y'), $row['user_phone'] , $row['user_full_name'] , $row['tournament_name'] , $section , $reward , $row['Name'] , $row['report_practice_counts'], $row['report_tournament_counts'] );
						fputcsv($file,$data);
					}
					 
				}
			}
			fclose($file); 
			exit; 
	}
	

	public function getFreeGamesStats(){
		if($this->session->userdata('admin_logged_in')){
			$data['list'] = $this->ADMINDBAPI->getFreeGamesStats();
			$data['freeStats'] = $this->ADMINDBAPI->getFreeGamesTotalGP();
			$this->load->view('admin/free_games_stats', $data);	
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}

	public function getFreeGamesStatsFilter(){
		if($this->session->userdata('admin_logged_in')){
			
			$type = @$_GET['type'];   // 1=Date-wise  2=User-wise
			$game_id = @$_GET['game'];   
			$data['gameInfo'] = $this->ADMINDBAPI->getGamesInfoByGameboostId($game_id);
			
			if(!empty($type) && $type == 1 || $type == 2){
				if($type == 1 ){  
					// Find date-wise free games played stats
					
					if(!empty($_POST['search'])){
						$filter = @$_POST['search'];
					
						if($filter == '1'){
							$data['filter'] = $filter;
							$data['list'] = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = '1');
							$data['freeStats'] = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = '1');
						
						} else if($filter == '7'){
							$data['filter'] = $filter;
							$data['list'] = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = '7');
							$data['freeStats'] = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = '7');
						
						} else if($filter == '15'){
							$data['filter'] = $filter;
							$data['list'] = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = '15');
							$data['freeStats'] = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = '15');
							
						} else if($filter == '30'){
							$data['filter'] = $filter;
							$data['list'] = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = '30');
							$data['freeStats'] = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = '30');
							
						} else if($filter == 'month'){
							$stat_month = date('m');
							$stat_year = date('Y');				
							$data['filter'] = $filter;
							$data['list'] = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = 'month', $stat_month, $stat_year);
							$data['freeStats'] = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = 'month', $stat_month, $stat_year);
						}
						
					}  else {
						$stat_month = date('m');
						$stat_year = date('Y');
						$data['stat_month'] = @$stat_month;
						$data['stat_year'] = @$stat_year;
						$data['filter'] = '30';
						$data['list'] = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = '30');
							$data['freeStats'] = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = '30');
						
					}
					
					$data['type'] = $type;
					$data['game_id'] = $game_id;
					
					
					$this->load->view('admin/free_games_stats_datewise', $data);
				
				//} else if($type == 2 ){ 
					// Find user-wise free games played stats
					
					
					
				} else {
					redirect('Admin/FreeGamesStats');
				}
			} else {
				redirect('Admin/FreeGamesStats');
			}			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	
	public function getFreeGamesStatsDateFilter(){
		if($this->session->userdata('admin_logged_in')){
			
			if(!empty($_GET['type']) && @$_GET['type']== 1 && !empty($_GET['game'])){  
			
				$type = @$_GET['type'];   // 1=Date-wise  2=User-wise
				$game_id = @$_GET['game'];   
				$data['gameInfo'] = $this->ADMINDBAPI->getGamesInfoByGameboostId($game_id);
			
			
				// Find date-wise free games played stats
				
				$startDate = @$_POST['startDate'];
				$endDate = @$_POST['endDate'];
				
				if(!empty($startDate) && !empty($endDate)){
					if($startDate > $endDate){
						
						$this->session->set_flashdata('error','<strong> Error! </strong> Invalid date range passed in custom filters.  <b>End Date</b> value can not be less than the <b>Start Date</b> value.');
						redirect('Admin/FreeGamesStats');
						
					} else {
						$data['list'] = $this->ADMINDBAPI->getFreeGamesStatsDateRange($game_id, $startDate, $endDate);
						$data['freeStats'] = $this->ADMINDBAPI->getFreeGameDateRangeGP($game_id, $startDate, $endDate);
						
						$data['type'] = $type;
						$data['game_id'] = $game_id;
						$data['startDate'] = $startDate;
						$data['endDate'] = $endDate;
						$data['filter'] = 'customDates';
						
						$this->load->view('admin/free_games_stats_datewise', $data);
					}
					
				} else {
					redirect('Admin/getFreeGamesStatsFilter/?type='.$type.'&game='.$game_id);
				}
			} else {
				redirect('Admin/FreeGamesStats');
			}			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	public function exportFreeGamesStats(){
		if($this->session->userdata('admin_logged_in')){
			
			$type = @$_GET['type'];   // 1=Date-wise  2=User-wise
			$game_id = @$_GET['game'];  
			$filter = @$_GET['filter'];			
			$data['gameInfo'] = $this->ADMINDBAPI->getGamesInfoByGameboostId($game_id);
			
			if(!empty($type) && !empty($game_id) && !empty($filter)){
			
					// Find date-wise free games played stats
					
						if($filter == '1'){
							$data['filter'] = $filter;
							$list = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = '1');
							$freeStats = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = '1');
						
						} else if($filter == '7'){
							$data['filter'] = $filter;
							$list  = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = '7');
							$freeStats = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = '7');
						
						} else if($filter == '15'){
							$data['filter'] = $filter;
							$list  = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = '15');
							$freeStats = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = '15');
							
						} else if($filter == '30'){
							$data['filter'] = $filter;
							$list  = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = '30');
							$freeStats = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = '30');
							
						} else if($filter == 'month'){
							$stat_month = date('m');
							$stat_year = date('Y');				
							$data['filter'] = $filter;
							$list = $this->ADMINDBAPI->getFreeGamesStatsDatewise($game_id, $filter = 'month', $stat_month, $stat_year);
							$freeStats = $this->ADMINDBAPI->getFreeGameTotalGP($game_id, $filter = 'month', $stat_month, $stat_year);
						}
						
					
					
					//define column headers
					$headers = array("Date"=> 'string', "Play Counts"=> 'string', "Unique Users"=> 'string');
				
					//create writer object
					$writer = new XLSXWriter();
					
					//meta data info
					$writer->setTitle('Mini Games Free Games Stats Report');
					$writer->setSubject('Mini Games Free Games Stats Report');
					$writer->setAuthor('Nisha Vaish');
					$writer->setCompany('BEMOBI/GPL');
					$writer->setDescription('Mini Games Free Games Stats Report');
					$writer->setTempDir(sys_get_temp_dir());
					
					//write headers
					//$writer->writeSheetHeader('Sheet1', $headers);
					$writer->writeSheetHeader('Sheet1', $headers, $col_options = array(
						'widths'=>[25,25,25],
						['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
						['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
						['font'=>'Calibri','font-style'=>'bold','font-size'=>'13']
						));
					//write rows to sheet1
					if(is_array($list) && count($list)>0){
						
						foreach ($list as $sf):
							$writer->writeSheetRow('Sheet1', array(date('d/M/Y', strtotime($sf['report_date'])), number_format($sf['total_game_plays'], 0), number_format($sf['unique_plays'],0)),  ['width'=>'25', 'font'=>'Calibri','font-style'=>'normal','font-size'=>'12']);
						endforeach;
						
					} else {
						$writer->writeSheetRow('Sheet1', array("", "", "", "", "", "", "", ""));
						
					}
					
					$filename = 'MiniGames_GamesStats_'.str_ireplace(" ","-",$data['gameInfo']['Name']).'.xlsx';
					
					$fileLocation = FCPATH . 'uploads/daily_reports/'.$filename;
					
					//write to xlsx file
					$writer->writeToFile($fileLocation);
					
					// Download the xls file
					$this->load->helper('download');
					force_download($fileLocation, NULL);
					
				
				
			} else {
				redirect('Admin/FreeGamesStats');
			}			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	
	
	public function exportFreeGamesStatsRange(){
		if($this->session->userdata('admin_logged_in')){
			
			$type = @$_GET['type'];   // 1=Date-wise  2=User-wise
			$game_id = @$_GET['game'];
			$startDate = @$_GET['start'];
			$endDate = @$_GET['end'];
			
			if(!empty($startDate) && !empty($endDate) && !empty($game_id)){
				
					$data['gameInfo'] = $this->ADMINDBAPI->getGamesInfoByGameboostId($game_id);
			
					// Find date-wise free games played stats
					
					$list = $this->ADMINDBAPI->getFreeGamesStatsDateRange($game_id, $startDate, $endDate);
					$freeStats = $this->ADMINDBAPI->getFreeGameDateRangeGP($game_id, $startDate, $endDate);
						
					
					//define column headers
					$headers = array("Date"=> 'string', "Play Counts"=> 'string', "Unique Users"=> 'string');
				
					//create writer object
					$writer = new XLSXWriter();
					
					//meta data info
					$writer->setTitle('Mini Games Free Games Stats Report');
					$writer->setSubject('Mini Games Free Games Stats Report');
					$writer->setAuthor('Nisha Vaish');
					$writer->setCompany('BEMOBI/GPL');
					$writer->setDescription('Mini Games Free Games Stats Report');
					$writer->setTempDir(sys_get_temp_dir());
					
					//write headers
					//$writer->writeSheetHeader('Sheet1', $headers);
					$writer->writeSheetHeader('Sheet1', $headers, $col_options = array(
						'widths'=>[25,25,25],
						['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
						['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
						['font'=>'Calibri','font-style'=>'bold','font-size'=>'13']
						));
					//write rows to sheet1
					if(is_array($list) && count($list)>0){
						
						foreach ($list as $sf):
							$writer->writeSheetRow('Sheet1', array(date('d/M/Y', strtotime($sf['report_date'])), number_format($sf['total_game_plays'], 0), number_format($sf['unique_plays'],0)),  ['width'=>'25', 'font'=>'Calibri','font-style'=>'normal','font-size'=>'12']);
						endforeach;
						
					} else {
						$writer->writeSheetRow('Sheet1', array("", "", "", "", "", "", "", ""));
						
					}
					
					$filename = 'MiniGames_GamesStats_'.str_ireplace(" ","-",$data['gameInfo']['Name']).'.xlsx';
					
					$fileLocation = FCPATH . 'uploads/daily_reports/'.$filename;
					
					//write to xlsx file
					$writer->writeToFile($fileLocation);
					
					// Download the xls file
					$this->load->helper('download');
					force_download($fileLocation, NULL);
					
				
			} else {
				redirect('Admin/FreeGamesStats');
			}	

			
		} else{
			$this->session->set_flashdata('error','<strong> Error! </strong> Login to Access Your Account.');
			redirect('Admin');
		}
	}
	public function getUserRegistered(){
		$data['filter'] = '30';
		$data['result'] = $this->ADMINDBAPI->getUserRegistered(30);
		//echo $this->db->last_query(); die;
		$this->load->view('admin/user_registered' , $data);
	}
	
	public function getFilteredUserRegistered(){
		$filter = $_POST['search'];
		if($filter=='Month' || $filter=='month')
		{
			$stat_month = date('m');
			$stat_year = date('Y');				
			$data['result'] = $this->ADMINDBAPI->getUserRegistered($filter , $stat_month, $stat_year);
		}
		else
			$data['result'] = $this->ADMINDBAPI->getUserRegistered($filter);
		
		
		$data['filter'] = $filter;
		$this->load->view('admin/user_registered' , $data);

	}
	public function getDateFilterUserRegistered()
	{
		$startDate = @$_POST['startDate'];
		$endDate = @$_POST['endDate'];
		if($startDate> $endDate)
		{
			$this->session->set_flashdata('error','<strong> Error! </strong> Invalid date range passed in custom filters.  <b>End Date</b> value can not be less than the <b>Start Date</b> value.');
			redirect('Admin/UserRegistered');
		}
		else
			$data['result'] = $this->ADMINDBAPI->getUserRegisteredRange($startDate , $endDate);
		$data['filter'] = 'customDates';
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		$this->load->view('admin/user_registered' , $data);
	}
	public function getExportUserRegistered($id)
	{
		$filter = base64_decode($id);
		if($filter=='Month' || $filter=='month')
		{
			$stat_month = date('m');
			$stat_year = date('Y');				
			$result = $this->ADMINDBAPI->getUserRegistered($filter , $stat_month, $stat_year);
		}
		else
		{
			$result = $this->ADMINDBAPI->getUserRegistered($filter);
		}
			
			$headers = array("Date"=> 'string', "User Registered"=> 'string', "Subscribed"=> 'string' ,"Non-Subscribed"=> 'string');
				
			//create writer object
			$writer = new XLSXWriter();
			
			//meta data info
			$writer->setTitle('Mini Games Free Games Stats Report');
			$writer->setSubject('Mini Games Free Games Stats Report');
			$writer->setAuthor('Nisha Vaish');
			$writer->setCompany('BEMOBI/GPL');
			$writer->setDescription('Mini Games Free Games Stats Report');
			$writer->setTempDir(sys_get_temp_dir());
			
			//write headers
			//$writer->writeSheetHeader('Sheet1', $headers);
			$writer->writeSheetHeader('Sheet1', $headers, $col_options = array(
				'widths'=>[25,25,25],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13']
				));
			//write rows to sheet1
			if(is_array($result) && count($result)>0){
				
				foreach ($result as $sf):
					$writer->writeSheetRow('Sheet1', array($sf['date'], $sf['total_users'],$sf['subscribed'], $sf['total_users'] - $sf['subscribed']),  ['width'=>'25', 'font'=>'Calibri','font-style'=>'normal','font-size'=>'12']);
				endforeach;
				
			} else {
				$writer->writeSheetRow('Sheet1', array("", "", "", "", "", "", "", ""));
				
			}
			
			$filename = 'UserRegistered_.xlsx';
			
			$fileLocation = FCPATH . 'uploads/daily_reports/'.$filename;
			
			//write to xlsx file
			$writer->writeToFile($fileLocation);
			
			// Download the xls file
			$this->load->helper('download');
			force_download($fileLocation, NULL);
		
	}
	public function getUserPlayStats($date)
	{
		$date = base64_decode($date);
		$data['result'] = $this->ADMINDBAPI->getUserPlayStats($date);
		$this->load->view('admin/user_registered_datewise' , $data);
	}
	public function getExportRangeUserRegistered($Sdate , $eDate)
	{
		$sDate=base64_decode($Sdate);
		$eDate=base64_decode($eDate);
		$result = $this->ADMINDBAPI->getUserRegisteredRange($sDate , $eDate);
		$headers = array("Date"=> 'string', "User Registered"=> 'string', "Subscribed"=> 'string' ,"Non-Subscribed"=> 'string');
				
			//create writer object
			$writer = new XLSXWriter();
			
			//meta data info
			$writer->setTitle('Mini Games Free Games Stats Report');
			$writer->setSubject('Mini Games Free Games Stats Report');
			$writer->setAuthor('Nisha Vaish');
			$writer->setCompany('BEMOBI/GPL');
			$writer->setDescription('Mini Games Free Games Stats Report');
			$writer->setTempDir(sys_get_temp_dir());
			
			//write headers
			//$writer->writeSheetHeader('Sheet1', $headers);
			$writer->writeSheetHeader('Sheet1', $headers, $col_options = array(
				'widths'=>[25,25,25],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13']
				));
			//write rows to sheet1
			if(is_array($result) && count($result)>0){
				
				foreach ($result as $sf):
					$writer->writeSheetRow('Sheet1', array($sf['date'], $sf['total_users'],$sf['subscribed'], $sf['total_users'] - $sf['subscribed']),  ['width'=>'25', 'font'=>'Calibri','font-style'=>'normal','font-size'=>'12']);
				endforeach;
				
			} else {
				$writer->writeSheetRow('Sheet1', array("", "", "", "", "", "", "", ""));
				
			}
			
			$filename = 'UserRegistered_.xlsx';
			
			$fileLocation = FCPATH . 'uploads/daily_reports/'.$filename;
			
			//write to xlsx file
			$writer->writeToFile($fileLocation);
			
			// Download the xls file
			$this->load->helper('download');
			force_download($fileLocation, NULL);
	}
	public function getAssignmentOverVoucher()
	{
		$data['list']= $this->ADMINDBAPI->getVoucherNearExpiration();
		$this->load->view('admin/voucher_expiration' , $data);
	}
	public function exportVoucherExpiration()
	{
		$result = $this->ADMINDBAPI->getVoucherNearExpiration();
		$headers = array("Voucher ID"=> 'string', "Voucher"=> 'string', "Starts From"=> 'string' ,"Valid Upto"=> 'string');
				
			//create writer object
			$writer = new XLSXWriter();
			
			//meta data info
			
			
			//write headers
			//$writer->writeSheetHeader('Sheet1', $headers);
			$writer->writeSheetHeader('Sheet1', $headers, $col_options = array(
				'widths'=>[25,25,25],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
				['font'=>'Calibri','font-style'=>'bold','font-size'=>'13']
				));
			//write rows to sheet1
			if(is_array($result) && count($result)>0){
				
				foreach ($result as $sf):
					$writer->writeSheetRow('Sheet1', array($sf['voucher_id'], $sf['vt_type'],date('j M, Y', strtotime($sf['voucher_validity_starts'])), date('j M, Y', strtotime($sf['voucher_validity_ends']))),  ['width'=>'25', 'font'=>'Calibri','font-style'=>'normal','font-size'=>'12']);
				endforeach;
				
			} else {
				$writer->writeSheetRow('Sheet1', array("", "", "", "", "", "", "", ""));
				
			}
			
			$filename = 'Vouchers_List.xlsx';
			
			$fileLocation = FCPATH . 'uploads/daily_reports/'.$filename;
			
			//write to xlsx file
			$writer->writeToFile($fileLocation);
			
			// Download the xls file
			$this->load->helper('download');
			force_download($fileLocation, NULL);
	}
	public function voucherLogs()
	{
		$id = $_POST['id'];
		// echo $id;
		$data['logs'] = $this->ADMINDBAPI->getVoucherLogs($id);
		if(is_array($data['logs']) && count($data['logs'])>0)
		{
			$this->load->view('admin/voucher_logs' , $data);
		}
		else
		{
			echo "false";
		}
	}
}
