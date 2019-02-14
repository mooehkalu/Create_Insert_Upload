<?php

	require_once 'dbconfig.php';
	
	if(isset($_GET['delete_id']))
	{
		// select image from db to delete
		$stmt_select = $DB_con->prepare('SELECT userPic FROM tbl_users WHERE userID =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("user_images/".$imgRow['userPic']);
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM tbl_users WHERE userID =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		header("Location: index.php");
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UploadInsertUpdateDelete</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
</head>

<body>
<div class="container">
<?php
	
	$stmt = $DB_con->prepare('SELECT userID, userName, userDepartment, userClock, userIssue,  userProfession, userPic FROM tbl_users ORDER BY userID DESC');
	$stmt->execute();



$stmt= $stmt->fetchAll();

echo "<table>";

echo "<tr><th>Name</th><th>Department</th><th>Clock Number</th><th>Issues</th><th>Changes</th><th>Picture</th></tr>";

foreach ($stmt as $row) {
echo "<tr >
<td>$row[userName]</td>
<td>$row[userDepartment]</td>
<td>$row[userClock]</td>
<td>$row[userIssue]</td>
<td>$row[userProfession]</td>
<td><a href=\"http://emoo.x10host.com/createUpload-master/user_images/" . $row['userPic'] . "\">Load Image</a></td>
</tr>";
}

echo "</table>";
?>



</div>

<style>
table {
  width:100%;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
  text-align: left;
}
table#t01 tr:nth-child(even) {
  background-color: #eee;
}
table#t01 tr:nth-child(odd) {
 background-color: #fff;
}
table#t01 th {
  background-color: black;
  color: white;
}

</style>



</body>
</html>