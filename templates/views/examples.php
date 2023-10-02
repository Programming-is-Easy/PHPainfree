<?php
	$file_path = "{$App->BASE_PATH}/templates/views/examples/{$App->data['example']}.php";
	if ( $App->htmx && ! $App->htmx_boosted && file_exists($file_path) ) {
		include_once "examples/{$App->data['doc']}.php";
		die();
	} else if ( $App->htmx && ! $App->htmx_boosted && ! file_exists($file_path) ) {
		include_once "examples/missing.php";
		die();
	}
?>
		<section class="bg-primary bg-opacity-10 py-2">
			<div class="container px-5">
				<div class="row gx-5 justify-content-center">
					<div class="col-lg-10">
						<div class="text-center my-5">
							<h1 class="display-5 fw-bolder text-white mb-2">PHPainfree<code>2</code> Examples</h1>
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
        <section class="bg-secondary bg-opacity-25 border-bottom border-success" id="examples">
            <div class="container-fluid">
                <div class="row justify-content-center border-top">
					<div class="col-lg-2 bg-dark">
						<div class="bg-dark sticky-top p-2 overflow-auto pt-4" style="height:90vh; top:4.2em;">
							<h4>PHPainfree<code>2</code></h4>
							<ul class="fs-5" id="painfree_navigation_links" hx-on:click="htmx.findAll('li.nav-item.active').forEach(el => htmx.removeClass(el, 'active'));">
								<li class="nav-item <?= $App->data['example'] === 'default' ? 'active' : ''; ?>">
									<a class="nav-link d-inline-block"
										href="/examples/default"
										hx-get="/examples/default"
										hx-target="#example_content"
										hx-push-url="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									>Overview</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-10 bg-dark pt-2 border-start" id="example_content">	
					<?php
						if ( file_exists($file_path) ) {
							include_once "examples/{$App->data['example']}.php";
						} else {
							include_once "examples/missing.php";
						}
					?>
					</div> <!-- end of #doc_content -->

                </div>
            </div>
        </section>
