<?php
function request_loans($session_id, $username)
{
    $data = "sid=$session_id&uid=$username";
    $ch = curl_init('https://cs4743.professorvaladez.com/api/request_loans%27);
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
        {<h5></h5>
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
//            log_api_call("request_loans", "OK", $cinfo[2], $executionTime, $loans, $session_id);
            return $loans;
        }
    }
    else
    {
//        log_api_call("request_loans", "ERROR", $cinfo[2], $executionTime, $cinfo[1], $session_id);
        echo "Request Loans Error: $cinfo[1]\r\n";
        return null;
    }
}
function query_docs_by_loan($session_id, $username, $loan_number)
{
    $data = "sid=$session_id&uid=$username&lid=$loan_number";
    $ch = curl_init('https://cs4743.professorvaladez.com/api/request_file_by_loan%27);
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
?>