@extends('layouts.client')

@section('content')

<div class="right-side">

	<div class="container-fluid">

		<div style="margin: 50px auto 0 auto;width: 80%;" class="row">

            <embed src="{{ file_exists(public_path().'/assets/newQuotations/'.$check->quotation_invoice_number.'.pdf') ? asset('assets/newQuotations/'.$check->quotation_invoice_number.'.pdf') : null }}" width="100%" height="1200px" />

		</div>

	</div>

</div>

@endsection
