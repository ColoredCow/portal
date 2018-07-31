<div class="card">
    <div class="card-body">
        <h1 class="mt-1 mb-4 mx-2">
            @{{ book.title }}
        </h1>
        <div class="row">
            <div class="col-6">
                <div class="ml-1 mb-1">
                    <div class="row">
                        <div class="col-3">
                            <p>
                                <b>Authors: </b>
                            </p>
                        </div>
                        <div class="col-6">
                            @{{ book.author }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <p>
                                <b>Read: </b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p>
                                <a class="btn btn-primary" v-bind:href="book.readable_link">Read</a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <p>
                                <b>Category: </b>
                            </p>
                        </div>
                        <div class="col-6">
                            @{{ book.categories }}
                        </div>
                    </div>
                    <div class="row d-flex align-items-center">
                        <div class="col-3 pr-0 font-weight-bold">
                            <label for="number_of_copies" class="mb-0">Copies available:</label>
                        </div>
                        <div class="col-6">
                            <input type="number" v-model="number_of_copies" class="form-control" id="number_of_copies" placeholder="Number of copies">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-6">
                        <img v-bind:src="book.thumbnail" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button
        type="button"
        v-on:click= "saveBookToRecords"
        class="btn btn-success"
        :disabled = "buttons.disableSaveButton"
        id="save_book_btn" >
        <i class="fa fa-spinner fa-spin d-none item"></i>
        <span v-if="!buttons.disableSaveButton" class="item">Save</span>
        </button>
    </div>
</div>
