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
        <link rel="stylesheet" href="css/download.css" type="text/css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="menu-bar">
            <div class="menu-bkg"></div>
            <ul>
                <li class="ul-left selected"><a href="index.php">Home</a></li>
                <li class="ul-left"><a href="download.php">Download</a></li>
                <li class="ul-left"><a href="forum.php?pg=1">Forum</a></li>
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
        
        
        <div class ="tab">
            <div class="first"></div>
            <div class="text_1">
                <center><span id="Text_T_1">Want to create your own game easier and faster? <br> Try XNAEnvironment!</span></center></center><br>
                <span id="Text_T_2">XNAEnvironment is a powerful tool designed for game developers, which allows to create your dreamed game world. 
                You don't have to create your own graphics engine.
                You can generate random worlds by using your resources.
                Try yourself this framework, it's completely free. 
                All that you need is Visual C# 2010 or later and Microsoft XNA 4.0 for C#. 
                Free resources may be found out on our community.</span>
            </div>
        </div>
        
        <div class="tab">
            <div class="second"></div>
            <div class="text_2">
                <center><span id="Text_T_3">Experience some cool stuff like shadows, water shader, billboards system, light shaft and so on!</span></center>
                <span></span>
            </div>
        </div>
        
        
        <div class="slider">
            <div class="slide active-slide">
                <div class="bg01">
                    <div class="title">
                        <p><h1>Realtime environment</h1></p>
                    </div>
                     <div class="description">
                        <p>Make an open world game with weather features and day-night cycles.</p>
                    </div>
                </div>
            </div>
    
            <div class="slide">
                <div class="bg02">
                    <div class="title2">
                        <p><h1>Cool underwater</h1></p>
                    </div>
                     <div class="description2">
                        <p>This framework has partial support for underwater world. You can add fishes, vegetation and some rocks and you have got an awesome environment!</p>
                    </div>
                </div>
            </div>
            
            <div class="slide">
                <div class="bg03">
                    <div class="title3">
                        <p><h1>Light scattering</h1></p>
                    </div>
                     <div class="description3">
                        <p>Day-night cycle with light scattering and lens flare do your world much more realistic. Also the reflection of sun and moon looks wonderful!</p>
                    </div>
                </div>
            </div>
    
            <div class="slider-nav">
                <div class="arrows">
                    <div class="arrow-prev">
                        <a href="#!"><img src="https://s3.amazonaws.com/codecademy-content/courses/ltp2/img/flipboard/arrow-prev.png"></a>
                    </div>
                    <div class="arrow-next">
                      <a href="#!"><img src="https://s3.amazonaws.com/codecademy-content/courses/ltp2/img/flipboard/arrow-next.png"></a>
                    </div> 
                </div>
                <div class="slider-dots">
                    <ul>
                        <li class="dot active-dot">&bull;</li>
                        <li class="dot">&bull;</li>
                        <li class="dot">&bull;</li>
                    </ul>                   
                </div>
            </div> 
        </div>


        <div class="tab">
            <div class="third"></div>
            <div class="text_3">
                <center>
                    <span id="Text_T_4">Make your dreams become true! Don't hesitate! Try it right now!<br> It's Free!</span><br><br><br>
                    <div class="download-btn"><a href="download.php">Go to download page</a></div>
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

        <script src="js/script.js"></script>
        <script src="js/SmoothScroll.js"></script>
    </body>
</html>