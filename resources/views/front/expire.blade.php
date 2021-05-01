@extends('layouts.front')

@section('content')

<div class="jumbotron text-center" style="font-family: inherit;height: 470px;background-color: #e9ecef;padding-top: 100px;">
  <h1 class="display-3" style="font-weight: 300;">{{__('text.Something went wrong!')}}</h1>
  <p class="lead" style="font-size: 18px;width: 80%;margin: auto;padding-top: 55px;"> {{__('text.Kindly visit your dashboard panel and change the booking status for this invoice to get fresh checkout url to complete your remaining transaction. This could be server side error or your checkout url has expired.')}}</p>
  <hr>
  <p style="font-size: 18px;font-weight: 500;margin-top: 50px;">
    {{__('text.Having trouble?')}} <a href="{{route('front.contact')}}">{{__('text.Contact Us')}}</a>
  </p>
  <p class="lead">
    <a class="btn btn-primary btn-sm" href="{{route('front.index')}}" role="button" style="font-size: 14px;background-color: #0069d9;border-color: #0062cc">{{__('text.Continue to homepage')}}</a>
  </p>

</div>

<style type="text/css">

  .subscribe-newsletter-wrapper
    {
        background-color: #e9ecef;
    }

    body{

        background-color: #e9ecef;
    }

</style>

<script type="text/javascript">


            setTimeout(function(){
                $('#cover').fadeOut(0);
            },0)


</script>

@endsection
