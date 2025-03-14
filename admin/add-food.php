<?php include('partials/menu.php')?>

<div class = "main-content">
    <div class="wrapper">
        <h1>Thêm Đồ Ăn</h1>
        <br><br>


        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class = "tbl-30">
                <tr>
                    <td>Tiêu đề: </td>
                    <td>
                        <input type="text" name="title" placeholder="Nhập tiêu đề đồ ăn">
                    </td>
                </tr>


                <tr>
                    <td>Mô Tả: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Mô tả đồ ăn"></textarea>
                    </td>
                </tr>


                <tr>
                    <td>Giá: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>


                <tr>
                    <td>Hình Ảnh: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>


                <tr>
                    <td>Danh mục: </td>
                    <td>
                        <select name="category">

                            <?php
                                // Display categories from database
                                // 1. Create SQL to get all active categories from db
                                $sql = "SELECT * FROM tbl_category WHERE active = 'Có'";
                                $res = mysqli_query($conn, $sql);
                                
                                //Count rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);
                                if($count > 0)
                                {
                                    // we have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        // Get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <option value="<?php echo $id ?>"><?php echo $title ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    // Don't have category
                                    ?>
                                    <option value="0">Không tìm thấy thư mục!</option>;
                                    <?php
                                }
                                // 2. Display on 
                            ?>
                        </select>
                    </td>
                </tr>


                <tr>
                    <td>Nổi Bật: </td>
                    <td>
                        <input type="radio" name="featured" value="Có"> Có
                        <input type="radio" name="featured" value="Không"> Không
                    </td>
                </tr>


                <tr>
                <td>Hiển Thị: </td>
                    <td>
                        <input type="radio" name="active" value="Có"> Có
                        <input type="radio" name="active" value="Không"> Không
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value ="Thêm Đồ Ăn" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        


        <?php
            // Check whether the button is clicked or not
            if(isset($_POST['submit']))
            {
                // Add the food in database
                // Get the data from form and insert into databse
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                

                //Check if the radio button is checked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "Không";
                }

                if(isset($_POST["active"]))
                {
                    $active = $_POST["active"];
                }
                else
                {
                    $active = "Không";
                }
                // Upload the image if selected
                if(isset($_FILES['image']['name']))
                {
                    // Get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //Check if the select image is clicked or not and upload the image only if the image is selected
                    if($image_name != "")
                    {
                        // image is selected
                        // Rename the image
                        // Get the extension of selected image (jpg, png, etc)
                        $ext = end(explode(".", $image_name));

                        // Create new name for image
                        $image_name = "Food_name_".rand(0000, 9999).".".$ext;   // Food_name_5867.jpg
                        // Get the src path anf destination path
                        // Src path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];
                        
                        // Destination path for the image to be upload
                        $dst = "../images/food/".$image_name;

                        // Upload the image
                        $upload = move_uploaded_file($src, $dst);

                        // Check if the image uploaded or not
                        if($upload == false)
                        {
                            // False to upload the image
                            $_SESSION['upload'] = "<div class = 'error'>Tải lên hình ảnh thất bại!</div>";
                            header("location:".SITEURL.'admin/add-food.php');
                            die();
                        }
                    }

                }
                else
                {
                    $image_name = "";
                }

                // Insert data into database
                // Create a sql query to save or add food
                $sql2 = "INSERT INTO tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";
                
                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // Check the data insert or not
                if($res2 == true)
                {
                    // Data insert successfully
                    $_SESSION['add'] = "<div class='success'> Thêm món ăn thành công!!</div>";
                    header("location:".SITEURL."admin/manage-food.php");
                }
                else
                {
                    //False to insert data
                    $_SESSION['add'] = "<div class='error'> Thêm món ăn thất bại!</div>";
                    header("location:".SITEURL."admin/manage-food.php");
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php')?>