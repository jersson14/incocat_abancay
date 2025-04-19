<script src="../js/console_pagos.js?rev=<?php echo time(); ?>"></script>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>MANTENIMIENTO DE PAGOS</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../index.php">MENU</a></li>
                    <li class="breadcrumb-item active">PAGOS</li>
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
                        <h3 class="card-title"><i class="nav-icon fas fas fa-hand-holding-usd"></i>&nbsp;&nbsp;<b>Listado de pagos</b></h3>
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
                                    <button onclick="listar_pagos_filtro()" class="btn btn-danger mr-2" style="width:100%" onclick><i class="fas fa-search mr-1"></i>Buscar pagos</button>
                                </div>

                            </div>
                        </div>
                    </div>
                  

                    <div class="table-responsive" style="text-align:center">
                        <div class="card-body">
                            <table id="tabla_pagos" class="table table-striped table-bordered" style="width:100%">
                                <thead style="background-color:#023D77;color:#FFFFFF;">
                                    <tr>
                                        <th style="text-align:center">Nro Expediente.</th>
                                        <th style="text-align:center">Documento</th>
                                        <th style="text-align:center">Cliente</th>
                                        <th style="text-align:center">Servicio</th>
                                        <th style="text-align:center">Monto Total</th>
                                        <th style="text-align:center">Saldo Cobrado</th>
                                        <th style="text-align:center">Saldo Pendiente</th>
                                        <th style="text-align:center">Fecha Registro</th>
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
<div class="modal fade" id="modal_pagar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#1FA0E0;">
          <div style="display: flex; flex-direction: column;color:white">
            <h5 class="modal-title" id="lb_tituloesta_pagar"></h5>
            <h5 class="modal-title" id="lb_titulo2esta_pagar" style="margin-top: 10px;"></h5> <!-- Espaciado entre títulos -->
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 form-group" style="color:red">
              <h6><b>Campos Obligatorios (*)</b></h6>
            </div>
            <div class="col-6 form-group">
              <label for="">Saldo Pendiente<b style="color:red">(*)</b>:</label>
              <input type="text" id="id_pago" hidden>
              <input type="text" class="form-control" id="txt_total" disabled>
            </div>
            <div class="col-6 form-group">
              <label for="">Monto total a Cancelar<b style="color:red">(*)</b>:</label>
              <input type="text" class="form-control" id="txt_pagar" placeholder="Ingrese el monto a cancelar" onkeypress="return soloNumeros(event)">
            </div>
            <div class="col-12 form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="chk_aplica_igv">
                    <label class="form-check-label" for="chk_aplica_igv">
                    Aplicar IGV (18%)
                    </label>
                </div>
            </div>
            <div class="col-4 form-group">
              <label for="">IGV(Solo si aplica)</b>:</label>
              <input type="text" class="form-control" id="txt_igv_porcentaje"  onkeypress="return soloNumeros(event)" readonly>
            </div>
            <div class="col-4 form-group">
              <label for="">Total IGV(Solo si aplica)</b>:</label>
              <input type="text" class="form-control" id="txt_igv" placeholder="Ingrese el IGV" onkeypress="return soloNumeros(event)" readonly>
            </div>
            <div class="col-4 form-group">
              <label for="">Subtotal a Cancelar<b style="color:red">(*)</b>:</label>
              <input type="text" class="form-control" id="txt_subtotal_a_cancelar" disabled>
            </div>
            <div class="col-6 form-group">
              <label for="">Nuevo Saldo Pendiente<b style="color:red">(*)</b>:</label>
              <input type="text" class="form-control" id="txt_saldo" disabled>
            </div>
           
            <div class="col-6 form-group">
              <label for="">Fecha de pago<b style="color:red">(*)</b>:</label>
              <input type="date" class="form-control" id="txt_fecha_pago" disabled>
            </div>
            <div class="col-12 form-group">
                <label for="">Observación/Descripción(Opcional)</b>:</label>
                <textarea class="form-control" id="txt_obser" rows="2" style="resize:none" placeholder="Ingrese alguna observación si tuviera"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
          <button type="button" class="btn btn-success" onclick="Realizar_pago()"><i class="fas fa-check"></i> Pagar</button>
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
  <div class="modal fade" id="modal_ver_anulado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#1FA0E0;">
          <div style="display: flex; flex-direction: column;color:white">
            <h5 class="modal-title"><b>MOTIVO DE ANULACIÓN</b></h5>
          </div>
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
              <label for="">Fecha de anulación:</label>
              <input type="datetime" class="form-control" id="txt_fecha_anulado2" disabled>
            </div>
            <div class="col-12 form-group">
              <label for="">Motivo:</label>
              <textarea class="form-control" id="txt_motivo2" disabled rows="4" style="resize:none" placeholder="Ingrese el motivo"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times ml-1"></i> Cerrar</button>
          <button type="button" class="btn btn-success" onclick="Realizar_pago()"><i class="fas fa-check"></i> Pagar</button>
        </div>
      </div>
    </div>
  </div>
  <script>
// Add an event listener to the payment input field
document.getElementById('txt_pagar').addEventListener('input', calculateAll);

// Add event listener to the IGV checkbox
document.getElementById('chk_aplica_igv').addEventListener('change', calculateAll);

// Function to calculate all related values
function calculateAll() {
  // Get the values from the fields
  const totalValue = parseFloat(document.getElementById('txt_total').value) || 0;
  const paymentValue = parseFloat(document.getElementById('txt_pagar').value) || 0;
  const applyIgv = document.getElementById('chk_aplica_igv').checked;
  
  // Set IGV percentage based on checkbox
  const igvPercentage = applyIgv ? 18 : 0;
  document.getElementById('txt_igv_porcentaje').value = igvPercentage;
  
  // Calculate IGV amount (18% of payment value if checkbox is checked, otherwise 0)
  const igvAmount = applyIgv ? (paymentValue * 0.18) : 0;
  document.getElementById('txt_igv').value = igvAmount.toFixed(2);
  
  // Calculate the final amount to pay (payment - IGV)
  const finalAmount = paymentValue - igvAmount;
  document.getElementById('txt_subtotal_a_cancelar').value = finalAmount.toFixed(2);
  
  // Calculate the balance
  const balance = totalValue - paymentValue;
  document.getElementById('txt_saldo').value = balance.toFixed(2);
}

// Also calculate when the total field changes
document.getElementById('txt_total').addEventListener('input', calculateAll);

// Initialize all calculations when the modal opens
$('#modal_pagar').on('shown.bs.modal', function() {
  // Set today's date by default
  const today = new Date();
  const formattedDate = today.toISOString().substring(0, 10); // Format as YYYY-MM-DD
  document.getElementById('txt_fecha_pago').value = formattedDate;
  
  // Calculate all values
  calculateAll();
});
  </script>


  <script>
  $(document).ready(function () {
    // Al iniciar, deshabilitamos el textarea
    $('#txt_motivo').prop('disabled', true);

    // Escuchamos cambios en el select
    $('#select_estado_edit').on('change', function () {
      const estado = $(this).val();

      if (estado === 'OBSERVADO') {
        $('#txt_motivo').prop('disabled', false);
      } else {
        $('#txt_motivo').prop('disabled', true).val('');
      }
    });
  });
</script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                placeholder: "Seleccionar Servicio",
                allowClear: true
            });
            listar_pagos();
            Cargar_Select_Servi();
        });
        $('#modal_registro').on('shown.bs.modal', function() {
            $('#txt_servicio').trigger('focus')
        })
    </script>