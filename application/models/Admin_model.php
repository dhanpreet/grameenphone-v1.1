<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	 function __construct(){
		parent::__construct();
	}
	
	
	function getLoginStatus($email,$pswd){
		$this->db->select("*", FALSE);
        $this->db->from('login');        
        $this->db->where('username', $email);
		$this->db->where('password', $pswd);
		$this->db->where('user_status', '1');		
		$this->db->where('user_type', '1');		
        return $this->db->get()->row_array();
	}

	
	function getAllGamesCount(){
		$this->db->select("count(*) as total", FALSE);
        $this->db->from('games'); 
        return $this->db->get()->row_array();
	}
	
	function getPublishedGamesCount(){
		$this->db->select("count(*) as total", FALSE);
        $this->db->from('games'); 
        $this->db->where('portalPublished','1'); 
        return $this->db->get()->row_array();
	}
	
	function getTournamentsCount(){
		$this->db->select("count(*) as total", FALSE);
        $this->db->from('tournaments'); 
        return $this->db->get()->row_array();
	}
	
	function getLiveTournamentsCount(){
		$todayDate = date('Y-m-d'); 
		
		$this->db->select("count(*) as total", FALSE);
        $this->db->from('tournaments'); 
        $this->db->where("tournament_start_date <= '$todayDate'"); 
        $this->db->where("tournament_end_date >= '$todayDate'"); 
        return $this->db->get()->row_array();
	}
	
	
	function getUserInfo($user_id){
		$this->db->select("*", FALSE);
        $this->db->from('login');        
        $this->db->where('user_id', $user_id);
		
        return $this->db->get()->row_array();
	}
	function getSiteUserInfo($user_id){
		$this->db->select("*", FALSE);
        $this->db->from('tbl_site_users');        
        $this->db->where('user_id', $user_id);
		
        return $this->db->get()->row_array();
	}
	
	function getCategoriesList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('categories'); 
		$this->db->order_by('category_id', 'ASC');
        return $this->db->get()->result_array();
	}
	
	function getCategoriesInfo($id){
		$this->db->select("*", FALSE);
        $this->db->from('categories'); 
		$this->db->where('category_id', $id);
        return $this->db->get()->row_array();
	}
	
	function getCategoriesInfoByName($category){
		$this->db->select("*", FALSE);
        $this->db->from('categories'); 
		$this->db->where("category_name LIKE '%$category%' ");
        return $this->db->get()->row_array();
	}
	
	
	function getGamesList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		if(!empty($id))		
			$this->db->where('id', $id);
		$this->db->order_by('Name', 'ASC');
        return $this->db->get()->result_array();
	}
	
	public function getCountryList(){
		$this->db->select('*' ,FALSE);
		$this->db->from('country');
		return $this->db->get()->result_array();
	}
	
	public function setCountry($data){
		$this->db->insert('tbl_country' , $data);
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
			return false;
	}
	
	public function updateCountry($cid, $data){
		$this->db->where('c_id', $cid);
		$this->db->update('tbl_country' , $data);
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
			return false;
	}
	
	function getTournamentsList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('tournaments'); 
		if(!empty($id)){
			$this->db->where('tournament_id', $id);
			
		}	
		$this->db->join('tbl_tournaments_fee_rewards','tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id','left');
		// $this->db->join('tbl_voucher_type','tbl_voucher_type.vt_id = tbl_tournaments_fee_rewards.fee_tournament_prize_1','left');
        return $this->db->get()->result_array();
	}
	function getVoucher()
	{
		$this->db->select('*', FALSE);
		$this->db->from('tbl_voucher_type');
		return $this->db->get()->result_array();
	}
	
	public function getActiveCountryList(){
		$this->db->select('*' , False);
		$this->db->from('country');
		$this->db->where('c_status', '1');
		return $this->db->get()->result_array();
	}
	
	public function deteleCountry($id){
		$this->db->where('c_id', $id);
		$this->db->delete('tbl_country');
	}
	
	
	public function addNewTournaments($data){
		$startTimeStamp = $data['tournament_start_date'].' '.$data['tournament_start_time'].":00";
		$endTimeStamp = $data['tournament_end_date'].' '.$data['tournament_end_time'].":59";
		
		$data2=array(
			'tournament_name'=>$data['tournament_name'],
			'tournament_game_id'=>$data['tournament_game_id'],
			'tournament_gameboost_id'=>$data['tournament_gameboost_id'],
			'tournament_game_name'=>$data['tournament_game_name'],
			'tournament_game_image'=>$data['tournament_game_image'],
			'tournament_desc'=>$data['tournament_desc'],
			'tournament_type'=>$data['tournament_type'],
			'tournament_section'=>$data['tournament_section'],
			'tournament_start_date'=>$data['tournament_start_date'],
			'tournament_end_date'=>$data['tournament_end_date'],
			'tournament_start_time'=>$data['tournament_start_time'],
			'tournament_end_time'=>$data['tournament_end_time'],			
			'tournament_start_timestamp'=> $startTimeStamp,
			'tournament_end_timestamp'=> $endTimeStamp,			
			'tournament_category'=>$data['tournament_category'],
			'tournament_category_id'=>$data['tournament_category_id'],
			'tournament_reward_type'=>$data['tournament_reward_type'][0],
			'tournament_status'=>$data['tournament_status'],
			'tournament_added_on'=>$data['tournament_added_on'],
			'tournament_updated_on'=>$data['tournament_updated_on']
			
		);
		// echo "<pre>";
		// print_r($data2);
		// die();
		$result=$this->db->insert('tbl_tournaments', $data2);
		if(!$result)
			return false;
		$insert_id=$this->db->insert_id();
		//print_r($insert_id);
		$count=0;
		foreach($data['country_id'] as $row){   
			if($data['tournament_reward_type'][$count]=='4'){
				if(!isset($data['tournament_fee'][$count])){
				  $data['tournament_fee'][$count]='0';
				}
				$data2=array(
					'fee_turnament_id'=> $insert_id,
					'fee_country_id' => $row,
					'fee_country_name' => $data['country'][$count],
					'fee_tournament_rewards' => $data['tournament_reward_type'][$count],
					'fee_tournament_fee' => $data['tournament_fee'][$count],
					'fee_tournament_prize_1' => $data['tournament_prize_1'][$count],
					'fee_tournament_prize_2' => $data['tournament_prize_2'][$count],
					'fee_tournament_prize_3' => $data['tournament_prize_3'][$count],
					'fee_tournament_prize_4' => $data['tournament_prize_4'][$count],
					'fee_tournament_prize_5' => $data['tournament_prize_5'][$count]
				);
				
				//$this->db->insert('tbl_tournaments_fee_rewards', array(''));
				$this->db->insert('tbl_tournaments_fee_rewards', $data2);
			
			
            // assignment of voucher for tournament
				if($data['tournament_section'] == '1'){ //free tournament
					
					for($j=1;$j<=10;$j++){
						$vouchercode = $this->getdetailvoucher($data['tournament_prize_1'][$count], $limit='1');  //get the voucher by type id
						$this->updateVouchersLogs($vouchercode, $insert_id, $section='1', $j);
					}

				} elseif ($data['tournament_section'] == '2') {
					
					//for rank 1
					$vouchercode_rank1 = $this->getdetailvoucher($data['tournament_prize_1'][$count], $limit='1');
					$this->updateVouchersLogs($vouchercode_rank1,  $insert_id, $section='2', '1');
						
						
					//for rank 2  
					$vouchercode_rank2 = $this->getdetailvoucher($data['tournament_prize_2'][$count], $limit='1');
					$this->updateVouchersLogs($vouchercode_rank2,  $insert_id, $section='2', '2');
              	   
				   
					// for rank 3 
					$vouchercode_rank3 = $this->getdetailvoucher($data['tournament_prize_3'][$count], $limit='1');
					$this->updateVouchersLogs($vouchercode_rank3,  $insert_id, $section='2', '3');
                  
					// for rank 4 to 10 
					for($j=4;$j<=10;$j++){
             		    $vouchercode_rank4_10 = $this->getdetailvoucher($data['tournament_prize_4'][$count], $limit='1');
						$this->updateVouchersLogs($vouchercode_rank4_10,  $insert_id, $section='2', $j);
             	    }

					// for rank 11 to 50 
             	    for($j=11;$j<=50;$j++){
						$vouchercode_rank11_50 = $this->getdetailvoucher($data['tournament_prize_5'][$count], $limit='1');
						$this->updateVouchersLogs($vouchercode_rank11_50,  $insert_id, $section='2', $j);
             	    }
              	         	   
              	   
				} elseif ($data['tournament_section'] == '3') {
					//for rank 1
					$vouchercode_rank1 = $this->getdetailvoucher($data['tournament_prize_1'][$count], $limit='1');
					$this->updateVouchersLogs($vouchercode_rank1,  $insert_id, $section='3', '1');
              	   
				   
					//for rank 2  
					$vouchercode_rank2 = $this->getdetailvoucher($data['tournament_prize_2'][$count], $limit='1');
					$this->updateVouchersLogs($vouchercode_rank2,  $insert_id, $section='3', '2');
              	   
				   
              	    // for rank 3 
					$vouchercode_rank3 = $this->getdetailvoucher($data['tournament_prize_3'][$count], $limit='1');
					$this->updateVouchersLogs($vouchercode_rank3,  $insert_id, $section='3', '3');
              	   
                  
					for($j=4;$j<=10;$j++){
             		    $vouchercode_rank4_10 = $this->getdetailvoucher($data['tournament_prize_4'][$count], $limit='1');
						$this->updateVouchersLogs($vouchercode_rank4_10,  $insert_id, $section='3', $j);
					}


             	    for($j=11;$j<=20;$j++){
						$vouchercode_rank11_20 = $this->getdetailvoucher($data['tournament_prize_5'][$count], $limit='1');
						$this->updateVouchersLogs($vouchercode_rank11_20,  $insert_id, $section='3', $j);
             	    }
				}
			
				$count++;
				
			} else {
			
				$data2=array(
					'fee_turnament_id'=> $insert_id,
					'fee_country_id'=>$row,
					'fee_country_name'=>$data['country'][$count],
					'fee_tournament_rewards'=>$data['tournament_reward_type'][$count],
					'fee_tournament_fee'=>$data['tournament_fee'][$count],
					'fee_tournament_prize_1'=>$data['tournament_prize_1'][$count],
					'fee_tournament_prize_2'=>$data['tournament_prize_2'][$count],
					'fee_tournament_prize_3'=>$data['tournament_prize_3'][$count],
					'fee_tournament_prize_4'=>$data['tournament_prize_4'][$count],
					'fee_tournament_prize_5'=>$data['tournament_prize_5'][$count],
					'fee_tournament_prize_6'=>$data['tournament_prize_6'][$count],
					'fee_tournament_prize_7'=>$data['tournament_prize_7'][$count],
					'fee_tournament_prize_8'=>$data['tournament_prize_8'][$count],
					'fee_tournament_prize_9'=>$data['tournament_prize_9'][$count],
				);
				$count++;
				$this->db->insert('tbl_tournaments_fee_rewards', $data2);
			}
		}
		return $insert_id;
	}

	

	function updateVouchersLogs($vouchercode, $tournamentId, $section, $rank){
		
		$this->db->insert('tbl_tournament_voucher_detail', 
			array(
			'tv_voucher_id' => $vouchercode[0]['voucher_id'], 
			'tv_tournament_id' => $tournamentId,
			'tv_tournament_section'=> $section, 
			'tv_date_time' => date("Y-m-d H:i:s"),
			'tv_prize_rank' => $rank,
			'tv_assigned_status' => '0'
			)
		); 

		//update in vouchers table
		$this->db->set('voucher_status', '1', false);  // 0=NotAssigned 1=Assigned-Tournament 2=Assigned-User 3=Claimed 4=Expired   5=Deactivated
		$this->db->where('voucher_id', $vouchercode[0]['voucher_id']);
		if($this->db->update('voucher_detail')){

			// deduct coupon from the voucher type and update balance
			$voucherType = $this->getVoucherTypes($vouchercode[0]['voucher_type_id']);
			
			$vtAssignCoupons = $voucherType[0]['vt_assign_coupons'];
			$vtBalanceCoupons = $voucherType[0]['vt_balance_coupons'];
			$updateCoupon['vt_assign_coupons'] = ($vtAssignCoupons+1);
			$updateCoupon['vt_balance_coupons'] = ($vtBalanceCoupons-1);
			$this->db->where('vt_id', $voucherType[0]['vt_id']);
			$this->db->update('voucher_type', $updateCoupon);
			
			// finally update logs
			$logs['log_voucher_id'] =  $vouchercode[0]['voucher_id'];
			$logs['log_tournament_id'] = $tournamentId;
			$logs['log_voucher_status'] = '1';
			$logs['log_message'] = 'assigned_to_tournament';
			$logs['log_date_time'] = date('Y-m-d H:i:s');
			$logs['log_added_on'] = time();
			$this->db->insert('voucher_logs', $logs);
		}    

	}
	

	function getTournamentsBannersList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('tournament_banners'); 
        $this->db->join('tournaments','tournaments.tournament_id = tournament_banners.banner_tournament_id','left'); 
		return $this->db->get()->result_array();
	}
	
	function getTournamentBannerInfo($id){
		$this->db->select("*", FALSE);
        $this->db->from('tournament_banners'); 
        $this->db->where('banner_id', $id); 
        $this->db->join('tournaments','tournaments.tournament_id = tournament_banners.banner_tournament_id','left'); 
		return $this->db->get()->row_array();
	}
	
	
	function getTournamentBannerInfoByTid($tournament_id){
		$this->db->select("*", FALSE);
        $this->db->from('tournament_banners'); 
        $this->db->where('banner_tournament_id', $tournament_id); 
       return $this->db->get()->row_array();
	}
	
	
	function getCategoryGamesList($category=''){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		//$this->db->where("portalCategory like '%$category%' ");
		$this->db->where("portalCategoryId", $category);
		$this->db->where("portalPublished", '1');
		$this->db->where("private_tournament", '1');
	
        return $this->db->get()->result_array();
	}
	
	function getGamesInfo($id){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		$this->db->where('gid', $id);
        return $this->db->get()->row_array();
	}
	
	function getGamesInfoByGameboostId($id){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		$this->db->where('id', $id);
        return $this->db->get()->row_array();
	}
	
	function getGameInfoByName($game){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		$this->db->where("Name like '%$game%'");
        return $this->db->get()->row_array();
	}
	
	function getTournamentInfo($id){
		$this->db->select("*", FALSE);
        $this->db->from('tournaments'); 
		$this->db->where('tournament_id', $id);
		
        return $this->db->get()->row_array();
	}
	
	public function getRewardInfo($id){
		$this->db->select('*', FALSE);
		$this->db->from('tbl_tournaments_fee_rewards');
		$this->db->where('fee_turnament_id', $id);
		return $this->db->get()->result_array();
	}
	
	public function updateTournamentInfo($id, $data , $section){
		
		$startTimeStamp = $data['tournament_start_date'].' '.$data['tournament_start_time'].":00";
		$endTimeStamp = $data['tournament_end_date'].' '.$data['tournament_end_time'].":59";
		
		$dataTournament=array(
			'tournament_name'=>$data['tournament_name'],
			'tournament_game_id'=>$data['tournament_game_id'],
			'tournament_gameboost_id'=>$data['tournament_gameboost_id'],
			'tournament_game_name'=>$data['tournament_game_name'],
			'tournament_game_image'=>$data['tournament_game_image'],
			'tournament_desc'=>$data['tournament_desc'],
			'tournament_type'=>$data['tournament_type'],
			'tournament_start_date'=>$data['tournament_start_date'],
			'tournament_end_date'=>$data['tournament_end_date'],
			'tournament_start_time'=>$data['tournament_start_time'],
			'tournament_end_time'=>$data['tournament_end_time'],
			'tournament_start_timestamp'=> $startTimeStamp,
			'tournament_end_timestamp'=> $endTimeStamp,		
			'tournament_reward_type'=>$data['tournament_reward_type'][0],
			'tournament_category'=>$data['tournament_category'],
			'tournament_category_id'=>$data['tournament_category_id'],
			'tournament_updated_on'=>$data['tournament_updated_on'],
			
		);
		$this->db->where('tournament_id', $id);
		$this->db->update('tbl_tournaments', $dataTournament);
		$result=$this->db->affected_rows();
		$count=0;
		foreach($data['country_id'] as $row){  
		
		if($data['tournament_reward_type'][$count]=='4'){
			
			// get the old assigned vouchers types from free_reward for voucher update
			$feeId = $data['id'][$count];
			$oldFeeVouchers = $this->db->select('*')->from('tournaments_fee_rewards')->where('fee_id', $feeId)->get()->row_array(); 
           	if(!isset($data['tournament_fee'][$count])){
              $data['tournament_fee'][$count]='0';
           	}
			$data2 = array(
				'fee_turnament_id'=> $id,
				'fee_country_id'=>$row,
				'fee_country_name'=>$data['country'][$count],
				'fee_tournament_rewards'=>$data['tournament_reward_type'][$count],
				'fee_tournament_fee'=>$data['tournament_fee'][$count],
				'fee_tournament_prize_1'=>$data['tournament_prize_1'][$count],
				'fee_tournament_prize_2'=>$data['tournament_prize_2'][$count],
				'fee_tournament_prize_3'=>$data['tournament_prize_3'][$count],
				'fee_tournament_prize_4'=>$data['tournament_prize_4'][$count],
				'fee_tournament_prize_5'=>$data['tournament_prize_5'][$count],
				'fee_tournament_prize_6'=>"",
				'fee_tournament_prize_7'=>"",
				'fee_tournament_prize_8'=>"",
				'fee_tournament_prize_9'=>"",
			);
			
			$this->db->where('fee_id' , $data['id'][$count]);
			$this->db->update('tbl_tournaments_fee_rewards', $data2);
			
			// echo "<pre>";
			// print_r($data);
			// die();
			/*	echo "<pre>";
			print_r($data);
			echo "</pre>";
			die;
			*/
			if($section['tournament_section'] == 1){ //free tournament
				
					// first remove assigned vouchers from the  tournament_voucher_detail table
					if($oldFeeVouchers['fee_tournament_prize_1'] != $data['tournament_prize_1'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_1'];
						$newVoucherType = $data['tournament_prize_1'][$count];
						for($j=1;$j<=10;$j++){
							$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank=$j);
						
							$vouchercode = $this->getdetailvoucher($data['tournament_prize_1'][$count], $limit='1');  //get the voucher by type id
							$this->updateVouchersLogs($vouchercode, $id, $section='1', $j);
						}
					}

				} elseif ($section['tournament_section'] == 2) {
					
					//for rank 1
					// echo "S_2";
					// die();
					// first remove assigned vouchers from the  tournament_voucher_detail table
					if($oldFeeVouchers['fee_tournament_prize_1'] != $data['tournament_prize_1'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_1'];
						$newVoucherType = $data['tournament_prize_1'][$count];
						$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank='1');
						
						$vouchercode_rank1 = $this->getdetailvoucher($data['tournament_prize_1'][$count], $limit='1');
						$this->updateVouchersLogs($vouchercode_rank1,  $id, $section='2', '1');
					}
					
					//for rank 2  
					if($oldFeeVouchers['fee_tournament_prize_2'] != $data['tournament_prize_2'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_2'];
						$newVoucherType = $data['tournament_prize_2'][$count];
						$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank='2');
						
						$vouchercode_rank2 = $this->getdetailvoucher($data['tournament_prize_2'][$count], $limit='1');
						$this->updateVouchersLogs($vouchercode_rank2,  $id, $section='2', '2');
					}
				   
					// for rank 3 
					if($oldFeeVouchers['fee_tournament_prize_3'] != $data['tournament_prize_3'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_3'];
						$newVoucherType = $data['tournament_prize_3'][$count];
						$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank='3');
						
						$vouchercode_rank3 = $this->getdetailvoucher($data['tournament_prize_3'][$count], $limit='1');
						$this->updateVouchersLogs($vouchercode_rank3,  $id, $section='2', '3');
					}
					
					// for rank 4 to 10 
					if($oldFeeVouchers['fee_tournament_prize_4'] != $data['tournament_prize_4'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_4'];
						$newVoucherType = $data['tournament_prize_4'][$count];
						for($j=4;$j<=10;$j++){
							$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank=$j);
							
							$vouchercode_rank4_10 = $this->getdetailvoucher($data['tournament_prize_4'][$count], $limit='1');
							$this->updateVouchersLogs($vouchercode_rank4_10,  $id, $section='2', $j);
						}
             	    }

					// for rank 11 to 50 
					if($oldFeeVouchers['fee_tournament_prize_5'] != $data['tournament_prize_5'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_5'];
						$newVoucherType = $data['tournament_prize_5'][$count];
						for($j=11;$j<=50;$j++){
							$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank=$j);
							
							$vouchercode_rank11_50 = $this->getdetailvoucher($data['tournament_prize_5'][$count], $limit='1');
							$this->updateVouchersLogs($vouchercode_rank11_50,  $id, $section='2', $j);
						}
             	    }
              	         	   
              	   
				} elseif ($section['tournament_section'] == 3) {
					//for rank 1
					// echo "S_3";
					// die();
					if($oldFeeVouchers['fee_tournament_prize_1'] != $data['tournament_prize_1'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_1'];
						$newVoucherType = $data['tournament_prize_1'][$count];
						$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank='1');
						
						$vouchercode_rank1 = $this->getdetailvoucher($data['tournament_prize_1'][$count], $limit='1');
						$this->updateVouchersLogs($vouchercode_rank1,  $id, $section='3', '1');
              	   
					}
					
				   
					//for rank 2 
					if($oldFeeVouchers['fee_tournament_prize_2'] != $data['tournament_prize_2'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_2'];
						$newVoucherType = $data['tournament_prize_2'][$count];
						$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank='2');
						
						$vouchercode_rank2 = $this->getdetailvoucher($data['tournament_prize_2'][$count], $limit='1');
						$this->updateVouchersLogs($vouchercode_rank2,  $id, $section='3', '2');
					}					
					
				   
              	    // for rank 3 
					if($oldFeeVouchers['fee_tournament_prize_3'] != $data['tournament_prize_3'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_3'];
						$newVoucherType = $data['tournament_prize_3'][$count];
						$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank='3');
						
						$vouchercode_rank3 = $this->getdetailvoucher($data['tournament_prize_3'][$count], $limit='1');
						$this->updateVouchersLogs($vouchercode_rank3,  $id, $section='3', '3');
					}
					
					if($oldFeeVouchers['fee_tournament_prize_4'] != $data['tournament_prize_4'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_4'];
						$newVoucherType = $data['tournament_prize_4'][$count];
						for($j=4;$j<=10;$j++){
							$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank=$j);
							
							$vouchercode_rank4_10 = $this->getdetailvoucher($data['tournament_prize_4'][$count], $limit='1');
							$this->updateVouchersLogs($vouchercode_rank4_10,  $id, $section='3', $j);
						}
					}

					if($oldFeeVouchers['fee_tournament_prize_5'] != $data['tournament_prize_5'][$count]){
						$oldVoucherType = $oldFeeVouchers['fee_tournament_prize_5'];
						$newVoucherType = $data['tournament_prize_5'][$count];
						
						for($j=11;$j<=20;$j++){
							$this->removeOldAssignedTournamentVouchers($id, $oldVoucherType, $newVoucherType, $rank=$j);
							
							$vouchercode_rank11_20 = $this->getdetailvoucher($data['tournament_prize_5'][$count], $limit='1');
							$this->updateVouchersLogs($vouchercode_rank11_20,  $id, $section='3', $j);
						}
             	    }
				}
			
		
		} else {
			// echo "Coin";
			// 		die();
			$data2=array(
				'fee_turnament_id'=> $id,
				'fee_country_id'=>$row,
				'fee_country_name'=>$data['country'][$count],
				'fee_tournament_rewards'=>$data['tournament_reward_type'][$count],
				'fee_tournament_fee'=>$data['tournament_fee'][$count],
				'fee_tournament_prize_1'=>0,
				'fee_tournament_prize_2'=>0,
				'fee_tournament_prize_3'=>0,
				'fee_tournament_prize_4'=>0,
				'fee_tournament_prize_5'=>0,
				'fee_tournament_prize_6'=>0,
				'fee_tournament_prize_7'=>0,
				'fee_tournament_prize_8'=>0,
				'fee_tournament_prize_9'=>0,
			);
			$this->db->where('fee_id' , $data['id'][$count]);
			$this->db->update('tbl_tournaments_fee_rewards', $data2);
		}
		$count++;
		}
		return true;
	}


