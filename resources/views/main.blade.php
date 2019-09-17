<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title', 'Anıl Şenocak - Laravel6.0 Blog Template')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        {!! Html::style('css/w3.css') !!}
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <style>body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}</style>
        <link rel="shortcut icon" href="https://laravel.com/img/logomark.min.svg" type="image/x-icon">
        {!! Html::style('css/prism.css') !!}
        {!! Html::script('js/prism.js') !!}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>img{max-width:100%;max-height:100%;}</style>
        {!! Html::script('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') !!} 
        @yield('stylesheet')
    </head>
    <body class="w3-light-grey">
        <div class="w3-content" style="max-width:1800px">
            <header class="w3-container w3-center w3-padding-32"> 
                <h1><b><a href="/" style="text-decoration: none">Anıl Şenocak</a></b></h1>
                <p>@yield('kategoriler')</p>
            </header> 
            @if(Session::has('hata'))<span class="w3-tag w3-round w3-red w3-block" style="padding:3px"><span class="w3-tag w3-round w3-red w3-border w3-border-white  w3-block">{{ Session::get('hata') }}</span></span>@endif
            @if(Session::has('basarı'))<span class="w3-tag w3-round w3-green w3-block" style="padding:3px"><span class="w3-tag w3-round w3-green w3-border w3-border-white  w3-block">{{ Session::get('basarı') }}</span></span>@endif
            <div class="w3-row">
                <div class="w3-col l8 s12">
                    @yield('body')
                </div>
                <div class="w3-col l4">   
                    <p class="mesaj_gonderildi w3-margin w3-container w3-green" style="display: none;">If you click on the "Hide" button, I will disappear.</p> 
                    <script type="text/javascript"> 
                        $(document).ready(function(){  
                            $(".mesaj_gonderildi").hide();
                            $(".mail_gonder_btn").click(function(e){  
                                e.preventDefault(); 
                                $.ajax({
                                    type:'POST',
                                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                                    url:'{{ route('email_onayla') }}', 
                                    success:function(data){ 
                                        $(".mesaj_gonderildi").show();
                                        if (data == 1) {  
                                            $(".mesaj_gonderildi").text("Kod Mailinize Gönderildi.");
                                        } else { 
                                            $(".mesaj_gonderildi").text("Hata Meydana Geldi.");
                                        }
                                    } 
                                });
                            });
                        });
                    </script>   
                    <div class="w3-card w3-margin ">
                        @if(Auth::check())
                            <div class="w3-bar">
                                @if (Auth::user()->email_verified_at)
                                    <span class="w3-bar-item w3-right"><i class="fa fa-check" title="Email Adresi Onaylanmış"></i></span>
                                @endif
                                @if (Auth::user()->is_admin == 1)
                                    <span class="w3-bar-item w3-right"><i class="fa fa-star" title="Admin Yetkili Kullanıcı"></i></span>
                                @endif 
                                <img src="/images/{{ Auth::user()->picture }}" class="w3-bar-item w3-c ircle w3-hide-small" style="width:80px">
                                <span class="w3-large w3-margin w3-center">{{ Auth::user()->name }}</span><br>
                                <span class="w3-margin w3-center">{{ Auth::user()->email }}</span><br>
                                <div class="w3-cell-row">
                                    <div class="w3-cell">
                                        <a class="w3-btn w3-green w3-ripple w3-block" href="/profil">Profil</a>
                                    </div>
                                    @if (Auth::user()->is_admin == 1 || Auth::user()->email_verified_at != null)
                                        <div class="w3-cell">
                                            <a class="w3-btn w3-black w3-ripple w3-block" href="/admin">Admin Paneli</a>
                                        </div>
                                    @endif 
                                    <div class="w3-cell">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            {{ csrf_field() }}
                                            <button type="submit" class="w3-btn w3-red w3-ripple w3-block" href="{{ route('logout') }}" >Çıkış Yap</button>
                                        </form>
                                    </div>
                                    @if (Auth::user()->email_verified_at == null)
                                        <div class="w3-cell"> 
                                            <form action="{{ route('email_onayla') }}" method="POST">
                                                {{ csrf_field() }}
                                                <button type="submit" class="w3-btn w3-blue w3-ripple w3-block mail_gonder_btn">Mail Onayla</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>  
                            </div>
                        @else
                            <div class="w3-bar w3-black">
                                <button class="w3-bar-item w3-button tablink w3-red" onclick="openCity(event,'login')">Giriş Yap</button>
                                <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'register')">Kayıt Ol</button> 
                            </div> 
                            <div id="login" class="w3-container w3-border auth">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <p><input type="email" class="w3-input w3-border" required="" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}"></p> 
                                    <p><input type="password" class="w3-input w3-border" required="" placeholder="{{ __('Password') }}" name="password"></p>
                                    <p><input class="w3-check w3-border" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>{{ __('Remember Me') }}</p>
                                    <p><button type="submit" class="w3-button w3-block w3-green">{{ __('Login') }} &nbsp; ❯</button></p>
                                </form>
                            </div>
                            <div id="register" class="w3-container w3-border auth" style="display:none"> 
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <p>
                                        <input type="text" class="w3-input w3-border" required="" placeholder="{{ __('İsminiz') }}" name="name" value="{{ old('name') }}">
                                        @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </p> 
                                    <p>
                                        <input type="email" class="w3-input w3-border" required="" placeholder="{{ __('E-Mail Adresiniz') }}" name="email" value="{{ old('email') }}">
                                        @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </p>
                                    <p>
                                        <input type="password" class="w3-input w3-border" required="" placeholder="{{ __('Şifreniz') }}" name="password" autocomplete="new-password">
                                        @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </p> 
                                    <p>
                                        <input type="password" class="w3-input w3-border" required="" placeholder="{{ __('Şifreniz Tekrar') }}" name="password_confirmation" autocomplete="new-password">
                                    </p>
                                    <p><button type="submit" class="w3-button w3-block w3-green">{{ __('Kayıt Ol') }} &nbsp; ❯</button></p>
                                </form> 
                            </div>
                        @endif
                    </div>
                    <hr>
                    <!-- Posts -->
                    <div class="w3-card w3-margin">
                        <div class="w3-container w3-padding"><h4>Son Yorumlar</h4></div>
                        <ul class="w3-ul w3-hoverable w3-white">
                            @yield('yorumlar')
                        </ul>
                    </div>
                    <hr>  
                    <div class="w3-card w3-margin w3-margin-top">
                        <img src="/images/pp.jpg" style="width:100%">
                            <div class="w3-container w3-white">
                            <h4>
                                <b>Anıl Şenocak</b>
                                <div  class="w3-right">
                                    <a href="https://github.com/senocak" target="_blank"><i class="fa fa-github"></i></a>
                                    <a href="https://linkedin.com/in/anilsenocak27" target="_blank"><i class="fa fa-linkedin"></i></a>
                                </div>
                            </h4>
                            <p>Love to play, Play to ride, Ride to live, Live to love </p>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <footer class="w3-container w3-padding-32 w3-margin-top" style="height: 250px;background-image: url({{url('/')}}/images/footer.png);background-position-x: -120px;background-position-y: 0px;"></footer>
        <script>
            function openCity(evt, authName) {
                var i, x, tablinks;
                x = document.getElementsByClassName("auth");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablink");
                for (i = 0; i < x.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
                }
                document.getElementById(authName).style.display = "block";
                evt.currentTarget.className += " w3-red";
            }
        </script> 
    </body>
</html>