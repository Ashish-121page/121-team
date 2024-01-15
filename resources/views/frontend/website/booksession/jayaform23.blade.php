@php

    DB::table('refer')
        ->where('id', 2) // Demo (BookSession)
        ->increment('view_count', 1);

@endphp


@extends('frontend.layouts.main')

@section('meta_data')
    @php
        $meta_title = 'Dtask | ' . getSetting('app_name');
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
        /* Existing Styles... */

        @media only screen and (max-width: 600px) {
            .hero {
                font-size: 1rem;
                /* Smaller font size for mobile */
            }

            .hero form .cols {
                flex-direction: column;
                align-items: stretch;
                /* Stack items vertically */
                justify-content: flex-start;
                height: auto;
                /* Adjust height for mobile */
                padding: 1rem;
                /* Add some padding */
            }

            .hero form .cols .inpbx {
                margin: 0;
                /* Remove left margin for mobile */
                width: 100%;
                /* Full width */
                padding: 0.5rem 0;
                /* Adjust padding */
            }

            .hero form .cols .inpbx input,
            .hero form .cols .inpbx select {
                width: 100%;
                /* Full width for inputs */
                padding: 0.5rem;
                /* Larger padding for touch targets */
            }

            .hero form .cols img {
                max-width: 100%;
                /* Ensure images are responsive */
                height: auto;
                /* Adjust height accordingly */
                padding: 0.5rem 0;
                /* Adjust padding */
            }

            .img-submit {
                width: 100%;
                /* Full width for images */
                margin-top: 0;
            }

            .submit {
                width: 50%;
                /* Full width for submit button */
                padding: 0.8rem;
                /* Increase padding for mobile */
            }

            .controlbtn {
                right: 5%;
                /* Adjust position */
                bottom: 0.5rem;
                /* Adjust position */
                font-size: 1.5rem;
                /* Larger size for easier tapping */
            }

            .text-red {
                font-size: 1rem;
                /* Adjust text size for readability */
            }

            /* Adjust the position of specific elements if necessary */
            .img-1,
            .img-2,
            .img-3 {
                padding: 0;
                /* Remove padding for mobile */
                margin: 0;
                /* Remove margin for mobile */
            }

            .img-1 {
                margin-left: auto;
                /* Center align */
                margin-right: auto;
                margin-top: 2rem;
                /* Adjust top margin */
            }
        }
    </style>

    <!-- Hero End -->
    <!-- Start -->
    <section class="" style="margin-top: 15px;">
        <div class="hero d-flex justify-content-center">

            <div class="progress-container">
                <div class="progress-bar" id="myBar"></div>
            </div>


            <form
                action="https://docs.google.com/forms/u/0/d/e/1FAIpQLSecMyXvlfocH8rJJ0KNVA1xy9tjXVZFBW7EfdlbycdVw98Zig/formResponse"
                method="post">

                <!-- Hidden Section -->

                <div class="hidden_content">
                    <input type="hidden" name="entry.137550352" value="D. Task"> <!-- For Dtask -->

                </div>
                <div class="row active mx-2">
                    <div class="cols p1 ">
                        <div class="inpbx">
                            <div class="row">
                                <label>What is The Work <span class="text-danger">*</span> </label>
                                <input type="text" placeholder=". . . ." name="entry.112864257" class="my-2 form-control"
                                    id="work1" required>
                            </div>
                            <div class="row mt-2">
                                <label for="refr">Reference</label>
                                {{-- <input type="text" placeholder="" name="entry.879293343" class="my-2 form-control" id="refr" >   --}}
                                <textarea name="entry.879293343" class="form-control" id="refr" cols="30" rows="2"></textarea>
                            </div>
                            {{-- https://docs.google.com/forms/d/e/1FAIpQLSeEpw0l1apLLTJGPdRG3_WR84ZEH4GmIpCnmzGZvJG4Mym19A/viewform?usp=pp_url&entry.975582590=sda --}}

                            <div class="row mt-2">
                                <label for="assign">Assign to <span class="text-danger">*</span></label>

                                {{-- <select name="entry.975582590" style="width: 50%" class="my-2 form-control " id="assign">
                            <option value="">Choose</option>
                            <option value="Ashish">Ashish</option>
                            <option value="Dolly">Dolly</option>
                            <option value="Harish">Harish</option>
                            <option value="Jaya">Jaya</option>
                            <option value="Saurabh">Saurabh</option>
                            <option value="Nikitaa">Nikitaa</option>
                            <option value="Waitlist">Waitlist</option>
                        </select> --}}

                                <input list="team-members" name="entry.975582590" style="width: 100%"
                                    class="my-2 form-control " id="assign" placeholder="Member Name">
                                <datalist id="team-members">
                                    <option value="Ashish">
                                    <option value="Jaya">
                                    <option value="Saurabh">
                                    <option value="Nikitaa">
                                    <option value="Subhash">
                                    <option value="Waitlist">
                                </datalist>


                            </div>

                        </div>
                    </div>
                </div>
                <div class="row mt-2 mx-2">
                    <div class="cols p2">
                        <div class="inpbx">
                            <div class="row">
                                <label for="startdate">Work Start Date<span class="text-danger">*</span></label>
                                <input type="date" name="entry.448684861" id="startdate" class="my-2 form-control"
                                    required min="2023-08-16">
                            </div>
                            <div class="row mt-2">
                                <label for="pdate">Plan Dates</label>
                                <input type="date" name="entry.323973282" id="pdate" class="my-2 form-control"
                                    required min="2023-08-16">
                            </div>
                            <div class="row mt-2">
                                <label for="highPriorityCheckbox">Priority<span class="text-danger">*</span></label>
                                <div class="form-group d-flex align-items-center">

                                    <label class="form-check-label mr-2 mt-3" for="highPriorityCheckbox">High</label>
                                    <input type="checkbox" style="width: 15rem; height:1rem; margin-top:20px;"
                                        value="High" name="entry.1652210707" id="highPriorityCheckbox">
                                </div>
                            </div>

                            <div class="mt-3 align-items-center ">
                                <button type="submit" class="btn btn-primary submit">Submit</button>
                            </div>
                        </div>




            </form>

            <!-- <div class="controlbtn">
                        <span title="Click To Previous" data-input="8" id="prev"><i
                                class="uil-angle-up"></i></span>
                        <span title="Click To Next" data-input="8" id="next"><i class="uil-angle-down"></i></span>
                    </div> -->
            <span class="text-muted water" title="121.page">121.page</span>
        </div>
        </div>


    </section>
@endsection
@section('InlineScript')
    <script>
        $(document).ready(function() {

            var today = new Date().toISOString().split('T')[0];
            $('#startdate').val(today);
            $('#pdate').val(today);

            // Function to move to the next field
            function moveToNextField(currentField, nextField) {
                $(currentField).removeClass('active'); // Remove 'active' class from current field
                $(nextField).addClass('active'); // Add 'active' class to next field
                $(nextField).find('#highPriorityCheckbox, #work1').first()
            .focus(); // Focus on the first input/select in the next field
            }

            // Listen for keyup event on input fields and select dropdown

            $("#assign").change(function(e) {
                // e.preventDefault();
                $("#Nextbtn").click();
            });

            $("#highPriorityCheckbox")

            // Functionality for the 'Next' button click
            $('#next').on('click', function() {
                var currentField = $('.row.active');
                var nextField = currentField.next('.row');

                if (nextField.length !== 0) {
                    moveToNextField(currentField, nextField);
                } else {
                    //   $('form').submit(); // Submit the form if there are no more fields
                }
            });

            // Functionality for the 'Previous' button click
            $('#prev').on('click', function() {
                var currentField = $('.row.active');
                var prevField = currentField.prev('.row');

                if (prevField.length !== 0) {
                    moveToNextField(currentField, prevField);
                }
            });
        });




        //
    </script>
@endsection
