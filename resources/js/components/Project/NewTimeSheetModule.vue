<template>
  <div class="modal fade " id="newTimesheetModuleModal" tabindex="-1" role="dialog" aria-labelledby="newTimesheetModuleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <p>Add new Module</p>
                </div>
                <div class="modal-body">
                    <slot></slot>


                    <div class="form-group">
                        <label>Module Name</label>
                        <input v-model="moduleName" type="text" class="form-control">
                    </div>

                    <div>
                        <p>Sub Tasks</p>
                        <div id="moduleSubTasks">
                            <div class="d-flex" v-for="(subTask, index) in subTasks" :key="subTask.id">
                                 <div class="form-group flex-grow-1 mr-2">
                                    <input 
                                        v-model="subTask.name" 
                                        placeholder="Name of the subtask" 
                                        type="text"
                                        class="form-control"/>
                                </div>

                                <div>
                                    <button type="button" class="btn btn-danger btn-sm" @click="removeSubTask(index)"> - </button>
                                </div>
                            </div>
                           
                        </div>

                        <div class="text-right">
                            <button type="button" class="btn btn-info" @click="addNewSubtask()">Add more</button>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type ="button" class="btn btn-success" @click="addNewModule()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

</template>


<script>
    export default {
        props: [ 'newModuleRoute' ],
        data() {
            return {
                subTasks: [],
                moduleName:'Amar'
            }
        },

        mounted() {
            console.log(this.newModuleRoute);
        },

        methods: {
            addNewSubtask: function() {
                this.subTasks.push({id:this.subTasks.length, name:''});
            },

            removeSubTask: function(index) {
                this.subTasks.splice(index, 1);
            },

            addNewModule: async function() {
                let response = await axios.post(this.newModuleRoute, {moduleName:this.moduleName, subTasks:this.subTasks});
            }


        },
    }
</script>