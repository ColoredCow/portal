<div class="card">
    <div id="client_address_form">
        <div v-for="(clientAddress, index) in clientAddresses" :key="clientAddress.id">
            <div class="card-body" >

                {{-- If there are multiple Addresses --}}
                <div class="d-flex justify-content-between" v-if ="multipleAddress">
                    <div class="form-group c-pointer">
                        <label :for="'use_as_billing_address_' + clientAddress.id">Use this address for billing</label>
                        <input v-if="clientAddress.type == 'billing-address'"  checked="checked" type="radio"  name="use_as_billing_address" :id="'use_as_billing_address_' + clientAddress.id" :value="clientAddress.id">
                        <input v-else type="radio"  name="use_as_billing_address" :id="'use_as_billing_address_' + clientAddress.id" :value="clientAddress.id">
                    </div>
                    <p class="text-right text-danger" v-on:Click="removeThisAddress(index)" >Remove this address</p>
                </div>
                 {{-- End of multiple address fields --}}


                <input v-if ="true"  type="hidden"  :name="`address[${index}][type]`" value="billing-address">
                <div class="form-row">
                    <div class="col-md-5 ">  
                        <input v-if="!(clientAddress.temp)" type="hidden" class="form-control" :name="`address[${index}][id]`"  :value="clientAddress.id">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group flex-grow-1">
                                <label for="name" class="field-required">Country</label>
                                <select :name="`address[${index}][country_id]`"  class="form-control" required="required">
                                    <option value="">Select country</option>
                                    @foreach ($countries as $key => $country)
                                    <option value="{{$country->id}}" {{($country->id) ==  $client->country_id ? 'selected' : '' }}>{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2">
                                <button type="button" style="text-decoration: underline;" data-toggle="modal" data-target="#myModalClientCountry" class="btn btn-sm">Add new country</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="field-required">Address</label>
                            <textarea v-model="clientAddress.address" rows="10"  class="form-control" :name="`address[${index}][address]`"   placeholder="Client Address" required="required" ></textarea>  
                        </div>
                    </div>

                    <div class="col-md-5 offset-md-1">

                        <div class="form-group">
                            <label for="name" >State</label>
                            <input v-model="clientAddress.state" type="text" class="form-control" :name="`address[${index}][state]`"  placeholder="Enter client state">   
                        </div>

                        <div class="form-group" v-if="clientAddress.country_id == 1">
                            <label for="name" >GST Number</label>
                            <input v-model="clientAddress.gst_number" type="text" class="form-control" :name="`address[${index}][gst_number]`"   placeholder="Enter client GST number" >   
                        </div>
                        <div class="form-group">   
                            <label for="city" >City</label>
                            <input  v-model="clientAddress.city" class="form-control"  :name="`address[${index}][city]`"   placeholder="Enter city"  />
                        </div>

                        <div class="form-group">
                            <label for="area_code" >Area code</label>
                            <input type="text"  v-model="clientAddress.area_code" class="form-control" :name="`address[${index}][area_code]`"  placeholder="Enter Area code"/> 
                        </div>

                    </div>
                </div>
        
            </div>
            <hr v-if ="multipleAddress" class="border-bottom border-theme-gray-border py-0">
        </div>

        <div class="">
            <button type="button" v-on:click="addNewAddress()" style="text-decoration: underline"  class="ml-1 my-4 btn btn-default">Add new address for this client</button>
        </div>
       
        <div class="card-footer">
            @include('client::subviews.edit-client-form-submit-buttons')
        </div>
    </div>
</div>
@section('js_scripts')
<script>
    new Vue({
        el:'#client_address_form',
        data() { return {
            clientAddresses:@json($addresses)
        }},
        methods: { 
            newAddress: function() {
                return {
                    id: new Date().getTime(),
                    temp:true
                }
            },

            addNewAddress: function() {
                this.clientAddresses.push(this.newAddress())
            },

            removeThisAddress:function(index) {
                return this.clientAddresses.splice(index, 1);
            }
        },

        computed: {
            multipleAddress() {
                return this.clientAddresses.length > 1;
            }
        },
        mounted() {
            if(!this.clientAddresses.length) {
                this.addNewAddress();
            }

        }
    })
</script>
@endsection
