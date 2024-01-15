@php

DB::table('refer')
->where('id', 2) // Demo (BookSession)
->increment('view_count', 1);

@endphp


@extends('frontend.layouts.main')

@section('meta_data')
@php
$meta_title = '7 Minutes Online Demo | ' . getSetting('app_name');
$meta_description = '' ?? getSetting('seo_meta_description');
$meta_keywords = '' ?? getSetting('seo_meta_keywords');
$meta_motto = '' ?? getSetting('site_motto');
$meta_abstract = '' ?? getSetting('site_motto');
$meta_author_name = '' ?? 'GRPL';
$meta_author_email = '' ?? 'Hello@121.page';
$meta_reply_to = '' ?? getSetting('frontend_footer_email');
$meta_img = ' ';
$no_header = 1;
$no_footer = 1;
@endphp
@endsection

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body{
        height: 100%;
    }

    .hero {
        width: 100vw;
        height: 100vh;
        user-select: none;
        font-size: 1.5rem;
    }

    .hero form .cols {
        display: flex;
        flex-direction: row;
        align-items: center !important;
        justify-content: space-between;
        height: 100vh;
    }

    .hero form .cols label {
        display: block;
        margin-bottom: 10px;
    }

    .text-red {
        color: red;
    }

    .hero form .cols .inpbx {
        align-items: center;
        margin-right: auto;
        margin-left: 5rem;

    }

    .img-1,
    .img-2,
    .img-3 {
        max-height: 40rem;
    }

    .img-1 {
        padding: 7rem 1rem;
        margin-left: 19.5rem;

    }

    .img-2 {
        height: 40rem;
    }

    small {
        margin: 1.2rem 0;
        font-size: 1.3rem;

    }

    .ti {
        display: block;
        position: absolute;
        top: 2vh !important;
        width: 100vw !important;
        text-align: center;
    }

    .hero form .cols .inpbx input {
        height: 2rem;
        border: none;
        border-bottom: 1px solid;
        width: 25rem;
        display: block;
        padding-left: 0.5rem;

    }

    .hero form .cols img {
        padding: 5rem 10rem
    }

    .img-submit {
        height: 88vh;
        width: 50%;
        /* padding: 0 !important; */
    }

    .submit {
        background-color: #6666CC;
        color: white;
        border: 1px solid #6666CC;
        font-size: 1.2rem !important;
        margin: 10px 0;
        transition: 0.3s all;
        opacity: 0.9;
    }

    .submit:hover {
        opacity: 0.8;
    }

    .controlbtn {
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        font-size: 1.8rem;
    }

    .controlbtn span {
        padding: 5px;
        border: none;
        margin: 0 0 0 20px;
        transition: 0.3s all;
        cursor: pointer;
        background-color: #6666CC;
        color: white;

    }

    .controlbtn span:hover {
        border-radius: 8px;
    }



    /* The progress container (grey background) */
    .progress-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 8px;
        background: #ccc;
    }

    /* The progress bar (scroll indicator) */
    .progress-bar {
        height: 8px;
        background: #6666CC !important;
        width: 0%;
    }

    .water {
        position: fixed;
        bottom: 1rem;
        left: 1rem;
        font-size: 0.8rem;
    }

    form {
        scroll-snap-type: y mandatory !important;
    }

    .cols {
        scroll-snap-align: start !important;
        display: flex !important;
        justify-content: center;

    }


    @media only screen and (max-width: 600px) {
        .hero form .cols {
            display: flex;
            flex-direction: column-reverse;
            align-items: center !important;
            justify-content: space-between;
            /* margin-bottom: 3rem; */
            height: 100vh !important;
            /* border: 2px solid red; */
            overflow: hidden;

        }

        .img-1 {
            margin-left: 10rem !important;
            margin-top: 5rem !important;
        }


        .ti {
            top: 0vh !important;
            font-size: 1.2rem !important;
        }

        .hero form .cols .inpbx {
            align-items: center;
            margin-right: 0;
            margin-left: 10%;
            margin-top: 10%;
            margin-right: 10%;
            width: 100%;
            padding-left: 2rem;
            height: 35vh;
        }

        .hero form .cols .inpbx input {
            margin: 1rem 0;
            width: 80%;
            padding-left: 1rem;
            border-radius: 10px;

        }


        .hero form .cols img {
            height: 50vh;
            width: 100%;
            /* margin-bottom: 10vh; */
            padding: 0rem 0rem;
            /* margin-top: 10rem; */
        }
        .img-2,.img-3{
            padding: 2rem !important;
        }

        .img-submit {
            height: 88vh;
            width: 50%;
            padding: 0 !important;
            margin-top: 0 !important;
        }

        .controlbtn {
            position: fixed;
            bottom: 1rem;
            right: 10%;
            font-size: 1.8rem;
        }


        /* .hero form .inpbx:nth-child(odd) {
            height: 40vh;
        } */
        .form-check-input{

        }
    

    }
