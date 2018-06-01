<?php
namespace logins;
class UserData {
    /*
     * Adds a new user to the database, given login information. This method also sets cookies accordingly (logs in locally) and returns true upon success. If an error is encountered, the error message, as a string, is returned.
    */
    public function createNewUser($username, $email, $password) {
        $server = 'localhost';
        $database_username = 'root';
        $file = fopen($_SERVER['DOCUMENT_ROOT'] . '/private/database_login', 'r');
        $database_password = fgets($file); // Read database login password from hidden file.
        fclose($file);
        try {
            $connection = new PDO("mysql:host=$server;dbname=dusttoash", $database_username, $database_password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Generate a sessionID.
            $sessionID = random_int(PHP_INT_MIN, PHP_INT_MAX);
            // Here we'll use a prepared statement to prevent injection and stuff.
            $query = $connection->prepare("INSERT INTO users (username, email, password, sessionID)
VALUES (:username, :email, :password, $sessionID)");
            $connection->bindParam(':username', $username);
            $connection->bindParam(':email', $email);
            $connection->bindParam(':password', $password);
            // bindParam takes references to our bound variables. These can be set below which will change what is placed into the database when $query is executed.
            $query->execute();
            // TODO: Login locally.
            return true;
        }
        catch(PDOException $e) {
            // Don't locally login
            return $e->getMessage();
        }
        $connection = null;
    }
}
?>
