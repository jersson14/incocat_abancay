

<script src="../js/console_expediente_editar.js?rev=<?php echo time(); ?>"></script>
<link rel="stylesheet" href="../plantilla/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<input type="text" id="dni" autocomplete="off" name="dni" hidden>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>DATOS EL EXPEDIENTE</b></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../index.php">MENU</a></li>
                    <li class="breadcrumb-item active">EXPEDIENTE</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="col-12">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b><u>DATOS DEL CLIENTE</u></b></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 form-group" style="color:red">
                            <h7><b>Campos Obligatorios (*)</b></h7>
                        </div>
                        <div class="col-6 form-group">
                            <label for="" style="font-size:small;">Tipo de documento<b style="color:red">(*)</b>:</label>
                            <select class="form-control" id="select_tipo_documento" style="width:100%" readonly>
                                <option value="" disabled>Seleccione</option>
                                <option value="DNI" selected>DNI</option>
                                <option value="CARNET DE EXTRANJERIA">CARNET DE EXTRANJERIA</option>
                                <option value="PASAPORTE">PASAPORTE</option>
                            </select>
                        </div>

                        <div id="dni_section" class="col-6 form-group">
                            <label for="" style="font-size:small;">N° Documento<b style="color:red">(*)</b>:</label>
                            <div class="input-group">
                            <input type="text" class="form-control" placeholder="Ingrese el Nro de Documento" id="txt_dni" onkeypress="return soloNumeros(event)" readonly>
                            <div class="input-group-append">
                                    <button onclick="" class="btn btn-primary" id="prueba" disabled><i class="fa fa-search" ></i><b> Reniec</b></button>
                                </div>
                            </div>
                        </div>
                        <div id="otros_documentos_section" class="col-6 form-group" style="display: none;">
                            <label for="" style="font-size:small;">N° Documento<b style="color:red">(*)</b>:</label>
                            <div class="input-group">
                            <input type="text" class="form-control" placeholder="Ingrese los nombres" id="txt_nro_doc" onkeypress="return sololetras(event)" readonly>

                            </div>
                        </div>
                        <div class="col-6 form-group">
                            <label for="" style="font-size:small;">Nombres<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_nomb" onkeypress="return sololetras(event)" readonly>
                        </div>
                        <div class="col-6 form-group">
                            <label for="" style="font-size:small;">Apellidos<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_ape" onkeypress="return sololetras(event)" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">Celular<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_celular" maxlength="9" onkeypress="return soloNumeros(event)" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">Telefono(Opcional)::</label>
                            <input type="text" class="form-control" id="txt_telefono" maxlength="9" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">Email(Opcional)::</label>
                            <input type="text" class="form-control" id="txt_email" readonly>
                        </div>
                        <div class="col-12 form-group">
                            <label for="" style="font-size:small;">Dirección(Opcional):</label>
                            <input type="text" class="form-control" id="txt_dire" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">Región<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_region"  readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">Provincia<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_provincia" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">Distrito<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_distrito" readonly>
                        </div>

                        <div class="col-12 form-group">
                            <label for="" style="font-size:small;">Descripción(Opcional):</label>
                            <input type="text" class="form-control" id="txt_descrip" readonly>
                        </div>
                        <div class="col-12"><br>
                            <label for="" style="font-size:small;">En Representación</label>
                        </div>
                        <div class="col-12 row">
                            <!--radio-->
                            <div class="col-4 form-group clearfix">
                                <div class="icheck-success d-inline">
                                    <input type="radio" checked value="A Nombre Propio" id="rad_presentacion1" name="r1" disabled>
                                    <label for="rad_presentacion1" style="font-weight:normal; font-size:small">
                                        <b>A Nombre Propio</b>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 form-group clearfix">
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="rad_presentacion2" name="r1" value="A Otra Persona Natural" disabled>
                                    <label for="rad_presentacion2" style="font-weight:normal; font-size:small">
                                        <b>A Otra Persona Natural</b>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 form-group clearfix">
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="rad_presentacion3" name="r1" value="Persona Jurídica" disabled>
                                    <label for="rad_presentacion3" style="font-weight:normal; font-size:small">
                                        <b>Persona Jurídica</b>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row" id="div_juridico" style="display:none">
                            <div class="row">
                                <div class="col-4 form-group">
                                    <label for="" style="font-size:small;">RUC<b style="color:red">(*)</b>:</label>
                                    <input type="text" class="form-control" id="txt_ruc" onkeypress="return soloNumeros(event)" readonly>
                                </div>
                                <div class="col-8 form-group">
                                    <label for="" style="font-size:small;">Razón Social<b style="color:red">(*)</b>:</label>
                                    <input type="text" class="form-control" id="txt_razon" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><b><u>DATOS DEL EXPEDIENTE</u></b></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 form-group" style="color:red">
                            <h7><b>Campos Obligatorios (*)</b></h7>
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">Servicio<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_servicio" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">N° Expediente<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_nro_expediente" onkeypress="return soloNumeros(event)" readonly>
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">N° Folios<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_folio" onkeypress="return soloNumeros(event)" readonly>
                        </div>
                        <div class="col-12 form-group" style="color:red">
                            <label for="">OJO: (los documentos como requisitos deben estar en un solo archivo en formato PDF, deberá optimizar los documentos antes de enviarlos. El tamaño máximo de los archivos no debe superar los 15MB).</label>
                            <div class="col-12 table-responsive" style="text-align:center">
                                <table id="tabla_requisito_mostrar" style="width:100%" class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Requisito</th>
                                            <th>Archivo</th>
                                            <th>Estado</th>
                                            <th>Fecha de Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_tabla_requisito">
                                        <!-- Aquí se agregarán las filas dinámicamente con JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 form-group" id="total_requisitos" style="font-size: 40px; font-weight: bold; margin-top: 20px; text-align: center; padding-right: 30px; border: 2px solid #0154A0; border-radius: 10px; padding: 10px; color: black;">
                                <label for="precio_total">Precio total del servicio: S/</label>
                                <input type="text" id="precio_total" value="0" style="font-size: 35px; font-weight: bold; width: 200px; text-align: center;" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
