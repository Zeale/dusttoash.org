<?php
use dusttoash\logins\Database;
$loggedIn = (new Database ())->isLoggedIn ();
function printForm(string ...$errors) {
	global $loggedIn;
	
	t ();
	
	if ($loggedIn)
		echo "<span style='color: var(--hard-gold);'>You are already logged in. Logging to a new account will log you out of your current account.</span>";
	
	// Print the errors from the previous attempt
	foreach ( $errors as $error )
		echo "<span style='color: var(--hard-red);'>$error</span>";
	?>
<style>
form {
	color: var(--secondary-color);
}
</style>
<form style="margin-top: 50px;" method="post">
	Username/Email: <input type="text" name="identifier"
		<?php if(isset($identifier)) echo " value='" . $identifier. "'";?>> <br>
	<br> <br> Password: <input type="password" name="password"
		<?php if(isset($password)) echo " value='" . $password . "'";?>> <br>
	<br> <br> <input type="submit">
</form>
<?php
}

if (isset ( $_POST ['identifier'] ) && isset ( $_POST ['password'] )) {
}