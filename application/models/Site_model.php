<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_model extends CI_Model {

	 function __construct(){
		parent::__construct();
	}

	function getPortalSettings(){
		$this->db->select("*", FALSE);
        $this->db->from('portal_settings'); 
		return $this->db->get()->result_array();
	}
	
	function signup_name($data){
        $this->db->where('user_id', $data['id']);
        $this->db->update('site_users', array('user_full_name' => $data['name']));
	}

	function signup_insert(){
		$email = trim($this->input->post('user_email'));
		$phone = trim($this->input->post('user_phone'));
		$password = trim($this->input->post('user_password'));
		$data = array(
        'user_email'=>$email,
        'user_phone'=>$phone,
        'user_password'=>$password,
        'user_type'=>'2',
		'user_image'=>'default.png',
		'user_play_coins'=>'50000',
        'skillpod_nickname'=>'nisha-1',
        'skillpod_password'=>'utaz6r$nlohm',
        'skillpod_object_id'=>'1629476869',
        'skillpod_player_id'=>'2',
        'skillpod_player_key'=>'8b420af2-6781-4a91-9af8-218ad4202618',
        'user_registered_on'=>date('Y-m-d H:i:s'),
        'user_last_login'=>date('Y-m-d H:i:s'),
        'user_added_on'=>time(),
        'user_updated_on'=>time(),
    );

    $this->db->insert('site_users',$data);
    $insertId = $this->db->insert_id();
   return  $insertId;
	}

	function signup_checkmail(){
		$email = trim($this->input->post('user_email'));
    $phone = trim($this->input->post('user_phone'));
     $password = trim($this->input->post('user_password'));
        $this->db->select("*", FALSE);
		$this->db->where('user_email', $email);
		
		$result=$this->db->get('site_users');
		   if($result->num_rows()>0){
            return 1;
		   }else{
              $this->db->select("*", FALSE);
		      $this->db->where('user_phone', $phone);
		      $result1=$this->db->get('site_users');
		        if($result1->num_rows()>0){
                 return 2;
		        }else{
                 return 0;
		        }
		   }
	}

	function LoginAccessUpdate($id){
		$this->db->where('uniqid', $id);
        $this->db->update('user_login_access_logs', array('access_status' => 1));

	}

	function validateUser($id){
		$this->db->select("*", FALSE);
		$this->db->from('site_users');
		$this->db->where('user_id', $id);
		 return $this->db->get()->row_array();
	}

	function tournamentlist(){
		$this->db->select("*", FALSE);
		$this->db->from('site_users');
		$this->db->where('user_id', $id);
		 return $this->db->get()->row_array();
	}

	function verifyUserDetails($phone, $password){
		$this->db->select("*", FALSE);
		$this->db->from('site_users');
		$this->db->where('user_phone', $phone);
		$this->db->where('user_password', $password);
		 return $this->db->get()->row_array();
	}

	function getSiteUserDetail($id=''){
		$this->db->select("*", FALSE);
		$this->db->from('site_users');
		if(!empty($id))
			$this->db->where('user_id', $id);
		 return $this->db->get()->row_array();
	}


	function checkUserByEmail($email){
		$this->db->select("*", FALSE);
		$this->db->from('site_users');
		$this->db->where('user_email', $email);
		return $this->db->get()->row_array();
	}

	function getGamesList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('games');
		if(!empty($id))
			$this->db->where('id', $id);
		//$this->db->limit('30');
		 return $this->db->get()->result_array();
	}

	function getPublishedGamesList($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('games');
		if(!empty($id))
			$this->db->where('id', $id);
		//$this->db->where('IsPublished', 'YES');
		$this->db->where('portalPublished', '1');
		
        return $this->db->get()->result_array();
	}

	function getPublishedPTGames($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('games');
		if(!empty($id))
			$this->db->where('id', $id);
		$this->db->where('IsPublished', 'YES');
		$this->db->where('private_tournament', '1');
		$this->db->order_by('Name', 'ASC');
        return $this->db->get()->result_array();
	}

	function getGameInfo($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('games');
		if(!empty($id))
			$this->db->where('gid', $id);
		//$this->db->where('IsPublished', 'YES');
		$this->db->where('portalPublished', '1');
        return $this->db->get()->row_array();
	}

	function getGameboostGameInfo($id=''){
		$this->db->select("*", FALSE);
        $this->db->from('games');
		if(!empty($id))
			$this->db->where('id', $id);
		$this->db->where('portalPublished', '1');
        return $this->db->get()->row_array();
	}

	function getSiteUserLiveTournament($user_id){
		$today = date('Y-m-d');
		$this->db->select("user_tournaments.*, user_tournament_players.*", FALSE);
        $this->db->from('user_tournaments');
		$this->db->where('player_user_id', $user_id);
		$this->db->where("t_start_date <= '$today' ");
		$this->db->where("t_end_date >= '$today' ");
		$this->db->join('user_tournament_players', 'user_tournament_players.player_t_id = user_tournaments.t_id', 'left');
        $this->db->group_by('t_id');
        $this->db->order_by('t_id','desc');
        $this->db->limit('1');
		return $this->db->get()->row_array();
	}

	function getUserTournamentsList__1($user_id){
		$this->db->select("tournaments.*, tbl_tournaments_players.player_id,tbl_tournaments_players.player_reward_rank,tbl_tournaments_players.player_reward_prize,tbl_tournaments_players.redeem_prize,tbl_tournaments_players.redeem_expiry_date, tbl_tournaments_players.prize_claimed_date, count(tbl_tournaments_players.player_id) as no_players ", FALSE);
        $this->db->from('tournaments');
		$this->db->where('tbl_tournaments_players.player_user_id', $user_id);
		//$this->db->or_where('tournaments_players.player_user_id', $user_id);
		$this->db->join('tournaments_players', 'tournaments_players.player_t_id = tournaments.tournament_id', 'left');
        $this->db->group_by('tournaments_players.player_t_id');
        $this->db->order_by('tournaments_players.player_t_id','desc');
		return $this->db->get()->result_array();
	}
	
	function getUserTournamentsList___0($user_id){
		$today = date('Y-m-d');
		$this->db->select("tournaments.*, tbl_tournaments_players.player_id,tbl_tournaments_players.player_reward_rank,tbl_tournaments_players.player_reward_prize,tbl_tournaments_players.redeem_prize,tbl_tournaments_players.redeem_expiry_date, tbl_tournaments_players.prize_claimed_date, tbl_tournaments_players.prize_voucher_id,count(tbl_tournaments_players.player_id) as no_players ", FALSE);
        $this->db->from('tournaments');
	//	$this->db->where('tbl_tournaments_players.player_user_id', $user_id);
	//	$this->db->where('tbl_tournaments_players.player_reward_rank != 0');
	//	$this->db->where("tournament_end_date < '$today' ");
		//$this->db->or_where('tournaments_players.player_user_id', $user_id);
		$this->db->join('tournaments_players', 'tournaments_players.player_t_id = tournaments.tournament_id', 'left');
        $this->db->group_by('tournaments_players.player_t_id');
        $this->db->order_by('tournaments_players.player_t_id','desc');
		return $this->db->get()->result_array();
	}
	
	function getUserTournamentsList($user_id, $limit=1, $offset='0'){
		
		$today = date('Y-m-d');
		
		$this->db->select("*", FALSE);
        $this->db->from('tournaments_players');
		$this->db->where('player_user_id', $user_id);
	//	$this->db->where("tournament_end_date <= '$today' ");
		$this->db->join('tournaments', 'tournaments.tournament_id = tournaments_players.player_t_id', 'left');
		$this->db->join('tournaments_results', 'tournaments_results.result_t_id = tournaments_players.player_t_id', 'right');
		$this->db->group_by('tournaments.tournament_id');
        $this->db->order_by('tournaments.tournament_id','desc');
        $this->db->limit($limit,$offset);
		return $this->db->get()->result_array();
	}
	
	
	function getUserTournamentsTotal($user_id){
		
		$today = date('Y-m-d');
		$this->db->select("*", FALSE);
        $this->db->from('tournaments_players');
		$this->db->where('player_user_id', $user_id);
	//	$this->db->where("tournament_end_date <= '$today' ");
		$this->db->join('tournaments', 'tournaments.tournament_id = tournaments_players.player_t_id', 'left');
		$this->db->join('tournaments_results', 'tournaments_results.result_t_id = tournaments_players.player_t_id', 'right');
       // $this->db->join('tournament_banners','tournament_banners.banner_tournament_id = tournaments.tournament_id','left');  
		
		$this->db->group_by('tournaments.tournament_id');
        $this->db->order_by('tournaments.tournament_id','desc');
       
		return $this->db->get()->num_rows();
	}
	
	
	

	function getUserliveTournamentsList($user_id){
	$todayDate = date('Y-m-d'); 
		$this->db->select("*", FALSE);
        $this->db->from('tournaments'); 
        $where = '(tournament_section="2" or tournament_section="3")';

 $this->db->where($where); // 1=Free 2=Vip 3=Pay and Play 
		$this->db->where("tournament_start_date <= '$todayDate'"); 
        $this->db->where("tournament_end_date >= '$todayDate'"); 
        $this->db->join("tournament_banners","tournament_banners.banner_tournament_id = tournaments.tournament_id", "left"); 
		$this->db->join("tbl_tournaments_fee_rewards","tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id", "left");
		$this->db->join("tbl_country","tbl_country.c_id = tbl_tournaments_fee_rewards.fee_country_id", "left");
		return $this->db->get()->result_array();
	}

	function getVIPliveTournamentsList($user_id){
	$todayDate = date('Y-m-d'); 
		$this->db->select("*", FALSE);
        $this->db->from('tournaments'); 
        $where = '(tournament_section="2")';

 $this->db->where($where);  // 1=Free 2=Vip 3=Pay and Play 
		$this->db->where("tournament_start_date <= '$todayDate'"); 
        $this->db->where("tournament_end_date >= '$todayDate'"); 
        $this->db->join("tournament_banners","tournament_banners.banner_tournament_id = tournaments.tournament_id", "left"); 
		$this->db->join("tbl_tournaments_fee_rewards","tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id", "left");
		$this->db->join("tbl_country","tbl_country.c_id = tbl_tournaments_fee_rewards.fee_country_id", "left");
		return $this->db->get()->result_array();
	}

	function getTournamentInfo($id){
		$this->db->select("user_tournaments.*, count(tbl_user_tournament_players.player_id) as no_players ", FALSE);
        $this->db->from('user_tournaments');
		$this->db->where('t_id', $id);
		$this->db->join('user_tournament_players', 'user_tournament_players.player_t_id = user_tournaments.t_id', 'left');
        $this->db->group_by('t_id');
		return $this->db->get()->row_array();
	}

	function getSharedTournamentInfo($share_code){
		$this->db->select("user_tournaments.*, count(tbl_user_tournament_players.player_id) as no_players ", FALSE);
        $this->db->from('user_tournaments');
		$this->db->where('t_share_code', $share_code);
		$this->db->join('user_tournament_players', 'user_tournament_players.player_t_id = user_tournaments.t_id', 'left');
        $this->db->group_by('t_id');
		return $this->db->get()->row_array();
	}

	function getTournamentPlayersList($id){
		$this->db->select("*", FALSE);
		$this->db->from('user_tournament_players');
		$this->db->where('player_t_id', $id);
		$this->db->join('site_users', 'site_users.user_id = user_tournament_players.player_user_id', 'left');
		
	    return $this->db->get()->result_array();
	}
	
	function getTournamentPlayersListDESC($id){
		$this->db->select("*", FALSE);
		$this->db->from('user_tournament_players');
		$this->db->where('player_t_id', $id);
		$this->db->join('site_users', 'site_users.user_id = user_tournament_players.player_user_id', 'left');
		$this->db->order_by('player_score', 'desc');
	    return $this->db->get()->result_array();
	}
	
	function getTournamentPlayerScore($id, $user_id){
		$this->db->select("*", FALSE);
		$this->db->from('user_tournament_players');
		$this->db->where('player_t_id', $id);
		$this->db->where('player_user_id', $user_id);
		
	    return $this->db->get()->row_array();
	}
	
	
	function checkTournamentPlayer($user_id, $t_id){
		$this->db->select("*", FALSE);
		$this->db->from('user_tournament_players');
		$this->db->where('player_t_id', $t_id);
		$this->db->where('player_user_id', $user_id);
		return $this->db->get()->row_array();
	}

	function searchPTGameByName($txt){
		$this->db->select("*", FALSE);
        $this->db->from("games");
		$this->db->where("Name like '%$txt%' ");
		$this->db->where("IsPublished", "YES");
		$this->db->where('private_tournament', '1');
		$this->db->order_by('Name', 'ASC');

        return $this->db->get()->result_array();
	}

	function searchGameByName($txt){
		$this->db->select("*", FALSE);
        $this->db->from("games");
		$this->db->where("Name like '%$txt%' ");
		$this->db->where("IsPublished", "YES");

        return $this->db->get()->result_array();
	}

	
	function getGenreGamesList($type, $limit='all'){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		$this->db->where("portalCategory like '%$type%' ");
		$this->db->where('portalPublished', '1');
		$this->db->order_by('Name', 'RANDOM');
		
		if(is_numeric($limit) && $limit > 0)
			$this->db->limit($limit);
		
        return $this->db->get()->result_array();
	}
	
	function getSuggestedGamesList($limit){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		$this->db->where('IsSuggested', '1');
		$this->db->where('portalPublished', '1');		
		$this->db->order_by('Name', 'RANDOM');
		$this->db->limit($limit);
		
        return $this->db->get()->result_array();
	}
	
	function getQuickTournamnetGamesList($limit){
		$this->db->select("*", FALSE);
        $this->db->from('quick_tournaments'); 
		$this->db->join('games','games.gid = quick_tournaments.quick_gid','left'); 
		$this->db->order_by('quick_tid', 'RANDOM');
		$this->db->limit($limit);
        return $this->db->get()->result_array();
	}
	
	function getTopGamesList($limit){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		$this->db->where('IsTop', '1');
		$this->db->where('portalPublished', '1');
		$this->db->order_by('Name', 'RANDOM');
		$this->db->limit($limit);
		
        return $this->db->get()->result_array();
	}
	
	function getHomeGenreGamesList($type, $limit){
		$this->db->select("*", FALSE);
        $this->db->from('games'); 
		$this->db->where("portalCategory like '%$type%' ");
		$this->db->where('portalPublished', '1');
		$this->db->order_by('Name', 'RANDOM');
		$this->db->limit($limit);
        return $this->db->get()->result_array();
	}
	
	function getMaleProfileImages(){
		$this->db->select("*", FALSE);
        $this->db->from('user_images');
        $this->db->where('type', '1');
		$this->db->order_by('id', 'RANDOM');
		return $this->db->get()->result_array();
	}
	function getFemaleProfileImages(){
		$this->db->select("*", FALSE);
        $this->db->from('user_images');
		$this->db->where('type', '2');
		$this->db->order_by('id', 'RANDOM');
		return $this->db->get()->result_array();
	}
	
	
