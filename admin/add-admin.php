<?php include("partials/menu.php");?>;
    <div class="main-content">
        <div class="wrapper">
            <h1>Thêm Admin</h1>
            <br><br>
            
            <form action="" method="POST">
                <table class="tbl-30">

                    <tr>
                        <td>Họ Tên: </td>
                        <td>
                            <input type="text" name="full_name" placeholder="Nhập họ tên của bạn">
                        </td>
                    </tr>


                    <tr>
                        <td>Tên Tài Khoản: </td>
                        <td>
                            <input type="text" name="username" placeholder="Nhập tên tài khoản">
                        </td>
                    </tr>


                    <tr>
                        <td>Mật Khẩu: </td>
                        <td>
                            <input type="password" name="password" placeholder="Nhập mật khẩu">
                        </td>
                    </tr>


                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Thêm Admin" class="btn-secondary">
                        </td>
                    </tr>
                    
                </table>
            </form>
        </div>
    </div>
<?php include("partials/footer.php")?>

<?php
    if(isset($_POST['submit']))
    {
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);  

        $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        if($res == true)
        {
            $_SESSION['add'] = "<div class='success'>Admin được thêm thành công!</div>";

            header("location:".SITEURL.'admin/manage-admin.php');
        }

        else
        {
            $_SESSION['add'] = "<div class ='error'>Không thể thêm Admin. Hãy thử lại!</div>";

            header("location:".SITEURL.'admin/add-admin.php');
        }
    }    
?>