<title>$Painfree->logic() - Documentation | PHPainfree2</title>

<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">PHPainfree<code>2</code> 
		<code class="language-php">$Painfree->logic()</code>
	</h2>
	<p class="lead mb-0">
		<code class="language-php">$Painfree->logic() : void</code>
	</p>
</div>

<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>
			<code class="language-php">$Painfree->logic() : void</code>
		</h3>
		<p class="m-4">
			This function is called automatically by PHPainfree<code>2</code>
			and loads the defined ApplicationController.
		</p>
		<div class="ms-4 mt-4 mb-4 card bg-danger bg-opacity-25 border-danger">
			<div class="card-body">
				<h5 class="card-title">WARNING</h5>
				<p class="fs-6">
					This is an internal function to PHPainfree<code>2</code>
					and is not meant to be called by applications.
				</p>
			</div>
		</div>
		<div class="mt-4 mb-4 card bg-dark border-warning mb-4">
			<div class="card-header fs-4 font-monospace">$Painfree->logic()</div>
			<div class="card-body p-4">
<pre class="line-numbers" data-start="36"><code class="language-php">
include $Painfree->logic(); // load the application logic controller
</code></pre>
<pre class="line-numbers" data-start="52"><code class="language-php">
public function logic() : void {
	return $this->options['LogicFolder'] . 
		'/' . $this->options['ApplicationController'];
}
</code></pre>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header fs-4 font-monospace">$Painfree->logic()</div>
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
							<td scope="row">Configured</td>
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
<pre data-line="1,2" data-line-offset="-3"><code class="language-treeview">PHPainfree/
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

