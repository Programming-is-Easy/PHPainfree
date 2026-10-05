<?php
global $App, $Painfree;

$found_template           = false;
$found_subtemplate        = false;
$app_template             = false;
$app_view_template        = "{$App->BASE_PATH}/apps/{$App->view}/views/{$App->view}.php";
$app_subview_template     = "{$App->BASE_PATH}/apps/{$App->view}/views/{$App->view}/{$App->id}.php";
$default_view_template    = "{$App->BASE_PATH}/templates/views/{$App->view}.php";
$default_subview_template = "{$App->BASE_PATH}/templates/views/{$App->view}/{$App->id}.php";

if ( file_exists($app_view_template) ) {
	$app_template   = true;
	$found_template = $app_view_template;
} else if ( file_exists($default_view_template) ) {
	$found_template = $default_view_template;
}

if ( file_exists($app_subview_template) ) {
	$app_template      = true;
	$found_subtemplate = $app_subview_template;
} else if ( file_exists($default_subview_template) ) {
	$found_subtemplate = $default_subview_template;
}

if ( $App->htmx && ! $App->htmx_boosted && ($found_template || $found_subtemplate) ) {
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
	if ( $found_subtemplate ) {
		include_once $found_subtemplate;
	} else {
		include_once $found_template;
	}
} else { 

	$view = $App->view;
	if ( $app_template ) {
		$view = "{$App->view}/views/{$App->view}";
		if ( $found_subtemplate ) {
			$view .= "/{$App->id}";
		} else {
			$view = "{$App->view}/views/{$App->view}";
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?= $Painfree->safe($App->title()); ?></title>

		<link rel="icon" type="image/x-icon" href="/images/favicon.ico" />

		<!-- bootstrap used in example page. Not required by PHPainfree -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
		<!-- Core theme CSS (includes Bootstrap)-->
		<link href="/css/styles.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
	
		<!-- htmx -->
		<script src="https://unpkg.com/htmx.org@2.0.0/dist/htmx.min.js"></script>

		<!-- github buttons -->
		<script async defer src="https://buttons.github.io/buttons.js"></script>

		<!-- Prism (syntax highlighting in <code> blocks) -->
		<link href="/css/prism.min.css" rel="stylesheet" />
		<script src="/js/prism.min.js"></script>

		<!-- Load our main application JS -->
		<script src="/js/phpainfree.js"></script>

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
		include $Painfree->load_view($view, '404');
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

