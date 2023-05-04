<?php
class Connection {
	private $connection;
	private $typeConnection;

    public function __construct($type = 'PDO') {
		$this->typeConnection = $type;
		$connection_array = require_once(__DIR__ . '/../../settings.php');
		$settings = $connection_array['db']['connection']['default'];
		
		if ($type === 'PDO') {
			try {	
				$this->connection = new PDO("mysql:host={$settings['host']};dbname={$settings['dbname']};cahrset={$settings['charset']}", $settings['username'], $settings['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => $settings['initStatements']]);
				$this->connection->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} catch (PDOException $e) {
				echo "Ошибка: " . $e->getMessage();
			}
		}
	}
	
	public function getConnection() {
		return $this->connection;
	}
}