/*  **********************************   Global Leaderboard *********************** */
	
	public function getMonthlyGlobalLeaderboard($limit='', $offset=''){
		
		
		 $startDate = date("Y-m-d", strtotime("first day of this month"));
		 $endDate = date("Y-m-d", strtotime("last day of this month"));
		
		$this->db->select(" count(DISTINCT tbl_user_tournaments.t_id) as no_tournaments, count(tbl_user_tournament_players.player_id) as no_players, site_users.user_id, site_users.user_full_name, site_users.user_email, site_users.user_phone, site_users.user_login_type, site_users.user_image ", FALSE);
        $this->db->from('user_tournaments');
        $this->db->where("user_tournament_players.player_score > 0");
        $this->db->where("user_tournament_players.player_type = 2");
        $this->db->where("user_tournaments.t_start_date >= '$startDate'");
        $this->db->where("user_tournaments.t_end_date <= '$endDate'");
		$this->db->join('user_tournament_players', 'user_tournament_players.player_t_id = user_tournaments.t_id', 'left');
		$this->db->join('site_users', 'site_users.user_id = user_tournaments.t_user_id', 'left');
        $this->db->group_by('user_tournaments.t_user_id');
		$this->db->having('no_players > 0');
        $this->db->order_by('no_tournaments','desc');
        $this->db->limit("$limit, $offset");
		return  $this->db->get()->result_array();
		
	}
	
	public function getWeeklyGlobalLeaderboard($limit='', $offset=''){
		
		
		$monday = strtotime("last monday");
		$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
		$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
		$startDate = date("Y-m-d",$monday);
		$endDate = date("Y-m-d",$sunday);
		
		$this->db->select(" count(DISTINCT tbl_user_tournaments.t_id) as no_tournaments, count(tbl_user_tournament_players.player_id) as no_players, site_users.user_id, site_users.user_full_name, site_users.user_email, site_users.user_phone, site_users.user_login_type, site_users.user_image ", FALSE);
        $this->db->from('user_tournaments');
        $this->db->where("user_tournament_players.player_score > 0");
        $this->db->where("user_tournament_players.player_type = 2");
        $this->db->where("user_tournaments.t_start_date >= '$startDate'");
        $this->db->where("user_tournaments.t_end_date <= '$endDate'");
		$this->db->join('user_tournament_players', 'user_tournament_players.player_t_id = user_tournaments.t_id', 'left');
		$this->db->join('site_users', 'site_users.user_id = user_tournaments.t_user_id', 'left');
        $this->db->group_by('user_tournaments.t_user_id');
		$this->db->having('no_players > 0');
        $this->db->order_by('no_tournaments','desc');
		 $this->db->limit("$limit, $offset");
		return  $this->db->get()->result_array();
	
	}
	
	function getFakeUsers($count){
		
		$this->db->select("vName", FALSE);
        $this->db->from('fake_users');        
        $this->db->order_by('ID', 'RANDOM');
        $this->db->limit($count);
       
        return $this->db->get()->result_array();
	}
	
	public function getMonthlyGlobalLeaderboardUsers($limit='', $offset=''){
		$today = date('Y-m-d');
		$this->db->select("*", FALSE);
        $this->db->from('leaderboard_monthly');
        $this->db->where("month_date", $today);
        $this->db->limit("$limit, $offset");
		return  $this->db->get()->result_array();
	}
	
	public function getWeeklyGlobalLeaderboardUsers($limit='', $offset=''){
		$today = date('Y-m-d');
		$this->db->select("*", FALSE);
        $this->db->from('leaderboard_weekly');
        $this->db->where("week_date", $today);
        $this->db->limit("$limit, $offset");
		return  $this->db->get()->result_array();
	}
	
	public function checkWeeklyGLRows(){
		$today = date('Y-m-d');
		$this->db->select("count(*) as no_rows", FALSE);
        $this->db->from('leaderboard_weekly');
        $this->db->where("week_date", $today);
		return  $this->db->get()->row_array();
	}
	
	public function checkMonthlyGLRows(){
		$today = date('Y-m-d');
		$this->db->select("count(*) as no_rows", FALSE);
        $this->db->from('leaderboard_monthly');
        $this->db->where("month_date", $today);
		return  $this->db->get()->row_array();
	}
	
	
	public function getUserMGLRank(){
		
		$startDate = date("Y-m-d", strtotime("first day of this month"));
		$endDate = date("Y-m-d", strtotime("last day of this month"));
		
		$this->db->select(" count(DISTINCT tbl_user_tournaments.t_id) as no_tournaments, count(tbl_user_tournament_players.player_id) as no_players, site_users.user_id, site_users.user_full_name, site_users.user_email, site_users.user_phone, site_users.user_login_type, site_users.user_image ", FALSE);
        $this->db->from('user_tournaments');
        $this->db->where("user_tournament_players.player_score > 0");
        $this->db->where("user_tournament_players.player_type = 2");
        $this->db->where("user_tournaments.t_start_date >= '$startDate'");
        $this->db->where("user_tournaments.t_end_date <= '$endDate'");
		$this->db->join('user_tournament_players', 'user_tournament_players.player_t_id = user_tournaments.t_id', 'left');
		$this->db->join('site_users', 'site_users.user_id = user_tournaments.t_user_id', 'left');
        $this->db->group_by('user_tournaments.t_user_id');
		$this->db->having('no_players > 0');
        $this->db->order_by('no_tournaments','desc');
       
		return  $this->db->get()->result_array();
		
	}
	
	public function getUserWGLRank(){
		
		$monday = strtotime("last monday");
		$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
		$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
		$startDate = date("Y-m-d",$monday);
		$endDate = date("Y-m-d",$sunday);
		
		$this->db->select(" count(DISTINCT tbl_user_tournaments.t_id) as no_tournaments, count(tbl_user_tournament_players.player_id) as no_players, site_users.user_id, site_users.user_full_name, site_users.user_email, site_users.user_phone, site_users.user_login_type, site_users.user_image ", FALSE);
        $this->db->from('user_tournaments');
        $this->db->where("user_tournament_players.player_score > 0");
        $this->db->where("user_tournament_players.player_type = 2");
        $this->db->where("user_tournaments.t_start_date >= '$startDate'");
        $this->db->where("user_tournaments.t_end_date <= '$endDate'");
		$this->db->join('user_tournament_players', 'user_tournament_players.player_t_id = user_tournaments.t_id', 'left');
		$this->db->join('site_users', 'site_users.user_id = user_tournaments.t_user_id', 'left');
        $this->db->group_by('user_tournaments.t_user_id');
		$this->db->having('no_players > 0');
        $this->db->order_by('no_tournaments','desc');		
		return  $this->db->get()->result_array();
	
	}
	
