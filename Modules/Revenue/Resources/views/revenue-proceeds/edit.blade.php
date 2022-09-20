<div class="modal fade text-left" tabindex="-1" role="dialog" id="modalEdit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Revenue</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('revenue.proceeds.update', 'id') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group ml-6 col-md-5">
                                <input value="{{ route('revenue.proceeds.update', 'id') }}" type="hidden"
                                    class="hidden" aria-hidden="true" name="routePlaceHolder">
                                <label class="field-required">Name</label>
                                <input type="text" class="form-control" required name="name">
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label class="field-required">Date of Recieved</label>
                                <input type="date" class="form-control" required name="received_at">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group ml-6 col-md-5">
                                <label class="field-required">Category</label>
                                <select name="category" class="form-control">
                                    <option class="disabled">Select category</option>
                                    @foreach (config('report.finance.profit_and_loss.particulars.revenue') as $key => $label)
                                        <option value="{{ $key }}">{{ $label['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label class="field-required">Year</label>
                                <select name="year" class="form-control">
                                    @php $year = now()->year; @endphp
                                    @while ($year != 2017)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                        @php
                                            $year--;
                                        @endphp
                                    @endwhile
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group ml-6 col-md-5">
                                <label class="field-required">Amount</label>
                                <div class="input-group">
                                    <div class=" input-group-prepend">
                                        <select name="currency" name="currency" class="input-group-text">
                                            @foreach (config('constants.countries') as $country => $countryDetails)
                                                <option value="{{ $countryDetails['currency'] }}">
                                                    {{ $countryDetails['currency'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="number" class="form-control" required name="amount">
                                </div>
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label class="field-required">Month</label>
                                <select type="text" class="form-control" required name="month">
                                    <option class="disbled">Select month</option>
                                    @foreach (config('constants.months') as $months => $month)
                                        <option value="{{ $months }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group ml-6 col-md-7">
                                <label>Note</label>
                                <textarea type="text" class="form-control" rows="3" name="notes"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save-btn-action">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
