<?php
    $th = $_GET["th"];
    $json = file_get_contents("../json/Forum_Data.json");
    $data = json_decode($json);
   
    for($i = $th; $i < count($data); $i++)
        $data[$i] = $data[$i + 1];
    unset($data[count($data)-1]);
     
    file_put_contents('../json/Forum_Data.json', json_encode($data));
    header("location: ../forum.php?pg=1");  
?>