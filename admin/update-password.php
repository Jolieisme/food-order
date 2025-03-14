<?php include("partials/menu.php") ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Thay Đổi Mật Khẩu</h1>
            <br>
            <br>

            <?php
                if(isset($_GET['id']))
                {
                    $id = $_GET['id'];
                } 
            ?>

            <form action="" method="POST">
                <table class="tbl-30">

                    <tr>
                        <td>Mật Khẩu Hiện Tại: </td>
                        <td>
                            <input type="password" name="current_password" placeholder="Nhập mật khẩu hiện tại">
                        </td>
                    </tr>

                    <tr>
                        <td>Mật Khẩu Mới: </td>
                        <td>
                            <input type="password" name="new_password" placeholder="Nhập mật khẩu mới">
                        </td>
                    </tr>

                    <tr>
                        <td>Xác Nhận Mật Khẩu Mới: </td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu mới">
                        </td>
                    </tr>
                    

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="submit" name="submit" value="Thay Đổi Mật Khẩu" class="btn-secondary">
                        </td>
                    </tr>

                </table>
            </form>
        </div>
    </div>


<?php
    if(isset($_POST['submit']))
    {
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";
        $res = mysqli_query($conn, $sql);

        if($res == true)
        {
            $count = mysqli_num_rows($res);
            if($count == 1)
            {
                if($new_password == $confirm_password)
                {
                    $sql2 = "UPDATE tbl_admin SET 
                    password = '$new_password'
                    WHERE id = $id
                    ";

                    $res2 = mysqli_query($conn, $sql2);
                    if($res2 == true)
                    {
                        $_SESSION['change_password'] = "<div class = 'success'>Mật khẩu đã được thay đổi!</div>";
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        $_SESSION['change_password'] = "<div class = 'error'>Thay đổi mật khẩu thất bại!</div>";
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    $_SESSION['password_not_match'] = "<div class = 'error'>Mật khẩu không khớp!</div>";
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }

            else
            {
                $_SESSION['user_not_found'] = "<div class = 'error'>Không tìm thấy người dùng!</div>";
                header("location:".SITEURL.'admin/manage-admin.php');
            }
        }
    }
?>
<?php include("partials/footer.php") ?>