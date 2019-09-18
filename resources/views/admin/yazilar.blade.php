@extends('admin.main')
@section('stylesheet') 
    <style type="text/css">.sortable { cursor: grab; }</style>
@endsection
@section('body')
    <header class="w3-container w3-row-padding" style="padding-top:22px">
        <div class="w3-third"><h5><b><i class="fa fa-dashboard"></i> Yazılar</b></h5></div> 
        <div class="w3-third"><input type="text" id="myInput" onkeyup="search()" placeholder="Aktif sayfada ara..." class="w3-input"></div> 
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
    @if(Session::has('hata'))<span class="w3-tag w3-round w3-red w3-block" style="padding:3px"><span class="w3-tag w3-round w3-red w3-border w3-border-white  w3-block">{{ Session::get('hata') }}</span></span>@endif
    @if(Session::has('basarı'))<span class="w3-tag w3-round w3-green w3-block" style="padding:3px"><span class="w3-tag w3-round w3-green w3-border w3-border-white  w3-block">{{ Session::get('basarı') }}</span></span>@endif
    <a href="/admin/yazilar/ekle" class="w3-btn w3-black w3-block">Yazı Ekle</a>
    <table class="w3-table-all" id="yazilar_table">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Başlık</th>
                <th>Kategori</th>
                <th>Yorum</th>
                <th>Begeni</th>
                <th>Yazar</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody id="sortable">
            @php($sira = 1)
            @forelse ($dizi["yazilar"] as $item)
                <tr id="item-{{ $item->id }}">
                    <td class="sortable">{{$sira}}</td>
                    <td>{{$item->baslik}}</td>
                    <td><a href="/admin/kategoriler/{{$item->kategori->url}}" style="text-decoration: none" class="w3-btn w3-padding-small">{{$item->kategori->baslik}}</a></td>
                    <td><a href="/admin/yorumlar/yazi/{{$item->url}}" style="text-decoration: none" class="w3-btn w3-padding-small">{{count($item->yorum)}} Yorum</a></td>
                    <td>{{count($item->begeni)}} 👍</td>
                    <td>{{$item->user->name}}</td>
                    <td>
                        <a href="/admin/yazilar/duzenle/{{$item->id}}" title="Düzenle"><i class="fa fa-edit"></i></a>
                        <a href="/admin/yazilar/sil/{{$item->id}}" title="Sil" onclick="return confirm('Silmek İstediğinize Emin Misiniz?!')"><i class="fa fa-minus-circle"></i></a>
                        <a href="/admin/yazilar/aktif/{{$item->id}}" title="Aktif/Pasif"><i class="@if($item->aktif == 1)fa fa-thumbs-up @else fa fa-thumbs-down @endif"></i></a>
                    </td>
                </tr>
                @php($sira++)
            @empty
                <tr>Kayıt Yok</tr>
            @endforelse 
        </tbody>
    </table>
    {{ $dizi["yazilar"]->links("posts_page")}}
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
                        url: '{{route("admin.yazilar.sirala")}}',
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