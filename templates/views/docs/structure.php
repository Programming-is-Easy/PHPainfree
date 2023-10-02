
<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">PHPainfree<code>2</code> Program Structure</h2>
	<p class="lead mb-0">
		A detailed overview of the PHPainfree<code>2</code> framework structure.
	</p>
</div>

<div class="row mb-4">
	<div class="col-lg-6">
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
			<div class="card-header">htdocs/.htaccess</div>
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
			<div class="card-header">htdocs/index.php</div>
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
			<div class="card-header">includes/Painfree.php</div>
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
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">includes/PainfreeConfig.php</div>
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
</div>

<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>
			5. 
			<a href="/docs/painfree-application-controller">
				ApplicationController:</a>
			<code>includes/App.php</code>
		</h3>
		<p class="lead ms-4 text-warning">
			Now comes the fun part!
		</p>
		<p>
			This file is the heart of your specific application or website. At 
			this point, PHPainfree<code>2</code> is almost completely finished
			with all the magic that it does and you're expected to do the rest
			of the application development yourself.
		</p>
		<p class="m-4">
			The provided <code>App.php</code> makes an excellent starting point
			for your project. This script, and the singleton you're expected to create,
			will serve as the overall application state of your program for each
			and every HTTP request that is passed to the server and handled by
			PHPainfree<code>2</code>.
		</p>
		<p class="lead">
			For more detailed information about the ApplicationController,
			please see <a href="/docs/painfree-application-controller">/docs/painfree-application-controller</a>.
		</p>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
<pre data-line="5" data-line-offset="-1" id="test"><code class="language-treeview">PHPainfree/
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

<!-- App class overview -->
<div class="row mb-4 mt-5">
	<div class="col-lg-6">
		<h4 class="">
			<code class="language-php">class App</code> Overview
		</h4>
		<p class="m-4">
			The provided ApplicationController is a stripped down version of
			several production ApplicationControllers that have been developed
			for several large companies serving hundreds of thousands of requests
			for complicated highly-interactive data-driven web applications. 
			This file is an excellent starting point for projects of all sizes,
			ranging from quick Hackathon projects to high-availability production
			web applications.
		</p>
		<h5>Environment Setup - <code>includes/App.php</code></h5>
		<p>
			At the top of the ApplicationController, the code creates a global
			Singleton instance of <code class="language-php">class App</code> defined
			in this file.
		</p>
		<div class="ms-4 card bg-primary bg-opacity-10 border-info">
			<div class="card-body">
				<h5 class="card-title">Reminder</h5>
				<p class="fs-6">
					This ApplicationController is just code that is automatically executed
					by <code class="language-php">$Painfree->logic()</code> and 
					<strong>DOES NOT</strong> have to be fully defined in this file.
					Some products are better suited having the ApplicationController
					class stored in a different file and defined with proper namespacing,
					or perhaps loaded automatically through a PSR-4 composer autoload
					mechanism.
				</p>
				<blockquote class="blockquote mb-0 ">
					<p>	
						Build things to suit <span class="text-decoration-underline"><em>YOUR</em></span> 
						needs, not the framework's needs.
					</p>
					<footer class="blockquote-footer">
						Eric Harrison, 
						<cite title="PHPainfree Structure Documentation">
							PHPainfree Structure Documentation
						</cite>
					</footer>
				</blockquote>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">includes/App.php</div>
			<div class="card-body p-4">
				<pre class="line-numbers"><code class="language-php">