</style>
<!-- Hero End -->
<!-- Start -->
<section class="">
    <div class="hero d-flex justify-content-center">

        <div class="progress-container">
            <div class="progress-bar" id="myBar"></div>
        </div>       
        <form
            action="forms/d/e/1FAIpQLSecMyXvlfocH8rJJ0KNVA1xy9tjXVZFBW7EfdlbycdVw98Zig/formResponse" 
            method="post">

            <!-- Hidden Section -->
            <div class="hidden_content">
                <input type="hidden" name="entry.975582590" id="assign">
                <input type="hidden" name="entry.1652210707" id="highPriorityCheckbox">
                <input type="hidden" name="" id="ogyear">
                <input type="hidden" name="entry.879293343" id="refr">
                <input type="hidden" name="entry.112864257" id="work1">
                <input type="hidden" name="entry.857368045" id="ogname">
                <input type="hidden" name="entry.348108511" id="ogphone">
                <input type="hidden" name="entry.479807686" id="ogmail">                
            </div>

            <!-- Hidden Section -->



            <!-- Section 1 -->



            <!-- Section 2 -->
            <div class="cols p1 active">
                <div class="inpbx">
                    <div class="row">                    
                    <label>What is The Work <span class="text-red">*</span> </label>
                    <input type="text" placeholder=". . . ." name="work1" class="my-2 form-control" id="work1" required> 
                </div>
                <div class="row mt-4">
                    <label for="refr">Reference</label>                                
                    <input type="text" placeholder="" name="refr" class="my-2 form-control" id="refr" required>  
                </div> 
                <div class="row mt-4">
                    <label for="assign">Assign to </label>               
                    <select name="assign" class="my-2 form-control " id="assign" required>
                        <option value="choose">Choose</option>
                        <option value="option1">Ashish</option>
                        <option value="option2">Dolly</option>
                        <option value="option3">Harish</option>
                        <option value="option4">Jaya</option>
                        <option value="option5">Saurabh</option>
                        <option value="option6">Waitlist</option>
                        <option value="option7"></option>
                    </select> 
                </div>               
                                  
                </div>              
            </div>
           
              <div class="cols p2">
                <div class="inpbx">
                    <div class="row">
                        <label for="startdate">Work Start Date<span class="text-red">*</span></label>                        
                        <input type="date" name="startdate" id="startdate" class="my-2 form-control" required min="2023-08-16"> 
                    </div>
                    <div class="row mt-4">
                        <label for="pdate">Plan Date</label>                        
                        <input type="date" name="pdate" id="pdate" class="my-2 form-control" required min="2023-08-16"> 
                    </div>
                    <div class="row mt-4"> 
                        <label for="highPriorityCheckbox">Priority<span class="text-red">*</span></label>
                        <div class="form-group" >
                            <input class="form-check-input" type="checkbox" value="high" id="highPriorityCheckbox" >
                            <label class="form-check-label" style="width:90%;" for="highPriorityCheckbox">High Priority</label>                                                           
                        </div>
                    </div>
                    <div class="mt-5 align-items-center ">
                        <button type="submit" class="btn btn-primary submit ">Submit</button>
                    </div>
             </div>
           
                           
        </form>

        <div class="controlbtn">
            <span title="Click To Previous" data-input="8" id="prev"><i
                    class="uil-angle-up"></i></span>
            <span title="Click To Next" data-input="8" id="next"><i class="uil-angle-down"></i></span>
        </div>
        <span class="text-muted water" title="121.page">121.page</span>
    </div>


</section>
{{-- <form id="resendOtpForm"   action="{{ route('user-enquiry.questions.store') }}" method="post">
<input type="hidden" name="phone" value="">
</form> --}}
<!--end section-->
<!-- End -->
@endsection
@section('InlineScript')
<script>
    $(document).ready(function(){
  // Function to move to the next field
  function moveToNextField(currentField, nextField) {
    $(currentField).removeClass('active'); // Remove 'active' class from current field
    $(nextField).addClass('active'); // Add 'active' class to next field
    $(nextField).find('input, select').first().focus(); // Focus on the first input/select in the next field
  }

  // Listen for keyup event on input fields and select dropdown

  $("#assign").change(function (e) { 
    e.preventDefault();
    $("#Nextbtn").click();
});

$("#highPriorityCheckbox")

  // Functionality for the 'Next' button click
  $('#next').on('click', function(){
    var currentField = $('.cols.active');
    var nextField = currentField.next('.cols');

    if (nextField.length !== 0) {
      moveToNextField(currentField, nextField);
    } else {
      $('form').submit(); // Submit the form if there are no more fields
    }
  });

//   // Functionality for the 'Previous' button click
  $('#prev').on('click', function(){
    var currentField = $('.cols.active');
    var prevField = currentField.prev('.cols');

    if (prevField.length !== 0) {
      moveToNextField(currentField, prevField);
    }
  });
});



   
</script>
@endsection