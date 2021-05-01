@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard Contact Page Content -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Website Languages</h2> 
                                        </div>
                                        <hr>

                                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css">

<form method="get" action="{{route('admin-lang-index')}}" id="lang-form">
{{csrf_field()}} 


<select class="selectpicker" data-width="fit" name="lang_select" >
    @if($lang->lang == 'eng')
    <option value="eng" selected data-content='<span class="flag-icon flag-icon-us"></span> English'>English</option>
  <option value="du"  data-content='<span class="flag-icon flag-icon-nl"></span> Nederlands'>Nederlands</option>

  @else

  <option value="eng"  data-content='<span class="flag-icon flag-icon-us"></span> English'>English</option>
  <option value="du" selected  data-content='<span class="flag-icon flag-icon-nl"></span> Nederlands'>Nederlands</option>

  @endif
</select>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>

<script type="text/javascript">

    $(function(){
    $('.selectpicker').selectpicker();
});

    $(".selectpicker").change(function(){
  
  $('#lang-form').submit();

});

</script>

<style type="text/css">

  .bootstrap-select.fit-width
  {
    margin: 15px;
    margin-left: 15px !important;
  }

  ul.tab {
  list-style-type: none;
  margin: auto;
  padding: 0;
  overflow: hidden;
  border-bottom: 1px solid #d4d4d4;
  width: 95%;
}




/* Style the links inside the list items */

ul.tab li {

  float: left;
  border-right: 1px solid gray;
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
  background-color: #bdbdbd;
  padding: 15px 85px;
  color: white;
  text-align: center;
  transition: 0.3s;
  font-size: 17px;
  cursor: pointer;
}


/* Change background color of links on hover */

ul.tab li:hover {
  background-color: #bdbdbd;
}


/* Create an active/current tablink class */

#form1 ul.tab li:focus,
#form1 ul.tab li.active {
  background-color: #686868;
}


/* Style the tab content */

.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #d4d4d4;
  border-top: none;
  color:black;
  -webkit-animation: fadeEffect 1.25s;
  animation: fadeEffect 1.25s;
  /* Fading effect takes 1 second */
}

@-webkit-keyframes fadeEffect {
    from {opacity: 0;}
    to {opacity: 1;}
}

@keyframes fadeEffect {
    from {opacity: 0;}
    to {opacity: 1;}
}


</style>

<script type="text/javascript">
  
  function openContent(evt, contentId) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tabs");
    for (i = 0; i < tabcontent.length; i++) {
      
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the link that opened the tab
    document.getElementById(contentId).style.display = "block";
    evt.currentTarget.className += " active";
}

</script>

                                        <form class="form-horizontal" id="form1" action="{{route('admin-lang-submit')}}" method="POST">
                                         @include('includes.form-success')      
                                        {{csrf_field()}}

                                        <input type="hidden" name="lang_set" value="{{$lang->lang}}">

                                          <ul class="tab">
  <li class="tabs active" onclick="openContent(event, 'Frontend')">Frontend</li>
  <li class="tabs" onclick="openContent(event, 'Filter')">Filter</li>
  <li class="tabs" onclick="openContent(event, 'Cart')">Cart</li>
  <li class="tabs" onclick="openContent(event, 'Handyman Panel')">Handyman Panel</li>
  <li class="tabs" onclick="openContent(event, 'Client Panel')">Client Panel</li>
</ul>

