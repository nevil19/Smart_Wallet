<style>
td{
	padding: 10px;
}
</style>
<?php
include ("conection.php");
error_reporting(0);
$query = "SELECT * FROM user";
$data = mysqli_query($conn, $query);
$total = mysqli_num_rows($data);

if($total != 0){
?>

<table>
	<tr>
		<th>UserId</th>
		<th>FirstName</th>
		<th>LastName</th>
		<th>Email</th>
		<th>Currency</th>
		<th colspan = "2">Operations</th>
	</tr>

	<?php
	while ($result = mysqli_fetch_assoc($data)){
		echo "<tr>
		         <td>".$result['UserId']."</td>
		         <td>".$result['FirstName']."</td>
		         <td>".$result['LastName']."</td>
		         <td>".$result['Email']."</td>
		         <td>".$result['Currency']."</td>
		         <td><a href='update.php?id=$result[UserId] &fn=$result[FirstName] &ln=$result[LastName] &email=$result[Email] &cu=$result[Currency]'>Edit</a></td>
		         <td><a href='update.php'>Delete</a></td>
		</tr>";
	}
}

else {
	echo "No Record Found";
}
?>
</table>

?>