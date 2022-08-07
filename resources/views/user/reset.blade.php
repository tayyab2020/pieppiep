@extends('layouts.front_new')
@section('content')

          <div class="profile-fillup-wrap wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;padding: 150px 0 0 0;">
            <div class="container">
                <div style="margin: 0;" class="row">
                    <div style="margin: 0 auto 50px auto;border: 1px solid #d1d1d1;padding: 20px;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                        <form class="form-horizontal" action="{{route('user-reset-submit')}}" method="POST">
                            
                            @include('includes.form-success')
                            @include('includes.form-error')
                            {{csrf_field()}}            
                            
                            <div class="profile-filup-description-box margin-bottom-30">

                              <div class="form-group">
                                <label for="full_name" class="control-label">{{$lang->cp}} *</label>
                                <div>
                                  <input class="form-control" id="full_name" name="cpass" placeholder="{{$lang->cp}}" type="text" value="" required="">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="full_name" class="control-label">{{$lang->np}} *</label>
                                <div>
                                  <input class="form-control" id="full_name" name="newpass" placeholder="{{$lang->np}}" type="text" value="" required="">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="full_name" class="control-label">{{$lang->rnp}} *</label>
                                <div>
                                  <input class="form-control" id="full_name" name="renewpass" placeholder="{{$lang->rnp}}" type="text" value="" required="">
                                </div>
                              </div>

                            </div>

                            <div class="submit-area">
                              <div style="margin: 0;" class="row">
                                <div>
                                  <div style="margin: 0;" class="form-group text-center">
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