/*  **********************************   Global Leaderboard Ends Here *********************** */

/*  **********************************   Coins Management Starts Here *********************** */


	function getUserLastSpin($userId){
		$this->db->select("*", FALSE);
        $this->db->from('user_spinwin'); 
		$this->db->where('spin_user_id', $userId);
		$this->db->order_by('spin_id', 'desc');
		$this->db->limit('1');
		
        return $this->db->get()->row_array();
	}
	
/*  **********************************   Coins Management Ends Here *********************** */

/*  **********************************   Spin & Win Sections Starts Here *********************** */
	
	function getSpinWheelSections(){
		$this->db->select("*", FALSE);
        $this->db->from('spinwheel_data'); 
		$this->db->order_by('wheel_seq', 'ASC');
        return $this->db->get()->result_array();
	}
	
	function getSpinWheelInfo($id){
		$this->db->select("*", FALSE);
        $this->db->from('spinwheel_data'); 
        $this->db->where('wheel_id', $id); 
		return $this->db->get()->row_array();
	}
	
/*  **********************************   Spin & Win Sections Ends Here *********************** */


/*  **********************************   Notifications Sections Starts Here *********************** */

	function getUserNotifications($user_id){
		$this->db->select("*", FALSE);
        $this->db->from('user_notifications'); 
        $this->db->where('notify_user_id', $user_id); 
        $this->db->order_by('notify_id', 'desc'); 
        $this->db->limit('100'); 
		return $this->db->get()->result_array();
	}
	
	function getUserUnreadNotificationsCount($user_id){
		$this->db->select("count(*) as rows_count", FALSE);
        $this->db->from('user_notifications'); 
        $this->db->where('notify_user_id', $user_id); 
        $this->db->where('notify_status', '0'); 
		return $this->db->get()->row_array();
	}
	
	
	function getUserUnseenResults($user_id){
		$this->db->select("player_id, player_reward_rank, player_reward_prize, tournament_name", FALSE);
        $this->db->from('tournaments_results'); 
        $this->db->join('tournaments_players','tournaments_players.player_t_id = tournaments_results.result_t_id', 'left'); 
        $this->db->join('tournaments','tournaments.tournament_id = tournaments_results.result_t_id', 'left'); 
        $this->db->where('player_user_id', $user_id); 
        $this->db->where('player_reward_rank > 0');  // Should have some reward rank assigned
        $this->db->where('prize_voucher_id > 0');   // Should have some reward voucher  assigned
        $this->db->where('prize_seen', '0'); 
        $this->db->group_by('player_t_id'); 
        $this->db->order_by('result_t_id', 'desc'); 
        return $this->db->get()->result_array();
	}
	
	
	function setUpdateUnseenTournamentsResults($unseenTournamentsArray){
		if(is_array($unseenTournamentsArray) && count($unseenTournamentsArray)>0){
			foreach($unseenTournamentsArray as $row){
				$updateSeen['prize_seen'] = '1';
				$this->db->where('player_id', $row['player_id']); 
				$this->db->update('tournaments_players', $updateSeen); 
			}
		}
	}
	
	
