@extends('salary::layouts.master')
@section('content')
    <div class="container">
        <br>
        <br>
        <br>
        <div class="card-header pb-lg-5 fz-28 bg-light">
            <div class="mt-5 ml-0">Salaries( <i class="fa fa-rupee"></i>&nbsp;)</div>
        </div>
        <div class="container tb1-container salary-container">
            <div class="row tb1-fixed"> 
                <table class="table table-bordered table-striped salary-table">
                    <thead class="sticky-top">
                        <tr class="text-center">
                        </tr>
                        <tr class="text-center">
                            <th colspan="8" class="bg-light"></th>
                            <th colspan="5" class="bg-light">Deduction</th>
                            <th colspan="5" class="bg-light"></th>
                            <th colspan="4" class="bg-light">CTC</th>
                        </tr>
                        <tr class="bg-light">
                            <th class="bg-light"> Employee Name</th>
                            <th>GROSS</th>
                            <th>Basic Salary</th>
                            <th>HRA</th>
                            <th>Transport Allowance</th>
                            <th>Other Allowance</th>
                            <th>Food Allowance</th>
                            <th>Total Salary</th>
                            <th class="bg-light">Employee ESI</th>
                            <th class="bg-light">Employee EPF</th>
                            <th class="bg-light">TDS</th>
                            <th class="bg-light">Food Deduction</th>
                            <th class="bg-light">Total Deduction</th>
                            <th>Net Pay</th>
                            <th>Employer Esi</th>
                            <th>EPF Employer Share</th>
                            <th>Administration Charges</th>
                            <th>EDLI Charges</th>
                            <th class="bg-light">CTC</th>
                            <th class="bg-light">CTC Annual</th>
                            <th class="bg-light">Health Insurance</th>
                            <th class="bg-light">CTC Aggreed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td class="font-weight-bold bg-white">{{$employee->name}}</td>
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
                                    <td class="bg-white">N/A</td>
                                    <td class="bg-white">N/A</td>
                                    <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                     <td class="bg-white">N/A</td>
                                @endif
                            </tr>
                        @endforeach
                </table>
            </div>
        </div>
        </div>
        <div class="card-footer"></div>
    </div>
@endsection
