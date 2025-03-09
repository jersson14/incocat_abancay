<script src="../js/console_servicios.js?rev=<?php echo time(); ?>"></script>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>MANTENIMIENTO DE SERVICIOS</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="../index.php">MENU</a></li>
          <li class="breadcrumb-item active">SERVICIOS</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- /.col-md-6 -->
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fas fas fa-hands-helping"></i>&nbsp;&nbsp;<b>Listado de Servicios</b></h3>
            <button class="btn btn-success float-right" onclick="AbrirRegistro()"><i class="fas fa-plus"></i> Nuevo Registro</button>
          </div>
          <div class="table-responsive" style="text-align:center">
            <div class="card-body">
              <table id="tabla_servicios" class="table table-striped table-bordered" style="width:100%">
                <thead style="background-color:#023D77;color:#FFFFFF;">
                  <tr>
                    <th style="text-align:center">Nro.</th>
                    <th style="text-align:center">Servicio</th>
                    <th style="text-align:center">Costo</th>
                    <th style="text-align:center">Requisitos</th>
                    <th style="text-align:center">Fecha de Registro</th>
                    <th style="text-align:center">Fecha de Actualización</th>
                    <th style="text-align:center">Ultimo Usuario en Actualizar</th>
                    <th style="text-align:center">Estado</th>
                    <th style="text-align:center">Acción</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>

        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
  <!-- Modal -->
  <div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#1FA0E0;">
          <h5 class="modal-title" id="exampleModalLabel" style="color:white; text-align:center"><b>REGISTRO DE SERVICIO</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 form-group" style="color:red">
              <h6><b>Campos Obligatorios (*)</b></h6>
            </div>
            <div class="col-12 form-group">
              <label for="">Servicio<b style="color:red">(*)</b>:</label>
              <input type="text" autocomplete="on" class="form-control" placeholder="Ingrese el área u oficina" id="txt_servicio" onkeypress="return sololetras(event)">
            </div>
            <div class="col-12 form-group">
              <label for="">Costo<b style="color:red">(*)</b>:</label>
              <input type="text" autocomplete="on" class="form-control" placeholder="Ingrese el costo" id="txt_costo" onkeypress="return soloNumeros(event)">
            </div>
            <div class="col-12 form-group">
              <label for="">Requisitos<b style="color:red">(*)</b>:</label>
              <textarea class="form-control" id="txt_requisitos" rows="4" style="resize:none" placeholder="Ingrese los requisitos"></textarea>
            </div>
            <div class="col-12 form-group">
              <label for="">Descripción(Opcional):</label>
              <textarea class="form-control" id="txt_descripcion" rows="4" style="resize:none" placeholder="Ingrese la descripción"></textarea>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
          <button type="button" class="btn btn-success" onclick="Registrar_Servicio()"><i class="fas fa-save"></i> Registrar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#1FA0E0;">
          <h5 class="modal-title" id="exampleModalLabel" style="color:white; text-align:center"><b>EDITAR DATOS DEL SERVICIO</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-12 form-group" style="color:red">
              <h6><b>Campos Obligatorios (*)</b></h6>
            </div>
            <div class="col-12 form-group">
              <label for="">Servicio<b style="color:red">(*)</b>:</label>
              <input type="text" id="txt_idservicio" hidden>
              <input type="text" autocomplete="on" class="form-control" placeholder="Ingrese el área u oficina" id="txt_servicio_editar" onkeypress="return sololetras(event)">
            </div>
            <div class="col-12 form-group">
              <label for="">Costo<b style="color:red">(*)</b>:</label>
              <input type="text" autocomplete="on" class="form-control" placeholder="Ingrese el costo" id="txt_costo_editar" onkeypress="return soloNumeros(event)">
            </div>
            <div class="col-12 form-group">
              <label for="">Requisitos<b style="color:red">(*)</b>:</label>
              <textarea class="form-control" id="txt_requisitos_editar" rows="4" style="resize:none" placeholder="Ingrese los requisitos"></textarea>
            </div>
            <div class="col-12 form-group">
              <label for="">Descripción(Opcional):</label>
              <textarea class="form-control" id="txt_descripcion_editar" rows="4" style="resize:none" placeholder="Ingrese la descripción"></textarea>
            </div>
            <div class="col-12 form-group">
              <label for="">Rol<b style="color:red">(*)</b>:</label>
              <select class="form-control" id="select_status_editar" style="width:100%">
                  <option value="">Seleccione</option>
                  <option value="ACTIVO">ACTIVO</option>
                  <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
          <button type="button" class="btn btn-success" onclick="Modificar_Servicio()"><i class="fas fa-edit"></i> Modificar</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="modal_mostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#1FA0E0;">
          <h5 class="modal-title" id="exampleModalLabel" style="color:white; text-align:center"><b>DATOS DEL SERVICIO</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="row">

            <div class="col-12 form-group">
              <label for="">Servicio:</label>
              <input type="text" autocomplete="on" class="form-control" placeholder="Ingrese el área u oficina" id="txt_servicio_mostrar" readonly onkeypress="return sololetras(event)">
            </div>
            <div class="col-12 form-group">
              <label for="">Costo:</label>
              <input type="text" autocomplete="on" class="form-control" placeholder="Ingrese el costo" id="txt_costo_mostrar" readonly onkeypress="return soloNumeros(event)">
            </div>
            <div class="col-12 form-group">
              <label for="">Requisitos:</label>
              <textarea class="form-control" id="txt_requisitos_mostrar" rows="4" style="resize:none" readonly placeholder="Ingrese los requisitos"></textarea>
            </div>
            <div class="col-12 form-group">
              <label for="">Descripción(Opcional):</label>
              <textarea class="form-control" id="txt_descripcion_mostrar" rows="4" style="resize:none" readonly placeholder="Ingrese la descripción"></textarea>
            </div>
            <div class="col-12 form-group">
              <label for="">Rol:</label>
              <select class="form-control" id="select_status_mostrar" style="width:100%" disabled>
                  <option value="">Seleccione</option>
                  <option value="ACTIVO">ACTIVO</option>
                  <option value="INACTIVO">INACTIVO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
          <button type="button" class="btn btn-success" onclick="Modificar_Servicio()"><i class="fas fa-edit"></i> Modificar</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      listar_servicios();

    });
    $('#modal_registro').on('shown.bs.modal', function() {
      $('#txt_servicio').trigger('focus')
    })
  </script>