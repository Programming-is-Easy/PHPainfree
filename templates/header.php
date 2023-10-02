
		<!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top border-primary border-bottom" style="z-index:5000;">
            <div class="container px-5">
                <a class="navbar-brand" href="/">PHPainfree<code style="color:var(--bs-code-color);">2</code></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
							<a class="nav-link <?= $App->view === 'main' ? 'active' : ''; ?>" href="/">Home</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link <?= $App->view === 'docs' ? 'active' : ''; ?>" href="/docs">Documentation</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link <?= $App->view === 'examples' ? 'active' : ''; ?>" href="/examples">Examples</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link" href="https://github.com/Programming-is-Easy/PHPainfree/issues">Issue Tracker</a>
						</li>
                    </ul>
                </div>
            </div>
        </nav>
