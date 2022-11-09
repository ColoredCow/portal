<div>
	<style>
		.line {
			line-height: 1px;
		}
	</style>
	<p>Dear, {{ $name }}</p>
	<p>Thanks for using our services! We hope you’re like that all books :)</p>
	<p>We’d like to ask for a favor – could you share your experience with this book? </p>
	<p>It will take you about 4 minutes to complete our survey, but it’ll be invaluable to us for improving our services.</p>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Book's Name</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>

					@if(is_array($key1))
					@foreach ($key1 as $key)
					<li>{{$key}}</li>
					@endforeach
					@else
					{{$key1}}
					@endif
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<p>To view all Books, you can use this link <a href="{{ route('books.index', ['status' => 'active'])  }}">Books</a>.</p>
	<br>
	<p class="line">Thank You,</p>
	<p class="line">ColoredCow Portal</p>
</div>