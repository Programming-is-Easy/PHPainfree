
<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">Using the <code>$App->data[]</code> Array in PHPainfree<code>2</code></h2>
	<p class="lead mb-0">
		A brief overview of <code>$App->data[]</code> and using it to communicate with templates and 
		the automatic JSON API.
	</p>
</div>

<div class="row mb-4">
	<div class="col-lg-6">
		<p class="lead mb-0">
			The <code>$App->data[]</code> array is a unique array freshly 
			created for every request. The intended use of this array 
			is to fill it with information from your controller so that this 
			data is available for your view templates.
		</p>
		<p>
			This array also has another secret weapon -- it's automatically 
			used as output for a JSON-powered API available at every page request.
		</p>
		<h2 class="fw-bolder">Security Warning!</h2>
		<p class="lead">
			<strong>ALL</strong> data in <code>$App->data[]</code> is exposed to any user 
			making a request to your application either by providing 
			<code>application/json</code> in the Request Headers <strong>Accept</strong> 
			field, or by passing the query parameter <code>?json</code> along with 
			the request.
		</p>
		<p class="lead">
			Because of this, you should never put any sensitive information in 
			<code>$App->data[]</code> that you do <strong>NOT want visible</strong> 
			to any user of your page.
		</p>
		<p>
			See 
			<a
				href="/test/json"
				hx-get="/test/json"
				hx-target="#example_content"
				hx-push-url="true"
				onclick="setTimeout(function() { set_active(getEl('json_menu_item')); Prism.highlightAll(); }, 1000);"
				hx-on::after-request="set_active(getEl('json_menu_item'));Prism.highlightAll();"
			>JSON API</a> 
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
	</div>
</div>

<div class="row mb-4">
	<div class="col-lg-6">
		<h2 class="fw-bolder">Template Usage</h2>
		<p class="lead mb-0">
			Using these data variables in your templates is extremely easy.
			Simply reference <code>$App->data[]</code> directly, or make 
			local variable copies of either the entire array, or of individual 
			array items.
		</p>
	</div>
	<div class="col-lg-6">
		<!-- Step 1 -->
		<div class="card bg-dark border-info mb-4">
			<div class="card-body p-4">
<pre class="line-numbers"><code class="language-php">
&lt;php 
/**
 * test/views/test.php - Primary template for test application.
 */
/** @var App $App */
$App = get_App();

$data = $App->data;
?&gt;
&lt;h2&gt;&lt;?= $data['title']; ?&gt;&lt;/h2&gt;
&lt;ul&gt;
	&lt;?php 
		if ( $data['records'] ) {
			foreach ( $data['records'] as $row ) {
	?&gt; 
	&lt;li&gt;&lt;em&gt;&lt?= $row[1]; ?&gt;&lt;/em&gt;&lt;/em&gt;
	&lt;?php 
			}
		} else {
	?&gt; 
	&lt;li&gt;&lt;em&gt;No records found...&lt;/em&gt;&lt;/em&gt;
	&lt;?php 
		}
	?&gt;
&lt;ul&gt;
</code></pre>
			</div>
		</div>
	</div>
</div>

