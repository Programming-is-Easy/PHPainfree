
<div class="row">
	<div class="col-lg-5">
		Using htmx!
	</div>
	<div class="col-lg-7">
		<!-- Step 1 -->
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header bg-primary bg-opacity-10">
				<h4 class="my-2">1. Grab the Source Code</h4>
			</div>
			<div class="card-body p-4">
				<pre
					class="command-line"
					data-prompt="$"
					data-continuation-str="\"
				><code class="language-bash">git clone --depth=1 git@github.com:Programming-is-Easy/PHPainfree.git \
cd PHPainfree && rm -rf .git && cp development.env .env</code></pre>
				<p class="lead">
					Grab the current source code from Github, delete the <code>.git/</code> folder,
					and copy the <code>development.env</code> file into <code>.env</code>.
				</p>
				<p>
					The <code>.env</code> file will contain sensitive passwords and other essential private items (API keys, etc)
					and should <strong>never</strong> be checked into version control. A minimalistic version is included
					with the PHPainfree source code to allow you to connect to the Docker database configured in the 
					local development environment.
				</p>
			</div>
		</div>
		<!-- Step 2 -->
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header bg-primary bg-opacity-10">
				<h4 class="my-2">2. Turn on the Docker Server</h4>
			</div>
			<div class="card-body p-4">
				<pre
					class="command-line"
					data-prompt="$"
					data-continuation-str="\"
				><code class="language-bash">sudo docker compose up</code></pre>
				<p class="lead">
					PHPainfree V2 comes with a Docker setup for speedy development. By default, the <code>docker-compose.yml</code>
					configuration will start up three containers:
				</p>
				<ul>
					<li><code>phpainfree_dev</code> - Apache+PHP container running your application.</li>
					<li><code>phpainfree_db</code> - MySQL container with a persistent storage volume.</li>
					<li><code>phpainfree_phpmyadmin</code> - PHPMyAdmin web application connected to <code>phpainfree_db</code>.</li>
				</ul>
			</div>
		</div>
		<!-- Step 3 -->
		<div class="card bg-dark border-warning mb-4">
			<div class="card-header bg-primary bg-opacity-10">
				<h4 class="my-2">3. Code!</h4>
			</div>
			<div class="card-body p-4">
				<p class="lead">
					It's really as easy as that! You should have a webserver running the source
					code in this folder located at <a href="http://localhost:8888">http://localhost:8888/</a>
					and you should see a complete clone of this website.
				</p>
				<p>
					From here you can use this website as a starting point for simple web development
					projects, or you can wipe out almost everything and start your new project from scratch.
					PHPainfree has never been an "opinionated" framework, and really just provides
					some lightweight routing automation and some tools for persistent database connections.
				</p>
			</div>
		</div>
	</div>
</div>
