<?php include('partials-front/menu.php')?>

 <?php
    // Check whether food id is set or not
    if(isset($_GET['food_id']))
    {
        // get the food id and details of selected food
        $food_id = $_GET['food_id'];

        // Get the details of selected food

        $sql = "SELECT * FROM tbl_food WHERE id = $food_id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        
        if($count == 1)
        {
            $row = mysqli_fetch_assoc($res);
            $title = $row['title']; 
            $price = $row['price'];
            $image_name = $row['image_name'];
        }
        else
        {
            // food not available
            header("location:".SITEURL);
        }

    }
    else
    {
        header('location:'.SITEURL);
    }
 ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-black" style="padding-top:5rem" >Xác Nhận Thông Tin Đặt Hàng</h2>

            <form action="#" method="POST" class="order">
                <fieldset>
                    <legend>Món Ăn Đã Chọn</legend>

                    <div class="food-menu-img">
                        <?php
                            // check if the image is available or not
                            if($image_name == "")
                            {
                                // image not available
                                echo "<div class='error'>Hình ảnh không có sẵn!</div>";
                            }
                            else
                            {
                                ?>
                                    <img src="<?php echo SITEURL?>images/food/<?php echo $image_name?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title;?>">

                        <p class="food-price"><?php echo $price ?></p>
                        <input type="hidden" name="price" value="<?php echo $price ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Thông Tin Vận Chuyển</legend>
                    <div class="order-label">Họ và Tên</div>
                    <input type="text" name="full-name" placeholder="Điền tên của bạn" class="input-responsive" required>

                    <div class="order-label">Số Điện Thoại</div>
                    <input type="tel" name="contact" placeholder="+843867xxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="user@gmail.com" class="input-responsive" required>

                    <div class="order-label">Địa Chỉ</div>
                    <textarea name="address" rows="10" placeholder="Địa chỉ" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Xác Nhận Đặt Hàng" class="btn btn-primary">
                </fieldset>

            </form>

            <?php 
                if(isset($_POST['submit']))
                {
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty;
                    $order_date = date('Y-m-d H:i:sa');
                    $status = "Đặt Hàng!";  // Orderd, on delivery, delivered, cancelled
                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    // Save the order in db
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    $res2 = mysqli_query($conn, $sql2);

                    if($res2 == true)
                    {
                        // query executed àn order saved
                        $_SESSION['order'] = "<div class='success text-center'>Đặt Hàng Thành Công!</div>";
                        header("location:".SITEURL);
                    }
                    else
                    {
                        // failed to save order
                        $_SESSION['order'] = "<div class='error text-center'>Đặt Hàng Thất Bại!</div>";
                        header("location:".SITEURL);
                    }
                }

            ?>


        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php')?>