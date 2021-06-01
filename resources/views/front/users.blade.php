@extends('layouts.front')
@section('styles')
<style type="text/css">
    /* Hide the list on focus of the input field */
datalist {
    display: none;
}
/* specifically hide the arrow on focus */
input::-webkit-calendar-picker-indicator {
    display: none;
}
</style>
@endsection
@section('content')
<div class="hero-area overlay" style="background-image: url({{asset('assets/images/'.$gs->bgimg)}});z-index: auto;color: black;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="donors-header text-center" style="color: black;margin-left: 130px;">{{$lang->vt}}</h1>
                        <div class="hero-form">
                            <div class="hero-form-wrapper inline">
                                <form action="{{route('user.search')}}" method="GET">
                                    <div class="row">




                                        <div class="col-md-6" id="zip">
                                            <div class="form-group" id="zipbox">
                                            <div class="input-group">
                                              <div class="input-group-addon">
                                                  <i class="fa fa-fw fa-home"></i>
                                              </div>
                                      <input type="search" name="zipcode" id="zipcode" class="form-control" placeholder="{{$lang->spzc}}" autocomplete="off" required >


                                            </div>
                                          </div>


                                        </div>

                                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&libraries=places&callback=initMap" async defer></script>

                                      <script type="text/javascript">



                                          function initMap() {


  var input = document.getElementById('zipcode');


   var options = {
  componentRestrictions: {country: "nl"}
 };

  var autocomplete = new google.maps.places.Autocomplete(input,options);




  // Set the data fields to return when the user selects a place.
  autocomplete.setFields(
      ['address_components', 'geometry', 'icon', 'name']);


  autocomplete.addListener('place_changed', function() {


    var place = autocomplete.getPlace();





    if (!place.geometry) {

      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("{{__('text.No details available for input: ')}}" + place.name);
      return;
    }

    var city = '';

    for(var i=0; i < place.address_components.length; i++)
    {



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

            var city = place.address_components[i].long_name;

        }


    }

    }



    });


}

</script>

                                         <div class="col-md-6">

                                            <div class="form-group">
                                        <div class="input-group" id="service_box" style="height: 50px;">
                                          <div class="input-group-addon">
                                              <i class="fa fa-fw fa-cog"></i>
                                          </div>

                                            <select class="js-data-example-ajax form-control"  style="width: 100%" name="group" id="blood_grp" required>

                                                <option value="">{{$lang->sbg}}</option>


                                                @foreach($cats as $cat)



                                                    <option value="{{$cat->id}}" >{{$cat->cat_name}}</option>



                                                @endforeach
                                            </select>

                                        </div>
                                      </div>

                                         </div>



                                        <div class="col-md-6" style="margin-top: 10px;">

                                            <div class="form-group" >
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                              <i class="fa fa-fw fa-calendar"></i>
                                          </div>

                                         <input  type="text" name="from_date" id="from_date" class="form-control" placeholder="{{$lang->spdf}}" autocomplete="off"  required >


                                        </div>
                                      </div>



                                        </div>


                                        <div class="col-md-6" style="margin-top: 10px;">

                                            <div class="form-group" >
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                              <i class="fa fa-fw fa-calendar"></i>
                                          </div>

                                         <input  type="text" name="to_date" id="to_date" class="form-control" placeholder="{{$lang->spdt}}" autocomplete="off"  required >


                                        </div>
                                      </div>

                                        </div>

                                        <div class="col-md-12" style="margin-top: 20px;">
                                            <div class="form-group text-center">
                                                <input class="btn btn-block hero-btn" name="button" value="{{$lang->search}}" type="submit">
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>



        <script type="text/javascript">

            $(document).ready(function() {


$('#from_date').datepicker({

  format: 'dd-mm-yyyy',
  startDate: new Date(),

});

$('#to_date').datepicker({

  format: 'dd-mm-yyyy',
  startDate: new Date(),

});

});



                                          $(".js-data-example-ajax").select2({
               width: '100%',
               height: '200px',
               // placeholder: "City Name",
               placeholder: "<?php echo $lang->sbg; ?>",
               allowClear: true,
               dropdownParent: $('#service_box'),
                                              "language": {
                                                  "noResults": function(){
                                                      return '{{__('text.No results found')}}';
                                                  }
                                              },


           });


                                      </script>


