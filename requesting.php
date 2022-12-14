<?php
$username="jlg480";
$password="98%23fwBtVKj!pYL4";
//$data = "sid=$session_id&uid=$username";
function request_loans($session_id, $username)
{
//request loans 
$username="jlg480";
$password="98%23fwBtVKj!pYL4";
$data = "sid=$session_id&uid=$username";

    $ch = curl_init('https://cs4743.professorvaladez.com/api/request_loans%29');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Content-Length: ' . strlen($data))
    );
    $timeStart = microtime(true); //start timer
    $result = curl_exec($ch); // executes our curl request
    $timeEnd = microtime(true); //end timer
    $executionTime = ($timeEnd - $timeStart) / 60; //dividing with 60 will give the execution time in seconds
    curl_close($ch);
    $cinfo = json_decode($result, true); // curl response payload array
    if ($cinfo[0] == "Status: OK")
    {
        if ($cinfo[2] == "Action: None")
        {
//            log_api_call("request_loans", "OK", "None", $executionTime, $cinfo[1], $session_id);
            echo "No loans found";
            echo "\r\n";
            return false;
        }
        else
        {
            echo '$cinof[1]: ' . $cinfo[1] . "\r";
            $tmp = explode(" ", $cinfo[1]);
            $loans = explode(",", $tmp[1]);
            array_walk($loans, function(&$value, $key) {
                $value = str_replace('"', '', $value);
                $value = str_replace('[', '', $value);
                $value = str_replace(']', '', $value);
            });
            foreach ($loans as $loan) {
                echo "Loan: $loan\r\n";
            }
            //log_api_call("request_loans", "OK", $cinfo[2], $executionTime, $loans, $session_id);
            return $loans;
        }
    }
    else
    {
        //log_api_call("request_loans", "ERROR", $cinfo[2], $executionTime, $cinfo[1], $session_id);
        echo "Request Loans Error: $cinfo[1]\r\n";
        return null;
    }
}
//query docs by loan 
function query_docs_by_loan($session_id, $username, $loan_number)
{
    $data = "sid=$session_id&uid=$username&lid=$loan_number";
    $ch = curl_init('https://cs4743.professorvaladez.com/api/request_file_by_loan%29');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Content-Length: ' . strlen($data))
    );
    $timeStart = microtime(true); //start timer
    $result = curl_exec($ch); // executes our curl request
    $timeEnd = microtime(true); //end timer
    $executionTime = ($timeEnd - $timeStart) / 60; //dividing with 60 will give the execution time in seconds
    curl_close($ch);
    $cinfo = json_decode($result, true); // curl response payload array
    if ($cinfo[0] == "Status: OK")
    {
        if ($cinfo[2] == "Action: None")
        {
//            log_api_call("query_files", "OK", "None", $executionTime, $cinfo[1], $session_id);
            echo "No new files found";
            echo "\r\n";
            return false;
        }
        else
        {
            $tmp = explode(" ", $cinfo[1]);
            $files = explode(",", $tmp[1]);

            array_walk($files, function(&$value, $key) {
                $value = str_replace('"', '', $value);
                $value = str_replace('[', '', $value);
                $value = str_replace(']', '', $value);
            });

            echo "$loan_number: \r\n";
            foreach ($files as $file) {
                echo "File: $file\r\n";
            }
            echo "\r\n";
//            log_api_call("query_files", "OK", $cinfo[2], $executionTime, $files, $session_id);
            return $files;
        }
    }
    else
    {
//        log_api_call("query_files", "ERROR", $cinfo[2], $executionTime, $cinfo[1], $session_id);
        echo "Error: $cinfo[1]\r\n";
        return null;
    }
}

//store and upload file into database php myadmin 
//$sid=$cinfo[2];

$tmp=explode(":", $cinfo[2]);
			$files=explode(",",$tmp[2]);
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
    $db="blackbox";
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
	//$fp=fopen($path.$fileName,"wb") or
	//	die("Could not open $path$fileName for writing");
	//fwrite($fp,$content);
	//fclose($fp);
	//header("Location: https://192.168.56.103/upload.php?msg=success");
	header("Location: 192.168.56.103/upload.php?msg=success");
}
			
		


	




?>