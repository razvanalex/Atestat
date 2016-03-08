<?php
    include('logon/login.php');
    $user = "Sing In";
    if(isset($_SESSION['login_user']))
    {
       /* if($username === "admin")
            header("location:  userPages/adminPage.php");        
        else header("location: userPages/userPage.php"); */
        $user = $_SESSION['login_user'];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Home Page</title>
        <link rel="stylesheet" href="css/main.css" type="text/css"/> 
        <link rel="stylesheet" href="css/forum.css" type="text/css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        
        <div class="menu-bar">
            <div class="menu-bkg"></div>
            <ul>
                <li class="ul-left"><a href="index.php">Home</a></li>
                <li class="ul-left"><a href="download.php">Download</a></li>
                <li class="ul-left selected"><a href="forum.php?pg=1">Forum</a></li>
                <li class="ul-left"><a href="about.php">About Us</a></li>
            </ul>
            <ul>
                <?php
                    if($user === "Sing In")
                        echo "<li class='ul-right SignIn-btn'><a href='#!'>Sign In</a></li>";
                    else echo "<li class='ul-right SignIn-btn'><a href='#!'>" . $user . "</a></li>";
                ?>
            </ul>
        </div>
        
       <div class='SignIn'>
            <div class="icon-close">
                <img src="https://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png">
             </div>
         <?php
            if($user === "Sing In"){
                echo '
                    <form class="LogLBL" action="" method="post"> 
                        <p><input type="text" name="Username" placeholder="Username" class="textbox"/></p>
                        <p><input type="password" name="Password" placeholder="Password" class="textbox"/></p>
                        <p><input type="Submit" name="Submit" value="Sign in" class="button" /></p>
                    </form>
                    
                    <div class="FgtPass">
                        <span class="invalid"><p>' . $error . '</p></span>
                        <p><a href="#">Forgot your password?</a></p>
                        <p><a href="#">Cannot access your accout?</a></p>
                        <p><a href="logon/createAccount.php">Create an account</a></p>
                    </div>';
            }
            else {
                echo "
                    <div class='LogLBL'>
                        <div class='button centerDIV' onclick=" . "location.href='./logon/logout.php';" . ">Sign Out</div><br>
                    </div>
                    ";
                if($user === "admin") {
                      echo "<div class='button centerDIV' onclick=" . "location.href='./userPages/adminPage.php';" . ">Admin Page</div>";  
                }
                else {
                    echo "<div class='button centerDIV' onclick=" . "location.href='./userPages/userPage.php';" . ">" . $user . " Page</div>";
                }
            }
        ?>
        
        </div>
      
        <div class="forumContent">
            <div class="content"> 
                <div class="forum">
                    <span>Forum</span>
                </div><br>
                <?php
                    if($user !== "Sing In")
                         echo " <div class='barTable'>
                                    <div class='btn'><a href='forum/addThread.php'>Add Thread</a></div>
                                </div>";
                                
                //ToDo: Design (+ About);
                //Optional: LiveUpdate
                ?>
            
                <div class="tableForum">
                    <table>
                        <?php
      	                $json = file_get_contents("./json/Forum_Data.json");
                        $data = json_decode($json);
                        
                        $perPage = 7;
                        $currentPage = $_GET["pg"];
                        $res = (int)(count($data) / $perPage);

                        if(count($data) % $perPage !== 0)
                            $res++;
                        
                        for ($i = $perPage * ($currentPage - 1); $i< $perPage * $currentPage; $i++) {
                            if($data[$i] !== null){
                                    
                                if($data[$i]->When === date('jS F Y'))
                                    $data[$i]->When = "Today";
                                
                                echo "<tr>
                                    <td class='nameThread'>
                                        <span class='TitleThread'><a href='forum/Thread.php?th=". $i . "&pg=1'>" . $data[$i]->Name . "</a></span><br>
                                        <span>Thread by: " . $data[$i]->Author . "</span>
                                    </td>
                                    <td class='lastPost'>
                                        <span>Last post by " . $data[$i]->lastPost . "</span><br>
                                        <span> " . $data[$i]->LastWhen . " at " . $data[$i]->Posts[$data[$i]->noPosts - 1]->HM ."</span>
                                    </td>
                                    <td class='Views'>
                                         <span>Posts: " . $data[$i]->noPosts . "</span><br>
                                        <span>Views: " . $data[$i]->noViews . "</span>
                                    </td>
                                </tr>";
                                }
                            }
                        ?>
                    </table><br>
                </div>
                
                <div class="pages">
                    <?php
                        for ($i=1; $i<=$res; $i++) {
                            if($i == $_GET["pg"])
                                print "<strong>" . $i ."</strong>";
                            else print " <a href='?pg=" . $i . "'>" . $i . "</a> ";
                        }
                    ?>
                </div>
            </div>
        </div>


        <div class="bottomTab">
            <hr>
            <p>Copyright© 2016</p>
        </div>  

        <script src="js/script.js"></script>
        <script src="js/SmoothScroll.js"></script>
    </body>
</html>