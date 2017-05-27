<?php
$servername = "localhost";
$username = "root";
$password = "your_password";
$dbname = "accounts_database";
//Object oriented mysqli
$con_table = new mysqli($servername, $username, $password,$dbname);
/*Hocam security fonksiyonu aşağıda sadece htmlspecialchars kontrol ettim aslında mysql de kontrol edecektim Ama htmlspecialcharstan sonra hemen mysql_real_escape_string
kontrol edince çöktü anlamadığım bir sebeble*/
$email=security($con_table,$_POST["email"]);
$password=security($con_table,$_POST["password"]);
$post=security($con_table,$_POST['message']);
$field=security($con_table,$_POST['field']);
$title=security($con_table,$_POST['title']);
if(filter_var($email,FILTER_VALIDATE_EMAIL) && !empty($email) && !empty($password)){
   
    $sql_email_check="Select email From Accounts Where email='$email';";
   
    $sql_email="INSERT INTO Accounts (email,password) VALUES ('".$email."','".$password."');";
    if($con_table->query($sql_email_check)->num_rows>=1){
     //Burda blogs table yoksa yapıp Kullanıcnın gönderdiği blog postu ekledim
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
                if(!empty(trim($post)) && !empty(trim($title))){
                    if($con_table->query($sql_table_insert)===TRUE){
                        //redirect fonksiyonu ile kullanıcı geri tuşana basmadan blog sayfasına gitsin istedim.
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
       include('db_con.php');
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
