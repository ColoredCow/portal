<template>
    <div>
        <table class="table table-bordered">
            <tr>
                <th class="w-20">Modules</th>
                <th class="w-20">Status</th>
                <th class="w-20">Subtask</th>
                <th>Total</th>
                <th>Mon, 25 Nov</th>
                <th>Tue, 26 Nov</th>
                <th>Wed, 27 Nov</th>
                <th>Thu, 28 Nov</th>
                <th>Fri, 29 Nov</th>
            </tr>
            <tr>
                <td>Fixing a bug</td>
                <td>Status</td>
                <td>
                    <select class="form-control mb-1" id="exampleFormControlSelect1">
                        <option v-for="(subtask, index) in subtasks">{{ subtask }}</option>
                    </select>
                    <button class="btn btn-dark flex-shrink-0">New subtask</button>
                </td>
                <td><input type="text" name="" class="form-control"></td>
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
        props: [ 'timesheet', 'project', 'subtasks' ],
        data() {
            return {}
        },

        mounted() {},

        methods: {},
    }
</script>