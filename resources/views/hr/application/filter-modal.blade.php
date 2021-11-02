<div class="container" id="vueContainer">   
    <div class="modal job-application-modal" id="application-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Filter By</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <job-application-component value="options"></job-application-component>    
                        </div>
                    </div>
                </form>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" disabled data-dismiss="modal">Apply(Coming Soon)</button>
                <button type="button" class="btn btn-outline-danger" disabled data-dismiss="modal">Close(Coming Soon)</button>
            </div>
        </div>
    </div>
</div>
