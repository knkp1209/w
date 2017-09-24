<?php


session_start();
@$old_user = $_SESSION['admin'];  // store  to test if they *were* logged in
unset($_SESSION['admin']);
session_destroy();

// start output html
//do_html_header("Logging Out");

if (!empty($old_user)) {
    $indexurl =  "login.php";
	header("Location: $indexurl");
    //do_html_url("login.php", "Login");
} else {
    echo "<p>您处于未登录状态，无需退出！</p>";
}


?>
