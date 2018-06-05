<?php

namespace dusttoash\logins;

class Database {
	private const COOKIE_USERNAME = "dta_username";
	private const COOKIE_SESSION_ID = "dta_session_id";
	
	// True if the client is entirely logged in, false otherwise.
	private static $loggedIn;
	private static $currentUsername, $currentSessionID;
	
	// True if the client has some, but not all of the cookies that are used to determine whether or not the client is logged in, set. False otherwise.
	private static $halfLoggedIn;
	public function isHalfLoggedIn() {
		if (isset ( self::$halfLoggedIn ))
			return self::$halfLoggedIn;
		self::isLoggedIn ();
		return self::$halfLoggedIn;
	}
	public function isLoggedIn() {
		if (isset ( self::$loggedIn ))
			return self::$loggedIn;
		if (isset ( self::$currentUsername ) and isset ( self::$currentSessionID )) {
			// It was set to an empty value (probably by the logout method).
			if (! self::$currentUsername)
				return self::$loggedIn = false;
			$username = self::$currentUsername;
			$sessionID = self::$currentSessionID;
		} else if (! (isset ( $_COOKIE [self::COOKIE_USERNAME] ) and isset ( $_COOKIE [self::COOKIE_SESSION_ID] ))) {
			
			// This if block checks to see if the user is lacking any of the cookies that are used to determine if they're logged in. If the user only has one of the two cookies (e.g. they have a username cookie but no sessionID), then the below call to 'logoutLocally' will remove the single cookie.
			// The user should not have only one of the two login cookies set, however, the user can edit their own cookies (I have a chrome plugin that lets me do so, for example), so we try to fix this ASAP.
			self::$halfLoggedIn = isset ( $_COOKIE [self::COOKIE_USERNAME] ) or isset ( $_COOKIE [self::COOKIE_SESSION_ID] );
			
			// If neither cookies are set, this still gets called. All it does is unset cookies though, so it's ok.
			self::logoutLocally ();
			return self::$loggedIn = false;
		} else {
			$username = $_COOKIE [self::COOKIE_USERNAME];
			$sessionID = $_COOKIE [self::COOKIE_SESSION_ID];
		}
		self::$halfLoggedIn = false;
		
		// Inside those parantheses, we're creating a new Query (to return any users that have the same sessionID and username as the client has in their cookies). We then run this query, and get an associative array as the result. self::$loggedIn is given the array, evaluated into a boolean (so false if it's empty meaning there is no user with a matching username and sessionID, or true otherwise). We return the result of this assignment to self::$loggedIn, so whether or not the user is logged in.
		return self::$loggedIn = ( boolean ) (new \dusttoash\connections\Query ( "SELECT id FROM users WHERE username=:username AND sessionID=:sessionID", NULL, NULL, NULL, new \dusttoash\connections\Query\Pair ( "username", $username ), new \dusttoash\connections\Query\Pair ( "sessionID", $sessionID ) ))->fetch ();
	}
	private static function uncacheLoginData() {
		self::$loggedIn = self::$halfLoggedIn = null;
	}
	public static function loginLocally(string $username, int $sessionID) {
		// This simply makes it so that the next call to "isLoggedIn" doesn't return the old value; (false, if the user wasn't logged in before this method runs).
		self::uncacheLoginData ();
		
		// We can send cookies to be set, but we'll receive data about those on the next page load. The current page needs to know that we are in fact logged in, so, now that we've uncached the previous value of self::$loggedIn, if there was any, we'll set these two static variables to override the cookie checkup. This basically says, "the user has this log in information in their cookies, we just can't see it yet" and makes calls to "isLoggedIn" reflect that.
		self::$currentUsername = $username;
		self::$currentSessionID = $sessionID;
		// Now we actually set the log in information on the user's browser which will be reflected on the next page load.
		setcookie ( self::COOKIE_USERNAME, $username, 0, "/" );
		setcookie ( self::COOKIE_SESSION_ID, $sessionID, 0, "/" );
	}
	public static function logout() {
		// Logging out is currently equivalent to logging out locally. Because of this, we just need to call logoutLocally().
		self::logoutLocally ();
		// We're logging out, so any overriding done by setting the current username and session id should be removed (AND it should be set to force self::isLoggedIn() to return FALSE. Checking the cookies will return true if the user was previous logged in, so if we set the override values (below) to NULL, isLoggedIn() will check cookies.)
		self::$currentUsername = self::$currentSessionID = "";
	}
	private static function logoutLocally() {
		// Client is no longer logged in. Uncache any cached login data.
		self::uncacheLoginData ();
		// Send cookies to remove the login from the client.
		setcookie ( self::COOKIE_USERNAME, FALSE, time () - 1, "/" );
		setcookie ( self::COOKIE_SESSION_ID, FALSE, time () - 1, "/" );
	}
	public static function getLocalUsername() {
		if (isset ( self::$currentUsername ))
			return self::$currentUsername;
		if (isset ( $_COOKIE [self::COOKIE_USERNAME] ))
			return $_COOKIE [self::COOKIE_USERNAME];
		return false;
	}
	public static function getLocalSessionID() {
		if (isset ( self::$currentSessionID ))
			return self::$currentSessionID;
		if (isset ( $_COOKIE [self::COOKIE_SESSION_ID] ))
			return $_COOKIE [self::COOKIE_SESSION_ID];
		return false;
	}
}
