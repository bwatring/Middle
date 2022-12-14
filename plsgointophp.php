<?php
	if (isset($_POST['submit'])) {

		$name = $_POST['name'];

		if (isset($_FILES['pdf_file']['name']))
		{
		$file_name = $_FILES['pdf_file']['name'];
		$file_tmp = $_FILES['pdf_file']['tmp_name'];

		move_uploaded_file($file_tmp,"./pdf/".$file_name);

		$insertquery =
		"INSERT INTO pdf_data(username,filename) VALUES('$name','$file_name')";
		$iquery = mysqli_query($con, $insertquery);
		}
		else
		{
		?>
			<div class=
			"alert alert-danger alert-dismissible
			fade show text-center">
			<a class="close" data-dismiss="alert"
				aria-label="close">×</a>
			<strong>Failed!</strong>
				File must be uploaded in PDF format!
			</div>
		<?php
		}
	}
?>
