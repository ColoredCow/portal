@extends('payment::layouts.master')

@section('content')
<div class="container">
    <br>
    <form action="{{ route('payment-setting.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <h4>Payment Settings</h4>
                <div class="row">
                    <div class="col-6">
                        <br>
                        <div class="form-group">
                            <label for="">Bank Charges (For International payments)</label>
                            <div class="input-group mb-3">
                                <input name="bank_charges" type="number" class="form-control w-10" value="{{ optional($paymentConfig->get('bank_charges'))->value }}">
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <label for="">TDS Amount limit</label>
                            <div class="input-group mb-3">
                                <input name="tds_amount_limit" type="number" class="form-control w-10" value="{{ optional($paymentConfig->get('tds_amount_limit'))->value }}">
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <label for="">TDS Deduction</label>
                            <div class="input-group mb-3">
                                <input name="tds_deduction" type="number" class="form-control w-10" value="{{ optional($paymentConfig->get('tds_deduction'))->value }}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection