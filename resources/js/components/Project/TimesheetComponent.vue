<template>
    <div>
        <div class="row mt-4">
            <div class="col-2">
                <h4>Modules</h4>
            </div>

            <div class="col-2">
                <h4>Subtask</h4>
            </div>

            <div class="col-2">
                <h4>Status</h4>
            </div>

             <div class="col-1">
                <h4>Total</h4>
             </div>

            <div class="col-5">
                <div class="d-flex overflow-auto w-100">
                    <span style="width: 50px;" class="mr-2">
                        <p>25, Mon</p>
                    </span>

                    <span style="width: 50px;" class="mr-2">
                        <p>25, Mon</p>
                    </span>

                    <span style="width: 50px;" class="mr-2">
                        <p>25, Mon</p>
                    </span>

                    <span style="width: 50px;" class="mr-2">
                        <p>25, Mon</p>
                    </span>

                    <span style="width: 50px;" class="mr-2">
                        <p>25, Mon</p>
                    </span>

                    <span style="width: 50px;" class="mr-2">
                        <p>25, Mon</p>
                    </span>

                    <span style="width: 50px;" class="mr-2">
                        <p>25, Mon</p>
                    </span>
                </div>
            </div>
        </div>


         <div class="row mt-4">
            <div class="col-2">
                <p>Newslatter</p>
            </div>

            <div class="col-2">
                <p>Setup Mailchimp</p>
            </div>

            <div class="col-2">
                <select>
                    <option value="">Pending</option>
                    <option value="">In Progress</option>
                    <option value="">Completed</option>
                </select>
            </div>

             <div class="col-1">
                <div class="h-75">
                    <input type="number" class="form-control h-100">
                </div>
             </div>

            <div class="col-5">
                <div class="d-flex" style=" overflow: scroll !important; width: 28em;">
                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                     <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>

                    <div style="min-width: 50px;" class="mr-2 mr-2 flex-grow-0">
                        <input class="w-100" min="0" type="number">
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <button class="btn btn-primary">Add New Module</button>
    </div>
</template>


<script>
    export default {
        props: [ 'timesheet', 'project', 'subtasks','projectStatuses' ],
        data() {
            return {}
        },

        mounted() {},

        methods: {},
    }
</script>