<?php
    $Thread = $_POST["Thread"];
    $Row = $_POST["Row"];
    $Text = $_POST["Text"];
    
    if($Thread == null || $Row == null || $Text == null)
        echo "Error Variable!";
        
    $json = file_get_contents("../json/Forum_Data.json");
    $data = json_decode($json);
    $data[$Thread]->Posts[$Row]->postText = $Text;
    
    file_put_contents('../json/Forum_Data.json', json_encode($data));
    
    echo $Text;
?>