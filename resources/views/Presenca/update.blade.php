@extends('adminlte::page')
@section('title', 'Presenca')
@section('plugins.Select2', true)
@section('plugins.bootstrap-switch', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Toastr', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1> RACB-SECÇÃO DE PESSOAL E QUADROS</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Presença</a></li>
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
                    <a href="{{ route('presenca.index') }}" class="btn btn-sm btn-block btn-secondary"><i
                            class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('presenca.update', ['presenca' => $presenca->id]) }}" method="post"
                class="form-horizontal">
                @method('PUT')
                @csrf

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> efectivo</label>
                    <div class="col-sm-8">
                        <select class="form-control select2 @error('efectivo') is-invalid @enderror" style="width: 100%;"
                            name="efectivo">
                            <option value="">Selecione um efectivo </option>
                            @foreach ($efectivos as $efectivo)
                                <option value="{{ $efectivo->id }}"
                                    {{ old('efectivo') ?? $efectivo->id ==  $presenca->efectivo->id ? 'selected' : '' }}>{{ $efectivo->nome }}</option>
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
                    <label for="inputName" class="col-sm-2 col-form-label">ausente</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ausente" {{ $presenca->ausente == 1 ? 'checked': ''}} value="1">
                                <label class="form-check-label">Sim</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="ausente" {{ $presenca->ausente == 0 ? 'checked': ''}} value="0">
                                <label class="form-check-label">Não</label>
                              </div>

                            @error('ausente')
                                <div class="invalid-feedback">
                                    <h6>{{ $message }}</h6>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputStatus" class="col-sm-2 control-label">Motivos da ausencia</label>
                    <div class="col-sm-8">
                        <select id="inputStatus" class="form-control custom-select @error('motivo') is-invalid @enderror"
                            style="width: 100%;" name="motivo">
                            <option value=""> Selecione um motivos </option>
                            @foreach ($motivos as $motivo)
                                <option value="{{ $motivo->value }}"
                                    {{ $presenca->motivo == $motivo->value ? 'selected' : '' }}>
                                    {{ $motivo->value }}</option>
                            @endforeach
                        </select>
                        @error('motivo')
                            <div class="invalid-feedback">
                                <h6>{{ $message }}</h6>
                            </div>
                        @enderror
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
            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
        });
    </script>
@stop
