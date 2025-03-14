<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Cập Nhật Danh Mục</h1>

        <br><br>


        <?php
            // Check whether the id is set or not
            if(isset($_GET['id']))
            {
                // Get the id and all other details
                $id = $_GET['id'];

                // Create sql query to get all other details
                $sql = "SELECT * FROM tbl_category WHERE id = $id";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if($count == 1)
                {
                    $rows = mysqli_fetch_assoc($res);
                    $title = $rows['title'];
                    $current_image = $rows['image_name'];
                    $featured = $rows['featured'];
                    $active = $rows['active'];
                }
                else
                {
                    $_SESSION['no-category-found'] = "<div class='error'>Không tìm thấy danh mục!</div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                header("location:".SITEURL.'admin/manage-category.php');
            }
        ?>
        <form action="" method = "POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Tiêu Đề: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>
                </tr>


                <tr>
                    <td>Hình Ảnh Hiện Tại: </td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                                // display the image
                                ?>
                                <img src="<?php echo SITEURL?>images/category/<?php echo $current_image?>" width="150px">
                                <?php

                            }
                            else
                            {
                                echo "<div class = 'error'>Hình ảnh chưa được thêm!</div>";
                            }
                        ?>
                    </td>
                </tr>


                <tr>
                    <td>Hình Ảnh Mới: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Nổi Bật: </td>
                    <td>
                        <input <?php if($featured == "Có"){echo "checked";}?> type="radio" name="featured" value="Có">Có
                        <input <?php if($featured == "Không"){echo "checked";}?> type="radio" name="featured" value="Không"> Không
                    </td>
                </tr>

                <tr>
                    <td>Hiển Thị: </td>
                    <td>
                        <input <?php if($active == "Có"){echo "checked";}?> type="radio" name="active" value="Có">Có
                        <input <?php if($active == "Không"){echo "checked";}?> type="radio" name="active" value="Không"> Không
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image ?>">
                        <input type="hidden" name = "id" value="<?php echo $id ?>">
                        <input type="submit" name="submit" value="Cập Nhật Danh Mục" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit']))
            {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2. Updating the new image if selected
                //Check whether the image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //Get the image details
                    $image_name = $_FILES['image']['name'];

                    if($image_name != "")
                    {
                        $ext = end(explode('.', $image_name));
                        $image_name = "Food_category_".rand(000, 999).'.'.$ext;  // e.g: Food_category_850.jpg
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;
                        $upload = move_uploaded_file($source_path, $destination_path);
                        if($upload == false)
                        {
                            $_SESSION['upload'] = "<div class = 'error'>Tải ảnh lên thất bại!</div>";
                            header("location:".SITEURL."admin/manage-category.php");
                            die();
                        }

                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);
                            if($remove == false)
                            {
                                // failed to remove image
                                $_SESSION['failed-remove'] = "<div class = 'error'> Không thể xoá hình ảnh hiện tại! </div>";
                                header("location:".SITEURL.'admin/manage-category.php');
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }
                $sql2 = "UPDATE tbl_category SET 
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";
                $res = mysqli_query($conn, $sql2);
                if($res == true)
                {
                    $_SESSION['update'] = "<div class = 'success'> Cập nhật danh mục thành công! </div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class = 'error'> Cập nhật danh mục thất bại! </div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                
            }
        ?>
    </div>
</div>

<?php
    
?>

<?php include("partials/footer.php"); ?>