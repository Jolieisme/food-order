<?php include("partials/menu.php") ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Thêm Danh Mục</h1>
            <br><br>
            

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            ?>
            <br><br>
             

            <!-- Add category form start -->
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Tiêu Đề: </td>
                        <td>
                            <input type="text" name="title" placeholder="Tiêu đề danh mục">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Hình Ảnh: </td>
                        <td>
                            <input type="file" name="image">
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
                            <input type="submit" name="submit" value="Thêm Danh Mục" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
            <!-- Add category form end -->


            <?php
                // check whether the submit button is clicked or not
                if(isset($_POST["submit"])) 
                {
                    // Get the value from category form
                    $title = $_POST['title'];
                    
                    // for radio input, check whether the button is selected or not
                    if(isset($_POST['featured']))
                    {
                        // get the value from form 
                        $featured = $_POST['featured'];
                    }
                    else
                    {
                        // set the default value
                        $featured = "Không";
                    }

                    if(isset($_POST['active']))
                    {
                        // get the value from form 
                        $active = $_POST['active'];
                    }
                    else
                    {
                        // set the default value
                        $active = "Không";
                    }
                    
                    // Check whether the image is selected or not and set the value for image name accordingly
                    // print_r($_FILES['image']);

                    if(isset($_FILES['image']['name']))
                    {
                        // to upload image we need image name, source path and destination path
                        $image_name=$_FILES['image']['name'];
                        

                        // Upload the image only if image is selected
                        if($image_name != "")
                        {
                            

                            // Auto rename image
                            // Get the extension of image (jpg, png, gif, ...) e.g: food1.jpg
                            $ext = end(explode('.', $image_name));

                            //rename the image
                            $image_name = "Food_category_".rand(000, 999).'.'.$ext;  // e.g: Food_category_850.jpg
                            $source_path = $_FILES['image']['tmp_name'];
                            $destination_path = "../images/category/".$image_name;

                        // upload the image
                            $upload = move_uploaded_file($source_path, $destination_path);

                        // check whether the image is uploaded or not
                        //if the image is not uploaded, stop process and redirect with error message
                            if($upload == false)
                            {
                                $_SESSION['upload'] = "<div class = 'error'>Tải ảnh lên thất bại!</div>";
                                header("location:".SITEURL."admin/add-category.php");
                                die();  // stop the process, don't insert the data into db if the image doesn't upload
                            }
                        }

                    }
                    else
                    {
                        // don't upload image and set the image_name value as blank
                        $image_name = "";
                        
                    }
                    // 2. Create sql query to insert category into db
                    $sql = "INSERT INTO tbl_category SET
                        title = '$title',
                        image_name = '$image_name',
                        featured = '$featured',
                        active = '$active'
                    ";
                     
                    // 3. Execute the query and save in db
                    $res = mysqli_query($conn,$sql);
                     // 4. Check whether the query executed or not and data add or not

                    if($res == true)
                    {
                        // Query executed and category added
                        $_SESSION['add'] = "<div class = 'success'>Thư mục được thêm thành công!</div>";
                        header("location:".SITEURL."admin/manage-category.php");
                    }
                    else
                    {
                        //failed to add category
                        $_SESSION['add'] = "<div class = 'error'>Thêm thư mục thất bại!</div>";
                        header("location:".SITEURL."admin/add-category.php");
                    }
                }

            ?>

        </div>
    </div>

<?php include("partials/footer.php") ?>