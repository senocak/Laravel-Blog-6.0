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
    <form class="w3-container w3-card-4 w3-margin" method="POST">
        {{ csrf_field() }}
        <div class="w3-half">
            <p><label class="w3-text-grey">İsim</label><input class="w3-input w3-border" type="text" required="" placeholder="İsminiz" name="isim"></p>
        </div>
        <div class="w3-half">
            <p><label class="w3-text-grey">Email</label><input class="w3-input w3-border" type="email" required="" placeholder="Email Adresiniz" name="email"></p>
        </div>
        <p><label class="w3-text-grey">Yorum</label><textarea class="w3-input w3-border" style="resize:none" placeholder="Yorumunuz" name="yorum"></textarea></p>
        <p><button type="submit" class="w3-btn w3-padding w3-teal" style="width:120px">Göder &nbsp; ❯</button></p>
    </form>
    <ul class="w3-ul w3-card-4 w3-margin w3-white">
        @foreach ($return_dizi["yazilar"]->yorum as $yorum)
            <li class="w3-bar">
                <span class="w3-bar-item w3-white w3-right"><i class="fa fa-check" title="Onaylanmış Yorum"></i></span>
                <img src="/images/img_avatar6.png" class="w3-bar-item w3-circle w3-hide-small" style="width:90px">
                <span class="w3-large w3-margin w3-center">{{$yorum->isim}}</span><br>
                <span class="w3-margin w3-center"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($yorum->created_at))->diffForHumans() ?></span><br>
                <div class="w3-bar-item" style="text-align: justify"><span>{{$yorum->yorum}}</span></div>
            </li> 
        @endforeach
    </ul>
@endsection
@section('kategoriler')
    @foreach ($return_dizi["kategoriler"] as $kategori)
        <a href="/kategori/{{ $kategori->url }}"><span class="w3-tag">{{ $kategori->baslik }}</span></a>
    @endforeach
@endsection