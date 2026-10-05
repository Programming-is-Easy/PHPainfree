
<div class="text-center mt-5 mb-5">
	<h2 class="fw-bolder">PHPainfree<code>2</code> App-based Routing</h2>
	<p class="lead mb-0">
		Using the new app-based routing system in PHPainfree<code>2</code>.
	</p>
</div>

<div class="row mb-4">
	<div class="col-lg-6">
		<p class="lead mb-0">
			PHPainfree<code>2</code> introduced a new routing mechanism called 
			<code>App-routing</code> that allows you to keep code for specific 
			routes together inside of folders. In the default routing system, 
			the following locations are automatically used for controller 
			and template loading:
		</p>
		<ul>
			<li>
				Controller:
				<code>{$App->BASE_PATH}/includes/Controllers/{$App->view}.php</code>
			</li>
			<li> 
				View Template:
				<code>{$App->BASE_PATH}/templates/views/{$App->view}.php</code>
			</li>
		</ul>
		<h2 class="fw-bolder">Limitations for Large Projects</h2>
		<p class="lead mb-0">
			On large projects, this quickly becomes unwieldy with hundreds 
			of files stored in both <code>includes/Controllers/</code> and 
			<code>templates/views/</code>. To solve this, we introduced 
			<code>App-based Routing</code>!
		</p>
	</div>
	<div class="col-lg-6">
		<!-- Step 1 -->
		<div class="card bg-dark border-info mb-4">
			<div class="card-body p-4">
<pre data-line="4,8"><code class="language-treeview">PHPainfree/
|-- includes/
|   |-- Controllers/
|   `-- test.php
`-- templates/
    |-- app.php
    |-- views/
	`-- test.php
</code></pre>
			</div>
		</div>
	</div>
</div>

<div class="row mb-4">
	<div class="col-lg-6">
		<h2 class="fw-bolder">App-based Routing</h2>
		<p class="lead mb-0">
			App-based Routing is a new routing concept that works in concert with 
			the default routing mechanism but allows you to keep all controllers, 
			functions, and view templates contained inside a unique directory.
		</p>
		<p>
			PHPainfree2 introduced a new top-level project folder called 
			<code>apps/</code>. When a request comes in to your server, 
			the <code>$App->route()</code> function will look inside <code>apps/</code>
			for a folder matching the <code>$App->view</code> taken from the 
			first path name of the Request URL.
		</p>
		<table class="table table-sm table-dark">
			<tbody>
				<tr>
					<th class="text-end">Request</th>
					<td><code>https://php.programming-is-easy.com/test/main</code></td>
				</tr>
				<tr>
					<th class="text-end">$App->view = </th>
					<td><code>"test"</code></td>
				</tr>
				<tr>
					<th class="text-end">App Folder</th>
					<td>
						<code>{$App->BASE_PATH}/apps/<b class="text-light">test</b>/</code>
					</td>
				</tr>
				<tr>
					<th class="text-end">Controllers</th>
					<td>
						<code>apps/<b class="text-light">test</b>/controllers/</code>
					</td>
				</tr>
				<tr>
					<th class="text-end">Main Controller</th>
					<td>
						<code>apps/<b class="text-light">test</b>/controllers/<b class="text-light">test</b>.php</code>
					</td>
				</tr>
				<tr>
					<th class="text-end">Templates</th>
					<td>
						<code>apps/<b class="text-light">test</b>/views/</code>
					</td>
				</tr>
				<tr>
					<th class="text-end">Main Template</th>
					<td>
						<code>apps/<b class="text-light">test</b>/views/<b class="text-light">test</b>.php</code>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-lg-6">
		<!-- Step 1 -->
		<div class="card bg-dark border-info mb-4">
			<div class="card-body p-4">
<pre data-line="2-8"><code class="language-treeview">PHPainfree/
|-- apps/
|   `-- test/
|     |-- controllers/
|     |   `-- test.php
|     `-- views/
|         `-- test.php
|-- includes/
|   `-- Controllers/
`-- templates/
    `-- views/
</code></pre>
			</div>
		</div>
	</div>
</div>

