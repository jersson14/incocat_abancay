function Cargar_Select_Servicios() {
    // Verificar primero si Select2 está disponible
    if (typeof $.fn.select2 !== 'function') {
        console.error("Select2 no está cargado aún. Reintentando en 500ms...");
        setTimeout(Cargar_Select_Servicios, 500);
        return;
    }
    
    $.ajax({
        url: "../controller/servicios/controlador_cargar_servicios.php",
        type: 'POST',
        dataType: 'json', // Esto le dice a jQuery que espere JSON
        timeout: 10000 // 10 segundos de timeout
    }).done(function(data) {
        try {
            // No necesitas JSON.parse si usas dataType:'json'
            let cadena = "<option value='' disabled selected>Seleccione Servicio</option>";
            
            if (data && data.length > 0) {
                for (let i = 0; i < data.length; i++) {
                    cadena += `<option value='${data[i][0]}' data-precio='${data[i][2]}'>${data[i][1]}</option>`;
                }
            } else {
                console.warn("No se encontraron servicios disponibles");
            }
            
            $('#select_servicio').html(cadena);
            
            // Verificar nuevamente si Select2 está disponible
            if (typeof $.fn.select2 === 'function') {
                $('#select_servicio').select2({
                    placeholder: "Seleccione Servicio",
                    allowClear: true,
                    width: '100%'
                });
            } else {
                console.error("Select2 no está disponible para inicializar el select");
            }
            
            // Configurar eventos
            configurarEventosServicio();
            
            console.log("Servicios cargados correctamente");
        } catch (e) {
            console.error("Error al procesar la respuesta:", e);
            // Reintentar después de un breve retraso
            setTimeout(Cargar_Select_Servicios, 2000);
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error al cargar los servicios:", textStatus, errorThrown);
        // Reintentar después de un breve retraso
        setTimeout(Cargar_Select_Servicios, 2000);
    });
}

// Separar los eventos en otra función para mejor organización
function configurarEventosServicio() {
    // Evento change para cargar requisitos por servicio
    $('#select_servicio').off('change').on('change', function() {
        let servicioId = $(this).val();
        
        if (servicioId) {
            // Cargar los detalles del servicio y su precio
            cargarDetalleRequisitosPorServicio(servicioId);
            
            // Obtener el precio directamente desde el <option> seleccionado
            let precioSeleccionado = $("#select_servicio option:selected").data('precio');
            
            // Actualizar el valor del input con el precio seleccionado
            $('#precio_total').val(precioSeleccionado);
        } else {
            $('#tbody_tabla_requisito').html('');
            $('#precio_total').val('0');
        }
    });
    
    // Evento para que el usuario pueda modificar el precio
    $('#precio_total').off('input').on('input', function() {
        // Asegurarse de que el valor sea un número válido
        let precioModificado = parseFloat($(this).val());
        if (!isNaN(precioModificado)) {
            // Actualiza el precio en el select
            $("#select_servicio option:selected").data('precio', precioModificado);
        }
    });
}
  function cargarDetalleRequisitosPorServicio(servicioId) {
    let tbody = $('#tbody_tabla_requisito');
    tbody.html('<tr><td colspan="6">Cargando...</td></tr>');
    $.ajax({
        url: "../controller/servicios/controlador_cargar_requisitos_por_servicio.php",
        type: 'POST',
        data: { id_servicio: servicioId }
    }).done(function(resp) {
        try {
            let data = JSON.parse(resp);
            let html = '';

            if (data.length > 0) {
                data.forEach((item, index) => {
                    html += `
                      <tr>
                        <td class="align-middle">${item.id_requisitos}</td>
                        <td class="align-middle">${item.requisito}</td>
                        <td class="text-center align-middle">
                          <input type="checkbox" class="form-check-input chk-agregar fs-4" data-index="${index}" style="width: 1.5em; height: 1.5em;">
                        </td>
                        <td class="align-middle">
                          <div class="input-group">
                            <label class="input-group-text bg-primary text-white" for="file${index}">
                              <i class="fas fa-file-upload"></i>
                            </label>
                            <input type="file" id="file${index}" accept="application/pdf" class="form-control file-input" data-index="${index}" disabled>
                          </div>
                        </td>
                        <td class="estado-text align-middle" data-index="${index}">
                          <span class="badge bg-danger">NO</span>
                        </td>
                        <td class="align-middle">${obtenerFechaHoraActual()}</td>
                        <td class="text-center align-middle">
                            <button class="btn btn-outline-danger btn-sm btn-remove" onclick='remove(this)' title="Limpiar fila" data-index="${index}" disabled>
                                <i class="fas fa-eraser"></i>
                            </button>
                        </td>
                      </tr>`;
                });
            } else {
                html = '<tr><td colspan="6" class="text-center">No hay requisitos disponibles para este servicio.</td></tr>';
            }

            tbody.html(html);

            // Evento para activar/desactivar file input y cambiar estado
            $('.chk-agregar').on('change', function () {
                const index = $(this).data('index');
                const isChecked = $(this).is(':checked');

                const fileInput = $(`.file-input[data-index="${index}"]`);
                const estadoCell = $(`.estado-text[data-index="${index}"]`);
                const btnRemove = $(`.btn-remove[data-index="${index}"]`);

                if (isChecked) {
                    fileInput.prop('disabled', false);
                    estadoCell.html('<span class="badge bg-success">SI</span>');
                    btnRemove.prop('disabled', false); // Habilitar el botón "limpiar"
                } else {
                    fileInput.prop('disabled', true);
                    estadoCell.html('<span class="badge bg-danger">NO</span>');
                    btnRemove.prop('disabled', true); // Deshabilitar el botón "limpiar"
                }
            });

            // Evento para limpiar la fila cuando se hace clic en el botón de limpieza
            $('.btn-remove').on('click', function() {
                const index = $(this).data('index');
                const fileInput = $(`.file-input[data-index="${index}"]`);
                const estadoCell = $(`.estado-text[data-index="${index}"]`);
                const chkBox = $(`.chk-agregar[data-index="${index}"]`);

                // Limpiar el checkbox, desmarcarlo
                chkBox.prop('checked', false);
                // Deshabilitar el archivo
                fileInput.prop('disabled', true);
                // Restablecer el archivo cargado (borrar archivo cargado)
                fileInput.val('');
                // Establecer el estado como "NO"
                estadoCell.html('<span class="badge bg-danger">NO</span>');
                // Deshabilitar el botón de limpieza
                $(this).prop('disabled', true);
            });

        } catch (error) {
            console.error('Error al procesar los datos:', error);
            tbody.html('<tr><td colspan="6">Error al procesar los requisitos</td></tr>');
        }
    }).fail(function(error) {
        console.error('Error al cargar los requisitos:', error);
        tbody.html('<tr><td colspan="6">Error al cargar los requisitos</td></tr>');
    });
}

  
  // Función para obtener fecha y hora actual
  function obtenerFechaHoraActual() {
    const now = new Date();
    const pad = num => num.toString().padStart(2, '0');
  
    const dia = pad(now.getDate());
    const mes = pad(now.getMonth() + 1);
    const anio = now.getFullYear();
    const horas = pad(now.getHours());
    const minutos = pad(now.getMinutes());
    const segundos = pad(now.getSeconds());
  
    return `${dia}/${mes}/${anio} ${horas}:${minutos}:${segundos}`;
  }
  
  

  function Cargar_Select_Servi() {
    $.ajax({
        url: "../controller/servicios/controlador_cargar_servicios.php",
      type: 'POST',
    }).done(function(resp) {
      let data = JSON.parse(resp);
      let cadena = "<option value=''>Seleccionar Servicio</option>";
      if (data.length > 0) {
        for (let i = 0; i < data.length; i++) {
          cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";
        }
      } else {
        cadena += "<option value=''>No hay obras disponibles</option>";
      }
      $('#select_servicios_buscar').html(cadena);
  
      // Inicializar Select2 después de cargar opciones
      $('#select_servicios_buscar').select2({
        placeholder: "Seleccionar servicio",
        allowClear: true,
        width: '100%' // Asegura que use todo el ancho
      });
    });
  }

  //LISTADO DE EXPEDIENTES
  var tbl_expedientes;
function listar_expedientes() {
  tbl_expedientes = $("#tabla_expedientes").DataTable({
    "ordering": true,
    "bLengthChange": true,
    "searching": { "regex": false },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "pageLength": 10,
    "destroy": true,
    pagingType: 'full_numbers',
    scrollCollapse: true,
    responsive: true,
    "async": false,
    "processing": true,
    "ajax": {
      "url": "../controller/expedientes/controlador_listar_expedientes.php",
      type: 'POST'
    },
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: 'Exportar a Excel',
        filename: function() {
          return "LISTA DE EXPEDIENTES";
        },
        title: function() {
            return "LISTA DE EXPEDIENTES";
        },
        className: 'btn btn-excel',
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6, 7] // Exportar solo hasta la columna 'estado'
        }
      },
      {
        extend: 'pdfHtml5',
        text: '<i class="fas fa-file-pdf"></i> PDF',
        titleAttr: 'Exportar a PDF',
        filename: function() {
            return "LISTA DE EXPEDIENTES";
        },
        title: function() {
            return "LISTA DE EXPEDIENTES";
        },
        className: 'btn btn-pdf',
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6, 7] // Exportar solo hasta la columna 'estado'
        }
      },
      {
        extend: 'print',
        text: '<i class="fa fa-print"></i> Imprimir',
        titleAttr: 'Imprimir',
        title: function() {
            return "LISTA DE EXPEDIENTES";
        },
        className: 'btn btn-print',
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6, 7] // Exportar solo hasta la columna 'estado'
        }
      }
    ],

    "columns": [
      { "data": "nro_expediente" },
      {
        "data": null,
        "render": function(data, type, row) {
          return `
            <div style="font-weight: bold; font-size: 12px;">${row.tipo_documento}</div>
            <div>${row.nro_documento}</div>
          `;
        }
      },
      
      { 
        "data": "CLIENTE",
        "render": function(data, type, row) {
          return "<strong>" + data + "</strong>";
        }
      },
      {
        "defaultContent": "<button class='ver btn btn-success btn-sm' title='Ver datos cliente'><i class='fa fa-user'></i> Ver datos cliente</button>"
      },
      { "data": "nombre" },
      { "data": "folios" },
      {
        "data": "estado",
        "render": function(data, type, row) {
          let color = '';
      
          switch (data.toUpperCase()) {
            case 'OPOSICION':
              color = 'warning'; break;
            case 'OBSERVADO':
              color = 'danger'; break;
            case 'EN PROCESO':
              color = 'info'; break;
            case 'EN TRAMITE':
              color = 'primary'; break;
            default:
              color = 'secondary';
          }
      
          return `<span class="badge bg-${color}">${data}</span>`;
        }
      },
      
      { "data": "fecha_formateada" },
      {
        "data": "tiempo_transcurrido",
        "render": function(data, type, row) {
          let dias = parseInt(data); // Asegúrate que el valor sea numérico
      
          if (isNaN(dias)) {
            return `<span class="badge bg-secondary">${data}</span>`;
          }
      
          let colorClass = "bg-dark"; // default: 1 día o menos
          if (dias >= 30) {
            colorClass = "bg-danger";
          } else if (dias >= 20) {
            colorClass = "bg-warning text-dark";
          } else if (dias >= 10) {
            colorClass = "bg-success";
          }
      
          return `<span class="badge ${colorClass}">${dias} días</span>`;
        }
      },      
      {
        "defaultContent": "<button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> <button class='cambiar btn btn-dark btn-sm' title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>"
      }
    ],

    "language": idioma_espanol,
    select: true
  });

  tbl_expedientes.on('draw.td', function() {
    var PageInfo = $("#tabla_expedientes").DataTable().page.info();
    tbl_expedientes.column(0, { page: 'current' }).nodes().each(function(cell, i) {

    });
  });
}


