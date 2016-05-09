<?php
    $servername = "localhost";
    $Susername = "root";
    $Spassword = "";
    $dbname = "Accounts";
    
    // Create connection
    $conn = new mysqli($servername, $Susername, $Spassword, $dbname);
    // Check connection
    if ($conn -> connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }
?>