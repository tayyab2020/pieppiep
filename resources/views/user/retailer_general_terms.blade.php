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
                                    <h3 class="header-title">{{__('text.General Terms')}}</h3>

                                    <form action="{{route('save-retailer-general-terms')}}" method="POST" enctype="multipart/form-data">

                                        {{csrf_field()}}

                                        <input type="hidden" name="id" value="{{isset($general_terms) ? $general_terms->id : null}}">

                                        <!-- <div style="display: flex;width: 15%;justify-content: space-between;margin: 20px 0;" class="form-group">
                                            <label style="margin: 0;">{{__('text.Show in quote')}}</label>
                                            <div style="display: flex;justify-content: center;align-items: center;margin-left: 10px;">
                                                <label style="margin: 0;" class="switch">
                                                    <input class="show_quote" name="show_quote" {{isset($general_terms) ? ($general_terms->show_quote ? 'checked' : null) : null}} type="checkbox">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div style="display: flex;width: 15%;justify-content: space-between;margin: 20px 0;" class="form-group">
                                            <label style="margin: 0;">{{__('text.Show in invoice')}}</label>
                                            <div style="display: flex;justify-content: center;align-items: center;margin-left: 10px;">
                                                <label style="margin: 0;" class="switch">
                                                    <input class="show_invoice" name="show_invoice" {{isset($general_terms) ? ($general_terms->show_invoice ? 'checked' : null) : null}} type="checkbox">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div> -->

                                        <div class="form-group">
                                            <input type="hidden" name="description" value="{{isset($general_terms) ? $general_terms->description : ''}}">
                                            <div class="summernote">{!! isset($general_terms) ? $general_terms->description : '' !!}</div>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 submit-form">{{__('text.Update Changes')}}</button>
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

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 13px;
            width: 13px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

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
            background-color: #f5f5f5;
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
            box-shadow: 0 0 4px -1px #00000047;
        }

        .card-body
        {
            padding: 3.6rem 3rem;
            -webkit-box-flex: 1;
            flex: 1 1 auto;
        }

        label, .form-text
        {
            color: black;
        }

        .header-title
        {
            color: black;
            font-family: 'Lato', sans-serif;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 0;
            text-transform: capitalize;
            margin-bottom: 35px;
        }

        .note-editor
        {
            margin-bottom: 10px;
        }

    </style>
@endsection

@section('scripts')

    <script>

        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                /*['color', ['color']],*/
                ['fontname', ['fontname']],
                ['forecolor', ['forecolor']],
                ['backcolor', ['backcolor']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['fullscreen', 'codeview']],
                ['insert', ['link', 'picture', 'video']],
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
