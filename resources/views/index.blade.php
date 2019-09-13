@extends('main')
@section('body')
    @php ($i=0)
    @foreach ($return_dizi["yazilar"] as $yazi)
        @if ($i%2 == 0)
            <div class="w3-half ">
        @endif
        <div class="w3-card-4 w3-margin w3-white">
            <div class="w3-display-container">
                <a href="/yazi/{{ $yazi->url }}"><img class="w3-center" src="/images/{{ $yazi->kategori->resim }}" style="width:100%"></a>
                <div class="w3-display-bottomleft w3-container w3-button w3-padding-large w3-white"><a style="text-decoration: none;" href="/yazar/{{$yazi->user->id}}">{{$yazi->user->name}}</a></div>
                <div class="w3-display-topleft w3-container w3-button w3-padding-large w3-white"><a style="text-decoration: none;" href="/kategori/{{ $yazi->kategori->url }}">{{$yazi->kategori->baslik}}</a></div>
                <div class="w3-display-bottomright w3-container w3-button w3-padding-large w3-white"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($yazi->created_at))->diffForHumans() ?></div> 
            </div>
            <div class="w3-container">
                <b style="font-size: x-large"><a style="text-decoration: none;" href="/yazi/{{ $yazi->url }}">{{$yazi->baslik}}</a></b>
                <b class="w3-right"><b>Yorumlar </b><span class="w3-badge">{{count($yazi->yorum)}}</span></b>
            </div>
            <div class="w3-container">
                <p>
                    @php ($kelime = 500)
                    @php ($icerik=strip_tags($yazi->icerik))
                    @if (strlen($icerik)>=$kelime)
                        @if (preg_match('/(.*?)\s/i',substr($icerik,$kelime),$dizi))
                            @php ($icerik=substr($icerik,0,$kelime+strlen($dizi[0]))."...")
                        @endif
                    @else
                        @php ($icerik.="")
                    @endif  
                    <div style="text-align: justify;"> 
                        {!! $icerik !!} 
                        <div class="w3-row">
                            @foreach(explode(',', $yazi->etiketler) as $info)
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
        @if ($i%2 == 0)
            </div> 
        @endif
    @endforeach 
    <hr>
    <div class="w3-container w3-row">
        {{ $return_dizi["yazilar"]->links("posts_page")}}
    </div> 
@endsection
@section('kategoriler')
    @foreach ($return_dizi["kategoriler"] as $kategori)
        <a href="/kategori/{{ $kategori->url }}"><span class="w3-tag">{{ $kategori->baslik }}</span></a>
    @endforeach
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
                    <span class="w3-right w3-tiny">
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