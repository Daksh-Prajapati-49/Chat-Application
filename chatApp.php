
<?php 

    session_start();

?>
    

<?php
    
    require 'db.php';

   if((isset($_POST['msg'])) and (!($_POST['msg'] == "")))
   {   
        $client = new Predis\Client();
    
        $msg = $_POST["msg"];
        $now = new DateTime( null, new DateTimeZone('Asia/Kolkata'));
        $date = $now->format('Y-m-d H:i:s');
        $user = $_SESSION['username'];
        $client -> incr("count");
        $count = $client -> get("count");
        $client -> lpush("userHistory",$user);
        $client -> lpush("msgHistory",$msg);
        $client -> lpush("timeHistory",$date);
        $_POST['msg'] = null;
    }  

     echo ' <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Chat Application | Home</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
    <hr><div>
    
        <div id = "title">
            Chat Application
        </div>

        <div id="nav">
            <a href="chatApp.php" class="move" id="current"> Home </a> 
            <a href="logout.php" class="move"> Logout </a>
        </div>
        </div><hr>';

        $user = $_SESSION['username'];

        echo '<div id="welcome">    Welcome '.$user.  '</div>';

        echo '<div class="register">

            <form action="chatApp.php" method="post" >
                Speak to the world : <br>
                <input type="text" name="msg" placeholder="Message" class="input" id="msg" > <br> <br>
            
                <button class="btn btn-primary">Submit</button> 

            </form>
        <div class="chatt">
        <div class="chats">';
        $msgarray = $client->lrange("msgHistory",0,-1);
        $userarray = $client->lrange("userHistory",0,-1);
        $timearray = $client->lrange("timeHistory",0,-1);

        for ($i=0; $i < count($msgarray); $i++) { 
          if ($_SESSION['username'] == $userarray[$i]) {
            echo '<div class="right">
            <div class="rightcont">
            <div class="name">' . $userarray[$i] . '</div>
            <div class="msg">' . $msgarray[$i] . '</div>
            <div class="time">'.$timearray[$i].'</div>
            </div>
          </div>';
          }
          else {
            echo '<div class="left">
            <div class="leftcont">
            <div class="name">' . $userarray[$i] . '</div>
            <div class="msg">' . $msgarray[$i] . '</div>
            <div class="time">'.$timearray[$i].'</div> 
            </div>
          </div>';
          }

        };

        echo '</div>
        </div>

          
        </div>

        <div id="footer">
            <footer>
                <p id="footer-text"> Copyright &#169; to Chat Application - IIITDMJ </p>
            </footer>
        </div>

    </body>
    <script>
    // var $scores = $(".chats");
    setInterval(function () {
    $( ".chatt" ).load( "chatApp.php .chats" );
      }, 1000);
    </script>
    </html>';
?>

