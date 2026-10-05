<?php
	$App = get_App();

	if ( ! $App->id ) {
		$App->id = 'main';
	}

	$sub_template_path = $App->app_path('test') . "/views/partials/{$App->id}.php";
	if ( ! file_exists($sub_template_path) ) {
		$sub_template_path = 'partials/main.php';
	}

	if ( $App->htmx && $App->id ) {
		include $sub_template_path;
	} else {
?>
		<section class="bg-primary bg-opacity-10 py-2">
			<div class="container px-5">
				<div class="row gx-5 justify-content-center">
					<div class="col-lg-10">
						<div class="text-center my-5">
							<h1 class="display-5 fw-bolder text-white mb-2">PHPainfree<code>2</code> App Routing Example</h1>
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
        <section class="bg-secondary bg-opacity-25 border-bottom border-secondary border-top" id="examples">
            <div class="container-fluid">
                <div class="row justify-content-center">
					<div class="col-lg-2 bg-dark pt-1">
						<div class="bg-dark sticky-top p-2 overflow-auto pt-4" style="top:4.2em;">
							<h4>PHPainfree<code>2</code></h4>
							<ul
								class="fs-5"
								id="painfree_navigation_links"
								hx-on:click="getSel('li.nav-item.active').forEach(el => el.classList.remove('active'));"
							>
								<li class="nav-item mb-3">
									<a class="nav-link d-inline-block"
										href="/examples/default"
									>Back to Examples</a>
								</li>
								<li
									id="main_menu_item"
									class="nav-item <?= $App->data['sub-pages']['main']['selected'] ? 'active' : ''; ?>"
								>
									<a class="nav-link d-inline-block"
										href="/test"
										hx-get="/test"
										hx-target="#example_content"
										hx-push-url="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><?= $App->data['sub-pages']['main']['label']; ?></a>
								</li>
								<li
									id="data_menu_item"
									class="nav-item <?= $App->data['sub-pages']['data']['selected'] ? 'active' : ''; ?>"
								>
									<a class="nav-link d-inline-block"
										href="/test/data"
										hx-get="/test/data"
										hx-target="#example_content"
										hx-push-url="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><?= $App->data['sub-pages']['data']['label']; ?></a>
								</li>
								<li
									id="json_menu_item"
									class="nav-item <?= $App->data['sub-pages']['json']['selected'] ? 'active' : ''; ?>"
								>
									<a class="nav-link d-inline-block"
										href="/test/json"
										hx-get="/test/json"
										hx-target="#example_content"
										hx-push-url="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><?= $App->data['sub-pages']['json']['label']; ?></a>
								</li>
								<li
									id="objects_menu_item"
									class="nav-item <?= $App->data['sub-pages']['objects']['selected'] ? 'active' : ''; ?>"
								>
									<a class="nav-link d-inline-block"
										href="/test/objects"
										hx-get="/test/objects"
										hx-target="#example_content"
										hx-push-url="true"
										hx-on::after-request="htmx.addClass(htmx.closest(this,'li'),'active');Prism.highlightAll();"
									><?= $App->data['sub-pages']['objects']['label']; ?></a>
								</li>
							</ul>
						</div>
					</div>
					<div
						class="col-lg-10 bg-dark pt-2 border-start border-secondary"
						id="example_content"
					>	
						<?php 
							include $sub_template_path;
						?> 
					</div> <!-- end of #doc_content -->

                </div>
            </div>
        </section>
<?php 
	}

