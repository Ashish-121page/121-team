<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer FeedBack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css");
        body {
            overflow-x: hidden;
        }
        label{
            color: black !important;
        }
        /* The progress container (grey background) */
        .progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            z-index: 99999;
            background: #ccc;
        }
        /* The progress bar (scroll indicator) */
        .progress-bar {
            height: 8px;
            background: #6666CC !important;
            width: 0%;
        }
        section {
            height: 100vh;
            width: 100%;
        }
        section .row {
            height: 100%;
        }
        section .row .col-md-6 img {
            height: 100%;
        }
        .fb {
            width: 42rem !important;
            align-items: center;
        }
        .ash{
            margin-left: 2rem;
        }
        .page-1 input[type=text] {
            background-color: transparent;
            border: none;
            outline: none;
            height: 8rem;
            width: 35rem;
            font-size: 1.5rem;
            border-bottom: 1px solid black;
        }
        .page-1 input[type=text]::placeholder {
            font-size: 2rem;
        }
        .desc {
            width: 55rem;
            text-align: justify;
            word-spacing: 2px;
        }
        /* .page-2 {
            background: url(/storage/backend/feedback/img2.jpg);
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            backdrop-filter: grayscale(100%);
        } */
        .matrix-response {
            margin-top: 2rem;
            width: 42rem;
        }
        .mybox {
            margin: 10px 0 !important;
        }
        .mybox td .form-bx input {
            width: 2rem;
            cursor: pointer;
        }
        .bro {
            padding: 10px !important;
        }
        /* .page-4 {
            background: url(/storage/backend/feedback/img3.jpg);
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            backdrop-filter: grayscale(100%);
        } */
        .page-4 input[type=text] {
            background-color: transparent;
            border: none;
            outline: none;
            height: 8rem;
            font-size: 1.5rem;
            border-bottom: 1px solid white;
            color: white;
        }
        .page-4 input[type=text]::placeholder {
            font-size: 2rem;
            color: white;
        }
        /*

        .page-5 {
            background: url(/storage/backend/feedback/img2.jpg);
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            backdrop-filter: grayscale(100%);
        } */

        .page-5 input[type=text] {
            background-color: transparent;
            border: none;
            outline: none;
            height: 8rem;
            font-size: 1.5rem;
            border-bottom: 1px solid white;
            color: white;
        }
        .page-5 input[type=text]::placeholder {
            font-size: 2rem;
            color: white;
        }.page-5 input[type=text] {
            background-color: transparent;
            border: none;
            outline: none;
            height: 8rem;
            font-size: 1.5rem;
            border-bottom: 1px solid white;
            color: white;
        }
        .page-5 input[type=text]::placeholder {
            font-size: 2rem;
            color: white;
        }

        .navigation {
            position: fixed;
            bottom: 2%;
            right: 2%;
            z-index: 9999;
        }
        .navigation button {
            padding: 9px;
        }
        .watermark {
            position: fixed;
            z-index: 9999;
            bottom: 2.5%;
            left: 0.5rem;
            background-color: #fff;
            padding: 5px;
            border-radius: 5px;
        }
        label{
            cursor: pointer;
        }
        .table input[type="radio"]+label i{
            padding:8px;
            height:1rem;
            width: 1rem;
        }
        .table input[type="radio"]:checked+label i {
            /* background-color: #6666CC !important; */
            border-radius: 50%;
            color: #6666CC !important;
        }
        input[type="text"]{
            border-bottom: 1px solid #111 !important;
            color: black !important;
        }
        input[type="text"]::placeholder{
            color: black !important;
        }

        @media only screen and (max-width: 600px) {

            .page-1 .row {
                overflow: hidden;
            }

            .page-1 .fb {
                background-color: #fff;
                position: relative;
                height: 100%;
                align-items: start;
            }

            .page-1 input[type=text] {
                background-color: transparent;
                border: none;
                outline: none;
                height: 8rem;
                width: 20rem;
                font-size: 1.5rem;
                border-bottom: 1px solid black;
            }

            .page-1 input[type=text]::placeholder {
                font-size: 1.3rem;
            }

            .page-2 .row .bg {
                margin-left: 0rem;
                width: 100%;
                text-align: left;
            }

            .page-2 .matrix-response {
                width: 90vw;
            }

            .page-3{
                overflow: hidden;
            }
            .page-3 .fb {
                background-color: #fff;
                position: relative;
                height: 100%;
                align-items: start;
                margin-top: -80px;
            }


            .page-3 .matrix-response {
                width: 90vw;
                margin-left: 9rem;
            }
            .dn{
                margin-left: 9rem;
                width: 25rem;
            }


            .page-4 .row .bg {
                margin-left: 0rem;
                width: 100%;
                text-align: left;
                color: white;
            }

            .page-4 input[type=text] {
                background-color: transparent;
                border: none;
                outline: none;
                height: 8rem;
                width: 20rem;
                font-size: 1.5rem;
                border-bottom: 1px solid black;
            }



            .page-5 .row .bg {
                margin-left: 0rem;
                width: 100%;
                text-align: left;
                color: white;
            }

            .page-5 input[type=text] {
                background-color: transparent;
                border: none;
                outline: none;
                height: 8rem;
                width: 20rem;
                font-size: 1.5rem;
                border-bottom: 1px solid black;
            }

            .desc {
                width: 20rem;
            }

            .navigation {
                top: 90%;
                left: 75%;
                z-index: 9999;
            }
            .watermark {
                position: fixed;
                z-index: 9999;
                bottom: 2.5%;
                left: 0.5rem;
            }
            .hfhds{
                margin-left: -10%;
            }
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="progress-container">
            <div class="progress-bar" id="myBar"></div>
        </div>

        <div class="navigation">
            <button class="btn  btn-primary" id="prev" type="button">
                <i class="bi bi-caret-up"></i>
            </button>
            <button class="btn  btn-primary mx-1" id="next" type="button">
                <i class="bi bi-caret-down"></i>
            </button>
        </div>

{{-- <form action="https://docs.google.com/forms/u/0/d/e/1FAIpQLSeYQfJsm1ik6W-DwQN0HqRcfFxTNW6V9LPG5w80kVMI610C3w/formResponse" method="POST"> --}}
<form action="{{ route('feedbackform.store') }}" method="POST">
        <div class="container-fluid">
            <section class="page-1">
                <div class="row d-flex">
                    <div class="col-md-6">
                        <img src="{{ asset('/storage/backend/feedback/welcome.svg') }}" class="img-fluid rounded ash" alt="Image 1" width="80%">
                    </div>
                    <div class="col-md-6 d-flex align-items-center ">
                        <div class="form-bx px-3">
                            <label for="entry.1134233759" class="form-label h4"> <span class="text-info">1 -> </span> Your Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control my-3 shadow-none" placeholder="Typer here …" name="entry.1134233759" autocomplete="off" id="entry.1134233759" style=" height: 3.5rem;" required>
                                <button class="btn btn-primary" onclick="next()" type="button">Next</button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="page-2 mb-5">
                <div class="row">
                    <div class="col-md-6 p-2">
                        <img src="{{asset('storage/backend/feedback/img2.svg')}}" class="img-fluid rounded ash" alt="Image 1" width="80%">
                    </div>
                    <div class="col-md-6 d-flex justify-content-center flex-column  bg">
                        <div class="form-bx px-3">
                            <label for="name" class="form-label h3 "> <span class="text-info">2 -> </span> How was the demo ? <span class="text-danger">*</span></label>
                            <br>
                            <div class="desc fs-5 d-none">
                                <small>Tell Us So We Can Improve.</small>
                            </div>
                        </div>
                        <div class="matrix-response">
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center"></th>
                                            <th scope="col">Great</th>
                                            <th scope="col">Good</th>
                                            <th scope="col" class="text-center">OK</th>
                                            <th scope="col" class="text-center">Needs Improvement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="mybox">
                                            <td scope="row" class="w-50 bro">
                                            Value anticipated from 121.page
                                            </td>
                                            <td>
                                                <div class="form-bx">
                                                    <input type="radio" class="form-check d-none" name="entry.1400368396" id="Greatq1" value="Great" required>
                                                    <label for="Greatq1">
                                                        <i class="bi bi-emoji-smile fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-bx">
                                                    <input type="radio" class="form-check d-none" name="entry.1400368396" id="Goodq1" value="Good" required>
                                                    <label for="Goodq1">
                                                        <i class="bi bi-emoji-laughing fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-bx px-4">
                                                    <input type="radio" class="form-check d-none" name="entry.1400368396" id="satisfactoryq1" value="Satisfactory" required>
                                                    <label for="satisfactoryq1">
                                                        <i class="bi bi-emoji-laughing fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-bx px-4">
                                                    <input type="radio" class="form-check d-none" name="entry.1400368396" id="unsatisfactoryq1" value="Unsatisfactory" required>
                                                    <label for="unsatisfactoryq1">
                                                        <i class="bi bi-emoji-angry fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- row 2 -->
                                        <tr class="mybox">
                                            <td scope="row" class="w-50 bro">
                                                Video clarity - during demo
                                            </td>
                                            <td>
                                                <div class="form-bx">
                                                    <input type="radio" class="form-check d-none" name="entry.1552551473" id="Greatq2" value="Great" required>
                                                    <label for="Greatq2">
                                                        <i class="bi bi-emoji-smile fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-bx">
                                                    <input type="radio" class="form-check d-none" name="entry.1552551473" id="Goodq2" value="Good" required>
                                                    <label for="Goodq2">
                                                        <i class="bi bi-emoji-laughing fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-bx px-4">
                                                    <input type="radio" class="form-check d-none" name="entry.1552551473" id="Satisfactoryq2" value="Satisfactory" required>
                                                    <label for="Satisfactoryq2">
                                                        <i class="bi bi-emoji-wink fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-bx px-4">
                                                    <input type="radio" class="form-check d-none" name="entry.1552551473" id="unsatisfactoryq2" value="Unsatisfactory" required>
                                                    <label for="unsatisfactoryq2">
                                                        <i class="bi bi-emoji-angry fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Row 3 -->
                                        <tr class="mybox">
                                            <td scope="row" class="w-50 bro">
                                                Audio clarity - during demo
                                            </td>
                                            <td>
                                                <div class="form-bx">
                                                    <input type="radio" class="form-check d-none" name="entry.254315716" id="Greatq3" value="Great" required>
                                                    <label for="Greatq3">
                                                        <i class="bi bi-emoji-smile fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-bx">
                                                    <input type="radio" class="form-check d-none" name="entry.254315716" id="Goodq3" value="Good" required>
                                                    <label for="Goodq3">
                                                        <i class="bi bi-emoji-laughing fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-bx px-4">
                                                    <input type="radio" class="form-check d-none" name="entry.254315716" id="Satisfactoryq3" value="Satisfactory" required>
                                                    <label for="Satisfactoryq3">
                                                        <i class="bi bi-emoji-wink fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-bx px-4">
                                                    <input type="radio" class="form-check d-none" name="entry.254315716" id="unsatisfactoryq3" value="Unsatisfactory" required>
                                                    <label for="unsatisfactoryq3">
                                                        <i class="bi bi-emoji-angry fs-3"></i>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-sm btn-primary my-2"  onclick="next()" type="button">Next</button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="page-3">
                <div class="row">
                    <div class="col-md-6 p-2 mt-5">
                        <img src="{{ asset('/storage/backend/feedback/img3.svg') }}" class="img-fluid rounded ash" alt="Image 1" width="60%">
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center flex-column ">
                        <div class="form-bx px-3 mt-3 fb">
                            <label for="name" class="form-label dn h4"> <span class="text-info">3 -> </span>
                            <!-- Tell Something About our Duration of demo  -->
                            Duration of Demo <span class="text-danger">*</span>
                            </label>
                            <div class="matrix-response">
                                    <div class="table-responsive">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Too quick</th>
                                                <th scope="col">Perfect</th>
                                                <th scope="col">Too long</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="mybox">
                                                <td scope="row" class="fs-4">Introduction</td>
                                                <td>
                                                    <div class="form-bx">
                                                        <input type="radio" class="form-check d-none" name="entry.904323925" id="q2a" value="Too quick" required>
                                                        <label for="q2a">
                                                            <i class="bi bi-emoji-smile fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-bx">
                                                        <input type="radio" class="form-check d-none" name="entry.904323925" id="q2b" value="Perfect" required>
                                                        <label for="q2b">
                                                            <i class="bi bi-emoji-laughing fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-bx px-4">
                                                        <input type="radio" class="form-check d-none" name="entry.904323925" id="q3c" value="Too long" required>
                                                        <label for="q3c">
                                                            <i class="bi bi-emoji-angry fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="mybox">
                                                <td scope="row" class="fs-4">Demo</td>
                                                <td>
                                                    <div class="form-bx">
                                                        <input type="radio" class="form-check d-none"  name="entry.1181307444" id="q2a2" value="Too quick" required>
                                                        <label for="q2a2">
                                                            <i class="bi bi-emoji-smile fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-bx">
                                                        <input type="radio" class="form-check d-none"  name="entry.1181307444" id="q2b2" value="Perfect" required>
                                                        <label for="q2b2">
                                                            <i class="bi bi-emoji-laughing fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-bx px-4">
                                                        <input type="radio" class="form-check d-none"  name="entry.1181307444" id="q2c2" value="Too long" required>
                                                        <label for="q2c2">
                                                            <i class="bi bi-emoji-angry fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="mybox">
                                                <td scope="row" class="fs-4">FAQ</td>
                                                <td>
                                                    <div class="form-bx">
                                                        <input type="radio" class="form-check d-none"  name="entry.1854430268" id="q4a" value="Too quick" required>
                                                        <label for="q4a">
                                                        <i class="bi bi-emoji-smile fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-bx">
                                                        <input type="radio" class="form-check d-none"  name="entry.1854430268" id="q4b" value="Perfect" required>
                                                        <label for="q4b">
                                                        <i class="bi bi-emoji-laughing fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-bx px-4">
                                                        <input type="radio" class="form-check d-none"  name="entry.1854430268" id="q4c" value="Too long" required>
                                                        <label for="q4c">
                                                        <i class="bi bi-emoji-angry fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="mybox">
                                                <td scope="row" class="fs-4">Offers and Packages</td>
                                                <td>
                                                    <div class="form-bx">
                                                        <input type="radio" class="form-check d-none"  name="entry.972276528" id="q54a" value="Too quick" required>
                                                        <label for="q54a">
                                                        <i class="bi bi-emoji-smile fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-bx">
                                                        <input type="radio" class="form-check d-none"  name="entry.972276528" id="q54as" value="Perfect" required>
                                                        <label for="q54as">
                                                        <i class="bi bi-emoji-laughing fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-bx px-4">
                                                        <input type="radio" class="form-check d-none"  name="entry.972276528" id="q54sa" value="Too long" required>
                                                        <label for="q54sa">
                                                        <i class="bi bi-emoji-angry fs-3"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-sm btn-primary my-2"  onclick="next()" type="button">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="page-4">
                <div class="row ash">

                    <div class="col-md-6">
                        <img src="{{ asset('/storage/backend/feedback/img-4.svg') }}" class="img-fluid rounded ash" alt="Image 1" width="65%">
                    </div>
                    <div class="col-md-6 d-flex justify-content-center flex-column">
                        <div class="form-bx hfhds">
                            <label for="name" class="form-label h3"> <span class="text-info">4 -> </span>
                            <!-- Any other suggestions -->
                            Any suggestions ?
                        </label>
                            <br>
                            <div class="desc fs-5">
                                <small>
                                    <!-- We welcome your suggestions & feedback.
                                    <br> -->
                                    - Any features that can help your business
                                    <!-- - related to cataloguing  -->
                                    <br>
                                    - Any additional tips based on your demo / using 121.page
                                </small>
                            </div>
                            <input type="text" class="form-control my-3 shadow-none" placeholder="Type here .. " name="entry.962971201" autocomplete="off" id="suggest">
                            <button class="btn btn-sm btn-primary"  onclick="next()" type="button">Next</button>
                        </div>
                    </div>

                </div>
            </section>
            <section class="page-5">
                <div class="row">

                    <div class="col-md-6 d-flex align-items-center justify-content-center flex-column bg ">
                        <div class="form-bx px-3 w-100">
                            <label for="name" class="form-label h3"> <span class="text-info">5 -> </span>
                            <!-- Any questions that we can further answer? -->
                            Any questions we missed?
                        </label>
                            <br>
                            <div class="desc fs-5 d-none">
                                <small>
                                </small>
                            </div>
                            <input type="text" class="form-control my-3 shadow-none" placeholder="Type here .. " name="entry.2138732357" autocomplete="off" id="other_suggestion">
                            <button class="btn btn-md btn-success" type="submit">Submit</button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <img src="{{ asset('/storage/backend/feedback/img-5.svg') }}" class="img-fluid ash rounded" alt="Image 1" width="80%">
                    </div>
                </div>
            </section>
        </div>
    </form>
    <span class="watermark text-muted">Powerd By 121.page</span>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        // When the user scrolls the page, execute myFunction
        window.onscroll = function () {
            myFunction()
        };
        function myFunction() {
            var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("myBar").style.width = scrolled + "%";
        }
        let currSlide = 1;
        const SLIDE_LENGTH = $('section').length;
        $("#next").click(function () {
            currSlide = currSlide === SLIDE_LENGTH ? 1 : ++currSlide;
            $('html,body').animate({
                    scrollTop: $(`.page-${currSlide}`).offset().top
                },'slow');
        });
        $("#prev").click(function () {
            $('html,body').animate({
                    scrollTop: $(`.page-${currSlide}`).offset().top - $(`.page-${currSlide}`).outerHeight()
                },'slow');
            currSlide = currSlide === SLIDE_LENGTH ? 1 : --currSlide;
        });
        function next() {
            currSlide = currSlide === SLIDE_LENGTH ? 1 : ++currSlide;
            $('html,body').animate({
                    scrollTop: $(`.page-${currSlide}`).offset().top
                },'slow');
        }

        document.addEventListener("keydown", function(event) {
            if(event.which == 13){
                event.preventDefault()
                next();
            }
        })


    </script>
</body>
</html>
