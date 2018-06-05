<?php
use dusttoash\logins\Database;

$database = new Database ();
if ($loggedIn = $database->isLoggedIn ()) {
	$username = $database->getLocalUsername ();
	$database->logout ();
	t ( true );
	echo "See you soon $username! (You've been logged out.)";
} else {
	t ( true );
	echo "You were not logged in.";
}
b ();