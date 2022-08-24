@extends('layouts.client')

@section('styles')

    <link href="{{asset('assets/admin/css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>



@endsection

@section('content')


    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard header items area -->
                    <div class="panel panel-default admin">
                        <div class="panel-heading admin-title">{{$lang->edit}}</div>

                    </div>
                    <!-- Ending of Dashboard header items area -->

                    <!-- Starting of Dashboard Top reference + Most Used OS area -->
                    <div class="reference-OS-area">
                        <div class="donors-profile-top-bg overlay text-center wow fadeInUp"
                             style="background-image: url({{asset('assets/images/'.$gs->c_dashbg)}}); visibility: visible; animation-name: fadeInUp;z-index: auto;color: black;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>{{$user->name}} {{$user->family_name}}</h2>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-fillup-wrap wow fadeInUp"
                             style="visibility: visible; animation-name: fadeInUp;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form class="form-horizontal" id="form"
                                              action="{{route('client-profile-update',$user->id)}}" method="POST"
                                              enctype="multipart/form-data">
                                            @include('includes.form-success')
                                            @include('includes.form-error')
                                            {{csrf_field()}}
                                            <div class="profile-filup-description-box margin-bottom-30">
                                                <div class="form-group">
                                                    <label for="first_name"
                                                           class="col-sm-3 control-label">{{$lang->suf}}*</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" id="first_name" name="name"
                                                               placeholder="{{$lang->suf}}" type="text"
                                                               value="{{$user->name}}" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="family_name"
                                                           class="col-sm-3 control-label">{{$lang->fn}}*</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" id="family_name" name="family_name"
                                                               placeholder="{{$lang->fn}}" type="text"
                                                               value="{{$user->family_name}}" required="">
                                                    </div>
                                                </div>

                                                @if($user->photo)

                                                    <div class="form-group">
                                                        <label for="current_photo"
                                                               class="col-sm-3 control-label">{{$lang->cup}}*</label>
                                                        <div class="col-sm-8">

                                                            <img width="130px" height="90px" id="adminimg"
                                                                 src="{{asset('assets/images/'.$user->photo)}}"
                                                                 alt="" id="adminimg">

                                                        </div>
                                                    </div>

                                                @endif

                                                <div class="form-group">
                                                    <label for="profile_photo"
                                                           class="col-sm-3 control-label">{{$lang->pp}}*</label>
                                                    <div class="col-sm-8">
                                                        <input type="file" id="uploadFile" class="hidden" name="photo"
                                                               value="">
                                                        <button type="button" id="uploadTrigger" onclick="uploadclick()"
                                                                class="form-control"><i
                                                                class="fa fa-download"></i> {{$lang->app}}</button>
                                                        <p>{{$lang->size}}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="address" class="col-sm-3 control-label">{{$lang->doad}}
                                                        *</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" name="address" id="address"
                                                               placeholder="{{$lang->doad}}" type="text"
                                                               value="{{$user->address}}" required="">
                                                        <input type="hidden" id="check_address" value="1">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="postal_code"
                                                           class="col-sm-3 control-label">{{$lang->pc}}</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" id="postcode" name="postcode" readonly
                                                               placeholder="{{$lang->pc}}" type="text"
                                                               value="{{$user->postcode}}">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="city" class="col-sm-3 control-label">{{$lang->doct}}
                                                        *</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" name="city" id="city" readonly
                                                               placeholder="{{$lang->doct}}" type="text"
                                                               value="{{$user->city}}" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="phone" class="col-sm-3 control-label">{{$lang->doph}}
                                                        *</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" name="phone" id="phone"
                                                               placeholder="{{$lang->doph}}" type="text"
                                                               value="{{$user->phone}}" required="">
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="phone" class="col-sm-3 control-label">Email*</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" name="em" id="em"
                                                               placeholder="Email" type="text" value="{{$user->email}}"
                                                               readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="business_name"
                                                           class="col-sm-3 control-label">{{$lang->bn}}</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" id="business_name"
                                                               name="business_name" placeholder="{{$lang->bn}}"
                                                               type="text" value="{{$user->business_name}}">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="tax_number"
                                                           class="col-sm-3 control-label">{{__('text.Tax number')}}</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" id="tax_number"
                                                               name="tax_number" placeholder="{{__('text.Tax number')}}"
                                                               type="text" value="{{$user->tax_number}}">
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: none;">
                                                    <label for="profile_description"
                                                           class="col-sm-3 control-label">{{$lang->dopd}}</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" name="description"
                                                                  id="profile_description" rows="5"
                                                                  style="resize: vertical;">{{$user->description}}</textarea>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="profile-filup-description-box margin-bottom-30" style="display: none;">

                                                <div class="form-group" style="display: none;">
                                                    <label for="age" class="col-sm-3 control-label">{{$lang->doa}}
                                                        *</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" name="age" id="age"
                                                               placeholder="{{$lang->doa}}" type="text"
                                                               value="{{$user->age}}" value="0">
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="edu"
                                                           class="col-sm-3 control-label">{{$lang->doe}}</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" name="education" id="edu"
                                                               placeholder="{{$lang->doe}}" type="text"
                                                               value="{{$user->education}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="lang"
                                                           class="col-sm-3 control-label">{{$lang->dol}}</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" name="language" id="lang"
                                                               placeholder="{{$lang->dol}}" type="text"
                                                               value="{{$user->language}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="prof"
                                                           class="col-sm-3 control-label">{{$lang->dopr}}</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" name="profession" id="prof"
                                                               placeholder="{{$lang->dopr}}" type="text"
                                                               value="{{$user->profession}}">
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="email"
                                                           class="col-sm-3 control-label">{{$lang->doeml}}</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" name="web" id="web"
                                                               placeholder="Website" type="text"
                                                               value="{{$user->web}}">
                                                    </div>
                                                </div>


                                            </div>


                                            <div class="submit-area margin-bottom-30">
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="form-group text-center">
                                                            <button class="boxed-btn blog"
                                                                    type="submit">{{$lang->doupl}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>





    <style>

        .container {
            width: 100% !important;
        }

        #edit {
            color: #fff;
            background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.70)':$gs->colors.'c2'}};

        }


    </style>


    <style>

        .swal2-show {
            font-size: 17px;
        }
    </style>


