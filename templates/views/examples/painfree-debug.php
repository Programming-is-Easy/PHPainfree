
<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">
		PHPainfree<code>2</code> 
		<code class="language-php">$Painfree->debug()</code>
	</h2>
	<p class="lead mb-0">
		<code class="language-php">$Painfree->debug(string $key, mixed $var, bool $abort) : void</code>
	</p>
</div>

<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>
			<code class="language-php">$Painfree->debug()</code>
		</h3>
		<p class="m-4">
			This function is a useful helper function to store various objects
			and variables into an array for later viewing. This function is
			often combined with a template like <code>templates/debug.php</code>
			to view all of the variables, objects, and arrays that have been 
			added to <code>$Painfree</code> via the <code>debug()</code> method.
		</p>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-body p-4">
<pre><code class="language-php">
public function debug($heading,$obj,$abort=false) : void {
	if ( $abort ) {
		die('&lt;pre&gt;' . $heading . ' = ' . print_r($obj,true) . '&lt;/pre&gt;');
	}
	$this->__debug[$heading] = print_r($obj,true);
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
			Use this function whenever you want to inspect a variable later
			in the execution of your application. Or pass in the <code class="language-php">$abort</code>
			argument to immediately halt execution and display the variable information
			passed to this function.
		</p>
		<p>
			By default, any information passed to <code class="language-php">$Painfree-&gt;debug();</code>
			is not displayed anywhere. In most applications, a common pattern is
			to create a debugging template and only render that template if the 
			user that is viewing the application has administrator or development 
			permissions for your application.
		</p>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header">Example View</div>
			<div class="card-body p-4">
				<?php
$debug_implementation = '
<?php
	$debug_cnt = 0;
	foreach ( $Painfree->__debug as $heading => $obj_dump ) {
		$debug_cnt = $debug_cnt + 1;
?>
	<div class="card bg-dark border-warning mb-4">
		<div class="card-header bg-danger bg-opacity-10">
			<h4 class="my-2"><?= $debug_cnt; ?>. <?= $heading; ?></h4>
		</div>
		<div class="card-body p-4">
			<pre><code class="language-php"
				><?= $heading; ?> = <?= $obj_dump; ?></code></pre>
		</div>
	</div>
<?php
	}
?>
';
				?>
<pre class="line-numbers" data-start="66"><code class="language-php">
<?= $Painfree->safe($debug_implementation); ?>
</code></pre>

			</div>
		</div>
	</div>
</div>

