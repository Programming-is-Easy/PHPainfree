<?php
	// It's common to rename the "App" class and object instance to match
	// your specific product. Feel free to leave it as $App or rename it.
	$App = new App();
	// any internal classes should be defined below
	// require_once 'includes/App/User.php'; 
	// $App->User = new User();
	
	// start routing and handle the request
	$App->route();

	/**
	 * App Singleton
	 */
	class App {
		private string $title = 'PHPainfree2';

		// if HX-Request header is sent, we're an htmx-powered request
		public bool $htmx = false;
		public bool $htmx_boosted = false;

		// routing defaults
		public string $route;
		public string $view   = '';
		public string $id     = '';
		public string $action = '';

		// controller/view data storage
		public array $data    = []; // publicly exposed "json" data
		public array $objects = []; // private template data.

		public string $BASE_PATH;

		public function title($title = null,$prepend = false): string {
			if ( $title !== null ) {
				if ( $prepend ) {
					$this->title = $title . ' ' . $this->title;
				} else {
					$this->title = $title;
				}
			}
			return $this->title;
		}

		/**
		 * $App->route() takes the $Painfree->route value and attempts
		 * to load a controller from `/includes/Controllers/`.
		 *
		 * @return void
		 */
		public function route() : void {
			global $Painfree;
			
			// the default routing pattern is
			// /:VIEW/:ID/:ACTION
			$this->__setRoutes();
			
			header('X-Frame-Options: SAMEORIGIN');

			if ( file_exists("{$this->BASE_PATH}/includes/Controllers/{$this->view}.php") ) {
				require_once "Controllers/{$this->view}.php";

				$headers = apache_request_headers();
				if ( isset($headers['HX-Request']) && $headers['HX-Request'] === 'true' ) {
					$this->htmx = true;
				}
				if ( isset($headers['HX-Boosted']) && $headers['HX-Boosted'] === 'true' ) {
					$this->htmx_boosted = true;
				}
				if ( isset($headers['Content-Type']) && $headers['Content-Type'] === 'application/json' ) {
					header('Content-Type: application/json; charset=utf-8');
					die(json_encode($this->data));
				}
			} else {
				header('HTTP/1.0 404 Not Found');
				// We don't "die" here so that the developer can render a
				// nice looking 404 template if they want.
			}
		}

		private function __setRoutes() : void {
			$routes = explode('/', $this->route);

			// default route is set in PainfreeConfig.php
			if ( count($routes) ) {
				$this->view = array_shift($routes);
			} else {
				$this->view = $this->route;
			}

			if ( count($routes) ) {
				$this->id = array_shift($routes);
			}

			if ( count($routes) ) {
				$this->action = array_shift($routes);
			}
		}

		public function __construct() {
			global $Painfree;

			$this->BASE_PATH = str_replace('/htdocs', '', $_SERVER['DOCUMENT_ROOT']);

			// $this->db = $Painfree->db;
      // OR
			// require_once 'core/MySQLiHelpers.php';
			// $this->db = new MySQLiHelpers($Painfree->db);
			
			// Set up the route and prepare for routing
			$this->route = $Painfree->route;
		}
	}

