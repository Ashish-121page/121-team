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

    }
</style>
<!-- Hero End -->
<!-- Start -->
<section class="">
    <div class="hero d-flex justify-content-center">

        <div class="progress-container">
            <div class="progress-bar" id="myBar"></div>
        </div>

        <span class=" text-break my-3 px-3 h3 ti">Book 7 Minutes Online Demo</span>

        <form
            action="https://docs.google.com/forms/u/0/d/e/1FAIpQLSejaBqSVzcFHQB4Zi2KTP4obPVjp_GMjJ6QmM74BCYKPL8FaA/formResponse"
            method="post">

            <!-- Hidden Section -->

            <div class="hidden_content">
                <input type="hidden" name="entry.974318119_hour" id="oghour">
                <input type="hidden" name="entry.974318119_minute" id="ogmin">
                <input type="hidden" name="entry.974318119_year" id="ogyear">
                <input type="hidden" name="entry.974318119_month" id="ogmonth">
                <input type="hidden" name="entry.974318119_day" id="ogday">
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
                    <label for="gname">Your Name <span class="text-red">*</span></label>
                    <small>Mr./Mrs.</small>
                    <input type="text" placeholder=". . . ." name="gname" class="my-2 form-control" id="gname" required>
                    <button type="button" class="btn btn-primary" onclick="next()">Ok <i
                            class="uil-check fs-5"></i></button>


                </div>
                <img src="{{ asset('storage/backend/booksession/name_1.svg') }}" class="img-1">
            </div>


            <!-- Section 2 -->

            <div class="cols p2">
                <div class="inpbx">
                    <label for="gphone">Your Phone <span class="text-red">*</span></label>
                    <small class="fs-6">You'll Get Meeting Login Details on Whatsapp</small>

                    <input type="number" placeholder="9 9 9 9 - 8 8 8 - 7 7 7" name="gphone" class="my-2 form-control"
                        maxlength="10" id="gphone" required style="width:250px">
                    <button type="button" class="btn btn-primary" onclick="next()">Ok <i
                            class="uil-check fs-5"></i></button>

                </div>
                <img src="{{ asset('storage/backend/booksession/contact.svg') }}" class="img-2">
            </div>


            <!-- Section 3 -->

            <div class="cols p3">

                <div class="inpbx">
                    <label for="email">Enter Your Email <span class="text-red">*</span></label>
                    <small class="fs-6">You'll Get Meeting Login Details on Email</small>

                    <input type="email" placeholder="sample@demo.com" name="email" class="my-2 form-control" id="email"
                        required>
                    <button type="button" class="btn btn-primary" onclick="next()">Ok <i
                            class="uil-check fs-5"></i></button>

                </div>

                <img src="{{ asset('storage/backend/booksession/social_1.svg') }}" class="img-3">
            </div>



            <!-- Section 4 -->

            <div class="cols p4">
                <div class="inpbx">
                    <label for="gdate">Select Session Time <span class="text-red">*</span></label>

                    <input type="date" name="gdate" id="gdate" class="my-2 form-control" required min="2023-08-16">
                    <input type="time" name="gtime" id="gtime" class="my-2 form-control" min="10:30" max="18:00"
                        required>
                    <small class="fs-6">Choose Between 10:30 to 18:00</small>
                    <br>
                    <button type="submit" class="btn btn-primary submit">Submit</button>
                </div>
                <img src="{{ asset('storage/backend/booksession/time1.svg') }}" class="img-submit" style="transform: scale(80%);">
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

    });
</script>
@endsection