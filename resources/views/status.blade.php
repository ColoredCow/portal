@if (sizeof($errors))
	<div class="alert alert-danger" role="alert">
		<p><strong>There were some errors. Please resolve them and try again.</strong></p>
	    <ul>
	    @foreach ($errors as $message)
	        <li>{{ $message }}</li>
	    @endforeach
	    </ul>
	</div>
@elseif (session('status'))
	<div class="alert alert-success" role="alert">
		<p>{!! session('status') !!}</p>
		<span class="status-close"><b>&times;</b></span>
	</div>
@endif