function removeOldAssignedTournamentVouchers($tournamentId, $oldVoucherType, $newVoucherType, $rank){
		
		// get all tournament vouchers and assign the status 0
		$vouchersList = $this->db->select('*')->from('tournament_voucher_detail')->where(array('tv_tournament_id'=>$tournamentId, 'tv_prize_rank'=>$rank))->get()->result_array(); 
		if(is_array($vouchersList) && count($vouchersList)>0){
			foreach($vouchersList as $vRow){
				$this->db->set('voucher_status', '0', false);  // 0=NotAssigned 1=Assigned-Tournament 2=Assigned-User 3=Claimed 4=Expired   5=Deactivated
				$this->db->where('voucher_id', $vRow['tv_voucher_id']);
				$this->db->update('voucher_detail');
				
				// deduct coupon from the voucher type and update balance
				$voucherType = $this->getVoucherTypes($oldVoucherType);
				
				$vtAssignCoupons = $voucherType[0]['vt_assign_coupons'];
				$vtBalanceCoupons = $voucherType[0]['vt_balance_coupons'];
				
				$updateCoupon['vt_assign_coupons'] = ($vtAssignCoupons-1);
				$updateCoupon['vt_balance_coupons'] = ($vtBalanceCoupons+1);
				$this->db->where('vt_id', $oldVoucherType);
				$this->db->update('voucher_type', $updateCoupon);
				
				// finally update logs
				$logs['log_voucher_id'] =  $vRow['tv_voucher_id'];
				$logs['log_tournament_id'] = $tournamentId;
				$logs['log_voucher_status'] = '8';
				$logs['log_message'] = 'removed_from_tournament_and_recreated';
				$logs['log_date_time'] = date('Y-m-d H:i:s');
				$logs['log_added_on'] = time();
				$this->db->insert('voucher_logs', $logs);
				
			}
			//finally remove the voucher from tournament
			$this->db->where(array('tv_tournament_id'=>$tournamentId, 'tv_prize_rank'=>$rank));
			$this->db->delete('tournament_voucher_detail');
		}
		
	}
	

