<div class="card-body" id="create_invoice_details_form">
    <div class="form-row mb-4">
        <div class="col-md-5">
            <div class="form-group">
                <div class="d-flex justify-content-between">
                    <label for="client_id" class="field-required">Client</label>
                    <a href="{{ route('client.create')  }}" for="client_id" class="text-underline">Add new client</a>
                </div>
                <select name="client_id" id="client_id" class="form-control" required="required"
                    @change="updateClientDetails()" v-model="clientId">
                    <option value="">Select Client</option>
                    <option v-for="client in clients" :value="client.id" v-text="client.name" :key="client.id"></option>
                </select>
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-between">
                    <label for="client_id" class="field-required">Project</label>
                    <a href="{{ route('project.create')  }}" class="text-underline">Add new project</a>
                </div>
                <select name="project_id" id="project_id" class="form-control" required="required">
                    <option value="">Select project</option>
                    <option v-for="project in projects" :value="project.id" v-text="project.name" :key="project.id">
                    </option>
                </select>
            </div>

            <div class="form-group ">
                <label for="project_invoice_id" class="field-required">Upload file</label>
                <div class="d-flex">
                    <div class="custom-file mb-3">
                        <input type="file" id="invoice_file" name="invoice_file" class="custom-file-input" required="required">
                        <label for="customFile0" class="custom-file-label">Choose file</label>
                    </div>
                </div>
            </div>

            <div class="form-group ">
                <label for="comments">Comments</label>
                <textarea name="comments" id="comments" rows="5" class="form-control"></textarea>
            </div>

        </div>

        <div class="col-md-5 offset-md-1">
            <div class="form-group">
                <label for="project_invoice_id" class="field-required">Status</label>
                <select class="form-control" name="status">
                    {{-- <option value="pending">Pending</option> --}}
                    <option value="sent">Sent</option>
                    <option value="paid">Paid</option>
                </select>
            </div>

            <div class="form-group">
                <label for="amount" class="field-required">Amount</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select name="currency" v-model="currency" id="currency" class="input-group-text"
                            required="required">
                            @foreach($countries as $country)
                                <option value="{{$country->currency}}">{{$country->currency}}</option>
                            @endforeach 
                        </select>
                    </div>
                    <input onkeyup="number2text();"
                     v-model="amount" type="number" class="form-control" name="amount" id="amount"
                        placeholder="Invoice Amount" required="required" step=".01" min="0">
                </div>
            </div>

            <div class="form-group" v-if="currency == 'INR'">
                <label for="gst">GST</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">INR</span>
                    </div>
                    <input v-model="gst" type="number" class="form-control" name="gst" id="gst" placeholder="GST"
                        step=".01" min="0">
                </div>
            </div>
            <p class="text-danger" v-if="currency == 'INR' " >Total Amount : @{{tot}}</p>
            <p class="text-danger" v-if="currency == 'USD' " >Total Amount : @{{amt}}</p>
            <div class="text-danger" id="container"></div><br/>

            <div class="form-group">
                <label for="sent_on" class="field-required">Sent on</label>
                <input type="date" class="form-control" name="sent_on" id="sent_on" required="required"
                    value="{{ now()->format('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label for="due_on" class="field-required">Due date</label>
                <input type="date" class="form-control" name="due_on" id="due_on" required="required"
                    value="{{ now()->addDays(6)->format('Y-m-d') }}">
            </div>

        </div>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Create</button>
</div>



@section('js_scripts')
<script>
    
    new Vue({
    el:'#create_invoice_details_form',

    data() {
        return {
            clients: @json($clients),
            projects:{},
            clientId:"",
            client:null,
            currency:'',
            amount:'',
        }
    },

    methods: {
        updateClientDetails: function() {
            this.projects =  {};
            for (var i in this.clients) {
                let client = this.clients[i];
                if (client.id == this.clientId) {
                    this.client = client;
                    this.currency = client.currency;
                    this.projects = client.projects;
                    break;
                }
            }

        }
    },

    mounted() {
    },

    computed: {
        gst: function () {
            return (this.amount * 0.18).toFixed(2);
        },
        tot: function () {
            let total = this.amount * 0.18 + 1 * this.amount;
            return (total);
        },
        amt: function (){
            return (this.amount);
        },
    }
});

function getcurrency(){
    var currency = document.getElementById('currency').value;

    return currency;
}
function number2text(value) {
    var curr = getcurrency();
    var value = document.getElementById('amount').value;
    switch (curr) {
  case 'INR':
    value = value * 0.18 + 1 * value;
    var fraction = Math.round(frac(value)*100);
    var f_text  = "";
    if(fraction > 0) {
        f_text = "AND "+convert_number(fraction)+" PAISE";
    }
    var output = convert_number(value)+" RUPEE "+f_text+" ONLY";
    break;
  case 'USD':
    var fraction = Math.round(frac(value)*100);
    var f_text  = "";
    if(fraction > 0) {
        f_text = "AND "+convert_number(fraction)+" CENTS";
    }
    var output = convert_number(value)+" DOLLAR "+f_text+" ONLY";
    break;
  }
	document.getElementById('container').innerHTML = output;
}

function frac(f) {
    return f % 1;
}

function convert_number(number)
{
    if ((number < 0) || (number > 999999999)) 
    { 
        return "NUMBER OUT OF RANGE!";
    }
    var Gn = Math.floor(number / 10000000);  /* Crore */ 
    number -= Gn * 10000000; 
    var kn = Math.floor(number / 100000);     /* lakhs */ 
    number -= kn * 100000; 
    var Hn = Math.floor(number / 1000);      /* thousand */ 
    number -= Hn * 1000; 
    var Dn = Math.floor(number / 100);       /* Tens (deca) */ 
    number = number % 100;               /* Ones */ 
    var tn= Math.floor(number / 10); 
    var one=Math.floor(number % 10); 
    var res = ""; 

    if (Gn>0) 
    { 
        res += (convert_number(Gn) + " CRORE"); 
    } 
    if (kn>0) 
    { 
            res += (((res=="") ? "" : " ") + 
            convert_number(kn) + " LAKH"); 
    } 
    if (Hn>0) 
    { 
        res += (((res=="") ? "" : " ") +
            convert_number(Hn) + " THOUSAND"); 
    } 

    if (Dn) 
    { 
        res += (((res=="") ? "" : " ") + 
            convert_number(Dn) + " HUNDRED"); 
    } 


    var ones = Array("", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX","SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN","FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTEEN","NINETEEN"); 
var tens = Array("", "", "TWENTY", "THIRTY", "FOURTY", "FIFTY", "SIXTY","SEVENTY", "EIGHTY", "NINETY"); 

    if (tn>0 || one>0) 
    { 
        if (!(res=="")) 
        { 
            res += " AND "; 
        } 
        if (tn < 2) 
        { 
            res += ones[tn * 10 + one]; 
        } 
        else 
        { 

            res += tens[tn];
            if (one>0) 
            { 
                res += ("-" + ones[one]); 
            } 
        } 
    }

    if (res=="")
    { 
        res = "ZERO"; 
    } 
    return res;
}
</script>

@endsection