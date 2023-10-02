<?php
	// This is a lightweight Debugging template. It basically just demonstrates
	// how to use the debugging mechanisms provided by $Painfree.

	// In most cases, you would really only want to have your primary
	// template load a debugging template like this during development
	// or for your development account. Use your own judgement.

	// this is an example just for fun. You can call $Painfree->debug()
	// wherever you want in your application and it would theoretically
	// be displayed in this template.
	$Painfree->debug('App', $App);
	$Painfree->debug('Painfree', $Painfree);
	$Painfree->debug('DebugExamples', 'Please be aware that there are several $Painfree->debug() calls made in templates/debug.php to be used as examples. You should probably remove them.');
	$TestArray = array('this_is' => 'a simple dummy array.', 'example' => array(1,2,3));
	$Painfree->debug('$TestArray', $TestArray);

	$Painfree->debug('$PainfreeConfig', $PainfreeConfig);

	$Painfree->debug('EXAMPLE', 'You can basically pass anything to $Painfree->debug().');
?>
<section class="bg-primary bg-opacity-10 py-2 border-top border-primary" id="phpainfree_debug">
	<div class="container-fluid px-5 my-2">
		<div class="mb-2">
			<h2 class="fw-bolder">
				PHPainfree Debugging Console
				<code id="painfree_exec_time" class="px-4 text-secondary">[exec: <span class="text-success"><?= sprintf('%0.4f', (microtime(true) - $__painfree_start_time)) . 's'; ?></span>]</code>
			</h2>
		</div>
		<div class="row gx-5 justify-content-center">
			<div class="col-lg-12">
<?php
	$debug_cnt = 0;
	foreach ( $Painfree->__debug as $heading => $obj_dump ) {
		$debug_cnt = $debug_cnt + 1;
?>
				<div class="card bg-dark border-warning mb-4">
					<div class="card-header bg-danger bg-opacity-10">
						<h4 class="my-2"><?= $debug_cnt; ?>. <?= $heading; ?></h4>
					</div>
					<div class="card-body p-4">
						<pre><code class="language-php"><?= $heading; ?> = <?= $obj_dump; ?></code></pre>
					</div>
				</div>
<?php
	}
?>
			</div>
		</div>
	</div>
</section>
