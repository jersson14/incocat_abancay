function Buscar_expediente() {
  console.log("Buscando expediente...");
  const tipo = document.querySelector('select[name="tipo_documento"]').value;
  const nro_documento = document.getElementById('txt_documento').value;
  const nro_expediente = document.getElementById('txt_expediente').value;

  if (!tipo || !nro_documento || !nro_expediente) {
      alert("Complete todos los campos.");
      return;
  }

  $.ajax({
      url: "../controller/expedientes/controlador_buscar_expediente.php",
      type: 'POST',
      data: {
          tipo_documento: tipo,
          numero_documento: nro_documento,
          numero_expediente: nro_expediente
      },
      dataType: 'JSON',
      success: function (resp) {
          if (resp && resp.status === 'ok' && resp.data) {
              const datos = resp.data;

              // Guardar datos en sessionStorage
              sessionStorage.setItem("expedienteDatos", JSON.stringify(datos));

              // ✅ Llamar a la función para cargar pagos
              cargarPagosPorExpediente(datos.id_pago);
              cargarHistorialPorExpediente(datos.id_expediente);
              // Redirigir
              window.location.href = "formulario_seguimiento.php";
          } else {
              Swal.fire(
                  "Mensaje de Advertencia",
                  "Expediente no encontrado, revise el número de documento o expediente.",
                  "warning"
              );
          }
      },
      error: function () {
          Swal.fire(
              "Mensaje de Advertencia",
              "Error en la búsqueda. Intente nuevamente.",
              "warning"
          );
      }
  });
}

function cargarPagosPorExpediente() {
  const datos = JSON.parse(sessionStorage.getItem("expedienteDatos"));
  if (!datos || !datos.id_pago) {
    console.warn("⚠️ No se encontró el ID de pago en sessionStorage.");
    Swal.fire("Error", "No se encontraron datos de pago del expediente.", "error");
    return;
  }

  const id_pago = datos.id_pago;
  console.log("🟡 Enviando ID de pago desde sessionStorage:", id_pago);

  $.ajax({
    url: "../controller/pagos/controlador_listar_pagos_expediente.php",
    type: "POST",
    data: { id_pago: id_pago },
    dataType: "json",
    success: function (resp) {
      console.log("🟢 Respuesta recibida:", resp);

      if (resp && resp.data && resp.data.length > 0) {
        const pagos = resp.data;
        console.log("✅ Datos de pagos:", pagos);

        const yaInicializada = $.fn.dataTable.isDataTable("#tabla_pagos");
        console.log("🧪 ¿DataTable ya inicializada?", yaInicializada);

        if (yaInicializada) {
          $('#tabla_pagos').DataTable().destroy();
          console.log("🔄 DataTable destruida antes de volver a inicializar.");
        }

        $('#tabla_pagos').DataTable({
          data: pagos,
          columns: [
            { data: 'monto_pagado', render: data => `S/ ${parseFloat(data).toFixed(2)}` },
            { data: 'igv', render: data => `S/ ${parseFloat(data).toFixed(2)}` },
            { data: 'monto_total', render: data => `S/ ${parseFloat(data).toFixed(2)}` },
            { data: 'fecha_formateada' },
            {
              data: 'estado',
              render: function (data) {
                return data.toUpperCase() === "VALIDO"
                  ? `<span class="badge bg-success">VALIDO</span>`
                  : `<span class="badge bg-danger">ANULADO</span>`;
              }
            }
          ],
          language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
          }
        });

        console.log("✅ DataTable inicializada correctamente.");
      } else {
        console.warn("⚠️ Sin datos: No se encontraron pagos.");
        Swal.fire("Sin datos", "No se encontraron pagos para este expediente.", "info");
      }
    },
    error: function (xhr, status, error) {
      console.error("❌ Error en AJAX:", status, error);
      Swal.fire("Error", "No se pudo cargar la tabla de pagos.", "error");
    }
  });
}

