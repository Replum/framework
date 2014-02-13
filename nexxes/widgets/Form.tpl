<fieldset class="col-lg-12">
	<legend>{$widget->title}</legend>
	<form method="POST" action="{$request->link()}" role="form" class="form-horizontal">
	{$widget->renderChildrenHTML()}
	</form>
</fieldset>