<div id="Frontend" class="tabcontent" style="display: block;width: 95%;margin: auto;min-height: 700px;height: 700px;overflow-y: auto;overflow-x: hidden;">


                                        <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Home Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="home" placeholder="Home" value="{{$data->home}}" >
                                            
                                            </div>
                                          </div>

    <div class="form-group" style="margin-top: 30px;">
    <label class="control-label col-sm-4" for="contact_form_success_text">Email Required Validation *</label>
    <div class="col-sm-6">

      <input id="contact_form_success_text" class="form-control" type="text" name="erv" placeholder="Email Required Text" value="{{$data->erv}}" >

    </div>
  </div>

    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Email Unique Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="euv" placeholder="Email Unique Text" value="{{$data->euv}}" >

        </div>
    </div>


    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">First Name Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="nrv" placeholder="First Name Required Text" value="{{$data->nrv}}" >

        </div>
    </div>


    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">First Name Max Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="nmv" placeholder="First Name Max Text" value="{{$data->nmv}}" >

        </div>
    </div>


    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">First Name Invalid Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="niv" placeholder="First Name Invalid Text" value="{{$data->niv}}" >

        </div>
    </div>

    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Family Name Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="fnrv" placeholder="Family Name Required Text" value="{{$data->fnrv}}" >

        </div>
    </div>

    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Family Name Max Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="fnmv" placeholder="Family Name Max Text" value="{{$data->fnmv}}" >

        </div>
    </div>


    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Family Name Invalid Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="fniv" placeholder="Family Name Invalid Text" value="{{$data->fniv}}" >

        </div>
    </div>


    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Postcode Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="pcrv" placeholder="Postcode Required Text" value="{{$data->pcrv}}" >

        </div>
    </div>

    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Address Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="arv" placeholder="Address Required Text" value="{{$data->arv}}" >

        </div>
    </div>


    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">City Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="crv" placeholder="City Required Text" value="{{$data->crv}}" >

        </div>
    </div>

    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Phone Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="prv" placeholder="Phone Required Text" value="{{$data->prv}}" >

        </div>
    </div>


    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Password Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="parv" placeholder="Password Required Text" value="{{$data->parv}}" >

        </div>
    </div>


    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Password Minimum Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="pamv" placeholder="Password Minimum Text" value="{{$data->pamv}}" >

        </div>
    </div>

    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Password Confirmation Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="pacv" placeholder="Password Confirmation Text" value="{{$data->pacv}}" >

        </div>
    </div>


    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Google Recaptcha Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="grv" placeholder="Google Recaptcha Required Text" value="{{$data->grv}}" >

        </div>
    </div>

    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Company Name Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="cnrv" placeholder="Company Name Required Text" value="{{$data->cnrv}}" >

        </div>
    </div>

    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Registration Number Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="rnrv" placeholder="Registration Number Required Text" value="{{$data->rnrv}}" >

        </div>
    </div>


    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Bank Account Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="barv" placeholder="Bank Account Required Text" value="{{$data->barv}}" >

        </div>
    </div>

    <div class="form-group" style="margin-top: 30px;">
        <label class="control-label col-sm-4" for="contact_form_success_text">Tax Number Required Validation *</label>
        <div class="col-sm-6">

            <input id="contact_form_success_text" class="form-control" type="text" name="tnrv" placeholder="Tax Number Required Text" value="{{$data->tnrv}}" >

        </div>
    </div>
                                          <div class="form-group" style="margin-top: 30px;">
                                          <label class="control-label col-sm-4" for="contact_form_success_text">Year Text *</label>

                                            <div class="col-sm-6">


                                              <input id="contact_form_success_text" class="form-control" type="text" name="yt1" placeholder="Year Text" value="{{$data->yt1}}" >

                                            </div>

                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                          <label class="control-label col-sm-4" for="contact_form_success_text">Years Text *</label>

                                            <div class="col-sm-6">


                                              <input id="contact_form_success_text" class="form-control" type="text" name="yst" placeholder="Years Text" value="{{$data->yst}}" >

                                            </div>

                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                          <label class="control-label col-sm-4" for="contact_form_success_text">I Agree Text *</label>

                                            <div class="col-sm-6">


                                              <input id="contact_form_success_text" class="form-control" type="text" name="iagt" placeholder="I Agree Text" value="{{$data->iagt}}" >

                                            </div>

                                          </div>


                                          <div class="form-group" style="margin-top: 30px;">

                                            <label class="control-label col-sm-4" for="contact_form_success_text">Terms & Conditions Text *</label>

                                            <div class="col-sm-6">


                                              <input id="contact_form_success_text" class="form-control" type="text" name="tact" placeholder="Terms & Conditions Text" value="{{$data->tact}}" >


                                            </div>

                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Successfully Updated Your Password Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="suyp" placeholder="Successfully Updated Your Password Text" value="{{$data->suyp}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Confirm Password Not Matched Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cpnm" placeholder="Confirm Password Not Matched Text" value="{{$data->cpnm}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Your Password Reset Successfully Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="prst" placeholder="Your Password Reset Successfully Text" value="{{$data->prst}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">No Account Found With This Email Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="naft" placeholder="No Account Found With This Email Text" value="{{$data->naft}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">You Are Subscribed Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="yasst" placeholder="You Are Subscribed Text" value="{{$data->yasst}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Modal Sub Service Name Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="msnt" placeholder="Modal Sub Service Name Heading" value="{{$data->msnt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Modal Price Unit Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="mput" placeholder="Modal Price Unit Heading" value="{{$data->mput}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Modal Requirement Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="mrt" placeholder="Modal Requirement Heading" value="{{$data->mrt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Add Sub Service Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="asst" placeholder="Add Sub Service Text" value="{{$data->asst}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Select Sub Service Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ssstf" placeholder="Select Sub Service Text" value="{{$data->ssstf}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Already Selected Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sast" placeholder="Service Already Selected Text" value="{{$data->sast}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Modal Close Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="clt" placeholder="Modal Close Text" value="{{$data->clt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">How It Works Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hiwh" placeholder="How It Works Heading" value="{{$data->hiwh}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Reasons To Book Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rtbh" placeholder="Reasons To Book Heading" value="{{$data->rtbh}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Checkout With Another Account Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pdc" placeholder="Checkout With Another Account Text" value="{{$data->pdc}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invalid Date Range Error *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="idr" placeholder="Invalid Date Range Error" value="{{$data->idr}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invalid Postal Code OR City Error *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ipcoc" placeholder="Invalid Postal Code OR City" value="{{$data->ipcoc}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Date Expire Error *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ibd" placeholder="Booking Date Expire Error" value="{{$data->ibd}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Please Wait Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pwt" placeholder="Please Wait Text" value="{{$data->pwt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Please Wait Detail Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pwm" placeholder="Please Wait Detail Text" value="{{$data->pwm}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Description Placeholder *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="bdp" placeholder="Booking Description Placeholder" value="{{$data->bdp}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Upload Booking Image Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="uit" placeholder="Upload Booking Image Text" value="{{$data->uit}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">File Extension Error *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fte" placeholder="File Extension Error" value="{{$data->fte}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Maximum Images Error *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="mie" placeholder="Maximum Images Error" value="{{$data->mie}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Total Payload Size Error *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="tpe" placeholder="Total Payload Size Error" value="{{$data->tpe}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Modal Yes Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="qyt" placeholder="Modal Yes Text" value="{{$data->qyt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Enter Description Placeholder *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sdesc" placeholder="Enter Description Placeholder" value="{{$data->sdesc}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Description Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dt" placeholder="Description Text" value="{{$data->dt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Modal No Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="qnt" placeholder="Modal No Text" value="{{$data->qnt}}" >
                                            
                                            </div>
                                          </div>

                                        

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Card Rating Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ratt" placeholder="Rating Text" value="{{$data->ratt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Card Jobs Completed Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="jct" placeholder="Jobs Completed Text" value="{{$data->jct}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Card Experience Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="et" placeholder="Experience Text" value="{{$data->et}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Confirm Button Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cnf_btn" placeholder="Confirm Button Text" value="{{$data->cnf_btn}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Minimum Amount Error Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ma" placeholder="Minimum Amount Error Text" value="{{$data->ma}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Thankyou Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="tyt" placeholder="Thankyou Text" value="{{$data->tyt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Congratulations Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cst" placeholder="Congratulations Text Text" value="{{$data->cst}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Thankyou Message Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="tym" placeholder="Thankyou Message Text" value="{{$data->tym}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Having Trouble Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="htt" placeholder="Having Trouble Text" value="{{$data->htt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Us Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cut" placeholder="Contact Us Text" value="{{$data->cut}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Continue To Homepage Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ctht" placeholder="Continue To Homepage Text" value="{{$data->ctht}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Not Available Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="nad" placeholder="Not Available Text" value="{{$data->nad}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Per Hour Service Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="servT1" placeholder="Per Hour Service Text" value="{{$data->servT1}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Per Meter Service Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="servT2" placeholder="Per Meter Service Text" value="{{$data->servT2}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Per Foot Service Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="servT3" placeholder="Per Foot Service Text" value="{{$data->servT3}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Per Piece Service Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="servT4" placeholder="Per Piece Service Text" value="{{$data->servT4}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Per Hour Placeholder Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="servP1" placeholder="Per Hour Placeholder Text" value="{{$data->servP1}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Per Meter Placeholder Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="servP2" placeholder="Per Meter Placeholder Text" value="{{$data->servP2}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Per Foot Placeholder Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="servP3" placeholder="Per Foot Placeholder Text" value="{{$data->servP3}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Per Piece Placeholder Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="servP4" placeholder="Per Piece Placeholder Text" value="{{$data->servP4}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Services Available Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sat" placeholder="Services Available Text" value="{{$data->sat}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Have To Book Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="yhtb" placeholder="Have To Book Text" value="{{$data->yhtb}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Cart Success Message Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="acm" placeholder="Cart Success Message Text" value="{{$data->acm}}" >
                                            
                                            </div>
                                          </div>

                                           <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Cart Error Message Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ace" placeholder="Cart Error Message Text" value="{{$data->ace}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Type Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="st" placeholder="Service Type Text" value="{{$data->st}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Rate Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sr" placeholder="Service Rate Text" value="{{$data->sr}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Ready To Add To Cart Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rtac" placeholder="Ready To Add To Cart Text" value="{{$data->rtac}}" >
                                            
                                            </div>
                                          </div>

                                         


                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Search Zip Code Check Text*</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="szc" placeholder="Search zip code check text" value="{{$data->szc}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Search City Check Text*</label>
                                            <div class="col-sm-6">
                                              
                                            <input id="contact_form_success_text" class="form-control" type="text" name="sc" placeholder="Search city check text" value="{{$data->sc}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Search Zip Code Placeholder*</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="spzc" placeholder="Search Zip Code Placeholder" value="{{$data->spzc}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Search City Placeholder*</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="spc" placeholder="Search City Placeholder" value="{{$data->spc}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Date From Placeholder*</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="spdf" placeholder="Search Date From Placeholder" value="{{$data->spdf}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Date To Placeholder*</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="spdt" placeholder="Search Date To Placeholder" value="{{$data->spdt}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Featured Handymen Text *</label>
                                            <div class="col-sm-6">
                                          
                                          <input id="contact_form_success_text" class="form-control" type="text" name="fh" placeholder="Featured Handymen Text" value="{{$data->fh}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Registration Number Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rg" placeholder="Registration Number Text" value="{{$data->rg}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Company Name Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="compname" placeholder="Company Name Text" value="{{$data->compname}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Bank Account Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ba" placeholder="Bank Account Text" value="{{$data->ba}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Tax Number Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="tn" placeholder="Tax Number Text" value="{{$data->tn}}" >

                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Featured Handymen Title Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fht" placeholder="Featured Handymen Title Text" value="{{$data->fht}}" >

                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">All Handymen Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="h" placeholder="All Handymen Text" value="{{$data->h}}" >

                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">All Handymen Title Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="vt" placeholder="All Handymen Title Text" value="{{$data->vt}}" >

                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">All Handymen in Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="gt" placeholder="All Handymen in Text" value="{{$data->gt}}" >

                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">All Featured Button Text *</label>
                                            <div class="col-sm-6">
                                            
                                            <input id="contact_form_success_text" class="form-control" type="text" name="vdn" placeholder="All Featured Button Text " value="{{$data->vdn}}" >

                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">About Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="about" placeholder="About Text" value="{{$data->about}}" >

                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Business Name Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="bn" placeholder="Business Name Text" value="{{$data->bn}}" >

                                            </div>
                                          </div> 

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Postal Code Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pc" placeholder="Postal Code Text" value="{{$data->pc}}" >

                                            </div>
                                          </div> 

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Address Name Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ad" placeholder="Address Text" value="{{$data->ad}}" >

                                            </div>
                                          </div> 

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up City Name Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ct" placeholder="City Text" value="{{$data->ct}}" >

                                            </div>
                                          </div> 

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Phone Number Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pn" placeholder="Phone Number Text" value="{{$data->pn}}" >

                                            </div>
                                          </div> 



                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">About Title Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="abouts" placeholder="About Title Text" value="{{$data->abouts}}" >

                                            </div>
                                          </div> 
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Blog Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="blog" placeholder="blog Text" value="{{$data->blog}}" >

                                            </div>
                                          </div>       
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Blog Title Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="blogs" placeholder="Blog Title Text" value="{{$data->blogs}}" >

                                            </div>
                                          </div>                                                                               
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Faq Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="faq" placeholder="Faq Text" value="{{$data->faq}}" >

                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Faq Title Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="faqs" placeholder="Faq Title Text" value="{{$data->faqs}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="contact" placeholder="Contact Text" value="{{$data->contact}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Title Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="contacts" placeholder="Contact Title Text" value="{{$data->contacts}}" >
                                            </div>
                                          </div>
                                         <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Name Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="con" placeholder="Contact Name Text" value="{{$data->con}}" >
                                            </div>
                                          </div>
                                         <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Phone Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cop" placeholder="Contact Phone Text" value="{{$data->cop}}" >
                                            </div>
                                          </div>
                                         <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Email Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="coe" placeholder="Contact Email Text" value="{{$data->coe}}" >
                                            </div>
                                          </div>
                                         <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Replay Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cor" placeholder="Contact Replay Text" value="{{$data->cor}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign In Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="signin" placeholder="Sign In Text" value="{{$data->signin}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign In Email Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sie" placeholder="Sign In Email Text" value="{{$data->sie}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign In Password Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="spe" placeholder="Sign In Password Text" value="{{$data->spe}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="signup" placeholder="Sign Up Text" value="{{$data->signup}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Handyman Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="signup_handyman" placeholder="Sign Up for Handyman Text" value="{{$data->signup_handyman}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up First Name Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="suf" placeholder="Sign Up First Name Text" value="{{$data->suf}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Family Name Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fn" placeholder="Sign Up Family Name Text" value="{{$data->fn}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Phone Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="suph" placeholder="Sign Up Phone Text" value="{{$data->suph}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Email Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sue" placeholder="Sign Up Email Text" value="{{$data->sue}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Password Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sup" placeholder="Sign Up Password Text" value="{{$data->sup}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Up Confirm Password Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sucp" placeholder="Sign Up Confirm Password Text" value="{{$data->sucp}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Dashboard Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dashboard" placeholder=">Dashboard Text" value="{{$data->dashboard}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Edit Profile Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="edit" placeholder="Edit Profile Text" value="{{$data->edit}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Reset Password Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="reset" placeholder="Reset Password Text" value="{{$data->reset}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sign Out Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="logout" placeholder="Sign Out Text" value="{{$data->logout}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Current Password Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cp" placeholder="Current Password Text" value="{{$data->cp}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">New Password Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="np" placeholder="New Password Text" value="{{$data->np}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Re-Type New Password Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rnp" placeholder="Re-Type New Password Text" value="{{$data->rnp}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Change Password Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="chnp" placeholder="Change Password Text" value="{{$data->chnp}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">All Available Sectors Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="bgs" placeholder="Blood Groups" value="{{$data->bgs}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">All Available Sectors Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="bg" placeholder="All Available Sectors Text" value="{{$data->bg}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Learn More Button Text*</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="lm" placeholder="Learn More Text" value="{{$data->lm}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Featured Handymen Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rds" placeholder="Featured Handymen Text" value="{{$data->rds}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Happy Customers Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hcs" placeholder="Happy Customers Text" value="{{$data->hcs}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Latest Blogs Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="lns" placeholder="Latest Blogs Text" value="{{$data->lns}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">View Details Button Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="vd" placeholder="View Details Text" value="{{$data->vd}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Subscribe Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ston" placeholder="Subscribe Text" value="{{$data->ston}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Subscribe Button Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="s" placeholder="Subscribe Button Text" value="{{$data->s}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Subscribe Placeholder Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="supl" placeholder="Subscribe Placeholder Text" value="{{$data->supl}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Footer Links Text*</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fl" placeholder="Footer Links Text" value="{{$data->fl}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Button Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sm" placeholder="Contact Button Text" value="{{$data->sm}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Forgot Password Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fpw" placeholder="Forgot Password Text" value="{{$data->fpw}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Forgot Password Title *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fpt" placeholder="Forgot Password Title" value="{{$data->fpt}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Forgot Password Email *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fpe" placeholder="Forgot Password Email" value="{{$data->fpe}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Forgot Password Button *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fpb" placeholder="Forgot Password Button" value="{{$data->fpb}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Create New Account Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cn" placeholder="Create New Account Text" value="{{$data->cn}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Already Account Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="al" placeholder="Already Account Text" value="{{$data->al}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Search Result Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dni" placeholder="Search Result Text" value="{{$data->dni}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Search Button Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="search" placeholder="Search Button Text" value="{{$data->search}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Search Form Text (City) *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ec" placeholder="Search Form Text (City)" value="{{$data->ec}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Select Form Text (Service) *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sbg" placeholder="Select Form Text (Blood Group)" value="{{$data->sbg}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Search Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ss" placeholder="Search Heading Text" value="{{$data->ss}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Blog Source Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="bs" placeholder="Blog Source Text" value="{{$data->bs}}" >
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Profile Description *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dopd" placeholder="Handyman Profile Description" value="{{$data->dopd}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Specialities *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doo" placeholder="Handyman Specialities" value="{{$data->doo}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman General Information *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="binfo" placeholder="Handyman General Information" value="{{$data->binfo}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Language *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dol" placeholder="Handyman Language" value="{{$data->dol}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Age *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doa" placeholder="Handyman Age" value="{{$data->doa}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Education *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doe" placeholder="Handyman Education" value="{{$data->doe}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Residency *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dor" placeholder="Handyman Residency" value="{{$data->dor}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Profession *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dopr" placeholder="Handyman Profession" value="{{$data->dopr}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Contact Title *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doc" placeholder="Handyman Contact Title " value="{{$data->doc}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Contact Info *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doci" placeholder="Handyman Contact Info " value="{{$data->doci}}">
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Share Profile *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dosp" placeholder="Handyman Share Profile " value="{{$data->dosp}}">
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Contact Name *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="don" placeholder="Handyman Email Name " value="{{$data->don}}">
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Contact Email *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doem" placeholder="Handyman Contact Email" value="{{$data->doem}}">
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Contact Message *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dom" placeholder="Handyman Contact Message" value="{{$data->dom}}">
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Full Name Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fname" placeholder="Full Name Text" value="{{$data->fname}}" >
                                            </div>
                                          </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Current Photo Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cup" placeholder="Current Photo Text" value="{{$data->cup}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Profile Photo Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pp" placeholder="Profile Photo Text" value="{{$data->pp}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Add Profile Photo Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="app" placeholder="Add Profile Photo Text" value="{{$data->app}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Preferred Size Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="size" placeholder="Preferred Size Text" value="{{$data->size}}" >
                                            </div>
                                          </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">More Details *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="md" placeholder="More Details" value="{{$data->md}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Add More Field Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="amf" placeholder="Add More Field Text" value="{{$data->amf}}" >
                                            </div>
                                          </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman City Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doct" placeholder="Handyman City Text" value="{{$data->doct}}" >
                                            </div>
                                          </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Address Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doad" placeholder="Handyman Address Text" value="{{$data->doad}}" >
                                            </div>
                                          </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Phone Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doph" placeholder="Handyman Phone Text" value="{{$data->doph}}" >
                                            </div>
                                          </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Fax Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dofx" placeholder="Handyman Fax Text" value="{{$data->dofx}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Facebook Profile Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dofpl" placeholder="Handyman Facebook Profile Text" value="{{$data->dofpl}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Twitter Profile Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dotpl" placeholder="Handyman Twitter Profile Text " value="{{$data->dotpl}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Google+ Profile Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dogpl" placeholder="Handyman Google+ Profile Text" value="{{$data->dogpl}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Linkedin Profile Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dolpl" placeholder="Handyman Linkedin Profile Text" value="{{$data->dolpl}}" >
                                            </div>
                                          </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Web Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doeml" placeholder="Handyman Emali Text" value="{{$data->doeml}}" >
                                            </div>
                                          </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Email Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doeml" placeholder="Handyman Emali Text" value="{{$data->doeml}}" >
                                            </div>
                                          </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Update Button Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="doupl" placeholder="Handyman Update Button Text" value="{{$data->doupl}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Update Success Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="success" placeholder="Handyman Update Success Text" value="{{$data->success}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">More Details Title Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="dttl" placeholder="More Details Title Text" value="{{$data->dttl}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">More Details Description Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ddesc" placeholder="More Details Description Text" value="{{$data->ddesc}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Puplish My Profile Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ppr" placeholder="Puplish My Profile Text" value="{{$data->ppr}}" >
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Feature My Profile Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fpr" placeholder="Feature My Profile Text" value="{{$data->fpr}}" >
                                            </div>
                                          </div>
                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Language Setting</button>   
                                            </div>

</div>


<div id="Filter" class="tabcontent" style="width: 95%;margin: auto;min-height: 700px;height: 700px;overflow-y: auto;overflow-x: hidden;">


                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Filter Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ft" placeholder="Filter Heading Text" value="{{$data->ft}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Filter Close Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fct" placeholder="Filter Close Text" value="{{$data->fct}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Insurance Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fit" placeholder="Insurance Heading Text" value="{{$data->fit}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Insurance Yes Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="yt" placeholder="Filter Yes Text" value="{{$data->yt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Insurance No Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="nt" placeholder="Filter No Text" value="{{$data->nt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Rating Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="frt" placeholder="Rating Heading Text" value="{{$data->frt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Upto 1 Star Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="u1s" placeholder="Upto 1 Star Text" value="{{$data->u1s}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Upto 2 Stars Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="u2s" placeholder="Upto 2 Stars Text" value="{{$data->u2s}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Upto 3 Stars Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="u3s" placeholder="Upto 3 Stars Text" value="{{$data->u3s}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Upto 4 Stars Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="u4s" placeholder="Upto 4 Stars Text" value="{{$data->u4s}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Upto 5 Stars Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="u5s" placeholder="Upto 5 Stars Text" value="{{$data->u5s}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Price Range Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fprt" placeholder="Price Range Heading Text" value="{{$data->fprt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Experience Years Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="feyt" placeholder="Experience Years Heading Text" value="{{$data->feyt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Select Years Placeholder Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fsyt" placeholder="Select Years Placeholder Text" value="{{$data->fsyt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Filter Button Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fbt" placeholder="Filter Button Text" value="{{$data->fbt}}" >
                                            </div>
                                          </div>

                                          <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Language Setting</button>   
                                            </div>

</div>

<div id="Cart" class="tabcontent" style="width: 95%;margin: auto;min-height: 700px;height: 700px;overflow-y: auto;overflow-x: hidden;">


                                          <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Cart Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sch" placeholder="Cart Heading Text" value="{{$data->sch}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Image Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="chi" placeholder="Handyman Image Heading Text" value="{{$data->chi}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Name Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="chn" placeholder="Handyman Name Heading Text" value="{{$data->chn}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="chs" placeholder="Handyman Service Heading Text" value="{{$data->chs}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Rate Type Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="chst" placeholder="Handyman Rate Type Heading Text" value="{{$data->chst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Rate Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="chr" placeholder="Rate Heading Text" value="{{$data->chr}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Demand Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="csd" placeholder="Service Demand Heading Text" value="{{$data->csd}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Date Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cbd" placeholder="Booking Date Heading Text" value="{{$data->cbd}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Total Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ctot" placeholder="Total Heading" value="{{$data->ctot}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Action Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cac" placeholder="Action Heading" value="{{$data->cac}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Fee Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="csf" placeholder="Service Fee Heading" value="{{$data->csf}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Price Including Tax *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cpit" placeholder="Price Including Tax" value="{{$data->cpit}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">VAT Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cvat" placeholder="VAT Heading" value="{{$data->cvat}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">VAT Amount Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cvatam" placeholder="VAT Amount Heading" value="{{$data->cvatam}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Price Excluding Tax *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cpet" placeholder="Price Excluding Tax" value="{{$data->cpet}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Continue Shopping Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ccs" placeholder="Continue Shopping Text" value="{{$data->ccs}}" >
                                            </div>

                                          </div>

                                            <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Checkout Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cc" placeholder="Checkout Text" value="{{$data->cc}}" >
                                            </div>

                                          </div>

                                            <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Select Payment Option Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cspo" placeholder="Select Payment Option Text" value="{{$data->cspo}}" >
                                            </div>

                                          </div>

                                            <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Full Payment Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cfp" placeholder="Full Payment Text" value="{{$data->cfp}}" >
                                            </div>
                                          </div>

                                            <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Partial Payment Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cpp" placeholder="Partial Payment Text" value="{{$data->cpp}}" >
                                            </div>
                                          </div>

                                            <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Partial Payment Note *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cppt" placeholder="Partial Payment Note" value="{{$data->cppt}}" >
                                            </div>
                                          </div>

                                           <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Payable Amount Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cpa" placeholder="Payable Amount Text" value="{{$data->cpa}}" >
                                            </div>
                                          </div>

                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Language Setting</button>   
                                            </div>

</div>

<div id="Handyman Panel" class="tabcontent" style="width: 95%;margin: auto;min-height: 700px;height: 700px;overflow-y: auto;overflow-x: hidden;">


                                            <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Panel Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hpt" placeholder="Handyman Panel Text" value="{{$data->hpt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                          <label class="control-label col-sm-4" for="contact_form_success_text">Invoice Header Booking Date Heading *</label>
                                          <div class="col-sm-6">
                                          <input id="contact_form_success_text" class="form-control" type="text" name="hbdih" placeholder="Invoice Header Booking Date Heading" value="{{$data->hbdih}}" >
                                          </div>
                                          </div>

                                          <div class="form-group">
                                          <label class="control-label col-sm-4" for="contact_form_success_text">Complete Profile Success Heading *</label>
                                          <div class="col-sm-6">
                                          <input id="contact_form_success_text" class="form-control" type="text" name="cmpsm1" placeholder="Complete Profile Success Heading" value="{{$data->cmpsm1}}" >
                                          </div>
                                          </div>

                                          <div class="form-group" >

                                          <label class="control-label col-sm-4" for="contact_form_success_text">Invoice Commission Heading *</label>
                                          <div class="col-sm-6">

                                          <input id="contact_form_success_text" class="form-control" type="text" name="hcp" placeholder="Invoice Commission Heading" value="{{$data->hcp}}" >

                                          </div>

                                          </div>

                                          <div class="form-group" >

                                          <label class="control-label col-sm-4" for="contact_form_success_text">Purchased Bookings Heading *</label>

                                          <div class="col-sm-6">

                                          <input id="contact_form_success_text" class="form-control" type="text" name="pbt" placeholder="Purchased Bookings Heading" value="{{$data->pbt}}" >

                                          </div>


                                          </div>

                                          <div class="form-group" >

                                            <label class="control-label col-sm-4" for="contact_form_success_text">Enter Service Rate Text *</label>

                                            <div class="col-sm-6">


                                              <input id="contact_form_success_text" class="form-control" type="text" name="esrt" placeholder="Enter Service Rate Text" value="{{$data->esrt}}" >


                                            </div>

                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Pick Up Multiple Dates Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pumdt" placeholder="Pick Up Multiple Dates Text" value="{{$data->pumdt}}" >
                                            
                                            </div>
                                          </div>


                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Registration Fee Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rft" placeholder="Registration Fee Text" value="{{$data->rft}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >

                                          <label class="control-label col-sm-4" for="contact_form_success_text">Excluding VAT Text *</label>

                                          <div class="col-sm-6">

                                          <input id="contact_form_success_text" class="form-control" type="text" name="rfevat" placeholder="Excluding VAT Text" value="{{$data->rfevat}}" >

                                          </div>


                                          </div>

                                          

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">My Sub Services Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="msst" placeholder="My Sub Services Heading" value="{{$data->msst}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">My Sub Services Note *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="mssn" placeholder="My Sub Services Note" value="{{$data->mssn}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Sub Services No Service Linked Note *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="mssn1" placeholder="Sub Services No Service Linked Note" value="{{$data->mssn1}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Select Sub Service Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ssst" placeholder="Select Sub Service Text" value="{{$data->ssst}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Add More Sub Service Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="amsst" placeholder="Add More Sub Service Text" value="{{$data->amsst}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Select Multiple Hours Note *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="smhn" placeholder="Select Multiple Hours Note" value="{{$data->smhn}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Images Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hbit" placeholder="Booking Images Heading" value="{{$data->hbit}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Images Photo Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hbipt" placeholder="Booking Images Photo Heading" value="{{$data->hbipt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Images Service Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hbist" placeholder="Booking Images Service Heading" value="{{$data->hbist}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Images Description Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hbidt" placeholder="Booking Images Description Heading" value="{{$data->hbidt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Images No Image Uploaded Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hbinit" placeholder="Booking Images No Image Uploaded Text" value="{{$data->hbinit}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Availability Management Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="avmt" placeholder="Availability Management Text" value="{{$data->avmt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Radius Management Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rm" placeholder="Radius Management Text" value="{{$data->rm}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Profile Update Request Success Message *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pusm" placeholder="Profile Update Request Success Message" value="{{$data->pusm}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">My Ratings Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hpmrt" placeholder="My Ratings Text" value="{{$data->hpmrt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Actual Rating Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="acrt" placeholder="Actual Rating Text" value="{{$data->acrt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Average Rating Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="avrt" placeholder="Average Rating Text" value="{{$data->avrt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Menu Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hmt" placeholder="Handyman Menu Text" value="{{$data->hmt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Dashboard Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hdt" placeholder="Handyman Dashboard Text" value="{{$data->hdt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">My Services Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="mst" placeholder="My Services Text" value="{{$data->mst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">My Bookings Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="mbt" placeholder="My Bookings Text" value="{{$data->mbt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Complete My Profile Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cmpt" placeholder="Complete My Profile Text" value="{{$data->cmpt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Experience Years Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="eyt" placeholder="Experience Years Text" value="{{$data->eyt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Insurance Settings Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ist" placeholder="Insurance Settings Text" value="{{$data->ist}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Postcode Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pct" placeholder="Postcode Text" value="{{$data->pct}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Radius Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rt" placeholder="Radius Text" value="{{$data->rt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Something Went Wrong Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sww" placeholder="Something Went Wrong Text" value="{{$data->sww}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Postal Code Error Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pcet" placeholder="Postal Code Error Text" value="{{$data->pcet}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Availability Manager Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="amt" placeholder="Availability Manager Text" value="{{$data->amt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Availability Manager Note *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="amm" placeholder="Availability Manager Note" value="{{$data->amm}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Selected Error Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sse" placeholder="Service Selected Error Text" value="{{$data->sse}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Deleted Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sdt" placeholder="Service Deleted Text" value="{{$data->sdt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Client's Photo Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cpht" placeholder="Client Photo Heading" value="{{$data->cpht}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Client's Name Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cnht" placeholder="Client Name Heading" value="{{$data->cnht}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoice Number Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="inht" placeholder="Invoice Number Heading" value="{{$data->inht}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Date Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hpbd" placeholder="Booking Date Heading" value="{{$data->hpbd}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Total Amount Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hpta" placeholder="Total Amount Heading" value="{{$data->hpta}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Status Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sht" placeholder="Status Heading" value="{{$data->sht}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Action Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hpa" placeholder="Action Heading" value="{{$data->hpa}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Cancelled Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cast" placeholder="Cancelled Status Text" value="{{$data->cast}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Pending Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pst" placeholder="Pending Status Text" value="{{$data->pst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Expired Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="est" placeholder="Expired Status Text" value="{{$data->est}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Partial Payment Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ppst" placeholder="Partial Payment Status Text" value="{{$data->ppst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Payment Pending Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ppest" placeholder="Payment Pending Status Text" value="{{$data->ppest}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Accept Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="acst" placeholder="Accept Status Text" value="{{$data->acst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Paid Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="past" placeholder="Paid Status Text" value="{{$data->past}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booked Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="bst" placeholder="Booked Status Text" value="{{$data->bst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Job Completed Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="jcst" placeholder="Job Completed Status Text" value="{{$data->jcst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Requested For Cancellation Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rfcst" placeholder="Requested For Cancellation Status Text" value="{{$data->rfcst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">View Booking Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="vbt" placeholder="View Booking Text" value="{{$data->vbt}}" >
                                            </div>
                                          </div>

                                          

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Are You Sure Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ayst" placeholder="Are You Sure Text" value="{{$data->ayst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Update Status Confirmation Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="uscm" placeholder="Update Status Confirmation Text" value="{{$data->uscm}}" >
                                            </div>
                                          </div>

                                           <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Cancelled Text <small>(For Popup)</small> *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cant" placeholder="Cancelled Text" value="{{$data->cant}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Status Update Cancelled Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="suct" placeholder="Status Update Cancelled Text" value="{{$data->suct}}" >
                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoice Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="it" placeholder="Invoice Heading Text" value="{{$data->it}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Negative Invoice Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="nit" placeholder="Negative Invoice Heading Text" value="{{$data->nit}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoiced At Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="iat" placeholder="Invoice At Text" value="{{$data->iat}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Client Information Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="clit" placeholder="Client Information Heading Text" value="{{$data->clit}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Information Heading Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hit" placeholder="Handyman Information Heading Text" value="{{$data->hit}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="iservt" placeholder="Service Heading" value="{{$data->iservt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Type Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="istt" placeholder="Service Type Heading" value="{{$data->istt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Demand Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="isdt" placeholder="Service Demand Heading" value="{{$data->isdt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Service Rate Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="isrt" placeholder="Service Rate Heading" value="{{$data->isrt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoice Booking Date Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ibdt" placeholder="Invoice Booking Date Heading" value="{{$data->ibdt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoice Total Amount Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="itat" placeholder="Invoice Total Heading" value="{{$data->itat}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Grand Total Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="gtt" placeholder="Grand Total Heading" value="{{$data->gtt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Amount Refund Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="art" placeholder="Amount Refund Heading" value="{{$data->art}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Amount Paid Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="apt" placeholder="Amount Paid Heading" value="{{$data->apt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoice VAT Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ivatt" placeholder="Invoice VAT Heading" value="{{$data->ivatt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoice Service Fee Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="isft" placeholder="Invoice Service Fee Heading" value="{{$data->isft}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Subtotal Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="isubtt" placeholder="Subtotal Heading" value="{{$data->isubtt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Complete Your Profile Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cypt" placeholder="Complete Your Profile Text" value="{{$data->cypt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Note Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cmpnt" placeholder="Note Text" value="{{$data->cmpnt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Complete My Profile Note *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cmpn" placeholder="Complete My Profile Note" value="{{$data->cmpn}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Complete My Profile Success Note *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cmpsm" placeholder="Complete My Profile Success Note" value="{{$data->cmpsm}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Go To Checkout Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="gtcp" placeholder="Go To Checkout Text" value="{{$data->gtcp}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Experience Years Note *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="eyn" placeholder="Experience Years Note" value="{{$data->eyn}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">For Example Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="fet" placeholder="For Example Text" value="{{$data->fet}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Experience Years Example *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="eyex" placeholder="Experience Years Example" value="{{$data->eyex}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Experience Years Error *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="eyer" placeholder="Experience Years Error" value="{{$data->eyer}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Experience Years Placeholder *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="eyp" placeholder="Experience Years Placeholder" value="{{$data->eyp}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Insurance Settings Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ish" placeholder="Insurance Settings Heading" value="{{$data->ish}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Insurance Settings Approved Note *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="isam" placeholder="Insurance Settings Approved Note" value="{{$data->isam}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Insurance Settings Note *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="isn" placeholder="Insurance Settings Note" value="{{$data->isn}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Status Update Success Message *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hbsm" placeholder="Booking Status Update Success Message" value="{{$data->hbsm}}" >
                                            </div>
                                          </div>

                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Language Setting</button>   
                                            </div>


</div>

<div id="Client Panel" class="tabcontent" style="width: 95%;margin: auto;min-height: 700px;height: 700px;overflow-y: auto;overflow-x: hidden;">


                                            <div class="form-group" style="margin-top: 30px;">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Client Panel Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cpt" placeholder="Client Panel Text" value="{{$data->cpt}}" >
                                            </div>
                                            </div>

                                            <div class="form-group" >

                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoice Header Booking Date Heading *</label>

                                            <div class="col-sm-6">

                                            <input id="contact_form_success_text" class="form-control" type="text" name="cbdih" placeholder="Invoice Header Booking Date Heading" value="{{$data->cbdih}}" >

                                            </div>

                                            </div>

                                            <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Enter Reason For Cancellation Placeholder *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="erfct" placeholder="Enter Reason For Cancellation Placeholder" value="{{$data->erfct}}" >
                                            
                                            </div>
                                          </div>



                                            <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Images Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cbit" placeholder="Booking Images Heading" value="{{$data->cbit}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Images Photo Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cbipt" placeholder="Booking Images Photo Heading" value="{{$data->cbipt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Images Service Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cbist" placeholder="Booking Images Service Heading" value="{{$data->cbist}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Images Description Heading *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cbidt" placeholder="Booking Images Description Heading" value="{{$data->cbidt}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group" >
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Images No Image Uploaded Text *</label>
                                            <div class="col-sm-6">
                                              
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cbinit" placeholder="Booking Images No Image Uploaded Text" value="{{$data->cbinit}}" >
                                            
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Client Menu Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cmt" placeholder="Client Menu Text" value="{{$data->cmt}}" >
                                            </div>
                                          </div>

                                          

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">My Bookings Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="mbt1" placeholder="My Bookings Text" value="{{$data->mbt1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Client Dashboard Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cdt" placeholder="Client Dashboard Text" value="{{$data->cdt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoice Number Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="inct" placeholder="Invoice Number Heading" value="{{$data->inct}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Status Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="sct" placeholder="Status Heading" value="{{$data->sct}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Action Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cpat" placeholder="Action Heading" value="{{$data->cpat}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Client Information Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="clit1" placeholder="Client Information Text" value="{{$data->clit1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Handyman Information Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="hit1" placeholder="Handyman Information Text" value="{{$data->hit1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Subtotal Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="subtt1" placeholder="Subtotal Text" value="{{$data->subtt1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Amount Paid Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="apt1" placeholder="Amount Paid Text" value="{{$data->apt1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Amount Refund Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="art1" placeholder="Amount Refund Text" value="{{$data->art1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Grand Total Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="gtt1" placeholder="Grand Total Text" value="{{$data->gtt1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">View Bookings Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cpvb" placeholder="View Bookings Text" value="{{$data->cpvb}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Paid Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="past1" placeholder="Paid Status Text" value="{{$data->past1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Payment Pending Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ppest1" placeholder="Payment Pending Status Text" value="{{$data->ppest1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Job Complete Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="jcst1" placeholder="Job Complete Text" value="{{$data->jcst1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Transfer Funds Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="tfst" placeholder="Transfer Funds Status Text" value="{{$data->tfst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booked Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="bst1" placeholder="Booked Status Text" value="{{$data->bst1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Request For Cancellation Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rfcst1" placeholder="Request For Cancellation Status Text" value="{{$data->rfcst1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Partial Payment Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ppst1" placeholder="Partial Payment Status Text" value="{{$data->ppst1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Complete Payment Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cpst" placeholder="Complete Payment Status Text" value="{{$data->cpst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Cancel Job Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cjst" placeholder="Cancel Job Status Text" value="{{$data->cjst}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Pending Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pst1" placeholder="Pending Status Text" value="{{$data->pst1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Cancelled Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cast1" placeholder="Cancelled Status Text" value="{{$data->cast1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Expired Status Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="est1" placeholder="Expired Status Text" value="{{$data->est1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Reason For Cancellation Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="rfct" placeholder="Reason For Cancellation Text" value="{{$data->rfct}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Send Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="send" placeholder="Send Text" value="{{$data->send}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Are You Sure Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ayst1" placeholder="Are You Sure Text" value="{{$data->ayst1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Update Status Confirmation Message *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="uscm1" placeholder="Update Status Confirmation Message" value="{{$data->uscm1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Cancelled Text<small>(For Popup)</small> *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cant1" placeholder="Cancelled Text" value="{{$data->cant1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Status Update Cancelled Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="suct1" placeholder="Status Update Cancelled Text" value="{{$data->suct1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Negative Invoice Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="nit1" placeholder="Negative Invoice Heading" value="{{$data->nit1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoice Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="it1" placeholder="Invoice Heading" value="{{$data->it1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Invoiced At Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="iat1" placeholder="Invoiced At Heading" value="{{$data->iat1}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Error Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="ert" placeholder="Error Text" value="{{$data->ert}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Please Give Rating Text *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="pgrt" placeholder="Please Give Rating Text" value="{{$data->pgrt}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Give Rating Heading *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="grn" placeholder="Give Rating Heading" value="{{$data->grn}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Booking Status Update Success Message *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cbsm" placeholder="Booking Status Update Success Message" value="{{$data->cbsm}}" >
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Job Cancel Status Update Success Message *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="cbjcm" placeholder="Job Cancel Status Update Success Message" value="{{$data->cbjcm}}" >
                                            </div>
                                          </div>

                                         
                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Language Setting</button>   
                                            </div>

</div>

                                          
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard FAQ Page -->
                </div>
            </div>
        </div>
    </div>
@endsection