@extends('layouts.client')
@section('content')



    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard header items area -->
                    <div class="panel panel-default admin">
                        <div class="panel-heading admin-title">{{$lang->cdt}}</div>

                    </div>
                    <!-- Ending of Dashboard header items area -->

                    <!-- Starting of Dashboard Top reference + Most Used OS area -->
                    <div class="reference-OS-area">
                        <div class="donors-profile-top-bg overlay text-center wow fadeInUp" style="background-image: url({{asset('assets/images/'.$gs->c_dashbg)}}); visibility: visible; animation-name: fadeInUp;z-index: auto;color: black;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="ut">{{$user->name}} {{$user->family_name}}</h2>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="donors-profile-wrap wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                            <div class="container">

                                <div class="row">
                                    @include('includes.form-success')
                                    @if(count($errors) > 0)
                                        <div class="alert alert-danger validation">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <ul class="text-left">
                                                @foreach($errors->all() as $error)
                                                    <li>{{$error}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="col-md-8">

                                        <div class="profile-description-box margin-bottom-30">
                                            <h2 class="ut">{{$lang->dopd}}</h2>
                                            <hr>
                                            <p>{!!$user->description!!}</p>
                                        </div>

                                        @if($user->special != null)
                                            <div class="other-description-box margin-bottom-30">
                                                <h2 class="ut">{{$lang->doo}}</h2>
                                                <hr>
                                                <div class="table-responsive" style="overflow: hidden;">
                                                    @php
                                                        $specials = explode(',', $user->special);
                                                    @endphp
                                                    <ul class="row">
                                                        @foreach($specials as $special)
                                                            <li class="col-md-6 col-sm-6">{{$special}}</li>

                                                        @endforeach
                                                    </ul>


                                                </div>
                                            </div>
                                        @endif

                                        <div class="other-description-box margin-bottom-30">
                                            <h2 class="ut">{{$lang->binfo}}</h2>
                                            <hr>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <th>{{$lang->dol}}</th>
                                                        <td>{{$user->language}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{$lang->doa}}</th>
                                                        <td>{{$user->age}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{$lang->doe}}</th>
                                                        <td>{{$user->education}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{$lang->dor}}</th>
                                                        <td>{{$user->residency}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{$lang->dopr}}</th>
                                                        <td>{{$user->profession}}</td>
                                                    </tr>


                                                    </tbody></table>
                                            </div>
                                        </div>

                                        <!--                         <div class="add-area margin-bottom-30">
                                                                    <img src="assets/img/add.jpg" alt="Ad. Image">
                                                                </div> -->

                                    </div>
                                    <div class="col-md-4">
                                        <div class="profile-right-side">

                                            @if($user->photo)

                                                <div class="profile-img">
                                                    <img width="130px" height="90px" id="adminimg" src="{{asset('assets/images/'.$user->photo)}}" alt="" id="adminimg">
                                                </div>

                                            @endif

                                            <div class="profile-contact-info" style="margin-top: 40px;">
                                                <h2>{{$lang->doci}}</h2>
                                                <hr>

                                                <p><i class="fa fa-home fa-1x"></i>&nbsp;{{$user->address}}</p>
                                                @if($user->fax != null)
                                                    <p><i class="fa fa-fax fa-1x"></i>&nbsp;{{$user->fax}}</p>
                                                @endif
                                                <p><i class="fa fa-phone fa-1x"></i>&nbsp;{{$user->phone}}</p>
                                                <p><i class="fa fa-envelope fa-1x"></i>&nbsp;{{$user->email}}</p>
                                                @if($user->web != null)
                                                    <p><i class="fa fa-globe fa-1x"></i>&nbsp;{{$user->web}}</p>
                                                @endif
                                            </div>

                                            <div class="share-profile-info" style="margin-top: 40px;">
                                                <h2>{{$lang->dosp}}</h2>
                                                <hr>
                                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                                    <a class="a2a_dd" href=""></a>
                                                    <a class="a2a_button_facebook" href=""></a>
                                                    <a class="a2a_button_twitter" href=""></a>
                                                    <a class="a2a_button_google_plus" href=""></a>
                                                    <a class="a2a_button_linkedin" href=""></a>
                                                </div>
                                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                                            </div>
                                            <hr>
                                            <div class="add-area margin-bottom-30">
                                                <iframe
                                                        width="340"
                                                        height="350"
                                                        frameborder="0" style="border:0"
                                                        src="https://www.google.com/maps/embed/v1/place?key={{$gs->map_key}}&q={{$user->address == null ? '@':$user->address}}" allowfullscreen>
                                                </iframe>
                                            </div>
                                            <!--                             <div class="add-area">
                                                                        <img src="assets/img/ad1.jpg" alt="Ad. Image">
                                                                    </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>
                    <!-- Ending of Dashboard Top reference + Most Used OS area -->

                </div>
            </div>
        </div>
    </div>


    <style>

        .container
                {
                    width: 100% !important;
                }

        #dashboard{
            color: #fff;
            background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.70)':$gs->colors.'c2'}};

        }


    </style>


@endsection

@section('scripts')

    <script>

        $("#opt").change(function(){

            var opt = $("#opt").val();

            if(opt=="yes"){
                $("#cost").html("Total Cost: {{$gs->fp+$gs->np}}$");
            }else{
                $("#cost").html("Total Cost: {{$gs->np}}$");
            }

        });
        //    $('#pay').click(function(e) {
        //
        //        var opt = $("#opt").val();
        //        if(opt !=""){
        //
        //            $('#ModalAll').modal('toggle'); //or  $('#IDModal').modal('hide');
        //        }
        //    });
        //    $('#pay2').click(function(e) {
        //        $('#ModalFeature').modal('toggle'); //or  $('#IDModal').modal('hide');
        //    });

        function meThods(val) {
            var action1 = "{{route('payment.submit')}}";
            var action2 = "{{route('stripe.submit')}}";
            if (val.value == "Paypal") {
                $("#payment_form").attr("action", action1);
                $("#stripes").hide();
                $("#stripes").find("input").attr('required',false);
            }
            if (val.value == "Stripe") {
                $("#payment_form").attr("action", action2);
                $("#stripes").show();
                $("#stripes").find("input").attr('required',true);
            }
        }
        function meThods2(val) {
            var action1 = "{{route('payment.submit')}}";
            var action2 = "{{route('stripe.submit')}}";
            if (val.value == "Paypal") {
                $("#payment_form2").attr("action", action1);
                $("#stripes2").hide();
                $("#stripes2").find("input").attr('required',false);
            }
            if (val.value == "Stripe") {
                $("#payment_form2").attr("action", action2);
                $("#stripes2").show();
                $("#stripes2").find("input").attr('required',true);
            }
        }

    </script>

@endsection
