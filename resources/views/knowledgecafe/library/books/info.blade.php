<div class="card">

    <div class="card-body">
        <h1 class="mt-1 mb-4 mx-2" >
            {{ $info['title'] }}
        </h1>

        <div class="row">
            <div class="col-6">
                <div class="ml-1 mb-1">
                    <div class="row">
                        <div class="col-3">
                            <p>
                                <b> Authors: </b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p> {{ implode($info['authors']) }} </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <p>
                                <b> Read : </b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p>
                                <a class="btn btn-primary" href="{{ ($book["accessInfo"]["webReaderLink"]) }}">Read</a>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <p>
                                <b>Category : </b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p> {{ implode ($book['volumeInfo']['categories']) }} </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="row">
                    <div class="col-6">
                        <img src="{{$info['imageLinks']['thumbnail']}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>