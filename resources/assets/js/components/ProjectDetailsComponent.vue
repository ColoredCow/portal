<template>
  <div class="header">

    <div class="card-body">
      <div class="project-info container">
        <div class="head-section row">
          <h3 class="col-sm-12"><strong>{{project.name}}</strong></h3>
        </div>

        <div class="info-section row">
          <div class="current-cycle-info col-sm-6">
            <label for=""><strong>Current Cycle:</strong></label>
            {{"29/10/2018 to 02/10/2018"}}
            <br>
            <label for=""><strong>Estimated Effort:</strong></label>
            {{"40"}}
            <br>
            <label for=""><strong>Last Updated:</strong></label>
            {{"30/10/2018"}}
          </div>
          <div class="employee-info col-sm-6">
            <div class="row list-section">
              <div class="offset-sm-4 col-sm-4 list-section">
                <p><strong>Employees</strong></p>
                <ul class="unstyled-list">
                  <li v-for="employee in project.employees">{{employee.name}}</li>
                </ul>
              </div>
              <div class="col-sm-4 list-section">
                <p><strong>Contribution</strong></p>
                <ul class="unstyled-list">
                  <li v-for="employee in project.employees">0</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="project-actions row">
        <div class="col-sm-12 project-action">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>
                  Employee
                  <span @click="showAddEmployeeForm">
                    <i class="btn btn-default fa fa-plus"></i>
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

    computed: {
      availableEmployees() {

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
        let payload = {
          employeeId: this.selectedEmployee,
          contribution: this.contributionType
        }

        axios.post('/projects/'+this.project.id+'/add-employee', payload)
          .then((response) => {
            window.location.reload(); //since we are not using vue-router
            this.destroyFormModal();
        })
        .catch(error => {
          console.log('err', error);
        });
      },

      removeEmployee(employeeId) {
        let payload = {
          employeeId: employeeId,
        }

        axios.post('/projects/'+this.project.id+'/remove-employee', payload)
          .then((response) => {
            window.location.reload(); //since we are not using vue-router
            console.log('asdasd');
        })
        .catch(error => {
          console.log('err', error);
        });
      }
    }
  }
</script>

<style>
  .info-section {
    margin-top: 30px;
  }

  .project-action {
    text-align: center;
  }

  .unstyled-list {
    list-style: none;
    padding: 0
  }

  .btn-default {
    padding: 1px;
  }

  .list-section {
    text-align: center;
  }
</style>