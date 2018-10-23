<template>
  <div class="header">

    <div class="card-body">
      <div class="project-info container">
        <div class="head-section row">
          <h3 class="col-sm-12">Project Dashboard</h3>
          <br>
          <h5 class="col-sm-12">{{project.name}}</h5>
        </div>

        <div class="info-section row">
          <div class="current-cycle-info col-sm-6">
            <label for=""><strong>Current Cycle</strong></label>
            {{'123123'}}
            <br>
            <label for=""><strong>Estimated Effort</strong></label>
            {{'123123'}}
            <br>
            <label for=""><strong>Last Updated</strong></label>
            {{'123123'}}
          </div>
          <div class="employee-info col-sm-6">
            <div class="row list-section">
              <div class="col-sm-6">
                <p><strong>Employees</strong></p>
                <ul class="unstyled-list">
                  <li>Tushar</li>
                  <li>Vaibhav</li>
                  <li>Pankaj</li>
                </ul>
              </div>
              <div class="col-sm-6">
                <p><strong>Contribution</strong></p>
                <ul class="unstyled-list">
                  <li>40</li>
                  <li>20</li>
                  <li>20</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="project-actions row">
        <div class="col-sm-3 project-action">
          <p><strong>Project Type</strong></p>
        </div>
        <div class="col-sm-3 project-action">
          <p><strong>Billing Frequency</strong></p>
        </div>
        <div class="col-sm-3 project-action">
          <p>
            <strong>Employees</strong>
            <span @click="showAddEmployeeForm">
              <i class="btn btn-default fa fa-plus"></i>
            </span>
          </p>
          <ul class="unstyled-list">
            <li v-for="employee in employees">
              {{employee.name}}
            </li>
          </ul>
        </div>
        <div class="col-sm-3 project-action">
          <p><strong>Contribution</strong></p>
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
                  <select class="form-control" name="employee" v-model="selectedEmployee">
                    <option disabled value="">Please select one</option>
                    <option v-for="employee in employees" :value="employee.id">{{employee.name}}</option>
                  </select>

                  <label for="contribution">Contribution</label>
                  <select class="form-control" name="contribution" v-model="contributionType">
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
        let payload = {
          employeeId: this.selectedEmployee,
          contribution: this.contributionType
        }
        console.log('pay', payload);

        axios.post('/projects/'+this.project.id+'/add-employee', payload)
          .then((response) => {
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
  }

  .btn-default {
    padding: 1px;
  }
</style>