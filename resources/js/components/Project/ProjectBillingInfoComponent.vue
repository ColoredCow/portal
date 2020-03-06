<template>
    <div>
        <h3 class="mt-4">Billing Info</h3>
        
           <div class="form-row">
        <div class="form-group col-md-5">
            <label for="address">Address line 1</label>
            <input v-model="billinginfo.address" type="text" class="form-control" name="address" id="address" placeholder="Address line 1">
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label for="contact_person_name">Contact person name</label>
            <input v-model="billinginfo.contact_person_name" type="text" class="form-control"
                name="contact_person_name" id="contact_person_name" placeholder="Contact person name">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="state_id">State</label>
            <select name="state_id" id="state_id" class="form-control" required="required" @change="stateChanged">
                <option  v-for="state in this.states" :key="state.id" :value="state.id" >{{  state.name }}  </option>
            </select>
        </div>

        <div class="form-group offset-md-1 col-md-5">
            <label for="contact_person_email">Contact person email</label>
            <input v-model="billinginfo.contact_person_email" type="email" class="form-control" name="contact_person_email" id="contact_person_email"
                placeholder="Contact person email">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="city">City</label>
            <input v-model="billinginfo.city" type="text" class="form-control" name="city" id="city"
                placeholder="City">
        </div>

        <div class="form-group offset-md-1 col-md-5">
            <label for="other_members_to_cc">Other members to CC (email1, eamil2, email3...)</label>
            <input v-model="billinginfo.other_members_to_cc" type="text" class="form-control" name="other_members_to_cc" id="other_members_to_cc"
                placeholder="Other members to CC">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="city">Pincode</label>
            <input v-model="billinginfo.pincode" type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="city">GST Number</label>
            <input v-model="billinginfo.gst_number" v-on:input="checkState" type="text" class="form-control" name="gst_number" id="gst_number" placeholder="GST Number">
        </div>
    </div>
    </div>
</template>


<script>
    export default {
        props: [ 'states', 'project', 'billinginfo'],
        props: { 
            states:Array,
            project:Object,
            billing:Object,
            billinginfo: {
                type:Object,
                default:{}
            }
        },
        data() {
            return {
                gst:'',
                selectedState:0,
            }
        },

        mounted() {
            
        },

        methods: {
            checkState:function() {},
            stateChanged:async function(e){}
        },
    }
</script>