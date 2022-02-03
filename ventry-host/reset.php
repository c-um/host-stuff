<?php
session_start();
function generateRandomString($length)
{
  $characters = '0123456789';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
$db = mysqli_connect('localhost', 'root', 'Julian2016--!123', 'file-host');
  // Start with PHPMailer class
  use PHPMailer\PHPMailer\PHPMailer;
  //use PHPMailer\PHPMailer\Exception;
  //require 'PHPMailer-master/src/Exception.php';
  require 'api/PHPMailer-master/src/PHPMailer.php';
  require 'api/PHPMailer-master/src/SMTP.php';
  require 'api/vendor/autoload.php';
if(isset($_GET["email"])){
  $email = $_GET["email"];
}
$sql = "SELECT * FROM `users` WHERE `email`='$email'";
if($result = mysqli_query($db, $sql)){
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result)){
      $uuid = $row["uuid"];
      $id = $row["id"];
      $username = $row["username"];
      $role = $row["role"];
      $registerdate = $row["reg_date"];
      $lastupload = $row["last_uploaded"];
      $uploads = $row["uploads"];
      $_SESSION["resetid"] = $row["id"];
      $banned = $row["banned"];
      $discord_avatar = $row["discord_avatar"];
      $discord_username = $row["discord_username"];
      $_SESSION["resetcode"] = generateRandomString(8);
      $discord_id = $row["discord_id"];
      if($banned == "false"){
        $banned = "No";
      }
      else{
        $banned = "Yes";
      }
    }
  }
}

$mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug  = 0;  
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "mhills.host@gmail.com";
    $mail->Password   = "Jan30052007";
    $mail->IsHTML(true);
    $mail->SetFrom("mhills.host@gmail.com", "mhills.de | Reset System");
    $mail->AddCC($email, $username);
    $mail->Subject = "Password reset request";
    $content = "<style>button a{ background-color: #131313;
      color: white;
      padding: 12px 50px;
      cursor: pointer;
      font-size: 20px;
      border-radius: 15px; }</style><img src='https://mhills.de/images/mhills.de.png' class='card-img-top'><br><hr class='rounded'><br<br><p>Hello $username.<br>You can click the button below to reset your Password: <br> <button><a href='https://mhills.de/reset-password?code=" . $_SESSION["resetcode"] ."'>Reset Password</a></button><br><br>If you did not do this contact the<br>Owner (AtomicHXH#9888) on Discord IMMEDIATELY!<br><br><br><br>Best regards, mhills.de File Hosting</p>";
    $mail->MsgHTML($content); 
    if(!$mail->send()){
        echo 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        //echo 'Message has been sent';
        unset($_SESSION['email']);
        unset($_SESSION['username']);
        header("location: reset");
    }


?>
  <head>
      <link rel='icon' type='image/png' href='https://mhills.de/images/icons/favicon.ico'/>
      <link rel='stylesheet' type='text/css' href='https://mhills.de/vendor/bootstrap/css/bootstrap.min.css'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <meta name="apple-mobile-web-app-capable" content="yes" />

<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="https://mhills.de/images/mhills.de.png"/>

<link rel="apple-touch-startup-image" href="https://mhills.de/images/mhills.de.png" />
      <link rel='stylesheet' type='text/css' href='https://mhills.de//fonts/font-awesome-4.7.0/css/font-awesome.min.css'>
      <link rel='stylesheet' type='text/css' href='https://mhills.de//fonts/iconic/css/material-design-iconic-font.min.css'>
      <link rel='stylesheet' type='text/css' href='https://mhills.de//vendor/animate/animate.css'>
      <link rel='stylesheet' type='text/css' href='https://mhills.de//vendor/css-hamburgers/hamburgers.min.css'>
      <link rel='stylesheet' type='text/css' href='https://mhills.de//vendor/animsition/css/animsition.min.css'>
      <script async src="https://arc.io/widget.min.js#3uop4387"></script>
      <link rel='stylesheet' type='text/css' href='https://mhills.de//vendor/select2/select2.min.css'>
      <link rel='stylesheet' type='text/css' href='https://mhills.de//vendor/daterangepicker/daterangepicker.css'>
      <link rel='stylesheet' type='text/css' href='https://mhills.de//css/util.css'>
      <link rel='stylesheet' type='text/css' href='https://mhills.de//css/main.css'>
      <script src='https://mhills.de//vendor/jquery/jquery-3.2.1.min.js'></script>
      <script src='https://mhills.de//vendor/animsition/js/animsition.min.js'></script>
      <script src='https://mhills.de//vendor/bootstrap/js/popper.js'></script>
      <script src='https://mhills.de//vendor/bootstrap/js/bootstrap.min.js'></script>
      <script src='https://mhills.de//vendor/select2/select2.min.js'></script>
      <script src='https://mhills.de//vendor/daterangepicker/moment.min.js'></script>
      <script src='https://mhills.de//vendor/daterangepicker/daterangepicker.js'></script>
      <script src='https://mhills.de//vendor/countdowntime/countdowntime.js'></script>
      <script src='https://mhills.de//js/main.js'></script>
      <meta property='og:type' content='website'>
   </head>
   <body>
<div class='loader-wrapper'>
    <span class='loader'><span class='loader-inner'></span></span>
</div>

<div id='body_div'>
      <div class='container-login100'>
      <style>
.wrap-login100 {
    width: 590px;
    background: #1b1b1b;
    border-radius: 20px;
    overflow: hidden;
    padding: 5px;
    box-shadow: 0 5px 10px 0px rgb(0 0 0 / 10%);
    -moz-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
    -webkit-box-shadow: 0 5px 10px 0px rgb(0 0 0 / 10%);
    -o-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
    -ms-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);
}
.p-b-26 {
    padding-bottom: 0px;
}
.flex {
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
}
.flex-child-small {
    -webkit-box-flex: 1 1 auto;
    -moz-box-flex: 1 1 auto;
    -webkit-flex: 1 1 auto;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    margin: 10px;
    font-size: 20px;
    border-radius: 15px;
    width: 100px;
    height: auto;
    font-family: Poppins-Regular;
    font-size: 14px;
    line-height: 1.7;
    color: #666666;
    text-align: center;
}
    hr.rounded {
  border-top: 2px solid #1b1b1b;
  border-radius: 5px;
}
.card img {
      border-radius: 50%;
      width: 40%;
      height: auto;
      display: block;
      margin-left: auto;
      margin-right: auto;
      margin-top: 10%;
    }

    .card img:hover {
      border-radius: 25%;
      width: 40%;
      height: auto;
      display: block;
      margin-left: auto;
      margin-right: auto;
      margin-top: 10%;
      transition: 0.3s;
    }
    .card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0px;
    width: auto;
    height: auto;
    word-wrap: break-word;
    background-color: #131313;
    background-clip: border-box;
    border: 2px solid rgba(0, 0, 0, .125);
    border-radius: 15px;
    padding: 15px;
    margin: 10px 10px 10px 10px;
    box-shadow: 0 1px 10px rgb(0 0 0 / 30%), 0 15px 12px rgb(0 0 0 / 22%);
}
    .card img {
      border-radius: 50%;
      width: 40%;
      height: auto;
      display: block;
      margin-left: auto;
      margin-right: auto;
      margin-top: 10%;
      transition: 0.3s;
    }
    input {
    display: block;
    margin-bottom: 10px;
    padding: 5px;
    width: 100%;
    border: 1px solid grey;
    border-radius: 10px;
    font-size: 16px;
    background-color: #1b1b1b;
    color: white;
}
.btn32143 {
  background-color: #131313;
    color: white;
    cursor: pointer;
    margin-bottom: 10px;
    font-size: 20px;
    border-radius: 15px;
    border: 1px solid grey;
    width: 100%;
    }
      </style>
         <div class='wrap-login100'>
            <!-- notification message -->
            <span class='login100-form-title p-b-26'>
               <div class='card'>
               <div class='flex'>
        <img src='https://mhills.de/images/mhills.de.png' class='card-img-top'>
          </div>
          <br>
          <hr class='rounded'>
               <h5 class='card-title'><br>Password Reset</h5><br>
               <div class='flex'>
               <p class='flex-child-small' style='color: white'><strong>If the email you enter exists, a code will be sent to it!</strong></p>
            </div><br><br>
            <form method='get' action='reset'>
            <div class='input-group'>
              <input type='text' name='email' placeholder='Enter Email'>
            </div>
            </div><br>
            <button type='submit' class='btn32143'>Send</button>
          </form>
            </div>
         </div>
         </span>
      </div>
      </div>

</div>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.min.js'></script>
      <script src='https://unpkg.com/tilt.js@1.2.1/dest/tilt.jquery.min.js'></script>

   </body>