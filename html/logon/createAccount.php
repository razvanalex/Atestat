<!DOCTYPE html>
<html>
    <head>
        <title>New account</title>
         <link rel="stylesheet" href="../css/main.css" type="text/css"/>
    </head>
    <body>
        <div>
            <h1>Create Account</h1>
        </div>
        
        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <p>First Name: <input type="text" name="<?php echo "FirstName"; ?>" placeholder="First Name"/></p>
                <p>Last Name: <input type="text" name="LastName" placeholder="Last Name"/></p>
                <p>Username: <input type="text" name="Username" placeholder="Username"/></p>
                <p>Email: <input type="text" name="Email" placeholder="Email"/></p>
                <p>Date of Birth: <input type="text" name="DateOfBirth" placeholder="Date of Birth"/></p>
                <p>Password: <input type="text" name="Password" placeholder="Password"/></p>
                <p>Repeat Password: <input type="text" name="RePassword" placeholder="Repeat Password"/></p>
                <p><input type="submit" value="Create Account" onclick="location.href='index.php';"/></p>
            </form>
        </div>
        
        <?php
            include '../ajax/InitialiseConnection.php';
            
            /*for($i=1;$i<=100; $i++)
            {
                $sql = "INSERT INTO Users (Username, FirstName, LastName, Email, DateOfBirth, Password)
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
             
                $sql = "SELECT Username FROM Users";
                $result = $conn->query($sql);
                while ($db_field = $result->fetch_assoc()) 
                {
                    if($db_field["Username"] == $Username)
                        $error = "Username exists!";
                }
                
                if($error == "")
                {
                    $hashed_password = password_hash($Password, PASSWORD_BCRYPT, ['cost' => 15]);
                    $sql = "INSERT INTO Users (Username, FirstName, LastName, Email, DateOfBirth, Password)
                    VALUES('$Username', '$FirstName', '$LastName', '$Email', '$DateOfBirth', '$hashed_password')";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } 
                    else echo "Error: " . $sql . "<br>" . $conn->error;
                }  
             
                $sql = "SELECT ID, Username FROM Users";
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
                    }
                }
                
                $conn->close();
            }
            
            function test_input($data) 
            {
               $data = trim($data);
               $data = stripslashes($data);
               $data = htmlspecialchars($data);
               return $data;
            }

        ?> 
        <span class="invalid"><?php echo $error; ?></span><br>
        <button onclick="location.href='../index.php';">Go back</button>
    </body>
</html>