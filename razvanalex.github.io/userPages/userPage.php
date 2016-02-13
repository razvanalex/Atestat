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
    if($username === "admin")
        header("location: adminPage.php");
    if(!isset($login_session))
    {
        $conn->close();// Closing Connection
        header('Location: ../index.php'); // Redirecting To Home Page
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo "Welcome " . $username; ?></title>
        <style>
            table, th, td{
                border:1px solid black;
                padding-left:5px;
                padding-right:5px;
                border-collapse: collapse;
                vertical-align: middle;
                text-align:center;
            }
        </style>
    </head>
    <body>
        <h1>Welcome <?php echo $username;?></h1>
        <p>this is user page!</p>
        <br>
        <button onclick="location.href='../logon/logout.php';">SignOut</button>
    </body>
</html>