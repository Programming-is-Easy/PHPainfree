
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
                        <a class="text-decoration-none" href="/docs/structure">
							Read the Docs
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

		<?php include 'docs/quickstart.php'; ?>
