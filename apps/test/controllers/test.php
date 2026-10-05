<?php 
	/** 
	 * @file: apps/test/controllers/test.php - Example "app" controller.
	 *
	 * The earliest routing method preferred for PHPainfree applications  
	 * was to stuff all controllers in `includes/Controllers/` and have the 
	 * `$App->view` route parameter (the first path after the server URL) 
	 * be the name of the controller for that route.
	 *
	 * On larger projects, that method is ungainly and ends up with a 
	 * `includes/Controllers/` folder and `templates/views/` folder that grew 
	 * to comically large proportions.
	 *
	 * To remedy this error, PHPainfree v2 introduced the "app"-based routing 
	 * concept where the value of $App->view searched for a folder in `apps/`
	 * and, if found, used `apps/controllers/{$App->view}.php` for the  
	 * controller and `apps/views/{$App->view}.php` for the view template.
	 *
	 * This system worked extremely well in several very large applications 
	 * and is now the recommended structure for PHPainfree applications.
	 *
	 * The original routing mechanism is still available as a fall-back and 
	 * is still well-suited for global pages (login, signup, etc) where  
	 * the level of interactivity is not complex. This is the ideal way to  
	 * serve simple static pages while keeping your complex logical routes 
	 * and pages contained in app folders.
	 */

	$App = get_App();

	// Example use of $App->data[]. Anything in $App->data[] will be 
	// visibile in a JSON/API request, so be cautious about what you 
	// put in this array.
	$App->data = array(
		'sub-pages'       => array(
			'main'    => array(
				'label'    => 'App Routing', 
				'title'    => 'Using App Routing', 
				'selected' => false,
			),
			'objects' => array(
				'label'    => '$App->objects[]', 
				'title'    => 'The $App->objects[] Array', 
				'selected' => false,
			),
			'data' => array(
				'label'    => '$App->data[]', 
				'title'    => 'The $App->data[] Array', 
				'selected' => false,
			),
			'json' => array(
				'label'    => 'JSON API',
				'title'    => 'Automatic JSON API', 
				'selected' => false,
			),
		),
		'template'        => 'test',
		'visible-in-JSON' => true,
	);
	if ( ! $App->id ) {
		$App->id = 'main';
	}

	if ( isset($App->data['sub-pages'][$App->id]) ) {
		$App->data['sub-pages'][$App->id]['selected'] = true;
	}

	// Example of $App->objects[]. This is another place to store data 
	// you want to expose to your view templates, but this variable is NOT 
	// exposed automatically in a JSON/API request 
	$App->objects['private-data'] = "Don't leak this in JSON";
	$App->objects['user_id']  = 1;
	$App->objects['username'] = "Eric Harrison";
	$App->objects['password'] = "look@MySecr3tPASSword24!";

	// In a normal application controller, this is where you'll put all of  
	// your page-specific logic (database reads, updates, deletes, etc.)
	
	/**
	 * Example 
	 */
	$App->data['records'] = get_demo_database_records($App->objects['user_id']);
	

	/** 
	 * Example database fetching function for the view template 
	 *
	 * @param int $user_id 
	 * @return array $records 
	 */
	function get_demo_database_records(int $user_id) : array {
		$App = get_App();

		$query = "
			SELECT 
				id,user_id,language,years_experience,favorite,hated
			FROM user_lanaguages 
			WHERE user_id = ?
			ORDER BY years_experience DESC
		";
		// obviously this simple example doesn't exist and no such table 
		// exists, but this is what you'd normally see if you're using  
		// PHPainfree's MySQLiHelpers class.
		//$rows = $App->db->query($query, 'i', [$user_id]);
		
		$rows = [
			[4, 1, 'PHP', 27, 1, 0],	
			[5, 1, 'Javascript', 23, 1, 0],	
			[1, 1, 'C', 29, 1, 0],	
			[3, 1, 'C++', 20, 0, 1],	
			[9, 1, 'Python', 4, 0, 1],	
			[8, 1, 'Jai', 2, 1, 0],	
			[7, 1, 'Rust', 2, 0, 1],	
		];

		return $rows;
	}

