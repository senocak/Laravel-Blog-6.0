@extends('admin.main')
@section('body')
    <header class="w3-container" style="padding-top:22px"><h5><b><i class="fa fa-dashboard"></i> Yazılar</b></h5></header>
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
@endsection