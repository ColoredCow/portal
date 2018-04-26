<div class="card">

    <div class="card-body">
        <h1 style="margin-left: 0.7em; margin-bottom: 1em; margin-top: 1em;">
            {{ $info['title'] }}
        </h1>
        <div class="row">
            <div class="col-xs-6 col-md-6">
                <div style="margin-left: 3em; margin-bottom: 2em;">
                    <div class="row">
                        <div class="col-xs-6">
                            <p>
                                <b> Authors: </b>
                            </p>
                        </div>
                        <div class="col-xs-6">
                            <p> {{ implode($info['authors']) }} </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <p>
                                <b> Read : </b>
                            </p>
                        </div>
                        <div class="col-xs-6">
                            <p>
                                <a href="{{ ($book["accessInfo"]["webReaderLink"]) }}">{{ ($book["accessInfo"]["webReaderLink"]) }}</a>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <p>
                                <b>Category : </b>
                            </p>
                        </div>
                        <div class="col-xs-6">
                            <p> {{ implode ($book['volumeInfo']['categories']) }} </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-md-6">
                <div class="row">
                    <div class="col-xs-6">
                        <img src="{{$info['imageLinks']['thumbnail']}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer text-center">
        <button type="button" class="btn btn-primary" id="save_book_to_records" >Save to records</button>
    </div>
</div>

