<script src="../js/console_tramite.js?rev=<?php echo time(); ?>"></script>
<link rel="stylesheet" href="../plantilla/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<input type="text" id="dni" autocomplete="off" name="dni" hidden>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>REGISTRO DEL EXPEDIENTE</b></h1>
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
                            <select class="form-control" id="select_tipo_documento" style="width:100%">
                                <option value="" disabled>Seleccione</option>
                                <option value="DNI" selected>DNI</option>
                                <option value="CARNET DE EXTRANJERIA">CARNET DE EXTRANJERIA</option>
                                <option value="PASAPORTE">PASAPORTE</option>
                            </select>
                        </div>

                        <div id="dni_section" class="col-6 form-group">
                            <label for="" style="font-size:small;">N° Documento<b style="color:red">(*)</b>:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="txt_dni">
                                <div class="input-group-append">
                                    <button onclick="" class="btn btn-primary" id="prueba"><i class="fa fa-search"></i><b> Reniec</b></button>
                                </div>
                            </div>
                        </div>
                        <div id="otros_documentos_section" class="col-6 form-group" style="display: none;">
                        <label for="" style="font-size:small;">N° Documento<b style="color:red">(*)</b>:</label>
                        <div class="input-group">
                                <input type="text" class="form-control" id="txt_dni2">
                             
                            </div>
                        </div>
                        <div class="col-6 form-group">
                            <label for="" style="font-size:small;">Nombres<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_nomb" onkeypress="return sololetras(event)">
                        </div>
                        <div class="col-6 form-group">
                            <label for="" style="font-size:small;">Apellidos<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_ape" onkeypress="return sololetras(event)">
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">Celular<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_celular" onkeypress="return soloNumeros(event)">
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">Telefono(Opcional)::</label>
                            <input type="text" class="form-control" id="txt_email">
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">Email(Opcional)::</label>
                            <input type="text" class="form-control" id="txt_email">
                        </div>
                        <div class="col-12 form-group">
                            <label for="" style="font-size:small;">Dirección(Opcional):</label>
                            <input type="text" class="form-control" id="txt_dire">
                        </div>
                        <div class="col-12 form-group">
                            <label for="" style="font-size:small;">Descripción(Opcional):</label>
                            <input type="text" class="form-control" id="txt_dire">
                        </div>
                        <div class="col-12"><br>
                            <label for="" style="font-size:small;">En Representación</label>
                        </div>
                        <div class="col-12 row">
                            <!--radio-->
                            <div class="col-4 form-group clearfix">
                                <div class="icheck-success d-inline">
                                    <input type="radio" checked value="A Nombre Propio" id="rad_presentacion1" name="r1">
                                    <label for="rad_presentacion1" style="font-weight:normal; font-size:small">
                                        <b>A Nombre Propio</b>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 form-group clearfix">
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="rad_presentacion2" name="r1" value="A Otra Persona Natural">
                                    <label for="rad_presentacion2" style="font-weight:normal; font-size:small">
                                        <b>A Otra Persona Natural</b>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 form-group clearfix">
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="rad_presentacion3" name="r1" value="Persona Jurídica">
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
                                    <input type="text" class="form-control" id="txt_ruc" onkeypress="return soloNumeros(event)">
                                </div>
                                <div class="col-8 form-group">
                                    <label for="" style="font-size:small;">Razón Social<b style="color:red">(*)</b>:</label>
                                    <input type="text" class="form-control" id="txt_razon">
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
                            <select   class="form-control" id="select_area_d" style="width:100%"></select>
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">N° Expediente<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_ndocumento" onkeypress="return soloNumeros(event)">
                        </div>
                        <div class="col-4 form-group">
                            <label for="" style="font-size:small;">N° Folios<b style="color:red">(*)</b>:</label>
                            <input type="text" class="form-control" id="txt_folio" onkeypress="return soloNumeros(event)">
                        </div>
                        <div class="col-12 form-group" style="color:red">
                            <label for="">OJO: (los documentos como requisitos deben estar en un solo archivo en formato PDF, deberá optimizar los documentos antes de enviarlos. El tamaño máximo de los archivos no debe superar los 15MB).</label>
                        </div>
                        <div class="col-12 table-responsive" style="text-align:center">
                            <table id="tabla_requisito" style="width:100%" class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Requisito</th>
                                    <th>¿se agregara al documento?</th>
                                    <th>Archivo</th>
                                    <th>Estado</th>
                                    <th>Fecha de Registro</th>
                                    <th>Acci&oacute;n</th>
                                </tr>
                                </thead>
                                <tbody id="tbody_tabla_requisito">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                                <div class="form-group clearfix">
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox"  id="checkboxSuccess1" onclick="Validar_Informacion()">
                                        <label for="checkboxSuccess1" style="align:justify">
                                            Declaro bajo penalidad de pejurio, que toda información proporcionada es correscta y veridica.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <div class="col-12" style="text-align:center">
                            <button class="btn btn-success btn-lg" onclick="Registrar_Tramite()" id="btn_registro"><i class="fas fa-save"></i><b> REGISTRAR EXPEDIENTE</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $("#rad_presentacion1").on('click', function() {
            document.getElementById('div_juridico').style.display = "none";
        });
        $("#rad_presentacion2").on('click', function() {
            document.getElementById('div_juridico').style.display = "none";
        });
        $("#rad_presentacion3").on('click', function() {
            document.getElementById('div_juridico').style.display = "block";
        });

    });

    Validar_Informacion();

    function Validar_Informacion() {
        if (document.getElementById('checkboxSuccess1').checked == false) {
            $("#btn_registro").addClass("disabled");
        } else {
            $("#btn_registro").removeClass("disabled");
        }
    }

    let precio = document.getElementById("txt_archivo")
    let cajaChecada = document.getElementById("checkboxSuccess2")

    cajaChecada.addEventListener("click", () => {
        if (precio.disabled) {
            precio.disabled = false
        } else {
            precio.disabled = true
        }
    })

    $('input[type="file"]').on('change', function() {
        var ext = $(this).val().split('.').pop();
        console.log($(this).val());
        if ($(this).val() != '') {
            if (ext == "PDF" || ext == "pdf") {
                if ($(this)[0].files[0].size > 31457280) { //----- 30 MB
                    //if($(this)[0].files[0].size> 1048576){ ------- 1 MB
                    //if($(this)[0].files[0].size> 10485760){ ------- 10 MB
                    Swal.fire("El archivo seleccionado es demasiado pesado",
                        "<label style='color:#9B0000;'>Seleccionar un archivo mas liviano</label>", "waning");
                    $("#txt_archivo").val("");
                    return;
                    //$("#btn_subir").prop("disabled",true);
                } else {
                    //$("#btn_subir").attr("disabled",false);
                }
                $("#txtformato").val(ext);
            } else {
                $("#txt_archivo").val("");
                Swal.fire("Mensaje de Error", "Extensión no permitida: " + ext,
                    "error");
            }
        }
    });
    var input = document.getElementById('txt_dni');
    input.addEventListener('input', function() {
        if (this.value.length > 8)
            this.value = this.value.slice(0, 8);
    })
    var input = document.getElementById('txt_celular');
    input.addEventListener('input', function() {
        if (this.value.length > 9)
            this.value = this.value.slice(0, 9);
    })
    var input = document.getElementById('txt_folio');
    input.addEventListener('input', function() {
        if (this.value.length > 3)
            this.value = this.value.slice(0, 3);
    })
    var checkboxes = document.querySelectorAll('input[type=checkbox]');
    var text = document.getElementById('txt_acciones');

    function checkboxClick(event) {
        var valor = '';
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                valor += checkboxes[i].value;
            }
        }
        txt_acciones.value = valor;
    }

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', checkboxClick);
    }
