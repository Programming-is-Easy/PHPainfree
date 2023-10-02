
<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">PHPainfree<code>2</code> 
		<code class="language-php">$Painfree->autoload()</code>
	</h2>
	<p class="lead mb-0">
		<code class="language-php">$Painfree->autoload() : void</code>
	</p>
</div>

<div class="row mb-4 mt-4">
	<div class="col-lg-6">
		<h3>
			<code class="language-php">$Painfree->autoload() : void</code>
		</h3>
		<p class="m-4">
			This function is called automatically by PHPainfree<code>2</code>
			and loads the defined BaseView.
		</p>
		<div class="ms-4 mt-4 mb-4 card bg-info bg-opacity-25 border-info">
			<div class="card-body">
				<h5 class="card-title">Design Theory</h5>
				<p class="fs-6">
					The reason that this program is executed outside of the
					PHPainfree class is so that all imported scripts loaded
					by the autoloader will be executed in the global PHP scope.
				</p>
			</div>
		</div>
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
			<div class="card-header fs-4 font-monospace">$Painfree->autoload()</div>
			<div class="card-body p-4">
<pre class="line-numbers" data-start="30"><code class="language-php">
// process Autoload folder
$loaders = $Painfree->autoload();
foreach ( $loaders as $load ) {
	include $load;
}
</code></pre>
<pre class="line-numbers" data-start="80"><code class="language-php">
public function autoload() {
	// process Autoload folder
	$auto_load_path = $this->Root . $this->options['LogicFolder'] . '/Autoload/*.php';
	$loaders = glob($auto_load_path);
	if ( is_array($loaders) && count($loaders) ) {
		foreach ( $loaders as $autoload ) {
			list($junk,$file_name) = explode('Autoload/', $autoload);
			$this->Autoload[$file_name] = $autoload;
		}
	}

	return $this->Autoload;
}
</code></pre>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header fs-4 font-monospace">$Painfree->autoload()</div>
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
							<td scope="row">Loaded</td>
							<td><span class="font-monospace">includes/Autoload/</span></td>
							<td><span class="font-monospace">*.php</span></td>
						</tr>
						<tr>
							<td scope="row">Called</td>
							<td><span class="font-monospace">Painfree.php</span></td>
							<td><code class="language-php">$Painfree->autoload();</code></td>
						</tr>
					</tbody>
				</table>
<pre data-line="1" data-line-offset="-4"><code class="language-treeview">PHPainfree/
|-- htdocs/
|-- includes/
|   |-- PainfreeConfig.php
|   |-- Painfree.php
|   |-- App.php
|   `-- Controllers/
`-- templates/
    |-- app.php
	`-- autoloads/
	    `-- main.php
</code></pre>
			</div>
		</div>
	</div>
</div>

