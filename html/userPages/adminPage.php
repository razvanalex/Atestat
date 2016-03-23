 <?php
	include('../ajax/InitialiseConnection.php');
	session_start();// Starting Session
	// Storing Session
	$username = $_SESSION['login_user'];
	
	// SQL Query To Fetch Complete Information Of User
	$sql = "SELECT Username FROM Users WHERE Username='$username'";
	
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$login_session = $row['Username'];
	if(!isset($login_session))
	{
		$conn->close();// Closing Connection
		header('Location: ../index.php'); // Redirecting To Home Pagpe
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo "Welcome to " . $username; ?></title>
		<link rel="stylesheet" href="../css/UI.css" type="text/css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	<body>
		
		<div class="Search">
		<form method="post">
			<p>Search: <input type="text" name="search"/>
			<select>
				<option>ID</option>
				<option>Username</option>
				<option>First Name</option>
				<option>Last Name</option>
				<option>Email</option>
				<option>Date of Birth</option>
			</select>
			</p>
		</form>	
		</div>
		
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Date of Birth</th>
					<th>Password</th>
					<th>Properties</th>
				</tr>
			</thead>
			<tbody  id="myTable">
				<?php  
					$sql = "SELECT ID, Username, FirstName, LastName, Email, DateOfBirth, Password FROM Users";
					$result = $conn->query($sql);
				 
					if ($result->num_rows > 0) 
					{
						$ID = 0;
						while ($db_field = $result->fetch_assoc() ) 
						{
							$ID++;
							$username = $db_field['Username'];
							if($db_field['ID'] != $ID)
							{
								$sql1 = "Update Users SET ID = '$ID' WHERE Username='$username'";
								$conn->query($sql1);
							}  
							$username_temp = $db_field['Username'];
							print "<tr>";
							print "<td id='$ID'>" . $db_field['ID'] . "</td>";
	  						print "<td>" . $db_field['Username'] . "</td>";
							print "<td>" . $db_field['FirstName'] . "</td>";
							print "<td>" . $db_field['LastName'] . "</td>";
							print "<td>" . $db_field['Email'] . "</td>";
							print "<td>" . $db_field['DateOfBirth'] . "</td>";
							print "<td>" . $db_field['Password'] . "</td>";
							print "<td>"; 
							?>
							
							<img class='edit' value="Edit" onclick="Edit('<?php echo $db_field['Username']?>');" src='https://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/256/Actions-document-edit-icon.png' height='21' width='21'/> 
							<img class='remove' value="Delete" name = '<?php echo $username_temp?>' onclick="YesNoBtn('<?php echo $db_field['Username']?>')" src='https://icons.iconarchive.com/icons/custom-icon-design/office/256/delete-icon.png' height='21' width='21'/>
							</td>
							<?php
							print "</tr>";
						}
					}
				?>
			</tbody>
		</table>
		<br>
		
		<div class='Panel Delete NOTvisible'>
			<div class="title">Delete</div><br>
			<p class="text">Are you sure you want to remove <span id="user">USER</span>?</p>
			<button class='button yes' ID='yes'>Yes</button> 
			<button class='button no' ID='no'>No</button>
		</div>
		
		<div class='Panel Edit NOTvisible'>
			<div class="title">Edit</div><br>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <p>First Name: <input ID="FirstName" type="text" name="<?php echo "FirstName"; ?>" placeholder="First Name"/></p>
                <p>Last Name:  <input ID="LastName" type="text" name="LastName" placeholder="Last Name"/></p>
                <p>Username:   <input ID="Username" type="text" name="Username" placeholder="Username"/></p>
                <p>Email:  <input ID="Email" type="text" name="Email" placeholder="Email"/></p>
                <p>Date of Birth: <input ID="DateOfBirth" type="text" name="DateOfBirth" placeholder="Date of Birth"/></p>
                <span>Change Password</span>
                <p>Password: <input ID="Password" type="Password" name="Password" placeholder="Password"/></p>
                <p>Repeat Password: <input ID="RePassword" type="Password" name="RePassword" placeholder="Repeat Password"/></p>
                <p><span class="Error NOTvisible">Wrong Password!</span></p>
                <ul class="BTNS">
                	<li><input type="button" value="Save" name="Save" class='button' ID='Save'/></li>
                	<li><button class='button' ID='Cancel'>Cancel</button></li>
                </ul>
            </form>

		</div>
		
		<button onclick="location.href='../logon/logout.php';">SignOut</button>
		<button onclick="location.href='../logon/createAccount.php';">Add account</button>
		<button onclick="location.href='../logon/Problems.php';">Login Problems</button>
		
		<script type="text/javascript" src="../js/UI.js"></script>
	</body>
</html>