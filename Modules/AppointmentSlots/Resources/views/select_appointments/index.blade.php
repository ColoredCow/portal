@extends('appointmentslots::layouts.master')

@section('content')
<div class="mx-13" id="select_appointment_view" >
    <div id="select_appointment">
        <div class="alert alert-success mb-5" role="alert">
            <h4 class="alert-heading mb-2">Hello! Great you made it to this page!</h4>
            <p class="fz-16">This is a calendar where you can see available slots to schedule your interview with ColoredCow. Simply click on a slot that suits you best and verify your email id!</p>
            <hr>
            <p class="mb-0 fz-14"><i class="fa fa-lightbulb-o"></i>&nbsp;Pro tip: In case you don't find any available slots, please use the navigation arrows to check the available slots in the next month.</p>
        </div>
        @include('appointmentslots::select_appointments.select_appointment_modal')
    </div>
    <div id="appointment_selected" class="d-none">
        @include('appointmentslots::select_appointments.selected')
    </div>
    <div id='calendar'></div>
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
            calculateMinDate(that) {
                this.minDate = null;
                this.events.forEach(event => {
                this.eventStart = new Date(event.start);
                if (this.minDate === null || this.eventStart < this.minDate) {
                    this.minDate = this.eventStart;
                }
                });
                this.minDateString = this.minDate.toISOString().split('T')[0]; // Extracts the date part
                return this.minDateString;
            },

            calculateMaxDate(that) {
                this.maxDate = null;
                this.events.forEach(event => {
                    this.eventEnd = event.end ? new Date(event.end) : new Date(event.start);
                if (this.maxDate === null || this.eventEnd > this.maxDate) {
                    this.maxDate = this.eventEnd;
                }
                });
                this.maxDateWithOneDayAdded = new Date(this.maxDate);
                this.maxDateWithOneDayAdded.setDate(this.maxDateWithOneDayAdded.getDate() + 1);
                this.maxDateString = this.maxDateWithOneDayAdded.toISOString().split('T')[0];
                return this.maxDateString;
            },

            selectAppointment(id) {
                this.selected_appointment_id = id;
                $('#select_appointment_modal').modal('show');
            },

            async selectappointmentSlot() {
                $('#selectAppointmentSlotButton').attr('disabled', 'disabled').addClass('disabled c-disabled');
                response = await axios.post('/appointment-slots/selected', {
                    email: this.selected_email,
                    slot_id: this.selected_appointment_id,
                    params: "{{ $params }}"
                });

                $('#selectAppointmentSlotButton').removeAttr('disabled').removeClass('disabled c-disabled');
                if (response.data.error) {
                    alert(response.data.message);
                    return true;
                }

                $('#select_appointment_modal').modal('hide');
                $('#calendar, #select_appointment').addClass('d-none');
                $('#appointment_selected').removeClass('d-none');
                return true;
            },

            renderCalender(that) {
                var calendarEl = document.getElementById('calendar');
                
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: { left: 'prev,next today', center: 'title', right: null},
                    height: 'auto',
                    navLinks: true,
                    editable: true,
                    selectable: true,
                    selectMirror: true,
                    hiddenDays: [0, 6],
                    validRange: {
                        start: this.startDate,
                        end: this.endDate
                    },
                    nowIndicator: true,
                    events: this.events,
                    eventClick: function(args) {
                        that.selectAppointment(args.event.id);
                    },
                    eventTimeFormat: {
                        hour: "numeric",
                        minute: "2-digit",
                        meridiem: "short",
                    }
                });

                calendar.render();
            }

        },

        mounted() {
            this.events = @json($freeSlots);
            this.startDate = this.calculateMinDate(this);
            this.endDate = this.calculateMaxDate(this);
            this.renderCalender(this)
        }
    });
</script>

@endsection
