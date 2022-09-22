@extends('adminlte::page')

@section('title', 'subcategorias')
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Toastr', true)

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1> RACB-SECÇÃO DE PESSOAL E QUADROS</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Categoria Militar</a></li>
        <li class="breadcrumb-item active">Actualizar</li>
      </ol>
    </div>
  </div>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="float-left">
                <div class="btn-group">
                    <a href="{{ route('categorias.index') }}" class="btn btn-sm btn-block btn-secondary"><i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('subcategoria.update',['subcategorium'=>$subcategoria->id]) }}" method="post" class="form-horizontal">
              @method('PUT')
              @csrf

              <div class="form-group row">
                <label class="col-sm-2 col-form-label"> Categoria Militar</label>
                <div class="col-sm-8">
                <select class="form-control select2 @error('categoria') is-invalid @enderror" style="width: 100%;" name="categoria">
                    <option value="">seleciona uma categoria que pertence a subcategoria</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ ($categoria->id ==  $subcategoria->categoria->id ) ? 'selected' : '' }}>{{ $categoria->nome }}</option>
                    @endforeach

                </select>
                @error('categoria')
                     <div class="invalid-feedback">
                         <h6>{{ $message }}</h6>
                    </div>
                @enderror
                </div>

            </div>
        <div class="form-group row">
             <label for="inputName" class="col-sm-2 col-form-label">nome da Categoria Militar </label>
             <div class="col-sm-8">
                 <div class="input-group">
                     <div class="input-group-prepend">
                         <span class="input-group-text"><i class="fas fa-edit"></i></span>
                     </div>
                     <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{$categoria->nome ?? old('nome') }}" placeholder="nome" autocomplete="off">
                     @error('nome')
                     <div class="invalid-feedback">
                         <h6>{{$message}}</h6>
                     </div>
                     @enderror
                 </div>
             </div>
         </div>
         <div class="form-group row">
             <div class="col-sm-10">
                 <div class="float-right">
                     <div class="btn-group">
                         <button type="submit" class="btn btn-sm btn-block btn-primary">
                          salvar
                         </button>
                     </div>
                 </div>
             </div>
         </div>
     </form>
        </div>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
 <script>
    $(function() {
        $('.select2').select2();
    });
 </script>
@stop
