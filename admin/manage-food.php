<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Quản Lý Đồ Ăn</h1>

        <br/>
            <!-- Button To Add Admin Start-->
            <a href="<?php echo SITEURL?>admin/add-food.php" class="btn-primary">Thêm Đồ Ăn</a>
            <br/>
            <br>
            <br>

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }

                if(isset($_SESSION['unauthorize']))
                {
                    echo $_SESSION['unauthorize'];
                    unset($_SESSION['unauthorize']);
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

                if(isset($_SESSION['remove-failed']))
                {
                    echo $_SESSION['remove-failed'];
                    unset($_SESSION['remove-failed']);
                }

            ?>

            <table class="tbl-full">
                <tr>
                    <th>STT</th>
                    <th>Tiêu Đề</th>
                    <th>Giá</th>
                    <th>Hình Ảnh</th>
                    <th>Đặc Biệt</th>
                    <th>Hiển Thị</th>
                    <th>Hoạt Động</th>
                </tr>

                <?php
                    $sql = "SELECT * FROM tbl_food";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    $sn = 1;
                    if($count > 0)
                    {
                        while($rows = mysqli_fetch_assoc($res))
                        {
                            // get the values from individual column
                            $id = $rows['id'];
                            $title = $rows['title'];
                            $price = $rows['price'];
                            $image_name = $rows['image_name'];
                            $featured = $rows['featured'];
                            $active = $rows['active'];
                            ?>

                        <tr>
                            <td><?php echo $sn++?> </td>
                            <td><?php echo $title?></td>
                            <td><?php echo $price?></td>
                            <td>
                                <?php
                                    if($image_name == "")
                                    {
                                        echo "<div class = 'error'> Hình ảnh chưa được thêm!</div>";
                                    } 
                                    else
                                    {
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                        <?php
                                    }
                                ?>
                            </td>
                            <td><?php echo $featured?></td>
                            <td><?php echo $active?></td></td>
                            <td>
                                <a href="<?php echo SITEURL?>admin/update-food.php?id=<?php echo $id?>" class="btn-secondary"> Cập Nhật Thông Tin Món Ăn</a>
                                <a href="<?php echo SITEURL?>admin/delete-food.php?id=<?php echo $id?>&image_name=<?php echo $image_name?>" class="btn-danger"> Xoá Món Ăn</a>
                            </td>
                        </tr>

                        <?php

                        }
                    }
                    else
                    {
                        // food not add in db
                        echo "<tr><td colspan = '2' class = 'error'> Chưa có món ăn được thêm!</td></tr>";
                    }

                ?>


            </table>


    </div>
</div>

<?php include("partials/footer.php"); ?>