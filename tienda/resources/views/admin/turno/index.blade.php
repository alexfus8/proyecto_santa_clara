<style>
    .btn-success{
        background:silver !important;
    }
</style>
@extends('adminlte::page')

@section('title', 'Modulo Turnos')

@section('content_header')
<h1>
    Turnos
</h1>
@stop

@section('css')
<link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Turnos</h3>
                </div>
            <!-- /.card-header -->
            <div class="mt-3">
                <!--turnos-->
                <button type="button" class="btn btn-primary ml-2" data-toggle="modal"
                    data-target="#modal-crear-turno"><i class="fa fa-plus-circle pr-2"></i>Nuevo Turno
                </button>
            </div>
            <div class="card-body">
                <table id="tabla-turno" class="table table-bordered table-striped" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Turno</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($turnos as $turno)
                        <tr>
                            <td>{{ $turno->id }}</td>
                            <td>{{ date('H:i', strtotime($turno->hora )) }}</td>
                            <td>{{ $turno->estado === '1' ? 'Activo' : 'Inactivo'  }}</td>
                            <td>
                                @if($turno->estado === '1')
                                <form action="{{ route ('admin.turno.cambiarEstado', $turno->id) }}"
                                    class="d-inline" method="post">
                                    {{ csrf_field() }}
                                    @method('POST')
                                    <button class="btn btn-success btn-sm btn-xs"><i class="fas fa-lock"></i></button>
                                </form>
                                @else
                                    <button class="btn btn-info btn-sm btn-xs"><i class="fas fa-unlock"></i></button>
                                @endif
                                <button type="button" class="btn btn-warning btn-sm btn-xs" data-toggle="modal" data-target="#modal-update-turno-{{$turno->id}}"><i class="fas fa-edit"></i></button>
                                <form action="{{ route ('admin.turno.eliminar', $turno->id) }}"
                                    class="d-inline" method="post">
                                    {{ csrf_field() }}
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-xs"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Turno</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>

<!-- Modal Crear Turno  -->
<div class="modal fade" id="modal-crear-turno" tabindex="-1" role="dialog" aria-labelledby="modal-crear-turno"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modal-crear-turno">Nuevo Turno
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.turno.registro') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="hora">Turno</label>
                        <input type="time" class="form-control" name="hora" min="{{\Carbon\Carbon::now()->format('H:i')}}" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="estado" class="form-check-input" id="accept" required>
                            <label class="form-check-label2" for="accept">Activo?</label>
                        </div>
                    </div>
                    <div id="success-message"></div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="crear-turno">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Crear Turno  -->
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#tabla-turno').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print'],
        responsive: true,
        autoWidth:false,
        "order": [[ 3, "asc" ]],
        "language": {
              "lengthMenu": "Mostrar _MENU_ registros por páginas",
              "zeroRecords": "Nada encontrado - disculpa",
              "info": "Mostrando la página _PAGE_ de _PAGES_",
              "infoEmpty": "No records available",
              "infoFiltered": "(filtrado de _MAX_ total registros totales)",
              "search": "Buscar:",
              "paginate": {
              "next": "Siguiente",
              "previous": "Anterior"
                }
        }
    });
});
</script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

@stop
