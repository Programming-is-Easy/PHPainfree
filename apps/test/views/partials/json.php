
<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">The Automatic JSON API powered by <code>$App->data[]</code></h2>
	<p class="lead mb-0">
		Using the Automatic JSON API.
	</p>
</div>

<div class="row mb-4">
	<div class="col-lg-6">
		<h2 class="fw-bolder">Automatic APIs for Free!</h2>
		<p class="lead">
			To streamline API development and promote code reusability in 
			your web applications, the PHPainfree<code>2</code> routing 
			system provides you with a JSON API at each and every unique 
			URL and endpoint.
		</p>
		<p class="lead">
			Rather than writing a separate API to serve any of your users 
			that need access to an API, PHPainfree<code>2</code> turns every 
			page and route into an API automatically using the <code>$App->data[]</code> 
			array.
		</p>
		<

		<p class="lead">
			Because of this, you should never put any sensitive information in 
			<code>$App->data[]</code> that you do <strong>NOT want visible</strong> 
			to any user of your page.
		</p>
		<p>
			See 
			<a
				href="/test/data"
				hx-get="/test/data"
				hx-target="#example_content"
				hx-push-url="true"
				onclick="setTimeout(function() { set_active(getEl('data_menu_item')); Prism.highlightAll(); }, 1000);"
				hx-on::after-request="set_active(getEl('data_menu_item'));Prism.highlightAll();"
			>$App->data[]</a> 
			and 
			<a
				href="/test/objects"
				hx-get="/test/objects"
				hx-target="#example_content"
				hx-push-url="true"
				onclick="setTimeout(function() { set_active(getEl('objects_menu_item')); Prism.highlightAll(); }, 1000);"
				hx-on::after-request="set_active(getEl('objects_menu_item'));Prism.highlightAll();"
			>$App->objects[]</a> for more details.
		</p>
		<h3 class="fw-bolder">Accessing the API</h3>
		<p class="lead">
			By default, the JSON API for any route/endpoint is automatically 
			served whenever a request is made with an <code>Accept</code> request 
			header set to <code>application/json</code>.
		</p>
		<p>
			The <code>$App->route()</code> method will also serve the API for 
			any request submitted with <strong>ANY</strong> query parameter 
			or POST body field with the name <code>json</code>.
		</p>
	</div>
	<div class="col-lg-6">
		<!-- Step 1 -->
		<div class="card bg-dark border-info mb-4">
			<div class="card-body p-4">
<pre class="line-numbers"><code class="language-php">
&lt;?php 
/**
 * test/controllers/test.php - Primary controller for test application.
 */
$App->data = array(
	'info'    => "You can put whatever information in this array that you want",
	'numbers' => array(4, 8, 15, 16, 23, 42),
	'is_user' => true,
	'records' => array(
		array(1, 'Test User', 'test@user.com'),
		array(2, 'Wife User', 'wife@user.com'),
		array(3, 'Son User', 'son@user.com'),
		array(4, 'Daugher User', 'daughter@user.com'),
	),
);
</code></pre>
			</div>
		</div>
		
		<h4 class="fw-bolder">See it in action</h4>
		<p class="lead">
			Take a look at this current page with the <code>json</code> query 
			parameter turned on: <a href="?json">/test/json/?json=true</a>
		</p>
	</div>
</div>

<div class="row mb-4">
	<div class="col-lg-6">
		<h3 class="fw-bolder">API Design</h3>
		<p class="lead mb-0">
			How you design your API is ultimate up to you. You can do whatever 
			you need in any way to meet the needs of your application use-cases.
			Just be aware that any time you use <code>$App->data</code>, you 
			are silently creating a Publicly-accessible API for any user 
			that has access to any given page.
		</p>
	</div>
	<div class="col-lg-6">
		<h3 class="fw-bolder">The Safe Template Data Alternative</h3>
		<p class="lead">
			If you want to send data from your controller to your templates 
			without worrying about exposing sensitive information to your users,
			the <code>$App->objects[]</code> array provides all the same options 
			as <code>$App->data[]</code> but without any magical array to JSON 
			conversion happening behind the scenes.
		</p>
		<div class="text-start">
			<a
				href="/test/objects"
				class="btn btn-outline-warning fw-bolder"
			>
				➡️Learn about $App->objects 
			</a>
		</div>
	</div>
</div>

