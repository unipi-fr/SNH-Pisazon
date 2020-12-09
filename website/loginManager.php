<?php
    require "dbManager.php";
	
	$username = $_POST['email'];
	$password = $_POST['password'];
	
	$errorMessage = login($username, $password);
	if($errorMessage === null)
		header('location: ./index.php');
	else {
		session_start();
		$_SESSION['errorMessage'] = $errorMessage;
		header('location: ./login.php');
	}

	function login($username, $password){   
		if ($username != null && $password != null){
			$ret = authenticate($username, $password);
    		if ($ret > 0){
    			session_start();
    			$_SESSION['username'] = $_POST['username'];
    			return null;
    		}

    	} else
    		return 'You should insert something';
    	
    	return 'Username or password invalid.';
	}
	
	function authenticate($username, $password){   
		global $db;
		$username = $db->sqlInjectionFilter($username);
		$password = $db->sqlInjectionFilter($password);

		$queryText = "select * from User where email='" . $username . "' AND password='" . $password . "'";

		$result = $db->performQuery($queryText);
		$numRow = mysqli_num_rows($result);
		if ($numRow != 1)
			return 0;
		
		$db->closeConnection();
		return 1;
	}
	
	function register($username, $password) {
		if ($username == null || $password == null)
			return 'Username or password invalid.';
		
		global $db;
		$username = $db->sqlInjectionFilter($username);
		
		$queryText = 'SELECT * FROM Player WHERE Username=\'' . $username . '\'';
		$result = $db->performQuery($queryText);
	
		if($result->num_rows === 1)
			return 'username already used';
		
		$password = $db->sqlInjectionFilter($password);
		$score = 0;
		$score = $db->sqlInjectionFilter($score);
		$queryText = 'INSERT INTO Player (Username, Password, BestScore) VALUES (\'' . $username . '\',\'' . $password . '\',' . $score . ')';
		$db->performQuery($queryText);
		$db->closeConnection();
		
		session_start();
    	$_SESSION['username'] = $_POST['username'];
		
		return null;
	}
?>