<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ashish Test Page</title>
    <link rel="stylesheet" href="{{ asset("backend/plugins/fontawesome-free/css/all.min.css") }}">
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    
</head>
<body>


    <div class="container ">
        <form method="post" enctype="multipart/form-data">
            @csrf
            <label for="file">Select File</label>
            <div class="form-group">
                <input type="file" name="images" class="form-control">
            </div>
            <input type="submit" value="submit" class="btn btn-outline-primary my-2" name="submt">
        </form>

    </div>

    


</body>
</html>