function cargarHistorialPorExpediente() {
  const datos = JSON.parse(sessionStorage.getItem("expedienteDatos"));
  if (!datos || !datos.id_expediente) {
    console.warn("⚠️ No se encontró el ID de expediente en sessionStorage.");
    Swal.fire("Error", "No se encontraron datos del expediente.", "error");
    return;
  }
  

  const id_expediente = datos.id_expediente;
  console.log("🟡 Enviando ID de expediente desde sessionStorage:", id_expediente);

  $.ajax({
    url: "../controller/expedientes/controlador_listar_historial_expediente.php",
    type: "POST",
    data: { id_expediente: id_expediente },
    dataType: "json",
    success: function (resp) {
      console.log("🟢 Respuesta recibida:", resp);

      if (resp && resp.data && resp.data.length > 0) {
        const expediente = resp.data;
        console.log("✅ Datos de expediente:", expediente);

        const yaInicializada = $.fn.dataTable.isDataTable("#tabla_documentos");
        console.log("🧪 ¿DataTable ya inicializada?", yaInicializada);

        if (yaInicializada) {
          $('#tabla_documentos').DataTable().destroy();
          console.log("🔄 DataTable destruida antes de volver a inicializar.");
        }

        $('#tabla_documentos').DataTable({
          data: expediente,
          columns: [
            { data: 'REQUISITO' },
            {
              data: 'fecha_formateada',
              render: function (data) {
                return data && data.trim() !== "" ? data : "<span class='text-muted'>SIN FECHA</span>";
              }
            },
            {
              data: 'estado',
              render: function (data) {
                return data.toUpperCase() === "NO"
                  ? `<span class="badge bg-success">SIN DOCUMENTO</span>`
                  : `<span class="badge bg-danger">PRESENTÓ</span>`;
              }
            }
          ],
          
          language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
          }
        });

        console.log("✅ DataTable inicializada correctamente.");
      } else {
        console.warn("⚠️ Sin datos: No se encontraron documentos.");
        Swal.fire("Sin datos", "No se encontraron documentos para este expediente.", "info");
      }
    },
    error: function (xhr, status, error) {
      console.error("❌ Error en AJAX:", status, error);
      Swal.fire("Error", "No se pudo cargar la tabla de documentos.", "error");
    }
  });
}

function aplicarEstadoExpediente(estado) {
    const estadoDiv = document.getElementById("estadoExpediente");
    const estadoTexto = document.getElementById("estadoTexto");
  
    // Elimina clases anteriores
    estadoDiv.classList.remove(
      "estado-en-proceso",
      "estado-en-tramite",
      "estado-observado",
      "estado-reingresado",
      "estado-finalizado"
    );
  
    let clase = '';
    let texto = '';
  
    switch (estado) {
      case 'EN PROCESO':
        clase = 'estado-en-proceso';
        texto = 'EN PROCESO';
        break;
      case 'EN TRÁMITE':
        clase = 'estado-en-tramite';
        texto = 'EN TRÁMITE';
        break;
      case 'OBSERVADO':
        clase = 'estado-observado';
        texto = 'OBSERVADO';
        break;
      case 'REINGRESADO':
        clase = 'estado-reingresado';
        texto = 'REINGRESADO';
        break;
      case 'FINALIZADO':
        clase = 'estado-finalizado';
        texto = 'FINALIZADO';
        break;
      default:
        clase = 'estado-en-proceso';
        texto = estado || 'DESCONOCIDO';
    }
  
    estadoDiv.classList.add(clase);
    estadoTexto.textContent = texto;
  }
  

  function generarReporteResumen() {
    // Obtener los valores de los campos
    var nroExpediente = document.getElementById("txt_nro_expediente").value;
    var nroDocumento = document.getElementById("txt_nro_documento").value;

    // Validación básica
    if (!nroExpediente || !nroDocumento) {
        alert("Faltan datos para generar el reporte.");
        return;
    }

    // Construir la URL al archivo PHP que genera el PDF con mPDF
    var url = "../view/MPDF/REPORTE/resumen_seguimiento.php?nro_expediente=" + 
              encodeURIComponent(nroExpediente) + 
              "&nro_documento=" + 
              encodeURIComponent(nroDocumento) + 
              "#zoom=100%";

    // Abrir nueva ventana
    var newWindow = window.open(url, "REPORTE RESUMEN", "scrollbars=NO");

    if (newWindow) {
        newWindow.moveTo(0, 0);
        newWindow.resizeTo(screen.width, screen.height);
    } else {
        alert("Por favor, habilita las ventanas emergentes para ver el reporte.");
    }
}
