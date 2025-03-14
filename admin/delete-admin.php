<?php
 
include('../config/constants.php');
    session_start();
    $id = $_GET['id'];

    $sql = "DELETE from tbl_admin WHERE id = $id";
    $res = mysqli_query($conn, $sql);
    

    if($res == TRUE)
    {
       $_SESSION['delete'] = "<div class='success'> Xoá Admin Thành Công! </div>";

       header("location:".SITEURL.'admin/manage-admin.php');
    }
    else
    {
        $_SESSION['delete'] = "<div class ='error'> Không thể xoá Admin. Hãy thử lại! </div>";
        header("location:".SITEURL.'admin/manage-admin.php');
    }
?>