<!DOCTYPE html>
<html>
  <head>
      <title>W3.CSS Template</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}</style>
      {!! Html::script('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') !!} 
  </head>
  <body class="w3-light-grey">
    <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
      <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
      <span class="w3-bar-item w3-right"> 
          <form id="logout-form" action="{{ route('logout') }}" method="POST">
              {{ csrf_field() }}
              <button type="submit" class="w3-btn w3-red w3-ripple w3-block w3-small" href="{{ route('logout') }}" >Çıkış Yap</button>
          </form> 
      </span>
      <span class="w3-bar-item w3-left">Admin Paneli</span>
    </div>
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
      <div class="w3-container w3-row">
        <div class="w3-col s4">
          <img src="/images/{{ Auth::user()->picture }}" class=" w3-margin-right" style="width:70px">
        </div>
        <div class="w3-col s8 w3-bar">
          <span><strong>{{ Auth::user()->name }}</strong></span><br><br>
          <a href="/admin/mesaj" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
          <a href="/admin/profil" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
          <a href="/admin/ayarlar" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
        </div>
      </div>
      <hr> 
      <div class="w3-bar-block">
        <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Kapat</a>
        <a href="/admin" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Anasayfa</a>
        <a href="/admin/yazilar" class="w3-bar-item w3-button w3-padding"><i class="fa fa-eye fa-fw"></i>  Yazılar</a>
        <a href="/admin/kategoriler" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bank fa-fw"></i>  Kategoriler</a>
        <a href="/admin/kullanicilar" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Kullanıcılar</a>
        <a href="/admin/mesajlar" class="w3-bar-item w3-button w3-padding"><i class="fa fa-envelope fa-fw"></i>  Mesajlar</a> 
        <a href="/admin/ayarlar" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Ayarlar</a><br><br>
      </div>
    </nav>
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
      @yield('body') 
      <footer class="w3-container w3-black"> 
        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
      </footer> 
    </div> 
    <script>
      var mySidebar = document.getElementById("mySidebar");
      var overlayBg = document.getElementById("myOverlay");
      function w3_open() {
        if (mySidebar.style.display === 'block') {
          mySidebar.style.display = 'none';
          overlayBg.style.display = "none";
        } else {
          mySidebar.style.display = 'block';
          overlayBg.style.display = "block";
        }
      }
      function w3_close() {
        mySidebar.style.display = "none";
        overlayBg.style.display = "none";
      }
    </script> 
  </body>
</html>