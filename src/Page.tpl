<!DOCTYPE html>
<html>
	<head>
		<title>{$page->getTitle()|escape}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<!--<link rel="icon" href="/favicon.png" type="image/png" />
		<link rel="shortcut icon" href="/favicon.png" type="image/png" />-->
		
		{foreach $page->getScripts() as $script}
			{$script}
		{/foreach}
		
		{foreach $page->getStyleSheets() as $style}
			{$style}
		{/foreach}
		
		<!-- Bootstrap -->
		<!--<link href="/vendor/bootstrap-3.1.1/css/bootstrap.min.css" rel="stylesheet" />-->

		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!--<script src="/vendor/bootstrap-3.1.1/js/bootstrap.min.js"></script>-->
		
		<!-- Javascript template enginge  -->
		<!--<script src="/vendor/js/handlebars-v1.3.0.js"></script>-->
		
		<!-- Input field suggestion engine  -->
		<!--<script src="/vendor/js/typeahead-v0.10.1.bundle.min.js"></script>
		<link href="/vendor/css/typeahead.css" rel="stylesheet" />-->
		
		<!-- URL helper class -->
		<!--<script src="/vendor/js/uri-v1.12.0.bundle.min.js"></script>-->
		
		<!-- nexxes stuff -->
		<!--<script src="/nexxes.js?t={time()}"></script>-->
		
		<script>
			{literal}
			/* Enable tooltips */
			$(document).ready(function() {
				//$('.tooltip-show').tooltip();
			});
			{/literal}
		</script>
		
		<style type="text/css">
			/* Space for fixed top navbar */
			body { padding-top: 70px; }
		</style>
		
		<!--<link href="/style.css" rel="stylesheet" />-->
	</head>
	<body id="{$id}">
		{foreach $page->widgets() as $widget}
			{$widget->renderHTML()}
		{/foreach}
		
		<!--
		<div class="modal fade" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h3>Bitte warten...</h3>
					</div>
					<div class="modal-body">
						<div class="progress progress-striped active">
							<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="45" style="width: 1%;">
								<span class="sr-only">60% Complete</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	-->
	</body>
</html>
