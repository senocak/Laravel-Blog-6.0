@extends('admin.main')
@section('stylesheet')
    <script type="text/javascript">
        function showimagepreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {$('#imgview').attr('src', e.target.result);}
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
@section('body')
    <header class="w3-container w3-row-padding" style="padding-top:22px"><h5><b><i class="fa fa-dashboard"></i> Kategori Ekle</b></h5></header>  
    <div class="w3-container w3-card-4">
        {!! Form::open(array('files' => true)) !!}
            {!! Form::label("baslik", "Kategori Başlığı", ["class"=>"w3-text-grey"]) !!}
            {!! Form::text("baslik", null,["id"=>"baslik","class"=>"w3-input w3-border","placeholder"=>"Kategori Başlığı","required"=>"required"  ]) !!}
            @error('baslik') <span class="w3-tag w3-round w3-red" style="padding:3px"><span class="w3-tag w3-round w3-red w3-border w3-border-white">{{ $message }}</span></span><br>@enderror
            {!! Form::label("resim", "Resim", ["class"=>"w3-text-grey"]) !!}
            {!! Form::file('resim',["id"=>"resim","class"=>"w3-input w3-border","required"=>"required", "onChange"=>"showimagepreview(this)" ]) !!}
            {{ Html::image("/images/no-image.png", "Logo",array('id'=>'imgview','width'=>'100')) }}
            @error('icerik') <span class="w3-tag w3-round w3-red" style="padding:3px"><span class="w3-tag w3-round w3-red w3-border w3-border-white">{{ $message }}</span></span>@enderror
            <br><br>
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