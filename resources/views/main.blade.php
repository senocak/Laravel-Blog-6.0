<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title', 'Anıl Şenocak - Laravel6.0 Blog Template')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <style>body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}</style>
        <link rel="shortcut icon" href="https://laravel.com/img/logomark.min.svg" type="image/x-icon">
        {!! Html::style('css/prism.css') !!}
        {!! Html::script('js/prism.js') !!}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>img{max-width:100%;max-height:100%;}</style>
    </head>
    <body class="w3-light-grey">
        <div class="w3-content" style="max-width:1800px">
            <header class="w3-container w3-center w3-padding-32"> 
                <h1><b><a href="/" style="text-decoration: none">Anıl Şenocak</a></b></h1>
                <p>@yield('kategoriler')</p>
            </header>
            <div class="w3-row">
                <div class="w3-col l8 s12">
                    @yield('body')
                </div>
                <div class="w3-col l4">
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
                    <hr>
                    <!-- Posts -->
                    <div class="w3-card w3-margin">
                        <div class="w3-container w3-padding"><h4>Son Yorumlar</h4></div>
                        <ul class="w3-ul w3-hoverable w3-white">
                            @yield('yorumlar')
                        </ul>
                    </div>
                    <hr> 
                    <div class="w3-card w3-margin ">
                        @if(Auth::check())
                            <div class="w3-bar">
                                @if (Auth::user()->is_admin == 1)
                                    <span class="w3-bar-item w3-right"><i class="fa fa-check" title="Admin Hesabı"></i></span>
                                @endif
                                <img src="/images/img_avatar6.png" class="w3-bar-item w3-circle w3-hide-small" style="width:80px">
                                <span class="w3-large w3-margin w3-center">{{ Auth::user()->name }}</span><br>
                                <span class="w3-margin w3-center">{{ Auth::user()->email }}</span><br>
                                <div class="w3-row">
                                    <div class="w3-half">
                                        <a class="w3-btn w3-black w3-ripple w3-block" href="/admin">Admin Paneli</a>
                                    </div>
                                    <div class="w3-half"> 
                                            
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            {{ csrf_field() }}
                                            <button type="submit" class="w3-btn w3-red w3-ripple w3-block" href="{{ route('logout') }}" >Çıkış Yap</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w3-container w3-center "><h4>Giriş Yap</h4></div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <p><input type="email" class="w3-input w3-border" required="" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}"></p> 
                                <p><input type="password" class="w3-input w3-border" required="" placeholder="{{ __('Password') }}" name="password"></p>
                                <p><input class="w3-check w3-border" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>{{ __('Remember Me') }}</p>
                                <div class="w3-row">
                                    <div class="w3-half">
                                        <button type="submit" class="w3-button w3-block w3-teal">{{ __('Login') }} &nbsp; ❯</button>
                                    </div>
                                    <div class="w3-half"> 
                                        @if (Route::has('password.request')) 
                                            <a class="w3-btn w3-button w3-red w3-block" >{{ __('Forgot Your Password?') }}</a>
                                            <!--<a class="w3-btn w3-button w3-red w3-block" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>-->
                                        @endif
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <br>
        </div>
        <footer class="w3-container w3-padding-32 w3-margin-top" style="height: 250px;background-image: url({{url('/')}}/images/footer.png);background-position-x: -120px;background-position-y: 0px;"></footer>
    </body>
</html>