/* 
	function removeAssignedTournamentVouchers($tournamentId){
		
		// get all tournament vouchers and assign the status 0
		$vouchersList = $this->db->select('*')->from('tournament_voucher_detail')->where('tv_tournament_id', $tournamentId)->get()->result_array(); 
		if(is_array($vouchersList) && count($vouchersList)>0){
			foreach($vouchersList as $vRow){
				$this->db->set('voucher_status', '0', false);  // 0=NotAssigned 1=Assigned-Tournament 2=Assigned-User 3=Claimed 4=Expired   5=Deactivated
				$this->db->where('voucher_id', $vRow['tv_voucher_id']);
				$this->db->update('voucher_detail');
			}
		}
		
		
		//update in vouchers table
		$this->db->set('voucher_status', '1', false);  // 0=NotAssigned 1=Assigned-Tournament 2=Assigned-User 3=Claimed 4=Expired   5=Deactivated
		$this->db->where('voucher_id', $vouchercode[0]['voucher_id']);
		if($this->db->update('voucher_detail')){

			// deduct coupon from the voucher type and update balance
			$voucherType = $this->getVoucherTypes($vouchercode[0]['voucher_type_id']);
			
			$vtAssignCoupons = $voucherType[0]['vt_assign_coupons'];
			$vtBalanceCoupons = $voucherType[0]['vt_balance_coupons'];
			$updateCoupon['vt_assign_coupons'] = ($vtAssignCoupons+1);
			$updateCoupon['vt_balance_coupons'] = ($vtBalanceCoupons-1);
			$this->db->where('vt_id', $voucherType[0]['vt_id']);
			$this->db->update('voucher_type', $updateCoupon);
			
			// finally update logs
			$logs['log_voucher_id'] =  $vouchercode[0]['voucher_id'];
			$logs['log_tournament_id'] = $tournamentId;
			$logs['log_voucher_status'] = '1';
			$logs['log_message'] = 'assigned_to_tournament';
			$logs['log_date_time'] = date('Y-m-d H:i:s');
			$logs['log_added_on'] = time();
			$this->db->insert('voucher_logs', $logs);
		}    

	}
	

 */

	function getPublishedGamesList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		if(!empty($id))		
			$this->db->where('id', $id);
		//$this->db->where('IsPublished', 'YES');
		//$this->db->or_where('IsPublished', 'Yes');
		$this->db->where('portalPublished', '1');
		$this->db->order_by('Name', 'ASC');
        return $this->db->get()->result_array();
	}
	
	function getPTGamesList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		if(!empty($id))		
			$this->db->where('id', $id);
		//$this->db->where('IsPublished', 'YES');
		//$this->db->or_where('IsPublished', 'Yes');
		$this->db->where('private_tournament', '1');
		$this->db->order_by('Name', 'ASC');
        return $this->db->get()->result_array();
	}
	
	function getQuickTournamnetGamesList(){
		$this->db->select("*", FALSE);
        $this->db->from('quick_tournaments'); 
		 $this->db->join('games','games.gid = quick_tournaments.quick_gid','left'); 
        return $this->db->get()->result_array();
	}
	
	function checkQuickTournamnetGame($gid, $gameboost_id){
		$this->db->select("count(*) as no_rows", FALSE);
        $this->db->from('quick_tournaments'); 
        $this->db->where('quick_gid', $gid); 
        $this->db->where('quick_gameboost_id', $gameboost_id); 
		return $this->db->get()->row_array();
	}
	
	function getQuickTournamnetGameRows(){
		$this->db->select("count(*) as no_rows", FALSE);
        $this->db->from('quick_tournaments'); 
		return $this->db->get()->row_array();
	}
	
	
	function getSuggestedGamesList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		if(!empty($id))		
			$this->db->where('id', $id);
		$this->db->where('IsSuggested', '1');
		//$this->db->where('IsPublished', 'yes');
		$this->db->where('portalPublished', '1');		
		$this->db->order_by('Name', 'ASC');
		
        return $this->db->get()->result_array();
	}
	
	function getTopGamesList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		if(!empty($id))		
			$this->db->where('id', $id);
		$this->db->where('IsTop', '1');
		//$this->db->where('IsPublished', 'yes');
		$this->db->where('portalPublished', '1');
		$this->db->order_by('Name', 'ASC');
		
        return $this->db->get()->result_array();
	}
	function checkExistingTournament($section , $date)
	{
		$this->db->select('*');
		$this->db->from('tournaments');
		$this->db->where('tournament_section' , $section);
		$this->db->where('tournament_start_date' , $date);
		$result = $this->db->get()->num_rows();
		if($result)
			return true;
		else 
		return false;
	}
	function getGenreGamesList($type){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		$this->db->where("portalCategory like '%$type%' ");
		$this->db->where('portalPublished', '1');
		$this->db->order_by('Name', 'ASC');
		
        return $this->db->get()->result_array();
	}
	
	function getSpinWheelSections(){
		$this->db->select("*", FALSE);
        $this->db->from('spinwheel_data'); 
		$this->db->order_by('wheel_seq', 'ASC');
        return $this->db->get()->result_array();
	}
	
	
	function getdetailvoucher($id, $limit){
		$this->db->select("*", FALSE);
        $this->db->from('voucher_detail'); 
        $this->db->where('voucher_type_id', $id); 
        $this->db->where('voucher_status', 0); 
        $this->db->order_by('voucher_id', 'asc'); 
        $this->db->limit($limit); 
        return $this->db->get()->result_array();
        
	}
	
	function getVoucherTypeByAmount($type){
		$this->db->select("*", FALSE);
        $this->db->from('voucher_type'); 
		$this->db->where("vt_type", $type);
        return $this->db->get()->row_array();
	}
	
	function getVoucherTypes($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('voucher_type'); 
        if($id){
			$this->db->where('vt_id', $id); 	
        }
        return $this->db->get()->result_array();
	}
	
	
