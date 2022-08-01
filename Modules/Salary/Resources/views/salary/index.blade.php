@extends('salary::layouts.master')
@section('content')
    <div class="container">
        <br>
        <br>
        <br>
        <div class="card-header pb-lg-5 fz-28 bg-info">
            <div class="mt-4 ml-5">Salaries( <i class="fa fa-rupee"></i>&nbsp;)</div>
        </div>
        <div class="container tb1-container salary-container]">
            <div class="row tb1-fixed"> 
                <table class="table table-bordered table-striped salary-table">
                    <thead class="sticky-top">
                        {{-- Need to find a way to implement sticky top as in responsive table it is not working --}}
                        <tr class="text-center">
                            <th colspan="8" class="bg-secondary"></th>
                            <th colspan="5" class="bg-danger">Deduction</th>
                            <th colspan="5" class="bg-secondary"></th>
                            <th colspan="4" class="bg-info">CTC</th>
                        </tr>
                        <tr class="bg-secondary"> 
                            <th>Employee Name</th>
                            <th>GROSS</th>
                            <th>Basic Salary</th>
                            <th>HRA</th>
                            <th>Transport Allowance</th>
                            <th>Other Allowance</th>
                            <th>Food Allowance</th>
                            <th>Total Salary</th>
                            <th class="bg-danger">Employee ESI</th>
                            <th class="bg-danger">Employee EPF</th>
                            <th class="bg-danger">TDS</th>
                            <th class="bg-danger">Food Deduction</th>
                            <th class="bg-danger">Total Deduction</th>
                            <th>Net Pay</th>
                            <th>Employer Esi</th>
                            <th>EPF Employer Share</th>
                            <th>Administration Charges</th>
                            <th>EDLI Charges</th>
                            <th class="bg-info">CTC</th>
                            <th class="bg-info">CTC Annual</th>
                            <th class="bg-info">Health Insurance</th>
                            <th class="bg-info">CTC Aggreed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td class="font-weight-bold">{{$employee->name}}</td>
                                @if(optional($employee->employeeSalaries->first())->monthly_gross_salary != null)
                                    <td>{{optional($employee->employeeSalaries->first())->monthly_gross_salary}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->basic_salary}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->hra}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->transport_allowance}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->other_allowance}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->food_allowance}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->total_salary}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->employee_esi}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->employee_epf}}</td>
                                    <td>N/A</td>
                                    <td>{{optional($employee->employeeSalaries->first())->food_allowance}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->total_deduction}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->net_pay}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->employer_esi}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->employer_epf}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->administration_charges}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->edli_charges}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->ctc}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->ctc_annual}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->health_insurance}}</td>
                                    <td>{{optional($employee->employeeSalaries->first())->ctc_aggreed}}</td>
                                @else
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                @endif
                            </tr>
                        @endforeach
                </table>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
@endsection
