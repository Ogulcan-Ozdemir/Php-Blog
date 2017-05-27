<html>
<head>
<title>Se362 Blog </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $("#btn").click(function () {
        var email=$("#email").val();
        var password=$("#password").val();
        if(email=="" || password==""){
            alert("You didn't enter email or password");
        }
        else{
            $.post("sign_up.php",{
                email:email,
                password,password
                },
                function(data,status){
                    if(!data.startsWith("!")){
                        var email_password=data.split("?");
                        var email=email_password[0].split("=")[1];
                        var password=email_password[1].split("=")[1];
                        $("#email").val(email);
                        $("#password").val(password);
                        alert("You are registered succesfully");
                    }
                    else {
                            alert(data.split("!")[1]);
                    }
                });
        }      
    });
});
</script>
<?php
    require("make_db_table.php");
?>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4 text-center" style="background-color:White  ;">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                Field: <select name="field" required> 
                <option value="coding">coding</option>
                <option value="technology">technology</option>
                <option value="interesting">interesting</option>
                <input type="submit" value="Show in this field blogs">
            </form>
<?php
//TODO this should be define as global
$servername = "localhost";
$username = "root";
$password = "your_password";
$dbname = "accounts_database";
//Procedural mysqli 
$con_db=mysqli_connect($servername, $username, $password);
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM blogs";
if(isset($_POST['field'])){
    $field=$_POST['field'];
    $sql = "SELECT * FROM blogs Where field='$field'";
    echo "<h1>Recent Blog Posts in $field</h1>";
}
else {
echo "<h1>Recent Blog Posts</h1>";
}

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<h3>Title: ". $row["title"]."</h3>";
        echo "<pre>".$row["post"];
        echo "</pre>";
        echo "<p><b>Blogger:</b>".$row["blogger"]."\t<b>Time to sent:</b>".$row["tim"]."</p>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>

    </div>
</div>

<div class="row justify-content-center">
    <div class="col-4 text-center" style="background-color:Wheat   ;" >
                <h1>Write Your Blog</h1>
          <form action="register_blog.php" method="post">
                Title of blog: <input type="text" name="title" id="title" size="40"><br><br>
                <textarea id="texttable" name="message" rows="12" cols="50">
                </textarea><br>
                E-mail: <input type="text" name="email" id="email"><br>
                Password: <input type="password" name="password" id="password"><br>
                Field: <select name="field" required> 
                <option value="coding">coding</option>
                <option value="technology">technology</option>
                <option value="interesting">interesting</option>

                </select>
                <input type="submit" value="Send">
                <button type="button" id="btn">Register</button>
         </form>
     </div>
    </div>
</div>
</body>
</html>