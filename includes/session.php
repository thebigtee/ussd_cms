<?php
	session_start();

	function logged_in()
	{
		return isset($_SESSION['admin']);
	}

	function confirm_logged_in()
	{
		if (!logged_in())
		{
			redirect_to("login.php");
		}
	}

	function confirm_admin_logged_in()
	{
		if(!isset($_SESSION['adminusername']))
		{
			redirect_to("adminlogin.php");
		}
	}

	function confirm_session_set($session_name){
		if(isset($_SESSION[$session_name]))
			return true;
		else
			return false;
	}

	function logout($indexpage)
	{

	//2. unset the session
	$_SESSION = array();

	//3. Destroy the session cookie
	if(isset($_COOKIE[session_name()]))
	{
		setcookie(session_name(),'',time()-42000,'/');
	}

	// 4. Destroy the session
	session_destroy();


	// then lastly redirect to a page
	redirect_to("{$indexpage}");
	}

?>
