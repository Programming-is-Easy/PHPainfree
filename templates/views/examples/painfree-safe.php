
<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">
		PHPainfree<code>2</code> 
		<code class="language-php">$Painfree->safe()</code>
	</h2>
	<p class="lead mb-0">
		<code class="language-php">$Painfree->safe(string $unsafe) : string</code>
	</p>
</div>

<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>
			<code class="language-php">$Painfree->safe(string $unsafe) : string</code>
		</h3>
		<p class="m-4">
			This function is designed to provide a starting point for user-input
			web safety. It's primary purpose is to provide an HTML escaping
			mechanism for any user-submitted code that you want to render inside
			of a template.
		</p>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
<pre><code class="language-php">
public function safe($unsafe='') : string {
	// null arguments to htmlspecialchars() is deprecated
	if ( ! $unsafe ) {
		return '';
	}
	return htmlspecialchars($unsafe);
}
</code></pre>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4 mt-5">
	<div class="col-lg-6">
		<h4 class="">
			Usage
		</h4>
		<p class="m-4">
			Use this function (or something like it) anywhere you're going to be
			showing user-provided input in your HTML templates. This function
			is the bare minimum you'd need to prevent XSS attacks.
		</p>
		<div class="ms-4 card bg-danger bg-opacity-25 border-danger">
			<div class="card-body">
				<h5 class="card-title">WARNING</h5>
				<p class="fs-6">
					This function is just a starting point for safely handling
					user input. It's merely a thin wrapper around 
					<code class="language-php">htmlspecialchars()</code>. You
					should consider your application's security requirements
					on a case-by-case basis and write code accordingly.
				</p>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">Example View</div>
			<div class="card-body p-4">
<?php
	$user_input = 'Title<script>alert("hello");</script>';
?>
<pre class="line-numbers" data-start="66"><code class="language-php">
	&lt;?php
		$user_input = '<?= $Painfree->safe($user_input); ?>';
	?&gt;
	&lt;div id="post-title" class="bg-dark text-light"&gt;
		&lt;?= $user_input_title; ?&gt; &lt;!-- alerts --&gt;
	&lt;/div&gt;
	
	&lt;div id="post-title-escaped" class="bg-dark text-light"&gt;
		&lt;?= $Painfree->safe($user_input); ?&gt; &lt;!-- doesn't alert --&gt;
	&lt;/div&gt;
</code></pre>

				<h5 class="card-title">Template Output</h5>
<pre class="line-numbers" data-start="66"><code class="language-html">
	&lt;div id="post-title" class="bg-dark text-light"&gt;
		<?= $Painfree->safe($user_input); ?> &lt;!-- alerts --&gt;
	&lt;/div&gt;
	
	&lt;div id="post-title-escaped" class="bg-dark text-light"&gt;
		<?= $Painfree->safe($Painfree->safe($user_input)); ?> &lt;!-- doesn't alert --&gt;
	&lt;/div&gt;
</code></pre>
			</div>
		</div>
	</div>
</div>

