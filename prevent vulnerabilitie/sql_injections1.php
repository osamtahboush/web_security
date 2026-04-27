<?php
// ========== الطريقة الصحيحة الوحيدة: Prepared Statements ==========

// MySQLi
$stmt = $mysqli->prepare("SELECT id, username, email FROM users WHERE id = ? AND status = ?");
$stmt->bind_param("is", $id, $status);  // i = integer, s = string
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo htmlspecialchars($row['username']);  // حماية ضد XSS أيضاً
}

// PDO
$stmt = $pdo->prepare("SELECT * FROM products WHERE category = :cat AND price <= :max");
$stmt->execute([':cat' => $category, ':max' => $maxPrice]);

// ========== التحقق من صحة الإدخال (defense in depth) ==========

// للـ ID الرقمية
if (!ctype_digit($id)) {
    die("Invalid ID");
}

// للأسماء (حروف فقط)
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    die("Invalid username format");
}

// القائمة البيضاء للخيارات المحدودة
$allowedSort = ['ASC', 'DESC'];
if (!in_array($sortOrder, $allowedSort)) {
    $sortOrder = 'ASC';
}

// ========== أبداً لا تفعل هذا ==========
// $result = $mysqli->query("SELECT * FROM users WHERE id = $id");     // خطأ
// $result = $mysqli->query("SELECT * FROM users WHERE id = '$id'");   // خطأ
// mysql_query("SELECT * FROM users WHERE id = $id");                  // خطأ + دالة منتهية

// ========== إعدادات MySQL إضافية ==========
// تعطيل FILE privilege للمستخدم المستخدم من التطبيق
// REVOKE FILE ON *.* FROM 'appuser'@'localhost';

// تعطيل عرض الأخطاء للمستخدم
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
mysqli_report(MYSQLI_REPORT_OFF);  // لا تعرض تفاصيل أخطاء MySQL
?>