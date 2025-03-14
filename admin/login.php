<?php include("../config/constants.php") ?>


<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>


    <body>
        <div class ="login">
            <h1 class ="text-center2">Đăng Nhập</h1>
            <br>


            <?php
                if(isset($_SESSION["login"]))
                {
                    echo $_SESSION["login"];
                    unset($_SESSION["login"]);
                }


                if(isset($_SESSION["no-login-message"]))
                {
                    echo $_SESSION["no-login-message"];
                    unset($_SESSION["no-login-message"]);
                }
            ?>
            <br><br>
            <!-- Login Form Start -->
            <form action="" method = "POST" class="text-center3">
                <p>Tên tài khoản: </p>
                <br>
                <input type="text" name = "username" placeholder="Nhập tên tài khoản" class = login-text-input> <br>
                <p>Mật Khẩu: </p>
                <br>
                <input type="password" name="password" placeholder="Nhập mật khẩu" class = login-password-input> <br>
                <input type="submit" name="submit" value="Đăng Nhập" class="login-submit-input">
                <br><br>
            </form>
            <!-- Login Form End -->
        </div>
    </body>
</html>


<?php
    // Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        // 1. Get the data from login form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);


        $sql = "SELECT * FROM tbl_admin WHERE username ='$username' AND password = '$password'";
        $res = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($res);


        if($count == 1)  
        {
            // user available and login success
            $_SESSION['login'] = "<div class='success'>Đăng nhập thành công!</div>";
            $_SESSION["user"] = $username;   // check whether the user is logged in or not and logout will unset it
            header("location:".SITEURL."admin/");
        }
        else
        {
            $_SESSION['login'] = "<div class='error text-center'>Tên đăng nhập hoặc mật khẩu không đúng!</div>";
            header("location:".SITEURL."admin/login.php");
        }
    }
?>
