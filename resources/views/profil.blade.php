@extends('main')
@section('stylesheet')
    {!! Html::script('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') !!} 
    <script type="text/javascript">
		function showimagepreview(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {$('#imgview').attr('src', e.target.result);}
				reader.readAsDataURL(input.files[0]);
			}
		}
    </script>
    <style>
        .alert-info{
            
        }
    </style>
@endsection
@section('body')
    <div class="w3-bar w3-black">
        <button class="w3-bar-item w3-button tablink w3-red" onclick="openProfile(event,'profil')">Profil Düzenle</button>
        <button class="w3-bar-item w3-button tablink" onclick="openProfile(event,'yorum')">Yorumlarım</button>
        <button class="w3-bar-item w3-button tablink" onclick="openProfile(event,'Tokyo')">Tokyo</button>
    </div> 
    <div id="profil" class="w3-container w3-border profile">
        <div class="w3-col  margtest">
            <div class="w3-col s3 w3-center">
                <div class="w3-card-4 test">
                    <img src="/images/{{ Auth::user()->picture }}" >
                    <div class="w3-container">
                        <h4><b>{{ Auth::user()->name }}</b></h4>    
                        <p>{{ Auth::user()->email }}</p>    
                        @if (Auth::user()->email_verified_at)
                            <p>Email Adresini Onaylanmış</p>
                        @else
                            <p>Email Adresini Onayla</p>
                        @endif
                        @if (Auth::user()->is_admin == 1)
                            <p>Admin Hesabı <i class="fa fa-check" title="Admin Hesabı"></i></p>
                        @endif
                    </div>
                </div>
            </div>
            @if(Session::has('hata'))<div class="w3-red "><p>{{ Session::get('hata') }}</p></div>@endif
            @if(Session::has('basarı'))<div class="w3-green"><p>{{ Session::get('basarı') }}</p></div>@endif
            <div class="w3-col s9 w3-center">
                <form method="POST" action="/profil" enctype="multipart/form-data">
                    @csrf
                    <p><input type="text" class="w3-input w3-border" required="" placeholder="İsminiz" name="name" value="{{ Auth::user()->name }}"></p> 
                    <p><input type="email" class="w3-input w3-border" required="" placeholder="Email Adresiniz" name="email" value="{{ Auth::user()->email }}"></p>
                    <p><input type="password" class="w3-input w3-border" placeholder="{{ __('Şifreniz') }}" name="password"></p> 
                    <p><input type="password" class="w3-input w3-border" placeholder="{{ __('Şifreniz Tekrar') }}" name="password2"></p>
                    <p>
                        <div class="w3-half">
                            <input type="file" class="w3-input w3-border" onChange="showimagepreview(this)" name="picture">
                        </div>
                        <div class="w3-half">
                            <img src="/images/no-image.png" width="150px" id="imgview" >
                        </div>
                    </p>
                    <p><button type="submit" class="w3-button w3-block w3-green">Güncelle &nbsp; ❯</button></p>
                </form>
            </div>
        </div> 
    </div>

    <div id="yorum" class="w3-container w3-border profile" style="display:none">
        <h2>Paris</h2>
        <p>Paris is the capital of France.</p> 
    </div>

    <div id="Tokyo" class="w3-container w3-border profile" style="display:none">
        <h2>Tokyo</h2>
        <p>Tokyo is the capital of Japan.</p>
    </div> 

    <script>
        function openProfile(evt, profileName) {
            var i, x, tablinks;
            x = document.getElementsByClassName("profile");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < x.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
            }
            document.getElementById(profileName).style.display = "block";
            evt.currentTarget.className += " w3-red";
        }
    </script>  
@endsection 
@section('kategoriler')
    @foreach ($return_dizi["kategoriler"] as $kategori)
        <a href="/kategori/{{ $kategori->url }}"><span class="w3-tag">{{ $kategori->baslik }}</span></a>
    @endforeach
@endsection
@section('yorumlar')
    @foreach ($return_dizi["yorumlar"] as $yorum)
        <li class="w3-padding-16">
            <img src="/images/{{$yorum->user->picture}}" alt="Image" class="w3-left w3-margin-right " style="width:40px">
            <span class="w3-large">{{$yorum->user->name}}</span> <span class="w3-right"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($yorum->created_at))->diffForHumans() ?></span><br>
            <span><a href="/yazi/{{$yorum->yazi->url}}#yorum_{{$yorum->id}}" style="text-decoration: none">{{$yorum->yazi->baslik}}</a></span>
        </li>
    @endforeach
@endsection