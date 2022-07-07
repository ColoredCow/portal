<div class="modal fade" 
    id="update_category_modal"
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="update_category_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <ul class="list-group" >
                            <li v-for="(category, index) in bookCategories" class="list-group-item">
                                <div class="form-check books_category_item">
                                    <label class="form-check-label">
                                    <input type="checkbox" :data-category="category.name"  class=" book_category_input" :value="category.id"> @{{ category.name }}
                                    </label>
                                </div> 
                            </li>
                        
                            <li class="list-group-item">
                                <span>
                                    <div class="d-flex justify-content-between">
                                        <input class="form-control mr-3" type="text" v-model="newCategory" placeholder="Enter New Category" autofocus>
                                        <button type="button" class="btn btn-info btn-sm" @click="addNewCategory()">  Add&nbsp;New </button>
                                        
                                    </div>
                                </span>
                            </li>



                    </ul>
                </div>
            </div>

            <div class="modal-footer">
                <button id="close_update_category_modal" type="type" class="btn btn-light" data-dismiss="modal" aria-label="Close">Cancel</button>
                <button @click="updateCategory" type="button" type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
