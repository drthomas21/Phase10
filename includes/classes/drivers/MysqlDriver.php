<?php
class MysqlDriver {
	const TABLE_NAME = "game_sessions";
	private static $Instance = array();
	private $conn = null;
	private $host;
	private $database;
	private $username;
	private $password;
	private $error;
	
	/**
	 * 
	 * @param string $username
	 * @param string $password
	 * @param string $host
	 * @param string $database
	 * @return MysqlDriver $Instance
	 */
	public static function getInstance($username, $password, $host = "localhost", $database = "") {
		$key = sha1($host . $database . $username . $password);
		if(!array_key_exists($key, self::$Instance)) {
			self::$Instance[$key] = new self($username, $password, $host, $database);
		}
		
		return self::$Instance[$key];
	}
	
	protected function __construct($username, $password, $host, $database) {
		$this->username = $username;
		$this->password = $password;
		$this->host = $host;
		$this->database = $database;
	}
	
	/**
	 * Connects to the database
	 * @return boolean
	 */
	public function connect() {
		if(!$this->conn) {
			$this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
			if($this->conn->connect_error) {
				$this->error = "Cannot connect to database";
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Return error message
	 * @return string
	 */
	public function getErrorMessage() {
		return $this->error;
	}
	
	public function getGameData($sessionID) {
		$sessionID = preg_replace("/[^a-zA-Z0-9]+/","",$sessionID);
		
		if(!empty($sessionID)) {
			if($statement = $this->conn->prepare("SELECT data FROM ".self::TABLE_NAME." WHERE session_id=? LIMIT 0,1")) {
				$statement->bind_param("s", $sessionID);
				$statement->execute();
				$statement->bind_result($Data);
				$statement->fetch();
				$statement->close();
				return $Data;
			} else {
				$this->error = $this->conn->error;
				if(empty($this->error)) {
					$this->error = "Failed to fetch from database";
				}
				return false;
			}
		} else {
			$this->error = "Missing valid session id";
			return false;
		}
	}
	
	public function setGameData($sessionID,$data) {
		$sessionID = preg_replace("/[^a-zA-Z0-9]+/","",$sessionID);
		
		if(!empty($sessionID)) {
			if($this->getGameData($sessionID)) {
				//We need to update;
				if($statement = $this->conn->prepare("UPDATE " . self::TABLE_NAME . " SET data=? WHERE session_id=?")) {
					$statement->bind_param("ss",$data,$sessionID);
					$statement->execute();
					$statement->close();
				} else {
					$this->error = $this->conn->error;
					if(empty($this->error)) {
						$this->error = "Failed to update the database";
					}
					return false;
				}
			} else {
				//We need to add
				if($statement = $this->conn->prepare("INSERT INTO " . self::TABLE_NAME . " (session_id,data) VALUES ( ? , ? )")) {
					$statement->bind_param("ss",$sessionID,$data);
					$statement->execute();
					$statement->close();
				} else {
					$this->error = $this->conn->error;
					if(empty($this->error)) {
						$this->error = "Failed to update the database";
					}
					return false;
				}
			}
		}
	}
	
	public function close() {
		if($this->conn) {
			$this->conn->close();
		}
	}
}