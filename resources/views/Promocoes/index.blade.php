@extends('adminlte::page')

@section('title', 'Promoções')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1> RACB-SECÇÃO DE PESSOAL E QUADROS</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Promoções</a></li>
        <li class="breadcrumb-item active">Lista</li>
      </ol>
    </div>
  </div>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Lista de Promoções
            </h3>
            <div class="card-tools">
                <a href="{{ route('promocoes.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>

                    Adicionar
                </a>

            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
            <table id="promocoes" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>efectivo</th>
                        <th>data da promoção anterior</th>
                        <th>data da promoção actual</th>
                        <th  width="150" >ações</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>

                </tfoot>
            </table>
            </div>
        </div>

    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
  $(function () {
   var tablepromocoes = $("#promocoes").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        order: [[1, 'asc']],
        ajax: {
            url: "{{ route('promocoes.index') }}",
            method: 'GET'
        },
        columnDefs: [{
            orderable: false,
            targets: [0,4]
        }],
        columns: [{
                'data': null
            },
            {
                'data': function (data) { return data.efectivo.nome;}
            },
            {
              'data': 'anterior'
            },

            {
                'data':'actual'
            },


           {"data": function(data) {
                    return `<td  class="text-center" >
                            <div class="  btn-group btn-group-sm">
                                <a href="{{url('promocoes/${data.id}/edit')}}" class="btn btn-primary btn-edit"><i class="fas fa-user-edit"></i></a>
                                <button class="btn btn-danger btn-delete" data-id="${data.id}"><i class="fas fa-trash"></i></button>
                            </div>
                            </td>`
                }
            }
        ]
    });

    $(document).on('click', '.btn-delete', function(e) {
        Swal.fire({
            title: 'Você tem certeza?',
                text: 'Você não poderá reverter isso!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!',
                cancelButtonText: 'Cancelar',

            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        url: `{{ url('promocoes')}}/${$(this).attr('data-id')}`,
                        method: 'DELETE',
                    }).done((data, textStatus, jqXHR) => {
                        Toast.fire({
                            icon: 'success',
                            title: jqXHR.responseJSON.message,
                        });
                        console.log(jqXHR);
                        tablepromocoes.ajax.reload();
                    }).fail((error) => {
                        Toast.fire({
                            icon: 'error',
                            title: error.responseJSON.message,
                        });
                    })
                }
            })
    });

    tablepromocoes.on('draw.dt', function() {
        var PageInfo = $('#promocoes').DataTable().page.info();
        tablepromocoes.column(0, {
            page: 'current'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });


    tablepromocoes.on('order.dt search.dt', () => {
        tablepromocoes.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

  });
    </script>
@stop







