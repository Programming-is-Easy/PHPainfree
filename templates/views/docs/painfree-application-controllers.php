
<div class="row mb-4">
	<div class="col-lg-6">
		<h2>PHPainfree<code>2</code> Project Structure</h2>
		<p class="lead">
			By default, PHPainfree<code>2</code> is designed to provide <em>just enough</em>
			structure to allow you to rapidly build complex PHP-powered web sites and
			applications.
		</p>
		<h4>Default Structure</h4>
		<p class="lead">
			The default project structure focuses on three main top-level directories: 
			<ul>
				<li><code>htdocs/</code> - publicly accessible files and program entry-point.</li>
				<li><code>includes/</code> - Application objects, code, and Controllers.</li>
				<li><code>templates/</code> - Application views, templates, and partials.</li>
		</p>
	</div>
	<div class="col-lg-6">
		<!-- Step 1 -->
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
<pre><code class="language-treeview">PHPainfree/
|-- htdocs/
|   |-- .htaccess
|   |-- index.php
|   |-- css/
|   |-- js/
|   `-- images/
|-- includes/
|   |-- PainfreeConfig.php
|   |-- Painfree.php
|   |-- App.php
|   `-- Controllers/
`-- templates/
    |-- app.php
    `-- views/
</code></pre>
			</div>
		</div>
	</div>
</div>
<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h2>PHPainfree<code>2</code> Request Flow</h2>
		<p class="lead">
			Before diving in to PHP and looking at specific files, it's important
			to understand the flow of a request into a PHPainfree<code>2</code> 
			application.
		</p>
	</div>
</div>
<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>1. Initial Request - <code>htdocs/.htaccess</code></h3>
		<p>
			When a request comes in to your Apache server running a PHPainfree<code>2</code>
			application, the request is first processed by <code>.htaccess</code> (1). This
			Apache .htaccess file will ignore any URL that is trying to retrieve a file
			or directory that exists, but for all other URLs will grab the entire request
			path and rewrite the URL to <code>index.php?route=$1</code>.
		</p>
		<p>
			Thus, a request to <code>server.com/some/path/to/load</code> will be 
			transformed into <code>index.php?route=/some/path/to/load</code>, adding
			the entire path into a <code>$_REQUEST['route']</code> query parameter 
			and passing off the entire request to <code>index.php</code> (2).
		</p>
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
				<pre><code class="language-apacheconf">
RewriteEngine On

RewriteBase /

