<?php
//var_dump($_GET['id']);
if (isset($_GET['id'])){
  $mac = $_GET['id'];
  $ap = $_GET['ap'];
Session::set('mac', $mac);
Session::set('ap', $ap);
session('mac');
}else{
    //return redirect()->away('http://epointnet.com');
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
    <div class="col-center-block">
     <p class="text-center" style="color: #fff;">Registrate con Facebook para navegar</p>
    </div>
   </div>
   <div class="row">
   
    <div class="col-sm-4 center-block" style="float:none; padding:0px">
    <a class="btn btn-block btn-social btn-lg  btn-facebook" href="auth/login/facebook">
    <i class="fa fa-facebook"></i>Sign in with Facebook</a>
   </div>
   <br>
   <p class="text-center" style="color: #fff;">Ó</p>
    <div class="col-sm-4 center-block" style="float:none; padding:0px">
    <a class="btn btn-block btn-lg  btn-reddit" href="login">
    Ingresa Tus Datos</a>
   </div>
   </div>
   <div class="row">
    <p class="text-center" style="margin-top:166px;">E-point de Mexico S.A. de C.V.</p>
  </div>
   </div>
        <script src="/assets/js/main.js"></script>
    </body>
</html>
