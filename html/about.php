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
                <li class="ul-left"><a href="forum.php?pg=1">Forum</a></li>
                <li class="ul-left selected"><a href="about.php">About Us</a></li>
            </ul>
            <ul>
                <?php
                    if($user === "Sing In")
                        echo "<li class='ul-right SignIn-btn'><a href='#!'>Sign In</a></li>";
                    else echo "<li class='ul-right SignIn-btn'><a href='#!'>" . $user . "</a></li>";
                ?>
            </ul>
        </div>
        
        <div class="BG_About">
            <div class="About">
              <span id="AboutTextT">About Us</span>
              <center>
                    <p id="AboutTextP">
                        This engine is made and maintained by @razvanalex who is the main developer. 
                        He used a lot of projects and merge them into a complex engine which will be updated constantly.
                        One of the main objectiv is to do coding much easier. 
                        Many thanks for @jcoluna for his CSM algorithm (cascaded shadow mapping) and light shaft effect,
                        and for other devs for their uploaded projects on the internet.
                    </p>
                </center>
            </div>
        </div>
        
        <div class="bottomTab">
            <hr>
            <p>Copyright© 2016</p>
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
                        <p class="FgPss-btn"><a href="#!">Forgot your password?</a></p>
                        <p class="FgPss-btn"><a href="#">Cannot access your accout?</a></p>
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
        
        <div class="FgPss">
            <div class="FgPss-close">
                <img src="https://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png">
            </div>
            
            <form class="FgPass" action="logon/login.php?Submit=Lost" method="post"> 
                <p>Enter your username:</p>
                <p><input type="text" name="Username" placeholder="Username" class="textbox"/></p>
                <p><input type="Submit" name="Submit" value="Submit" class="button" /></p>
            </form>
            
        </div>

        <script src="js/script.js"></script>
        <script src="js/SmoothScroll.js"></script>
    </body>
</html>