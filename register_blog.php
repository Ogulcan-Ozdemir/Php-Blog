<?php
$servername = $GLOBALS['servername'];
$username = $GLOBALS['username'];
$password = $GLOBALS['password'];
$dbname = $GLOBALS['dbname'] ;
//Object oriented mysqli
$con_table = new mysqli($servername, $username, $password,$dbname);

$email=security($con_table,$_POST["email"]);
$password=security($con_table,$_POST["password"]);
$post=security($con_table,$_POST['message']);
$field=security($con_table,$_POST['field']);
$title=security($con_table,$_POST['title']);
if(filter_var($email,FILTER_VALIDATE_EMAIL) && !empty($email) && !empty($password)){
   
    $sql_email_check="Select email From Accounts Where email='$email';";
   
    $sql_email="INSERT INTO Accounts (email,password) VALUES ('".$email."','".$password."');";
    if($con_table->query($sql_email_check)->num_rows>=1){
     //Check if blogs table exits or make new one
      $sql_blog="CREATE TABLE IF NOT EXISTS blogs (
            id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            post LONGTEXT NOT NULL,
            blogger VARCHAR(30),
            field VARCHAR(30),
            title LONGTEXT NOT NULL,
            tim TIMESTAMP DEFAULT CURRENT_TIMESTAMP);";
            $sql_table_check="SHOW TABLES LIKE 'blogs';";
            $sql_table_insert="INSERT INTO blogs (post,blogger,field,title) VALUES ('$post','$email','$field','$title');";
            if($con_table->query($sql_blog)){
                if(!trim($post) && !trim($title)){
                    if($con_table->query($sql_table_insert)===TRUE){
                      
                        redirect("blog.php");
                    }
                    else {
                        echo display("error while insert blog post".$con_table->query($sql_blog));
                    }
                }
                else {
                    echo display("You should enter blog post and title");
                }
            }
            else {
                $con_table->query($sql_blog);
                $con_table->query($sql_table_insert);
                redirect("blog.php");
            }
    
    }
    else {
       include('make_accounts_table.php');
    }
}
else{
    echo display("Please enter valid email and password");
    redirect("blog.php");
}

function display($msg){
    echo "<h1>$msg</h1>";
}

function security($con,$par){
    return mysqli_real_escape_string($con,htmlspecialchars($par));
}

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}
?>
