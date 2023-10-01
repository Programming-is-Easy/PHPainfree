
		<?php include 'partials/hero.php'; ?>

		<!-- Features section-->
        <section class="py-2 border-bottom border-primary" id="features">
            <div class="container px-2 my-5">
                <div class="row gx-5">
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-emoji-heart-eyes"></i></div>
                        <h2 class="h4 fw-bolder">No Complicated Methods</h2>
                        <p>
							You already know PHP, so why learn an entirely new way of coding
							just to use some silly framework that will go out of fashion
							in a few years?
						</p>
						<p>
							Simple PHP and a tiny library footprint stay
							out of your way and let you focus on the part of your web app
							that you need to work on--<strong>your features!</strong>
						</p>
                    </div>
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-speedometer"></i></div>
                        <h2 class="h4 fw-bolder">Ultra Fast</h2>
                        <p>
							It's not 2004 anymore. PHP is actually fast as heck, and you can use it
							to create websites capable of serving millions and millions of requests per hour.
							However, as soon as you bring a giant web framework into the mix, you're adding
							all of the overhead of that framework into the mix and slowing down your ability
							to serve content. 
						</p>
						<p>
							<strong>PHPainfree is intentionally small</strong>. You are a <code>programmer</code>, so
							program in just what you need. Don't get stuck with a bunch of stuff that someone
							else has decided that you <strong><em>might</em></strong> need.
						</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-filetype-json"></i></div>
                        <h2 class="h4 fw-bolder">Fast JSON APIs and <code>htmx</code> Support</h2>
                        <p>
							Each controller is capable of ending execution before rendering a full HTML template.
							This allows you to use your controllers as a RESTful endpoint for a lightning-fast
							JSON API or to leverage the front-end framework <a href="https://htmx.org">htmx</a> to 
							send back HTML partials for highly interactive dynamic front-ends.
						</p>
                        <a class="text-decoration-none" href="#!">
							Read the Docs
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonials section-->
        <section class="bg-secondary bg-opacity-25 py-2 border-bottom border-success" id="quickstart">
            <div class="container px-2 my-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder">Quickstart Guide</h2>
                    <p class="lead mb-0">Start building something cool in just a few minutes.</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-10">
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
								><code class="language-bash">git clone --depth=1 git@github.com:februaryfalling/PHPainfree.git \
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
									PHPainfree V2 comes with a Docket setup for speedy development. By default, the <code>docker-compose.yml</code>
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
            </div>
        </section>
