
<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">PHPainfree<code>2</code> BaseView</h2>
	<p class="lead mb-0">
		A detailed overview of the PHPainfree<code>2</code> BaseView.
	</p>
</div>

<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>
			BaseView:
			<code>templates/app.php</code>
		</h3>
		<p class="m-4">
			The provided <code>app.php</code> BaseView is a good structural
			starting point for any project you intend to build. BaseView serves
			as the foundation for all templates output to the user in a normal
			HTTP web request. Think of the BaseView as a conductor for your 
			templates.
		</p>
		<p>
			In most PHPainfree<code>2</code> projects, the BaseView will also
			contain the HTML structure of your output and contain the initial
			HTML elements that define your website design and structure.
		</p>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header fs-4 font-monospace">BaseView</div>
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
							<td><code class="language-php">$PainfreeConfig['BaseView'];</code></td>
						</tr>
						<tr>
							<td scope="row">Called</td>
							<td><span class="font-monospace">Painfree.php</span></td>
							<td><code class="language-php">$Painfree->view();</code></td>
						</tr>
					</tbody>
				</table>
<pre data-line="1,2,5,6-7" data-line-offset="-3" id="test"><code class="language-treeview">PHPainfree/
|-- htdocs/
|-- includes/
|   |-- PainfreeConfig.php
|   |-- Painfree.php
|   |-- App.php
|   `-- Controllers/
`-- templates/
    |-- app.php
	`-- views/
	    `-- main.php
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

