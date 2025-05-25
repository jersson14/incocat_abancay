  //REGISTRAR EXPEDIENTE
//REGISTRAR EXPEDIENTE
  function Modificar_Expediente() {
    let id = document.getElementById('txt_id_cliente').value;
    let idexpe = document.getElementById('txt_id_expediente').value;
let dni = document.getElementById('txt_dni').value.trim();
    let dni2 = document.getElementById('txt_dni2').value.trim();
    let nombre = document.getElementById('txt_nomb_edi').value.trim();
    let apellido = document.getElementById('txt_ape').value.trim();
    let celular = document.getElementById('txt_celular').value.trim();
    let telefono = document.getElementById('txt_telefono').value.trim();
    let email = document.getElementById('txt_email').value.trim();
    let direc = document.getElementById('txt_dire').value.trim();
    let descrip = document.getElementById('txt_descrip').value.trim();
    let ruc = document.getElementById('txt_ruc').value.trim();
    let raz = document.getElementById('txt_razon').value.trim();
    let servi = document.getElementById('select_servicio').value;
    let nroexpe = document.getElementById('txt_nro_expediente').value.trim();
    let total = document.getElementById('precio_total').value;
    let folio = document.getElementById('txt_folio').value;
    let distri = document.getElementById('select_distrito').value;
    let idusu = document.getElementById('txtprincipalid').value;

    // Validar campos obligatorios
    if (!id ||!idexpe || !nombre || !apellido || !celular || !nroexpe || !folio || !servi || !distri) {
        return Swal.fire("Mensaje de Advertencia", "Los campos obligatorios no han sido completados", "warning");
    }

   // Validar documento según tipo
    let documentoFinal = '';
    if (tipo_doc === 'DNI') {
        if (!dni) {
            return Swal.fire("Mensaje de Advertencia", "El campo DNI es obligatorio", "warning");
        }
        documentoFinal = dni;
    } else {
        if (!dni2) {
            return Swal.fire("Mensaje de Advertencia", "El campo de documento es obligatorio", "warning");
        }
        documentoFinal = dni2;
    }

    // Obtener tipo de presentación
    let vpresentacion = '';
    let presentacion = document.getElementsByName("r1");
    for (let i = 0; i < presentacion.length; i++) {
        if (presentacion[i].checked) {
            vpresentacion = presentacion[i].value;
            break;
        }
    }

    // VALIDACIÓN NUEVA: Revisar si hay archivos en los requisitos
    let archivosCargados = false;
    $("#tabla_requisito tbody#tbody_tabla_requisito tr").each(function () {
        const checkbox = $(this).find('input[type="checkbox"]').first();
        const isChecked = checkbox.is(":checked");

        const fileInput = $(this).find('.file-input')[0];

        if (isChecked && fileInput && fileInput.files.length > 0) {
            archivosCargados = true;
            return false; // Salir del each cuando encuentra al menos uno
        }
    });

    if (!archivosCargados) {
        return Swal.fire("Mensaje de Advertencia", "Debe adjuntar al menos un archivo en los requisitos seleccionados antes de registrar el expediente.", "warning");
    }

    // Si todo está bien, registrar el expediente
    $.ajax({
        url: "../controller/expedientes/controlador_modificar_expediente.php",
        type: 'POST',
        data: {
            id: id,
            idexpe:idexpe,
            nombre: nombre,
            apellido: apellido,
            celular: celular,
            telefono: telefono,
            email: email,
            direc: direc,
            descrip: descrip,
            vpresentacion: vpresentacion,
            ruc: ruc,
            raz: raz,
            servi: servi,
            nroexpe: nroexpe,
            folio: folio,
            idusu: idusu,
            total: total,
            distri: distri
        }
    }).done(function (resp) {
        console.log("RESPUESTA DEL SERVIDOR:", resp);

        if (resp) {
        Modificar_Detalle_requisitos2(resp,documentoFinal, idusu);
            $("#contenido_principal").load("../view/expedientes/view_expedientes.php");

            Swal.fire("Mensaje de Confirmación", `Expediente modificado satisfactoriamente del cliente con el nombre: <b>${nombre} ${apellido}</b>`, "success");
            LimpiarRegistro();
        } else {
            return Swal.fire("Mensaje de Error", "No se completó la modificación", "error");
        }
    });
}



function Modificar_Detalle_requisitos2(idexpediente,dni, idusu) {
    let filas = $("#tabla_requisito tbody#tbody_tabla_requisito tr");
    if (filas.length === 0) {
        return Swal.fire({
            title: "Advertencia",
            text: "El detalle de los requisitos debe tener al menos un registro.",
            icon: "warning",
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    }

    let formData = new FormData();
    formData.append("idexpediente", idexpediente);
        formData.append("dni", dni);
    formData.append("idusu", idusu);

    let algunSeleccionado = false;
    let archivosCompletos = true;

    filas.each(function (index) {
        const checkbox = $(this).find('input[type="checkbox"]').first();
        const isChecked = checkbox.is(":checked");
        if (isChecked) algunSeleccionado = true;

        const idRequisito = $(this).find('td').eq(0).text().trim(); // o el input hidden si tienes
        const fileInput = $(this).find('.file-input')[0];
        const fecha = $(this).find('.fecha-input').val() || "";
        const estado = $(this).find('.estado-text span').text().trim();

        formData.append("requisitos[]", idRequisito);
        formData.append("fechas[]", fecha);
        formData.append("estados[]", estado);
        formData.append("seleccionados[]", isChecked ? 1 : 0);

        if (fileInput && fileInput.files.length > 0) {
            formData.append("archivos[]", fileInput.files[0]);
        } else {
            archivosCompletos = false;
            // Enviar un archivo vacío para que se actualice igual
            formData.append("archivos[]", new Blob([]), "vacio.txt");
        }
    });

    if (!algunSeleccionado) {
        return Swal.fire({
            title: "Advertencia",
            text: "Debe seleccionar al menos un requisito marcándolo con el check.",
            icon: "warning",
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    }

    if (!archivosCompletos) {
        Swal.fire({
            title: "Advertencia",
            text: "Algunos requisitos no tienen archivo. Se subirán archivos vacíos.",
            icon: "info",
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    }

    Swal.fire({
        title: 'Registrando...',
        text: 'Por favor espere mientras se guarda la información.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        url: "../controller/expedientes/controlador_modificar_detalle_requisitos.php",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (resp) {
        Swal.close();

        let response;
        try {
            response = JSON.parse(resp);
        } catch (e) {
            return Swal.fire({
                title: "Error",
                text: "Respuesta inválida del servidor",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }

        if (response.success) {
            Swal.fire({
                title: '¡Registro exitoso!',
                text: "¿Desea imprimir la boleta?",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, imprimir!',
                cancelButtonText: 'No, gracias',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = `../view/MPDF/REPORTE/ticket_seguimiento.php?id=${encodeURIComponent(idexpediente)}#zoom=100%`;
                    var newWindow = window.open(url, "TICKET DE SEGUIMIENTO", "scrollbars=NO");
                    if (newWindow) {
                        newWindow.moveTo(0, 0);
                        newWindow.resizeTo(screen.width, screen.height);
                    }
                }
                // Limpia la tabla siempre después de actualizar
                $("#tabla_requisito tbody#tbody_tabla_requisito").empty();
            });
        } else {
            Swal.fire({
                title: "Error",
                text: response.message,
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    }).fail(function () {
        Swal.close();
        Swal.fire({
            title: "Error",
            text: "Hubo un problema con la conexión, intente nuevamente.",
            icon: "error",
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    });
}
