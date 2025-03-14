<?php include('partials/menu.php');?>
<?php
    // check whether the id is set or not
    if(isset($_GET['id']))
    {
        // Get all the details
        $id = $_GET['id'];
        
        //SQL query to get the selection food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        $res2 = mysqli_query($conn, $sql2);

        // Get the value bassed on query executed
        $row2 = mysqli_fetch_assoc($res2);
        
        // Get the individual values of selected food 
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $fetured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        header("location:".SITEURL."admin/manage-food");
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Cập Nhật Thông Tin Món Ăn</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Tiêu Đề: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>

                    <tr>
                        <td>Mô Tả: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5"><?php echo $description?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Giá: </td>
                        <td>
                            <input type="number" name="price" value="<?php echo $price ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Hình Ảnh Hiện Tại: </td>
                        <td>
                            <?php
                                if($current_image == "")
                                {
                                    // image not available
                                    echo "<div class = 'error'>Hình ảnh không có sẵn!</div>";
                                }
                                else
                                {
                                    // image available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image?>" width="150px">
                                    <?php 
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
                        <td>Danh Mục: </td>
                        <td>
                            <select name="category">
                                <?php
                                    // Query to get active category
                                    $sql = "SELECT * FROM tbl_category WHERE active='Có'";
                                    $res = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($res);
                                    if($count > 0)
                                    {
                                        // category available
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            $category_title = $row['title'];
                                            $category_id = $row['id'];
                                            ?>
                                               <option <?php if($current_category==$category_id){echo 'selected';}?> value="<?php echo $category_id?>"><?php echo $category_title?></option> 
                                            <?php

                                        }
                                    }
                                    else
                                    {
                                        // category not available
                                        echo "<opiton value='0'>Danh mục không có sẵn!</opiton>";
                                    }
                                ?>
                                <option value="0">Test Category</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Nổi Bật: </td>
                        <td>
                            <input <?php if($fetured=='Có'){echo "checked";}?> type="radio" name="featured" value="Có"> Có
                            <input <?php if($fetured=='Không'){echo "checked";}?> type="radio" name="featured" value="Không"> Không
                        </td>
                    </tr>

                    <tr>
                        <td>Hiển Thị: </td>
                        <td>
                            <input <?php if($active=='Có'){echo "checked";}?> type="radio" name="active" value="Có"> Có
                            <input <?php if($active=='Không'){echo "checked";}?> type="radio" name="active" value="Không"> Không
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $id?>">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="submit" name="submit" value="Cập Nhật Thông Tin" class="btn-secondary">
                        </td>
                    </tr>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit']))
            {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];
                if(isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];
                    if($image_name != "")
                    {
                        $ext = end(explode('.', $image_name));
                        $image_name = "Food_name_".rand(0000, 9999).'.'.$ext;

                        // get the source path àn destination path
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;
                        $upload = move_uploaded_file($src_path, $dest_path);
                        if($upload == false)
                        {
                            $_SESSION['upload'] = "<div class = 'error'>Tải lên hình ảnh mới thất bại!</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        }

                        //Remove the image if new image is uploaded and current image exists
                        //Remove current image if available
                        if($current_image != "")
                        {
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);
                            if($remove==false)
                            {
                                $_SESSION['remove-failed'] = "<div class='error'>Gỡ hình ảnh hiện tại thất bại!</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
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

                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";

                $res3 = mysqli_query($conn,$sql3);
                if($res3 == true)
                {
                    $_SESSION['update'] = "<div class = 'success'>Cập nhật món ăn thành công!</div>";
                    header('location:'.SITEURL.'admin.manage-food.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class = 'error'>Cập nhật món ăn thất bại!</div>";
                    header('location:'.SITEURL.'admin.manage-food.php');
                }
                
            } 
        ?>
    </div>
</div>


<?php include('partials/footer.php');?>