<!DOCTYPE html>
<html>
  <head>
      <title>W3.CSS Template</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      {!! Html::style('css/w3.css') !!}
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}</style>
      {!! Html::script('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') !!} 
      {!! Html::script('https://code.jquery.com/ui/1.12.1/jquery-ui.js') !!}
      @yield('stylesheet')
  </head>
  <body class="w3-light-grey" style="padding-top: 1px;">
    
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:235px;" id="mySidebar"><br>
      <div class="w3-container w3-row">
        <div class="w3-col s4">
          <img src="/images/{{ Auth::user()->picture }}" class=" w3-margin-right" style="width:75px">
        </div>
        <div class="w3-col s8 w3-bar w3-right"  style="padding-left: 10px;"> 
          <span>{{ Auth::user()->name }}</span>
          <i class="fa fa-bars" onclick="kapat_ac();"></i>
          @if(Auth::user()->is_admin ==1)<i class="fa fa-star" title="Admin Yetkili Kullanıcı" style="color:green"></i>@endif
          <br><br>
          <form id="logout-form" action="{{ route('logout') }}" method="POST">
              {{ csrf_field() }}
              <button type="submit" class="w3-btn w3-red w3-ripple w3-block w3-padding-tiny" href="{{ route('logout') }}" >Çıkış Yap</button>
          </form> 
        </div>
      </div>
      <hr> 
      <div class="w3-bar-block"> 
        <a href="/admin" class="w3-bar-item w3-button w3-padding  @if(Request::segment(2)  == "") w3-blue @endif"><i class="fa fa-users fa-fw"></i>  Anasayfa</a>
        <a href="/admin/yazilar" class="w3-bar-item w3-button w3-padding  @if(Request::segment(2)  == "yazilar") w3-blue @endif"><i class="fa fa-eye fa-fw"></i>  Yazılar</a>
        <a href="/admin/kategoriler" class="w3-bar-item w3-button w3-padding  @if(Request::segment(2)  == "kategoriler") w3-blue @endif"><i class="fa fa-bank fa-fw"></i>  Kategoriler</a>
        <a href="/admin/yorumlar" class="w3-bar-item w3-button w3-padding  @if(Request::segment(2)  == "yorumlar") w3-blue @endif"><i class="fa fa-comment fa-fw"></i>  Yorumlar</a> 
        <a href="/admin/kullanicilar" class="w3-bar-item w3-button w3-padding  @if(Request::segment(2)  == "kullanicilar") w3-blue @endif"><i class="fa fa-users fa-fw"></i>  Kullanıcılar</a>
      </div>
    </nav>
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
    <div class="w3-main" style="margin-left:240px;" id="body"> 
      @yield('body') 
      <footer class="w3-container w3-black" style="position:fixed;right: 0;bottom: 0;left: 0;text-align: center;"> 
        <p>
          Anıl Şenocak 
          <a href="https://github.com/senocak" target="_blank"><i class="fa fa-github w3-right"></i></a> 
          <a href="https://linkedin.com/in/anilsenocak27" target="_blank"><i class="fa fa-linkedin w3-right"></i></a>
        </p>
      </footer> 
    </div> 
    <script> 
      var mySidebar = document.getElementById("mySidebar");
      var bodybar = document.getElementById("body");
      function kapat_ac() { 
        console.log(mySidebar.style.display);
        if (mySidebar.style.display == "none" || mySidebar.style.display == "") {
          mySidebar.style.setProperty('display', 'block', 'important');
          bodybar.style.marginLeft = "240px";
        } else {
          mySidebar.style.setProperty('display', 'none', 'important');
          bodybar.style.marginLeft = "0";
        } 
      }
    </script> 
    @yield('scripts')
  </body>
</html>