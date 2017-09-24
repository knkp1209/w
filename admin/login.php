<?php

require_once('../db_fns.php');
// The shopping cart needs sessions, so start one
session_start();

$error = '';
if (isset($_POST['submitted'])) { // Check if the form has been submitted.
	$validate="";
	if(isset($_POST["validate"])){
		$validate=$_POST["validate"];
		if($validate!=$_SESSION["authnum_session"]){
		//判断session值与用户输入的验证码是否一致;
			$error="验证码有误请重新输入"; 
		}else{
			 // Validate the email address.
		    if (!empty($_POST['userName'])) {
		        $n = trim($_POST['userName']);
		    } else {
		        $n = FALSE;
		    }

		    // Validate the password.
		    if (!empty($_POST['password'])) {
		        $p = trim($_POST['password']);
		    } else {
		        $p = FALSE;
		    }

		    if ($n && $p) { // If everything's OK.

		        // Query the database.
		        $conn = db_connect();
		        $query = "select lgmail,appname,rid from tenant where lgmail='" . $n . "' and pwd=sha1('" . $p . "');";

		        $result = $conn->query($query);

		        if (@$result->num_rows == 1) { // A match was made.

		            // Register the values & redirect.
		            $row = $result->fetch_assoc();
		            $_SESSION['customer'] = array();
		            $_SESSION['customer']['mail'] = $row['lgmail'];
		            $_SESSION['customer']['appname'] = $row['appname'];
		            $_SESSION['customer']['rid'] = $row['rid'];

		            // // Start defining the URL.
		            // $a = '';
		            // $a = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
		            // // Check for a trailing slash.
		            // if ((substr($a, -1) == '/') OR (substr($a, -1) == '\\')) {
		            //     $url = substr($a, 0, -1); // Chop off the slash.
		            // }
		            // Add the page.
		            $a = 'index.php';

		            header("Location: $a");
		            exit(); // Quit the script.

		        } else { // No match was made.
		            $error = '用户名或者密码错误';
		        }

		    } else {
		    	 $error = '系统错误，请稍候再试。';

		    }

		}
	}

   


} // End of SUBMIT conditional.
?>
<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>登录</title>
		<link rel="stylesheet" href="plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="css/login.css" />
	</head>

	<body class="beg-login-bg">
		<div class="beg-login-box">
			<header>
				<h1>后台登录</h1>
			</header>
			<div class="beg-login-main">
				<form action="login.php" class="layui-form" method="post"><input type="hidden" name="submitted" value="TRUE"/>
					<div class="layui-form-item">
						<label class="beg-login-icon">
                        <i class="layui-icon">&#xe612;</i>
                    </label>
						<input type="text" name="userName" lay-verify="userName" autocomplete="off" placeholder="这里输入登录名" class="layui-input">
					</div>
					<div class="layui-form-item">
						<label class="beg-login-icon">
                        <i class="layui-icon">&#xe642;</i>
                    </label>
						<input type="password" name="password" lay-verify="password" autocomplete="off" placeholder="这里输入密码" class="layui-input">
					</div>
					<div class="layui-form-item">
						<div class="beg-pull-left beg-login-remember">
<input type="text" class="layui-input" name="validate" value="" size=10>

						</div>
						<div class="beg-pull-right">
<img  title="点击刷新" src="./captcha.php" align="absbottom" onclick="this.src='captcha.php?'+Math.random();"></img>
						</div>
						<div class="beg-clear" style="text-align: center; padding-top: 10px;"><button class="layui-btn layui-btn-primary" lay-submit lay-filter="login">
                            <i class="layui-icon">&#xe650;</i> 登录
                        </button></div>
					</div>
				</form>
			</div>
			<footer>
				<p><?php echo $error; ?></p>
			</footer>
		</div>
		<script type="text/javascript" src="plugins/layui/layui.js"></script>
		<script>
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					$ = layui.jquery,
					form = layui.form();
					
				form.on('submit(login)',function(data){
					return true;
				});
			});
		</script>
	</body>

</html>