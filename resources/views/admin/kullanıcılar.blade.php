@extends('admin.main')
@section('body')
    <header class="w3-container w3-row-padding" style="padding-top:22px">
        <div class="w3-third"><a onclick="kapat_ac();" class="w3-bar-item w3-left w3-container w3-row-padding"><i class="fa fa-bars"></i></a></span> Admin Paneli</div> 
        <div class="w3-third w3-right"><input type="text" id="myInput" onkeyup="search()" placeholder="Aktif sayfada ara..." class="w3-input"></div> 
    </header>
    @if(Session::has('hata'))<span class="w3-tag w3-round w3-red w3-block" style="padding:3px"><span class="w3-tag w3-round w3-red w3-border w3-border-white  w3-block">{{ Session::get('hata') }}</span></span>@endif
    @if(Session::has('basarı'))<span class="w3-tag w3-round w3-green w3-block" style="padding:3px"><span class="w3-tag w3-round w3-green w3-border w3-border-white  w3-block">{{ Session::get('basarı') }}</span></span>@endif
    <table class="w3-table-all" id="kullanıcılar_table">
        <thead class="thead-dark">
            <tr> 
                <th>#</th> 
                <th>Kullanıcı Adı</th> 
                <th>Email</th>  
                <th>Toplam Yazı</th>  
                <th>Toplam Yorum</th>  
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody id="sortable"> 
            @forelse ($dizi["kullanıcılar"] as $item)
                <tr id="item-{{ $item->id }}" @if($item->email_verified_at == null) style="text-decoration: line-through;" @endif> 
                    <td><img src="/images/{{$item->picture}}" width="100px"></td> 
                    <td>{{$item->name}} @if ($item->is_admin == 1) <i class="fa fa-star" title="Admin Yetkili Kullanıcı" style="color:green"></i> @endif <div class="w3-tiny">{{$item->username}}</div></td> 
                    <td>{{$item->email}}</td> 
                    <td>{{count($item->yazi)}}</td> 
                    <td>{{count($item->yorum)}}</td> 
                    <td>
                        @if (Auth::user()->is_admin == 1)
                            @if($item->email_verified_at == null)
                                <a href="/admin/kullanicilar/aktif/{{$item->id}}" title="Aktif et" onclick="return confirm('Aktif Etmek İstediğinize Emin Misiniz?!')"><i class="fa fa-thumbs-down" style="color:red"></i></a>
                            @else
                                <a href="/admin/kullanicilar/aktif/{{$item->id}}" title="Pasif et" onclick="return confirm('Pasif Etmek İstediğinize Emin Misiniz?!')"><i class="fa fa-thumbs-up"></i></a>
                            @endif 
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
    <script>
        function search() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("kullanıcılar_table");
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