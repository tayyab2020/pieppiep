@extends('layouts.front_new')

@section('head_title', '')
@section('head_keywords', $seo->meta_keys)
@section('head_description', '')

@section('content')

@include('styles.design')

<style>

  .input-group
  {
    position: relative;
    display: table !important;
    border-collapse: separate;
  }

  .input-group-addon:first-child
  {
    border-right: 0;
  }

  .input-group-addon
  {
    padding: 6px 12px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1;
    text-align: center;
    border: 1px solid #ccc;
  }

  .input-group-addon, .input-group-btn
  {
    width: 1%;
    white-space: nowrap;
    vertical-align: middle;
  }

  .input-group .form-control, .input-group-addon, .input-group-btn
  {
    display: table-cell;
  }

  .input-group .form-control:last-child, .input-group-addon:last-child, .input-group-btn:first-child>.btn-group:not(:first-child)>.btn, .input-group-btn:first-child>.btn:not(:first-child), .input-group-btn:last-child>.btn, .input-group-btn:last-child>.btn-group>.btn, .input-group-btn:last-child>.dropdown-toggle
  {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }

  .login-form .form-control
  {
    height: 40px;
    border-radius: 2px;
    box-shadow: none;
  }

  .input-group .form-control
  {
    position: relative;
    z-index: 2;
    float: left;
    width: 100% !important;
    margin-bottom: 0;
  }

</style>

@if(Session::has('message'))
   <div class="alert alert-danger" style="font-size: 20px;margin: 0;text-align: center;position: relative;top: 100px;">{{ Session::get('message') }}</div>
@elseif(Session::has('success'))
  <div class="alert alert-success" style="font-size: 20px;margin: 0;text-align: center;position: relative;top: 100px;">{{ Session::get('success') }}</div>
@endif

<section style="padding: 200px 0 0 0;" class="login-area">

            <div class="container">
                <div style="justify-content: center;" class="row">
                    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12">
                        <div class="login-form">
                            <div class="login-icon"><i class="fa fa-user"></i></div>

                            <div class="section-borders">
                                <span></span>
                                <span class="black-border"></span>
                                <span></span>
                            </div>

                            <div class="login-title text-center">{{__('text.Signup')}}</div>

                            <form action="{{route('handyman-register-submit')}}" method="POST">
                              {{csrf_field()}}
                              @include('includes.form-error')
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-user"></i>
                                  </div>
                                  <input name="name" class="form-control" placeholder="{{$lang->suf}}" type="text" value="{{ old('name') }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-user"></i>
                                  </div>
                                  <input name="family_name" class="form-control" placeholder="{{$lang->fn}}" type="text" value="{{ old('family_name') }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-user"></i>
                                  </div>
                                  <input name="registration_number" class="form-control" placeholder="{{$lang->rg}}" type="text" value="{{ old('registration_number') }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-user"></i>
                                  </div>
                                  <input name="company_name" class="form-control" placeholder="{{$lang->compname}}" type="text" value="{{ old('company_name') }}">
                                </div>
                              </div>


                              <div class="form-group">
                                <div id="ad_box1" class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-user"></i>
                                  </div>
                                    <input name="address" id="address" class="form-control" placeholder="{{$lang->ad}}" type="text" value="{{ old('address') }}">
                                    <input type="hidden" id="check_address" value="0">
                                </div>
                              </div>

                                <div class="form-group">
                                    <div id="pc_box" class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input name="postcode" id="postcode" readonly class="form-control" placeholder="{{$lang->pct}}" type="text" value="{{ old('postcode') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div id="ct_box" class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input name="city" id="city" class="form-control" placeholder="{{$lang->ct}}" readonly type="text" value="{{ old('city') }}">
                                    </div>
                                </div>

                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-user"></i>
                                  </div>
                                  <input name="phone" class="form-control" placeholder="{{$lang->pn}}" type="number" value="{{ old('phone') }}">
                                </div>
                              </div>

                              {{--<div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-user"></i>
                                  </div>
                                  <input name="tax_number" class="form-control" placeholder="{{$lang->tn}}" type="text" value="{{ old('tax_number') }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-user"></i>
                                  </div>
                                  <input name="bank_account" class="form-control" placeholder="{{$lang->ba}}" type="text" value="{{ old('bank_account') }}">
                                </div>
                              </div>--}}

                              <input type="hidden" name="category_id" value="20">


                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <select class="form-control" name="role_id">
                                            <option {{ old('role_id') == 2 ? 'selected' : null }} value="2">Retailer</option>
                                            <option {{ old('role_id') == 4 ? 'selected' : null }} value="4">Supplier</option>
                                        </select>
                                    </div>
                                </div>

                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-envelope"></i>
                                  </div>
                                  <input name="email" class="form-control" placeholder="{{$lang->sue}}" type="email" value="{{ old('email') }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                        <i class="fa fa-unlock-alt"></i>
                                    </div>
                                  <input class="form-control" name="password" placeholder="{{$lang->sup}}" type="password">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                        <i class="fa fa-unlock-alt"></i>
                                    </div>
                                  <input class="form-control" name="password_confirmation" placeholder="{{$lang->sucp}}" type="password">
                                </div>
                              </div>



                                  <div class="g-recaptcha" data-sitekey="{{config('app.captcha_key')}}" style="display: table;margin: auto;margin-bottom: 40px;margin-top: 40px;"></div>
                                  <!-- @if($errors->has('g-recaptcha-response'))
                                  <span class="invalid-feedback" style="display: block;text-align: center;margin-bottom: 40px;">
                                    <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                                  </span>
                                  @endif -->

                                  <div style="margin: auto;margin-bottom: 40px;margin-top:30px;width: 50%;text-align: center;">

                                  <input type="checkbox" name="terms" id="terms" required> <span style="position: relative;bottom: 2px;"> {{$lang->iagt}} <a target="_blank" href="/algemene-voorwaarden-consumenten" style="color: blue;">{{$lang->tact}}</a></span>
                            </div>

                              <div class="form-group text-center">
                                    <button type="submit" class="btn login-btn" name="button">{{$lang->cnf_btn}}</button>
                              </div>
                              <div class="form-group text-center">
                                    <a href="{{route('user-login')}}">{{$lang->al}}</a>
                              </div>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
        </section>

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
                var string = $('#ad_box1 #address').val().substring(0, $('#ad_box1 #address').val().indexOf(',')); //first string before comma

                if(string)
                {
                    var is_number = $('#ad_box1 #address').val().match(/\d+/);

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
                $('#ad_box1 #check_address').val(1);
                $("#ad_box1").next('#address-error').remove();
                $('#pc_box #postcode').val(postal_code);
                $("#ct_box #city").val(city);
            }
            else
            {
                $('#ad_box1 #address').val('');
                $('#pc_box #postcode').val('');
                $("#ct_box #city").val('');

                $("#ad_box1").next('#address-error').remove();
                $('#ad_box1 #address').parent().parent().append('<small id="address-error" style="color: red;display: block;margin-top: 10px;">{{__('text.Kindly write your full address with house/building number so system can detect postal code and city from it!')}}</small>');
            }

        });
    }

    $("#ad_box1 #address").on('input',function(e){
        $(this).next('input').val(0);
    });

    $("#ad_box1 #address").focusout(function(){

        var check = $(this).next('input').val();

        if(check == 0)
        {
            $(this).val('');
            $('#pc_box #postcode').val('');
            $("#ct_box #city").val('');
        }
    });

</script>
@endsection
