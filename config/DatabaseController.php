<?php
	class DBController 
	{
		private $host = "localhost";
		private $user = "root";
		private $password = "";
		private $database = "kasangguni";
		private $conn;
		
		//private $host = "localhost";
		//private $user = "u530833690_root";
		//private $password = "J0bfix_manp0wer";
		//private $database = "u530833690_jobfix";
		//private $conn;
		
		function __construct()
		{
			$this->conn = $this->connectDB();
			if(!empty($this->conn)) 
			{
		    	$this->selectDB();
			}
		}
		
		function connectDB() 
		{
			$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
			mysqli_set_charset($conn,"utf8");
			return $conn;
		}
		
		function selectDB() 
		{
	    	mysqli_select_db($this->conn, $this->database);
		}
		
		function runQuery($query) 
		{
			set_time_limit(10000);
			$result = mysqli_query($this->conn,$query);
			while($row = mysqli_fetch_assoc($result))
			{
				$resultset[] = $row;
			}		
			if(!empty($resultset))
				return $resultset;
		}
		
		function numRows($query) 
		{
			$result  = mysqli_query($this->conn,$query);
			$rowcount = mysqli_num_rows($result);
			return $rowcount;	
		}
		
		function executeQuery($query) 
		{
	    	$result  = mysqli_query($this->conn, $query);
	    	return $result;
		}
		
		function closeQuery() 
		{
	    	mysqli_close($this->conn);
		}
	}
?>