/*
	function getVoucherSections($id=''){
		$this->db->select("*,voucher_detail.voucher_id", FALSE);
        $this->db->from('voucher_detail'); 
        if($id){
        $this->db->where('voucher_detail.voucher_id',$id); 	
        }
        $this->db->where('voucher_detail.status',1);
        //$this->db->where('voucher_type.balance_coupon > 0');
        $this->db->join('voucher_type','voucher_detail.voucher_typeid = voucher_type.vt_id','left');
        $this->db->join('tbl_tournament_voucher_detail', 'tbl_voucher_detail.voucher_id = tbl_tournament_voucher_detail.voucher_id', 'left'); 
        $this->db->join('tbl_tournaments', 'tbl_tournament_voucher_detail.tournament_id = tbl_tournaments.tournament_id', 'left'); 
        $this->db->join('tbl_site_users', 'tbl_site_users.user_id = tbl_tournament_voucher_detail.user_id', 'left'); 
		$this->db->order_by('voucher_detail.voucher_id', 'ASC');
        return $this->db->get()->result_array();
        
	}
*/

	function getVouchersList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('voucher_detail'); 
        if($id){
			$this->db->where('voucher_id', $id); 	
        }
		$this->db->join('voucher_type','voucher_detail.voucher_type_id = voucher_type.vt_id','left');
        $this->db->join('tournament_voucher_detail', 'voucher_detail.voucher_id = tournament_voucher_detail.tv_voucher_id', 'left'); 
        $this->db->join('tournaments', 'tournament_voucher_detail.tv_tournament_id = tournaments.tournament_id', 'left'); 
        $this->db->group_by('voucher_detail.voucher_id');
        return $this->db->get()->result_array();
        
	}

	function getdistinctvoucherSections(){
		$this->db->select("*", FALSE);
        $this->db->from('voucher_type');
        $this->db->where('status',1);
        return $this->db->get()->result_array();
	}

	function getvoucherTypeBalance($id){
		$this->db->select("*", FALSE);
        $this->db->from('voucher_type');
        $this->db->where('status',1);
        $this->db->where('vt_id',$id);
        return $this->db->get()->row_array();
	}
	
	function getvoucherSectionsByCount($count){
		$this->db->select("*", FALSE);
        $this->db->from('voucher_type');
        $this->db->where('vt_status',1);
        $result = $this->db->get()->result_array();
        $resultArray = array();
        foreach($result as $row){
			$countVoucher = $this->getDistinctVoucherSectionsByCount($count, $row['vt_id']);
        	if(!empty($countVoucher)){
        	  	$resultArray[] = $row;
            }
         }
        return $resultArray;
	}
	function getvoucherSectionsByCountEdit($count, $voucherId, $tournamentId){
		$this->db->select("*", FALSE);
        $this->db->from('voucher_type');
        $this->db->where('vt_status', 1);
        $result = $this->db->get()->result_array();
        $resultArray = array();
       
      	  $query = $this->db->query("SELECT * from tbl_voucher_type Where vt_id = '$voucherId'")->row_array();
          $assigendresultArray[] = $query;

	    //  echo "<pre>";
		//	print_r($resultArray);
		//	echo "</pre>";
		//	die;
			
        foreach($result as $row){
			//$countVoucher = $this->getDistinctVoucherSectionsByCount($count, $row['vt_id']);
			$countVoucher = $this->getDistinctVoucherSectionsByCountEdit($count, $row['vt_id'], $tournamentId);
        	if(!empty($countVoucher)){
				$resultArray[] = $row;
				 
				
            }
        }

        return $resultArray;
	}

	function getDistinctVoucherSectionsByCount($count,$vouchertypeid){
		$query = $this->db->query("SELECT * from tbl_voucher_detail Where voucher_type_id = '$vouchertypeid' and voucher_status=0");
		if($query->num_rows()>=$count){
			$list = $query->result_array();
			return $list;
		}else{
         return array();
		}     
	}

	
	function getDistinctVoucherSectionsByCountEdit($count, $vouchertypeid){
		$query = $this->db->query("SELECT * from tbl_voucher_detail Where voucher_type_id = '$vouchertypeid' and voucher_status IN ('0','1')");
		if($query->num_rows()>=$count){
			$list = $query->result_array();
			return $list;
		}else{
         return array();
		}     
	}

	
	
	function getPractiseBannersList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('practise_banners'); 
        $this->db->join('games','games.gid = practise_banners.banner_game_id','left'); 
		return $this->db->get()->result_array();
	}
	
	function getPractiseBannersInfo($id){
		$this->db->select("*", FALSE);
        $this->db->from('practise_banners'); 
        $this->db->where('banner_id', $id); 
		return $this->db->get()->row_array();
	}
	
	function getPortalSettings(){
		$this->db->select("*", FALSE);
        $this->db->from('portal_settings'); 
		return $this->db->get()->result_array();
	}
	
	function getRedemptionsList(){
		$this->db->select("*", FALSE);
        $this->db->from('redemption_settings'); 
        $this->db->order_by('redeem_type','ASC'); 
		return $this->db->get()->result_array();
	}
	
	###################################################################################################
	###################################### Tournament Report Section ##################################
	###################################################################################################

	function getTournamentList($filter, $stat_month = '', $stat_year= '')
	{	
		$this->db->select("tournament_id, tournament_name, tournament_start_date, tournament_start_time, tournament_end_date,  tournament_end_time, count(player_t_id) as total_players, count(player_t_id) as total_players", FALSE);
	    $this->db->from('tournaments');
		$this->db->where('tournament_section',1); 
        $this->db->join('tournaments_players', 'tournaments_players.player_t_id = tournaments.tournament_id','left'); 
		if($filter == '1'){
			$date = date('Y-m-d',strtotime("-1 days"));
			$this->db->where('DATE(tournament_start_date)', DATE($date));		
		} else if($filter == '7'){
			$startDate =  date('Y-m-d', strtotime('-7 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND  DATE('$endDate') ");	
		} else if($filter == '15'){
			$startDate =  date('Y-m-d', strtotime('-15 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND  DATE('$endDate') ");	
		} else if($filter == '30'){
			$startDate =  date('Y-m-d', strtotime('-30 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND DATE('$endDate') ");	
		} else if($filter == 'month'){			
			$this->db->where(" '$stat_year' = year(tournament_start_date)");		
			$this->db->where(" '$stat_month' = month(tournament_start_date)"); 
		} else if($filter == 'all'){
			$today = date('Y-m-d');
			$this->db->where("tournament_start_date <= '$today' ");
		}
		$this->db->group_by("tournament_id");
		$this->db->order_by("tournament_start_date",'DESC');
        return $this->db->get()->result_array();
	}

	function getPremiumTournamentList($filter, $stat_month = '', $stat_year= ''){
		$this->db->select("tournament_id, tournament_name, tournament_start_date, tournament_start_time, tournament_end_date,  tournament_end_time, count(player_t_id) as total_players, count(player_t_id) as total_players", FALSE);
	    $this->db->from('tournaments');
		$this->db->where('tournament_section !=',1); 
        $this->db->join('tournaments_players', 'tournaments_players.player_t_id = tournaments.tournament_id','left'); 
		if($filter == '1'){
			$date = date('Y-m-d',strtotime("-1 days"));
			$this->db->where('DATE(tournament_start_date)', DATE($date));		
		} else if($filter == '7'){
			$startDate =  date('Y-m-d', strtotime('-7 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND  DATE('$endDate') ");	
		} else if($filter == '15'){
			$startDate =  date('Y-m-d', strtotime('-15 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND  DATE('$endDate') ");	
		} else if($filter == '30'){
			$startDate =  date('Y-m-d', strtotime('-30 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND DATE('$endDate') ");	
		} else if($filter == 'month'){			
			$this->db->where(" '$stat_year' = year(tournament_start_date)");		
			$this->db->where(" '$stat_month' = month(tournament_start_date)"); 
		} else if($filter == 'all'){
			$today = date('Y-m-d');
			$this->db->where("tournament_start_date <= '$today' ");
		}
		$this->db->group_by("tournament_id");
		$this->db->order_by("tournament_start_date",'DESC');
        return $this->db->get()->result_array();
	}
	
	function getTournamentsFilterList($filter, $stat_month = '', $stat_year= '')
	{
		$this->db->select("*", FALSE);
	    $this->db->from('tournaments'); 
		$this->db->where('tournament_section',1);
		if($filter == '1'){
			$date = date('Y-m-d',strtotime("-1 days"));
			$this->db->where('DATE(tournament_start_date)', DATE($date));		
		
		} else if($filter == '7'){
			$startDate =  date('Y-m-d', strtotime('-7 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND  DATE('$endDate') ");	
		
		} else if($filter == '15'){
			$startDate =  date('Y-m-d', strtotime('-15 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND  DATE('$endDate') ");	
		
		} else if($filter == '30'){
			$startDate =  date('Y-m-d', strtotime('-30 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND DATE('$endDate') ");	
		
		
		} else if($filter == 'month'){			
			$this->db->where(" '$stat_year' = year(tournament_start_date)");		
			$this->db->where(" '$stat_month' = month(tournament_start_date)"); 
		
		} else if($filter == 'all'){
			$today = date('Y-m-d');
			$this->db->where("tournament_start_date <= '$today' ");
		}
		$this->db->group_by("tournament_id");
		$this->db->order_by("tournament_start_date",'DESC');
		
        return $this->db->get()->result_array();
	}
	function getPremiumTournamentsFilterList($filter, $stat_month = '', $stat_year= '')
	{
		$this->db->select("*", FALSE);
	    $this->db->from('tournaments'); 
		$this->db->where('tournament_section !=',1);
		if($filter == '1'){
			$date = date('Y-m-d',strtotime("-1 days"));
			$this->db->where('DATE(tournament_start_date)', DATE($date));		
		
		} else if($filter == '7'){
			$startDate =  date('Y-m-d', strtotime('-7 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND  DATE('$endDate') ");	
		
		} else if($filter == '15'){
			$startDate =  date('Y-m-d', strtotime('-15 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND  DATE('$endDate') ");	
		
		} else if($filter == '30'){
			$startDate =  date('Y-m-d', strtotime('-30 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND DATE('$endDate') ");	
		
		
		} else if($filter == 'month'){			
			$this->db->where(" '$stat_year' = year(tournament_start_date)");		
			$this->db->where(" '$stat_month' = month(tournament_start_date)"); 
		
		} else if($filter == 'all'){
			$today = date('Y-m-d');
			$this->db->where("tournament_start_date <= '$today' ");
		}
		$this->db->group_by("tournament_id");
		$this->db->order_by("tournament_start_date",'DESC');
		
        return $this->db->get()->result_array();
	}
	
	function getTournamentsListDateRange($startDate, $endDate)
	{	
		$this->db->select("tournament_id, tournament_name, tournament_start_date, tournament_start_time, tournament_end_date,  tournament_end_time, count(player_t_id) as total_players, count(player_t_id) as total_players", FALSE);
	    $this->db->from('tournaments'); 
		$this->db->where('tournament_section',1);
        $this->db->join('tournaments_players', 'tournaments_players.player_t_id = tournaments.tournament_id','left'); 
		
		$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND DATE('$endDate') ");	
		
		$this->db->group_by("tournament_id");
		$this->db->order_by("tournament_start_date",'DESC');
		
        return $this->db->get()->result_array();
	}

	function getPremiumTournamentsListDateRange($startDate, $endDate)
	{	
		$this->db->select("tournament_id, tournament_name, tournament_start_date, tournament_start_time, tournament_end_date,  tournament_end_time, count(player_t_id) as total_players, count(player_t_id) as total_players", FALSE);
	    $this->db->from('tournaments'); 
		$this->db->where('tournament_section !=',1);
        $this->db->join('tournaments_players', 'tournaments_players.player_t_id = tournaments.tournament_id','left'); 
		
		$this->db->where("DATE(tournament_start_date) BETWEEN DATE('$startDate') AND DATE('$endDate') ");	
		
		$this->db->group_by("tournament_id");
		$this->db->order_by("tournament_start_date",'DESC');
		
        return $this->db->get()->result_array();
	}

	function getTournamentsInfo($id){
		$today = date('Y-m-d');
		$this->db->select("*", FALSE);
        $this->db->from('tournaments'); 
		$this->db->where('tournament_id', $id);
        return $this->db->get()->row_array();
	}
	function getTournamentsInfoFeeRewards($id){
		$today = date('Y-m-d');
		$this->db->select("*", FALSE);
        $this->db->from('tournaments'); 
		$this->db->where('tournament_id', $id);
		$this->db->join('tbl_tournaments_fee_rewards', 'tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id', 'left');
        return $this->db->get()->row_array();
	}
	
	function getLiveTournamentPlayersDESC($id){
		$this->db->select("*", FALSE);
		$this->db->from('tournaments_players');
		$this->db->where('player_t_id', $id);
		$this->db->join('site_users', 'site_users.user_id = tournaments_players.player_user_id', 'left');
		$this->db->order_by('player_score', 'desc');
		$this->db->order_by('player_score_updated', 'asc');
	    return $this->db->get()->result_array();
	}

	function getTournamentPlayerPlayStats($id){
		return $this->db->query("
		SELECT user_phone, user_full_name, sum(report_tournament_counts) as total_rows,  sum(report_tournament_practice_counts) as total_practice_rows, t1.report_last_updated FROM tbl_report_game_play t1
		INNER JOIN (SELECT report_id, MAX(report_last_updated) report_last_updated FROM tbl_report_game_play WHERE report_tournament_id = '$id' GROUP BY report_id ORDER BY report_last_updated DESC) t2
		ON t1.report_id = t2.report_id 
		
		LEFT JOIN tbl_site_users ON tbl_site_users.user_id = t1.report_user_id
		WHERE report_tournament_id = '$id'
		GROUP BY report_user_id
		ORDER BY t2.report_last_updated ASC
		")->result_array();
		
	}
	###################################################################################################
	############################## End Tournament Report Section ######################################
	###################################################################################################
	function getVoucherNearExpiration()
	{
		$this->db->select('*', FALSE);
		$this->db->from('tbl_voucher_detail');
		$this->db->where('voucher_status' , 6);
		$this->db->join('tbl_voucher_type' , 'tbl_voucher_type.vt_id = tbl_voucher_detail.voucher_type_id ');
		return $this->db->get()->result_array();
	}
	function getInstantPlayedGames_0()
	{
		$this->db->select('tbl_event_capture.* , site_users.user_phone ,tbl_games.Name ', FALSE);
		$this->db->from('tbl_event_capture');
		$this->db->where('event_name' , 'play_instant_games');
		$this->db->where('event_function' ,'eventExecute');
		$this->db->where('event_game_id != 0');
		$this->db->join('site_users', 'site_users.user_id = tbl_event_capture.user_id', 'left');
		$this->db->join('tbl_games', 'tbl_games.gid = tbl_event_capture.event_game_id', 'left');
		$result =$this->db->get()->result_array();
		return $result;
	}

	// function getInstantGameFilterList($filter, $stat_month = '', $stat_year= '')
	// {
		
	// 	$this->db->select("*", FALSE);
	//     $this->db->from('tbl_report_game_play'); 
	// 	$this->db->where('report_practice_counts!=0');
	// 	if($filter == '1'){
	// 		$date = date('Y-m-d',strtotime("-1 days"));
	// 		$this->db->where('DATE(report_date)', DATE($date));		
		
	// 	} else if($filter == '7'){
	// 		$startDate =  date('Y-m-d', strtotime('-7 days'));
	// 		$endDate = date('Y-m-d', strtotime('-1 days'));
	// 		$this->db->where("DATE(report_date) BETWEEN DATE('$startDate') AND  DATE('$endDate') ");	
		
	// 	} else if($filter == '15'){
	// 		$startDate =  date('Y-m-d', strtotime('-15 days'));
	// 		$endDate = date('Y-m-d', strtotime('-1 days'));
	// 		$this->db->where("DATE(report_date) BETWEEN DATE('$startDate') AND  DATE('$endDate') ");	
		
	// 	} else if($filter == '30'){
	// 		$startDate =  date('Y-m-d', strtotime('-30 days'));
	// 		$endDate = date('Y-m-d', strtotime('-1 days'));
	// 		$this->db->where("DATE(report_date) BETWEEN DATE('$startDate') AND DATE('$endDate') ");	
		
		
	// 	} else if($filter == 'month'){			
	// 		$this->db->where(" '$stat_year' = year(report_date)");		
	// 		$this->db->where(" '$stat_month' = month(report_date)"); 
		
	// 	} else if($filter == 'all'){
	// 		$today = date('Y-m-d');
	// 		$this->db->where("report_date <= '$today' ");
	// 	}
	// 	$this->db->join('tbl_site_users', 'tbl_site_users.user_id = tbl_report_game_play.report_user_id', 'left');
	// 	$this->db->join('tbl_games', 'tbl_games.id = tbl_report_game_play.report_game_id', 'left');
    //     return $this->db->get()->result_array();
	// }








	function getInstantPlayedGames()
	{
		$this->db->select('*' , FALSE);
		$this->db->from('tbl_report_game_play');
		$this->db->where('report_practice_counts!=0');
		$this->db->join('tbl_site_users', 'tbl_site_users.user_id = tbl_report_game_play.report_user_id', 'left');
		$this->db->join('tbl_games', 'tbl_games.id = tbl_report_game_play.report_game_id', 'left');
		$result	=	$this->db->get()->result_array();
		return $result;
	}
	// function getUserPlayCount($data)
	// {
	// 	if(is_array($data) && count($data)>0){
	// 	foreach($data as $row)
	// 	{
	// 		$this->db->distinct();
	// 		$this->db->select('count(user_id)');
	// 		$this->db->from('tbl_event_capture');
	// 		$this->db->where('event_game_id' , $row['event_game_id']);
	// 		$this->db->where('user_id', $row['user_id']);
	// 		$result = $this->db->get()->num_rows();
	// 		$data2[] = $result;
	// 	}
	// 		return $data2;
	// 	}
	// 	else{
	// 		return false;
	// 	}
	// }
	
	function getTournamentVoucherDetails($id)
	{
		$this->db->select('*', FALSE);
		$this->db->from('tbl_tournament_voucher_detail');
		$this->db->where('tv_tournament_id', $id);
		$this->db->join('tbl_voucher_detail', 'tbl_voucher_detail.voucher_id = tbl_tournament_voucher_detail.tv_voucher_id', 'left');
		$this->db->join('tbl_voucher_type', 'tbl_voucher_type.vt_id = tbl_voucher_detail.voucher_type_id', 'left');
		$result = $this->db->get()->result_array();
		return $result;
	}
	function getTournamentSection($id)
	{
		$this->db->select('tournament_section');
		$this->db->where('tournament_id', $id);
		$result=$this->db->get('tbl_tournaments')->result_array();
		return $result[0];
		// die();
	}
	function getDailyReport()
	{
		$date = date("Y-m-d");
		$this->db->select('*' , FALSE);
		$this->db->from('tbl_report_game_play');
		$this->db->where('report_date' , $date);
		$this->db->join('tbl_site_users', 'tbl_site_users.user_id = tbl_report_game_play.report_user_id', 'left');
		$this->db->join('tbl_tournaments', 'tbl_tournaments.tournament_id = tbl_report_game_play.report_tournament_id', 'left');
		$this->db->join('tbl_games', 'tbl_games.id = tbl_report_game_play.report_game_id', 'left');
		$result	=	$this->db->get()->result_array();
		return $result;
	}
	function getDailyTournamentReport()
	{
		$date = date("Y-m-d");
		$this->db->select('*' , FALSE);
		$this->db->from('tbl_report_game_play');
		$this->db->where('report_date' , $date);
		$this->db->where('report_tournament_id != 0');
		$this->db->join('tbl_site_users', 'tbl_site_users.user_id = tbl_report_game_play.report_user_id', 'left');
		$this->db->join('tbl_tournaments', 'tbl_tournaments.tournament_id = tbl_report_game_play.report_tournament_id', 'left');
		$this->db->join('tbl_games', 'tbl_games.id = tbl_report_game_play.report_game_id', 'left');
		return $result	=	$this->db->get()->result_array();
	}
	function getFreeGamesStats(){
		$this->db->select("report_date, report_game_id, sum(report_practice_counts) as total_game_plays, count(distinct(report_user_id)) as unique_plays, games.Name ", FALSE);
        $this->db->from('report_game_play'); 
		$this->db->join("games", 'games.id = report_game_play.report_game_id', 'left');
		$this->db->where("report_practice_counts > 0");
		$this->db->group_by("report_game_id");
		$this->db->order_by("report_date", 'desc');
        return $this->db->get()->result_array();
	}

	function getFreeGamesTotalGP(){
		$this->db->select("sum(report_practice_counts) as total_game_plays, count(distinct(report_user_id)) as unique_plays", FALSE);
        $this->db->from('report_game_play'); 
		$this->db->where("report_practice_counts > 0");
		return $this->db->get()->row_array();
	}
	function getFreeGameTotalGP(){
		$this->db->select("sum(report_practice_counts) as total_game_plays, count(distinct(report_user_id)) as unique_plays", FALSE);
        $this->db->from('report_game_play'); 
		$this->db->where("report_practice_counts > 0");
		return $this->db->get()->row_array();
	}
	function getFreeGamesStatsDatewise($game_id, $filter, $stat_month = '', $stat_year= ''){
		$this->db->select("report_date, sum(report_practice_counts) as total_game_plays, count(distinct(report_user_id)) as unique_plays, games.Name ", FALSE);
        $this->db->from('report_game_play'); 
		$this->db->join("games", 'games.id = report_game_play.report_game_id', 'left');
		$this->db->where('report_game_id', $game_id);
		$this->db->where("report_practice_counts > 0");
		if($filter == '1'){
			$date = date('Y-m-d',strtotime("-1 days"));
			$this->db->where('report_date', $date);		
		
		} else if($filter == '7'){
			$startDate =  date('Y-m-d', strtotime('-7 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("report_date BETWEEN '$startDate' AND  '$endDate' ");	
		
		} else if($filter == '15'){
			$startDate =  date('Y-m-d', strtotime('-15 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("report_date BETWEEN '$startDate' AND '$endDate' ");	
		
		} else if($filter == '30'){
			$startDate =  date('Y-m-d', strtotime('-30 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("report_date BETWEEN '$startDate' AND '$endDate' ");	
		
		
		} else if($filter == 'month'){			
			$this->db->where(" '$stat_year' = year(report_date)");		
			$this->db->where(" '$stat_month' = month(report_date)"); 
		}	
		
		$this->db->group_by("report_date");
		$this->db->order_by("report_date", 'desc');
		
        return $this->db->get()->result_array();
	}
	
	
	function getFreeGamesStatsDateRange($game_id, $startDate, $endDate){
		$this->db->select("report_date, sum(report_practice_counts) as total_game_plays, count(distinct(report_user_id)) as unique_plays, games.Name ", FALSE);
        $this->db->from('report_game_play'); 
		$this->db->join("games", 'games.id = report_game_play.report_game_id', 'left');
		$this->db->where('report_game_id', $game_id);
		$this->db->where("report_practice_counts > 0");
		$this->db->where("report_date BETWEEN '$startDate' AND  '$endDate' ");	
		
		$this->db->group_by("report_date");
		$this->db->order_by("report_date", 'desc');
		
        return $this->db->get()->result_array();
	}
	function getFreeGameDateRangeGP($game_id, $startDate, $endDate){
		$this->db->select("sum(report_practice_counts) as total_game_plays, count(distinct(report_user_id)) as unique_plays", FALSE);
        $this->db->from('report_game_play'); 
		$this->db->where("report_practice_counts > 0");
		$this->db->where('report_game_id', $game_id);
		$this->db->where("report_date BETWEEN '$startDate' AND  '$endDate' ");	
		
		return $this->db->get()->row_array();
		
	}
	
	
	function getUserRegistered($filter, $stat_month = '', $stat_year= ''){
		$this->db->select("sum(user_subscription) as subscribed ,count(distinct(user_id)) as total_users ,DATE(user_registered_on) as date ", FALSE);
        $this->db->from('tbl_site_users'); 
		$this->db->where("DATE(user_registered_on) >= '2022-02-01' ");
		if($filter == '1'){
			$date = date('Y-m-d',strtotime("-1 days"));
			$this->db->where('DATE(user_registered_on)', $date);		
		
		} else if($filter == '7'){
			$startDate =  date('Y-m-d', strtotime('-7 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(user_registered_on) BETWEEN '$startDate' AND  '$endDate' ");	
		
		} else if($filter == '15'){
			$startDate =  date('Y-m-d', strtotime('-15 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(user_registered_on) BETWEEN '$startDate' AND '$endDate' ");	
		
		} else if($filter == '30'){
			$startDate =  date('Y-m-d', strtotime('-30 days'));
			$endDate = date('Y-m-d', strtotime('-1 days'));
			$this->db->where("DATE(user_registered_on) BETWEEN '$startDate' AND '$endDate' ");	
		
		
		} else if($filter == 'month'){			
			$this->db->where(" '$stat_year' = year(DATE(user_registered_on))");		
			$this->db->where(" '$stat_month' = month(DATE(user_registered_on))"); 
		}	
		
		$this->db->group_by("DATE(user_registered_on)");
		$this->db->order_by("DATE(user_registered_on)", 'desc');
		return $this->db->get()->result_array();
        // return $this->db->last_query();
	}
	function getUserRegisteredRange($startDate, $endDate){
		$this->db->select("sum(user_subscription) as subscribed ,count(user_full_name) as total_users ,DATE(user_registered_on) as date ", FALSE);
        $this->db->from('tbl_site_users'); 
		$this->db->where("DATE(user_registered_on) BETWEEN '$startDate' AND  '$endDate' ");	
		
		$this->db->group_by("DATE(user_registered_on)");
		$this->db->order_by("DATE(user_registered_on)", 'desc');
		
        return $this->db->get()->result_array();
	}
	function getUserPlayStats($date)
	{
		$this->db->select('*');
		$this->db->from('tbl_site_users'); 
		$this->db->where("DATE(user_registered_on)" , $date);
		return $this->db->get()->result_array();
		// return $this->db->last_query();
	}
	function getVoucherLogs($id)
	{
		$this->db->select('*' , FALSE);
		$this->db->from('tbl_voucher_logs');
		$this->db->where('log_voucher_id' , $id);
		$this->db->join("tournaments", 'tournaments.tournament_id = tbl_voucher_logs.log_tournament_id', 'left');
		$this->db->join("site_users", 'site_users.user_id = tbl_voucher_logs.log_user_id', 'left');
		$result = $this->db->get()->result_array();
		return $result;
		
	}
}  

?>