/*  **********************************   Notifications Sections Ends Here *********************** */


	function getRedemptionsList($type){
		$this->db->select("*", FALSE);
        $this->db->from('redemption_settings'); 
		// Type values:  1=Coins  2=Datapack(MB)   3=Datapack(GB)    4=Talktime   5=GamesAccessForUnsubscribedUsers
		$this->db->where('redeem_type', $type); 
		$this->db->where('redeem_status', '1'); 
		
		return $this->db->get()->result_array();
	}
	
		
	function getPractiseBannersList($limit){
		$this->db->select("*", FALSE);
        $this->db->from('practise_banners'); 
        $this->db->where('banner_status', '1'); 
        $this->db->order_by('banner_id', 'desc'); 
		$this->db->limit($limit); 
		
		return $this->db->get()->result_array();
	}
	
		
	function getPortalTournamentList($section, $limit=''){
		$todayDate = date('Y-m-d H:i:s'); 
		$currenttime = date('H:i');
		$this->db->select("*", FALSE);
        $this->db->from('tournaments'); 
        $this->db->where('tournament_section',$section);   // 1=Free 2=Vip 3=Pay and Play 
		$this->db->where("tournament_start_timestamp <= '$todayDate'"); 
	    $this->db->where("tournament_end_timestamp >= '$todayDate'"); 
        $this->db->join("tournament_banners","tournament_banners.banner_tournament_id = tournaments.tournament_id", "left"); 
		$this->db->join("tbl_tournaments_fee_rewards","tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id", "left");
		$this->db->join("tbl_country","tbl_country.c_id = tbl_tournaments_fee_rewards.fee_country_id", "left");
		$this->db->order_by('tournament_id', 'desc'); 
		if(!empty($limit))
		$this->db->limit($limit); 
		
		return $this->db->get()->result_array();
		
	}
		
	function getVipTournamentList($limit=''){
		$todayDate = date('Y-m-d'); 
		$currenttime = date('H:i');
		$this->db->select("*", FALSE);
        $this->db->from('tournaments'); 
        $this->db->where('tournament_section','2');   // 1=HeroTournaments   2=SmallTournaments  after Update  // 1=Free 2=Vip 3=Pay and Play 
		$this->db->where("tournament_start_date <= '$todayDate'"); 
        $this->db->where("tournament_end_date >= '$todayDate'"); 
         $this->db->where("CASE WHEN tournament_end_date = '$todayDate' THEN tournament_end_time >= '$currenttime' ELSE tournament_section = '2' END");
        $this->db->join("tournament_banners","tournament_banners.banner_tournament_id = tournaments.tournament_id", "left"); 
		$this->db->join("tbl_tournaments_fee_rewards","tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id", "left");
		$this->db->join("tbl_country","tbl_country.c_id = tbl_tournaments_fee_rewards.fee_country_id", "left");
		$this->db->order_by('tournament_id', 'desc'); 
		if(!empty($limit))
		$this->db->limit($limit); 
		
		return $this->db->get()->result_array();
		
	}

	function getVipTournamentListrankwise($limit=''){
		$todayDate = date('Y-m-d'); 
		$this->db->select("*", FALSE);
        $this->db->from('tournaments');
        $this->db->where('player_user_id',$this->session->userdata('userId'));
        $this->db->where('tournament_section','2');   // 1=HeroTournaments   2=SmallTournaments  after Update  // 1=Free 2=Vip 3=Pay and Play 
		$this->db->where("tournament_start_date <= '$todayDate'"); 
        $this->db->where("tournament_end_date >= '$todayDate'"); 
        $this->db->join("tournament_banners","tournament_banners.banner_tournament_id = tournaments.tournament_id", "left"); 
		$this->db->join("tbl_tournaments_fee_rewards","tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id", "left");
		$this->db->join("tbl_country","tbl_country.c_id = tbl_tournaments_fee_rewards.fee_country_id", "left");
		$this->db->join("tbl_tournaments_players","tbl_tournaments_players.player_t_id = tbl_tournaments.tournament_id", "left");
		$this->db->order_by('tournament_id', 'desc'); 
		if(!empty($limit))
		$this->db->limit($limit); 
		
		return $this->db->get()->result_array();
	}
	
	
	function checkJoinedTournamentPlayer($tournamentId, $userId){
		$this->db->select("*", FALSE);
        $this->db->from('tournaments_players'); 
        $this->db->where('player_t_id',$tournamentId);   
        $this->db->where('player_user_id',$userId);   
		
		//return $this->db->get()->row_array();
		return $this->db->get()->num_rows();
	}
	
	
		
	function getFreeTournamentList($limit=''){
		$todayDate = date('Y-m-d'); 
		$currenttime = date('H:i');
		$this->db->select("*", FALSE);
        $this->db->from('tournaments'); 
        $this->db->where('tournament_section','1');   // 1=HeroTournaments   2=SmallTournaments after Update  // 1=Free 2=Vip 3=Pay and Play 
		$this->db->where("tournament_start_date <= '$todayDate'"); 
        $this->db->where("tournament_end_date >= '$todayDate'");
        $this->db->where("CASE WHEN tournament_end_date = '$todayDate' THEN tournament_end_time >= '$currenttime' ELSE tournament_section = '1' END");
		$this->db->join("tbl_tournaments_fee_rewards","tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id", "left");
		$this->db->join("tbl_country","tbl_country.c_id = tbl_tournaments_fee_rewards.fee_country_id", "left"); 
		$this->db->order_by('tournament_id', 'desc'); 
		if(!empty($limit))
		$this->db->limit($limit); 
		
		return $this->db->get()->result_array();
	}
	public function getPayAndPlayTournamentList($limit=''){
		$todayDate = date('Y-m-d'); 
		$currenttime = date('H:i');
		$this->db->select("*", FALSE);
        $this->db->from('tournaments'); 
        $this->db->where('tournament_section','3');   // 1=Free   2=VipTournaments  3=PayAndPlay
		$this->db->where("tournament_start_date <= '$todayDate'"); 
        $this->db->where("tournament_end_date >= '$todayDate'");
        $this->db->where("CASE WHEN tournament_end_date = '$todayDate' THEN tournament_end_time >= '$currenttime' ELSE tournament_section = '3' END");
		$this->db->join("tbl_tournaments_fee_rewards","tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id", "left");
		$this->db->join("tbl_country","tbl_country.c_id = tbl_tournaments_fee_rewards.fee_country_id", "left");
		$this->db->order_by('tournament_id', 'desc'); 
		
		if(!empty($limit))
		$this->db->limit($limit); 
		
		return $this->db->get()->result_array();
	}

	public function getPayAndPlayTournamentListrank($limit=''){
		$todayDate = date('Y-m-d'); 
		
		$this->db->select("*", FALSE);
		$this->db->distinct();
        $this->db->from('tournaments'); 
        $this->db->where('tournament_section','3');   // 1=Free   2=VipTournaments  3=PayAndPlay
		$this->db->where("tournament_start_date <= '$todayDate'"); 
        $this->db->where("tournament_end_date >= '$todayDate'");
		$this->db->join("tbl_tournaments_fee_rewards","tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id", "left");
		$this->db->join("tbl_country","tbl_country.c_id = tbl_tournaments_fee_rewards.fee_country_id", "left");
		$this->db->join("tbl_tournaments_players","tbl_tournaments_players.player_t_id = tbl_tournaments.tournament_id", "left");
		if(!empty($limit))
		$this->db->limit($limit); 
		
		return $this->db->get()->result_array();
	}
	
	function getLiveTournamentInfo($id){
		$this->db->select("tournaments.*, games.screen as tournament_game_screen , tbl_tournaments_fee_rewards.* ,tbl_country.c_country_code", FALSE);
        $this->db->from('tournaments'); 
        $this->db->where('tournament_id',$id);  
        $this->db->join('games','games.gid = tournaments.tournament_game_id','left');
		$this->db->join("tbl_tournaments_fee_rewards","tbl_tournaments_fee_rewards.fee_turnament_id = tournaments.tournament_id", "left");
		$this->db->join("tbl_country","tbl_country.c_id = tbl_tournaments_fee_rewards.fee_country_id", "left");
		$result=$this->db->get()->result_array();
		foreach($result as $row)
		{
				return $row;
		}
		return $result;
	}
	
	public function deductTournamentFee($fee , $t_id){
		$this->db->select('user_play_coins', FALSE);
		$this->db->where('user_id', $this->session->userdata('userId'));
		$coins=$this->db->get('tbl_site_users')->result_array()[0]['user_play_coins'];
		
		$data2['user_play_coins']=$coins-$fee;
		if($data2['user_play_coins']>0)
		{
			$this->db->where('user_id' , $this->session->userdata('userId'));
			$this->db->update('tbl_site_users' , $data2);
			// Manage Coin history
			$coin['coin_user_id']           =   	$this->session->userdata('userId');
			$coin['coin_date']              =   	date("Y-m-d");
			$coin['coin_section']           =   	6;
			$coin['coin_play_coins_add']    =   	'-'.$fee;
			$coin['coin_tournament_id']		=		$t_id;
			$coin['coin_type']              =   	1;
			$coin['coin_added_on']          =   	time();
			$this->db->insert('tbl_user_coins_history' , $coin);
			return true;
		}
		else
			return false;
	}
		
	function getLiveTournamentPlayersCount($id){
		$this->db->select("count(*) as total_players", FALSE);
        $this->db->from('tournaments_players'); 
        $this->db->where('player_t_id',$id);   
		return $this->db->get()->row_array();
	}
	
	public function checkTournamentJoined($userId , $id){
		$this->db->select('*');
		$this->db->where('player_t_id' , $id);
		$this->db->where('player_user_id' , $userId);
		$result=$this->db->get('tbl_tournaments_players');
		if($result->num_rows()>0)
			return true;
		return false;
	}
		
	function checkLiveTournamentPlayer($user_id, $t_id){
		$this->db->select("*", FALSE);
		$this->db->from('tournaments_players');
		$this->db->where('player_t_id', $t_id);
		$this->db->where('player_user_id', $user_id);
		return $this->db->get()->row_array();
	}
	
	function getLiveTournamentPlayerScore($id, $user_id){
		$this->db->select("*", FALSE);
		$this->db->from('tournaments_players');
		$this->db->where('player_t_id', $id);
		$this->db->where('player_user_id', $user_id);
		
	    return $this->db->get()->row_array();
	}
	
	
	function getLiveTournamentPlayersListDESC($id){
		$this->db->select("*", FALSE);
		$this->db->from('tournaments_players');
		$this->db->where('player_t_id', $id);
		$this->db->join('site_users', 'site_users.user_id = tournaments_players.player_user_id', 'left');
		$this->db->order_by('player_score', 'desc');
	    return $this->db->get()->result_array();
	}
	
	
	function getUserPracticeGameReport($userId, $gameId){
		$today = date('Y-m-d');
		$this->db->select("*", FALSE);
		$this->db->from('report_game_play');
		$this->db->where('report_user_id', $userId);
		$this->db->where('report_game_id', $gameId);
		$this->db->where('report_date', $today);
		$this->db->order_by('report_id', 'desc');
		$this->db->limit('1');
		return $this->db->get()->row_array();
	}
	
	function getUserTournamentGameReport($userId, $gameId, $tournamentId){
		$today = date('Y-m-d');
		$this->db->select("*", FALSE);
		$this->db->from('report_game_play');
		$this->db->where('report_user_id', $userId);
		$this->db->where('report_game_id', $gameId);
		$this->db->where('report_tournament_id', $tournamentId);
		$this->db->where('report_date', $today);
		$this->db->order_by('report_id', 'desc');
		$this->db->limit('1');
		return $this->db->get()->row_array();
	}

	public function getUserLastLoginReport($userId, $page , $gameId , $tournamentId)
	{
		$date= date('Y-m-d');
		$this->db->select('*' , FALSE);
		$this->db->from('report_users');
		$this->db->where('report_date' , $date);
		$this->db->where('report_user_id' , $userId);
		$this->db->where('report_page', $page);
		$this->db->where('report_game_id', $gameId);
		$this->db->where('report_tournament_id', $tournamentId);
		return $this->db->get()->row_array();

	}	
	
	
	
	
	public function getVoucherdetailbyPrize($voucherprize){
		$this->db->select("voucher_detail.*, voucher_type.*", FALSE);
		$this->db->from('voucher_detail');
		$this->db->where('tbl_voucher_type.vt_type', $voucherprize);
		$this->db->join('tbl_voucher_type', 'tbl_voucher_type.vt_id = tbl_voucher_detail.voucher_type_id', 'left');
        $this->db->limit('1');
		return $this->db->get()->row_array();

	}

	public function getVoucherdetailbyid($id){
		$this->db->select("voucher_detail.*, voucher_type.*", FALSE);
		$this->db->from('voucher_detail');
		$this->db->where('voucher_type.vt_id', $id);
		$this->db->join('voucher_type', 'voucher_type.vt_id = voucher_detail.voucher_type_id', 'left');
        $this->db->limit('1');
		return $this->db->get()->row_array();

	}


	public function getVoucherInfo($id){
		$this->db->select("voucher_detail.*, voucher_type.*", FALSE);
		$this->db->from('voucher_detail');
		$this->db->where('voucher_type.vt_id', $id);
		$this->db->join('voucher_type', 'voucher_type.vt_id = voucher_detail.voucher_type_id', 'left');
		$this->db->join('tournament_voucher_detail', 'tournament_voucher_detail.tv_voucher_id = voucher_detail.voucher_id', 'left');

        $this->db->limit('1');
		return $this->db->get()->row_array();

	}
	
	public function getUpdatedVoucherCounts($id){
		$this->db->select("*", FALSE);
		$this->db->from('voucher_type');
		$this->db->where('vt_id', $id);
		$this->db->limit('1');
		return $this->db->get()->row_array();

	}
	
	public function getVoucherDetail($id){
		$this->db->select("*", FALSE);
		$this->db->from('voucher_detail');
		$this->db->where('voucher_id', $id);
		$this->db->join('voucher_type', 'voucher_type.vt_id = voucher_detail.voucher_type_id', 'left');
		
        $this->db->limit('1');
		return $this->db->get()->row_array();

	}
	