document.addEventListener("DOMContentLoaded", () => {
  cargarDatosDesdeLocalStorage();
  cargarRequisitosDelExpediente();
});






function cargarDatosDesdeLocalStorage() {
  const datos = JSON.parse(localStorage.getItem("expedienteMostrar"));
  if (!datos) {
    console.log("⚠ No se encontraron datos en localStorage");
    return;
  }

  // Asignación de campos...
  document.getElementById("txt_dni").value = datos.nro_documento;
  document.getElementById("txt_nomb").value = datos.nombres;
  document.getElementById("txt_ape").value = datos.apellidos;
  document.getElementById("txt_celular").value = datos.celular;
  document.getElementById("txt_telefono").value = datos.telefono;
  document.getElementById("txt_email").value = datos.email;
  document.getElementById("txt_dire").value = datos.direccion;
document.getElementById("txt_region").value = datos.REGION;
  document.getElementById("txt_provincia").value = datos.PROVINCIA;
  document.getElementById("txt_distrito").value = datos.DISTRITO;
  document.getElementById("txt_descrip").value = datos.observacion;

  document.getElementById("txt_ruc").value = datos.ruc;
  document.getElementById("txt_razon").value = datos.razon_social;
    document.getElementById("txt_servicio").value = datos.nombre;
  document.getElementById("txt_nro_expediente").value = datos.nro_expediente;
  document.getElementById("txt_folio").value = datos.folios;
  document.getElementById("precio_total").value = datos.costo;

  if (datos.representacion == "A NOMBRE PROPIO") {
    $("#rad_presentacion1").prop('checked', true);
    document.getElementById('div_juridico').style.display = "none";
  } else if (datos.representacion == "A OTRA PERSONA NATURAL") {
    $("#rad_presentacion2").prop('checked', true);
    document.getElementById('div_juridico').style.display = "none";
  } else if (datos.representacion == "PERSONA JURÍDICA") {
    $("#rad_presentacion3").prop('checked', true);
    document.getElementById('div_juridico').style.display = "block";
  } else {
    document.getElementById('div_juridico').style.display = "none";
  }

  // 👇 Pasamos los tres valores correctamente
}
</script>



<script>
document.addEventListener("DOMContentLoaded", () => {
  const datos = JSON.parse(localStorage.getItem("expedienteMostrar"));
  if (datos) {
        document.getElementById("txt_dni").value = datos.nro_documento;
        document.getElementById("txt_nomb").value = datos.nombres;
        document.getElementById("txt_ape").value = datos.apellidos;

    } else {
        console.log("No se encontraron datos en localStorage");
    }
});
</script>
