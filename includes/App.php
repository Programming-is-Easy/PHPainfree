<?php
	/**
	 * @file App.php - Defined as the application entry point in 
	 * PainfreeConfig.php in the 'ApplicationController' field.
	 * 
	 * This begins the request and passes control off to your primary 
	 * ApplicationController through the $App->route() method.
	 *
	 * This file also defines a function called get_App() which will return 
	 * a reference to this object singleton anywhere in your application.
	 * This can be used in place of adding `global $App;` in all of your 
	 * files in order for your LSP to complain about any unrecognized 
	 * or unitiated variables, even when that variable is technically already 
	 * in the global scope.
	 */

	// It's common to rename the "App" class and object instance to match
	// your specific product. Feel free to leave it as $App or rename it.
	require_once 'App/App.class.php';	
	$App = new App();

	// any internal classes should be defined below
	// require_once 'includes/App/User.php'; 
	// $App->User = new User();
	
	// start routing and handle the request
	$App->route();

	/**
	 * Returns a reference to the global $App singleton for use in other 
	 * files and templates. This is a substitution to calling 
	 * `global $App` everywhere you need access to this object.
	 *
	 * @return App $App - The $App singleton
	 */
	function get_App() : App {
		global $App;

		return $App;
	}

