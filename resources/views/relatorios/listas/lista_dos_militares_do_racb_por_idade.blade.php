@extends('relatorios.listas.listapadrao')
@section('titulo')
lista de efectivos por idade
@endsection
@section('conteudo')

<div class="card text-center" style="margin-top: 10rem;">
    <div class="card-header">
        <h6 class="card-title text-center">Lista de efectivos por idades</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>NIP</th>
                        <th>Nome</th>
                        <th width="150">Data de nascimento</th>
                        <th>Idade</th>
                        <th>FPS</th>
                    </tr>
                </thead>
                <tbody>

                  @forelse ($efectivos as $efectivo)
                      <tr>
                            <td>{{ $loop->index +1 }}</td>
                            <td>{{$efectivo->nip}}</td>
                            <td>{{ $efectivo->nome }}</td>
                            <td>{{ $efectivo->data_de_nascimento }}</td>
                            <td>{{ $efectivo->age}}</td>
                            <td>{{ $efectivo->fps}}</td>
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
    <div class="card-footer text-muted">
        <div class="card-tools">
            <button onclick="window.print()" class="btn btn-primary only-print">Imprimir</button>
        </div>
    </div>
  </div>
@endsection
