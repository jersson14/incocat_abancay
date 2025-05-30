<script src="../js/console_gastos.js?rev=<?php echo time(); ?>"></script>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>MANTENIMIENTO DE GASTOS</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../index.php">MENU</a></li>
                    <li class="breadcrumb-item active">GASTOS</li>
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
                        <h3 class="card-title"><i class="fas fa-file"></i>&nbsp;&nbsp;<b>Listado de Gastos</b>&nbsp;&nbsp;</h3>
                        <button class="btn btn-success float-right" onclick="AbrirRegistro()"><i class="fas fa-plus"></i> Nuevo Registro</button>
                    </div>
                    <div class="table-responsive" style="text-align:left">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2 form-group">
                                    <label for="">Indicador<b style="color:red">(*)</b>:</label>
                                    <select class="js-example-basic-single" id="select_indicadores_buscar" style="width:100%">
                                    </select>
                                </div>
                                <div class="col-2 form-group">
                                    <label for="">Fecha Inicio<b style="color:red">(*)</b>:</label>
                                    <input class="form-control" type="date" id="txtfechainicio">
                                </div>
                                <div class="col-2 form-group">
                                    <label for="">Fecha Final<b style="color:red">(*)</b>:</label>
                                    <input class="form-control" type="date" id="txtfechafin">
                                </div>
                                <div class="col-12 col-md-3" role="document">
                                    <label for="">&nbsp;</label><br>
                                    <button onclick="listar_gastos_filto()" class="btn btn-danger mr-2" style="width:100%" onclick><i class="fas fa-search mr-1"></i>Buscar por indicador y fechas</button>
                                </div>
                                <div class="col-12 col-md-3" role="document">
                                    <label for="">&nbsp;</label><br>
                                    <button onclick="listar_gastos()" class="btn btn-success mr-2" style="width:100%" onclick><i class="fas fa-search mr-1"></i>Listar egresos hoy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" style="text-align:center">
                        <div class="card-body">
                            <table id="tabla_gastos" class="table table-striped table-bordered" style="width:100%">
                                <thead style="background-color:#0A5D86;color:#FFFFFF;">
                                    <tr>
                                    <th style="text-align:center">Nro.</th>
                                    <th style="text-align:center">Indicador</th>
                                    <th style="text-align:center">Cantidad</th>
                                    <th style="text-align:center">Monto gastado</th>
                                    <th style="text-align:center">Observación</th>
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

    <div class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- /.col-md-6 -->
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="nav-icon fas fa-th"></i>&nbsp;&nbsp;<b>Ver diferencia de ingresos y egresos por fechas</b></h3>
          </div>
          <div class="table-responsive" style="text-align:left">
            <div class="card-body">
                <div class="row">               
                    <div class="col-3 form-group">
                        <label for="">Fecha Inicio<b style="color:red">(*)</b>:</label>
                        <input class="form-control" type="date" id="txtfechainicio3">
                    </div>
                    <div class="col-3 form-group">
                        <label for="">Fecha Final<b style="color:red">(*)</b>:</label>
                        <input class="form-control" type="date" id="txtfechafin3">
                    </div>
                    <div class="col-12 col-md-3" role="document">
                        <label for="">&nbsp;</label><br>
                        <button onclick="listar_diferencia_filtro()" class="btn btn-danger mr-2" style="width:100%" onclick><i class="fas fa-search mr-1"></i>Buscar por fechas</button>
                    </div>
                    <div class="col-12 col-md-3" role="document">
                        <label for="">&nbsp;</label><br>
                        <button onclick="listar_diferencia()" class="btn btn-success mr-2" style="width:100%" onclick><i class="fas fa-search mr-1"></i>Listar diferencia hoy</button>
                    </div>
                </div>
            </div>
        </div>
          <div class="table-responsive" style="text-align:center">
          <div class="card-body">
          <table id="tabla_diferencia" class="table table-striped table-bordered" style="width:100%">
              <thead style="background-color:#0A5D86;color:#FFFFFF;">
                  <tr>
                      <th style="text-align:center">Fecha desde</th>
                      <th style="text-align:center">Fecha hasta</th>
                      <th style="text-align:center">Total de Ingresos</th>
                      <th style="text-align:center">Total de Gastos</th>
                      <th style="text-align:center">Diferencia</th>
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
    <!-- Modal -->
    <div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1FA0E0;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white; text-align:center"><b>REGISTRO DE GASTO</b></h5>
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
                            <label for="">Indicador<b style="color:red">(*)</b>:</label>
                            <select class="js-example-basic-single" id="select_indicadores" style="width:100%">
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label for="">Cantidad<b style="color:red">(*)</b>:</label>
                            <input type="number" class="form-control" id="txt_cantidad" placeholder="Ingrese la cantidad">
                        </div>
                        <div class="col-6 form-group">
                            <label for="">Monto gastado<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_monto" placeholder="Ingrese el monto gastado" onkeypress="return soloNumeros(event)">
                            </div>
                            <div class="col-12 form-group">
                            <label for="">Descripción(Opcional):</label>
                            <textarea class="form-control" id="txt_descripcion" rows="4" style="resize:none" placeholder="Ingrese la descripción"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="Registrar_Gasto()"><i class="fas fa-save"></i> Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1FA0E0;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white; text-align:center"><b>EDITAR DATOS DE GASTO</b></h5>
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
                            <label for="">Indicador<b style="color:red">(*)</b>:</label>
                            <input type="hidden" id="txt_id_gasto">
                            <select class="js-example-basic-single" id="select_indicadores_editar" style="width:100%">
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label for="">Cantidad<b style="color:red">(*)</b>:</label>
                            <input type="number" class="form-control" id="txt_cantidad_editar" placeholder="Ingrese la cantidad">
                        </div>
                        <div class="col-6 form-group">
                            <label for="">Monto gastado<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_monto_editar" placeholder="Ingrese el monto gastado" onkeypress="return soloNumeros(event)">
                            </div>
                            <div class="col-12 form-group">
                            <label for="">Descripción(Opcional):</label>
                            <textarea class="form-control" id="txt_descripcion_editar" rows="4" style="resize:none" placeholder="Ingrese la descripción"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="Modificar_Gasto()"><i class="fas fa-edit"></i> Modificar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_anular" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#1FA0E0;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white; text-align:center"><b>EDITAR DATOS DE GASTO</b></h5>
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
                            <label for="">Indicador<b style="color:red">(*)</b>:</label>
                            <input type="hidden" id="txt_id_gasto_anular">
                            <select class="js-example-basic-single" id="select_indicadores_anular" disabled style="width:100%">
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label for="">Cantidad<b style="color:red">(*)</b>:</label>
                            <input type="number" class="form-control" id="txt_cantidad_anular" disabled placeholder="Ingrese la cantidad">
                        </div>
                        <div class="col-6 form-group">
                            <label for="">Monto gastado<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_monto_anular" disabled placeholder="Ingrese el monto gastado" onkeypress="return soloNumeros(event)">
                            </div>
                            <div class="col-12 form-group">
                            <label for="">Motivo de anulación<b style="color:red">(*)</b>:</label>
                            <textarea class="form-control" id="txt_descripcion_anular" rows="4" style="resize:none" placeholder="Ingrese la descripción por anulación"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="Anular_Gasto()"><i class="fas fa-check"></i> Anular</button>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="modal_motivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#1FA0E0;">
        <h5 class="modal-title" id="exampleModalLabel" style="color:white; text-align:center"><b>MOTIVO DE ANULACIÓN DE GASTO</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
          <div class="col-12 form-group">
            <label for="">Fecha de anulación<b style="color:red">(*)</b>:</label>
            <input class="form-control" type="date" id="fecha_anulacion" readonly>
          </div>
          <div class="col-12 form-group">
            <label for="">Motivo de anulación<b style="color:red">(*)</b>:</label>
            <textarea name="" id="txt_observación_motivo" rows="3" class="form-control" style="resize:none;" readonly></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
        <button type="button" class="btn btn-success" onclick="Anular_Ingreso()"><i class="fas fa-check"></i> Modificar</button>
      </div>
    </div>
  </div>
</div>


    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                placeholder: "Seleccionar Indicador",
                allowClear: true
            });
            listar_gastos();
            Cargar_Select_Indicadores();
            listar_diferencia();
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
        document.getElementById('txtfechainicio').value = y + "-" + m + "-" + d;
        document.getElementById('txtfechafin').value = y + "-" + m + "-" + d;

    </script>