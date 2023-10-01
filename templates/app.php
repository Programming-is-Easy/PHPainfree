<?php
if ( $App->htmx && file_exists("{$App->BASE_PATH}/templates/views/{$App->view}.php") ) {
	include_once "views/{$App->view}.php";
} else { 
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
		<script src="https://unpkg.com/htmx.org@1.9.5"></script>

		<!-- github buttons -->
		<script async defer src="https://buttons.github.io/buttons.js"></script>

		<!-- Prism (syntax highlighting in <code> blocks) -->
		<link href="/css/prism.min.css" rel="stylesheet" />
		<script src="/js/prism.min.js"></script>

<?php
	// DYNAMICALLY LOADED CSS AND JAVASCRIPT (by $App->view)
	if ( file_exists("{$App->BASE_PATH}/htdocs/css/views/{$App->view}.css") ) {
?>
		<link rel="stylesheet" href="/css/views/<?= $App->view; ?>.css" />
<?php
	}

	if ( file_exists("{$App->BASE_PATH}/htdocs/js/views/{$App->view}.js") ) {
?>
		<script type="text/javascript" src="/js/views/<?= $App->view; ?>.js" defer></script>
<?php
	}
?>

		<link href="/css/debug.css" rel="stylesheet" />
	</head>
	<body id="app-body" class="bg-dark text-light">
<?php
		include 'header.php';	
?>

<?php
	if ( file_exists("{$App->BASE_PATH}/templates/views/{$App->view}.php") ) {
		include "views/{$App->view}.php";
	} else {
		include "views/404.php";
	}
?>


<?php
		include 'footer.php';	
?>

<?php
	// TODO: If you're going to use a debug template in a production environment,
	// you will want to do a permissions check here to only show it to people with
	// "developer" permissions in your product.
	if ( isset($_ENV['ENVIRONMENT']) && $_ENV['ENVIRONMENT'] === 'development' ) {
		include 'debug.php';
	}
?>
	</body>
</html>

<?php
} // end of normal render mode

