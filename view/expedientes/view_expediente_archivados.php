<script src="../js/console_expediente.js?rev=<?php echo time(); ?>"></script>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>EXPEDIENTES ARCHIVADOS</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../index.php">MENU</a></li>
                    <li class="breadcrumb-item active">ARCHIVADOS</li>
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
                        <h3 class="card-title"><i class="nav-icon fas fas fa-folder"></i>&nbsp;&nbsp;<b>Expedientes Archivados</b></h3>
                    </div>
                    <div class="table-responsive" style="text-align:left">
                        <div class="card-body">
                            <div class="row" style="border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
                                <div class="col-3 form-group">
                                    <label for="">Fecha desde:</label>
                                    <input type="date" class="form-control" id="txt_fecha_desde">
                                </div>
                                <div class="col-3 form-group">
                                    <label for="">Fecha hasta:</label>
                                    <input type="date" class="form-control" id="txt_fecha_hasta">

                                </div>
                                <div class="col-3 form-group">
                                    <label for="">Servicios:</label>
                                    <select class="js-example-basic-single" id="select_servicios_buscar" style="width:100%">
                                    </select>
                                </div>
                                <div class="col-12 col-md-3" role="document">
                                    <label for="">&nbsp;</label><br>
                                    <button onclick="listar_expedientes_filtro_archivados()" class="btn btn-danger mr-2" style="width:100%" onclick><i class="fas fa-search mr-1"></i>Buscar expedientes</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-10 text-center">
                            <div class="alert border rounded p-3 shadow-sm" style="background-color: #f8f9fa;">
                                <h5 class="mb-3" style="color:#0154A0; font-weight: bold;">🔔 Alertas por Días Transcurridos</h5>
                                <div class="d-flex justify-content-center flex-wrap gap-3">
                                    <span class="badge bg-dark p-2 px-3">
                                        <i class="fas fa-clock me-1"></i> 1 día a más - Negro
                                    </span>
                                    <span class="badge bg-success p-2 px-3">
                                        <i class="fas fa-clock me-1"></i> 10 días a más  - Verde
                                    </span>
                                    <span class="badge bg-warning text-dark p-2 px-3">
                                        <i class="fas fa-clock me-1"></i> 20 días a más  - Amarillo
                                    </span>
                                    <span class="badge bg-danger p-2 px-3">
                                        <i class="fas fa-clock me-1"></i> 30 días a más - Rojo
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" style="text-align:center">
                        <div class="card-body">
                            <table id="tabla_expedientes" class="table table-striped table-bordered" style="width:100%">
                                <thead style="background-color:#023D77;color:#FFFFFF;">
                                    <tr>
                                        <th style="text-align:center">Nro Expediente.</th>
                                        <th style="text-align:center">Documento</th>
                                        <th style="text-align:center">Cliente</th>
                                        <th style="text-align:center">Ver más</th>
                                        <th style="text-align:center">Servicio</th>
                                        <th style="text-align:center">Folios</th>
                                        <th style="text-align:center">Estado</th>
                                        <th style="text-align:center">Historial de Estado</th>
                                        <th style="text-align:center">Fecha de Registro</th>
                                        <th style="text-align:center">Días transcurrido</th>
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
<div class="modal fade" id="modal_mostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#1FA0E0;">
          <h5 class="modal-title" id="exampleModalLabel" style="color:white; text-align:center"><b>DATOS DEL CLIENTE</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-12 form-group" style="color:red">
              <h6><b>*LOS DATOS AQUI SOLO SON DE VISTA*</b></h6>
            </div>
            <div class="col-6 form-group">
              <label for="">Tipo de documento:</label>
              <input type="text" id="txt_idcliente_mostrar" hidden>
              <select class="form-control" id="select_tipo_doc_mostrar" style="width:100%" disabled>
                  <option value="" disabled selected>Seleccione</option>
                  <option value="DNI">DNI</option>
                  <option value="CARNET DE EXTRANJERIA">CARNET DE EXTRANJERIA</option>
                  <option value="PASAPORTE">PASAPORTE</option>
              </select>            
            </div>
            <div class="col-6 form-group">
              <label for="">Nro. Documento:</label>
              <input type="text" readonly class="form-control" placeholder="Ingrese el Nro de Documento" id="txt_nro_doc_mostrar" onkeypress="return soloNumeros(event)">
            </div>
            <div class="col-6 form-group">
              <label for="">Nombres:</label>
              <input type="text" readonly class="form-control" placeholder="Ingrese los nombres" id="txt_nombre_mostrar" onkeypress="return sololetras(event)">
            </div>
            <div class="col-6 form-group">
              <label for="">Apellidos:</label>
              <input type="text" readonly class="form-control" placeholder="Ingrese los apellidos" id="txt_apellido_mostrar" onkeypress="return sololetras(event)">
            </div>
            <div class="col-6 form-group">
              <label for="">Celular:</label>
              <input type="text" readonly class="form-control" placeholder="Ingrese el celular" id="txt_celular_mostrar" onkeypress="return soloNumeros(event)">
            </div>
            <div class="col-6 form-group">
              <label for="">Telefono:</label>
              <input type="text" readonly class="form-control" placeholder="Ingrese el telefono" id="txt_telefono_mostrar" onkeypress="return soloNumeros(event)">
            </div>
            <div class="col-6 form-group">
              <label for="">Dirección:</label>
              <textarea class="form-control" readonly id="txt_direccion_mostrar" rows="2" style="resize:none" placeholder="Ingrese la dirección"></textarea>
            </div>
            <div class="col-6 form-group">
              <label for="">Email:</label>
              <input type="email" readonly class="form-control" placeholder="Ingrese el correo electronico" id="txt_email_mostrar">
            </div>
            <div class="col-12 form-group">
              <label for="">Observaciones:</label>
              <textarea class="form-control" readonly id="txt_obser_mostrar" rows="3" style="resize:none" placeholder="Ingrese alguna observación si tuviera"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="modal_ver_historial" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display: flex; flex-direction: column;color:black">
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
                  <table id="tabla_ver_historial" class="display compact" style="width:100%; text-align:center;">
                    <thead style="background-color:#0252A0;color:#FFFFFF;">
                      <tr>
                        <th colspan="5" style="text-align:center; font-size: 18px; font-weight: bold;">HISTORIAL DE MODIFICACIÓN</th>
                      </tr>
                      <tr style="text-align:center;">
                        <th style="text-align:center;">Nro.</th>
                        <th style="text-align:center;">Usuario que modifico</th>
                        <th style="text-align:center;">Estado cambiado</th>
                        <th style="text-align:center;">Motivo</th>
                        <th style="text-align:center;">Fecha de modificación</th>
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

  <div class="modal fade" id="modal_ver_requisitos" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display: flex; flex-direction: column;color:black">
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
                  <table id="tabla_ver_requi" class="display compact" style="width:100%; text-align:center;">
                    <thead style="background-color:#0252A0;color:#FFFFFF;">
                      <tr>
                        <th colspan="5" style="text-align:center; font-size: 18px; font-weight: bold;">HISTORIAL DE MODIFICACIÓN</th>
                      </tr>
                      <tr style="text-align:center;">
                        <th style="text-align:center;">Nro.</th>
                        <th style="text-align:center;">Requisito</th>
                        <th style="text-align:center;">Archivo</th>
                        <th style="text-align:center;">Estado</th>
                        <th style="text-align:center;">Fecha de registro</th>
                        <th style="text-align:center;">Fecha de actualización</th>
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
            $('.js-example-basic-single').select2({
                placeholder: "Seleccionar Servicio",
                allowClear: true
            });
            Cargar_Select_Servi();
            listar_expedientes_archivados();

        });
        $('#modal_registro').on('shown.bs.modal', function() {
            $('#txt_servicio').trigger('focus')
        })
    </script>