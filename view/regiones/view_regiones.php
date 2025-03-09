<script src="../js/console_regiones.js?rev=<?php echo time(); ?>"></script>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>MANTENIMIENTO DE REGIONES</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../index.php">MENU</a></li>
                    <li class="breadcrumb-item active">REGIONES</li>
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
                        <h3 class="card-title"><i class="fas fa-file"></i>&nbsp;&nbsp;<b>Listado de Regiones</b>&nbsp;&nbsp;</h3>
                        <button class="btn btn-success float-right" onclick="AbrirRegistro()"><i class="fas fa-plus"></i> Nuevo Registro</button>
                    </div>
                    <div class="table-responsive" style="text-align:center">
                        <div class="card-body">
                            <table id="tabla_regiones" class="table table-striped table-bordered" style="width:100%">
                                <thead style="background-color:#0A5D86;color:#FFFFFF;">
                                    <tr>
                                        <th style="text-align:center">Nro.</th>
                                        <th style="text-align:center">Región</th>
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
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white; text-align:center"><b>REGISTRO DE REGIÓN</b></h5>
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
                            <label for="">Regíon<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_region" placeholder="Ingrese el nombre de la región" onkeypress="return sololetras(event)">
                        </div>
                        <div class="col-12 form-group">
                            <label for="">Estado<b style="color:red">(*)</b>:</label>
                            <select name="" id="txt_status" class="form-control" disabled>
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label for="">Fecha de Registro<b style="color:red">(*)</b>:</label>
                            <input type="date" class="form-control" id="txt_fecha" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="Registrar_Region()"><i class="fas fa-save"></i> Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1FA0E0;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white; text-align:center"><b>EDITAR DATOS DE REGIÓN </b></h5>
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
                            <label for="">Regíon<b style="color:red">(*)</b>:</label>
                            <input type="text" id="txt_id_region" hidden>
                            <input type="text" class="form-control" id="txt_region_editar" placeholder="Ingrese el nombre de la región" onkeypress="return sololetras(event)">
                        </div>
                        <div class="col-12 form-group">
                            <label for="">Estado<b style="color:red">(*)</b>:</label>
                            <select name="" id="txt_status_editar" class="form-control">
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label for="">Fecha de Actualización<b style="color:red">(*)</b>:</label>
                            <input type="date" class="form-control" id="txt_fecha_actualizacion" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="Modificar_Region()"><i class="fas fa-edit"></i> Modificar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_ver_provincia" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display: flex; flex-direction: column;">
            <h5 class="modal-title" id="lb_titulo_historial"></h5>
            <h5 class="modal-title" id="lb_titulo_historial2" style="margin-top: 10px;"></h5> <!-- Espaciado entre títulos -->
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12" style="text-align:center">
              <div class="table-responsive" style="text-align:center">
                <div class="card-body">
                  <!-- Título general -->
                  <table id="tabla_ver_provincia" class="display compact" style="width:100%; text-align:center;">
                    <thead style="background-color:#0252A0;color:#FFFFFF;">
                      <tr>
                        <th colspan="4" style="text-align:center; font-size: 18px; font-weight: bold;">LISTA DE PROVINCIAS</th>
                      </tr>
                      <tr style="text-align:center;">
                        <th style="text-align:center;">Nro.</th>
                        <th style="text-align:center;">Provincias</th>
                        <th style="text-align:center;">Estado</th>
                        <th style="text-align:center;">Fecha de registro</th>

                      </tr>
                    </thead>
                    
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">
            <i class="fa fa-arrow-right-from-bracket"></i> Cerrar
          </button>
        </div>
      </div>
    </div>
  </div>

    <script>
        $(document).ready(function() {
            listar_regiones();
        });
        $('#modal_registro').on('shown.bs.modal', function() {
            $('#txt_region').trigger('focus')
        })

        var n = new Date();
        var y = n.getFullYear();
        var m = n.getMonth() + 1;
        var d = n.getDate();
        if (d < 10) {
            d = '0' + d;
        }
        if (m < 10) {
            m = '0' + m;

        }
        document.getElementById('txt_fecha').value = y + "-" + m + "-" + d;
        document.getElementById('txt_fecha_actualizacion').value = y + "-" + m + "-" + d;
    </script>