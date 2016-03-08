<?php
   class ThPosts{
            public $postBy;
            public $postText;
            public $HM;
            public $TimeZone;
            public $When;
            
            public function __construct($postBy, $postText, $TIMEZONE) {
                $this->postBy = $postBy;
                $this->postText = $postText;
                date_default_timezone_set('UTC');
                $this->TimeZone = $TIMEZONE;
                $UTC = date('H:i');
                $this->HM = date('H:i', strtotime($UTC . '+' . $TIMEZONE . ' hours'));
                $this->When = date('jS F Y');
            }
        } 
        
    class Thread { 
        public $Name;
        public $Author;
        public $lastPost;
        public $LastWhen;
        public $noPosts = 1;
        public $noViews = 1;
        public $Posts = array();
        
        public function __construct($Name, $Author, $Posts) {
            $this->Name = $Name;
            $this->Author = $Author;
            $this->lastPost = $Author;
            $this->LastWhen = date('jS F Y');
            array_push($this->Posts, $Posts);
        }
    }
        
    if($_GET["type"] === "Th")
    {
        $name = $_POST["name"];
        $text = $_POST["comment"];
        $author = $_GET["user"];
        $TIMEZONE = $_POST["time"]; 
        
        $FirstPost = new ThPosts($author, $text, $TIMEZONE);
        $newData = new Thread($name, $author, $FirstPost);
        
        $json = file_get_contents("../json/Forum_Data.json");
        $data = json_decode($json);  
        
        array_push($data, $newData);
        file_put_contents('../json/Forum_Data.json', json_encode($data));
        header("location: ../forum.php?pg=1");
    }
    if($_GET["type"] === "Post")
    {
        $text = $_POST["comment"];
        $th= $_GET["th"];
        $user = $_GET["user"];
        $TIMEZONE = $_POST["time"]; 
        
        $NewPost = new ThPosts($user, $text, $TIMEZONE);
        
        $json = file_get_contents("../json/Forum_Data.json");
        $data = json_decode($json);
        array_push($data[$th]->Posts, $NewPost);
        
        $data[$th]->lastPosts = $user;
        $data[$th]->noPosts = count($data[$th]->Posts);
        $data[$th]->LastWhen = date('jS F Y');
    
        file_put_contents('../json/Forum_Data.json', json_encode($data));
        header("location: ../forum/Thread.php?th=" . $th . "&pg=1");
    }
?>