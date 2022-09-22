@extends('adminlte::page')
@section('title', 'Hablitações')
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
                <li class="breadcrumb-item"><a href="#">Hablitação</a></li>
                <li class="breadcrumb-item active">Cadastrar</li>
            </ol>
        </div>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="float-left">
                <div class="btn-group">
                    <a href="{{ route('hablitacao.index') }}" class="btn btn-sm btn-block btn-secondary"><i
                            class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="<?= route('hablitacao.store') ?>" method="post" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> efectivo</label>
                    <div class="col-sm-8">
                        <select class="form-control select2 @error('efectivo') is-invalid @enderror" style="width: 100%;"
                            name="efectivo">
                            <option value="">Selecione um efectivo </option>
                            @foreach ($efectivos as $efectivo)
                                <option value="{{ $efectivo->id }}"
                                    {{ $efectivo->id == old('efectivo') ? 'selected' : '' }}>{{ $efectivo->nome }}</option>
                            @endforeach

                        </select>
                        @error('efectivo')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">nome da hablitação</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-edit"></i></span>
                            </div>
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                value="<?= old('nome') ?>" placeholder="nome" autocomplete="off">
                            @error('nome')
                                <div class="invalid-feedback">
                                    <h6>{{ $message }}</h6>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputStatus" class="col-sm-2 control-label">Tipo de hablitação</label>
                    <div class="col-sm-8">
                        <select id="inputStatus" class="form-control custom-select @error('tipo') is-invalid @enderror"
                            style="width: 100%;" name="tipo">
                            <option value=""> Selecione um tipo de hablitação</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->value }}" {{ old('tipo') == $tipo->value ? 'selected' : '' }}>
                                    {{ $tipo->value }}</option>
                            @endforeach
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputClientCompany" class="col-sm-2 control-label">Nivel</label>
                    <div class="col-sm-8">
                        <input type="text" id="inputClientCompany"
                            class="form-control @error('nivel') is-invalid @enderror" name="nivel" placeholder="Nivel">
                        @error('nivel')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
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

@stop

@section('js')
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
@stop
