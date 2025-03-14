<?php include('partials-front/menu.php')?>

    <!-- FOOD SEARCH Section Start -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Tìm kiếm món ăn bạn đang nghĩ tới.." required>
                <input type="submit" name="submit" value="Tìm Kiếm" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- FOOD SEARCH Section End -->

    <?php
    if(isset($_SESSION['order']))
    {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
    ?>

    <!-- Categories Section Start -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Món Ăn Nổi Bật</h2>

            <?php 
                $sql = "SELECT * FROM tbl_category WHERE active='Có' AND featured = 'Có' LIMIT 3";

                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if($count > 0)
                {
                    // category available
                    while($row = mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL?>category-foods.php?category_id=<?php echo $id?>">
                            <div class="box-3 float-container">

                                <?php
                                    if($image_name == "")
                                    {
                                        echo "<div class = 'error'>Hình ảnh không có sẵn!</div>";
                                    }
                                    else
                                    {
                                        ?>
                                            <img src="<?php echo SITEURL?>images/category/<?php echo $image_name?>" alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>

                                <h3 class="float-text text-white"><?php echo $title?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    echo "<div class = 'error'>Danh mục chưa được thêm!</div>";
                }
            ?>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- FOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Thực Đơn</h2>
            <?php
                $sql2 = "SELECT * FROM tbl_food WHERE active='Có' AND featured = 'Có' LIMIT 6";
                $res2 = mysqli_query($conn, $sql2);
                
                $count = mysqli_num_rows($res2);
                if($count > 0)
                {
                    while($row = mysqli_fetch_assoc($res2))
                    {
                        $id = $row["id"];
                        $title = $row["title"];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    if($image_name != "")
                                    {
                                        ?>
                                            <img src="<?php echo SITEURL ?>images/food/<?php echo $image_name?>" class="img-responsive img-curve">
                                        <?php
                                    }  
                                    else
                                    {
                                        echo "<div class = 'error'>Hình ảnh không có sẵn!</div>";
                                    }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title?></h4>
                                <p class="food-price"><?php echo $price ?></p>
                                <p class="food-detail">
                                    <?php echo $description ?>
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
                    echo "<div class = 'error'>Món ăn không có sẵn!</div>";
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