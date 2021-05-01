@extends('layouts.front')
@section('content')
<div class="donors-profile-top-bg overlay text-center wow fadeInUp" @if($user_role == 2) style="background-image: url({{asset('assets/images/'.$gs->h_dashbg)}}); visibility: visible; animation-name: fadeInUp;z-index: auto;color: black;" @else style="background-image: url({{asset('assets/images/'.$gs->c_dashbg)}}); visibility: visible; animation-name: fadeInUp;z-index: auto;color: black;"  @endif>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{$user->name}}</h2>

                        @if($services != "")

                        <p>{{$lang->bg}}

                        <?php $count = count($services); $i=1; ?>
                            @foreach($services as $key)

                                @if($i == $count)

                                {{$key->cat_name}}

                                @else

                                    {{$key->cat_name}},

                                    @endif

                                <?php $i++; ?>

                         @endforeach</p>

                         @endif
                            
                    </div>
                </div>
            </div>
        </div>

<div class="profile-fillup-wrap wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="{{route('user-reset-submit')}}" method="POST">
                            @include('includes.form-success')
                            @include('includes.form-error')
                            {{csrf_field()}}            
                            <div class="profile-filup-description-box margin-bottom-30">
                              <div class="form-group">
                                <label for="full_name" class="col-sm-3 control-label">{{$lang->cp}} *</label>
                                <div class="col-sm-8">
                                  <input class="form-control" id="full_name" name="cpass" placeholder="{{$lang->cp}}" type="text" value="" required="">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="full_name" class="col-sm-3 control-label">{{$lang->np}} *</label>
                                <div class="col-sm-8">
                                  <input class="form-control" id="full_name" name="newpass" placeholder="{{$lang->np}}" type="text" value="" required="">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="full_name" class="col-sm-3 control-label">{{$lang->rnp}} *</label>
                                <div class="col-sm-8">
                                  <input class="form-control" id="full_name" name="renewpass" placeholder="{{$lang->rnp}}" type="text" value="" required="">
                                </div>
                              </div>

                          </div>


                         <div class="submit-area margin-bottom-30">
                           <div class="row">
                               <div class="col-md-8 col-md-offset-2">
                                   <div class="form-group text-center">
                                        <button class="boxed-btn blog" type="submit">{{$lang->chnp}}</button>
                                    </div>
                               </div>
                           </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

