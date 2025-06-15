<?php
require_once '../config/db.php';
$conn = connectDB();

if (!isset($_GET['id'])) {
    die("Thiếu ID đơn hàng.");
}
$order_id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Không tìm thấy đơn hàng.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'];
    $updateStmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $updateStmt->execute([$new_status, $order_id]);
    header("Location: orders.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<style>
    .status-form-container {
        max-width: 500px;
        margin: 60px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .status-form-container h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }

    button, .cancel-link {
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        margin-right: 10px;
    }

    button {
        background-color: #2ecc71;
        color: white;
    }

    button:hover {
        background-color: #27ae60;
    }

    .cancel-link {
        background-color: #bdc3c7;
        color: #2c3e50;
    }

    .cancel-link:hover {
        background-color: #95a5a6;
    }
</style>

<div class="status-form-container">
    <h2>Chỉnh sửa trạng thái đơn hàng #<?= $order['order_id'] ?></h2>

    <form method="post">
        <label for="status">Trạng thái:</label>
        <select name="status" id="status" required>
            <option value="Đang xử lý" <?= $order['status'] == 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
            <option value="Đã xác nhận" <?= $order['status'] == 'Đã xác nhận' ? 'selected' : '' ?>>Đã xác nhận</option>
            <option value="Đang giao" <?= $order['status'] == 'Đang giao' ? 'selected' : '' ?>>Đang giao</option>
            <option value="Hoàn tất" <?= $order['status'] == 'Hoàn tất' ? 'selected' : '' ?>>Hoàn tất</option>
            <option value="Hủy" <?= $order['status'] == 'Hủy' ? 'selected' : '' ?>>Hủy</option>
        </select>

        <button type="submit">Cập nhật</button>
        <a href="orders.php" class="cancel-link">Hủy</a>
    </form>
</div>

<?php include 'footer.php'; ?>