<div class="section-padding all-donors-wrap team_section team_style2 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div class="container">
    @foreach($users->chunk(4) as $userChunk)
                <div class="row">

                  <?php $i = 0; ?>

                    @foreach($userChunk as $ruser)
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="team_common">
                            <a href="{{route('front.user',$ruser->id)}}">
                                <div style="width: 100%;background-color: white;">
                            <div class="member_img" style="width: 50%;border: 0;display: inline-block;height: 210px;">

                                    <img src="{{ $ruser->photo ? asset('assets/images/'.$ruser->photo):asset('assets/default.jpg')}}" alt="member image" style="width: 65%;height: 180px;padding: 0px;border-radius: 100%;border:1px solid lightgrey;margin: auto;display: block;margin-top: 20px;">
                            </div>

                            <div style="display: inline-block;max-width: 45%;position: absolute;top: 80px;">
                            <p style="font-size: 18px;font-weight: bold;color: black;">{{$ruser->name}}</p>


                        </div>
                    </div>
                    </a>


                            <div class="member_info text-center pos_relative" style="height: 190px;">

                                <div class="overlay1" style="transform: rotate(0deg);top: 0px;"></div>
                                <div class="overlay2" style="top: 0px;transform: rotate(0deg);"></div>


                                <div class="content content1" style="top: -13px;">

                                    <div style="width: 33%;float: left;border-right: 1px solid #c7c0c0;margin-top: 20px;">


                                    <div style="font-size: 15px;font-weight: bold;">{{$lang->ratt}}</div>
                                    <div class="change1" style="padding: 10px;font-size: 17px;">{{$ruser->rating}} <span class="fa fa-star checked" style="margin-left: 7px;"></span></div>

                                </div>

                                <div style="width: 33%;float: left;border-right: 1px solid #c7c0c0;margin-top: 20px;">

                                    <div style="font-size: 15px;font-weight: bold;">{{$lang->jct}}</div>

                                    <div class="change1" style="padding: 10px;font-size: 17px;"><?php echo $jobs[$i][0]; ?></div>

                                </div>

                                <div style="width: 33%;float: left;margin-top: 20px;">

                                    <div style="font-size: 15px;font-weight: bold;">{{$lang->et}}</div>
                                    <div class="change1" style="padding: 10px;font-size: 17px;">@if($ruser->experience_years) {{ (int) $ruser->experience_years}} @if($ruser->experience_years > 1) {{$lang->yst}} @else {{$lang->yt1}} @endif @else N/A @endif </div>

                                </div>


                                   <div style="width: 100%;display: inline-block;">


                                    <ul class="social_contact pt_10" style="padding-left: 0px;display: inline-block;padding-top: 20px;">
                                        @if($ruser->f_url != null)
                                        <li>
                                        <a class="link1" href="{{$ruser->f_url ? $ruser->f_url:'https://www.facebook.com/'}}" title="Facebook" target="_blank" ><i class="fa fa-facebook"></i></a>
                                        </li>
                                        @endif
                                        @if($ruser->t_url != null)
                                        <li>
                                        <a class="link1" href="{{$ruser->t_url ? $ruser->t_url:'https://twitter.com/'}}" title="Twitter" target="_blank" ><i class="fa fa-twitter"></i></a>
                                        </li>
                                        @endif
                                        @if($ruser->l_url != null)
                                        <li>
                                        <a class="link1" href="{{$ruser->l_url ? $ruser->l_url:'https://www.linkedin.com/'}}" title="linkedin" target="_blank" ><i class="fa fa-linkedin"></i></a>
                                        </li>
                                        @endif
                                        @if($ruser->g_url != null)
                                        <li>
                                        <a class="link1" href="{{$ruser->g_url ? $ruser->g_url:'https://plus.google.com/'}}" title="Google-plus" target="_blank" ><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        @endif
                                    </ul>

                                    <a href="{{route('front.user',$ruser->id)}}" class="next1 round1" style="position: absolute;right: 80px;top: 115px;width: 8%;height: 20px;padding: 0;display: inline-table;"><span class="arrow1" style="font-size: 25px;">&#8250;</span></a>

                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $i++; ?>

                    @endforeach

                    <style type="text/css">

                        @media (max-width: 890px)
                        {
                            .next1
                            {
                                right: 35px !important;
                            }
                        }

                         @media (max-width: 550px)
                        {
                            .next1
                            {
                                width: 10% !important;
                            }
                        }

                        @media (max-width: 450px)
                        {
                            .next1
                            {
                                width: 12% !important;
                            }
                        }

                    </style>


                </div>
        @endforeach
            </div>
                    <div class="text-center">
                    {!! $users->links() !!}
                    </div>
        </div>

        <style type="text/css">

          @media only screen and (max-width: 991px)
          {

            .hero-area h1, .hero-area h1.donors-header{

              margin-left: 0px !important;
            }

            .hero-form{

              margin-left: 0px;
            }

            #zip{

              margin-bottom: 10px;
            }


          }

            .select2-container{

               height: 100%;
           }

           .select2-container--default .select2-selection--single{

               height: 100%;
               padding: 11px;
               border: none;
               border-radius: 0;
           }

           .select2-container--default .select2-selection--single .select2-selection__arrow{

               padding: 26px;
           }

           .select2-selection__clear{

               display: none;
           }


                [type="radio"]:checked,
