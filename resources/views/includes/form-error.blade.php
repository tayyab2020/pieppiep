@if(count($errors) > 0)
<div class="alert alert-danger validation">
	<button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<ul class="text-left">
	@foreach($errors->all() as $error)
		<li>{{$error}}</li>
	@endforeach
	</ul>
</div>
@endif

@if(session('message')==='f')
    <div class="alert alert-danger validation">
        <button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <p>{{__('text.Credentials doesn\'t match')}}</p>
    </div>
@endif

