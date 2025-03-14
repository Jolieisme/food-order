<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Quản Lý Đơn Hàng</h1>
        <br><br><br>

        <?php
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            } 
        ?>
        <br><br>
            <table class="tbl-full">
                <tr>
                    <th>STT</th>
                    <th>Tên Món</th>
                    <th>Giá</th>
                    <th>Số Lượng</th>
                    <th>Đơn Giá</th>
                    <th>Ngày Đặt</th>
                    <th>Trạng Thái</th>
                    <th>Khách Hàng</th>
                    <th>SĐT</th>
                    <th>Email</th>
                    <th>Địa Chỉ</th>
                    <th>Hoạt Động</th>
                </tr>

                <?php
                    // get all the orders from db
                    $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    $sn = 1;
                    if($count > 0)
                    {
                        // order available
                        while($row = mysqli_fetch_assoc($res))
                        {
                            // Get all the order details
                            $id = $row['id'];
                            $food = $row['food'];
                            $price = $row['price'];
                            $qty = $row['qty'];
                            $total = $row['total'];
                            $order_date = $row['order_date'];
                            $status = $row['status'];
                            $customer_name = $row['customer_name'];
                            $customer_contact = $row['customer_contact'];
                            $customer_email = $row['customer_email'];
                            $customer_address = $row['customer_address'];

                            ?>

                            <tr>
                                <td><?php echo $sn++ ?> </td>
                                <td><?php echo $food?></td>
                                <td><?php echo $price?></td>
                                <td><?php echo $qty?></td>
                                <td><?php echo $total?></td>
                                <td><?php echo $order_date?></td>
                                <td><?php echo $status?></td>
                                <td><?php echo $customer_name?></td>
                                <td><?php echo $customer_contact?></td>
                                <td><?php echo $customer_email?></td>
                                <td><?php echo $customer_address ?></td>
                                <td>
                                    <a href="<?php echo SITEURL?>admin/update-order.php?id=<?php echo $id?>" class="btn-secondary"> Cập Nhật</a>
                                </td>
                            </tr>

                            <?php
                        }
                    } 
                    else
                    {
                        echo "<tr><td colpan = '12' class = 'error'>Đơn hàng không tồn tại!</td></tr>";
                    }
                ?>


            </table>


    </div>
</div>

<?php include("partials/footer.php"); ?>