<?php 
	/**
	 * @package App 
	 *
	 * Most products will want to rename the App class to better reflect
	 * your product. This is up to you, or you can leave it as App and do 
	 * whatever you want.
	 *
	 * @property string $env='development' - Current server environment. Set in .env with ENVIRONMENT=''
	 * @property string $title='PHPainfree2' - Page title used in the primary template.
	 * @property bool $htmx=false - Automatically true when hx-request is sent in request headers
	 * @property bool $htmx_boosted=false - Automatically true when the request is hx-boosted
	 * @property string $route='' - Copy of $Painfree->route set in App::route()
	 * @property ?string $app=null - /$view|$app/$id/$action - $app path param if using app routing.
	 * @property string $view='' - /$view|$app/$id/$action
	 * @property string $id='' - /$view|$app/$id/$action
	 * @property string $action='' - /$view|$app/$id/$action
	 * @property array<string,mixed> $data=[] - Template/API data array for controller->template sharing
	 * @property array<string,mixed> $objects=[] - Template data array for controller->template sharing (not exposed with ?json)
	 * @property ?string $BASE_PATH=null - Full directory path to web application 
	 * @property ?string $BASE_URI= - Full URL to web application (includes http:// and port)
	 */
	class App {
		// override this in .env with ENVIRONMENT="production" or whatever
		public string $env = 'development';

		private string $title = 'PHPainfree2';

		// if HX-Request header is sent, we're an htmx-powered request
		public bool $htmx = false;
		public bool $htmx_boosted = false;

		// request and response_headers
		public array $headers = array();
		public array $response_headers = array();

		// routing defaults
		public string $route  = '';
		public ?string $app   = null;
		public string $view   = '';
		public string $id     = '';
		public string $action = '';
		
		// used in CSV / save file output formats. 
		// can override default file naming convention
		public ?string $output_file = null;

		// controller/view data storage
		public array $data    = []; // publicly exposed "json" data
		public array $objects = []; // private template data.

		public ?string $BASE_PATH = null;
		public ?string $BASE_URI  = null;
		
		// DB reference handle
		public $db = null;

		/**
		 * This function sets the $title property. If $prepend is true, then the 
		 * existing title will be prepended to the new title.
		 *
		 * Ex: $App->title('Home', true); // title will be "Home | PHPainfree2"
		 *
		 * @param ?string $title=null - Title to set. If null, returns current title.
		 * @param bool $prepend=false - Prepend new title to current title.
		 *
		 * @return string $title - Current title.
		 */
		public function title(?string $title=null, bool $prepend=false): string {
			if ( $title !== null ) {
				if ( $prepend ) {
					$this->title = $title . ' | ' . $this->title;
				} else {
					$this->title = $title;
				}
			}
			return $this->title;
		}
		
		/**
		 * Returns a path to the folder if it exists
		 *
		 * @param string $app Name of the app
		 *
		 * @returns string 
		 */
		public function app_path($app) : string { 
			if ( ! file_exists($this->BASE_PATH . '/apps/' . $app) ) {
				return '';
			}
			return $this->BASE_PATH . '/apps/' . $app;
		}
		
		/**
		 * @return bool $is_csv_request=false - 
		 *	True if: $_REQUEST['csv'] is set _AND_ $this->data['records'] has content
		 *	False: default 
		 */
		public function csv_request() : bool {
			if ( isset($_REQUEST['csv']) && isset($this->data['records']) ) {
				return true;
			} 

			return false;
		}
		
		/**
		 * @return bool $is_json_request=false - 
		 *	True if: $_REQUEST['json'] is set _OR $this->headers['Accept'] === 'application/json'
		 *	False: default 
		 */
		public function json_request() : bool {
			if (
				isset($_REQUEST['json']) ||
				( isset($this->headers['Accept']) && $this->headers['Accept'] === 'application/json' )
			) {
				return true;
			}

			return false;
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
			
			$headers = apache_request_headers();
			$this->headers = $headers;
			
			$tz_offset = $headers['X-TZ-OFFSET'] ?? nullintparam('tz_offset');
			if ( $tz_offset ) {
				$_SESSION['tz_offset'] = $tz_offset;
			}

			// if you need to allow your website to be embeddable into another
			// website via iframe, disable this X-Frame-Options header.
			$this->response_header('X-Frame-Options', 'SAMEORIGIN');

			$app_controller  = "{$this->BASE_PATH}/apps/{$this->view}/controllers/{$this->view}.php";
			$view_controller = "{$this->BASE_PATH}/includes/Controllers/{$this->view}.php";

			$found_controller = false;
			if ( file_exists($app_controller) ) {
				$found_controller = $app_controller;
				$this->app = $this->view;

				// execute the controller
				require_once $app_controller;
			} else if ( file_exists($view_controller) ) {
				$found_controller = $app_controller;

				// execute the controller
				require_once $view_controller;
			}

			if ( $found_controller ) {
				// Process and handle JSON API Requests
				if ( $this->json_request() ) {
					$this->response_header('Content-Type', 'application/json; charset=utf-8');

					// JSON output exits early, so we need to send response headers 
					// before creating output
					$this->__send_response_headers();

					die(json_encode($this->data));
				}
				
				// CSV output is natively provided to any array stored in 
				// $App->data['records']
				// This array is assumed to be an array of associative arrays 
				// with [ [ 'key' => 'val', 'key2' => 'val2' ], ...]
				if ( $this->csv_request() ) {
					$this->__generate_csv_and_quit();	
				}

				if ( isset($headers['HX-Request']) && $headers['HX-Request'] === 'true' ) {
					$this->htmx = true;
				}
				if ( isset($headers['HX-Boosted']) && $headers['HX-Boosted'] === 'true' ) {
					$this->htmx_boosted = true;
				}

			} else {
				header('HTTP/1.0 404 Not Found');
				// We don't "die" here so that the developer can render a
				// nice looking 404 template if they want.
			}
		}
		
		/**
		 * $App->response_header() sets a response header and sends them all out 
		 * prior to loading any template output. If $header_value is an array, 
		 * all of those values will be sent as sequential headers (most often used 
		 * for Content-Type)
		 *
		 * @param string $header_name 
		 * @param mixed $header_value=null 
		 *
		 * @return int $response_code 
		 *	- -1 = error code (should not be possible)
		 *	- 0  = deleted existing header value completely
		 *	- 1  = added 
		 *	- 2  = already set, value swapped
		 */
		public function response_header(string $header_name, mixed $header_value=null) : int {
			$HEADER_EXISTS = isset($this->response_headers[$header_name]);
			
			// DELETE EXISTING CODE with null header_value, response code = 0
			if ( $HEADER_EXISTS && $header_value === null ) {
				unset($this->response_headers[$header_name]);

				return 0;
			
			// SET and add new header with valid value, response code = 1
			} else if ( ! $HEADER_EXISTS && $header_value !== null ) {
				$this->response_headers[$header_name] = $header_value;

				return 1;
			
			// REPLACE existing header code with new value, response code = 2
			} else if ( $HEADER_EXISTS && $header_value !== null ) {
				$this->response_headers[$header_name] = $header_value;
				return 2;
			}

			// ERROR condition, response code -1
			return -1;
		}

		/**
		 * $App->single_response_header() sets a stand-alone response header 
		 * in $App->response_headers. This is generally used for specific 
		 * cases like sending 'HTTP/1.0 404 Not Found'.
		 *
		 * @param string $header
		 *
		 * @return int $response_code 
		 *	- -1 = error code (should not be possible)
		 *	- 1  = added 
		 */
		public function single_response_header(string $header) : int {
			if ( isset($this->response_headers[$header]) ) {
				return -1;
			}

			$this->response_headers[$header] = null;
			return 1;
		}

		/**
		 * __generate_csv_and_quit() is called by route() when 
		 * csv_request() is true. It grabs the tabular records 
		 * created by the view-specific controller that is expected 
		 * to exist in $this->data['records'].
		 *
		 * If no records exist, it will insert an empty record so that 
		 * the user will no that no records exist.
		 *
		 * If records do exist, it will create a file output stream 
		 * named with either $this->output_file (if string exists) or 
		 * $this->view if not.
		 *
		 * It then sends the file out as an attachment and calls die() 
		 * to end future processing and end the request.
		 *
		 * @return void (die() at the end of the method)
		 */
		private function __generate_csv_and_quit() : void {
			if ( ! count($this->data['records']) ) {
				$csv_message = "The CSV file you requested was empty and did not contain any records.";
				$this->data['records'][] = array(
					'CSV Output Error' => $csv_message,
				);
			}

			if ( $this->view ) {
				$file_name = 'PHPainfree-' . ($this->output_file ?? $this->view) . '-' . time() . '.csv';
			} else {
				$file_name = 'PHPainfree-' . time() . '.csv';
			}
		
			$this->response_header('Content-Type', [ 
				'application/force-download',
				'application/octet-stream',
				'application/download'
			]);
			$this->response_header('Content-Disposition', "attachment;filename={$file_name}");
			$this->response_header('Content-Transfer-Encoding', 'binary');

			ob_start();
			$df = fopen('php://output', 'w');
			// passing &flat in the request does not make a header row
			$first_key = array_key_first($this->data['records']);
			if ( ! isset($_REQUEST['flat']) ) {
				fputcsv($df, array_keys($this->data['records'][$first_key]), escape: "\\");
			}
			foreach ( $this->data['records'] as $row ) {
				fputcsv($df, array_values($row), escape: "\\");
			}
			fclose($df);

			// CSV also outputs early, so we need to send our response 
			// headers early.
			$this->__send_response_headers();

			echo ob_get_clean();
			die();
		}

		/**
		 * Private function (called by $App->route()) to send any response 
		 * headers stored in $App->response_headers prior to loading any 
		 * view content into the output buffer. This function should only be 
		 * called one time prior to any output.
		 *
		 * Existing Controllers might generate content or have already sent 
		 * headers using the built-in header() function. They might also 
		 * have manually generated output content that blocks this mechanism 
		 * for debugging/development purposes, but in general use, this function 
		 * is a safe way to send all headers at once.
		 */
		private function __send_response_headers() : void {
			if ( $this->response_headers ) {
				foreach ( $this->response_headers as $header => $value ) {
					$val_type = gettype($value);
					if ( $val_type === 'array' ) {
						foreach ( $value as $i => $val ) {
							header("{$header}: {$val}");
						}

					// any null value is set by $App->single_response_header()
					// and does not contain a value of any type.
					} else if ( $val_type === 'NULL' ) {
						header("{$header}");
					} else {
						header("{$header}: {$value}");
					}
				}
			}
		}

		/**

		/**
		 * This private function explodes $Painfree->route (the requested user route)
		 * and sets $this->view, $this->id, $this->action 
		 *
		 * If you have a different URL scheme for your product, you can 
		 * rewrite this function to set whatever properties match your  
		 * application URL design.
		 *
		 * @return void 
		 */
		private function __setRoutes() : void {
			$routes = explode('/', $this->route);

			// save a copy of the initial route for use 
			// in controllers or templates where you want 
			// to inspect the initial request.
			$this->route_parts = $routes;

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

		/**
		 * The class constructor sets a few configuration items necessary 
		 * for every request. 
		 *
		 * It creates: 
		 *  - $this->BASE_URI (the full URL to the server)
		 *  - $this->BASE_PATH (the full file path to the application)
		 *  - $this->env (overridden in .env)
		 *  
		 * And will optionally create a full database handle or access class 
		 * in $this->db
		 *
		 * If there are any other values or properties that are important 
		 * for every single request, this is a good place to define them.
		 *
		 * @return void 
		 */
		public function __construct() {
			global $Painfree;

			$this->BASE_URI = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}";
			if ( $_SERVER['REQUEST_SCHEME'] === 'http' && $_SERVER['SERVER_PORT'] !== '80' ) {
				$this->BASE_URI .= ":{$_SERVER['SERVER_PORT']}";
			}
			$this->BASE_PATH = str_replace('/htdocs', '', $_SERVER['DOCUMENT_ROOT']);

			$this->env = $_ENV["ENVIRONMENT"] ?? 'development';


			/**
			 * Uncomment these lines to use the provided MySQLiHelpers 
			 * class with query(), queryOne(), and queryWithAssocKey()
			 */
			require_once $this->BASE_PATH . '/includes/core/MySQLiHelpers.php';
			$this->db = new MySQLiHelpers($Painfree->db);

			/**
			 * OR use this if you want to manually access the MySQLi (or other)
			 * db handle directly and not use the provided MySQLiHelpers class
			 */
			// $this->db = $Painfree->db;
			
			// Set up the route and prepare for routing
			$this->route = $Painfree->route;
		}
	}

