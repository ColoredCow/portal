<ul class="nav nav-pills">
    @php
     $request['all books'] = 'books';
    @endphp
        <a class="nav-item nav-link {{ $active === 'books' && request()->input('wishlist','active') !== 'booksInWishlist' ? 'active' : '' }}"  href="{{ route('books.index', $request) }}"><i class="fa fa-book"></i>&nbsp;Books</a>
    </li>

    @can('library_book_category.view')
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'book_category' ? 'active' : '' }}" href="{{ route('books.category.index') }}"><i class="fa fa-book"></i>&nbsp;Books Category</a>
    </li>
    @endcan

    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'book_a_month' ? 'active' : '' }}" href="{{ route('book.book-a-month.index') }}"><i class="fa fa-book"></i>&nbsp;A Book A Month</a>
    </li>
    <li class="nav-item">
        @php
         $request['wishlist'] = 'booksInWishlist';
        @endphp
        <a class="nav-item nav-link {{ (request()->input('wishlist','active') === 'booksInWishlist') ? 'active' : '' }}"  href="{{ route('books.index', $request)  }}"><i class="fa fa-book"></i>&nbsp;Wishlist Books</a>
    </li>
</ul>
