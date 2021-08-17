@extends('layouts.handyman')

@section('content')
    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard area -->
                    <div style="padding: 0;" class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header">
                                        <h2>{{isset($customer) ? __('text.Edit Customer') : __('text.Create Customer')}}</h2>
                                        <a href="{{route('customers')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> {{__('text.Back')}}</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('post-create-customer')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')
                                        {{csrf_field()}}

                                        <input type="hidden" name="org_id" value="{{isset($customer->id) ? $customer->id : null}}">

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="">{{__('text.Name')}}*</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{isset($customer->name) ? $customer->name : null}}" name="name" id="name" placeholder="" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="">{{__('text.Family Name')}}*</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{isset($customer->family_name) ? $customer->family_name : null}}" name="family_name" id="family_name" placeholder="" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="">{{__('text.Business Name')}}</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{isset($customer->business_name) ? $customer->business_name : null}}" name="business_name" id="business_name" placeholder="" type="text">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="address">{{__('text.Address')}}</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{isset($customer->address) ? $customer->address : null}}" name="address" id="address" placeholder="" type="text">
                                                <input type="hidden" id="check_address" value="0">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="address">{{__('text.Postcode')}}</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{isset($customer->postcode) ? $customer->postcode : null}}" name="postcode" id="postcode" placeholder="" readonly type="text">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="city">{{__('text.City')}}</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{isset($customer->city) ? $customer->city : null}}" name="city" id="city" placeholder="" readonly type="text">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="phone">{{__('text.Contact Number')}}*</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{isset($customer->phone) ? $customer->phone : null}}" name="phone" id="phone" placeholder="" required="" type="text">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="email">{{__('text.Email')}}*</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{isset($customer->email) ? $customer->email : null}}" {{isset($customer) ? 'readonly' : null}} name="email" id="email" placeholder="" required="" type="email">
                                            </div>
                                        </div>

                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" id="submit" type="submit" class="btn add-product_btn">{{isset($customer) ? __('text.Edit Customer') : __('text.Create Customer')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard area -->
                </div>
            </div>
        </div>
    </div>
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

    </script>


@endsection
