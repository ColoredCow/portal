@if (session('status'))
	<div class="alert alert-success" role="alert">
		<p>{!! session('status') !!}</p>
		<span class="status-close"><b>&times;</b></span>
	</div>
@endif
