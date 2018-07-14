<?php
$servername = $GLOBALS['servername'];
$username = $GLOBALS['username'];
$password = $GLOBALS['password'];
$dbname = $GLOBALS['dbname'] ;
$con = mysqli_connect($servername, $username, $password, $dbname);

//first check if email and password input present
if(isset($_POST['email']) & isset($_POST['password'])){

    $email_password=$_POST["email"];
    $email=mysqli_real_escape_string($con,htmlspecialchars($_POST["email"]));
    $password=mysqli_real_escape_string($con,htmlspecialchars($_POST["password"]));
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        if(!$email || !trim($password)) {

        $sql_make_account="INSERT INTO Accounts (email,password) VALUES('$email','$password')";
        $sql_check="SELECT * From Accounts Where email='$email';";
        $emails=mysqli_query($con, $sql_check);
        if(mysqli_num_rows($emails)<1){
            mysqli_query($con, $sql_make_account);
            echo "Email=".$email."?Password=".$password;
        }
        else {
            echo "!You are registered before". mysqli_error($con);
        
        }
     } 
  }
  else {
       echo "!Enter apporipate email to sing up";
  }
}

?>