function listar_expedientes_filtro() {
    let fechaini = document.getElementById('txt_fecha_desde').value;
    let fechafin = document.getElementById('txt_fecha_hasta').value;
    let servicio = document.getElementById('select_servicios_buscar').value;

    tbl_expedientes = $("#tabla_expedientes").DataTable({
      "ordering": true,
      "bLengthChange": true,
      "searching": { "regex": false },
      "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
      "pageLength": 10,
      "destroy": true,
      pagingType: 'full_numbers',
      scrollCollapse: true,
      responsive: true,
      "async": false,
      "processing": true,
      "ajax": {
        "url": "../controller/expedientes/controlador_listar_expedientes_filtro.php",
        type: 'POST',
        data:{
          fechaini:fechaini,
          fechafin:fechafin,
          servicio:servicio,
        }
      },
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'excelHtml5',
          text: '<i class="fas fa-file-excel"></i> Excel',
          titleAttr: 'Exportar a Excel',
          filename: function() {
            return "LISTA DE EXPEDIENTES";
          },
          title: function() {
              return "LISTA DE EXPEDIENTES";
          },
          className: 'btn btn-excel',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7] // Exportar solo hasta la columna 'estado'
          }
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> PDF',
          titleAttr: 'Exportar a PDF',
          filename: function() {
              return "LISTA DE EXPEDIENTES";
          },
          title: function() {
              return "LISTA DE EXPEDIENTES";
          },
          className: 'btn btn-pdf',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7] // Exportar solo hasta la columna 'estado'
          }
        },
        {
          extend: 'print',
          text: '<i class="fa fa-print"></i> Imprimir',
          titleAttr: 'Imprimir',
          title: function() {
              return "LISTA DE EXPEDIENTES";
          },
          className: 'btn btn-print',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7] // Exportar solo hasta la columna 'estado'
          }
        }
      ],
  
      "columns": [
        { "data": "nro_expediente" },
        {
          "data": null,
          "render": function(data, type, row) {
            return `
              <div style="font-weight: bold; font-size: 12px;">${row.tipo_documento}</div>
              <div>${row.nro_documento}</div>
            `;
          }
        },
        
        { 
          "data": "CLIENTE",
          "render": function(data, type, row) {
            return "<strong>" + data + "</strong>";
          }
        },
        {
          "defaultContent": "<button class='ver btn btn-success btn-sm' title='Ver datos cliente'><i class='fa fa-user'></i> Ver datos cliente</button>"
        },
        { "data": "nombre" },
        { "data": "folios" },
        {
          "data": "estado",
          "render": function(data, type, row) {
            let color = '';
        
            switch (data.toUpperCase()) {
              case 'OPOSICION':
                color = 'warning'; break;
              case 'OBSERVADO':
                color = 'danger'; break;
              case 'EN PROCESO':
                color = 'info'; break;
              case 'EN TRAMITE':
                color = 'primary'; break;
              default:
                color = 'secondary';
            }
        
            return `<span class="badge bg-${color}">${data}</span>`;
          }
        },
        
        { "data": "fecha_formateada" },
        {
          "data": "tiempo_transcurrido",
          "render": function(data, type, row) {
            let dias = parseInt(data); // Asegúrate que el valor sea numérico
        
            if (isNaN(dias)) {
              return `<span class="badge bg-secondary">${data}</span>`;
            }
        
            let colorClass = "bg-dark"; // default: 1 día o menos
            if (dias >= 30) {
              colorClass = "bg-danger";
            } else if (dias >= 20) {
              colorClass = "bg-warning text-dark";
            } else if (dias >= 10) {
              colorClass = "bg-success";
            }
        
            return `<span class="badge ${colorClass}">${dias} días</span>`;
          }
        },      
        {
          "defaultContent": "<button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> <button class='cambiar btn btn-dark btn-sm' title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>"
        }
      ],
  
      "language": idioma_espanol,
      select: true
    });
  
    tbl_expedientes.on('draw.td', function() {
      var PageInfo = $("#tabla_expedientes").DataTable().page.info();
      tbl_expedientes.column(0, { page: 'current' }).nodes().each(function(cell, i) {
  
      });
    });
  }