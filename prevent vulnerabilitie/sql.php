
<?php    

if(isset($_GET['Submit'])){
    
    // Retrieve data
    
    $id = $_GET['id'];

    $getid = "SELECT first_name, last_name FROM users WHERE user_id = '$id'";
    $result = mysql_query($getid) or die('<pre>' . mysql_error() . '</pre>' );

    $num = mysql_numrows($result);

    $i = 0;

    while ($i < $num) {

        $first = mysql_result($result,$i,"first_name");
        $last = mysql_result($result,$i,"last_name");
        
        echo '<pre>';
        echo 'ID: ' . $id . '<br>First name: ' . $first . '<br>Surname: ' . $last;
        echo '</pre>';

        $i++;
    }
}
?>

$id = stripslashes($id);
$id = mysql_real_escape_string($id); 

#---------------------------------------------------------
xss 

<?php

if(!array_key_exists ("name", $_GET) || $_GET['name'] == NULL || $_GET['name'] == ''){

 $isempty = true;

} else {
        
 echo '<pre>';
 echo 'Hello ' . $_GET['name'];
 echo '</pre>';
    
}

?>
str_replace('<script>', '', $_GET['name']);
htmlspecialchars($_GET['name']);

echo htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

// 2. Strip tags
echo strip_tags($input, '<b><i>'); // السماح بوسوم معينة فقط

// 3. URL encode
echo urlencode($input);

// 4. JSON encode (للـAJAX)
echo json_encode($input);

// 5. CSP Header (أمان إضافي)
header("Content-Security-Policy: default-src 'self'; script-src 'self'");

# xss stor
   // Sanitize message input
   $message = stripslashes($message);
   $message = mysql_real_escape_string($message);
   $message = htmlspecialchars($message);
   
   // Sanitize name input
   $name = stripslashes($name);
   $name = mysql_real_escape_string($name); 
   $name = htmlspecialchars($name);


#---------------------------------------------------
#os <command>

<?php

if( isset( $_POST[ 'submit' ] ) ) {

    $target = $_REQUEST[ 'ip' ];

    // Determine OS and execute the ping command.
    if (stristr(php_uname('s'), 'Windows NT')) { 
    
        $cmd = shell_exec( 'ping  ' . $target );
        echo '<pre>'.$cmd.'</pre>';
        
    } else { 
    
        $cmd = shell_exec( 'ping  -c 3 ' . $target );
        echo '<pre>'.$cmd.'</pre>';
        
    }
    
}
?>
// Remove any of the charactars in the array (blacklist).
    $substitutions = array(
        '&&' => '',
        ';' => '',
    );




    $target = str_replace( array_keys( $substitutions ), $substitutions, $target );



    $target = stripslashes( $target );
    // Split the IP into 4 octects
    $octet = explode(".", $target);
    
    // Check IF each octet is an integer
    if ((is_numeric($octet[0])) && (is_numeric($octet[1])) && (is_numeric($octet[2])) && (is_numeric($octet[3])) && (sizeof($octet) == 4)  ) {
    
    // If all 4 octets are int's put the IP back together.
    $target = $octet[0].'.'.$octet[1].'.'.$octet[2].'.'.$octet[3];




system("ping " . $_GET['ip']);

// 2. escapeshellcmd / escapeshellarg
$ip = escapeshellarg($_POST['ip']);
$output = shell_exec("ping -c 4 $ip");

// 3. استخدام filter_input
$ip = filter_input(INPUT_POST, 'ip', FILTER_VALIDATE_IP);
if (!$ip) {
    die("Invalid IP");
}

// 4. Whitelist validation
$allowed_commands = ['ping', 'traceroute', 'nslookup'];
$cmd = $_GET['cmd'];
if (!in_array($cmd, $allowed_commands)) {
    die("Command not allowed");
}

// 5. بديل آمن: use PHP functions بدل system
$ip = $_POST['ip'];
if (filter_var($ip, FILTER_VALIDATE_IP)) {
    $ping_result = exec("ping -c 1 " . escapeshellarg($ip), $output, $status);
}


#---------------------------------
# file upload

<?php
    if (isset($_POST['Upload'])) {

            $target_path = DVWA_WEB_PAGE_TO_ROOT."hackable/uploads/";
            $target_path = $target_path . basename( $_FILES['uploaded']['name']);

            if(!move_uploaded_file($_FILES['uploaded']['tmp_name'], $target_path)) {
                
                echo '<pre>';
                echo 'Your image was not uploaded.';
                echo '</pre>';
                
              } else {
            
                echo '<pre>';
                echo $target_path . ' succesfully uploaded!';
                echo '</pre>';
                
            }

        }
?>

            $uploaded_name = $_FILES['uploaded']['name'];
            $uploaded_type = $_FILES['uploaded']['type'];
            $uploaded_size = $_FILES['uploaded']['size'];

            if (($uploaded_type == "image/jpeg") && ($uploaded_size < 100000)){


            $uploaded_name = $_FILES['uploaded']['name'];
            $uploaded_ext = substr($uploaded_name, strrpos($uploaded_name, '.') + 1);
            $uploaded_size = $_FILES['uploaded']['size'];

            if (($uploaded_ext == "jpg" || $uploaded_ext == "JPG" || $uploaded_ext == "jpeg" || $uploaded_ext == "JPEG") && ($uploaded_size < 100000)){


#--------------------------------------------
#path travel 



<?php

    $file = $_GET['page']; //The page we wish to display 

?>
// Bad input validation
    $file = str_replace("http://", "", $file);
    $file = str_replace("https://", "", $file);        

    
    
    // Only allow include.php
    if ( $file != "include.php" ) {
        echo "ERROR: File not found!";
        exit;
    }














