@extends('main')
@section('body') 
    <div class="w3-card-4 w3-margin w3-white">
        <div class="w3-display-container">
            <img class="w3-center" src="/images/{{ $return_dizi["yazilar"]->kategori->resim }}" style="width:100%">
            <div class="w3-display-bottomleft w3-container w3-button w3-padding-large w3-white">{{$return_dizi["yazilar"]->user->name}}</div>
            <div class="w3-display-topleft w3-container w3-button w3-padding-large w3-white"><a style="text-decoration: none;" href="/kategori/{{ $return_dizi["yazilar"]->url }}">{{$return_dizi["yazilar"]->kategori->baslik}}</a></div>
            <div class="w3-display-bottomright w3-container w3-button w3-padding-large w3-white"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($return_dizi["yazilar"]->created_at))->diffForHumans() ?></div> 
        </div>
        <div class="w3-container">
            <b style="font-size: xx-large">{{$return_dizi["yazilar"]->baslik}}</b>
            <b class="w3-right"><b>Onaylanmış Yorumlar </b><span class="w3-badge">{{count($return_dizi["yazilar"]->yorum)}}</span></b>
        </div>
        <div class="w3-container">
            <p>
                <div style="text-align: justify;"> 
                    {!! $return_dizi["yazilar"]->icerik !!} 
                    <div class="w3-row">
                        @foreach(explode(',', $return_dizi["yazilar"]->etiketler) as $info)
                            <span class="w3-badge">{{$info}}</span> 
                        @endforeach
                    </div>
                </div>
            </p>
            <div class="w3-row">
                <div class="w3-col m4 w3-hide-small">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    @if(Auth::check())
        <form class="w3-container w3-card-4 w3-margin" method="POST">
            {{ csrf_field() }}
            <div class="w3-half">
                <p><label class="w3-text-grey">İsim</label><input class="w3-input w3-border" type="text" required="" placeholder="İsminiz" name="isim" value="{{ Auth::user()->name }}" disabled></p>
            </div>
            <div class="w3-half">
                <p><label class="w3-text-grey">Email</label><input class="w3-input w3-border" type="email" required="" placeholder="Email Adresiniz" name="email" value="{{ Auth::user()->email }}" disabled></p>
            </div>
            <p><label class="w3-text-grey">Yorum</label><textarea class="w3-input w3-border" style="resize:none" placeholder="Yorumunuz" name="yorum"></textarea></p>
            <p><button type="submit" class="w3-btn w3-padding w3-teal" style="width:120px">Göder &nbsp; ❯</button></p>
        </form>
    @else
        <div class="w3-container w3-white w3-margin w3-center"><h2>Lütfen Giriş Yapınız</h2></div>
    @endif
    <ul class="w3-ul w3-card-4 w3-margin w3-white">
        @foreach ($return_dizi["yazilar"]->yorum as $yorum)
            <li class="w3-bar" id="yorum_{{$yorum->id}}">
                <span class="w3-bar-item w3-white w3-right">
                    <i class="fa fa-check" title="Onaylanmış Yorum"></i>
                </span>
                <img src="/images/{{$yorum->user->picture}}" class="w3-bar-item w3-c ircle w3-hide-small" style="width:70px">
                <span class="w3-large w3-margin w3-center">
                    {{$yorum->user->name}}
                </span>
                <br>
                <span class="w3-margin w3-center w3-tiny">
                    <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($yorum->created_at))->diffForHumans() ?>
                </span>
                <br>
                <div class="w3-bar-item" style="text-align: justify; width: 90%;"><span>{{$yorum->yorum}}</span></div>
            </li> 
        @endforeach
    </ul>
@endsection
@section('yorumlar')
    <ul class="w3-ul w3-card-4">
        @foreach ($return_dizi["yorumlar"] as $yorumlar) 
            @foreach ($yorumlar->yorum as $y)
                <li class="w3-padding-16" style="text-align: justify">
                    <a href="/kategori/{{$yorumlar->kategori->url}}">
                        <img src="/images/{{$yorumlar->kategori->resim}}" class="w3-left w3-margin-right " style="width:100px">
                    </a>
                    <span class="w3-large">
                        <a href="/yazi/{{$yorumlar->url}}#yorum_{{$y->id}}" style="text-decoration: none">{{$yorumlar->baslik}}</a>
                    </span>
                    <span class="w3-right">
                        <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($y->created_at))->diffForHumans() ?>    
                    </span>
                    <br>
                    <span>
                        <a href="/yazi/{{$yorumlar->url}}#yorum_{{$y->id}}" style="text-decoration: none">
                            {{substr($y->yorum,0,100)}}...
                        </a>
                    </span>
                    {{$y->id}}
                </li>
            @endforeach
        @endforeach  
    </ul> 
@endsection