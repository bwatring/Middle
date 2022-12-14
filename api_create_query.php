<?php
$username="jlg480";
$password="98%23fwBtVKj!pYL4";
$data="username=$username&password=$password";
$ch=curl_init('https://cs4743.professorvaladez.com/api/create_session?username=jlg480&password=98%23fwBtVKj!pYL4');
curl_setopt($ch, CURLOPT_POST,1);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'content-type: application/c-www-form-urlencoded',
	'content-length: ' .strlen($data))
);
$time_start = microtime(true);
$result = curl_exec($ch);
$time_end = microtime(true);
$execution_time = ($time_end - $time_start)/60;
curl_close($ch);
$cinfo=json_decode($result,true);
if ($cinfo[0]=="Status: OK" && $cinfo[1]=="MSG: Session Created")
{
	$sid=$cinfo[2];
	$data="sid=$sid&uid=$username";
	echo "\r\nSession Created Succesfully!\r\n";
	echo "SID: $sid\r\n";
	echo "Create Session Execution Time: $execution_time\r\n";
	$ch=curl_init('https://cs4743.professorvaladez.com/api/close_session?sid=' . $sid . '&username=jlg480');
	curl_setopt($ch, CURLOPT_POST,1);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'content-type: application/x-www-form-urlencoded',
		'content-length: ' . strlen($data))
	);
	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end = $time_start)/60;
	curl_close($ch);
	$cinfo=json_decode($result,true);
	if ($cinfo[0]=="Status: OK")
	{
		if($cinfo[1]=="Action: None")
		{
			echo "\r\n No New files to import found \r\n";
			echo "SID: $sid\r\n";
			echo "UsernameL $username\r\n";
			echo "Query Files execution Time: $execution_time\r\n";
		}
		else //an error happened so view the error 
		{
			$tmp=explode(":", $cinfo[1]);
			$files=explode(",",$tmp[1]);
			echo "Number of new files to import found: ".count($files)."\r\n";
			echo "Files:\r\n";
			foreach($files as $key=>$value)
			{
				echo $value."\r\n";
			}
			echo "Query Files Execution time: $execution_time\r\n";
		}
		$data="sid=$sid";
		$ch=curl_init('https://cs4743.professorvaldez.com/api/close_session');
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'content-type: application/x-www-form-urlencoded',
			'content-length: ' .strlen($data))
		);
		$time_start = microtime(true);
		$result = curl_exec($ch);
		$time_end = microtime(true);
		$execution_time = ($time_end - $time_start)/60;
		curl_close($ch);
		$cinfo=json_decode($result,true);
		if ($cinfo[0]=="Status: OK")
		{
			echo "Session successfully closed!\r\n";
			echo "SID: $sid\r\n";
			echo "Close Session execution time: $execution_time\r\n";
		}
		else
		{
			echo $cinfo[0];
			echo "\r\n";
			echo $cinfo[1];
			echo "\r\n";
			echo $cinfo[2];
			echo "\r\n";
		}
	}
	else //an error happened so view the error 
	{
		echo $cinfo[0];
		echo "\r\n";
		echo $cinfo[1];
		echo "\r\n";
		echo $cinfo[2];
		echo "\r\n";
	}
}
else //another error happened view the error 
{
	echo $cinfo[0];
	echo "\r\n";
	echo $cinfo[1];
	echo "\r\n";
	echo $cinfo[2];
	echo "\r\n";
}
?>