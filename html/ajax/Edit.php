<?php
    include('InitialiseConnection.php');

    if($_POST['action'] === "GET")
    {
        $UserName = $_POST['username_temp'];
        
        $sql = "SELECT Username, FirstName, LastName, DateOfBirth, Email, Password, ID FROM Users WHERE Username='$UserName'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
            while ($db_field = $result->fetch_assoc() ) 
            {
                
    	        $UserName = $db_field["Username"];
                $FirstName = $db_field["FirstName"];
    	        $LastName = $db_field["LastName"];
    	        $DateOfBirth = $db_field["DateOfBirth"];
    	        $Email = $db_field["Email"];
    	        $Password = $db_field["Password"];
    	        $ID = $db_field["ID"];
    	        
    		    $json = file_get_contents("../json/Edit_Data.json");
                $data = json_decode($json, true);
                
                $data["ID"] = $ID;
                $data["Username"] = $UserName;
                $data["FirstName"] = $FirstName;
                $data["LastName"] = $LastName;
                $data["DateOfBirth"] = $DateOfBirth;
                $data["Email"] = $Email;
                $data["Password"] = $Password;
                
                file_put_contents('../json/Edit_Data.json', json_encode($data));
            }
        }
    }
    if($_POST['action'] === "SET")
    {
        $OLDUserName = $_POST["oldUsername"];
        $UserName = $_POST["Username"];
        $FirstName = $_POST["FirstName"];
        $LastName = $_POST["LastName"];
        $DateOfBirth = $_POST["DateOfBirth"];
        $Email = $_POST["Email"];
        $Password = $_POST["Password"];
        $RePassword = $_POST["RePassword"];
        
        $sql1 = "SELECT Username FROM Users WHERE Username='$UserName' OR Username='$OLDUserName'";
        $result = $conn->query($sql1);
        $count = 0;
        if ($result->num_rows > 0) 
        {
            while ($db_field = $result->fetch_assoc() ) 
            {
                $count++;
            }
        }
        
        if($count > 1) echo "EEUSER";
        else if ($count = 1)
        {
            if($Password === "" && $RePassword === "")
            {
                $sql = "UPDATE Users SET Username='$UserName', FirstName='$FirstName', LastName='$LastName', DateOfBirth='$DateOfBirth', Email='$Email' WHERE Username='$OLDUserName'";
                $result = $conn->query($sql);
                
                
                $json = file_get_contents("../json/Edit_Data.json");
                $data = json_decode($json, true);
                
                $data["Username"] = $UserName;
                $data["FirstName"] = $FirstName;
                $data["LastName"] = $LastName;
                $data["DateOfBirth"] = $DateOfBirth;
                $data["Email"] = $Email;
                
                file_put_contents('../json/Edit_Data.json', json_encode($data));
            }
            else if($Password === $RePassword && ($Password !== "" && $RePassword !== "")) {
                $hashed_password = password_hash(test_input($Password), PASSWORD_BCRYPT, ['cost' => 15]);
                $sql = "UPDATE Users SET Password='$hashed_password' WHERE Username='$OLDUserName'";
                $result = $conn->query($sql);
                
                $json = file_get_contents("../json/Edit_Data.json");
                $data = json_decode($json, true);
    
                $data["Password"] = $hashed_password;
                
                file_put_contents('../json/Edit_Data.json', json_encode($data));
            }
            else echo "NPASS";
        }
    }
    
    if($_POST['action'] === "UPDATE")
    {
        $Id1 = $_POST["Id"];
    	$UserName1 = $_POST["Username"];
        $FirstName1 = $_POST["FirstName"];
        $LastName1 = $_POST["LastName"];
        $DateOfBirth1 = $_POST["DateOfBirth"];
        $Email1= $_POST["Email"];
        $Password1 = $_POST["Password"];
        
        $sql = "SELECT * FROM Users";
        $result = $conn->query($sql);
        
        $ID_Check=0;
        if ($result->num_rows > 0) 
        {
            while ($db_field = $result->fetch_assoc() ) 
            {
                if ($Id1[$ID_Check] !== $db_field["ID"])   
                    $Id1[$ID_Check] = $db_field["ID"];
    	        if ($UserName1[$ID_Check] !== $db_field["Username"])
    	            $UserName1[$ID_Check] = $db_field["Username"];
                if ($FirstName1[$ID_Check] !== $db_field["FirstName"])
                    $FirstName1[$ID_Check] = $db_field["FirstName"];
    	        if ($LastName1[$ID_Check] !== $db_field["LastName"])
    	            $LastName1[$ID_Check] = $db_field["LastName"];
    	        if ($DateOfBirth1[$ID_Check] !== $db_field["DateOfBirth"])
    	            $DateOfBirth1[$ID_Check] = $db_field["DateOfBirth"];
    	        if ($Email1[$ID_Check] !== $db_field["Email"])
    	            $Email1[$ID_Check] = $db_field["Email"];
    	        if ($Password1[$ID_Check] !== $db_field["Password"])
    	            $Password1[$ID_Check] = $db_field["Password"];
    	    
        	    $json = file_get_contents("../json/Update_Data.json");
                $data = json_decode($json, true);
               
                $data[$ID_Check]["ID"] = $Id1[$ID_Check];
                $data[$ID_Check]["Username"] = $UserName1[$ID_Check];
                $data[$ID_Check]["FirstName"] = $FirstName1[$ID_Check];
                $data[$ID_Check]["LastName"] = $LastName1[$ID_Check];
                $data[$ID_Check]["DateOfBirth"] = $DateOfBirth1[$ID_Check];
                $data[$ID_Check]["Email"] = $Email1[$ID_Check];
                $data[$ID_Check]["Password"] = $Password1[$ID_Check];
                
                file_put_contents('../json/Update_Data.json', json_encode($data));
            
    	        $ID_Check++;
            }
        }
        echo $ID_Check;
    }
    
    if($_POST['action'] === "GET_ID")
    {
        $GETID = $_POST["ID"];
        $sql = "SELECT Username FROM Users Where ID='$GETID'";
        $result = $conn->query($sql);
        
        print $result->fetch_assoc()["Username"];
    }
    
    
  function test_input($data) 
        {
           $data = trim($data);
           $data = stripslashes($data);
           $data = htmlspecialchars($data);
           return $data;
        }
            
?>