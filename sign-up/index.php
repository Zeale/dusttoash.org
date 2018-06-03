<?php

// First, we check if the user is logged in. This is done before any data is sent, regardless of the fact that the server has output buffering enabled, since this process may set some cookies. (Compatibility :))
$database = new \dusttoash\logins\Database ();

$already_logged_in = $database->isLoggedIn ();

// /////////////////////////////////////////// PRINT THE LOGIN FORM /////////////////////////////////////////////
function printForm(string ...$errors) {
	t ( true );
	
	// Print the errors from the previous attempt
	foreach ( $errors as $error )
		echo "<span style='color: var(--hard-red);'>$error</span>";
	
	?>
	    Please note that this website does not have a "verified certificate." (If you're using Chrome then you were probably notified of this upon visiting.) If someone is presistently trying to hack you, there might be a risk with submitting information to this site. Because of this, I advise you to
<b>not</b>
submit any delicate information here.
<a href="reasons.php">This</a>
is the reason that I haven't verified my certificate with a "trusted authority blah blah blah."
<?php
	
	global $already_logged_in;
	if ($already_logged_in)
		// Give a notice to logged in users that they'll be logged out.
		echo "<span style=\"color: var(--hard-red);\">By the way, you are already logged in. Creating a new account will log you out of your current account.</span>"?>

<style>
form {
	color: var(--secondary-color);
}
</style>
<form style="margin-top: 50px;" method="post">
	Username: <input type="text" name="username" <?php ?>> <br> <br> <br>
	Email: <input type="email" name="email"> <br> <br> <br> Password: <input
		type="password" name="password"> <br> <br> <br> <input type="submit">
</form>
<?php
}

use \dusttoash\connections\Query;
use \dusttoash\connections\Query\Pair;
// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Here we do the login process
if (isset ( $_POST ['username'] ) and isset ( $_POST ['email'] ) and isset ( $_POST ['password'] )) {
	$username = $_POST ['username'];
	$email = $_POST ['email'];
	$password = $_POST ['password'];
	
	$errors = array ();
	
	$usernameChecked = $emailChecked = false;
	
	// TODO Check to make sure that input is valid (as in the username needs to not have spaces and stuff).
	
	if (! $username) {
		array_push ( $errors, "Please include a username." );
		$usernameChecked = true;
	}
	if (! $email) {
		array_push ( $errors, "Please include an email address." );
		$emailChecked = true;
	}
	if (! $password)
		array_push ( $errors, "Please include a password." );
	
	// We want to notify the user that their username is taken, only if the username is not invalid. I'm not putting this here because I expect there not to be invalid usernames. I'm putting this here because I don't want PHP making a useless database lookup.
	if (! $usernameChecked && (new Query ( "SELECT * FROM users WHERE username=:username", NULL, NULL, NULL, new Pair ( "username", $username ) ))->fetch ())
		array_push ( $errors, "'$username' is taken. Please use a different username." );
	if (! $emailChecked && (new Query ( "SELECT * FROM users WHERE email=:email", NULL, NULL, NULL, new Pair ( "email", $email ) ))->fetch ())
		array_push ( $errors, "'$email' is already in use. Please use a different email." );
	
	if ($errors) {
		printForm ( ...$errors );
	} else {
		// TODO Create a new account (and print the page!).
		t ( true );
		echo "Account successfully created!";
		b ();
	}
} else {
	// If not all of the data are present...
	
	$errors = array ();
	
	// If at least one piece of data is present (but not all of them are).
	if ((isset ( $_POST ['username'] ) or isset ( $_POST ['email'] ) or isset ( $_POST ['password'] ))) {
		// For whatever reason, only some of the data are present. I'm assuming that they're accessing this page without a browser, since my browser adds null values in the post header if an input is left empty.
		if (! isset ( $_POST ['username'] ))
			array_push ( $errors, "Please add a username to your request." );
		if (! isset ( $_POST ['email'] ))
			array_push ( $errors, "Please add an email address to your request." );
		if (! isset ( $_POST ['password'] ))
			array_push ( $errors, "Please add a password to your request." );
	}
	
	printForm ( ...$errors );
}

// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

