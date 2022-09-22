@extends('adminlte::page')
@section('title', 'efectivos')
@section('plugins.bs-stepper', true)
@section('plugins.Duallistbox', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Toastr', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1> RACB-SECÇÃO DE PESSOAL E QUADROS</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">efectivos</a></li>
                <li class="breadcrumb-item active">Cadastrar</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ route('efectivos.store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="float-left">
                            <div class="btn-group">
                                <a href="{{ route('efectivos.index') }}" class="btn btn-sm btn-block btn-secondary"><i
                                        class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="bs-stepper">
                            <div class="bs-stepper-header" role="tablist">
                                <!-- your steps here -->
                                <div class="step" data-target="#pessoais-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="pessoais-part"
                                        id="pessoais-part-trigger">
                                        <span class="bs-stepper-circle">1</span>
                                        <span class="bs-stepper-label">Informções Pessoais</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#militar-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="militar-part"
                                        id="militar-part-trigger">
                                        <span class="bs-stepper-circle">2</span>
                                        <span class="bs-stepper-label">Informações Militar</span>
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content">
                                <!-- nome	nip	numero_do_bi	data_de_emissao	data_de_nascimento	data_de_incorporacao	genero	iban	fliacao	fps	quadro_especial_id	unidade_id	subcategoria_id -->
                                <div id="pessoais-part" class="content" role="tabpanel"
                                    aria-labelledby="pessoais-part-trigger">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nome</label>
                                                <input type="text"
                                                    class="form-control @error('nome') is-invalid @enderror" id="name"
                                                    name="nome" placeholder="Nome" value="{{ old('nome') }}">
                                                @error('nome')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nip">NIP</label>
                                                <input type="text"
                                                    class="form-control @error('nip') is-invalid @enderror" id="nip"
                                                    name="nip" placeholder="NIP" value="{{ old('nip') }}">
                                                @error('nip')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="numero_do_bi">Número do BI</label>
                                                <input type="text"
                                                    class="form-control @error('numero_do_bi') is-invalid @enderror"
                                                    id="numero_do_bi" name="numero_do_bi" placeholder="Número do BI"
                                                    value="{{ old('numero_do_bi') }}">
                                                @error('numero_do_bi')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="data_de_emissao">Data de Emissão</label>
                                                <input type="date"
                                                    class="form-control @error('data_de_emissao') is-invalid @enderror"
                                                    id="data_de_emissao" name="data_de_emissao"
                                                    placeholder="Data de Emissão" value="{{ old('data_de_emissao') }}">
                                                @error('data_de_emissao')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="data_de_nascimento">Data de Nascimento</label>
                                                <input type="date"
                                                    class="form-control @error('data_de_nascimento') is-invalid @enderror"
                                                    id="data_de_nascimento" name="data_de_nascimento"
                                                    placeholder="Data de Nascimento"
                                                    value="{{ old('data_de_nascimento') }}">
                                                @error('data_de_nascimento')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="genero">Género</label>
                                                <select class="form-control @error('genero') is-invalid @enderror"
                                                    id="genero" name="genero">
                                                    <option value="">Selecione</option>
                                                    <option value="Masculino"
                                                        {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino
                                                    </option>
                                                    <option value="Feminino"
                                                        {{ old('genero') == 'Feminino' ? 'Feminino' : '' }}>Feminino
                                                    </option>
                                                </select>
                                                @error('genero')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="iban">IBAN</label>
                                                <input type="text"
                                                    class="form-control @error('iban') is-invalid @enderror"
                                                    id="iban" name="iban" placeholder="IBAN"
                                                    value="{{ old('iban') }}">
                                                @error('iban')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fliacao">Fliacão</label>
                                                <input type="text"
                                                    class="form-control @error('fliacao') is-invalid @enderror"
                                                    id="fliacao" name="fliacao" placeholder="Fliacão"
                                                    value="{{ old('fliacao') }}">
                                                @error('fliacao')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn btn-primary" onclick="stepper.next()">Proximo</a>
                                </div>
                                <div id="militar-part" class="content" role="tabpanel"
                                    aria-labelledby="militar-part-trigger">
                                    <!--  fps	quadro_especial_id	unidade_id  Categoria	subcategoria_id -->

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fps">Forma de Prestação de serviço</label>
                                                <select name="forma_de_prestacao_de_servico" id="fps"
                                                    class="form-control @error('forma_de_prestacao_de_servico') is-invalid @enderror">
                                                    <option value="">Selecione</option>
                                                    @foreach ($fps as $fp)
                                                        <option value="{{ $fp->value }}"
                                                            {{ old('forma_de_prestacao_de_servico') == $fp->value ? 'selected' : '' }}>
                                                            {{ $fp->value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('forma_de_prestacao_de_servico')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quadro_especial">Quadro Especial</label>
                                                <select class="form-control @error('quadro_especial') is-invalid @enderror"
                                                    id="quadro_especial" name="quadro_especial">
                                                    <option value="">Selecione</option>
                                                    @foreach ($quadros as $quadro)
                                                        <option value="{{ $quadro->id }}"
                                                            {{ old('quadro_especial') == $quadro->id ? 'selected' : '' }}>
                                                            {{ $quadro->nome }}</option>
                                                    @endforeach
                                                </select>
                                                @error('quadro_especial')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="unidade">Unidade</label>
                                                <select class="form-control @error('unidade') is-invalid @enderror"
                                                    id="unidade" name="unidade">
                                                    <option value="">Selecione</option>
                                                    @foreach ($unidades as $unidade)
                                                        <option value="{{ $unidade->id }}"
                                                            {{ old('unidade') == $unidade->id ? 'selected' : '' }}>
                                                            {{ $unidade->nome }}</option>
                                                    @endforeach
                                                </select>
                                                @error('unidade')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="categoria">Categoria</label>
                                                <select class="form-control @error('categoria') is-invalid @enderror"
                                                    id="categoria" name="categoria[]">
                                                    <option value="">Selecione</option>
                                                    @foreach ($categorias as $categoria)
                                                        <option value="{{ $categoria->id }}"
                                                            {{ old('categoria') == $categoria->id ? 'selected' : '' }}>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subcategoria">Subcategoria</label>
                                                <select class="form-control @error('subcategoria') is-invalid @enderror"
                                                    id="subcategoria" name="subcategoria">

                                                </select>
                                                @error('subcategoria')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="data_de_incorporacao">Data de Incorporação</label>
                                                <input type="date"
                                                    class="form-control @error('data_de_incorporacao') is-invalid @enderror"
                                                    id="data_de_incorporacao" name="data_de_incorporacao"
                                                    placeholder="Data de Incorporação"
                                                    value="{{ old('data_de_incorporacao') }}">
                                                @error('data_de_incorporacao')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cargo">cargo</label>
                                                <select class="form-control @error('cargo') is-invalid @enderror"
                                                    id="cargo" name="cargo">
                                                    <option value="">Selecione</option>
                                                    @foreach ($cargos as $cargo)
                                                        <option value="{{ $cargo->id }}"
                                                            {{ old('cargo') == $cargo->id ? 'selected' : '' }}>
                                                            {{ $cargo->nome }}</option>
                                                    @endforeach
                                                </select>
                                                @error('cargo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Fotografia</label>
                                                <div class="input-group ">
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="custom-file-input @error('foto') is-invalid @enderror"
                                                            id="exampleInputFile" name="foto">
                                                        <label class="custom-file-label" for="exampleInputFile">
                                                            @if ($errors->first('foto'))
                                                                <strong
                                                                    class="text-danger">{{ $errors->first('foto') }}</strong>
                                                            @else
                                                                selecione uma Fotografia
                                                            @endif
                                                        </label>

                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">carregar</span>
                                                    </div>


                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn btn-primary" onclick="stepper.previous()">Anterior</a>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

    </form>

@stop

@section('css')

@stop

@section('js')
    <script>
        $(function() {
            $('.duallistbox').bootstrapDualListbox();
            bsCustomFileInput.init();
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
        });
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })
    </script>
@stop
