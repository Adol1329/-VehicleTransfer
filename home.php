<?php
	$d = mysqli_connect('localhost','root','','revision300');
	if (isset($_POST['submit'])) {
	 	$fname = $_POST['fname'];
	 	$lname = $_POST['lname'];
	 	$age = $_POST['age'];
	 	$gender = $_POST['m'];

	 	$sql = "INSERT INTO student(fname,lname,age,gender) VALUES('$fname','$lname','$age','$gender')";
	 	$result = mysqli_query($d,$sql);
	 	if ($result) {
	 		echo "Successfull Saved";
	 	}else{
	 		echo "Data not saved";
	 	}
	} 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<form method="post">
		<label>firstName</label><br>
		<input type="text" name="fname"><br>
        <label>lastName</label><br>
		<input type="text" name="lname"><br>
		<label>Age</label><br>
		<input type="number" name="age"><br>
		<label>Gender</label><br>
		<input type="radio" name="m" value="M">Male
		<input type="radio" name="m" value="F">Female<br>
		<button type="submit" name="submit">Send</button>

	</form>
</body>
</html>