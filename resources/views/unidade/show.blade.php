@extends('adminlte::page')

@section('title', 'Unidedes')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1> RACB-SECÇÃO DE PESSOAL E QUADROS</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SUB-UNIDADES</a></li>
                <li class="breadcrumb-item active">visualizar</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $unidade->nome }}</h3>

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
                                Lista de efetivos da sub-unidade
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('imprimirListaEfectivos', ['unidade'=>$unidade->id]) }}" class="btn btn-sm btn-primary"><i
                                        class="far fa-fw fa-file-pdf"></i>Imprimir Lista de efectivos</a>

                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Nome</th>
                                        <th>Feleciação</th>
                                        <th width="150">Data de nascimento</th>
                                        <th width="150">Data de incorporação</th>
                                        <th>NIP</th>
                                        <th>Nº BI</th>
                                        <th>IBAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @forelse ($unidade->efectivos as $efectivo)
                                      <tr>
                                            <td>{{ $loop->index +1 }}</td>
                                            <td>{{ $efectivo->nome }}</td>
                                            <td>{{ $efectivo->feliciacao }}</td>
                                            <td>{{ $efectivo->data_nascimento }}</td>
                                            <td>{{ $efectivo->data_incorporacao }}</td>
                                            <td>{{ $efectivo->nip }}</td>
                                            <td>{{ $efectivo->nbi }}</td>
                                            <td>{{ $efectivo->iban }}</td>
                                      </tr>
                                  @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-danger">Nenhum efectivo encontrado</td>
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