[type="radio"]:not(:checked) {
    position: absolute;
    left: -9999px;
}
[type="radio"]:checked + label,
[type="radio"]:not(:checked) + label
{
    position: relative;
    padding-left: 28px;
    cursor: pointer;
    line-height: 20px;
    display: inline-block;
    color: #666;
}
[type="radio"]:checked + label:before,
[type="radio"]:not(:checked) + label:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 18px;
    height: 18px;
    border: 1px solid #ddd;
    border-radius: 100%;
    background: #fff;
}
[type="radio"]:checked + label:after,
[type="radio"]:not(:checked) + label:after {
    content: '';
    width: 12px;
    height: 12px;
    background: #c33131;
    position: absolute;
    top: 3px;
    left: 3px;
    border-radius: 100%;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}
[type="radio"]:not(:checked) + label:after {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
}
[type="radio"]:checked + label:after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
}

        </style>


        <style type="text/css">
            /*!
 * Datepicker for Bootstrap v1.5.0 (https://github.com/eternicode/bootstrap-datepicker)
 *
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */
.datepicker {
  padding: 4px;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  direction: ltr;
}
.datepicker-inline {
  width: 220px;
}
.datepicker.datepicker-rtl {
  direction: rtl;
}
.datepicker.datepicker-rtl table tr td span {
  float: right;
}
.datepicker-dropdown {
  top: 0;
  min-width: 22% !important;
}

 .table-condensed{

 width: 100%;


 }

 .datepicker td, .datepicker th
 {

  font-size: 17px;


 }
