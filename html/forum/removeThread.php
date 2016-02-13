<?php
    $th = $_GET["th"];
    $json = file_get_contents("../json/Forum_Data.json");
    $data = json_decode($json);
    unset($data[$th]); //// FIX THIS!!
    file_put_contents('../json/Forum_Data.json', json_encode($data));
    header("location: ../forum.php?pg=1");  
?>