<?php

namespace dusttoash\logins;

class UserData {
	private const COOKIE_USERNAME = "dta_username";
	private const COOKIE_SESSION_ID = "dta_session_id";
	
	// True if the client is entirely logged in, false otherwise.
	private static $loggedIn;
	
	// True if the client has some, but not all, of the cookies that are used to determine whether or not the client is logged in, set. False otherwise.
	private static $halfLoggedIn;
	public static function isHalfLoggedIn() {
		if (isset ( self::$halfLoggedIn ))
			return self::$halfLoggedIn;
		self::isLoggedIn ();
		return self::$halfLoggedIn;
	}
	public static function isLoggedIn() {
		if (isset ( self::$loggedIn ))
			return self::$loggedIn;
		
		if (! (isset ( $_COOKIE [COOKIE_USERNAME] ) and isset ( $_COOKIE [COOKIE_SESSION_ID] ))) {
			// This if block checks to see if the user is lacking any of the cookies that are used to determine if they're logged in. If the user only has one of the two cookies (e.g. they have a username cookie but no sessionID), then the below call to 'logoutLocally' will remove the single cookie.
			// The user should not have only one of the two login cookies set, however, the user can edit their own cookies (I have a chrome plugin that lets me do so, for example), so we try to fix this ASAP.
			self::$halfLoggedIn = isset ( $_COOKIE [COOKIE_USERNAME] ) or isset ( $_COOKIE [COOKIE_SESSION_ID] );
			
			// If neither cookies are set, this still gets called. All it does is unset cookies though, so it's ok.
			logoutLocally ();
			return self::$loggedIn = false;
		}
		
		self::$halfLoggedIn = false;
		
		$username = $_COOKIE [COOKIE_USERNAME];
		$sessionID = $_COOKIE [COOKIE_SESSION_ID];
		
		
		
		// TODO Check login information.
	}
	
	/*
	 * Adds a new user to the database, given login information. This method also sets cookies accordingly (logs in locally) and returns true upon success. If an error is encountered, the error message, as a string, is returned.
	 */
	public function createNewUser(string $username, string $email, string $password) {
		try {
			$usernameCheck = new \dusttoash\connections\Query ( "SELECT username FROM users WHERE username=:username LIMIT 1", NULL, NULL, NULL, new \dusttoash\connections\Query\Pair ( "username", $username ) );
			echo $usernameCheck->fetch()?"That username already exists":"That username is not taken! :D";
			exit ();
			// Generate a sessionID.
			$sessionID = random_int ( PHP_INT_MIN, PHP_INT_MAX );
			// Here we'll use a prepared statement to prevent injection and stuff.
			$query = $connection->prepare ( "INSERT INTO users (username, email, password, sessionID)
VALUES (:username, :email, :password, $sessionID)" );
			
			// Login locally (on the client's browser).
			loginLocally ( $username, $sessionID );
			return true;
		} catch ( PDOException $e ) {
			// Don't locally login
			return $e->getMessage ();
		}
		$connection = null;
	}
	private function loginLocally(string $username, int $sessionID) {
		setcookie ( COOKIE_USERNAME, $username, 0, "/" );
		setcookie ( COOKIE_SESSION_ID, $sessionID, 0, "/" );
	}
	private function logoutLocally() {
		setcookie ( COOKIE_USERNAME, FALSE, time () - 1, "/" );
		setcookie ( COOKIE_SESSION_ID, FALSE, time () - 1, "/" );
	}
}
