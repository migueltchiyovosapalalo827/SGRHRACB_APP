@extends('adminlte::page')

@section('title', 'quadro_especial')
@section('plugins.Sweetalert2', true)
@section('plugins.Toastr', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1> RACB-SECÇÃO DE PESSOAL E QUADROS</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Quadro Especial / Especialidade </a></li>
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
                    <a href="{{ route('quadro_especial.index') }}" class="btn btn-sm btn-block btn-secondary"><i
                            class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
        <form action="{{ route('quadro_especial.update', ['quadro_especial' => $quadro_especial->id]) }}" method="post" class="form-horizontal">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">nome da  Especialidade</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-edit"></i></span>
                            </div>
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                value="{{ $quadro_especial->nome ?? old('nome') }}" placeholder="nome" autocomplete="off">
                            @error('nome')
                                <div class="invalid-feedback">
                                    <h6>{{ $message }}</h6>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

        <div class="card-footer">
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
            $('.duallistbox').bootstrapDualListbox();
        });
    </script>
@stop
