<?php
    include('InitialiseConnection.php');
    $sql = "SELECT ID, Username FROM Users";
    $result = $conn->query($sql);
  
    if(isset($_POST['ArrangeID'])) 
    {
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