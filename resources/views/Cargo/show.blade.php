@extends('adminlte::page')

@section('title', 'categorias')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1> RACB-SECÇÃO DE PESSOAL E QUADROS</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Cargos ou funções exercidas</a></li>
                <li class="breadcrumb-item active">visualizar</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$cargo->nome }}</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Lista de permissões asssociados a este cargo
                            </h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Nome</th>

                                    </tr>
                                </thead>
                                <tbody>
                                  @forelse ($cargo->permissoes as $permissao)
                                      <tr>
                                            <td>{{ $loop->index +1 }}</td>
                                            <td>{{ $permissao->nome }}</td>

                                      </tr>
                                  @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-danger">Nenhuma sub-categoria encontrada</td>
                                        </tr>

                                  @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <!-- /.card-body -->
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop
