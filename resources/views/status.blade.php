@if (sizeof($errors))
	<div class="alert alert-danger" role="alert">
		<p><strong>There were some errors. Please resolve them and try again.</strong></p>
	    <ul>
			@foreach ($errors as $message)
				<li>{{ $message }}</li>
			@endforeach
	    </ul>
	</div>
	<br>
@endif
