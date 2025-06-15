<?php
require '../config/db.php';
$conn = connectDB();

$stmt = $conn->prepare("SELECT user_id, name, email, role, created_at FROM user ORDER BY created_at DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?>

<style>
.user-container {
  max-width: 900px;
  margin: 40px auto;
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
.user-container h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #2c3e50;
}
.user-table {
  width: 100%;
  border-collapse: collapse;
}
.user-table th, .user-table td {
  padding: 12px;
  border: 1px solid #ddd;
  text-align: center;
}
.user-table th {
  background: #f2f2f2;
  color: #333;
}
.user-table td a {
  margin: 0 5px;
  color: #3498db;
  text-decoration: none;
  font-weight: bold;
}
.user-table td a:hover {
  color: #e67e22;
  text-decoration: underline;
}
.add-user-btn {
  display: inline-block;
  background: #2ecc71;
  color: #fff;
  padding: 10px 18px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  margin-bottom: 20px;
  transition: background 0.3s ease;
}
.add-user-btn:hover {
  background: #27ae60;
}
</style>

<div class="user-container">
  <h2>Quản lý người dùng</h2>
  <a href="user_add.php" class="add-user-btn">➕ Thêm người dùng</a>
  <table class="user-table">
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created At</th><th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
      <tr>
        <td><?= $u['user_id'] ?></td>
        <td><?= htmlspecialchars($u['name']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>
        <td><?= htmlspecialchars($u['created_at']) ?></td>
        <td>
          <a href="user_edit.php?id=<?= $u['user_id'] ?>">Sửa</a>
          <?php if ($u['role'] !== 'admin'): // Không cho xóa admin ?>
          | <a href="user_delete.php?id=<?= $u['user_id'] ?>"
               onclick="return confirm('Xác nhận xóa người dùng?')">Xóa</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>
