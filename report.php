<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/bootstrap-fileupload.js"></script>
<?php
$page="report.php";
include("functions.php");
$dblink=db_connect("docstorage");
echo '<div id="page-inner">';
echo '<h1 class="page-head-line">Brynna Watring - Reporting and Analytics </h1>';
echo '<div class="panel-body">';
echo '<div class="page-head-line">Total number of unique loan numbers: 29<p> </h2>';
echo '<div class="page-head-line">All Unique Loan Numbers:
<p>17936240,	03217869,	69300872<p>

39287004,	67821039,	17638290<p>

02631894,	36124780,	87293106<p>

17430268,	67910843,	29810047<p>

07429638,	61478032,	70632149<p>

62039741,	26734008,	81329647<p>

07462839,	31706482,	97042138<p>

73216890,	27134089,	20843179<p>

64789130,	43209716,	41962380<p>

94826107,	 01329874
<p> </h2>';
echo '<div class="page-head-line">The total size of all documents recieved from the API and the average size of all documents across all loans: <p>  </h2>';
echo '<div class="page-head-line">The total size of all documents recieved from the API: 9.65 MB (10,125,593 bytes) <p>  </h2>';
echo '<div class="page-head-line">The average size of all documents across all loans: 123.04MB <p>  </h2>';

echo '<div class="page-head-line">A list of all loan numbers that are missing doc and what they are missing:
<p>
17936240 missing: other		
<p> 
69300872 missing: credit, title, and legal 
<p> 
03217869 missing: closing legal internal
<p> 
69300872 missing: credit, title, and legal 
<p> 
39287004 missing: title, financial, personal, internal, legal, and other 
<p> 
67821039 missing: credit, closing, personal, legal, and other 
<p> 
17638290 missing: credit, closing, financial, and internal 
<p> 
02631894 missing: credit, title, and financial 
<p> 
36124780 missing: closing, title, internal, and other 
<p> 
87293106 missing: credit, financial, and internal 
<p> 
17430268 missing: closing, financial, personal, legal, and other 
<p> 
67910843 missing: closing, title, and title  
<p> 
29810047 missing: closing, personal, internal, legal, and other 
<p> 
07429638 missing: credit, closing, title, financial and personal
<p> 
61478032 missing: credit, closing, title, financial, and other 
<p> 
70632149 missing: credit, title, financial, personal, internal, legal, and other 
<p> 
62039741 missing: credit, closing, title, personal, internal, legal, and other 
<p> 
26734008 missing: closing, personal, internal, legal, and other 
<p> 
81329647 missing: closing, financial, and personal 
<p> 
07462839 missing: credit, closing, financial, personal, legal, and oher
<p> 
31706482 missing: closing, title, financial, personal, internal, legal, and other 
<p> 
97042138 missing: credit, closing, personal, and internal 
<p> 
73216890 missing: closing, title, financial, and legal 
<p> 
27134089 missing: credit, title, and legal 
<p> 
20843179 missing: credit, title, financial, internal, and other 
<p> 
64789130 missing: closing, personal, internal, and legal 
<p> 
43209716 missing: credit, closing, title, personal, internal, legal, and other 
<p> 
41962380 missing: financial, personal, internal, and legal 
<p> 
94826107 missing: credit, title, financial, and personal 
<p> 
01329874 missing: credit, closing, title, financial, personal, legal, and other 



<p> </h2>';


echo '<div class="page-head-line">A list of all loan numbers that have all documents:<p> 

There were no loan numbers that had all 8 of the documents. 	


<p> </h2>';

$sql="Select * from `documents` where `status`='active'";
$result=$dblink->query($sql) or
	die("Something went wrong with $sql<br>".$dblink->error);
$loanArray=array();
while ($data=$result->fetch_array(MYSQLI_ASSOC))
{
	$tmp=explode("-",$data['document']);
	$loanArray[]=$tmp[0];
}
$loanUnique=array_unique($loanArray);
foreach($loanUnique as $key=>$value)
{
	$sql="Select count(`document`) from `documents` where `document` like '%value%'";
	$rst=$dblink->query($sql) or 
		die("Something went wrong with: $sql<br>".$dblink->error);
	$tmp=$rst->fetch_array(MYSQLI_NUM);
	echo '<div>Loan number: '.$value.' has '.$tmp[0].'number of documents</div>';
		
		//{
			//fwrite($fp,$content);
			//fclose($fp);
			//echo '<p>File: <a href="recieve/'.$loanNumber.'">'.$data['loan_number'].'</a></p>';
		//}
	}

echo '</div>';//end panel-body
echo '</div>';//end page-inner
?>