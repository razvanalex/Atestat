 <?php
	include('../ajax/InitialiseConnection.php');
	session_start();// Starting Session
	// Storing Session
	$username = $_SESSION['login_user'];
	
	// SQL Query To Fetch Complete Information Of User
	$sql = "SELECT Username FROM users WHERE Username='$username'";
	
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
        <table id="myTable">
            <?php 
              	$json = file_get_contents("../json/User_Pass_Req.json");
                $data = json_decode($json);
            
                for ($i = 0; $i<count($data); $i++) {
                  echo "<tr>
                            <td><span>" . ($i + 1) ."</span></td>
                            <td><span>" . $data[$i]->Username ."</span></td>
                        </tr>";
                }
            ?>
        </table>
    </body>
</html>