RewriteCond %{SCRIPT_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteRule ^(.+)$ index.php?route=$1&%{QUERY_STRING} [L]
				</code></pre>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<!-- Step 2 -->
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
<pre data-line="1" data-line-offset="-2"><code class="language-treeview">PHPainfree/
|-- htdocs/
|   |-- .htaccess
|   |-- index.php
|   |-- css/
|   |-- js/
|   `-- images/
|-- includes/
|   |-- PainfreeConfig.php
|   |-- Painfree.php
|   |-- App.php
|   `-- Controllers/
`-- templates/
    |-- app.php
    `-- views/
</code></pre>
			</div>
		</div>
	</div>
</div>
<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>2. First Script - <code>index.php</code></h3>
		<p>
			Once the request has been processed and passed off to <code>htdocs/index.php</code>,
			PHPainfree<code>2</code> takes over.
		</p>
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
				<pre><code class="language-php">
&lt;?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../');

// Uncomment if you're using Composer for PHP modules
// require realpath('../vendor/autoload.php');

include 'includes/Painfree.php';
				</code></pre>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<!-- Step 2 -->
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
<pre data-line="2" data-line-offset="-2"><code class="language-treeview">PHPainfree/
|-- htdocs/
|   |-- .htaccess
|   |-- index.php
|   |-- css/
|   |-- js/
|   `-- images/
|-- includes/
`-- template/
</code></pre>
			</div>
		</div>
	</div>
</div>
<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>3. PHPainfree<code>2</code> Framework - <code>includes/Painfree.php</code></h3>
		<p>
			<code>Painfree.php</code> does a tiny bit of setup, and first loads
			<code>includes/PainfreeConfig.php</code> (4) before creating an 
			instance of <code class="language-php">class PHPainfree</code>.
		</p>
		<h4 class="m-4">Painfree.php Sequencing</h4>
		<ol class="m-4">
			<li>
				Start an execution timer for benchmarking [
				<code class="language-php">$__painfree_start_time</code>
				].
			</li>
			<li>
				<code class="language-php">require 'PainfreeConfig.php';</code>
				to bring in your application configuration settings.
			</li>
			<li>
				Create an instance of <code class="language-php">class PHPainfree</code> to
				process the rest of the request and pass application control to the Application
				Singleton. <code class="language-php">$Painfree = new PHPainfree($PainfreeConfig);</code>
			</li>
			<li>
				Automatically load <strong>ANY</strong> <code>.php</code> files
				located in the <code>includes/Autoload</code> folder.
			</li>
			<li>
				Load the ApplicationController script defined in your <code>PainfreeConfig.php</code>
				file.
				<code class="language-php">include $Painfree->logic();</code>
			</li>
			<li>
				Lastly, after all application logic has been executed, load
				the BaseView template defined in your <code>PainfreeConfig.php</code>
				file.
				<code class="language-php">include $Painfree->view();</code>
			</li>
		</ol>
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
				<pre data-start="22" data-line="22,24,26,30-34,36,37" data-line-offset="22" class="line-numbers"><code class="language-php">
$__painfree_start_time = microtime(true);

require 'PainfreeConfig.php'; // you must have this file

$Painfree = new PHPainfree($PainfreeConfig);
$Painfree->URI = $_SERVER['SERVER_PORT'] == 80 ? 'http://' : 'https://';
$Painfree->URI .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// process Autoload folder
$loaders = $Painfree->autoload();
foreach ( $loaders as $load ) {
	include $load;
}

include $Painfree->logic(); // load the application logic controller 
include $Painfree->view();  // load the view

class PHPainfree {
	// cut for brevity
				</code></pre>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<!-- Step 2 -->
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
<pre data-line="3" data-line-offset="-2"><code class="language-treeview">PHPainfree/
|-- htdocs/
|-- includes/
|   |-- PainfreeConfig.php
|   |-- Painfree.php
|   |-- App.php
|   `-- Controllers/
`-- templates/
</code></pre>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>4. Configuration - <code>includes/PainfreeConfig.php</code></h3>
		<p>
			<code>PainfreeConfig.php</code>, read in by <code>Painfree.php</code> and
			passed directly into the <code class="language-php">new PHPainfree($PainfreeConfig);</code>
			constructor, does a lot of the heavy lifting in application setup.
		</p>
		<p>
			This file contains a single array named <code class="language-php">$PainfreeConfig</code>
			that defines some of the default routes, connects to the database, and specifies
			specific folders and scripts necessary for PHPainfree<code>2</code>.
		</p>
		<h4 class="m-4">Suggestions</h4>
		<p class="m-4">
			When you first download PHPainfree<code>2</code>, the default
			configuration provided loads a copy of this application and documentation
			to serve as an example of how to structure a project. However, this
			framework was designed to be <strong>non-opinionated</strong>, meaning
			that you are intended to use this framework in a manner that best suits
			your design intentions.
		</p>
		<p class="m-4">
			<code>ApplicationController</code>, <code>BaseView</code>, and
			<code>DefaultRoute</code> should be considered a starting-point
			to launch your development efforts. In most projects, you'll most-likely
			want to rename the ApplicationController from <code>App.php</code> to
			<code>YourProjectName.php</code> as well as changing the name of the
			class.
		</p>
		<p class="m-4">
			The <code class="language-php">class App {}</code> singleton instance
			that PHPainfree<code>2</code> will create handles all of the routing
			and business logic for your program, so it's helpful to pick a short
			name for this class and the instance it will create that matches your
			goals for your project. This will be covered in more detail in step 5, below.
		</p>
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
				<pre class="line-numbers"><code class="language-php">
&lt;?php
	$PainfreeConfig = array(
		'ApplicationController' => 'App.php',
		'BaseView'     => 'app.php',
		'DefaultRoute' => 'main',
		'Database'     => array(
			'PrimaryDB' => array(
				'host'   => $_ENV['MYSQL_HOST'],
				'user'   => $_ENV['MYSQL_USER'],
				'pass'   => $_ENV['MYSQL_PASSWORD'],
				'schema' => $_ENV['MYSQL_SCHEMA'],
				'port'   => $_ENV['MYSQL_PORT'],
			),
		),
		'RouteParameter' => 'route',
		'TemplateFolder' => 'templates',
		'LogicFolder'    => 'includes',
	);
				</code></pre>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
<pre data-line="4" data-line-offset="0"><code class="language-treeview">PHPainfree/
|-- htdocs/
|-- includes/
|   |-- PainfreeConfig.php
|   |-- Painfree.php
|   |-- App.php
|   `-- Controllers/
`-- templates/
</code></pre>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>5. Your ApplicationController - <code>includes/App.php</code></h3>
		<p>
			Now comes the fun part--programming!
		</p>
		<p>
			This file is the heart of your specific application or website. At 
			this point, PHPainfree<code>2</code> is almost completely finished
			with all the magic that it does and you're expected to do the rest
			of the application development yourself.
		</p>
		<h4 class="m-4"><code class="language-php">class App {}</code></h4>
		<p class="m-4">
			The provided <code>App.php</code> makes an excellent starting point
			for your project. This script, and the singleton you're expected to create,
			will serve as the overall application state of your program for each
			and every HTTP request that is passed to the server and handled by
			PHPainfree<code>2</code>.
		</p>
		<p class="m-4">
			Design pattern suggestions for ApplicationControllers can be found at 
			<a href="/docs/ApplicationControllers">/docs/ApplicationControllers</a>,
			but for the rest of this document we'll assume that you're using the
			provided <code>App.php</code> without any signification modifications.
		</p>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
<pre data-line="6" data-line-offset="0" id="test"><code class="language-treeview">PHPainfree/
|-- htdocs/
|-- includes/
|   |-- PainfreeConfig.php
|   |-- Painfree.php
|   |-- App.php
|   `-- Controllers/
`-- templates/
</code></pre>
			</div>
		</div>
	</div>
</div>

<div class="row m-4">
	<div class="col-lg-10">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
				<pre class="line-numbers"><code class="language-php">
&lt;?php
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
		private string $title = 'PHPainfree';

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

				</code></pre>
			</div>
		</div>
	</div>
</div>
