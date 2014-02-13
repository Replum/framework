<!DOCTYPE html>
<html>
	<head>
		<title>{$page->title|escape}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- Bootstrap -->
		<link href="/bootstrap-3.0.3/css/bootstrap.min.css" rel="stylesheet" />

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="/vendor/js/jquery-1.10.2.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/bootstrap-3.0.3/js/bootstrap.min.js"></script>
		
		<!-- Javascript template enginge  -->
		<script src="/vendor/js/handlebars-v1.3.0.js"></script>
		
		<!-- Input field suggestion engine  -->
		<script src="/vendor/js/typeahead-v0.10.1.bundle.min.js"></script>
		<link href="/vendor/css/typeahead.css" rel="stylesheet" />
		
		<!-- URL helper class -->
		<script src="/vendor/js/uri-v1.12.0.bundle.min.js"></script>
		
		<!-- nexxes stuff -->
		<script src="/nexxes.js"></script>
		
		<script>
			{literal}
			/* Enable tooltips */
			$(document).ready(function() {
				$('.tooltip-show').tooltip();
			});
			{/literal}
		</script>
		
		<style type="text/css">
			/* Space for fixed top navbar */
			body { padding-top: 70px; }
		</style>
	</head>
	<body id="{$id}">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Krit Happenz!</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="/zeiten/">Zeitplan</a></li>
					<li><a href="#">Link</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
							<li class="divider"></li>
							<li><a href="#">One more separated link</a></li>
						</ul>
					</li>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
				{if isset($user)}
						<li><p class="navbar-text">Hallo, {$user->name}</p></li>
						<li><a href="/logout.php" class="tooltip-show" data-toggle="tooltip" data-placement="left" title="Abmelden" ><span class="glyphicon glyphicon-log-out"></span></a></li>
				{else}
						<li><a href="/register.php">Registrieren</a></li>
						<li><a href="/members/">Anmelden</a></li>
				{/if}
					</ul>
				
				{if isset($user)}
					{if count($user->accounts)}
						<form class="navbar-form navbar-right" action="addCharacter" role="form" method="post">
							<div class="form-group">
								<div class="input-group">
									<input type="text" class="form-control" name="character" placeholder="Charactername" size="15"/>
									<span class="input-group-addon">@</span>
									<span class="input-group-btn">
										<select name="account" class="form-control">
											{foreach $user->accounts AS $account}
												<option value="{$account->name}">{$account->name}</option>
											{/foreach}
										</select>
									</span>
									<span class="input-group-btn">
										<button type="submit" class="btn btn-default tooltip-show" data-toggle="tooltip" data-placement="bottom" title="Character hinzufügen">
											<span class="glyphicon glyphicon-user"></span>
										</button>
									</span>
								</div>
							</div>
						</form>
					{/if}
				
				<form class="navbar-form navbar-right" action="addAccount" role="form" method="post">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">@</span>
							<input type="text" class="form-control" name="account" placeholder="Accountname" size="15"/>
							<span class="input-group-btn input-group-btn-fix">
								<button type="submit" class="btn btn-default tooltip-show" data-toggle="tooltip" data-placement="bottom" title="Account freischalten">
									<span class="glyphicon glyphicon-tower"></span>
								</button>
							</span>
						</div>
					</div>
				</form>
				{/if}
			</div>
		</nav>
		
		<div class="container">
			<div class="row">
				{$page->renderChildrenHTML()}
			</div>
		</div>
		
		<script>
		{literal}
			var charRepo = new Bloodhound({
				datumTokenizer: function(d) { return d.tokens; },
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				prefetch: {
					url: '/members/json/members.php',
					ttl: 1,
					thumbprint: 'foobar'
				}
			});

			charRepo.initialize();

			$('.guild-char-input').typeahead(null, {
				name: 'members',
				source: charRepo.ttAdapter(),
				autoselect: true,
				highlight: true,
				templates: {
					suggestion: Handlebars.compile([
						'<div><img src="{{icon}}" /> <strong>{{value}}</strong> {{#if owner}}(von: {{owner}}){{/if}}</div>',
					].join(''))
				}
			});
		{/literal}
		</script>
	</body>
</html>
