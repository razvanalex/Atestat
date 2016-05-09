<?php
    include('InitialiseConnection.php');
    $username_temp = $_POST['username_temp'];
    
    if(isset($_POST['action'])) 
    {
        $sql = "SELECT ID, Username FROM Users";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            while ($db_field = $result->fetch_assoc() ) 
            {
                $username = $db_field['Username'];
                if(strcmp($username, $username_temp) === 0)
                    echo $db_field['ID'];
            }
        }
        
        $sql = "Delete FROM Users Where Username = '$username_temp';";
        $conn->query($sql);
        
        $ID = 0;
        if ($result->num_rows > 0) 
        {
            while ($db_field = $result->fetch_assoc() ) 
            {
                $username = $db_field['Username'];
                $ID++;
                if($db_field['ID'] != $ID)
                {
                    $sql1 = "UPDATE Users SET ID='$ID' WHERE Username='$username'";
                    $conn->query($sql1);
                }
            }
        }
        
        
    }
    $conn->close();
?>