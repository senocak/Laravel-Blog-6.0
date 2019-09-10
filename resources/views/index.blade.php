@extends('main')
@section('body')
    @foreach ($yazilar as $yazi)
        <div class="w3-card-4 w3-margin w3-white">
            <div class="w3-display-container">
                <a href="/yazi/{{ $yazi->url }}"><img src="/images/{{ $yazi->kategori->resim }}" style="width:100%"></a>
                <div class="w3-display-bottomleft w3-container w3-button w3-padding-large w3-white">{{$yazi->user->name}}</div>
                <div class="w3-display-topleft w3-container w3-button w3-padding-large w3-white"><a style="text-decoration: none;" href="/kategori/{{ $yazi->url }}">{{$yazi->kategori->baslik}}</a></div>
                <div class="w3-display-bottomright w3-container w3-button w3-padding-large w3-white"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($yazi->created_at))->diffForHumans() ?></div> 
            </div>
            <div class="w3-container">
                <b style="font-size: x-large"><a style="text-decoration: none;" href="/yazi/{{ $yazi->url }}">{{$yazi->baslik}}</a></b>
                <b class="w3-right"><b>Yorumlar </b><span class="w3-badge">2</span></b>
            </div>
            <div class="w3-container">
                <p>
                    @php ($kelime = 1800)
                    @php ($icerik=strip_tags($yazi->icerik))
                    @if (strlen($icerik)>=$kelime)
                        @if (preg_match('/(.*?)\s/i',substr($icerik,$kelime),$dizi))
                            @php ($icerik=substr($icerik,0,$kelime+strlen($dizi[0]))."...")
                        @endif
                    @else
                        @php ($icerik.="")
                    @endif  
                    <div style="text-align: justify;"> {!! $icerik !!} </div>
                </p>
                <div class="w3-row">
                    <div class="w3-col m4 w3-hide-small">
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach 
@endsection
@section('kategoriler')
    @foreach ($kategoriler as $kategori)
        <a href="/kategori/{{ $kategori->url }}"><span class="w3-tag">{{ $kategori->baslik }}</span></a>
    @endforeach
@endsection