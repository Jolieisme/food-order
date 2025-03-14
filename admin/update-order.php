<?php include("partials/menu.php"); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Cập Nhật Đơn Hàng</h1>
        <br><br>

        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];

                // get all other details base on this id
                $sql = "SELECT * FROM tbl_order WHERE id = $id";
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);
                if($count == 1){
                        $row = mysqli_fetch_assoc($res);
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $customer_name = $row['customer_name'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                        $status = $row['status']; // order ,đang vận chuyển, vận chuyển xong, hủy 
                        $customer_contact = $row['customer_contact'];
                }
                else
                {
                    header("location:".SITEURL."admin/manage-order/php");
                }

            }
            else 
            {
                header("location:".SITEURL."admin/manage-order/php");
            }
        ?>

        <form action="" method="post">
            <table width="40%">
                <tr>
                    <td>Tên Món</td>
                    <td><b><?php echo $food ?></b></td>
                </tr>

                <tr>
                    <td>Giá</td>
                    <td><b><?php echo $price ?></b></td>
                </tr>

                <tr>
                    <td>Số lượng</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty ?>">
                    </td>
                </tr>

                <tr>
                    <td>Trạng thái</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Đặt Hàng">Đặt Hàng</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?> value="Đang Vận Chuyển">Đang vận chuyển</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Vận Chuyển Thành Công">Vận chuyển thành công</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Huỷ Đơn">Hủy</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Tên khách hàng: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name?>">
                    </td>
                </tr>

                <tr>
                    <td>SĐT: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact?>">
                    </td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td>
                        <input type="text" name="customer_email" value = "<?php echo $customer_email?>">
                    </td>
                </tr>

                <tr>
                    <td>Địa Chỉ:</td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="price" value="<?php echo $price?>">
                        <input type="submit" name="submit" value="Cập Nhật" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

    </div>
</div>


<?php
    if(isset($_POST['submit'])){
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $id = $_POST['id'];
        $total = $price * $qty;
        $customer_name = $_POST['customer_name'];
        $customer_email = $_POST['customer_email'];
        $customer_address = $_POST['customer_address'];
        $status = $_POST['status']; // đang order ,đang vận chuyển, vận chuyển xong, hủy 
        $customer_contact = $_POST['customer_contact'];  


        $sql2 = "UPDATE tbl_order SET
            qty = $qty,
            total = $total,
            status = '$status',
            customer_name = '$customer_name',
            customer_contact = '$customer_contact',
            customer_email = '$customer_email',
            customer_address = '$customer_address'
            WHERE id = $id

        ";

        $res2 = mysqli_query($conn, $sql2);
        
         if($res2==true)
        {
            $_SESSION['update'] = "<div class = 'success'>Cập nhật đơn hàng thành công!</div>";
            header("location:".SITEURL."admin/manage-order.php");
        }
        else
        {
            $_SESSION['update'] = "<div class = 'error'>Cập nhật đơn hàng thất bại!</div>";
            header("location:".SITEURL."admin/manage-order.php");
        }
    }
?>

<?php include("partials/footer.php"); ?>