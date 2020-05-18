<?php
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,"https://covid19.th-stat.com/api/open/today");
// Execute

$result=curl_exec($ch);
// Closing
curl_close($ch);
// แปลงข้อมูลที่รับมาในรูป json มาเป็น array จะได้ใช้ง่าย ๆ
$DATA= json_decode($result, true);

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set("Asia/Bangkok");

	$sToken = "p44qt5U9h9EyRFrgmlIZOt2XMpqr7pTpZbfm54AByYS";

	$sMessage = "\n".'ข้อมูลวันที่'.$DATA['UpdateDate'].
	"\n".'ติดเชื้อสะสม::'.$DATA['Confirmed'].
	"\n".'หายแล้ว:: '.$DATA['Recovered'].
	"\n".'รักษาอยู่ใน รพ.:: '.$DATA['Hospitalized'].
	"\n".'เสียชีวิต:: '.$DATA['Deaths'].
	"\n".'(ติดเชื้อสะสม-เพิ่มขึ้น):: '.$DATA['NewConfirmed'].
	"\n".'(หายแล้ว-เพิ่มขึ้น)::'.$DATA['NewRecovered'].
	"\n".'(รักษาอยู่ใน รพ.-เพิ่มขึ้น)::'.$DATA['NewHospitalized'].
	"\n".'(ตาย-เพิ่มขึ้น)::'.$DATA['NewDeaths'].
	"\n".'อ้างอิงจาก::'.$DATA['Source'];

	$chOne = curl_init(); 
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec( $chOne ); 

	//Result error 
	if(curl_error($chOne)) 
	{ 
		echo 'error:' . curl_error($chOne); 
	} 
	else { 
		$result_ = json_decode($result, true); 
		echo "status : ".$result_['status']; echo "message : ". $result_['message'];
	} 
	curl_close( $chOne );   

?>