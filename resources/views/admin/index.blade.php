@extends('admin.main')
@section('body')
  <header class="w3-container w3-row-padding" style="padding-top:22px;    padding-bottom: 11px;">
      <a onclick="kapat_ac();" class="w3-container w3-row w3-bar-item w3-left w3-container w3-row-padding"><i class="fa fa-bars"></i></a></span> Admin Paneli
  </header>  
  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-sticky-note w3-xxxlarge"></i></div>
          <div class="w3-right"><h3>{{ $dizi["toplam_yazilar"] }}</h3></div><div class="w3-clear"></div><h4>Yazı</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-list-alt  w3-xxxlarge"></i></div>
        <div class="w3-right"><h3>{{ $dizi["toplam_kategoriler"] }}</h3></div><div class="w3-clear"></div><h4>Kategori</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right"><h3>{{ $dizi["toplam_yorumlar"] }}</h3></div><div class="w3-clear"></div><h4>Onaylı Yorum</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right"><h3>{{ $dizi["toplam_kullanıcılar"] }}</h3></div><div class="w3-clear"></div><h4>Kullanıcı</h4>
      </div>
    </div>
  </div>
  <div class="w3-container">
    <h5><i class="fa fa-dashboard"></i> Onaylanmamış Yorumlar</h5> 
    @foreach ($dizi["onaysız_yorumlar"] as $yorumlar)
      @foreach ($yorumlar->yorum as $y) 
        <div class="w3-row">
          <div class="w3-col m2 text-center">
            <a href="/kategori/{{$yorumlar->kategori->url}}">
              <img src="/images/{{$yorumlar->kategori->resim}}" style="width:100%;">
            </a>
          </div>
          <div class="w3-col m10 w3-container">
            <h4 style="margin-top: -5px;"><a href="/yazi/{{$yorumlar->url}}#yorum_{{$y->id}}" style="text-decoration: none">{{$yorumlar->baslik}}</a> 
              <span class="w3-opacity w3-medium">
                <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($y->created_at))->diffForHumans() ?>    
              </span>
            </h4>
            <p>
              <a href="/yazi/{{$yorumlar->url}}#yorum_{{$y->id}}" style="text-decoration: none">
                {{$y->yorum}}
              </a>
            </p>
            <br>
          </div>
        </div>
      @endforeach
    @endforeach  
  </div> 
@endsection