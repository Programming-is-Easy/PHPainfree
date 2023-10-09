<?php
	$file_path = "{$App->BASE_PATH}/templates/views/docs/{$App->data['doc']}.php";
	if ( $App->htmx && ! $App->htmx_boosted && file_exists($file_path) ) {
	die('<pre>'.$file_path.'='.print_r($App,true).'</pre>');
		include_once "docs/{$App->data['doc']}.php";
		die();
	} else if ( $App->htmx && ! $App->htmx_boosted && ! file_exists($file_path) ) {
		include_once "docs/missing.php";
		die();
	}
?>
		<section class="bg-primary bg-opacity-10 py-2">
			<div class="container px-5">
				<div class="row gx-5 justify-content-center">
					<div class="col-lg-10">
						<div class="text-center my-5">
							<h1 class="display-5 fw-bolder text-white mb-2">PHPainfree<code>2</code> Docs</h1>
							<div class="d-grid gap-3 d-sm-flex justify-content-sm-center mt-4">
								<a
									class="github-button"
									href="https://github.com/Programming-Is-Easy/PHPainfree/fork"
									data-size="large"
									aria-label="Fork Programming-Is-Easy/PHPainfree on GitHub"
								>Fork PHPainfree</a>

								<a
									class="github-button"
									href="https://github.com/Programming-Is-Easy/PHPainfree"
									data-size="large"
									data-show-count="true"
									aria-label="Star Programming-Is-Easy/PHPainfree on GitHub"
								>Star</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
        <!-- Testimonials section-->
        <section class="bg-secondary bg-opacity-25 border-bottom border-secondary border-top" id="documentation">
            <div class="container-fluid">
                <div class="row justify-content-center">
					<div class="col-lg-2 bg-dark pt-1">
						<div class="bg-dark sticky-top p-2 overflow-auto pt-4" style="min-height:50vh; top:4.2em;">
							<h4>PHPainfree<code>2</code></h4>
							<ul class="fs-5" id="painfree_navigation_links" hx-on:click="htmx.findAll('li.nav-item.active').forEach(el => htmx.removeClass(el, 'active'));">
								<li class="nav-item <?= $App->data['doc'] === 'quickstart' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/quickstart"
										hx-get="/docs/quickstart"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									>Quickstart</a>
								</li>
								<li class="nav-item <?= $App->data['doc'] === 'structure' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/structure"
										hx-get="/docs/structure"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									>Structure</a>
								</li>
								<li class="nav-item <?= $App->data['doc'] === 'deploy' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/deploy"
										hx-get="/docs/deploy"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									>Deploying</a>
								</li>
							</ul>
							<h5>Components</h5>
							<ul class="fs-6" id="painfree_component_links" hx-on:click="htmx.findAll('li.nav-item.active').forEach(el => htmx.removeClass(el, 'active'));">
								<li class="nav-item <?= $App->data['doc'] === 'painfree-application-controller' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/painfree-application-controller"
										hx-get="/docs/painfree-application-controller"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									>ApplicationController</a>
								</li>
								<li class="nav-item <?= $App->data['doc'] === 'painfree-base-view' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/painfree-base-view"
										hx-get="/docs/painfree-base-view"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									>BaseView</a>
								</li>
							</ul>
							<h5>Methods</h5>
							<ul class="fs-6" id="painfree_method_links" hx-on:click="htmx.findAll('li.nav-item.active').forEach(el => htmx.removeClass(el, 'active'));">
								<li class="nav-item <?= $App->data['doc'] === 'painfree-safe' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/painfree-safe"
										hx-get="/docs/painfree-safe"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><span class="font-monospace">$Painfree->safe()</span></a>
								</li>
								<li class="nav-item <?= $App->data['doc'] === 'painfree-debug' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/painfree-debug"
										hx-get="/docs/painfree-debug"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><span class="font-monospace">$Painfree->debug()</span></a>
								</li>
								<li class="nav-item <?= $App->data['doc'] === 'painfree-load_view' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/painfree-load_view"
										hx-get="/docs/painfree-load_view"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><span class="font-monospace">$Painfree->load_view()</span></a>
								</li>
								<li class="nav-item <?= $App->data['doc'] === 'painfree-load_css' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/painfree-load_css"
										hx-get="/docs/painfree-load_css"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><span class="font-monospace">$Painfree->load_css()</span></a>
								</li>
								<li class="nav-item <?= $App->data['doc'] === 'painfree-load_js' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/painfree-load_js"
										hx-get="/docs/painfree-load_js"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><span class="font-monospace">$Painfree->load_js()</span></a>
								</li>
								<hr>
								<li class="nav-item <?= $App->data['doc'] === 'painfree-logic' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/painfree-logic"
										hx-get="/docs/painfree-logic"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><span class="font-monospace">$Painfree->logic()</span></a>
								</li>
								<li class="nav-item <?= $App->data['doc'] === 'painfree-view' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/painfree-view"
										hx-get="/docs/painfree-view"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><span class="font-monospace">$Painfree->view()</span></a>
								</li>
								<li class="nav-item <?= $App->data['doc'] === 'painfree-autoload' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/painfree-autoload"
										hx-get="/docs/painfree-autoload"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-swap-oob="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><span class="font-monospace">$Painfree->autoload()</span></a>
								</li>
							</ul>
							<!--
							<h4>htmx Support</h4>
							<ul class="fs-5" id="htmx_links" hx-on:click="htmx.findAll('li.nav-item.active').forEach(el => htmx.removeClass(el, 'active'));">
								<li class="nav-item <?= $App->data['doc'] === 'htmx' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/htmx"
										hx-get="/docs/htmx"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									>Overview</a>
								</li>
								<li class="nav-item <?= $App->data['doc'] === 'htmx-usage' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/docs/htmx-usage"
										hx-get="/docs/htmx-usage"
										hx-target="#doc_content"
										hx-push-url="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									>Usage</a>
								</li>
							</ul>
							-->
						</div>
					</div>
					<div class="col-lg-10 bg-dark pt-2 border-start border-secondary" id="doc_content">	
					<?php
						if ( file_exists($file_path) ) {
							include_once "docs/{$App->data['doc']}.php";
						} else {
							include_once "docs/missing.php";
						}
					?>
					</div> <!-- end of #doc_content -->

                </div>
            </div>
        </section>
