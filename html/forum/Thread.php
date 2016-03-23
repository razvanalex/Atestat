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
    <body onload=<?php echo "'getInfo(" . $_GET["th"] .", " . $_GET["pg"] . ");'" ?> >
        
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
                        <p class="FgPss-btn"><a href="#!">Forgot your password?</a></p>
                        <p class="FgPss-btn"><a href="#">Cannot access your accout?</a></p>
                        <p><a href="../logon/createAccount.php">Create an account</a></p>
                    </div>';
            }
            else {
                echo "
                    <div class='LogLBL'>
                        <div class='button centerDIV' onclick=" . "location.href='../logon/logout.php';" . ">Sign Out</div><br>
                    </div>
                    ";
                if($user === "admin") {
                      echo "<div class='button centerDIV' onclick=" . "location.href='../userPages/adminPage.php';" . ">Admin Page</div>";  
                }
                else {
                    echo "<div class='button centerDIV' onclick=" . "location.href='../userPages/userPage.php';" . ">" . $user . " Page</div>";
                }
            }
        ?>
        </div>
        
        <div class="FgPss">
            <div class="FgPss-close">
                <img src="https://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png">
            </div>
            
            <form class="FgPass" action="../logon/login.php?Submit=Lost" method="post"> 
                <p>Enter your username:</p>
                <p><input type="text" name="Username" placeholder="Username" class="textbox"/></p>
                <p><input type="Submit" name="Submit" value="Submit" class="button" /></p>
            </form>
            
        </div>

      
        <div class="forumContent">
            <div class="content"> 
                <?php 
                  	$json = file_get_contents("../json/Forum_Data.json");
                    $data = json_decode($json);
                    $th = $_GET["th"];
                    $data[$th]->noViews += 1;
                    
                    $perPage = 7;
                    $currentPage = $_GET["pg"];
                    $res = (int)(count($data[$th]->Posts) / $perPage);

                    if(count($data[$th]->Posts) % $perPage !== 0)
                        $res++;
                            
                    file_put_contents('../json/Forum_Data.json', json_encode($data));
        
                    print "
                        <div class='forum'>
                            <span><a href='../forum.php?pg=1'>Forum</a></span>
                            <span class='ThName'> >> " . $data[$th]->Name . "</span>
                        </div><br>
                        ";

                    if($user !== "Sing In")
                     {  echo " <div class='barTable'>
                                <div class='btn floatLeft'><a href= '../forum/addPost.php?th=". $th . "' >Add Post</a></div>";
                        if($user === $data[$th]->Author)
                            echo  "<div class='btn floatRight'><a href= '../forum/removeThread.php?th=". $th . "' >Close Thread</a></div>";
                        echo "</div>";
                     }
                  //  else echo "<br>";
                ?>
                <div class="tablePosts">
                    <table id="tableP">
                        <?php
                            for ($i = $perPage * ($currentPage - 1); $i< $perPage * $currentPage; $i++) {
                                if($data[$th]->Posts[$i] !== null){
                                    echo "<tr class='trPost'>
                                        <td class='postby'>
                                            <span>Posted by: " . $data[$th]->Posts[$i]->postBy . "</span><br>
                                            <span>On: " . $data[$th]->Posts[$i]->When . "</span><br>
                                            <span>At: " . $data[$th]->Posts[$i]->HM . "</span>
                                        </td>
                                        <td class='tdpost'>
                                            <div class='textpost'>
                                                <div class='topPost'>
                                                    <span id='textPost" . ($i -  $perPage * ($currentPage - 1)) . "'>" . $data[$th]->Posts[$i]->postText ."</span>
                                                    <textarea id='textarea" . ($i -  $perPage * ($currentPage - 1)) . "' class='txtarea notvisible'></textarea>
                                                    <br>
                                                </div>";
                                    if($data[$th]->Posts[$i]->postBy === $user){
                                        echo "  <div class='btnPost notvisible' id='editPost" . ($i -  $perPage * ($currentPage - 1) ). "'>
                                                    <div class='btn'><a href ='#!'>Edit Post</a></div>
                                                </div>
                                                <div class='btnPost notvisible' id='savePost" . ($i -  $perPage * ($currentPage - 1) ). "'>
                                                    <div class='btn'><a href ='#!'>Save Post</a></div>
                                                </div>";
                                    }
                                    echo "      <div class='bottomPost'>
                                                    <?-- ------Custom Bottom------ -->
                                                </div>
                                            </div>
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
                            else print " <a href='?th=" . $_GET['th'] . "&pg=" . $i . "'>" . $i . "</a> ";
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="bottomTab">
            <hr>
            <p>Copyright© 2016</p>
        </div>  

        <script src="../js/script.js"></script>
        <script src="../js/Post.js"></script>
        <script src="../js/SmoothScroll.js"></script>
    </body>
</html>