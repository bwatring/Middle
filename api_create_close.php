<?php
//Creating Session
#create,close,recieve 
$username="jlg480";
//%23== # 
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
	echo "\r\nSession Created Successfully!\r\n";
	echo "SID: $sid\r\n";
	echo "Create Session Execution Time: $execution_time\r\n";

	//Request Files
	$ch=curl_init('https://cs4743.professorvaladez.com/api/query_files?sid=' . $sid . '&uid=jlg480');
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
	if ($cinfo[0]=="Status: OK")
	{
		if($cinfo[1]=="Action: None")
	
		{
			echo "\r\nNo new files to import found\r\n";
			echo "SID: $sid\r\n";
			echo "Username: $username\r\n";
			echo "Query files execution time: $executionTime\r\n";
			echo "\r\n";
		}
		else
		{
		
			$tmp=explode(":", $cinfo[1]);
			$files=explode(",",$tmp[1]);
			echo "Number of new files to import found: ".count($files)."\r\n";
			echo "Files:\r\n";
			foreach($files as $key=>$value)
			{
				echo $value."\r\n";
			}
			
			foreach($files as $key=>$value)
            {

                $tmp=explode("/", $value);
                $file=$tmp[4];
                echo "File: $file\r\n";
                $data="sid=$sid&uid=$username&fid=$file";
                $ch=curl_init('https://cs4743.professorvaladez.com/api/request_file?sid=' . $sid . '&uid=jlg480&fid=' . $file);
                curl_setopt($ch, CURLOPT_POST, 1); #opening curl connection post
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); #transfer variables and dont spit them out to terminal
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'content-type: application/x-www-form-urlencode', 
                    'content-length: ' . strlen($data))); #sending length of content and content type everytime
                $result = curl_exec($ch); #executes the given CURL session
                $content=$result;
                #print_r($result);
                $fp=fopen("/var/www/html/recieve/$file","wb");
                fwrite($fp,$content);
                fclose($fp);
                echo "\r\n$file written to file system\r\n";
			}
			echo "\r\nQuery Files Execution time: $execution_time\r\n";
		
		}
	}
	//upload to phpmyadmin 
			$tmp=explode(":", $cinfo[1]);
			$files=explode(",",$tmp[1]);
			echo "Number of new files to import found: ".count($files)."\r\n";
			echo "Files:\r\n";
	foreach($files as $key=>$value)
			{
				echo $value."\r\n";
			}
			
			foreach($files as $key=>$value)
				
	if (isset($_POST['submit']))
{
   	$hostname="localhost";
    $username="webuser";
    $password="hello";
    $db="docstorage";
    $dblink=new mysqli($hostname,$username,$password,$db);
    if (mysqli_connect_errno())
    {
        die("Error connecting to database: ".mysqli_connect_error());   
    }
	$uploadDate=date("Y-m-d H:i:s");
	$uploadDName=date("Y-m-d_H:i:s");
	$uploadBy="user@test.mail";
	$fileName=str_replace(" ","_",$_FILES['userfile']['name']);
	$fileName=$uploadDName.$fileName;
	$docType="pdf";
	$tmpName=$_FILES['userfile']['tmp_name'];
	$fileSize=$_FILES['userfile']['size'];
	$fileType=$_FILES['userfile']['type'];
    $path="/var/www/html/recieve/";
	$fp=fopen($tmpName, 'r');
	$content=fread($fp, filesize($tmpName));
	fclose($fp);
	$contentsClean=addslashes($content);
	$sql="Insert into `documents` (`name`,`path`,`upload_by`,`upload_date`,`status`,`file_type`,`content`) values ('$fileName','$path','$uploadBy','$uploadDate','active','$docType','$contentsClean')";
	$dblink->query($sql) or
		die("Something went wrong with $sql<br>".$dblink->error);
	}

	//Close Files 
	
	$ch=curl_init('https://cs4743.professorvaladez.com/api/close_session?sid=' . $sid . '&username=jlg480');
		curl_setopt($ch, CURLOPT_POST,1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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


?>