</script>
<script>
    // Mostrar la sección correcta al cargar la página
    window.addEventListener('DOMContentLoaded', function() {
        const selectTipoDocumento = document.getElementById('select_tipo_documento');
        const dniSection = document.getElementById('dni_section');
        const otrosDocumentosSection = document.getElementById('otros_documentos_section');

        if (selectTipoDocumento.value === 'DNI') {
            dniSection.style.display = 'block';
            otrosDocumentosSection.style.display = 'none';
        }
    });

    // Cambiar la visibilidad según la selección del usuario
    document.getElementById('select_tipo_documento').addEventListener('change', function() {
        const selectedValue = this.value;
        const dniSection = document.getElementById('dni_section');
        const otrosDocumentosSection = document.getElementById('otros_documentos_section');

        if (selectedValue === 'DNI') {
            dniSection.style.display = 'block';
            otrosDocumentosSection.style.display = 'none';
        } else if (selectedValue === 'CARNET DE EXTRANJERIA' || selectedValue === 'PASAPORTE') {
            dniSection.style.display = 'none';
            otrosDocumentosSection.style.display = 'block';
        } else {
            dniSection.style.display = 'none';
            otrosDocumentosSection.style.display = 'none';
        }
    });
    txt_dni.focus();
 $(document).ready(function(){
    $('#txt_dni').change(function(){
  valor=$(this).val();
    $('#dni').val(valor);
  })
})
    var input = document.getElementById("txt_dni");
  input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementById("prueba").click();
  }
});

$("#prueba").click(function(){

var dni=$("#dni").val();
$.ajax({           
  type:"POST",
  url: "consulta-dni-ajax.php",
  data: 'dni='+dni,
  dataType: 'json',
  success: function(data) {
      if(data==1)
      {
          alert('El DNI tiene que tener 8 digitos');
      }
      else{
          console.log(data);
        
          document.getElementById("txt_nomb").value = data.nombres
          document.getElementById("txt_ape").value = data.apellidoPaterno+' '+data.apellidoMaterno


       
      }
  }
});
})
</script>