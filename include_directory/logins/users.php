<?php

function createNewUser($username, $email, $password) {

    
    $server='localhost';
    $database_username='root';
	
	$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/private/database_login', 'r');
    $database_password=fgets($file);// Read database login password from hidden file.
	
	fclose($file);

    try {
        $connection = new PDO("mysql:host=$server;dbname=dusttoash", $database_username, $database_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "INSERT INTO users (username, email, password)
VALUES ('$username', '$email', '$password')";

        $connection->exec($query);
        return true;
    } catch(PDOException $e) {
        
       return $e->getMessage();
        
    }
    
    $connection=null;
    
}

?>
