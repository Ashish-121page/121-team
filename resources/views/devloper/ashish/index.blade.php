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

    @php
        // $curretpage = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $curretpage = "https://121.page/panel/dashboard";
        $msg = "Hey I got Something New on The Internet That Help You!! \n\n $curretpage \n\n You Can Use this To Groww Your Business";
        
    @endphp  

    {!!
    Share::page(urlencode($msg), 'Share title')
	->facebook()
	->twitter()
	->linkedin('Extra linkedin summary can be passed here')
	->whatsapp(); !!}

</body>
</html>