.datepicker-dropdown:before {
  content: '';
  display: inline-block;
  border-left: 7px solid transparent;
  border-right: 7px solid transparent;
  border-bottom: 7px solid #999999;
  border-top: 0;
  border-bottom-color: rgba(0, 0, 0, 0.2);
  position: absolute;
}
.datepicker-dropdown:after {
  content: '';
  display: inline-block;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-bottom: 6px solid #ffffff;
  border-top: 0;
  position: absolute;
}
.datepicker-dropdown.datepicker-orient-left:before {
  left: 6px;
}
.datepicker-dropdown.datepicker-orient-left:after {
  left: 7px;
}
.datepicker-dropdown.datepicker-orient-right:before {
  right: 6px;
}
.datepicker-dropdown.datepicker-orient-right:after {
  right: 7px;
}
.datepicker-dropdown.datepicker-orient-bottom:before {
  display: none;
  top: -7px;
}
.datepicker-dropdown.datepicker-orient-bottom:after {
  display: none;
  top: -6px;
}
.datepicker-dropdown.datepicker-orient-top:before {
  display: none;
  bottom: -7px;
  border-bottom: 0;
  border-top: 7px solid #999999;
}
.datepicker-dropdown.datepicker-orient-top:after {
  display: none;
  bottom: -6px;
  border-bottom: 0;
  border-top: 6px solid #ffffff;
}
.datepicker > div {
  display: none;
}
.datepicker table {
  margin: 0;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.datepicker td,
.datepicker th {
  text-align: center;
  width: 20px;
  height: 20px;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  border: none;
}
.table-striped .datepicker table tr td,
.table-striped .datepicker table tr th {
  background-color: transparent;
}
.datepicker table tr td.day:hover,
.datepicker table tr td.day.focused {
  background: #eeeeee;
  cursor: pointer;
}
.datepicker table tr td.old,
.datepicker table tr td.new {
  color: #999999;
}
.datepicker table tr td.disabled,
.datepicker table tr td.disabled:hover {
  background: none;
  color: #999999;
  cursor: default;
}
.datepicker table tr td.highlighted {
  background: #d9edf7;
  border-radius: 0;
}
.datepicker table tr td.today,
.datepicker table tr td.today:hover,
.datepicker table tr td.today.disabled,
.datepicker table tr td.today.disabled:hover {
  background-color: #fde19a;
  background-image: -moz-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: -ms-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fdd49a), to(#fdf59a));
  background-image: -webkit-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: -o-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdd49a', endColorstr='#fdf59a', GradientType=0);
  border-color: #fdf59a #fdf59a #fbed50;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #000;
}
.datepicker table tr td.today:hover,
.datepicker table tr td.today:hover:hover,
.datepicker table tr td.today.disabled:hover,
.datepicker table tr td.today.disabled:hover:hover,
.datepicker table tr td.today:active,
.datepicker table tr td.today:hover:active,
.datepicker table tr td.today.disabled:active,
.datepicker table tr td.today.disabled:hover:active,
.datepicker table tr td.today.active,
.datepicker table tr td.today:hover.active,
.datepicker table tr td.today.disabled.active,
.datepicker table tr td.today.disabled:hover.active,
.datepicker table tr td.today.disabled,
.datepicker table tr td.today:hover.disabled,
.datepicker table tr td.today.disabled.disabled,
.datepicker table tr td.today.disabled:hover.disabled,
.datepicker table tr td.today[disabled],
.datepicker table tr td.today:hover[disabled],
.datepicker table tr td.today.disabled[disabled],
.datepicker table tr td.today.disabled:hover[disabled] {
  background-color: #fdf59a;
}
.datepicker table tr td.today:active,
.datepicker table tr td.today:hover:active,
.datepicker table tr td.today.disabled:active,
.datepicker table tr td.today.disabled:hover:active,
.datepicker table tr td.today.active,
.datepicker table tr td.today:hover.active,
.datepicker table tr td.today.disabled.active,
.datepicker table tr td.today.disabled:hover.active {
  background-color: #fbf069 \9;
}
.datepicker table tr td.today:hover:hover {
  color: #000;
}
.datepicker table tr td.today.active:hover {
  color: #fff;
}
.datepicker table tr td.range,
.datepicker table tr td.range:hover,
.datepicker table tr td.range.disabled,
.datepicker table tr td.range.disabled:hover {
  background: #eeeeee;
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0;
}
.datepicker table tr td.range.today,
.datepicker table tr td.range.today:hover,
.datepicker table tr td.range.today.disabled,
.datepicker table tr td.range.today.disabled:hover {
  background-color: #f3d17a;
  background-image: -moz-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: -ms-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f3c17a), to(#f3e97a));
  background-image: -webkit-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: -o-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3c17a', endColorstr='#f3e97a', GradientType=0);
  border-color: #f3e97a #f3e97a #edde34;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0;
}
.datepicker table tr td.range.today:hover,
.datepicker table tr td.range.today:hover:hover,
.datepicker table tr td.range.today.disabled:hover,
.datepicker table tr td.range.today.disabled:hover:hover,
.datepicker table tr td.range.today:active,
.datepicker table tr td.range.today:hover:active,
.datepicker table tr td.range.today.disabled:active,
.datepicker table tr td.range.today.disabled:hover:active,
.datepicker table tr td.range.today.active,
.datepicker table tr td.range.today:hover.active,
.datepicker table tr td.range.today.disabled.active,
.datepicker table tr td.range.today.disabled:hover.active,
.datepicker table tr td.range.today.disabled,
.datepicker table tr td.range.today:hover.disabled,
.datepicker table tr td.range.today.disabled.disabled,
.datepicker table tr td.range.today.disabled:hover.disabled,
.datepicker table tr td.range.today[disabled],
.datepicker table tr td.range.today:hover[disabled],
.datepicker table tr td.range.today.disabled[disabled],
.datepicker table tr td.range.today.disabled:hover[disabled] {
  background-color: #f3e97a;
}
.datepicker table tr td.range.today:active,
.datepicker table tr td.range.today:hover:active,
.datepicker table tr td.range.today.disabled:active,
.datepicker table tr td.range.today.disabled:hover:active,
.datepicker table tr td.range.today.active,
.datepicker table tr td.range.today:hover.active,
.datepicker table tr td.range.today.disabled.active,
.datepicker table tr td.range.today.disabled:hover.active {
  background-color: #efe24b \9;
}
.datepicker table tr td.selected,
.datepicker table tr td.selected:hover,
.datepicker table tr td.selected.disabled,
.datepicker table tr td.selected.disabled:hover {
  background-color: #9e9e9e;
  background-image: -moz-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: -ms-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#b3b3b3), to(#808080));
  background-image: -webkit-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: -o-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: linear-gradient(to bottom, #b3b3b3, #808080);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b3b3b3', endColorstr='#808080', GradientType=0);
  border-color: #808080 #808080 #595959;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #fff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.datepicker table tr td.selected:hover,
.datepicker table tr td.selected:hover:hover,
.datepicker table tr td.selected.disabled:hover,
.datepicker table tr td.selected.disabled:hover:hover,
.datepicker table tr td.selected:active,
.datepicker table tr td.selected:hover:active,
.datepicker table tr td.selected.disabled:active,
.datepicker table tr td.selected.disabled:hover:active,
.datepicker table tr td.selected.active,
.datepicker table tr td.selected:hover.active,
.datepicker table tr td.selected.disabled.active,
.datepicker table tr td.selected.disabled:hover.active,
.datepicker table tr td.selected.disabled,
.datepicker table tr td.selected:hover.disabled,
.datepicker table tr td.selected.disabled.disabled,
.datepicker table tr td.selected.disabled:hover.disabled,
.datepicker table tr td.selected[disabled],
.datepicker table tr td.selected:hover[disabled],
.datepicker table tr td.selected.disabled[disabled],
.datepicker table tr td.selected.disabled:hover[disabled] {
  background-color: #808080;
}
.datepicker table tr td.selected:active,
.datepicker table tr td.selected:hover:active,
.datepicker table tr td.selected.disabled:active,
.datepicker table tr td.selected.disabled:hover:active,
.datepicker table tr td.selected.active,
.datepicker table tr td.selected:hover.active,
.datepicker table tr td.selected.disabled.active,
.datepicker table tr td.selected.disabled:hover.active {
  background-color: #666666 \9;
}
.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td.active.disabled,
.datepicker table tr td.active.disabled:hover {
  background-color: #006dcc;
  background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
  background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: linear-gradient(to bottom, #0088cc, #0044cc);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
  border-color: #0044cc #0044cc #002a80;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #fff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.datepicker table tr td.active:hover,
.datepicker table tr td.active:hover:hover,
.datepicker table tr td.active.disabled:hover,
.datepicker table tr td.active.disabled:hover:hover,
.datepicker table tr td.active:active,
.datepicker table tr td.active:hover:active,
.datepicker table tr td.active.disabled:active,
.datepicker table tr td.active.disabled:hover:active,
.datepicker table tr td.active.active,
.datepicker table tr td.active:hover.active,
.datepicker table tr td.active.disabled.active,
.datepicker table tr td.active.disabled:hover.active,
.datepicker table tr td.active.disabled,
.datepicker table tr td.active:hover.disabled,
.datepicker table tr td.active.disabled.disabled,
.datepicker table tr td.active.disabled:hover.disabled,
.datepicker table tr td.active[disabled],
.datepicker table tr td.active:hover[disabled],
.datepicker table tr td.active.disabled[disabled],
.datepicker table tr td.active.disabled:hover[disabled] {
  background-color: #0044cc;
}
.datepicker table tr td.active:active,
.datepicker table tr td.active:hover:active,
.datepicker table tr td.active.disabled:active,
.datepicker table tr td.active.disabled:hover:active,
.datepicker table tr td.active.active,
.datepicker table tr td.active:hover.active,
.datepicker table tr td.active.disabled.active,
.datepicker table tr td.active.disabled:hover.active {
  background-color: #003399 \9;
}
.datepicker table tr td span {
  display: block;
  width: 23%;
  height: 54px;
  line-height: 54px;
  float: left;
  margin: 1%;
  cursor: pointer;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
}
.datepicker table tr td span:hover {
  background: #eeeeee;
}
.datepicker table tr td span.disabled,
.datepicker table tr td span.disabled:hover {
  background: none;
  color: #999999;
  cursor: default;
}
.datepicker table tr td span.active,
.datepicker table tr td span.active:hover,
.datepicker table tr td span.active.disabled,
.datepicker table tr td span.active.disabled:hover {
  background-color: #006dcc;
  background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
  background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: linear-gradient(to bottom, #0088cc, #0044cc);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
  border-color: #0044cc #0044cc #002a80;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #fff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.datepicker table tr td span.active:hover,
.datepicker table tr td span.active:hover:hover,
.datepicker table tr td span.active.disabled:hover,
.datepicker table tr td span.active.disabled:hover:hover,
.datepicker table tr td span.active:active,
.datepicker table tr td span.active:hover:active,
.datepicker table tr td span.active.disabled:active,
.datepicker table tr td span.active.disabled:hover:active,
.datepicker table tr td span.active.active,
.datepicker table tr td span.active:hover.active,
.datepicker table tr td span.active.disabled.active,
.datepicker table tr td span.active.disabled:hover.active,
.datepicker table tr td span.active.disabled,
.datepicker table tr td span.active:hover.disabled,
.datepicker table tr td span.active.disabled.disabled,
.datepicker table tr td span.active.disabled:hover.disabled,
.datepicker table tr td span.active[disabled],
.datepicker table tr td span.active:hover[disabled],
.datepicker table tr td span.active.disabled[disabled],
.datepicker table tr td span.active.disabled:hover[disabled] {
  background-color: #0044cc;
}
.datepicker table tr td span.active:active,
.datepicker table tr td span.active:hover:active,
.datepicker table tr td span.active.disabled:active,
.datepicker table tr td span.active.disabled:hover:active,
.datepicker table tr td span.active.active,
.datepicker table tr td span.active:hover.active,
.datepicker table tr td span.active.disabled.active,
.datepicker table tr td span.active.disabled:hover.active {
  background-color: #003399 \9;
}
.datepicker table tr td span.old,
.datepicker table tr td span.new {
  color: #999999;
}
.datepicker .datepicker-switch {
  width: 145px;
}
.datepicker .datepicker-switch,
.datepicker .prev,
.datepicker .next,
.datepicker tfoot tr th {
  cursor: pointer;
}
.datepicker .datepicker-switch:hover,
.datepicker .prev:hover,
.datepicker .next:hover,
.datepicker tfoot tr th:hover {
  background: #eeeeee;
}
.datepicker .cw {
  font-size: 10px;
  width: 12px;
  padding: 0 2px 0 5px;
  vertical-align: middle;
}
.input-append.date .add-on,
.input-prepend.date .add-on {
  cursor: pointer;
}
.input-append.date .add-on i,
.input-prepend.date .add-on i {
  margin-top: 3px;
}
.input-daterange input {
  text-align: center;
}
.input-daterange input:first-child {
  -webkit-border-radius: 3px 0 0 3px;
  -moz-border-radius: 3px 0 0 3px;
  border-radius: 3px 0 0 3px;
}
.input-daterange input:last-child {
  -webkit-border-radius: 0 3px 3px 0;
  -moz-border-radius: 0 3px 3px 0;
  border-radius: 0 3px 3px 0;
}
.input-daterange .add-on {
  display: inline-block;
  width: auto;
  min-width: 16px;
  height: 18px;
  padding: 4px 5px;
  font-weight: normal;
  line-height: 18px;
  text-align: center;
  text-shadow: 0 1px 0 #ffffff;
  vertical-align: middle;
  background-color: #eeeeee;
  border: 1px solid #ccc;
  margin-left: -5px;
  margin-right: -5px;
}


        </style>


@endsection
