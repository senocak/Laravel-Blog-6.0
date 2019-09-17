@extends('admin.main')
@section('body')
    <header class="w3-container w3-row-padding" style="padding-top:22px">
        <div class="w3-third"><h5><b><i class="fa fa-dashboard"></i> Kategoriler</b></h5></div> 
        <div class="w3-third"><input type="text" id="myInput" onkeyup="search()" placeholder="Aktif sayfada yazıya göre ara..." class="w3-input"></div> 
        <div class="w3-third w3-right">
            <select class="w3-select kayıt_goster" name="limit" onchange="this.options[this.selectedIndex].value && (window.location = '/admin/yorumlar/limit/'+this.options[this.selectedIndex].value);">
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
    <table class="w3-table-all" id="yorumlar_table">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Yazar</th> 
                <th>Yorum</th> 
                <th>Yazı</th>  
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody id="sortable">
            @php($i=1)
            @forelse ($dizi["yorumlar"] as $item)
                <tr id="item-{{ $item->id }}" @if($item->onay == "0") style="text-decoration: line-through;" @endif>
                    <td class="sortable">{{$i}}</td>
                    <td>{{$item->user->name}}</td> 
                    <td>{{substr($item->yorum,0,20)}}...</td> 
                    <td><a href="/yazi/{{ $item->yazi->url }}" style="text-decoration: none">{{ $item->yazi->baslik }}</a></td> 
                    <td>
                        <a onclick="document.getElementById('id_{{ $item->id }}').style.display='block'"  title="Düzenle"><i class="fa fa-edit"></i></a>
                        @if($item->onay == 0)
                            <a href="/admin/yorumlar/aktif/{{$item->id}}" title="Aktif et" onclick="return confirm('Aktif Etmek İstediğinize Emin Misiniz?!')"><i class="fa fa-thumbs-down" style="color:red"></i></a>
                        @else
                            <a href="/admin/yorumlar/aktif/{{$item->id}}" title="Pasif et" onclick="return confirm('Pasif Etmek İstediğinize Emin Misiniz?!')"><i class="fa fa-thumbs-up"></i></a>
                        @endif 
                    </td>
                </tr>
                @php($i++) 
                <div id="id_{{ $item->id }}" class="w3-modal">
                    <div class="w3-modal-content">
                        <header class="w3-container w3-teal"> 
                            <span onclick="document.getElementById('id_{{ $item->id }}').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                            <h2><a href="/yazi/{{ $item->yazi->url }}" target="_blank" style="text-decoration: none;">{{ $item->yazi->baslik }}</a></h2>
                        </header>
                        <div class="w3-container">
                            <p>
                                @php($search = array(":smile",":sad",":heart",":hah",":love",":hmm",":gross",":angry",":fire",":rock"))
                                @php($replace = array("😊","😔","❤","😀","😍","😐","🤢","😡","🔥","🤘"))
                                {{ str_replace($search,$replace,trim($item->yorum)) }}
                            </p>
                        </div>
                        <footer class="w3-container w3-teal"><p>{{$item->user->name}}</p></footer>
                    </div>
                </div> 
            @empty
                <tr>Kayıt Yok</tr>
            @endforelse 
        </tbody>
    </table>
    {{ $dizi["yorumlar"]->links("posts_page")}}  
@endsection
@section('scripts')
    <script>
        function search() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("yorumlar_table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[3];
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