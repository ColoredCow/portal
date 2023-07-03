@extends('layouts.app')

@section('content')
    <div class="container mb-20">
        <br>
        @include('hr.employees.sub-views.menu')
        <br>
        <div>
            <br>
            <h2>Employee Self Review</h2>
            <br>
            <br>

            <div class="review-cards">
                <!-- Quarter 1 Review Card -->
                <div class="card mb-4">
                    <div class="card-header review-card-header">
                        <h4 class="font-weight-bold">Quarterly Review (20/05/2023)</h4>
                    </div>
                    <div class="card-body review-card-body" style="display: none;">
                        <!-- Parameters for Quarter 1 Review -->
                        <h3 class="font-weight-bold">Work Area</h3>
                        <br>
                        <div class="parameter-section">
                            <p class="font-weight-bold">Threshold:</p>
                            <p>1. Good knowledge of engineering & development principles and best practice</p>
                            <div class="question">
                                <input type="radio" name="q1_threshold" value="A"> A &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_threshold" value="A-"> A- &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_threshold" value="B"> B
                            </div>
                            <br>
                            <br>
                            <p class="font-weight-bold">Normal:</p>
                            <div class="question">
                                <p>1. Able to code business logic independently (up to 5 pointers)</p>
                                <input type="radio" name="q1_normal_1" value="A"> A &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_1" value="A-"> A- &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_1" value="B"> B
                            </div>
                            <br>
                            <div class="question">
                                <p>2. Meeting the timelines on the assignments (Technical Competency Perspective) (up to 5
                                    pointers)</p>
                                <input type="radio" name="q1_normal_2" value="A"> A &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_2" value="A-"> A- &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_2" value="B"> B
                            </div>
                            <br>
                            <div class="question">
                                <p>3. Awareness of project infrastructure - Is the person able to follow documented devops
                                    activities on the project</p>
                                <input type="radio" name="q1_normal_3" value="A"> A &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_3" value="A-"> A- &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_3" value="B"> B
                            </div>
                            <br>
                        </div>

                        <!-- Additional Parameters for Quarter 1 Review -->
                        <!-- Add more parameters, sections, and questions as needed -->

                        <br>
                        <br>
                        <button class="btn btn-primary">Save</button> <!-- Save button -->
                    </div>
                </div>

                <div class="card">
                    <div class="card-header review-card-header">
                        <h4 class="font-weight-bold">Quarterly Review (20/01/2023)</h4>
                    </div>
                    <div class="card-body review-card-body" style="display: none;">
                        <!-- Parameters for Quarter 1 Review -->
                        <h3 class="font-weight-bold">Work Area</h3>
                        <br>
                        <div class="parameter-section">
                            <p class="font-weight-bold">Threshold:</p>
                            <p>1. Good knowledge of engineering & development principles and best practice</p>
                            <div class="question">
                                <input type="radio" name="q1_threshold" value="A"> A &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_threshold" value="A-"> A- &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_threshold" value="B"> B
                            </div>
                            <br>
                            <br>
                            <p class="font-weight-bold">Normal:</p>
                            <div class="question">
                                <p>1. Able to code business logic independently (up to 5 pointers)</p>
                                <input type="radio" name="q1_normal_1" value="A"> A &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_1" value="A-"> A- &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_1" value="B"> B
                            </div>
                            <br>
                            <div class="question">
                                <p>2. Meeting the timelines on the assignments (Technical Competency Perspective) (up to 5
                                    pointers)</p>
                                <input type="radio" name="q1_normal_2" value="A"> A &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_2" value="A-"> A- &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_2" value="B"> B
                            </div>
                            <br>
                            <div class="question">
                                <p>3. Awareness of project infrastructure - Is the person able to follow documented devops
                                    activities on the project</p>
                                <input type="radio" name="q1_normal_3" value="A"> A &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_3" value="A-"> A- &nbsp &nbsp &nbsp;
                                <input type="radio" name="q1_normal_3" value="B"> B
                            </div>
                            <br>
                        </div>

                        <!-- Additional Parameters for Quarter 1 Review -->
                        <!-- Add more parameters, sections, and questions as needed -->

                        <br>
                        <br>
                        <button class="btn btn-primary">Save</button> <!-- Save button -->
                    </div>
                </div>

                <!-- Add more Quarter Review Cards as needed -->

            </div>
        </div>
    </div>

    <script>
        // jQuery code to toggle card body visibility
        $(document).ready(function() {
            $('.review-card-header').click(function() {
                $(this).next('.review-card-body').slideToggle();
            });
        });
    </script>
@endsection
