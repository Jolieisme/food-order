<?php 
    include("../config/constants.php");

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Check the image is available or not and delete if image is available
        if($image_name != "")
        {
            $path = "../images/food/".$image_name;

            // Remove image file form folder
            $remove = unlink($path);


            // Check whether the image is remove or not
            if($remove == false)
            {
                // Failed to remove image
                $_SESSION['upload'] = "<div class = 'error'> Xoá hình ảnh thất bại!</div>";
                header("location:".SITEURL."admin/add-food.php");
                die(); 
            } 
        }

        // Delete food from db
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        $res = mysqli_query($conn, $sql);
        

        // Check whether the query is executed or not and set the session message respectively 
        if($res == true)
        {
            // Food deleted
            $_SESSION['delete'] = "<div class='success'> Xoá món ăn thành công! </div>";
            header("location:".SITEURL."admin/manage-food.php");
        }
        else
        {
            // False to delete food
            $_SESSION['unauthorize'] = "<div class='erroe'> Xoá món ăn thất bại! </div>";
            header("location:".SITEURL."admin/manage-food.php");
        }

    }
    else
    {
        $_SESSION['delete'] = "<div class = 'error'> Không thể truy cập!</div>";
        header("location:".SITEURL."admin/manage-food.php");
    }
?>