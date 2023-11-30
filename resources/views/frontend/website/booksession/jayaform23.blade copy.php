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

        <span class=" text-break my-3 px-3 h3 ti">New DTask and Rtask</span>

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
                <!---Name-->
                <input type="hidden" name="entry.348108511" id="ogphone">
                <!---phone-->
                <input type="hidden" name="entry.479807686" id="ogmail">
                <!---Email-->
            </div>

            <!-- Hidden Section -->



            <!-- Section 1 -->

            <div class="cols p1 active">
                <div class="inpbx">
                    <label for="gname">What Do You</label>
                    <select name="reference" class="my-2 form-control w-100" id="reference" required>
                        <option value="">Choose</option>
                        <option value="option1">D. Task</option>
                        <option value="option2">R. Task</option>
                        
                      </select>
                    {{-- <button type="button" class="btn btn-primary" onclick="next()">Ok <i
                            class="uil-check fs-5"></i></button> --}}
                </div>
                {{-- <img src="{{ asset('storage/backend/booksession/name_1.svg') }}" class="img-1"> --}}
            </div>


            <!-- Section 2 -->
            <div class="cols p2 active">
                <div class="inpbx">
                    <label for="gname">Add D.Task</label>
                    <small>What is The Work <span class="text-red">*</span> </small>
                    <input type="text" placeholder=". . . ." name="work1" class="my-2 form-control" id="work1" required>                   
                </div>
                {{-- <img src="{{ asset('storage/backend/booksession/name_1.svg') }}" class="img-1"> --}}
            </div>

            <div class="cols p3 active">
                <div class="inpbx">
                    <label for="gname">Reference
                    <small></small>
                    </label>
                    <input type="text" placeholder=". . . ." name="refr" class="my-2 form-control" id="refr" required>
                    {{-- <button type="button" class="btn btn-primary" onclick="next()">Ok <i
                            class="uil-check fs-5"></i></button> --}}
                </div>
                
            </div>

            <div class="cols p4 active">
                <div class="inpbx">
                  <label for="">Assign to
                    <small></small>
                  </label>
                  <select name="reference" class="my-2 form-control w-100" id="assign" required>
                    <option value="">Choose</option>
                    <option value="option1">Ashish</option>
                    <option value="option2">Dolly</option>
                    <option value="option3">Harish</option>
                    <option value="option4">Jaya</option>
                    <option value="option5">Saurabh</option>
                    <option value="option6">Waitlist</option>
                    <option value="option7"></option>
                  </select>
                  {{-- <button type="button" class="btn btn-primary" onclick="next()">Ok <i
                    class="uil-check fs-5"></i></button> --}}
                </div>
              </div>

              <div class="cols p5">
                <div class="inpbx">
                    <label for="gdate">Work Start Date<span class="text-red">*</span></label>
                    <small>Date</small>
                    <input type="date" name="gdate" id="gdate" class="my-2 form-control" required min="2023-08-16">                                                           
                </div>
             </div>
            <div class="cols p6">
                <div class="inpbx">
                    <label for="gdate">Plan Date</label>
                    <small>Date</small>
                    <input type="date" name="gdate" id="gdate" class="my-2 form-control" required min="2023-08-16">                                                            
                </div>                                
            </div>

            <div class="cols p7 justify-content-start">
                <div class="">
                  <label for="priority">Priority<span class="text-red">*</span></label>
                  <div class="form-group" >
                    <input class="form-check-input" type="checkbox" value="high" id="highPriorityCheckbox" >
                    <label class="form-check-label" style="width:90%;" for="highPriorityCheckbox">High Priority</label>
                  </div>
                 
                </div>
              </div>
              
              {{-- <div class="cols p7">
                <div class="">
                  <label for="priority">Priority<span class="text-red">*</span></label>
                  <div class="form-check1   " style="width:100%; height:100%;">
                    <input class="form-check-input" type="checkbox" value="high" id="highPriorityCheckbox" style="width:10%; border:1px solid">
                    <label class="form-check-label" style="width:90%;" for="highPriorityCheckbox">High Priority</label>
                  </div>
                  <div class="form-check" style="width:100%; height:100%;">
                    <input class="form-check-input" type="checkbox" value="other" id="otherPriorityCheckbox" style="width:10%; border:1px solid">
                    <label class="form-check-label" for="otherPriorityCheckbox">Other</label>
                    <textarea class="form-control" style="width:90%;" id="otherPriorityTextArea" rows="3" disabled></textarea>
                  </div>
                </div>
              </div> --}}

              

            


            <!-- Section 3 -->

            



            <!-- Section 4 -->

            {{-- <div class="cols p8
            ">
                <div class="inpbx">
                    <label for="gdate">Select Session Time <span class="text-red">*</span></label>

                    <input type="date" name="gdate" id="gdate" class="my-2 form-control" required min="2023-08-16">
                    <input type="time" name="gtime" id="gtime" class="my-2 form-control" min="10:30" max="18:00"
                        required>
                    <small class="fs-6">Choose Between 10:30 to 18:00</small>
                    <br>
                    <button type="submit" class="btn btn-primary submit">Submit</button>
                </div> --}}
                {{-- <img src="{{ asset('storage/backend/booksession/time1.svg') }}" class="img-submit" style="transform: scale(80%);"> --}}
            {{-- </div> --}}
            <button type="submit" class="btn btn-primary submit">Submit</button>

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
    // When the user scrolls the page, execute myFunction
    window.onscroll = function () {
        myFunction()
    };

    $("form").submit(function (e) { 
        // e.preventDefault();
        window.open("https://www.121.page");
    });
    
    function myFunction() {
        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var scrolled = (winScroll / height) * 100;
        document.getElementById("myBar").style.width = scrolled + "%";
    }


    let currSlide = 1;
    const SLIDE_LENGTH = $('.cols').length;
    $("#next").click(function () {
        currSlide = currSlide === SLIDE_LENGTH ? 1 : ++currSlide;
        // console.log(currSlide);
        $('html,body').animate({
                scrollTop: $(`.p${currSlide}`).offset().top
            },
            'slow');
    });


    $("#prev").click(function () {
        console.log(currSlide);
        $('html,body').animate({
                scrollTop: $(`.p${currSlide}`).offset().top -  $(`.p${currSlide}`).outerHeight()
            },
            'slow');
        currSlide = currSlide === SLIDE_LENGTH ? 1 : --currSlide;
    });



    function next() {
        currSlide = currSlide === SLIDE_LENGTH ? 1 : ++currSlide;
        // console.log(currSlide);
        $('html,body').animate({
                scrollTop: $(`.p${currSlide}`).offset().top
            },
            'slow');

    }



    // for Updating a Google Form Feilds

    // For name
    $("#gname").on('keyup', function () {
        var a = $(this).val();
        $("#ogname").val(a)
    });

    // For Phone
    $("#gphone").on('keyup', function () {
        var a = $(this).val();
        $("#ogphone").val(a)
    });

    // For Email
    $("#email").on('keyup', function () {
        var a = $(this).val();
        $("#ogmail").val(a)
    });


    // for date month and year

    $('#gdate').on('change', function () {
        var newVal = $(this).val().split(
                '-'), //renamed new_val to newVal, always stick to one naming convention
            dateParts = {
                year: parseInt(newVal[0], 10),
                month: parseInt(newVal[1], 10),
                day: parseInt(newVal[2], 10)
            };
        console.log(dateParts);
        $("#ogyear").val(dateParts.year)
        $("#ogmonth").val(dateParts.month)
        $("#ogday").val(dateParts.day)


    });

    $('#gtime').on('change', function () {
        var newVal = $(this).val().split(
                ':'), //renamed new_val to newVal, always stick to one naming convention
            timeParts = {
                hour: parseInt(newVal[0], 10),
                min: parseInt(newVal[1], 10)
            };

        $("#oghour").val(timeParts.hour)
        $("#ogmin").val(timeParts.min)


        const fields = document.querySelectorAll('.inpbx input, .inpbx select');

        fields.forEach(field => {
        field.addEventListener('keyup', (event) => {
            const nextField = event.target.nextElementSibling;
            if (nextField && event.target.value) {
            // Focus on the next field if it exists and the current field has a value
            nextField.focus();
            }
        });
        });


        
    // const otherPriorityCheckbox = document.getElementById('otherPriorityCheckbox');
    // const otherPriorityTextArea = document.getElementById('otherPriorityTextArea');

    // otherPriorityCheckbox.addEventListener('change', () => {
    //   otherPriorityTextArea.disabled = !otherPriorityCheckbox.checked;
    // });

  

    });
</script>
@endsection