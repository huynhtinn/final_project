<?php
include 'components/connect.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if(!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, hiển thị thông báo và liên kết đến trang đăng nhập
    echo '<script>alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!");</script>';
    echo '<meta http-equiv="refresh" content="0;URL=user_login.php">';
    exit; // Kết thúc kịch bản sau khi hiển thị thông báo và chuyển hướng
}

// Tiếp tục xử lý thêm sản phẩm vào giỏ hàng nếu người dùng đã đăng nhập
if(isset($_POST['add_to_cart'])) {
    // Trích xuất thông tin sản phẩm từ dữ liệu POST
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['qty'];
    $image = $_POST['image'];

    // Thêm thông tin sản phẩm vào bảng cart
    $insert_cart = $conn->prepare("INSERT INTO cart (user_id, pid, name, price, quantity, image) VALUES (:user_id, :pid, :name, :price, :quantity, :image)");
    $insert_cart->bindParam(':user_id', $_SESSION['user_id']);
    $insert_cart->bindParam(':pid', $pid);
    $insert_cart->bindParam(':name', $name);
    $insert_cart->bindParam(':price', $price);
    $insert_cart->bindParam(':quantity', $quantity);
    $insert_cart->bindParam(':image', $image);
    $insert_cart->execute();

    // Thông báo thành công hoặc chuyển hướng đến trang giỏ hàng
    //echo '<script>alert("Sản phẩm đã được thêm vào giỏ hàng!");</script>';
    echo '<meta http-equiv="refresh" content="0;URL=home.php">'; // Chuyển hướng về trang chính
    exit;
}
?>
