<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();

require_once dirname(__FILE__) . '/xlsxwriter.class.php';

class Reports extends CI_Controller {
	
	public  function __construct(){
		parent:: __construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('text');
		date_default_timezone_set("Asia/Dhaka");
    }

	
	public function dailyReport(){
		$reportDate = date('Y-m-d', strtotime("-1 day"));
		$this->getReportXLSX($reportDate);
		
		$filename = 'Grameenphone_Daily_Report_'.date('Ymd').'.xlsx';
		
		$filepath = '/uploads/daily_reports/'.$filename;
		
		$this->load->library("PhpMailerLib");
		$mail = $this->phpmailerlib->load();
		
		try {
			
		    //Server settings
		    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		   
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = 'adxdigitalsg@gmail.com';                 // SMTP username
		    $mail->Password = 'adxd@123';                           // SMTP password
		    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 465;                                    // TCP port to connect to
		  

		   //Recipients
		    $mail->setFrom('adxdigitalsg@gmail.com', 'ADX Digital');
		   
		//	$mail->addAddress('techsupport@18boxmedia.com', 'Nisha Vaish');     // Add a recipient
			$mail->addAddress('vaish.nisha55@gmail.com', 'Nisha Vaish');     // Add a recipient
			
			$mail->addReplyTo('adxdigitalsg@gmail.com', 'ADX Digital');
		//	$mail->addCC('mrinal@adxdigitalsg.com');			
			
			$mail->AddAttachment($_SERVER['DOCUMENT_ROOT'].$filepath); 
		   
			$bodyContent = "Good day!";
			$bodyContent .= "<br><br>Please check the attached Grameenphone Daily Report.";

			$bodyContent .= "<br><br><br>Thanks!";
		   
		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Grameenphone Daily Report '. date('j F, Y', strtotime($reportDate));
		    $mail->Body    = $bodyContent;
		    $mail->AltBody = $bodyContent;

		    if($mail->send())
				echo 'Message has been sent';
			else 
				echo 'Message could not be sent.';
		} catch (Exception $e) {
		
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		
	}
	
	
	
	public function getReportXLSX($date=''){
		
		if(empty($date)){
			$date = date('Y-m-d', strtotime("-1 day"));
		} 
		
		// get data - paid tournaments data
		$list = $this->db->query("
		SELECT report_date, sum(report_tournament_counts) as report_tournament_counts, sum(report_tournament_practice_counts) as report_tournament_practice_counts, tbl_site_users.user_full_name, tbl_site_users.user_phone, tbl_tournaments.tournament_name, tbl_tournaments.tournament_game_name , tbl_tournaments.tournament_section
		FROM tbl_report_game_play
		LEFT JOIN tbl_site_users ON tbl_site_users.user_id = tbl_report_game_play.report_user_id  
		LEFT JOIN tbl_tournaments ON tbl_tournaments.tournament_id = tbl_report_game_play.report_tournament_id  
		WHERE report_date = '$date' AND tournament_section IN('2','3')
		GROUP BY report_user_id
		")->result();
		
		
		// get data - free tournaments data
		$listFree = $this->db->query("
		SELECT report_date, sum(report_tournament_counts) as report_tournament_counts, sum(report_tournament_practice_counts) as report_tournament_practice_counts, tbl_site_users.user_full_name, tbl_site_users.user_phone, tbl_tournaments.tournament_name, tbl_tournaments.tournament_game_name , tbl_tournaments.tournament_section
		FROM tbl_report_game_play
		LEFT JOIN tbl_site_users ON tbl_site_users.user_id = tbl_report_game_play.report_user_id  
		LEFT JOIN tbl_tournaments ON tbl_tournaments.tournament_id = tbl_report_game_play.report_tournament_id  
		WHERE report_date = '$date' AND tournament_section IN('1')
		GROUP BY report_user_id
		")->result();
		
		
		// get data - free tournaments data
		$listFreeGames = $this->db->query("
		SELECT report_date, sum(report_practice_counts) as report_practice_counts, tbl_site_users.user_full_name, tbl_site_users.user_phone, tbl_games.Name
		FROM tbl_report_game_play
		LEFT JOIN tbl_site_users ON tbl_site_users.user_id = tbl_report_game_play.report_user_id  
		LEFT JOIN tbl_games ON tbl_games.id = tbl_report_game_play.report_game_id  
		WHERE report_date = '$date' 
		GROUP BY report_user_id
		having report_practice_counts > 0
		")->result();
		
		
	//	echo "<pre>"; print_r($list);  "</pre>";
		
		//define column headers
		$headers = array(
		"Date"=> 'string', 
		"User MSISDN"=> 'string', 
		"User Name"=> 'string', 
		"Tournament Type"=> 'string', 
		"Tournament Name"=> 'string', 
		"Game Name"=> 'string', 
		"Tournament Play Counts"=> 'string', 
		"Tournament Practice Counts"=> 'string'
		);
		
		//create writer object
		$writer = new XLSXWriter();
		
		//meta data info
		$writer->setTitle('Grameenphone Daily Report');
		$writer->setSubject('Grameenphone Daily Report');
		$writer->setAuthor('Nisha Vaish');
		$writer->setCompany('iGPL');
		$writer->setDescription('Grameenphone Daily Report');
		$writer->setTempDir(sys_get_temp_dir());
		
		//write headers  - Sheet 1 Paid Tournaments
		$writer->writeSheetHeader('Sheet1', $headers, $col_options = array(
			'widths'=>[25,25,25,25,25,25,25,25],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13']
		));
		
		//write rows to sheet1
		if(is_array($list) && count($list)>0){
			foreach ($list as $sf):
				if($sf->tournament_section == 1)
					$type = 'Daily Free Tournament';
				else if($sf->tournament_section == 2)
					$type = 'Weekly Premium Tournament';
				else
					$type = 'Daily Premium Tournament';
			
				$writer->writeSheetRow('Sheet1', 
				array(
					date('d/M/Y', strtotime($sf->report_date)), 
					$sf->user_phone, 
					$sf->user_full_name,
					$type, 					
					stripslashes(urldecode($sf->tournament_name)), 
					stripslashes(urldecode($sf->tournament_game_name)), 
					$sf->report_tournament_counts, 
					$sf->report_tournament_practice_counts, 
				), 
				['width'=>'25', 'font'=>'Calibri','font-style'=>'normal','font-size'=>'12']);
			endforeach;
			
		} else {
			$writer->writeSheetRow('Sheet1', array("", "", "", "", "", "", "", ""));
		}
		
		
		//write headers  - Sheet 2 Free Tournaments
		$writer->writeSheetHeader('Sheet2', $headers, $col_options = array(
			'widths'=>[25,25,25,25,25,25,25,25],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13']
		));
		//write rows to sheet2 - for Free tournaments
		if(is_array($listFree) && count($listFree)>0){
			foreach ($listFree as $sfree):
				if($sfree->tournament_section == 1)
					$type = 'Daily Free Tournament';
				else if($sfree->tournament_section == 2)
					$type = 'Weekly Premium Tournament';
				else
					$type = 'Daily Premium Tournament';
			
				$writer->writeSheetRow('Sheet2', 
				array(
					date('d/M/Y', strtotime($sfree->report_date)), 
					$sfree->user_phone, 
					$sfree->user_full_name,
					$type, 					
					stripslashes(urldecode($sfree->tournament_name)), 
					stripslashes(urldecode($sfree->tournament_game_name)), 
					$sfree->report_tournament_counts, 
					$sfree->report_tournament_practice_counts, 
				), 
				['width'=>'25', 'font'=>'Calibri','font-style'=>'normal','font-size'=>'12']);
			endforeach;
			
		} else {
			$writer->writeSheetRow('Sheet2', array("", "", "", "", "", "", "", ""));
		}
		
		
		//write headers  - Sheet 3 Instant Free Games
		
		//define column headers
		$headers_3 = array(
			"Date"=> 'string', 
			"User MSISDN"=> 'string', 
			"User Name"=> 'string', 
			"Game Name"=> 'string', 
			"Play Counts"=> 'string'
		);
		
		$writer->writeSheetHeader('Sheet3', $headers_3, $col_options = array(
			'widths'=>[25,25,25,25,25],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13'],
			['font'=>'Calibri','font-style'=>'bold','font-size'=>'13']
		));
		//write rows to Sheet3 - for Free tournaments
		if(is_array($listFreeGames) && count($listFreeGames)>0){
			foreach ($listFreeGames as $rowGame):
				
				$writer->writeSheetRow('Sheet3', 
				array(
					date('d/M/Y', strtotime($rowGame->report_date)), 
					$rowGame->user_phone, 
					$rowGame->user_full_name,
					$rowGame->Name,
					$rowGame->report_practice_counts
				), 
				['width'=>'25', 'font'=>'Calibri','font-style'=>'normal','font-size'=>'12']);
			endforeach;
			
		} else {
			$writer->writeSheetRow('Sheet3', array("", "", "", "", "", "", "", ""));
		}
		
		$filename = 'Grameenphone_Daily_Report_'.date('Ymd').'.xlsx';
		
		$fileLocation = FCPATH . 'uploads/daily_reports/'.$filename;
		
		//write to xlsx file
		$writer->writeToFile($fileLocation);
			
	}
	
	
}
