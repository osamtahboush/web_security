كيفية منع هجوم عبور المسار
الطريقة الأكثر فعالية لمنع ثغرات عبور المسار هي تجنب تمرير مدخلات المستخدم إلى واجهات برمجة تطبيقات نظام الملفات تمامًا. يمكن إعادة كتابة العديد من وظائف التطبيقات التي تقوم بذلك لتحقيق نفس الأداء بطريقة أكثر أمانًا.

إذا لم تتمكن من تجنب تمرير المدخلات التي يوفرها المستخدم إلى واجهات برمجة تطبيقات نظام الملفات، فنوصي باستخدام طبقتين من الدفاع لمنع الهجمات:

تحقق من صحة إدخال المستخدم قبل معالجته. يُفضل مقارنته بقائمة بيضاء للقيم المسموح بها. إذا لم يكن ذلك ممكنًا، فتأكد من أن الإدخال يحتوي فقط على المحتوى المسموح به، مثل الأحرف الأبجدية الرقمية فقط.
بعد التحقق من صحة المدخلات المُقدمة، أضِفها إلى الدليل الأساسي واستخدم واجهة برمجة تطبيقات نظام ملفات النظام الأساسي لإضفاء الطابع الرسمي على المسار. تأكد من أن المسار الرسمي يبدأ بالدليل الأساسي المتوقع.


<?php
// 1. تصفية path traversal characters
$file = str_replace(['../', './', '..\\'], '', $_GET['file']);

// 2. استخدام basename (يزيل المسار)
$file = basename($_GET['file']); // index.php فقط

// 3. التحقق من realpath + prefix
$base_dir = __DIR__ . '/files/';
$file = realpath($base_dir . basename($_GET['file']));
if (strpos($file, $base_dir) !== 0) {
    die("Access denied");
}

// 4. Whitelist الملفات المسموحة
$allowed_files = ['readme.txt', 'help.html', 'about.php'];
if (!in_array($_GET['file'], $allowed_files)) {
    die("File not allowed");
}

// 5. استخدام basename + preg_match للـsanitize
$file = $_GET['file'];
if (preg_match('/^[a-zA-Z0-9_\-\.]+$/', $file)) {
    $path = '/var/www/files/' . $file;
} else {
    die("Invalid filename");
}

// 6. تعطيل allow_url_fopen و allow_url_include
// في php.ini:
// allow_url_fopen = Off
// allow_url_include = Off

// مثال كامل:
function safeReadFile($filename, $allowed_dir) {
    // Remove path traversal
    $filename = str_replace(['../', './'], '', $filename);
    $filename = basename($filename);
    
    // Build full path
    $full_path = $allowed_dir . '/' . $filename;
    
    // Verify real path
    $real_path = realpath($full_path);
    $allowed_dir = realpath($allowed_dir);
    
    if ($real_path === false || strpos($real_path, $allowed_dir) !== 0) {
        return false;
    }
    
    if (!file_exists($real_path)) {
        return false;
    }
    
    return file_get_contents($real_path);
}

echo safeReadFile($_GET['file'], '/var/www/secure_docs/');
?>

