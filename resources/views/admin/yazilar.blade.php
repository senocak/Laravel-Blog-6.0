@extends('admin.main')
@section('body')
    <header class="w3-container w3-row-padding" style="padding-top:22px">
        <div class="w3-third"><h5><b><i class="fa fa-dashboard"></i> Yazılar</b></h5></div> 
        <div class="w3-third w3-right">
            <select class="w3-select kayıt_goster" name="limit" onchange="this.options[this.selectedIndex].value && (window.location = '/admin/yazilar/limit/'+this.options[this.selectedIndex].value);">
                <option value="" disabled selected>Kayıt Göster</option>
                <option value="10" @if ($dizi["limit"] == "10") selected @endif>10</option>
                <option value="20" @if ($dizi["limit"] == "20") selected @endif>20</option>
                <option value="30" @if ($dizi["limit"] == "30") selected @endif>30</option>
                <option value="50" @if ($dizi["limit"] == "50") selected @endif>50</option>
                <option value="100" @if ($dizi["limit"] == "100") selected @endif>100</option>
            </select>
        </div>
    </header> 
    @if(Request::url() === 'your url here')
        // code
    @endif 
    <table class="w3-table-all">
        <tr>
          <th>#</th>
          <th>Başlık</th>
          <th>Kategori</th>
          <th>Yorum</th>
          <th>Yazar</th>
          <th>İşlemler</th>
        </tr>
        @php($sira = 1)
        @forelse ($dizi["yazilar"] as $item)
            <tr>
                <td>{{$sira}}</td>
                <td>{{$item->baslik}}</td>
                <td>
                    <a href="/admin/kategoriler/{{$item->kategori->url}}" style="text-decoration: none" class="w3-btn w3-padding-small">{{$item->kategori->baslik}}</a>
                </td>
                <td>{{count($item->yorum)}} Yorum</td>
                <td>{{$item->user->name}}</td>
                <td>
                        <a href="/admin/yazi/duzenle/{{$item->baslik}}" title="Düzenle"><i class="fa fa-edit"></i></a>
                        <a href="/admin/yazi/duzenle/{{$item->baslik}}" title="Sil"><i class="fa fa-minus-circle"></i></a>
                </td>
            </tr>
            @php($sira++)
        @empty
            <tr>Kayıt Yok</tr>
        @endforelse 
      </table>
      {{ $dizi["yazilar"]->links("posts_page")}}
@endsection