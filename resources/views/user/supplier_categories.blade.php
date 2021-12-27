@extends('layouts.handyman')

@section('content')

    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard area -->
                    <div class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">

                                    <div class="add-product-header">
                                        <h2>My Categories</h2>
                                    </div>

                                    <form class="form-horizontal" action="{{route('supplier-categories-store')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        <div class="form-group">
                                                            
                                            <label class="control-label col-sm-4" for="blood_group_slug">Feature Category</label>

                                            <div class="col-sm-6">

                                                <select style="height: 100px;" class="form-control" name="supplier_categories[]" id="supplier_categories" multiple>

                                                    @foreach($feature_categories as $cat)

                                                        <option {{(in_array($cat->id, $my_categories) ? 'selected' : null)}} value="{{$cat->id}}">{{$cat->cat_name}}</option>

                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                        <div style="margin-top: 20px;" class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">Save</button>
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

<style>

.table{width: 100%;padding: 0 20px;}
.table table{border-collapse: inherit;text-align: left;width: 100%;border: 1px solid #d6d6d6;border-radius: 10px;}
.table table thead th{font-weight: 700;padding: 12px 10px;background: #f8f9fa;color: #3a3a3a;}
.table table tbody td{padding: 10px;border-bottom: 1px solid #d3d3d3;color: #3a3a3a;vertical-align: middle;}
.table table tbody tr:last-child td{ border-bottom: none; }

.accordion-menu h2 {
	font-size: 18px;
	line-height: 34px;
	font-weight: 500;
	letter-spacing: 1px;
	margin: 0;
    cursor: pointer;
    color: black;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fbfbfb;
    padding: 15px;
    border-top: 1px solid #dadada;
}
.accordion-menu .accordion-content {
	color: rgba(48, 69, 92, 0.8);
	font-size: 15px;
	line-height: 26px;
	letter-spacing: 1px;
	position: relative;
	overflow: hidden;
	max-height: 10000px;
	opacity: 1;
	transform: translate(0, 0);
	margin: 20px 0;
	z-index: 2;
}
.accordion-menu ul {
	list-style: none;
	perspective: 900;
	padding: 0;
    margin: 0;
    background-color: #fff;
	border-radius: 0;
	/*box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2),
	0 2px 2px 0 rgba(255, 255, 255, 0.19);*/
}
.accordion-menu ul li {
	position: relative;
	padding: 0;
	margin: 0;
}

.accordion-menu ul li input[type=checkbox]:not(:checked) ~ h2 { border-bottom: 1px solid #dadada; }

.accordion-menu ul li:last-of-type { padding-bottom: 0; }
.accordion-menu ul li:last-of-type h2{ border-bottom: 1px solid #dadada; }

.accordion-menu ul li .fas{
	color:#f6483b;
	font-size: 15px;
	margin-right: 10px;
}

.accordion-menu ul li .arrow:before, ul li .arrow:after {
	content: "";
	position: absolute;
	background-color: #f6483b;
	width: 3px;
	height: 9px;
}

.accordion-menu ul li h2 .arrow:before {
	transform: translate(-20px, 0) rotate(45deg);
}

.accordion-menu ul li h2 .arrow:after {
	transform: translate(-15.8px, 0) rotate(-45deg);
}

.accordion-menu ul li input[type=checkbox] {
	position: absolute;
	cursor: pointer;
	width: 100%;
	height: 100%;
    z-index: 1;
    opacity: 0;
}

.accordion-menu ul li input[type=checkbox]:checked ~ .accordion-content {
	max-height: 0;
	opacity: 0;
	transform: translate(0, 50%);
    margin: 0;
}

.accordion-menu ul li input[type=checkbox]:checked ~ h2 .arrow:before {
	transform: translate(-16px, 0) rotate(45deg);
}

.accordion-menu ul li input[type=checkbox]:checked ~ h2 .arrow:after {
	transform: translate(-20px, 0) rotate(-45deg);
}

.transition, .accordion-menu .accordion-content, .accordion-menu ul li h2 .arrow:before, .accordion-menu ul li h2 .arrow:after {
	transition: all 0.25s ease-in-out;
}

.flipIn, h1, .accordion-menu ul li {
	animation: flipdown 0.5s ease both;
}

.no-select, .accordion-menu h2 {
	-webkit-tap-highlight-color: transparent;
	-webkit-touch-callout: none;
	user-select: none;
}
@keyframes flipdown {
	0% {
		opacity: 0;
		transform-origin: top center;
		transform: rotateX(-90deg);
	}

	5% { opacity: 1; }

	80% { transform: rotateX(8deg); }

	83% { transform: rotateX(6deg); }

	92% { transform: rotateX(-3deg); }

	100% {
		transform-origin: top center;
		transform: rotateX(0deg);
	}
}

</style>

@endsection

@section('scripts')

    <script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
        //]]>
    </script>

<style type="text/css">

  .swal2-show
  {
    padding: 40px;
    width: 30%;

  }

  .swal2-header
  {
    font-size: 23px;
  }

  .swal2-content
  {
    font-size: 18px;
  }

  .swal2-actions
  {
    font-size: 16px;
  }

</style>

@endsection
