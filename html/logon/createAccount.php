<?php
    include('login.php');
    $user = "Sing In";
    if(isset($_SESSION['login_user']))
        $user = $_SESSION['login_user'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create new account</title>
        <link rel="stylesheet" href="../css/main.css" type="text/css"/>
        <link rel="stylesheet" href="../css/createAcc.css" type="text/css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        
        <div class="BackGrd"></div>
        <div class="boxAcc">
            <div id="titleBox">
                <p>Create Account</p>
            </div>
            <div id="contBox">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <p><input type="text" name="<?php echo "FirstName"; ?>" placeholder="First Name:" class="TextB"/></p>
                    <p><input type="text" name="LastName" placeholder="Last Name:" class="TextB"/></p>
                    <p><input type="text" name="Username" placeholder="Username:" class="TextB"/></p>
                    <p><input type="text" name="Email" placeholder="Email:" class="TextB"/></p>
                    <p><input type="text" name="DateOfBirth" placeholder="Date of Birth:" class="TextB"/></p>
                    <p><input type="password" name="Password" placeholder="Password:" class="TextB"/></p>
                    <p><input type="password" name="RePassword" placeholder="Repeat Password:" class="TextB"/></p>
                    <center><span class="invalid"></span></center>
                    <p><center><input type="submit" value="Create Account" onclick="location.href='index.php';" class="btn"/></center></p>
                </form>
            </div>
        </div>
        
        
        <?php
            include '../ajax/InitialiseConnection.php';
            
            /*for($i=1;$i<=100; $i++)
            {
                $sql = "INSERT INTO users (Username, FirstName, LastName, Email, DateOfBirth, Password)
                VALUES('USER$i', 'USER$i', 'USER$i', 'USER$i@sample.com', '', 'USER$i')";
                $conn->query($sql);
            }*/
            
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $Username = test_input($_POST["Username"]);
                $FirstName = test_input($_POST["FirstName"]);
                $LastName = test_input($_POST["LastName"]);
                $Email = test_input($_POST["Email"]);
                $DateOfBirth = test_input($_POST["DateOfBirth"]);
                $Password  = test_input($_POST["Password"]);
                $REPassword  = test_input($_POST["RePassword"]);
                $error = "";
                
                if($Password == "" || $Username == "")
                    $error = "Required fields are empty!";
                if($Password != $REPassword)  
                    $error = "Passwords don't match!";
                
                $newformat = date('d.m.Y', strtotime($DateOfBirth));
                if($DateOfBirth !== $newformat)  {
                    $error = "Wrong date format!";
                    $DateOfBirth = date('Y.m.d', $newformat);
                }
                
                $sql = "SELECT Username FROM users";
                $result = $conn->query($sql);
                while ($db_field = $result->fetch_assoc()) 
                {
                    if($db_field["Username"] == $Username)
                        $error = "Username exists!";
                }
                
                if($error === "")
                {
                    $hashed_password = password_hash($Password, PASSWORD_BCRYPT, ['cost' => 15]);
                    $sql = "INSERT INTO users (Username, FirstName, LastName, Email, DateOfBirth, Password)
                    VALUES('$Username', '$FirstName', '$LastName', '$Email', '$DateOfBirth', '$hashed_password')";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } 
                    else echo "Error: " . $sql . "<br>" . $conn->error;
                }  
             
                $sql = "SELECT ID, Username FROM users";
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
                            $sql1 = "Update users SET ID = '$ID' WHERE Username='$username'";
                            $conn->query($sql1);
                        }
                    }
                }
                $conn->close();
                
                if($error === ""){
                    if($user === "admin")
                        header("location: ../userPages/adminPage.php");        
                    else header("location: ../index.php");
                }
            }
            
            function test_input($data) 
            {
               $data = trim($data);
               $data = stripslashes($data);
               $data = htmlspecialchars($data);
               return $data;
            }
        
        ?> 
        <span class="textInv notvisible"><?php echo $error . "&nbsp;"; ?></span><br>
        <script type="text/javascript">
            $(".invalid").text($(".textInv").text());
        </script>
    </body>
</html>