@endsection



@section('scripts')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&libraries=places&callback=initMap" async defer></script>


    <script type="text/javascript">

        function initMap() {

            var input = document.getElementById('address');

            var options = {
                componentRestrictions: {country: "nl"}
            };

            var autocomplete = new google.maps.places.Autocomplete(input,options);

            // Set the data fields to return when the user selects a place.
            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

            autocomplete.addListener('place_changed', function() {

                var flag = 0;

                var place = autocomplete.getPlace();

                if (!place.geometry) {

                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("{{__('text.No details available for input: ')}}" + place.name);
                    return;
                }
                else
                {
                    var string = $('#address').val().substring(0, $('#address').val().indexOf(',')); //first string before comma

                    if(string)
                    {
                        var is_number = $('#address').val().match(/\d+/);

                        if(is_number === null)
                        {
                            flag = 1;
                        }
                    }
                }

                var city = '';
                var postal_code = '';

                for(var i=0; i < place.address_components.length; i++)
                {
                    if(place.address_components[i].types[0] == 'postal_code')
                    {
                        postal_code = place.address_components[i].long_name;
                    }

                    if(place.address_components[i].types[0] == 'locality')
                    {
                        city = place.address_components[i].long_name;
                    }

                }


                if(city == '')
                {
                    for(var i=0; i < place.address_components.length; i++)
                    {
                        if(place.address_components[i].types[0] == 'administrative_area_level_2')
                        {
                            city = place.address_components[i].long_name;

                        }
                    }
                }

                if(postal_code == '' || city == '')
                {
                    flag = 1;
                }

                if(!flag)
                {
                    $('#check_address').val(1);
                    $("#address-error").remove();
                    $('#postcode').val(postal_code);
                    $("#city").val(city);
                }
                else
                {
                    $('#address').val('');
                    $('#postcode').val('');
                    $("#city").val('');

                    $("#address-error").remove();
                    $('#address').parent().append('<small id="address-error" style="color: red;display: block;margin-top: 10px;">{{__('text.Kindly write your full address with house/building number so system can detect postal code and city from it!')}}</small>');
                }

            });
        }

        $("#address").on('input',function(e){
            $(this).next('input').val(0);
        });

        $("#address").focusout(function(){

            var check = $(this).next('input').val();

            if(check == 0)
            {
                $(this).val('');
                $('#postcode').val('');
                $("#city").val('');
            }
        });

        function uploadclick() {
            $("#uploadFile").click();
            $("#uploadFile").change(function (event) {
                readURL(this);
                $("#uploadTrigger").html($("#uploadFile").val());
            });

        }


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#adminimg').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>



    <script src="{{asset('assets/admin/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>



    <script type="text/javascript">
        $(document).ready(function () {
            $("#myTags").tagit({
                fieldName: "special[]",
                allowSpaces: true
            });
        });
    </script>



@endsection
