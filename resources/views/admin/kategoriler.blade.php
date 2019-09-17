@extends('admin.main')
@section('stylesheet') 
    <style type="text/css">.sortable { cursor: grab; }</style>
@endsection
@section('body')
    <header class="w3-container w3-row-padding" style="padding-top:22px">
        <div class="w3-third"><h5><b><i class="fa fa-dashboard"></i> Kategoriler</b></h5></div> 
        <div class="w3-third w3-right"><input type="text" id="myInput" onkeyup="search()" placeholder="Aktif sayfada ara..." class="w3-input"></div> 
    </header>
    @if(Session::has('hata'))<span class="w3-tag w3-round w3-red w3-block" style="padding:3px"><span class="w3-tag w3-round w3-red w3-border w3-border-white  w3-block">{{ Session::get('hata') }}</span></span>@endif
    @if(Session::has('basarı'))<span class="w3-tag w3-round w3-green w3-block" style="padding:3px"><span class="w3-tag w3-round w3-green w3-border w3-border-white  w3-block">{{ Session::get('basarı') }}</span></span>@endif
    @if (Auth::user()->is_admin == 1)        
        <a href="/admin/kategoriler/ekle" class="w3-btn w3-black w3-block">Kategori Ekle</a>
    @endif
    <table class="w3-table-all" id="yazilar_table">
        <thead class="thead-dark">
            <tr>
                <th>Resim</th>
                <th>Başlık</th> 
                <th>Toplam Yazı</th> 
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody id="sortable">
            @forelse ($dizi["kategoriler"] as $item)
                <tr id="item-{{ $item->id }}">
                    <td class="sortable"><img src="/images/{{$item->resim}}" width="150px"></td>
                    <td>{{$item->baslik}}</td> 
                    <td>
                        {{count($item->yazilar)}} Yazı
                    </td> 
                    <td>
                        @if (Auth::user()->is_admin == 1)                            
                            <a href="/admin/kategoriler/duzenle/{{$item->id}}" title="Düzenle"><i class="fa fa-edit"></i></a>
                            <a href="/admin/kategoriler/sil/{{$item->id}}" title="Sil" onclick="return confirm('Silmek İstediğinize Emin Misiniz?!')"><i class="fa fa-minus-circle"></i></a>
                        @else
                            <a ><i class="fa fa-exclamation-triangle"></i> Yetkisiz Kullanıcı</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>Kayıt Yok</tr>
            @endforelse 
        </tbody>
    </table>
@endsection
@section('scripts') 
    <script type="text/javascript"> 
        $(function() {
            $( "#sortable" ).sortable({
                revert: true,
                handle: ".sortable",
                stop: function (event, ui) {
                    var data = $(this).sortable('serialize');
                    console.log(data);
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                        type: "POST",
                        dataType: "json",
                        data: data,
                        url: '{{route("admin.kategoriler.sirala")}}',
                        success: function(msg){
                            location.reload();
                        }
                    });
                }
            });
            $( "#sortable" ).disableSelection();
        });
    </script>
    <script>
        function search() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("yazilar_table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }
    </script>   
@endsection