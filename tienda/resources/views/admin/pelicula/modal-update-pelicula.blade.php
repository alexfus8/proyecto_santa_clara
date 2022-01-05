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
<div class="modal fade" id="modal-update-pelicula-{{$pelicula->id}}">
    <div class="modal-dialog">
        <div class="modal-content bg-default">
            <div class="modal-header">
                <h4 class="modal-title">Actualizar Pelicula</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
                <form action="{{ route ('admin.pelicula.actualizar', $pelicula->id) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    < class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombres</label>
                            <input type="text" class="form-control" name="nombre" value="{{$pelicula->nombre}}">
                        </div>
                        <div class="form-group">
                            <label for="fecha_publicacion">Fecha de publicación</label>
                            <input class="form-control" type="date" name="fecha_publicacion"  min="{{\Carbon\Carbon::now()->format('Y-m-d')}}" value="{{$pelicula->fecha_publicacion}}">
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
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary">Save changes</button>
                    </div>
                </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('js')
<script>
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


@stop
