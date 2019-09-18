@extends('admin.main')
@section('stylesheet')
	{!! Html::style('css/bootstrap-tagsinput.css') !!}
    {!! Html::script('https://cdn.ckeditor.com/4.12.1/full-all/ckeditor.js') !!}
    <style>.bootstrap-tagsinput{width: 100%;}</style>
@endsection
@section('body')
    <header class="w3-container w3-row-padding" style="padding-top:22px;    padding-bottom: 11px;">
        <a onclick="kapat_ac();" class="w3-container w3-row w3-bar-item w3-left w3-container w3-row-padding"><i class="fa fa-bars"></i></a></span> Admin Paneli
    </header>  
    <div class="w3-container w3-card-4">
        {!! Form::open(array()) !!}
            {!! Form::label("baslik", "Başlık", ["class"=>"w3-text-grey"]) !!}
            {!! Form::text("baslik", null,["id"=>"baslik","class"=>"w3-input w3-border","placeholder"=>"Yazı Başlığı" ]) !!}
            @error('baslik') <span class="w3-tag w3-round w3-red" style="padding:3px"><span class="w3-tag w3-round w3-red w3-border w3-border-white">{{ $message }}</span></span><br>@enderror
            <br>
            {!! Form::label("icerik", "İçerik", ["class"=>"w3-text-grey"]) !!}
            {!! Form::textarea("icerik", null, ["id"=>"editor1","class"=>"ckeditor w3-input w3-border", "height"=>"550px"]) !!}
            @error('icerik') <span class="w3-tag w3-round w3-red" style="padding:3px"><span class="w3-tag w3-round w3-red w3-border w3-border-white">{{ $message }}</span></span>@enderror
            <br>
            {!! Form::label("kategori_id", "Kategori", ["class"=>"w3-text-grey"]) !!}
            {!! Form::select("kategori_id", $dizi["kategoriler_select"], null, ['class'=>'w3-input w3-border', "required"=>"required"]) !!}
            @error('kategori_id') <span class="w3-tag w3-round w3-red" style="padding:3px"><span class="w3-tag w3-round w3-red w3-border w3-border-white">{{ $message }}</span></span><br>@enderror
            {!! Form::label("etikets", "Etiketler", ["class"=>"w3-text-grey"]) !!}
            {!! Form::text("etiketler", null, ["data-role"=>"tagsinput","class"=>"w3-input w3-border"]) !!}
            {{ Form::checkbox('aktif',null,null, array('class'=>'w3-check')) }}
            {!! Form::label("aktif", "Yayınla", ["class"=>"w3-text-grey"]) !!}<br>
            {!! Form::submit("Kaydet", ["class"=>"w3-btn w3-padding w3-green w3-block"]) !!}
        {!! Form::close() !!}
    </div>  
@endsection
@section('scripts')
    {!! Html::script('js/bootstrap-tagsinput.min.js') !!}
    <script>
        CKEDITOR.replace('editor1', {
            filebrowserBrowseUrl: "{{url('/')}}/editor/fileman/index.html",
            filebrowserImageBrowseUrl: "{{url('/')}}/editor/fileman/index.html",
            extraPlugins: 'codesnippet',
            height: '480px',
        });
    </script>
@endsection