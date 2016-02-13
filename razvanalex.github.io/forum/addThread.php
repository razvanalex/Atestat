<?php
    include('../logon/login.php');
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
        <link rel="stylesheet" href="../css/main.css" type="text/css"/>
        <link rel="stylesheet" href="../css/forum.css" type="text/css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        
        <div class="menu-bar">
            <div class="menu-bkg"></div>
            <ul>
                <li class="ul-left"><a href="../index.php">Home</a></li>
                <li class="ul-left"><a href="../download.php">Download</a></li>
                <li class="ul-left selected"><a href="../forum.php?pg=1">Forum</a></li>
                <li class="ul-left"><a href="../about.php">About Us</a></li>
            </ul>
            <ul>
                <?php
                    if($user === "Sing In")
                        echo "<li class='ul-right SignIn-btn'><a href='#!'>Sign In</a></li>";
                    else echo "<li class='ul-right'><a href='#!'>" . $user . "</a></li>";
                ?>
            </ul>
        </div>
        
        <div class='SignIn'>
            <div class="icon-close">
                <img src="http://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png">
             </div>
            <form class="LogLBL" action="" method="post"> 
                <p><input type="text" name="Username" placeholder="Username" class="textbox"/></p>
                <p><input type="password" name="Password" placeholder="Password" class="textbox"/></p>
                <p><input type="Submit" name="Submit" value="Sign in" class="button" /></p>
            </form>
            
            <div class="FgtPass">
                <span class="invalid"><?php echo "<p>" . $error . "</p>"; ?></span>
                <p><a href="#">Forgot your password?</a></p>
                <p><a href="#">Cannot access your accout?</a></p>
                <p><a href="../logon/createAccount.php">Create an account</a></p>
            </div>
        </div>
      
        <div class="tab forumContent">
            <div class="content"> 
                <div class="forum">
                    <span><a href='../forum.php?pg=1'>Forum</a></span>
                </div><br>
                <form method="post" action= <?php echo "ThreadSystem.php?user=" . $user . "&type=Th"; ?> id="formTh">
                    <span>Name of thread: </span><input type="text" name="name"/><br>
                </form> 
                <textarea rows="10" cols="100" name="comment" form="formTh" class="text"></textarea><br>
                <input type="Submit" name="submit" value="Submit" form="formTh"/>
            </div>
        </div>
        
        <div class="bottomTab">
            <hr>
            <p>Copyright© 2015</p>
        </div>  

        <script src="../js/script.js"></script>
        <script src="../js/SmoothScroll.js"></script>
    </body>
</html>