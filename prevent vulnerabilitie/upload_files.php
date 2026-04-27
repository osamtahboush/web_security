كيفية منع هجوم عبور المسار
الطريقة الأكثر فعالية لمنع ثغرات عبور المسار هي تجنب تمرير مدخلات المستخدم إلى واجهات برمجة تطبيقات نظام الملفات تمامًا. يمكن إعادة كتابة العديد من وظائف التطبيقات التي تقوم بذلك لتحقيق نفس الأداء بطريقة أكثر أمانًا.

إذا لم تتمكن من تجنب تمرير المدخلات التي يوفرها المستخدم إلى واجهات برمجة تطبيقات نظام الملفات، فنوصي باستخدام طبقتين من الدفاع لمنع الهجمات:

تحقق من صحة إدخال المستخدم قبل معالجته. يُفضل مقارنته بقائمة بيضاء للقيم المسموح بها. إذا لم يكن ذلك ممكنًا، فتأكد من أن الإدخال يحتوي فقط على المحتوى المسموح به، مثل الأحرف الأبجدية الرقمية فقط.
بعد التحقق من صحة المدخلات المُقدمة، أضِفها إلى الدليل الأساسي واستخدم واجهة برمجة تطبيقات نظام ملفات النظام الأساسي لإضفاء الطابع الرسمي على المسار. تأكد من أن المسار الرسمي يبدأ بالدليل الأساسي المتوقع.



<?php
// 1. التحقق من الامتداد
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
$ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowed_extensions)) {
    die("Extension not allowed");
}

// 2. التحقق من MIME type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
$allowed_mimes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($mime, $allowed_mimes)) {
    die("Invalid file type");
}

// 3. التحقق من الحجم
$max_size = 2 * 1024 * 1024; // 2MB
if ($_FILES['file']['size'] > $max_size) {
    die("File too large");
}

// 4. إعادة تسمية الملف (أهم خطوة)
$new_name = uniqid() . '.' . $ext;
$upload_dir = __DIR__ . '/uploads/';

// 5. التأكد من عدم وجود path traversal
$destination = $upload_dir . basename($new_name);
if (strpos(realpath($destination), realpath($upload_dir)) !== 0) {
    die("Invalid path");
}

// 6. تخزين خارج web root
$upload_dir = '/var/www/secure_uploads/'; // ليس public

// 7. تعطيل تنفيذ PHP في مجلد uploads
// في .htaccess:
// php_flag engine off

// مثال كامل:
function secureUpload($file) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($ext, $allowed)) return false;
    if ($file['size'] > 2000000) return false;
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) return false;
    
    $new_name = md5_file($file['tmp_name']) . '.' . $ext;
    $dest = '/var/secure_uploads/' . $new_name;
    
    return move_uploaded_file($file['tmp_name'], $dest);
}
?>

<FilesMatch "\.php$">
    SetHandler none
</FilesMatch>
php_flag engine off
Options -ExecCGI
AddType text/plain .php .phtml .php3



