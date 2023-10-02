
<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">PHPainfree<code>2</code> ApplicationController</h2>
	<p class="lead mb-0">
		A detailed overview of the PHPainfree<code>2</code> ApplicationController.
	</p>
</div>

<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>
			ApplicationController:
			<code>includes/App.php</code>
		</h3>
		<p class="m-4">
			The provided <code>App.php</code> makes an excellent starting point
			for your project. This script, and the singleton you're expected to create,
			will serve as the overall application state of your program for each
			and every HTTP request that is passed to the server and handled by
			PHPainfree<code>2</code>.
		</p>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header fs-4 font-monospace">ApplicationController</div>
			<div class="card-body p-4">
				<table class="table table-striped table-dark">
					<thead>
						<tr>
							<th scope="col">What</th>
							<th scope="col">Where</th>
							<th scope="col">How</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td scope="row">Defined</td>
							<td><span class="font-monospace">PainfreeConfig.php</span></td>
							<td><code class="language-php">$PainfreeConfig['ApplicationController'];</code></td>
						</tr>
						<tr>
							<td scope="row">Called</td>
							<td><span class="font-monospace">Painfree.php</span></td>
							<td><code class="language-php">$Painfree->logic();</code></td>
						</tr>
					</tbody>
				</table>
<pre data-line="1,2,3" data-line-offset="-3" id="test"><code class="language-treeview">PHPainfree/
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

<pre class="line-numbers"><code class="language-php">
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
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">templates/app.php</div>
			<div class="card-body p-4">

<pre class="line-numbers" data-start="66"><code class="language-php">
	&lt;body id="app-body" class="bg-dark text-light">
&lt;?php
		include 'header.php';	
?>

&lt;?php
	if ( file_exists("{$App->BASE_PATH}/templates/views/{$App->view}.php") ) {
		include "views/{$App->view}.php";
	} else {
		include "views/404.php";
	}
?>

&lt;?php
		include 'footer.php';	
?>

</code></pre>

			</div>
		</div>
	</div>
</div>

