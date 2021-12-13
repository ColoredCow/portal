<div class="container" id="vueContainer">   
    <div class="modal" id="emailinvoicesmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Email Invoices</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method ="POST" id ="myForm" action="{{ route('email-invoice.handle') }}">
                        <input type="hidden" name="filters[year]" value="{{ request()->get('year') }}">
                        <input type="hidden" name="filters[month]" value="{{ request()->get('month') }}">
                        <input type="hidden" name="filters[status]" value="{{ request()->get('status')}}">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label for="recipient-email" class="col-sm-4 col-form-label">Recipient-Email:   </label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="recipient-email" placeholder="Recipient Email">
                            </div>
                        </div>
                    </form>    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary" onclick='myFunction()'>Email</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    function myFunction()
        {
            document.getElementById("myForm").submit();
        }
</script>
