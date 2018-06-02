<?php

namespace dusttoash\connections\Query;

class Pair {
	private $binding, $value;
	public function __construct(string $binding = NULL, &$value) {
		if ($binding != NULL)
			$this->binding = $binding;
		if ($value != NULL)
			$this->value = $value;
	}
	public function setValue(mixed &$value) {
		$this->value = $value;
	}
	public function getBinding() {
		return $this->binding;
	}
	public function &getValue() {
		return $this->value;
	}
}

namespace dusttoash\connections;

use PDO;

class Query {
	private const DEFAULT_SERVER_ADDRESS = 'localhost';
	private const DEFAULT_DATABASE_USERNAME = 'root';
	private const DATABASE_NAME = 'dusttoash';
	private static $database_password;
	private static function setDefaultDatabasePassword() {
		if (! isset ( self::$database_password )) {
			$file = fopen ( $_SERVER ['DOCUMENT_ROOT'] . '/private/database_login', 'r' );
			self::$database_password = fgets ( $file ); // Read database login password from hidden file.
			fclose ( $file );
		}
	}
	private $query;
	public function __construct(string $query, string $server_address = NULL, string $database_username = NULL, string $database_password = NULL, Query\Pair ...$bindings) {
		if ($server_address == NULL)
			$server_address = self::DEFAULT_SERVER_ADDRESS;
		if ($database_username == NULL)
			$database_username = self::DEFAULT_DATABASE_USERNAME;
		if ($database_password == NULL) {
			self::setDefaultDatabasePassword ();
			$database_password = self::$database_password;
		}
		
		$connection = new PDO ( "mysql:host=$server_address;dbname=" . self::DATABASE_NAME, $database_username, $database_password );
		$connection->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->query = $connection->prepare ( $query );
		
		foreach ( $bindings as $pair ) {
			$this->query->bindParam ( $pair->getBinding (), $pair->getValue () );
		}
		unset ( $pair );
	}
	public function execute(Query\Pair ...$bindings) {
		foreach ( $bindings as $pair ) {
			$this->query->bindParam ( $pair->getBinding (), $pair->getValue () );
		}
		unset ( $pair );
		$this->query->execute ();
	}
	
	// Executes query then fetches data.
	public function fetch(Query\Pair ...$bindings) {
		$this->execute ( ...$bindings );
		$this->query->setFetchMode ( PDO::FETCH_ASSOC );
		return $this->query->fetchAll ();
	}
}