<?php include('partials-front/menu.php')?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Bạn đang nghĩ tới món gì?.." required>
                <input type="submit" name="submit" value="Tìm Kiếm" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Thực Đơn</h2>

            <?php
                $sql = "SELECT * FROM tbl_food WHERE active = 'Có'";
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);
                // check whether the foods are available or not
                if($count > 0)
                {
                    // Foods Available
                    while($row = mysqli_fetch_assoc($res))
                    {
                        // Get the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        ?>

                          <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    if($image_name == "")
                                    {
                                        // image not available
                                        echo "<div class ='error'>Hình ảnh không có sẵn!</div>";
                                    }
                                    else
                                    {
                                        ?>

                                        <img src="<?php echo  SITEURL?>images/food/<?php echo $image_name?>" class="img-responsive img-curve">
                                        
                                        <?php
                                    }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title ?></h4>
                                <p class="food-price"> <?php echo $price?></p>
                                <p class="food-detail">
                                    <?php echo $description?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL?>order.php?food_id=<?php echo $id ?>" class="btn btn-primary">Đặt Ngay</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    echo "<div class='error'>Không tìm thấy món ăn!</div>";
                }
            ?>

            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="#">Xem thêm</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php')?>