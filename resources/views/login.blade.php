<?php
//var_dump($_GET['id']);
if (Session::has('mac')) {
  session::get('mac');
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/assets/js/docs.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.js"></script>
        <link rel="stylesheet" href="/assets/css/main.css" />
        <link rel="stylesheet" href="/assets/css/bootstrap-social.css" />
        <link rel="stylesheet" href="/assets/css/bootstrap.css" />
        <link rel="stylesheet" href="/assets/css/docs.css" />
        <link rel="stylesheet" href="/assets/css/font-awesome.css" />
        <!-- Styles -->
        
    </head>
    <body>
        <div class="container" style="margin-top:0px; padding-right:inherit">
   <div class="row" style="margin-bottom:4em">
    <div class="col-center-block">
     <img class="center-block" src="/images/logo.png"  style="width:280px;" />
    </div>
   </div>
   <div class="row">
   
    <form action="store" method="post">
  <div class="form-group">
    <label for="name">Nombre Completo:</label>
    <input type="name" class="form-control" name="name">
  </div>
  <div class="form-group">
    <label for="phone">Telefono:</label>
    <input type="name" class="form-control" name="phone">
  </div>
  <div class="form-group">
    <label for="email">Correo Electronico:</label>
    <input type="name" class="form-control" name="email">
  </div>
  <input type="hidden" name="_token" value="{{csrf_token()}}">
  <input type="submit" name="submit" value="submit" class="text-center">
</form>
   </div>
   <div class="row">
    <p class="text-center" style="margin-top:166px;">E-point de Mexico S.A. de C.V.</p>
  </div>
   </div>
        <script src="/assets/js/main.js"></script>
    </body>
</html>
