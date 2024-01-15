
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rembg API</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
        .changecolorbtn{
            height: 50px;
            width: 50px;
            margin: 0 5px;
            border-radius: 50%;
        }
        #colorPicker{
            padding: 0;
            width: 150%;
            height: 150%;
            margin: -25%;
        }
        .wrapper-color {
            overflow: hidden;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: 1px 1px 3px 0px grey;   
        }

    </style>



</head>
<body>
    <div class="container">
        <h1>Rembg API</h1>
        <form action="{{ url('dev/sendremovebg') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="image" class="form-label">Select Image:</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            {{-- <button type="submit" class="btn btn-outline-primary">Upload</button> --}}
        </form>
    </div>

    <h5>Response</h5>
    <p id="resposnee"></p>

    <div class="row">
        <div class="col-6 d-flex flex-column">
            <span>Original Background</span>
            <img id="imagePrevieworiginal" src="#" alt="Image Preview" style="display:none;"/>
        </div>
        <div class="col-6 d-flex flex-column">
            <span>Removed Background</span>
            <img src="" alt="preview" id="imagepreview" class="d-none">

        </div>
    </div>

    <div class="row mt-2">
        <div class="col-6 d-flex">
            <span class="changecolorbtn" data-color="#6666cc"></span>
            <span class="changecolorbtn" data-color="#f1f1f1"></span>
            <span class="changecolorbtn" data-color="#111111"></span>
            <span class="changecolorbtn" data-color="#cccccc"></span>
            
            <div class="wrapper-color">
                <input type="color" id="colorPicker" value="#800080">
            </div>

        </div>
        <div class="col-6">
            <button id="downloadBtn" class="btn btn-outline-primary">Download Image</button>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var imagePreview = document.getElementById('imagePrevieworiginal');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            
            reader.readAsDataURL(file);
        });

        function changeColor(color){
            $("#imagepreview").css("background-color", color);
            console.log(`Background color changed to ${color}`);
        }

        function readycolor(){
            $(".changecolorbtn").each(function(){
                var color = $(this).attr("data-color");
                $(this).css("background-color", color);
            });
        }

    </script>
    <script>
        $(document).ready(function() {
            readycolor();

            $("#colorPicker").on('input', function(){
                var selectedColor = $(this).val();
                // $("#myImage").css("background-color", selectedColor);
                changeColor(selectedColor)
            });

            $(".changecolorbtn").click(function (e) { 
                changeColor($(this).attr("data-color"));
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#image').on('change', function() {
                var formData = new FormData();
                formData.append('image', $('#image')[0].files[0]); // Append the file
                $.ajax({
                    url: '{{ url('dev/sendremovebg') }}', // Your server-side script or API endpoint
                    type: 'POST',
                    data: formData,
                    contentType: false, // Important: Don't set any content type header
                    processData: false, // Important: Do not process the data
                    success: function(response) {
                        // Handle success
                        $("#resposnee").html(response);
                        const data = JSON.parse(response);
                        $("#imagepreview").removeClass('d-none');
                        $("#imagepreview").attr("src", data.url);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        $("#resposnee").html(error);
                    }
                });
            });
            // $("#imagepreview").on('load', function() {
            //     // Adding Up Download Button and Function
            //     $("#downloadBtn").click(function(){
            //         var image = document.getElementById('imagepreview');
            //         var canvas = document.createElement('canvas');
            //         canvas.width = image.width;
            //         canvas.height = image.height;
            //         var ctx = canvas.getContext('2d');

            //         // Fill background
            //         ctx.fillStyle = $("#imagepreview").css("background-color");
            //         ctx.fillRect(0, 0, canvas.width, canvas.height);

            //         // Draw image
            //         ctx.drawImage(image, 0, 0);

            //         // Download
            //         var link = document.createElement('a');
            //         link.download = 'modified-image.png';
            //         link.href = canvas.toDataURL();
            //         link.click();
            //     });

            // });



        });
    </script>

</body>
</html>

