@extends('appointmentslots::layouts.master')

@section('content') 
<div class = "mx-13" id = "select_appointment_view" >
    <div id='calendar'> </div> 
    @include('appointmentslots::select_appointments.select_appointment_modal')
</div>
@endsection

@section('js_scripts')

    <script type = "text/javascript" src = "/lib/fullcalendar/lib/main.js"> </script>

    <script >
    new Vue({
        el: '#select_appointment_view',

        data() {
            return {
                comingFrom: 'marketing',
                selected_appointment_id: 0,
                selected_email: '',
            }
        },

        methods: {
            selectAppointment(id) {
                this.selected_appointment_id = id;
                $('#select_appointment').modal('show');
            },

            async selectappointmentSlot() {
                response = await axios.post('/appointment-slots/selected', {
                    email: this.selected_email,
                    slot_id: this.selected_appointment_id,
                    params: "{{ $params }}"
                });

                if (response.data.error) {
                    alert(response.data.message);
                    return true;
                }

                alert("Appointment Scheduled. Will send you the invite soon.");
                window.location.reload();
                return true;
            },

            renderCalender(that) {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'},
                    height: 'auto',
                    navLinks: true, 
                    editable: true,
                    selectable: true,
                    selectMirror: true,
                    nowIndicator: true,
                    events: @json($freeSlots),
                    eventClick: function(args) {
                        that.selectAppointment(args.event.id);
                    }
                });

                calendar.render();
            }

        },

        mounted() {
            this.renderCalender(this)
        }
    }); 
</script>

@endsection