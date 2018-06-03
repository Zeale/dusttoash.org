<?php
// First, we check if the user is logged in. This is done before any data is sent, regardless of the fact that the server has output buffering enabled. (Compatibility :))
$database = new \dusttoash\logins\Database ();

$already_logged_in = $database->isLoggedIn ();

t ( true );?>
    Please note that this website does not have a "verified certificate." (If you're using Chrome then you were probably notified of this upon visiting.) If someone is presistently trying to hack you, there might be a risk with submitting information to this site. Because of this, I advise you to <b>not</b> submit any delicate information to this site. <a href="reasons.php">This</a> is the reason that I haven't verified my certificate with a "trusted authority blah blah blah."
<?php if ($database->isLoggedIn ())
	// Give a notice to logged in users that they'll be logged out.
	echo "<span style=\"color: var(--hard-red);\">By the way, you are already logged in. Creating a new account will log you out of your current account.</span>"?>

<style>
    form {
        color: var(--secondary-color);
    }
</style>
<form style="margin-top: 20%;">
    Username:
    <input type="text" name="username">
    <br><br><br> Email:
    <input type="email" name="email"><br><br><br> Password:
    <input type="password" name="password">
</form>
