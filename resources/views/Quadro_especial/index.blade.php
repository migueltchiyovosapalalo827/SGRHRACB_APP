@extends('adminlte::page')
@section('title', 'quadro_especial')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1> RACB-SECÇÃO DE PESSOAL E QUADROS</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Quadro_especial ou Especialidades</a></li>
        <li class="breadcrumb-item active">Lista</li>
      </ol>
    </div>
  </div>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Lista de quadro_especials ou Especialidades
            </h3>
            <div class="card-tools">
                <a href="{{ route('quadro_especial.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i>

                    Adicionar
                </a>

            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
            <table id="quadro_especial" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Especialidade</th>
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
   var tablequadro_especial = $("#quadro_especial").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        order: [[1, 'asc']],
        ajax: {
            url: "{{ route('quadro_especial.index') }}",
            method: 'GET'
        },
        columnDefs: [{
            orderable: false,
            targets: [0,2]
        }],
        columns: [{
                'data': null
            },
            {
              'data': 'nome'
            },

           {"data": function(data) {
                    return `<td  class="text-center" >
                            <div class="  btn-group btn-group-sm">
                                <a href="{{url('quadro_especial/${data.id}/edit')}}" class="btn btn-primary btn-edit"><i class="fas fa-user-edit"></i></a>
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
                        url: `{{ url('quadro_especial')}}/${$(this).attr('data-id')}`,
                        method: 'DELETE',
                    }).done((data, textStatus, jqXHR) => {
                        Toast.fire({
                            icon: 'success',
                            title: jqXHR.responseJSON.message,
                        });
                        console.log(jqXHR);
                        tablequadro_especial.ajax.reload();
                    }).fail((error) => {
                        Toast.fire({
                            icon: 'error',
                            title: error.responseJSON.message,
                        });
                    })
                }
            })
    });

    tablequadro_especial.on('draw.dt', function() {
        var PageInfo = $('#quadro_especial').DataTable().page.info();
        tablequadro_especial.column(0, {
            page: 'current'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });


    tablequadro_especial.on('order.dt search.dt', () => {
        tablequadro_especial.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

  });
    </script>
@stop

