<?php
    session_start(); // Starting Session
    $error=''; // Variable To Store Error Message
    if (isset($_POST['Submit'])) 
    {
        if (empty($_POST['Username']) || empty($_POST['Password'])) 
        {
            $error = "Username or Password is invalid";
        }
        else
        {

            if(!@include("./ajax/InitialiseConnection.php"))
                include('../ajax/InitialiseConnection.php');
            
            // Define $username and $password
            $username=$_POST['Username'];
            $password=$_POST['Password'];

            // To protect MySQL injection for Security purpose
            $username = stripslashes($username);
            
            // SQL query to fetch information of registerd users and finds user match.
            $sql = "SELECT Username, Password FROM Users";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0)
            { 
                while ($db_field = $result->fetch_assoc()) 
                {
                    if (password_verify($password, $db_field["Password"]) && $username == $db_field["Username"])
                    {
                        $_SESSION['login_user'] = $username; // Initializing Session
                        // header('Location: ./index.php');
                    }
                    else $error = " Invalid Password or Username ";
                }
            } 
            else 
            {
                $error = " Invalid Password or Username ";
            }
                
            $conn->close(); // Closing Connection
        }
    }
    
    class PassProblem { 
        public $Username;
        public function __construct($Username) {
            $this->Username = $Username;
        }
    }
    
    if($_GET["Submit"] === "Lost")
    {
        $user = $_POST["Username"];
        $json = file_get_contents("../json/User_Pass_Req.json");
        $data = json_decode($json, true);
        $newData = new PassProblem($user);
        
        array_push($data, $newData);
        file_put_contents('../json/User_Pass_Req.json', json_encode($data));
        
        header('Location: ../index.php');
    }
    
?>