/*
	public function getVoucherDetailToAssign($voucher_type,$tournament_id){
		$this->db->select("voucher_detail.*, voucher_type.*, tbl_tournament_voucher_detail.*", FALSE);
		$this->db->from('voucher_detail');
		$this->db->where('tbl_voucher_type.vt_id', $voucher_type);
		$this->db->where('tbl_tournament_voucher_detail.tv_tournament_id', $tournament_id);
		$this->db->where('tbl_tournament_voucher_detail.tv_assigned_status', 0);
		$this->db->join('tbl_voucher_type', 'tbl_voucher_type.vt_id = tbl_voucher_detail.voucher_type_id', 'left');
		$this->db->join('tbl_tournament_voucher_detail', 'tbl_tournament_voucher_detail.tv_voucher_id = tbl_voucher_detail.voucher_id', 'left');

        $this->db->limit('1');
		return $this->db->get()->row_array();

	}
	*/
	
	public function getUserRankVoucher($rank, $tournament_id){
		$this->db->select("voucher_detail.*, voucher_type.*, tournament_voucher_detail.*", FALSE);
		$this->db->from('tournament_voucher_detail');
		$this->db->where('tv_prize_rank', $rank);
		$this->db->where('tv_tournament_id', $tournament_id);
		$this->db->join('voucher_detail', 'voucher_detail.voucher_id = tournament_voucher_detail.tv_voucher_id', 'left');
		$this->db->join('voucher_type', 'voucher_type.vt_id = voucher_detail.voucher_type_id', 'left');
		
        $this->db->limit('1');
		return $this->db->get()->row_array();

	}


	public function getUnassignedTournamentVouchers($tournament_id){
		$this->db->select("voucher_detail.*, voucher_type.*, tournament_voucher_detail.*", FALSE);
		$this->db->from('tournament_voucher_detail');
		$this->db->where('tv_assigned_status', '0');
		$this->db->where('tv_tournament_id', $tournament_id);
		$this->db->join('voucher_detail', 'voucher_detail.voucher_id = tournament_voucher_detail.tv_voucher_id', 'left');
		$this->db->join('voucher_type', 'voucher_type.vt_id = voucher_detail.voucher_type_id', 'left');
		
		return $this->db->get()->result_array();

	}