&lt;?php
	// It's common to rename the "App" class and object instance to match
	// your specific product. Feel free to leave it as $App or rename it.
	$App = new App();
				</code></pre>
			</div>
		</div>
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">includes/App.php</div>
			<div class="card-body p-4">
				<pre class="line-numbers" data-start="91" data-line="94-106" data-line-offset="91"><code class="language-php">
		class App {
		// snipped...

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
				</code></pre>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h5 class="mt-4">Other Classes</h5>
		<p>
			Directly below the instantiation, you can see a few lines commented
			out with a recommendation for how to build these types of ApplicationControllers.
		</p>
		<p>
			A common PHPainfree<code>2</code> design pattern is to attach several
			other required object Singletons to the primary ApplicationController
			Singleton. In the example code that is commented out, a 
			<code class="language-php">class User</code> singleton is imported
			and instantiated as a public member of the <code>$App</code> instance.
		</p>
		<p>
			Because this example ApplicationController uses the <code>$App</code>
			instance as the "application state" and execution director, it would
			be typical to have several such instances defined and attached to 
			the <code>$App</code> instance at run-time. There are several such
			pre-defined example classes available in this repository, and you
			can learn more about them at <a href="/docs/painfree-examples">/docs/painfree-examples</a>.
		</p>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">includes/App.php</div>
			<div class="card-body p-4">
				<pre class="line-numbers" data-start="4" data-line="5-6" data-line-offset="4"><code class="language-php">
	$App = new App();
	// any internal classes should be defined below
	// require_once 'includes/App/User.php'; 
	// $App->User = new User();
	
	// start routing and handle the request
	$App->route();
				</code></pre>
			</div>
		</div>
	</div>
</div>

<!-- Route() function -->
<div class="row mb-4 mt-5">
	<div class="col-lg-6">
		<h4 class="">
			<code class="language-php">$App->route()</code>
		</h4>
		<p class="m-4">
			Finally, on line 10, a tiny bit of magic happens with the call to
			<code class="language-php">$App->route()</code>. This code, defined
			inside the class is an example of an ApplicationController consuming
			the structured route of <code class="language-php">$Painfree->route</code> 
			to dynamically handle requests and pass them to the correct controller.
		</p>
		<p>
			Using this function, or one like it, allows PHPainfree<code>2</code>
			projects to orchestrate complex behaviors at URLs defined entirely
			by the name of the first value in the URL path.
		</p>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">includes/App.php</div>
			<div class="card-body p-4">
				<pre class="line-numbers" data-line="10" data-start="9" data-line-offset="10"><code class="language-php">
	// start routing and handle the request
	$App->route();

	/**
	 * App Singleton
	 */
	class App {
		// ... 
				</code></pre>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4 mt-5">
	<div class="col-lg-6">
		<h4 class="">
			<code class="language-php">$App-&gt;route()</code> ➡️
			<code class="language-php">$this-&gt;__setRoutes()</code>
		</h4>
		<p class="m-4">
			Inside <code>$App->route()</code>, the first thing we do is call the
			<code>__setRoutes()</code> private method. This function takes the route
			that PHPainfree<code>2</code> has defined and splits it up into various
			individual components. This ApplicationController has defined a routing
			format as: <code>/$VIEW/$ID/$ACTION</code>, so <code>__setRoutes()</code>
			examines <code>$Painfree->route</code> and assigns each piece to public
			member variables in <code>$App</code>
		</p>
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">includes/App.php, <code class="language-php">App::setRoutes()</code></div>
			<div class="card-body p-4">
				<pre class="line-numbers" data-start="81"><code class="language-php">
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
				</code></pre>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">includes/App.php</div>
			<div class="card-body p-4">
				<pre class="line-numbers" data-line="56" data-start="45" data-line-offset="45"><code class="language-php">
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
				</code></pre>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4 mt-5">
	<div class="col-lg-6">
		<h4 class="">
			"Magic" Routing
		</h4>
		<p class="m-4">
			Now that the route variables have been prepared, the <code>route()</code>
			method does the next four pieces of magic in a few short lines of code.
		</p>
		<ol>
			<li>Check if there is a controller script defined for <code>$App->view</code>.
				<ul>
					<li class="ms-4"><strong>If Controller Exists</strong>, load and execute the controller script.</li>
					<li class="ms-4"><strong>If No Controller</strong>, send a HTTP 404 status code.</li>
				</ul>
			</li>
			<li>
				<strong>htmx Support [partials]</strong>
				- Check the Request Headers to see if <code>HX-Request</code> is set 
				and set a boolean for our templates to use.
			</li>
			<li>
				<strong>htmx Support [boosted links]</strong>
				- Check the Request Headers to see if <code>HX-Boosted</code> is set 
				and set a boolean for our templates to use.
			</li>
			<li>
				<strong>Fast API Support</strong>
				- Check the request headers to see if <code>Content-Type</code> is
				set to "application/json" or a query parameter of <code>?json</code>
				was sent with the URL, and if so, set the response Content-Type and 
				immediately die and send back the contents of <code class="language-php">$this->data</code>
				encoded as JSON.
			</li>
		</ol>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">includes/App.php</div>
			<div class="card-body p-4">
				<pre class="line-numbers" data-start="58" data-line-offset="58"><code class="language-php">
			header('X-Frame-Options: SAMEORIGIN');

			if (file_exists("{$this->BASE_PATH}/includes/Controllers/{$this->view}.php")) {
				require_once "Controllers/{$this->view}.php";

				$headers = apache_request_headers();
				if ( isset($headers['HX-Request']) && 
					$headers['HX-Request'] === 'true' ) {
					$this->htmx = true;
				}
				if ( isset($headers['HX-Boosted']) && 
					$headers['HX-Boosted'] === 'true' 
				) {
					$this->htmx_boosted = true;
				}
				if ( isset($headers['Content-Type']) && 
					$headers['Content-Type'] === 'application/json' ) {
					header('Content-Type: application/json; charset=utf-8');
					die(json_encode($this->data));
				}
			} else {
				header('HTTP/1.0 404 Not Found');
				// We don't "die" here so that the developer can render a
				// nice looking 404 template if they want.
			}
				</code></pre>
			</div>
		</div>
	</div>
</div>


<div class="row mb-4 mt-5">
	<div class="col-lg-6">
		<h4 class="">
			Rendering a Template BaseView
		</h4>
		<p class="m-4">
			After completing the <code>route()</code> method, execution returns
			to <code>$Painfree</code> and <code class="language-php">$Painfree->view();</code>
			is called. This function loads the script defined in your <code>PainfreeConfig.php</code>
			BaseView option, which is the script located in <code>templates/</code>. In 
			the PainfreeConfig provided with this project, the initial BaseView template
			is defined as <code>templates/app.php</code>. 
		</p>
		<p>
			Your initial BaseView template is often going to be the most complicated
			template in your project, performing double-duty as an HTML skeleton for
			the rest of your views as well as dynamically loading view templates based
			on the URL. In PHPainfree<code>2</code>, this template also has code to handle
			<a href="https://htmx.org">htmx</a> partial templates.
		</p>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
<pre data-line="7" data-line-offset="2" data-start="2"><code class="language-treeview">PHPainfree/
|-- htdocs/
|-- includes/
`-- templates/
    |-- app.php
	`-- views/
	    `-- main.php
</code></pre>
			</div>
		</div>
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">templates/app.php</div>
			<div class="card-body p-4">

<pre><code class="language-php">
&lt;?php
if ( 
	$App->htmx && 
	! $App->htmx_boosted && 
	file_exists("{$App->BASE_PATH}/templates/views/{$App->view}.php") 
	) {
	// If we are an htmx request and the "view" variable exists in the top-level
	// templates folder, render that as an HTMX snippet.
	//
	// If we are an htmx request and there is a "sub-view" defined that lives
	// inside a folder, render _THAT_ instead of the full top-level snippet.
	//
	// In _this_ application, we're overriding $App->id to act as our default
	// "sub-view" route, but you should feel free to write whatever type of 
	// routing architecture that you want.
	//
	// This example requires that a top-level /templates/views/{$view}.php file 
	// exists **AND** a top-level /templates/views/{$view}/{$id}.php file to
	// exist for this magic to occur. 
	//
	// Each application built with PHPainfree should design their routing and
	// template relationships however best suits that product.
	$file_path = "{$App->BASE_PATH}/templates/views/{$App->view}/{$App->id}.php";
	if (file_exists($file_path)) {
		include_once "views/{$App->view}/{$App->id}.php";
	} else {
		include_once "views/{$App->view}.php";
	}
} else { 
?&gt;
&lt;!DOCTYPE html>
&lt;html lang="en">
	&lt;head>
		&lt;title>&lt;?= $Painfree->safe($App->title()); ?>&lt;/title>

		&lt;link rel="icon" type="image/x-icon" href="/images/favicon.ico" />
</code></pre>

			</div>
		</div>
	</div>
</div>

<div class="row mb-4 mt-5">
	<div class="col-lg-6">
		<h4 class="">
			Dynamic View Template Loading
		</h4>
		<p class="m-4">
			Inside of <code>templates/app.php</code> in the meat of our web template, 
			we'll load a template file in the <code>template/views/</code> directory
			if one exists with the same name as the value stored in 
			<code class="language-php">$App->view</code>.
		</p>
		<p>
			In PainfreeConfig, we have our <code>DefaultRoute</code> parameter
			defined as <code>"main"</code>, so our application will serve
			<code>templates/views/main.php</code> for any request to either
			<code>http://hostname.com/</code> (no path) as well as explictly called
			like <code>http://hostname.com/main</code>. The value of that view, <code>"main"</code>
			automatically loads:
		</p>
		<ul>
			<li class="font-monospace">includes/Controllers/<code>main</code>.php</li>
			<li class="font-monospace">templates/views/<code>main</code>.php</li>
		</ul>
		<p class="lead">
			This is one of the designs that makes developing projects with
			PHPainfree<code>2</code> so quick. Adding new pages is as simple as
			dropping a file in the <code>includes/Controllers/</code> folder and
			<code>templates/views/</code> folder. And as you develop more complicated
			applications, allowing all of your Controller code to serve as the
			business logic for your REST JSON API, you're able to do a lot more
			with a lot less duplication.
		</p>
	</div>
	<div class="col-lg-6">
	</div>
</div>

