<ul class="nav nav-pills">
    <li class="nav-item">
    <a class="nav-item nav-link {{ $active === 'books' ? 'active' : '' }}" href="{{ route('books') }}"><i class="fa fa-book"></i>&nbsp;Books</a>
    </li>

    @can('library_book_category.view')
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'book_category' ? 'active' : '' }}" href="{{ route('books.category.index') }}"><i class="fa fa-book"></i>&nbsp;Books Category</a>
    </li>
    @endcan
</ul>
