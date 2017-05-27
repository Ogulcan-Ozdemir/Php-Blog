<?php
$servername = "localhost";
$username = "root";
$password = "your_password";
$dbname="accounts_database";
$con = mysqli_connect($servername, $username, $password, $dbname);

//İlk önce post ile email ve password gelip gelmediğine baktı
if(isset($_POST['email']) & isset($_POST['password'])){

    $email_password=$_POST["email"];
    $email=mysqli_real_escape_string($con,htmlspecialchars($_POST["email"]));
    $password=mysqli_real_escape_string($con,htmlspecialchars($_POST["password"]));
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        if(!empty($email) || !empty(trim($password))) {

        $sql_make_account="INSERT INTO Accounts (email,password) VALUES('$email','$password')";
        $sql_check="SELECT * From Accounts Where email='$email';";
        $emails=mysqli_query($con, $sql_check);
        if(mysqli_num_rows($emails)<1){
        // if(mysqli_query($con, $sql_make_account)){
        //     echo "Email=".$email."?Password=".$password;
        // }
        // else {
        //     echo "Error while registering account";
        // }
            mysqli_query($con, $sql_make_account);
            echo "Email=".$email."?Password=".$password;
        }
        else {
            echo "!You are registered before". mysqli_error($con);
        
        }

        // mysqli_close($con);
        }
  }
  else {
       echo "!Enter apporipate email to sing up";
  }
}

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

?>