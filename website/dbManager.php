<?php
	require "dbConfig.php";
	
	$db = new DbManager();
	
	class DbManager {
		private $conn = null;
		
		function DbManager() {
			$this->openConnection();
		}
		
		function openConnection() {
			if(!$this->isOpened()) {
				global $dbHostname;
    			global $dbUsername;
    			global $dbPassword;
    			global $dbName;
				
				$this->conn = new mysqli($dbHostname, $dbUsername, $dbPassword);

				if ($this->conn->connect_error) 
					die("Connection failed: " . $conn->connect_error);
					
				$this->conn->select_db($dbName) or
					die ('Can\'t use Pisazon: ' . mysqli_error($conn));
			}
		}
		
		function isOpened(){
       		return ($this->conn != null);
    	}
		
		function performQuery($queryText) {
			if (!$this->isOpened())
				$this->openConnection();
			
			return $this->conn->query($queryText);
		}

		function closeConnection(){
 	       	if($this->conn !== null)
				$this->conn->close();
			
			$this->conn = null;
		}
		
		function sqlInjectionFilter($parameter) {
			if(!$this->isOpened())
				$this->openConnection();
				
			return $this->conn->real_escape_string($parameter);
		}

		function getConn(){
			if (!$this->isOpened())
				$this->openConnection();
			return $this->conn;
		}
	}
?>