/*
	function RedeemVoucherUpdate($id){
		$this->db->where('player_id', $id);
        $this->db->update('tournaments_players', array('redeem_prize' => '2', 'prize_claimed_date' => date('Y-m-d H:i:s')));

        $this->db->where('player_id', $id);
        $this->db->update('tbl_tournament_voucher_detail', array('status' => '2'));
	}	
	
	*/
	
	
	function updateVoucherClaimed($player_id, $voucher_id){
		
		$playerDetail = $this->db->query("SELECT player_t_id, player_user_id FROM tbl_tournaments_players WHERE player_id = '$player_id' AND redeem_prize = '0'")->row_array();
		$player_t_id = @$playerDetail['player_t_id'];
		$player_user_id = @$playerDetail['player_user_id'];
		
		if(!empty($player_t_id)){
			$this->db->where('player_id', $player_id);
			$this->db->update('tournaments_players', array('redeem_prize' => '2', 'prize_claimed_date' => date('Y-m-d H:i:s')));

			//status update of voucher assign
			$this->db->where('tv_voucher_id', $voucher_id);
			$this->db->update('tournament_voucher_detail', array('tv_assigned_status' => '4'));
			
			//status update of voucher assign
			$this->db->where('voucher_id', $voucher_id);
			$this->db->update('voucher_detail',  array('voucher_status' => '3'));  // claimed by user
			
			//updated claimed count
			$voucherDetail = $this->getVoucherDetail($voucher_id);
			$vtClaimedVouchers = $voucherDetail['vt_claimed_coupons'];
			$updateCoupon['vt_claimed_coupons'] = ($vtClaimedVouchers+1);
			$this->db->where('vt_id', $voucherDetail['vt_id']);
			$this->db->update('voucher_type', $updateCoupon);	
			
				
			// finally update logs
			$logs['log_voucher_id'] =  $voucher_id;
			$logs['log_tournament_id'] =  $player_t_id;
			$logs['log_user_id'] =  $player_user_id;
			$logs['log_voucher_status'] = '3'; //claimed by user
			$logs['log_message'] = 'claimed_by_user';
			$logs['log_date_time'] = date('Y-m-d H:i:s');
			$logs['log_added_on'] = time();
			$this->db->insert('voucher_logs', $logs);
			
			
			//add Notification for tournament rewards claimed 
			$notifyData['notify_user_id'] =  $player_user_id;
			$notifyData['notify_type'] =  '8';  //1=TournamentCreated   2=Spin&Win   3=RedeemCoins   4=TournamentRewardAdded   5=UpdateProfileName    6=SubscriptionCoins   7=RewardAdded  8=RewardClaimed  9=VoucherExpired
			$notifyData['notify_title'] =  "Tournament Reward Claimed";
			$notifyData['notify_desc'] =  "You have claimed a Daraz voucher worth <b> ".number_format($voucherDetail['vt_type'], 0)." BDT</b>.";
			$notifyData['notify_status'] =  '0';
			$notifyData['notify_date'] =  date('Y-m-d');
			$notifyData['notify_added_on'] =  time();
			$this->db->insert('user_notifications', $notifyData);
							
			
		}
		
	}	
	
	
	
	
	
}

?>
