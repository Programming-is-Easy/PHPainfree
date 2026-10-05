
<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">Using the <code>$App->objects[]</code> Array in PHPainfree<code>2</code></h2>
	<p class="lead mb-0">
		<code>$App->objects[]</code> is the hard-working, private sibling of <code>$App->data[]</code>. It knows
		how to keep a secret.
	</p>
</div>

<div class="row mb-4">
	<div class="col-lg-6">
		<!-- Step 1 -->
		<div class="card bg-dark border-info mb-4">
			<div class="card-body p-4">
<pre class="line-numbers" data-line="11-17"><code class="language-php">
&lt;?php 
/**
 * test/controllers/test.php - Primary controller for test application.
 */
// All visible via the JSON API
$App->data = array(
	'info'    => "You can put whatever information in this array that you want",
	/* snipped for brevity */
);

// Example of $App->objects[]. This is another place to store data 
// you want to expose to your view templates, but this variable is NOT 
// exposed automatically in a JSON/API request 
$App->objects['private-data'] = "Don't leak this in JSON";
$App->objects['user_id']  = 1;
$App->objects['username'] = "Eric Harrison";
$App->objects['password'] = "look@MySecr3tPASSword24!";
</code></pre>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<p class="lead">
			The <code>$App->objects[]</code> array is also a fresh new array created 
			with every request. The big difference between <code>$App->objects[]</code> 
			and <code>$App->data[]</code> is that <code>$App->objects[]</code> 
			is <strong><u>NEVER</u></strong> used for any magical purpose behind 
			the scenes in either <code>Painfree.php</code> or <code>App.php</code>.
		</p>
		<p>
			You can put any data inside the <code>objects[]</code> property to use 
			in your view templates, and unless you intentionally expose those values 
			inside your template manually, it will never be visible to any user 
			and will be discarded at the end of every request.
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
				href="/test/json"
				hx-get="/test/json"
				hx-target="#example_content"
				hx-push-url="true"
				onclick="setTimeout(function() { set_active(getEl('json_menu_item')); Prism.highlightAll(); }, 1000);"
				hx-on::after-request="set_active(getEl('json_menu_item'));Prism.highlightAll();"
			>JSON API</a> 
			for more details.
		</p>
	</div>
</div>

<div class="row mb-4">
	<div class="col-lg-6">
		<h2 class="fw-bolder"><code>$App->objects[]</code> Template Usage</h2>
		<p class="lead mb-0">
			Use <code>$App->objects[]</code> in your controllers and templates 
			the exact same way you would use <code>$App->data[]</code>. Any 
			values you store in the <code>object[]</code> property can be retrieved 
			using whatever key you specified at assignment time.
		</p>
	</div>
	<div class="col-lg-6">
		<!-- Step 1 -->
		<div class="card bg-dark border-info mb-4">
			<div class="card-body p-4">
<pre data-line="6-8" class="line-numbers"><code class="language-php">
&lt;?php 
/** test/views/test.php - Primary template for test application. */
/** @var App $App */
$App = get_App();

$user_id  = $App->objects['user_id'];
$username = $App->objects['username'];
$is_admin = $App->objects['is_admin'] ?? false;
?&gt;
&lt;h2&gt;&lt;?= $username; ?&gt;'s Page&lt;/h2&gt;
&lt;?php 
	if ( $is_admin ) {
?&gt; 
&lt;a href="/user/&lt;?= $user_id; &gt;/edit">Edit User&lt;/a&gt;
&lt;?php 
	}
?&gt; 
&lt;h2&gt;
</code></pre>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4">
	<div class="col-lg-7">
		<!-- Step 1 -->
		<h6>In the controller</h6>
		<div class="card bg-dark border-info mb-4">
			<div class="card-body p-4">
<pre data-line="6-8" class="line-numbers"><code class="language-php">
&lt;?php 
/** test/controllers/test.php - Primary controller for test application. */
$App = get_App();

require_once $App->BASE_PATH . '/includes/vendor/Parsedown/Parsedown.php';
$pd = new Parsedown();
$pd->setSafeMode(true);
$App->objects['Parsedown'] = $pd;
</code></pre>
			</div>
		</div>
	</div>
	<div class="col-lg-5">
		<h2 class="fw-bolder">Passing Large Objects</h2>
		<p class="lead">
			This property was initially created as a means to create a single 
			large object in a controller and make that object available inside 
			the template without resorting to either polluting the global namespace 
			or by forcing the template to recreate commonly-used objects from 
			libraries and packages.
		</p>
	</div>
</div>

<div class="row">
	<div class="col-lg-7">
		<h6>In the view template</h6>
		<div class="card bg-dark border-info mb-4">
			<div class="card-body p-4">
<pre data-line="5,7" class="line-numbers"><code class="language-php">
&lt;?php 
/** test/views/test.php - Primary template for test application. */
$App = get_App();

$pd = $App->objects['Parsedown'];
?&gt;
&lt;div class="parsedown"&gt;&lt;?= $pd->text($App->data['info']); ?&gt;&lt;/div&gt;
</code></pre>
			</div>
		</div>
	</div>
	<div class="col-lg-5">
		<h2 class="fw-bolder">Using the objects in our templates</h2>
		<p class="lead">
			In this example, we create an instance of the 
			<a href="https://parsedown.org/" target="_blank">Parsedown Markdown library</a> 
			in the controller and store that in <code>$App->objects['Parsedown']</code>.
			Inside our template, we grab a reference to that object and use it 
			to generate HTML from a potential markdown-formatted string in 
			<code>$App->data['info']</code>.
		</p>
	</div>
</div>

