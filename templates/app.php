<?php
if ( $App->htmx && ! $App->htmx_boosted && file_exists("{$App->BASE_PATH}/templates/views/{$App->view}.php") ) {
	// If we are an htmx request and the "view" variable exists in the top-level
	// templates folder, render that as an HTMX snippet.
	//
	// If we are an htmx request and there is a "sub-view" defined that lives
	// inside a folder, render _THAT_ instead of the full top-level snippet.
	//
	// In _this_ application, we're overriding $App->id to act as our default
	// "sub-view" route, but you should feel free to write whatever type of 
	// routing architecture that you want.
	//
	// This example requires that a top-level /templates/views/{$view}.php file 
	// exists **AND** a top-level /templates/views/{$view}/{$id}.php file to
	// exist for this magic to occur. 
	//
	// Each application built with PHPainfree should design their routing and
	// template relationships however best suits that product.
	if ( file_exists("{$App->BASE_PATH}/templates/views/{$App->view}/{$App->id}.php") ) {
		include_once "views/{$App->view}/{$App->id}.php";
	} else {
		include_once "views/{$App->view}.php";
	}
} else { 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?= $Painfree->safe($App->title()); ?></title>

		<meta name="viewport" contents="width=device-width, initial-scale=1">
		<meta name="description" content="PHPainfree2 is a fast and efficient PHP framework designed to make modern web development simple and painless.">

		<link rel="icon" type="image/x-icon" href="/images/favicon.ico" />

		<!-- bootstrap used in example page. Not required by PHPainfree -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
		<!-- Core theme CSS (includes Bootstrap)-->
		<link href="/css/styles.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
	
		<!-- htmx -->
		<script src="https://unpkg.com/htmx.org@1.9.5" async defer></script>

		<!-- github buttons -->
		<script async defer src="https://buttons.github.io/buttons.js"></script>

		<!-- Prism (syntax highlighting in <code> blocks) -->
		<link href="/css/prism.min.css" rel="stylesheet" />
		<script src="/js/prism.min.js" async defer></script>

		<!-- Dynamically load our css/js resources by "view" -->
		<!-- View-specific CSS -->
		<?= $Painfree->load_css($App->view); ?> 
		
		<!-- View-specific JS -->
		<?= $Painfree->load_js($App->view); ?> 

		<!-- Special PHPainfree demo development CSS -->
		<?= $Painfree->load_css('painfree_development'); ?> 
	</head>
	<body id="app-body" class="bg-dark text-light">

<?php
		include $Painfree->load_view('header');
		include $Painfree->load_view($App->view, '404');
		include $Painfree->load_view('footer');
?>

<?php
	// TODO: If you're going to use a debug template in a production environment,
	// you will want to do a permissions check here to only show it to people with
	// "developer" permissions in your product.
	if ( isset($_ENV['ENVIRONMENT']) && $_ENV['ENVIRONMENT'] === 'development' ) {
		include $Painfree->load_view('debug');
	}
?>
	</body>
</html>

<?php
} // end of normal render mode

