<div>
	<style>
		.line {
			line-height: 1px;
		}
	</style>
	<p>Dear, {{ $name }}</p>
	<p>Thanks for using our services! We hope you’re like that all books :)</p>
	<p>We’d like to ask for a favor – could you share your experience with this book? </p>
	<p>It will take you about a few minutes to complete our survey, but it’ll be valuable to us for improving our book feature.</p>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Book's Name</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					@foreach ($allbook as $keys)
					@foreach ($keys as $books)
					<li>{{$books}}</li>
					@endforeach
					@endforeach
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