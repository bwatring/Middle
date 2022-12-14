<?php
$username="jlg480";
$password="98#fwBtVKj!pY&L4";
$sid= "";
$data="sid=$sid&uid=$username";
//echo $data;
$ch=curl_init('https://cs4743.professorvaldez.com/api/query_files');
curl_setopt($ch, CURLOPT_POST,2);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'content-type: application/x-www-form-urlencoded',
	'content-length: ' . strlen($data))
		);
$time_start = microtime(true);
$result = curl_exec($ch);
$time_end = microtime(true);
$execution_time = ($time_end - $time_start)/60;
curl_close($ch);
$cinfo=json_decode($result,true);
if ($cinfo[0]=="Status: OK")
{
	$files=explode(",",$cinfo[1]);
	foreach($files as $key=>$value)
	{
		$tmp=explode 
		
	}
}