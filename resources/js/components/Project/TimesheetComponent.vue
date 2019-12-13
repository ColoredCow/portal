<template>

    <div>
        <table class="table table-bordered">
            <tr>
                <th class="w-20">Modules</th>
                <th class="w-20">Subtask</th>
                <th>Total</th>
                <th>Mon, 25 Nov</th>
                <th>Tue, 26 Nov</th>
                <th>Wed, 27 Nov</th>
                <th>Thu, 28 Nov</th>
                <th>Fri, 29 Nov</th>
            </tr>
            <tr>
                <td>
                    Fixing a bug<br>
                    <select class="form-control mb-1">
                        <option>Status</option>
                        <option v-for="(status, index) in projectStatuses" :value="index">{{ status }}</option>
                    </select>
                </td>
                <td>
                    <select class="form-control mb-1">
                        <option v-for="(subtask, index) in subtasks" :value="index">{{ subtask }}</option>
                    </select>
                    <button class="btn btn-dark flex-shrink-0">New subtask</button>
                </td>
                <td><input type="text" name="" class="form-control" readonly="readonly"></td>
                <td><input type="text" name="" class="form-control"></td>
                <td><input type="text" name="" class="form-control"></td>
                <td><input type="text" name="" class="form-control"></td>
                <td><input type="text" name="" class="form-control"></td>
                <td><input type="text" name="" class="form-control"></td>
            </tr>
        </table>

        <button class="btn btn-primary">Add effort</button>
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