<?php
//引入文件
include '../lib/common.php';
include '../lib/db.php';
include '../lib/functions.php';
include '../lib/user.php';
include '401.php';

//开启session
session_start();

//调取用户数据
$user = User::getById($_SESSION['userId']);
echo $_SESSION['userId'];

ob_start();
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <table>
        <tr>
        	<td><label for="Username">Username</label></td>
        	<td><input type="text" name="username" disabled="disabled" readonly="readonly" value="<?php echo $user->username; ?>"></td>
        </tr><tr>
        	<td><label for="email">Email Address</label></td>
        	<td><input type="text" name="email" id="email" 
        	value="<?php echo (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : $user->emailAddr; ?>"></td>
        </tr><tr>
        	<td><label for="password1">New Password</label></td>
        	<td><input type="password" name="password1" id="password1"></td>
        </tr><tr>
        	<td><label for="password2">Password Again</label></td>
        	<td><input type="password" name="password2" id="password2"></td>
        </tr><tr>
        	<td></td>
        	<td><input type="submit" value="Save"></td>
        	<td><input type="hidden" name="submitted" value="1"></td>
        </tr>
    </table>
</form>
<?php
$form = ob_get_clean();

//判断是否提交了表单
if (!isset($_POST['submitted'])){
	$GLOBALS['TEMPLATE']['content'] = $form;
}else{
	$password1 = (isset($_POST['password1']) && $_POST['password1']) ? sha1($_POST['password1']) : $user->passowrd;
	$password2 = (isset($_POST['password2']) && $_POST['password2']) ? sha1($_POST['password2']) : $user->passowrd;
	$passowrd = ($password1 == $password2) ? $password1 : '';

	if (User::validateEmailAddr($_POST['email']) && $passowrd){
		$user->emailAddr = $_POST['email'];
		$user->password = $password;
		$user->save();

		$GLOBALS['TEMPLATE']['content'] = '<p><strong>Information in your record has been updated.</strong></p>';
	}else{
		$GLOBALS['TEMPLATE']['content'] = '<p><strong>You provided some invalid data.</strong></p>';
		$GLOBALS['TEMPLATE']['content'] .= $form;
	}
}

include '../templates/template-page.php';
?>

