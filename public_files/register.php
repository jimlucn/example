<?php
include '../lib/common.php';
include '../lib/db.php';
include '../lib/functions.php';
include '../lib/User.php';

session_start();
header('Cache-control: private');

ob_start();
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<table>
	  <tr>
	    <td><label for="username"> Username </label></td>
	    <td><input type="text" name="username" id="username" value="<?php if (isset($_POST['username'])){echo htmlspecialchars($_POST['username']);}?>" /></td>
	  </tr><tr>
	    <td><label for="password1"> Password</label></td>
	    <td><input type="password" name="password1" id="password1" value="" /></td>
	  </tr><tr>
	  </tr><tr>
	    <td><label for="password2"> Password</label></td>
	    <td><input type="password" name="password2" id="password2" value="" /></td>
	  </tr><tr>
	  </tr><tr>
	    <td><label for="email"> Email Address</label></td>
	    <td><input type="text" name="email" id="email" value="<?php if (isset($_POST['email'])){echo htmlspecialchars($_POST['email']);}?>" /></td>
	  </tr><tr>
	  </tr><tr>
	    <td><input type="submit" value="Sign Up" /></td>
	    <td><input type="hidden" name="submitted" value="1" /></td>
	  </tr><tr>
	</table>
</form>
<?php
$form = ob_get_clean();

if(!isset($_POST['submitted'])){
	$GLOBALS['TEMPLATE']['content'] = $form;
}else{
	$password1 = (isset($_POST['password1'])) ? $_POST['password1'] : '';
	$password2 = (isset($_POST['password2'])) ? $_POST['password1'] : '';
	$password = ($password1 && $password1 == $password2) ? sha1($password1) : '';

	$captcha = (isset($_POST['captcha']) && strtoupper($_POST['captcha']) == $_POST['captcha']);

	if (User::validateUsername($_POST['username']) && $password && User::validateEmailAddr($_POST['email']) /*&& $captcha*/){
		$user = User::getByUsername($_POST['username']);
		if ($user-> userId){
			$GLOBALS['TEMPLATE']['content'] = '<p><strong> Sorry, that account already exists.</strong></p>'.'<p> Please try a different username.</p>';
			$GLOBALS['TEMPLATE']['content'] .= $form;
		}else{
			$user = new User();
			$user-> username = $_POST['username'];
			$user-> password = $password;
			$user-> emailAddr = $_POST['email'];
			$token = $user->setInactive();

			$GLOBALS['TEMPLATE']['content'] = '<p><storng> Thank you for registering.</storng></p>'.
			'<p> Be sure to verify your account by visiting <a href="verify.php?uid='.$user-> userId.'& token='.$token.'">verify.php?uid='.$user-> userId.' & token ='.$token.'</a></p>';
		}
	}
	else{
		$GLOBALS['TEMPLATE']['content'] = '<p><strong> You provided some invalid data.</strong></p>'.
		'<p> Please fill in all fields correctly so we can register your user account.</p>';
		$GLOBALS['TEMPLATE']['content'] .= $form;
	}
}

include '../templates/template-page.php';
?>