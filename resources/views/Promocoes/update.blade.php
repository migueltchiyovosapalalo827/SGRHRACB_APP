@extends('adminlte::page')

@section('title', 'Promoção')
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
                <li class="breadcrumb-item"><a href="#">Promoção</a></li>
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
                    <a href="{{ route('promocoes.index') }}" class="btn btn-sm btn-block btn-secondary"><i
                            class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('promocoes.update', ['promoco' => $promoco->id]) }}" method="post"
                class="form-horizontal">
                @method('PUT')
                @csrf

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Efectivo</label>
                    <div class="col-sm-8">
                        <select class="form-control select2 @error('efectivo') is-invalid @enderror" style="width: 100%;"
                            name="efectivo">
                            <option value="">selecione um efectivo</option>
                            @foreach ($efectivos as $efectivo)
                                <option value="{{ $efectivo->id }}"
                                    {{ $efectivo->id == $promoco->efectivo->id ? 'selected' : '' }}>
                                    {{ $efectivo->nome }}</option>
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
                    <label for="categoria" class="col-sm-2 control-label">Categoria</label>
                    <div class="col-sm-8">
                        <select class="form-control select2 @error('categoria') is-invalid @enderror" id="categoria"
                            name="categoria[]">
                            <option value="">Selecione</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ $promoco->efectivo->subcategoria->categoria->id == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                        @error('categoria')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="subcategoria" class="col-sm-2 control-label">Subcategoria</label>
                    <div class="col-sm-8">
                        <select class="form-control select2 @error('subcategoria') is-invalid @enderror" id="subcategoria"
                            name="subcategoria">

                        </select>
                        @error('subcategoria')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="data_da_actual_promocao" class="col-sm-2 col-form-label">Data da promoção </label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control @error('data_da_actual_promocao') is-invalid @enderror"
                            id="data_da_actual_promocao" name="data_da_actual_promocao" placeholder="Data da Promoção"
                            value="{{ old('data_da_actual_promocao') ?? $promoco->anterior }}">
                        @error('data_da_actual_promocao')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
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
        });
    </script>


<script>
    $(function() {
        //função para carregar as subcategorias de acordo com a categoria selecionada
        $('#categoria').change(function() {
            var categoria_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var option = '<option value="">Selecione</option>';
            $.ajax({
                url: `{{ url('categoriasGetsubcategorias/${categoria_id}') }}`,
                method: "POST",
                data: {
                    _token: _token
                },
                success: function(data) {
                    console.log(data);
                    $.each(data, function(key, value) {
                        option += '<option value="' + value.id + '">' + value.nome +
                            '</option>';
                    });
                    $('#subcategoria').html(option);
                }
            });
        });
        //função para buscar as subcategoria se o id da categoria exitir
        if (`{{ $promoco->efectivo->subcategoria->categoria->id }}` != '') {
            var categoria_id = $('#categoria').val();
            var _token = $('input[name="_token"]').val();
            var option = '<option value="">Selecione</option>';
            $.ajax({
                url: `{{ url('categoriasGetsubcategorias/' . $promoco->efectivo->subcategoria->categoria->id) }}`,
                method: "POST",
                data: {
                    _token: _token
                },
                success: function(data) {
                    console.log(data);
                    $.each(data, function(key, value) {
                        if (value.id == `{{ $promoco->efectivo->subcategoria->id }}`) {
                            option += '<option value="' + value.id + '" selected >' + value
                                .nome +
                                '</option>';
                        } else {
                            option += '<option value="' + value.id + '">' + value.nome +
                                '</option>';
                        }

                    });
                    $('#subcategoria').html(option);
                }
            });
        }
    });

</script>
@stop
