@extends('layouts.handyman')

@section('content')

    <div class="right-side">
        <div class="container-fluid">

            @include('includes.form-success')

            <div style="margin: 0;" class="row">
                <div class="col-lg-12 col-ml-12 padding-bottom-30">
                    <div style="margin: 0;" class="row">

                        <div class="col-12 mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Quotation Email Template</h4>

                                    <form action="{{route('save-email-template')}}" method="POST" enctype="multipart/form-data">

                                        {{csrf_field()}}

                                        <input type="hidden" name="type" value="1">
                                        <input type="hidden" name="template_id" value="{{isset($quotation_email_template) ? $quotation_email_template->id : null}}">

                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input type="text" value="{{isset($quotation_email_template) ? $quotation_email_template->subject : null}}" name="mail_subject" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label for="site_global_email_template">Email Template</label>
                                            <input type="hidden" name="mail_body" value="{{isset($quotation_email_template) ? $quotation_email_template->body : null}}">
                                            <div class="summernote">{!! isset($quotation_email_template) ? $quotation_email_template->body : null !!}</div>
                                            <small class="form-text text-muted">Variable like {name} will be replaced by name of user.</small>
                                        </div>

                                        <button type="button" class="btn btn-primary mt-4 pr-4 pl-4 submit-form">Update Changes</button>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Order Email Template</h4>

                                    <form action="{{route('save-email-template')}}" method="POST" enctype="multipart/form-data">

                                        {{csrf_field()}}

                                        <input type="hidden" name="type" value="2">
                                        <input type="hidden" name="template_id" value="{{isset($order_email_template) ? $order_email_template->id : null}}">

                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input type="text" value="{{isset($order_email_template) ? $order_email_template->subject : null}}" name="mail_subject" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label for="site_global_email_template">Email Template</label>
                                            <input type="hidden" name="mail_body" value="{{isset($order_email_template) ? $order_email_template->body : null}}">
                                            <div class="summernote">{!! isset($order_email_template) ? $order_email_template->body : null !!}</div>
                                            <small class="form-text text-muted">Variable like {name} will be replaced by name of user.</small>
                                        </div>

                                        <button type="button" class="btn btn-primary mt-4 pr-4 pl-4 submit-form">Update Changes</button>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Invoice Email Template</h4>

                                    <form action="{{route('save-email-template')}}" method="POST" enctype="multipart/form-data">

                                        {{csrf_field()}}

                                        <input type="hidden" name="type" value="3">
                                        <input type="hidden" name="template_id" value="{{isset($invoice_email_template) ? $invoice_email_template->id : null}}">

                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input type="text" value="{{isset($invoice_email_template) ? $invoice_email_template->subject : null}}" name="mail_subject" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label for="site_global_email_template">Email Template</label>
                                            <input type="hidden" name="mail_body" value="{{isset($invoice_email_template) ? $invoice_email_template->body : null}}">
                                            <div class="summernote">{!! isset($invoice_email_template) ? $invoice_email_template->body : null !!}</div>
                                            <small class="form-text text-muted">Variable like {name} will be replaced by name of user.</small>
                                        </div>

                                        <button type="button" class="btn btn-primary mt-4 pr-4 pl-4 submit-form">Update Changes</button>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>

        .note-toolbar
        {
            line-height: 1.5;
        }

        .right-side
        {
            background: white;
        }

        .padding-bottom-30
        {
            padding-bottom: 30px;
        }

        .mt-5, .my-5
        {
            margin-top: 3rem!important;
        }

        .card
        {
            background-color: #373737;
            border: none;
            border-radius: 4px;
            position: relative;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-clip: border-box;
            box-shadow: 0 0 6px 0 #00000026;
        }

        .card-body
        {
            padding: 3.6rem 3rem;
            -webkit-box-flex: 1;
            flex: 1 1 auto;
        }

        label, .form-text
        {
            color: white;
        }

        .header-title
        {
            color: white;
            font-family: 'Lato', sans-serif;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0;
            text-transform: capitalize;
            margin-bottom: 17px;
        }

        .note-editor
        {
            margin-bottom: 10px;
        }

    </style>
@endsection

@section('scripts')

    <script>

        $(document).on('click', '.submit-form', function () {

            var subject = $(this).parent().find("[name='mail_subject']").val();
            var body = $(this).parent().find("[name='mail_body']").val();
            var flag = 0;

            if(!subject)
            {
                $(this).parent().find("[name='mail_subject']").css('border','1px solid red');
                flag = 1;
            }
            else
            {
                $(this).parent().find("[name='mail_subject']").css('border','');
            }

            if(!body)
            {
                $(this).parent().find("[name='mail_body']").parent().find('.note-editor').css('border','1px solid red');
                flag = 1;
            }
            else
            {
                $(this).parent().find("[name='mail_body']").parent().find('.note-editor').css('border','');
            }

            if(!flag)
            {
                $(this).parent().submit();
            }

        });

        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                /*['color', ['color']],*/
                ['fontname', ['fontname']],
                ['forecolor', ['forecolor']],
            ],
            height: 300,   //set editable area's height
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            callbacks: {
                onChange: function(contents, $editable) {
                    $(this).prev('input').val(contents);
                }
            }
        });

    </script>

@endsection
