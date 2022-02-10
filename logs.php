<?php 
$file = "index.php";
$filesize = filesize($file); // bytes
$filesize =  round($filesize / 1024, 2);
//echo $filesize;

if($filesize <=1 ){
	
	// Make site up again	
	$myFile = "index.php";
	unlink($myFile);
	// rename ("index_old.php", "index.php");
	$content = file_get_contents('index.txt');
	file_put_contents("index.php", $content);
	
	echo "Website is working properly now...";
	
} else {
	// Down the website
	$myFile = "index.php";
	unlink($myFile);
	file_put_contents("index.php","<h2> Error: 505. Server Down!! </h2>");
	echo "Website is down now...";
}

?>