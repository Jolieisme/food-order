<?php
    include("../config/constants.php");

    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        // Get the value and Delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the physical image file is available
        if($image_name != "")
        {
            $path = "../images/category/".$image_name;
            $remove = unlink($path);
            if($remove == false)
            {
                $_SESSION['remove'] = "<div class = 'error'> Xoá ảnh danh mục thất bại! </div>";
                header("location:".SITEURL.'admin/manage-category.php');
                die();
            }
        }
        $sql = "DELETE FROM tbl_category WHERE id = $id";
        $res = mysqli_query($conn, $sql);
        

        // Check whether the data is delete from database or not
        if($res == true)
        {
            $_SESSION['delete'] = "<div class = 'success'>Xoá Danh Mục Thành Công!</div>";
            header("location:".SITEURL.'admin/manage-category.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class = 'error'>Xoá Danh Mục thất bại!</div>";
            header("location:".SITEURL.'admin/manage-category.php');
        }

    }
    else
    {
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>