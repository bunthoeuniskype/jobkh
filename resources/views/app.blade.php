
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Feed</title>
         <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>   
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
        <!-- Styles -->
      
    </head>
    <body>
     <div id="example"></div>	
     
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script> 	
    </body>
</html>
