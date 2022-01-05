<style>
.box {
  position: relative;
  background: #ffffff;
  width: 100%;
}

.box-header {
  color: #444;
  display: block;
  padding: 10px;
  position: relative;
  border-bottom: 1px solid #f4f4f4;
  margin-bottom: 10px;
}

.box-tools {
  position: absolute;
  right: 10px;
  top: 5px;
}

.dropzone-wrapper {
  border: 2px dashed #91b0b3;
  color: #92b0b3;
  position: relative;
  height: 150px;
}

.dropzone-desc {
  position: absolute;
  margin: 0 auto;
  left: 0;
  right: 0;
  text-align: center;
  width: 40%;
  top: 50px;
  font-size: 16px;
}

.dropzone,
.dropzone:focus {
  position: absolute;
  outline: none !important;
  width: 100%;
  height: 150px;
  cursor: pointer;
  opacity: 0;
}

.dropzone-wrapper:hover,
.dropzone-wrapper.dragover {
  background: #ecf0f5;
}

.preview-zone {
  text-align: center;
}

.preview-zone .box {
  box-shadow: none;
  border-radius: 0;
  margin-bottom: 0;
}
.btn-danger1{
        background:silver !important;
    }
</style>
@extends('adminlte::page')

@section('title', 'Modulo Peliculas')

@section('content_header')
<h1>
    Peliculas
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
                    <h3 class="card-title">Listado de Peliculas</h3>
                </div>
            <!-- /.card-header -->
            <div class="mt-3">
                <!--peliculas-->
                <button type="button" class="btn btn-primary ml-2" data-toggle="modal"
                    data-target="#modal-crear-pelicula"><i class="fa fa-plus-circle pr-2"></i>Nueva Pelicula
                </button>
            </div>
            <div class="card-body">
                <table id="tabla-pelicula" class="table table-bordered table-striped" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>F. Publicación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peliculas as $pelicula)
                        <tr>
                            <td>{{ $pelicula->id }}</td>
                            <td>{{ $pelicula->nombre }}</td>
                            <td>{{ date('d-m-Y', strtotime($pelicula->fecha_publicacion )) }}</td>
                            <td>{{ $pelicula->estado === '1' ? 'Activo' : 'Inactivo'  }}</td>
                            <td>
                                @if($pelicula->estado === '1')
                                <form action="{{ route ('admin.pelicula.cambiarEstado', $pelicula->id) }}"
                                    class="d-inline" method="post">
                                    {{ csrf_field() }}
                                    @method('POST')
                                    <button class="btn btn-danger1 btn-sm btn-xs"><i class="fas fa-lock"></i></button>
                                </form>
                                @else
                                    <button class="btn btn-info btn-sm btn-xs"><i class="fas fa-unlock"></i></button>
                                @endif
                                <button type="button" class="btn btn-warning btn-sm btn-xs" data-toggle="modal" data-target="#modal-update-pelicula-{{$pelicula->id}}"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-success btn-sm btn-xs ml-2" data-toggle="modal"
                                    data-target="#modal-crear-turno"><i class="fas fa-bars"></i>
                                </button>
                                <form action="{{ route ('admin.pelicula.eliminar', $pelicula->id) }}"
                                    class="d-inline" method="post">
                                    {{ csrf_field() }}
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-xs"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <!-- modal update -->
                        @include('admin.pelicula.modal-update-pelicula')
                        <!-- /.modal update-->
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>F. Publicación</th>
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

<!-- Modal Nueva Pelicula -->
<div class="modal fade" id="modal-crear-pelicula" tabindex="-1" role="dialog" aria-labelledby="modal-crear-pelicula"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modal-crear-pelicula">Nueva pelicula
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.pelicula.registro') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombres</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_publicacion">Fecha de publicación</label>
                        <input class="form-control" type="date" name="fecha_publicacion" min="{{\Carbon\Carbon::now()->format('Y-m-d')}}" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Imagen</label>
                        <div class="preview-zone hidden">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <div><b></b></div>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-danger btn-xs remove-preview">
                                        <i class="fa fa-times"></i> Resetear
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body"></div>
                            </div>
                        </div>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Click o Arrastre Aqui</p>
                            </div>
                                <input type="file" name="imagen" accept="image/jpeg,image/png,image/x-eps" class="dropzone">
                        </div>
                    </div>
                    <div id="success-message"></div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="crear-tipo-pelicula">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Nueva Pelicula  -->

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
                        <label for="hora">Horario</label>
                        <input type="time" class="form-control" name="hora" min="{{\Carbon\Carbon::now()->format('H:i')}}" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="estado" class="form-check-input" id="accept">
                            <label class="form-check-label2" for="accept" required>Activo?</label>
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
    $('#tabla-pelicula').DataTable({
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
function readFile(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      var htmlPreview =
        '<img width="200" src="' + e.target.result + '" />' +
        '<p>' + input.files[0].name + '</p>';
      var wrapperZone = $(input).parent();
      var previewZone = $(input).parent().parent().find('.preview-zone');
      var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

      wrapperZone.removeClass('dragover');
      previewZone.removeClass('hidden');
      boxZone.empty();
      boxZone.append(htmlPreview);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function reset(e) {
  e.wrap('<form>').closest('form').get(0).reset();
  e.unwrap();
}

$(".dropzone").change(function() {
  readFile(this);
});

$('.dropzone-wrapper').on('dragover', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).addClass('dragover');
});

$('.dropzone-wrapper').on('dragleave', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).removeClass('dragover');
});

$('.remove-preview').on('click', function() {
  var boxZone = $(this).parents('.preview-zone').find('.box-body');
  var previewZone = $(this).parents('.preview-zone');
  var dropzone = $(this).parents('.form-group').find('.dropzone');
  boxZone.empty();
  previewZone.addClass('hidden');
  reset(dropzone);
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
