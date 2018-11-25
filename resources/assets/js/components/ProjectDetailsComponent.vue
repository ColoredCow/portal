<template>
    <div class="header">

        <div class="card-body">
            <div class="project-info container">
                <div class="head-section row">
                  <h3 class="col-12"><strong>{{project.name}}</strong></h3>
                </div>

                <div class="info-section mt-3 row">
                    <div class="current-cycle-info col-sm-6">
                        <strong>Current Cycle:</strong>
                        29/10/2018 to 02/10/2018
                        <br>
                        <strong>Estimated Effort:</strong>
                        40
                        <br>
                        <strong>Last Updated:</strong>
                        30/10/2018
                    </div>
                    <div class="employee-info col-sm-6">
                        <div class="row list-sections text-center">
                            <div class="offset-sm-4 col-sm-4 text-center">
                                <p><strong>Employees</strong></p>
                                <ul class="unstyled-list p-0">
                                  <li v-for="employee in project.employees">{{employee.name}}</li>
                                </ul>
                            </div>
                            <div class="col-sm-4 text-center">
                                <p><strong>Contribution</strong></p>
                                <ul class="unstyled-list p-0">
                                    <li v-for="employee in project.employees">0</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="project-actions row">
                <div class="col-12 project-action text-center">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>
                                  Employee
                                    <span @click="showAddEmployeeForm">
                                        <button type="button" class="p-0 btn btn-default">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </span>
                                </th>
                                <th>Contribution</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="project">
                            <tr v-for="employee in project.employees">
                                <td>
                                  {{employee.name}}
                                </td>
                                <td>{{employee.pivot.contribution_type}}</td>
                                <td><i class="btn btn-default fa fa-close" @click="removeEmployee(employee.id)"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="add-employee-form" v-if="showAddEmployeeForm">
            <div class="modal fade slide-up" data-backdrop="static" data-keyboard="false" id="addEmployeeForm" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog">
                    <div class="modal-content-wrapper">
                        <div class="modal-content form-modal">
                            <div class="modal-header card-header">
                                <h3 class="modal-title">Add Employee to this Project</h3>
                                <button type="button" class="close" @click="destroyFormModal" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body card-body">
                                <form>
                                    <label for="employee">Select Employee</label>
                                    <select required class="form-control" name="employee" v-model="selectedEmployee">
                                        <option disabled value="">Please select one</option>
                                        <option v-for="employee in employees" :value="employee.id">{{employee.name}}</option>
                                    </select>

                                    <label for="contribution">Contribution</label>
                                    <select required class="form-control" name="contribution" v-model="contributionType">
                                        <option disabled value="">Please select one</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="hourly">Hourly</option>
                                      </select>
                                </form>
                            </div>

                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" @click="addEmployeeToProject">Add</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  
  export default {
    props: ['project', 'clients', 'employees'],

    data() {
        return {
        loadAddEmployeeForm: false,
        selectedEmployee: null,
        contributionType: null,
      }
    },

    methods: {
      showAddEmployeeForm() {
        this.loadAddEmployeeForm = true;
        $('#addEmployeeForm').modal('show');
      },

      destroyFormModal() {
        this.loadAddEmployeeForm = false;
        $('#addEmployeeForm').modal('hide');
      },

      addEmployeeToProject() {
        let employeeData = {
          employeeId: this.selectedEmployee,
          contribution: this.contributionType
        }

        axios.post('/projects/'+this.project.id+'/add-employee', employeeData)
          .then((response) => {
            window.location.reload(); //since we are not using vue-router
            this.destroyFormModal();
        })
        .catch(error => {
          console.log('err', error);
        });
      },

      removeEmployee(employeeId) {
        let employeeData = {
          employeeId: employeeId,
        }

        axios.post('/projects/'+this.project.id+'/remove-employee', employeeData)
          .then((response) => {
            window.location.reload(); //since we are not using vue-router
        })
        .catch(error => {
          console.log('err', error);
        });
      }
    }
  }
</script>

<style>
  .unstyled-list {
    list-style: none;
  }

</style>