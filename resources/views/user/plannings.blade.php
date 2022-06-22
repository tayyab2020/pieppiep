@extends('layouts.handyman')

@section('content')

    <script src="{{asset('assets/admin/js/main1.js')}}"></script>
    <script src="{{asset('assets/admin/js/bootstrap-tagsinput.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
    <script src="https://www.jqueryscript.net/demo/Date-Time-Picker-Bootstrap-4/build/js/bootstrap-datetimepicker.min.js"></script>

    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    @include('includes.form-success')
                    
                    <form method="POST" action="{{route('store-plannings')}}" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row" style="width: 90%;margin: 20px auto;">
                            <button type="button" class="btn btn-success add-appointment"><i style="margin-right: 5px;" class="fa fa-plus"></i> {{__('text.Add Appointment')}}</button>
                            <button type="submit" style="background-color: #0e720e !important;border-color: #0e720e !important;color: white !important;" class="btn btn-success"><i style="margin-right: 5px;" class="fa fa-save"></i> {{__('text.Save')}}</button>
                        </div>

                        <?php

                        $appointments = json_decode($plannings,true);
                        $appointments = array_slice($appointments, 2);
                        $count = count($appointments);
                        $last_event_id = $last_event_id + 1;
                        $appointments = json_encode($appointments);

                        ?>

                        <input type="hidden" value="{{isset($appointments) ? ($count > 0 ? $appointments : null) : null}}" class="appointment_data" name="appointment_data">
                        <input type="hidden" value="{{isset($last_event_id) ? $last_event_id : 1}}" class="appointment_id">

                        <div id='calendar'></div>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <div id="addAppointmentModal" role="dialog" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" data-dismiss="modal" class="close">×</button>
                    <h4 class="modal-title">{{__('text.Add Appointment')}}</h4>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 required appointment_title_box">
                            <label>{{__('Title')}}</label>
                            <select class="appointment_title">

                                <option value="">{{__('text.Select Event Title')}}</option>
                                <option value="Delivery Date">{{__('text.Delivery Date')}}</option>
                                <option value="Installation Date">{{__('text.Installation Date')}}</option>

                                @foreach($event_titles as $title)

                                    <option value="{{$title->title}}">{{$title->title}}</option>

                                @endforeach

                            </select>
                        </div>

                        <div class="form-group col-xs-12 col-sm-4 required">
                            <label>{{__('Start')}}</label>
                            <input type="text" class="form-control appointment_start validation_required" readonly="readonly">
                        </div>

                        <div class="form-group col-xs-12 col-sm-4 required">
                            <label>{{__('End')}}</label>
                            <input type="text" class="form-control appointment_end validation_required" readonly="readonly">
                        </div>

                        <div class="form-group col-xs-12 col-sm-4 required">
                            <label>{{__('Select Type')}}</label>
                            <select class="appointment_type">

                                <option value="1">{{__('text.For Quotation')}}</option>
                                <option value="2">{{__('text.For Client')}}</option>

                            </select>
                        </div>

                        <div class="form-group col-xs-12 quotation_box col-sm-4 required">
                            <label>{{__('Quotation Number')}}</label>
                            <select class="appointment_quotation_number">

                                <option value="">{{__('text.Select Quotation')}}</option>

                                @foreach($quotation_ids as $key)

                                    <option value="{{$key->id}}">{{$key->quotation_invoice_number}}</option>

                                @endforeach

                            </select>
                        </div>

                        <div style="display: none;" class="form-group customer_box col-xs-12 col-sm-4 required">
                            <label>{{__('Customer')}}</label>
                            <select class="appointment_client">

                                <option value="">{{__('text.Select Customer')}}</option>

                                @foreach($clients as $key)

                                    <option value="{{$key->id}}">{{$key->name . ' ' . $key->family_name}}</option>

                                @endforeach

                            </select>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12">
                            <label>{{__('Description')}}</label>
                            <textarea rows="4" class="form-control appointment_description"></textarea>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 required">
                            <label>{{__('Tags')}}</label>
                            <input type="text" data-role="tagsinput" class="form-control appointment_tags" />
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" id="event_id">
                    <button type="button" class="btn btn-success pull-left submit_appointmentForm">{{__('Save')}}</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>

    <style>

        .bootstrap-tagsinput
        {
            width: 100%;
        }

        .fc-event:hover .fc-buttons
        {
            display: block;
        }

        .fc-event .fc-buttons
        {
            padding: 10px;
            text-align: center;
            display: none;
            position: absolute;
            background-color: #ffffff;
            border: 1px solid #d7d7d7;
            bottom: 100%;
            z-index: 99999;
            min-width: 80px;
        }

        .fc-event .fc-buttons:after,
        .fc-event .fc-buttons:before {
            top: 100%;
            left: 8px;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .fc-event .fc-buttons:before {
            border-color: rgba(119, 119, 119, 0);
            border-top-color: #d7d7d7;
            border-width: 6px;
            margin-left: -6px;
        }

        .fc-event .fc-buttons:after {
            border-color: rgba(255, 255, 255, 0);
            border-top-color: #ffffff;
            border-width: 5px;
            margin-left: -5px;
        }

        .fc table
        {
            margin: 0 !important;
        }

        .fc .fc-scrollgrid-section-liquid > td, .fc .fc-scrollgrid-section > td, .fc-theme-standard td, .fc-theme-standard th
        {
            padding: 0 !important;
        }

        .fc .fc-scrollgrid-section-liquid > td:first-child
        {
            border-right: 1px solid var(--fc-border-color, #ddd);
        }

        #calendar {
            width: 90%;
            margin: 0 auto;
        }

        .alert-danger
        {
            margin: 30px 10px !important;
        }

        .swal2-html-container {
            line-height: 2;
        }

        a.info {
            vertical-align: bottom;
            position: relative;
            /* Anything but static */
            width: 1.5em;
            height: 1.5em;
            text-indent: -9999em;
            display: inline-block;
            color: white;
            font-weight: bold;
            font-size: 1em;
            line-height: 1em;
            background-color: #628cb6;
            cursor: pointer;
            margin-top: 7px;
            -webkit-border-radius: .75em;
            -moz-border-radius: .75em;
            border-radius: .75em;
        }

        a.info:before {
            content: "i";
            position: absolute;
            top: .25em;
            left: 0;
            text-indent: 0;
            display: block;
            width: 1.5em;
            text-align: center;
            font-family: monospace;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
            width: 100%;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #cacaca;
        }

        .select2-selection {
            height: 40px !important;
            padding-top: 5px !important;
            outline: none;
        }

        .select2-selection
        {
            height: 35px !important;
            padding-top: 0 !important;
            display: flex !important;
            align-items: center;
            justify-content: space-between;
        }

        .select2-selection__arrow {
            top: 7.5px !important;
        }

        .select2-selection__arrow
        {
            top: 0 !important;
            position: relative;
            height: 100% !important;
        }

        .appointment_start, .appointment_end
        {
            background-color: white !important;
        }

        .bootstrap-datetimepicker-widget .row:first-child
        {
            display: flex;
            align-items: center;
        }

    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script>

        $(".appointment_type").change(function () {

            var type = $(this).val();

            if(type == 1)
            {
                $('.customer_box').hide();
                $('.quotation_box').show();

                $('.appointment_client').val('');
                $('.appointment_client').trigger('change.select2');
            }
            else
            {
                $('.quotation_box').hide();
                $('.customer_box').show();

                $('.appointment_quotation_number').val('');
                $('.appointment_quotation_number').trigger('change.select2');
            }

        });

        $(".submit_appointmentForm").click(function () {

            var validation = $('#addAppointmentModal').find('.modal-body').find('.validation_required');

            var flag = 0;

            var title = $('.appointment_title').val();
            var event_type = $('.appointment_type').val();
            var appointment_quotation_id = $('.appointment_quotation_number').val();
            var customer_id = $('.appointment_client').val();

            if (!title) {
                flag = 1;
                $('.appointment_title_box .select2-container--default .select2-selection--single').css('border-color', 'red');
            }
            else {
                $('.appointment_title_box .select2-container--default .select2-selection--single').css('border-color', '#cacaca');
            }

            if(event_type == 1)
            {
                if(!appointment_quotation_id)
                {
                    flag = 1;
                    $('.quotation_box .select2-container--default .select2-selection--single').css('border-color', 'red');
                }
                else
                {
                    $('.quotation_box .select2-container--default .select2-selection--single').css('border-color', '#cacaca');
                }
            }
            else
            {
                if(!customer_id)
                {
                    flag = 1;
                    $('.customer_box .select2-container--default .select2-selection--single').css('border-color', 'red');
                }
                else
                {
                    $('.customer_box .select2-container--default .select2-selection--single').css('border-color', '#cacaca');
                }
            }

            $(validation).each(function(){

                if(!$(this).val())
                {
                    $(this).css('border','1px solid red');
                    flag = 1;
                }
                else
                {
                    $(this).css('border','');
                }

            });

            if(!flag)
            {
                var id = $('#event_id').val();
                var title = $('.appointment_title').val();
                var appointment_start = $('.appointment_start').val();
                var appointment_end = $('.appointment_end').val();
                var format_start = new Date(appointment_start);
                var format_end = new Date(appointment_end);
                var appointment_desc = $('.appointment_description').val();
                var appointment_tags = $('.appointment_tags').val();

                if (format_start <= format_end){

                    $('.appointment_end').css('border','');

                    var appointments = $('.appointment_data').val();

                    if(appointments)
                    {
                        var data_array = JSON.parse(appointments);
                    }
                    else
                    {
                        var data_array = [];
                    }

                    if(id)
                    {
                        var event = calendar.getEventById(id);
                        event.setDates(appointment_start,appointment_end);
                        event.setExtendedProp('quotation_id', appointment_quotation_id);
                        event.setExtendedProp('event_type', event_type);
                        event.setExtendedProp('retailer_client_id', customer_id);
                        event.setProp('title', title);
                        event.setExtendedProp('description',appointment_desc);
                        event.setExtendedProp('tags',appointment_tags);
                    }
                    else
                    {
                        var id = parseInt($('.appointment_id').val());
                        $('.appointment_id').val(id+1);

                        var color = 'green';

                        calendar.addEvent({
                            id: id,
                            quotation_id: appointment_quotation_id,
                            title: title,
                            start: appointment_start,
                            end: appointment_end,
                            description: appointment_desc,
                            tags: appointment_tags,
                            event_type: event_type,
                            retailer_client_id: customer_id,
                            color: color
                        });

                        var obj = {};
                        obj['id'] = id;
                        obj['quotation_id'] = appointment_quotation_id;
                        obj['title'] = title;
                        obj['start'] = appointment_start;
                        obj['end'] = appointment_end;
                        obj['description'] = appointment_desc;
                        obj['tags'] = appointment_tags;
                        obj['new'] = 1;
                        obj['default_event'] = 0;
                        obj['event_type'] = event_type;
                        obj['retailer_client_id'] = customer_id;
                        data_array.push(obj);

                        $('.appointment_data').val(JSON.stringify(data_array));
                    }

                    $('#addAppointmentModal').modal('toggle');
                    $('#event_id').val('');
                    $('.appointment_quotation_number').val('');
                    $('.appointment_title').val('');
                    $('.appointment_start').val('');
                    $('.appointment_end').val('');
                    $('.appointment_description').val('');
                    $('.appointment_client').val('');
                    $('.appointment_tags').tagsinput('removeAll');
                    $('.appointment_title').trigger('change.select2');
                    $('.appointment_quotation_number').trigger('change.select2');
                    $('.appointment_type').trigger('change.select2');
                    $('.appointment_client').trigger('change.select2');

                }
                else
                {
                    $('.appointment_end').css('border','1px solid red');
                }
            }

            return false;

        });

        $(".appointment_tags").tagsinput('items');

        $(".add-appointment").click(function () {

            $('.appointment_title').attr('disabled',false);
            $('.appointment_quotation_number').attr('disabled',false);
            $('.appointment_type').attr('disabled',false);
            $('#event_id').val('');
            $('.appointment_quotation_number').val('');
            $('.appointment_title').val('');
            $('.appointment_start').val('');
            $('.appointment_end').val('');
            $('.appointment_description').val('');
            $('.appointment_client').val('');
            $('.appointment_tags').tagsinput('removeAll');
            $('.appointment_title').trigger('change.select2');
            $('.appointment_quotation_number').trigger('change.select2');
            $('.appointment_type').trigger('change.select2');
            $('.appointment_client').trigger('change.select2');

            $('#addAppointmentModal').modal('toggle');

        });

        function edit_appointment(id)
        {
            var event = calendar.getEventById(id);
            var quotation_id = event._def.extendedProps.quotation_id;
            var title = event.title;
            var description = event._def.extendedProps.description;
            var tags = event._def.extendedProps.tags;
            var event_type = event._def.extendedProps.event_type;
            var retailer_client_id = event._def.extendedProps.retailer_client_id;
            var start = moment(event.start).format('YYYY-MM-DD HH:mm');
            var end = event.end ? moment(event.end).format('YYYY-MM-DD HH:mm') : start;

            $('#event_id').val(id);
            $('.appointment_quotation_number').val(quotation_id);
            $('.appointment_title').val(title);
            $('.appointment_start').val(start);
            $('.appointment_end').val(end);
            $('.appointment_description').val(description);
            $('.appointment_type').val(event_type);
            $('.appointment_client').val(retailer_client_id);
            $('.appointment_tags').tagsinput('removeAll');
            $('.appointment_tags').tagsinput('add',tags);

            if(event._def.extendedProps.default_event != 1)
            {
                $('.appointment_title').attr('disabled',false);
                $('.appointment_quotation_number').attr('disabled',false);
                $('.appointment_type').attr('disabled',false);
            }
            else
            {
                $('.appointment_title').attr('disabled',true);
                $('.appointment_quotation_number').attr('disabled',true);
                $('.appointment_type').attr('disabled',true);
            }


            $('.appointment_title').trigger('change.select2');
            $('.appointment_type').trigger('change.select2');
            $('.appointment_quotation_number').trigger('change.select2');
            $('.appointment_client').trigger('change.select2');
            $('.appointment_type').trigger('change');

            $('#addAppointmentModal').modal('toggle');
        }

        function remove_appointment(id)
        {
            var event = calendar.getEventById(id);

            if(event._def.extendedProps.default_event != 1)
            {
                event.remove();
                var appointments = $('.appointment_data').val();

                if(appointments)
                {
                    appointments = JSON.parse(appointments);
                }
                else
                {
                    appointments = [];
                }

                for(var i = 0; i < appointments.length; i++) {
                    if(appointments[i].id == id) {
                        appointments.splice(i, 1);
                        break;
                    }
                }

                if(jQuery.isEmptyObject(appointments))
                {
                    $('.appointment_data').val('');
                }
                else
                {
                    $('.appointment_data').val(JSON.stringify(appointments));
                }
            }
        }

        var calendar = '';

        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialDate: new Date(),
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectMirror: true,
                select: function(arg) {

                    $(".add-appointment").trigger("click");
                    calendar.unselect()
                },
                eventChange: function(arg) {

                    var default_event = arg.event._def.extendedProps.default_event;
                    var quotation_id = arg.event._def.extendedProps.quotation_id;
                    var title = arg.event._def.title;
                    var description = arg.event._def.extendedProps.description;
                    var tags = arg.event._def.extendedProps.tags;
                    var retailer_client_id = arg.event._def.extendedProps.retailer_client_id;
                    var event_type = arg.event._def.extendedProps.event_type;
                    var start = new Date(arg.event._instance.range.start.toLocaleString('en-US', { timeZone: 'UTC' }));
                    var end = new Date(arg.event._instance.range.end.toLocaleString('en-US', { timeZone: 'UTC' }));

                    var start_date = new Date(start);
                    var curr_date = (start_date.getDate()<10?'0':'') + start_date.getDate();
                    var curr_month = start_date.getMonth() + 1;
                    curr_month = (curr_month<10?'0':'') + curr_month;
                    var curr_year = start_date.getFullYear();
                    var hour = (start_date.getHours()<10?'0':'') + start_date.getHours();
                    var minute = (start_date.getMinutes()<10?'0':'') + start_date.getMinutes();
                    start = curr_year+"-"+curr_month+"-"+curr_date+" "+hour+":"+minute;

                    var end_date = new Date(end);
                    var curr_date = (end_date.getDate()<10?'0':'') + end_date.getDate();
                    var curr_month = end_date.getMonth() + 1;
                    curr_month = (curr_month<10?'0':'') + curr_month;
                    var curr_year = end_date.getFullYear();
                    var hour = (end_date.getHours()<10?'0':'') + end_date.getHours();
                    var minute = (end_date.getMinutes()<10?'0':'') + end_date.getMinutes();
                    end = curr_year+"-"+curr_month+"-"+curr_date+" "+hour+":"+minute;

                    var id = arg.event._def.publicId;
                    var data = $('.appointment_data').val();
                    var appointments = data ? JSON.parse(data) : '';

                    for(var i = 0; i < appointments.length; i++) {

                        if(appointments[i].id == id) {

                            appointments[i]['title'] = title;
                            appointments[i]['start'] = start;
                            appointments[i]['end'] = end;
                            appointments[i]['description'] = description;
                            appointments[i]['tags'] = tags;
                            appointments[i]['default_event'] = default_event;
                            appointments[i]['quotation_id'] = quotation_id;
                            appointments[i]['event_type'] = event_type;
                            appointments[i]['retailer_client_id'] = retailer_client_id;

                            $('.appointment_data').val(JSON.stringify(appointments));
                            break;
                        }

                    }

                },
                eventContent: function (arg) {

                },
                eventDidMount: function (arg)
                {
                    var actualAppointment = $(arg.el);
                    var event = arg.event;

                    if(event._def.extendedProps.default_event != 1)
                    {
                        var buttonsHtml = '<div class="fc-buttons">' + '<button type="button" class="btn btn-default edit-event" title="Edit"><i class="fa fa-pencil"></i></button>' + '<button class="btn btn-default remove-event" title="Remove"><i class="fa fa-trash"></i></button>' + '</div>';
                    }
                    else
                    {
                        var buttonsHtml = '<div class="fc-buttons">' + '<button type="button" class="btn btn-default edit-event" title="Edit"><i class="fa fa-pencil"></i></button>' + '</div>';
                    }

                    actualAppointment.append(buttonsHtml);

                    actualAppointment.find(".edit-event").on('click', function () {
                        edit_appointment(event.id);
                    });

                    actualAppointment.find(".remove-event").on('click', function () {
                        remove_appointment(event.id);
                    });
                },
                eventClick: function(arg) {

                },
                displayEventEnd: true,
                editable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                events: {!! $plannings !!},
                // events: [
                // 	{
                // 		id: 1,
                // 		title: 'All Day Event',
                // 		start: '2022-06-01',
                // 	},
                // 	{
                // 		id: 2,
                // 		title: 'Long Event',
                // 		start: '2022-06-07',
                // 		end: '2022-06-10'
                // 	},
                // 	{
                // 		id: 3,
                // 		classNames: 'delivery_date',
                // 		title: 'Delivery Date',
                // 		start: '2022-06-09T16:00:00',
                // 		durationEditable: false
                // 	},
                // 	{
                // 		id: 4,
                // 		classNames: 'non_removeables',
                // 		title: 'Repeating Event',
                // 		start: '2022-06-16T16:00:00',
                // 		editable: false,
                // 		droppable: false,
                // 		eventStartEditable: false,
                // 		eventResizableFromStart: false,
                // 		eventDurationEditable: false
                // 	},
                // 	{
                // 		id: 5,
                // 		classNames: 'installation_date',
                // 		title: 'Installation Date',
                // 		start: '2022-06-11T00:00:00',
                // 		end: '2022-06-13T00:00:00'
                // 	},
                // 	{
                // 		id: 6,
                // 		title: 'Meeting',
                // 		start: '2022-06-12T10:30:00',
                // 		end: '2022-06-12T12:30:00'
                // 	},
                // 	{
                // 		id: 7,
                // 		title: 'Lunch',
                // 		start: '2022-06-12T12:00:00'
                // 	},
                // 	{
                // 		id: 8,
                // 		title: 'Meeting',
                // 		start: '2022-06-12T14:30:00'
                // 	},
                // 	{
                // 		id: 9,
                // 		title: 'Happy Hour',
                // 		start: '2022-06-12T17:30:00'
                // 	},
                // 	{
                // 		id: 10,
                // 		title: 'Dinner',
                // 		start: '2022-06-12T20:00:00'
                // 	},
                // 	{
                // 		id: 11,
                // 		title: 'Birthday Party',
                // 		start: '2022-06-13T07:00:00'
                // 	},
                // 	{
                // 		id: 12,
                // 		title: 'Click for Google',
                // 		url: 'http://google.com/',
                // 		start: '2022-06-28'
                // 	}
                // ]
            });

            calendar.render();

        });

        $(".appointment_title").select2({
            width: '100%',
            height: '200px',
            placeholder: "{{__('text.Select Event Title')}}",
            allowClear: true,
            "language": {
                "noResults": function () {
                    return '{{__('text.No results found')}}';
                }
            },
        });


        $(".appointment_type").select2({
            width: '100%',
            height: '200px',
            placeholder: "{{__('text.Select Event Type')}}",
            allowClear: false,
            "language": {
                "noResults": function () {
                    return '{{__('text.No results found')}}';
                }
            },
        });

        $(".appointment_quotation_number").select2({
            width: '100%',
            height: '200px',
            placeholder: "{{__('text.Select Quotation')}}",
            allowClear: false,
            "language": {
                "noResults": function () {
                    return '{{__('text.No results found')}}';
                }
            },
        });

        $(".appointment_client").select2({
            width: '100%',
            height: '200px',
            placeholder: "{{__('text.Select Customer')}}",
            allowClear: false,
            "language": {
                "noResults": function () {
                    return '{{__('text.No results found')}}';
                }
            },
        });

        $('.appointment_start').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            defaultDate: new Date(),
            ignoreReadonly: true,
            sideBySide: true,
        });

        $('.appointment_end').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            defaultDate: new Date(),
            ignoreReadonly: true,
            sideBySide: true,
        });

    </script>

    <link href="{{asset('assets/admin/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/bootstrap-tagsinput.css')}}" rel="stylesheet">

@endsection
