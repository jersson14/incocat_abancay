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
          window.location.href = "formulario_seguimiento.php";
        } else {
            return Swal.fire(
                "Mensaje de Advertencia",
                "Expediente no encontrado, revise el número de documento o expediente.",
                "warning"
              );
        }
      },
      error: function () {
        return Swal.fire(
            "Mensaje de Advertencia",
            "Error en la búsqueda. Intente nuevamente.",
            "warning"
          );
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
  