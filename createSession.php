<?php
$page="createSession.php";
if ($username==NULL || $password==NULL)
{
	log_error($_SERVER['REMOTE_ADDR'], "NULL SID", "Null credential information",$_SERVER['REQUEST_URI'],$page);
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]="Status: Invalid Data";
	$output[]="MSG: Username or password cannot be null";
	$output[]="Action: Please try again.";
	$responseData=json_encode($output);
	echo $responseData;
	die();
}
else
{
	$dblink=db_connect("cs4743");
	$now=date("Y-m-d H:i:s");
	$salt=microtime();
	$username=addslashes(strtolower($username));
	$sql="Select * from `users` where `username`='$username'";
	$rst=$dblink->query($sql)or
		log_error($_SERVER['REMOTE_ADDR'], "NULL SID","Could not execute queryfor 
		$username/$password pair",$sql,$page);
	$info=$rst->fetch_array(MYSQLI_ASSOC);
	$dbSession=sha1($info['username'].$info['password'].$salt);
	$session=sha1($username.$password.$salt);
	if($dbSession==$session)
	{
		$slink=db_connect("sessions");
		$sql="Select `sid`,`uid` from `sessions` where `uid`='$username'";
		$rst=$slink->query($sql) or
			log_error($username,"Could not execute query",$sql,$page);
		if ($rst->num_rows>=1)
		{
			$tmp=$rst->fetch_array(MYSQLI_ASSOC);
			log_error($tmp['uid'],$tmp['sid'],"$tmp[uid] must clear previoius
			sid:$tmp[sid]",$sql,$page);
			header('Content-Type: application/json');
			header('HTTP/1.1 200 OK');
			$output[]="Status: Error";
			$output[]="MSG: Previous Session Found.";
			$output[]="Action: Must clear session first.";
			$responseData=json_encode($output);
			echo $responseData;
			die();
		}
		else
		{
			$sql="Insert into `sessions`
			(`sid`,`uid`,`location`,`in_time`,`c_time`,`update_time`) values
			('$dbSession', '$username','$_SERVER[REMOTE_ADDR]','$now','$now')";
			$slink->query($sql) or
				log_error($username,$dbSession,"Could not execute query",$sql,$page);
			header('Content-Type: application/json');
			header('HTTP/1.1 200 OK');
			$output[]="Status: OK";
			$output[]="MSG: Session Created";
			$output[]="$dbSession";
			$responseData=json_encode($output);
			track_session($username,$dbSession,$page,"Session created sucessfully");
			echo $responseData;
			die();
		}
	}
	else
	{
		header('Content-Type:application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: Error';
		$output[]='MSG: Invalid credentials';
		$output[]='Action: Please try again';
		log_error($_SERVER['REMOTE_ADDR'],"Invalid credentials $dbSession<>,$session",$_SERVER['REQUEST_URI'],$page);
		$responseData=json_encode($output);
		echo $responseData;
		die();
		
	}
	
}
?>