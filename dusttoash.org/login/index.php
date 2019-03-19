<?php
use dusttoash\logins\Database;
use dusttoash\connections\Query;
use dusttoash\connections\Query\Pair;
$database = new Database ();
$loggedIn = $database->isLoggedIn ();
function printForm(string ...$errors) {
	global $loggedIn;
	
	t ( true );
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

if (isset ( $_POST ['identifier'] ) and isset ( $_POST ['password'] )) {
	$identifier = $_POST ['identifier'];
	$passwordInput = $_POST ['password'];
	
	$errors = array ();
	
	$isEmail = false;
	
	if (! $identifier)
		array_push ( $errors, "Please enter either your username or your email." );
	else if ($isEmail = (strpos ( $identifier, "@" ) !== false))
		// Handle email.
		if (strlen ( $identifier ) > 255)
			array_push ( $errors, "That email is too large." );
		else if (! filter_var ( $identifier, FILTER_VALIDATE_EMAIL ))
			array_push ( $errors, "That email is invalid." );
		
		// $result is set regardless of the value of this if statement. We're gonna unset it after all this if...else crap is done.
		else if (! ($result = (new Query ( "SELECT password, username FROM users WHERE email=:identifier", null, null, null, new Pair ( "identifier", $identifier ) ))->fetch ()))
			array_push ( $errors, "'$identifier' is an invalid email. Please use a different email. (If that was supposed to be your username, then please remove the '@' symbol and try again.)" );
		else {
			// If no errors have been pushed, then we're gonna verify that the given password is correct. Cache it.
			$password = $result [0] ['password'];
			// Store the username so that it can be used for local login in a second.
			$username = $result [0] ['username'];
		}
	else { // I left these unnecessary braces in for the sake of your readability, whoever you are... :)
		if (! $identifier)
			array_push ( $errors, "Please enter your username." );
		else if (strlen ( $identifier ) < 3)
			array_push ( $errors, "That username is too short." );
		else if (strlen ( $identifier ) > 32)
			array_push ( $errors, "That username is too long." );
		else if (! preg_match ( "/^[\w _\\-\\.\u{00c4}\u{00e4}\u{00cb}\u{00eb}\u{00cf}\u{00ef}\u{00d6}\u{00f6}\u{00dc}\u{00fc}\u{0178}\u{00ff}]*$/", $identifier ))
			array_push ( $errors, "That username includes some invalid characters." );
		else if (! $result = (new Query ( "SELECT password FROM users WHERE username=:username", null, null, null, new Pair ( "username", $identifier ) ))->fetch ())
			array_push ( $errors, "An account by the name of, '$identifier', could not be found. Please try a different username." );
		else {
			$password = $result [0] ['password'];
			$username = $identifier;
		}
	}
	
	unset ( $result );
	
	if ($errors) {
		unset ( $password );
		printForm ( ...$errors );
	} else {
		if (strcmp ( $passwordInput, $password ) !== 0)
			printForm ( "That password is incorrect." );
		else {
			$sessionID = random_int ( - 2 ** 15, 2 ** 15 - 1 );
			try {
				$success = ( boolean ) (new Query ( "UPDATE users SET sessionID = :sessionID WHERE " . ($isEmail ? "email=:email" : "username=:username"), null, null, null, new Pair ( "sessionID", $sessionID ), ($isEmail ? new Pair ( "email", $email ) : new Pair ( "username", $username )) ))->execute ();
				$database->loginLocally ( $username, $sessionID );
			} catch ( PDOException $e ) {
				$success = false;
				$ERR = true;
			}
			
			t ( true );
			if ($success)
				echo "You've successfully been logged in!";
			else {
				if (isset ( $e )) {
					echo '<span style="color: var(--hard-red);">An internal error has occurred. You might have still been logged in, however. You can refresh the page to try and log in again just in case.</span>';
					var_dump ( $e );
				} else
					echo '<span style="color: var(--hard-gold);">Failed to log you in. Refresh the page to try again.</span>';
			}
			unset ( $e );
			unset ( $ERR );
			b ();
		}
	}
} else {
	$errors = array ();
	
	if (isset ( $_POST ['identifier'] ) or isset ( $_POST ['password'] )) {
		if (! isset ( $_POST ['identifier'] ))
			array_push ( $errors, "Please add a username/email to your request. (Reminder: Make sure to keep track of your cookies!)" );
		if (! isset ( $_POST ['password'] ))
			array_push ( $errors, "Please add a password to your request." );
	}
	
	printForm ( ...$errors );
}