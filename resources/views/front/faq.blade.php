@extends('layouts.front')
@section('content')
<div class="section-padding faq-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title pb_50 text-center">
                            <h2>{{$lang->faqs}}</h2>

                            <div class="section-borders">
                                <span></span>
                                <span class="black-border"></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="styled-faq">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        @foreach($faqs as $faq)
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading{{$faq->id}}">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$faq->id}}" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                                <span>{{$faq->title}}</span>
                                                <i class="fa fa-plus"></i>
                                                <i class="fa fa-minus"></i>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse{{$faq->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$faq->id}}" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                        {!!$faq->text!!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
