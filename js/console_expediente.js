function Cargar_Select_Servicios() {
  // Verificar primero si Select2 está disponible
  if (typeof $.fn.select2 !== 'function') {
      console.error("Select2 no está cargado aún. Reintentando en 500ms...");
      setTimeout(Cargar_Select_Servicios, 500);
      return;
  }
  
  // Cache el elemento select para mejor rendimiento
  let $select = $('#select_servicio');
  
  $.ajax({
      url: "../controller/servicios/controlador_cargar_servicios.php",
      type: 'POST',
      dataType: 'json',
      timeout: 10000 // 10 segundos de timeout
  }).done(function(data) {
      try {
          // Opción por defecto sin placeholder pero con valor vacío
          let cadena = "<option value=''>Seleccione Servicio</option>";
          
          if (data && data.length > 0) {
              for (let i = 0; i < data.length; i++) {
                  cadena += `<option value='${data[i][0]}' data-precio='${data[i][2]}'>${data[i][1]}</option>`;
              }
          } else {
              console.warn("No se encontraron servicios disponibles");
          }
          
          // Verificar si ya está inicializado con Select2
          if ($select.hasClass("select2-hidden-accessible")) {
              // Obtener el valor actual antes de destruir Select2
              let currentValue = $select.val();
              console.log("Valor actual antes de actualizar:", currentValue);
              
              // Destruir Select2
              $select.select2("destroy");
              
              // Actualizar HTML
              $select.html(cadena);
              
              // Reinicializar Select2 con configuración específica
              $select.select2({
                  placeholder: "Seleccione Servicio",
                  allowClear: true,
                  width: '100%',
                  dropdownParent: $select.parent() // Asegura que el dropdown aparezca correctamente posicionado
              });
              
              // Si había un valor seleccionado antes, intentar restaurarlo
              if (currentValue && currentValue !== '') {
                  $select.val(currentValue).trigger('change.select2');
                  console.log("Restaurando valor previo:", currentValue);
              }
          } else {
              // Primera inicialización
              $select.html(cadena);
              
              $select.select2({
                  placeholder: "Seleccione Servicio",
                  allowClear: true,
                  width: '100%',
                  dropdownParent: $select.parent()
              });
          }
          
          // Asegurar que el cambio de valor funcione correctamente
          $select.off('change.services').on('change.services', function() {
              let selectedValue = $(this).val();
              let selectedText = $(this).find("option:selected").text();
              console.log("Servicio seleccionado:", selectedValue, selectedText);
              
              // Si el valor seleccionado es válido, asegurar que se muestre correctamente
              if (selectedValue && selectedValue !== '') {
                  // Forzar actualización visible de Select2
                  setTimeout(function() {
                      $select.trigger('change.select2');
                  }, 100);
              }
          });
          
          // Configurar eventos
          if (typeof configurarEventosServicio === 'function') {
              configurarEventosServicio();
          } else {
              console.warn("La función configurarEventosServicio no está definida");
          }
          
          console.log("Servicios cargados correctamente");
      } catch (e) {
          console.error("Error al procesar la respuesta:", e);
          setTimeout(Cargar_Select_Servicios, 2000);
      }
  }).fail(function(jqXHR, textStatus, errorThrown) {
      console.error("Error al cargar los servicios:", textStatus, errorThrown);
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
  tbody.html('<tr><td colspan="7">Cargando...</td></tr>');
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
                            <input type="file" name="archivos[]" id="file${index}" accept="application/pdf" class="form-control file-input" data-index="${index}" disabled>
                        </div>
                      </td>
                      <td class="estado-text align-middle" data-index="${index}">
                        <span class="badge bg-danger">NO</span>
                      </td>
                      <td class="align-middle">
                        <input type="text" class="form-control fecha-input" data-index="${index}" value="" disabled>
                      </td>
                      <td class="text-center align-middle">
                        <button class="btn btn-outline-danger btn-sm btn-remove" onclick='remove(this)' title="Limpiar fila" data-index="${index}" disabled>
                            <i class="fas fa-eraser"></i>
                        </button>
                      </td>
                    </tr>`;
              });
          } else {
              html = '<tr><td colspan="7" class="text-center">No hay requisitos disponibles para este servicio.</td></tr>';
          }

          tbody.html(html);

          // Evento para activar/desactivar inputs al marcar checkbox
          $('.chk-agregar').on('change', function () {
              const index = $(this).data('index');
              const isChecked = $(this).is(':checked');

              const fileInput = $(`.file-input[data-index="${index}"]`);
              const estadoCell = $(`.estado-text[data-index="${index}"]`);
              const btnRemove = $(`.btn-remove[data-index="${index}"]`);
              const fechaInput = $(`.fecha-input[data-index="${index}"]`);

              if (isChecked) {
                  fileInput.prop('disabled', false);
                  estadoCell.html('<span class="badge bg-success">SI</span>');
                  btnRemove.prop('disabled', false);
                  fechaInput.prop('disabled', false).val(obtenerFechaHoraActual());
              } else {
                  fileInput.prop('disabled', true).val('');
                  estadoCell.html('<span class="badge bg-danger">NO</span>');
                  btnRemove.prop('disabled', true);
                  fechaInput.prop('disabled', true).val('');
              }
          });

          // Evento para limpiar la fila cuando se hace clic en el botón de limpieza
          $('.btn-remove').on('click', function() {
              const index = $(this).data('index');
              const fileInput = $(`.file-input[data-index="${index}"]`);
              const estadoCell = $(`.estado-text[data-index="${index}"]`);
              const chkBox = $(`.chk-agregar[data-index="${index}"]`);
              const fechaInput = $(`.fecha-input[data-index="${index}"]`);

              chkBox.prop('checked', false);
              fileInput.prop('disabled', true).val('');
              estadoCell.html('<span class="badge bg-danger">NO</span>');
              fechaInput.prop('disabled', true).val('');
              $(this).prop('disabled', true);
          });

      } catch (error) {
          console.error('Error al procesar los datos:', error);
          tbody.html('<tr><td colspan="7">Error al procesar los requisitos</td></tr>');
      }
  }).fail(function(error) {
      console.error('Error al cargar los requisitos:', error);
      tbody.html('<tr><td colspan="7">Error al cargar los requisitos</td></tr>');
  });
}

  
  // Función para obtener fecha y hora actual
// Función para obtener fecha y hora actual en formato 'yyyy-mm-dd HH:mm:ss'
function obtenerFechaHoraActual() {
  const now = new Date();
  const pad = num => num.toString().padStart(2, '0');

  const dia = pad(now.getDate());
  const mes = pad(now.getMonth() + 1);
  const anio = now.getFullYear();
  const horas = pad(now.getHours());
  const minutos = pad(now.getMinutes());
  const segundos = pad(now.getSeconds());

  return `${anio}-${mes}-${dia} ${horas}:${minutos}:${segundos}`;
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
            case 'REINGRESADO':
              color = 'warning'; break;
            case 'OBSERVADO':
              color = 'danger'; break;
            case 'EN PROCESO':
              color = 'info'; break;
            case 'EN TRAMITE':
              color = 'primary'; break;
            default:
              color = 'success';
          }
      
          return `<span class="badge bg-${color}">${data}</span>`;
        }
      },
      {
        "defaultContent": "<button class='historial_estado btn btn-secondary btn-sm' title='Ver historial estado'><i class='fas fa-history'></i> Historial Estado</button>"
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
        "data": "estado",
        render: function(data, type, row) {
            if (data == 'REINGRESADO') {
                return  `
           
               <button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> 
               <button class='cambiar btn btn-dark btn-sm' title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> 
               <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> 
               <button class='editar btn btn-primary btn-sm' hidden title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> 
               <button class='eliminar btn btn-danger btn-sm' hidden title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>
                  `;
          } else if (data == 'OBSERVADO') {
                return ` <button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> 
               <button class='cambiar btn btn-dark btn-sm' title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> 
               <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> 
               <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> 
               <button class='eliminar btn btn-danger btn-sm' hidden title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>                   `;
          } else if (data == 'EN PROCESO') {
                return ` <button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> 
               <button class='cambiar btn btn-dark btn-sm' title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> 
               <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> 
               <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> 
               <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>                   `;
          } else if (data == 'EN TRAMITE') {
                return ` <button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> 
               <button class='cambiar btn btn-dark btn-sm' title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> 
               <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> 
               <button class='editar btn btn-primary btn-sm' hidden title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> 
               <button class='eliminar btn btn-danger btn-sm' hidden title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>                   `;
          } else {
                return ` <button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> 
               <button class='cambiar btn btn-dark btn-sm' hidden title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> 
               <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> 
               <button class='editar btn btn-primary btn-sm' hidden title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> 
               <button class='eliminar btn btn-danger btn-sm' hidden title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>                   `;
          }
        }
    },        
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
              case 'REINGRESADO':
                color = 'warning'; break;
              case 'OBSERVADO':
                color = 'danger'; break;
              case 'EN PROCESO':
                color = 'info'; break;
              case 'EN TRAMITE':
                color = 'primary'; break;
              default:
                color = 'success';
            }
        
            return `<span class="badge bg-${color}">${data}</span>`;
          }
        },
        {
          "defaultContent": "<button class='historial_estado btn btn-secondary btn-sm' title='Ver historial estado'><i class='fas fa-history'></i> Historial Estado</button>"
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
          "data": "estado",
          render: function(data, type, row) {
              if (data == 'REINGRESADO') {
                  return  `
             
                 <button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> 
                 <button class='cambiar btn btn-dark btn-sm' title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> 
                 <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> 
                 <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> 
                 <button class='eliminar btn btn-danger btn-sm' hidden title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>
                    `;
            } else if (data == 'OBSERVADO') {
                  return ` <button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> 
                 <button class='cambiar btn btn-dark btn-sm' title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> 
                 <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> 
                 <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> 
                 <button class='eliminar btn btn-danger btn-sm' hidden title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>                   `;
            } else if (data == 'EN PROCESO') {
                  return ` <button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> 
                 <button class='cambiar btn btn-dark btn-sm' title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> 
                 <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> 
                 <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> 
                 <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>                   `;
            } else if (data == 'EN TRAMITE') {
                  return ` <button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> 
                 <button class='cambiar btn btn-dark btn-sm' title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> 
                 <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> 
                 <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> 
                 <button class='eliminar btn btn-danger btn-sm' hidden title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>                   `;
            } else {
                  return ` <button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> 
                 <button class='cambiar btn btn-dark btn-sm' hidden title='Cambiar estado'> <i class='fa fa-exchange-alt'></i> Cambiar estado</button> 
                 <button class='mostrar btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button> 
                 <button class='editar btn btn-primary btn-sm' hidden title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> 
                 <button class='eliminar btn btn-danger btn-sm' hidden title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>                   `;
            }
          }
      },        
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


  //REGISTRAR EXPEDIENTE
  function Registrar_Expediente() {
    let tipo_doc = document.getElementById('select_tipo_documento').value;
    let dni = document.getElementById('txt_dni').value.trim();
    let dni2 = document.getElementById('txt_dni2').value.trim();
    let nombre = document.getElementById('txt_nomb').value.trim();
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
    if (!tipo_doc || !nombre || !apellido || !celular || !nroexpe || !folio || !servi || !distri) {
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
  
    $.ajax({
      url: "../controller/expedientes/controlador_registro_expediente.php",
      type: 'POST',
      data: {
        tipo_doc: tipo_doc,
        documentoFinal: documentoFinal,
        dni: dni,
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
        distri:distri  
      }
    }).done(function (resp) {
      console.log("RESPUESTA DEL SERVIDOR:", resp); // <--- AGREGAR ESTO

      if (resp) {
        // Si la respuesta del servidor es el ID del expediente, pasa a la siguiente función
        Registrar_Detalle_requisitos2(resp, documentoFinal, idusu); // Aquí pasamos el ID retornado por el servidor
        $("#contenido_principal").load("../view/expedientes/view_expedientes.php");
        
        Swal.fire("Mensaje de Confirmación", `Nuevo Expediente registrado satisfactoriamente del cliente con el nombre: <b>${nombre} ${apellido}</b>`, "success");
        LimpiarRegistro();
      } else {
        return Swal.fire("Mensaje de Error", "No se completó el registro", "error");
      }
    });
}

  function LimpiarRegistro(){
    Cargar_Select_Regiones();
    Cargar_Select_Provincia(null);
    Cargar_Select_Distrito(null);
    $("#txt_dni").val("");
    $("#txt_dni2").val("");
    $("#txt_nombre").val("");
    $("#txt_ape").val("");
    $("#txt_celular").val("");
    $("#txt_telefono").val("");
    $("#txt_email").val("");
    $("#txt_dire").val("");
    $("#txt_descrip").val("");
    $("#txt_ruc").val("");
    $("#txt_razon").val("");
    $("#txt_nro_expediente").val("");
    $("#txt_folio").val("");
    $("#select_servicio").trigger("change");
    $("#select_tipo_doc").trigger("change");
  
  }

  function Registrar_Detalle_requisitos2(idexpediente, dni, idusu) {
    let count = $("#tabla_requisito tbody#tbody_tabla_requisito tr").length;
    if (count === 0) {
        return Swal.fire("Mensaje de Advertencia", "El detalle de los requisitos debe tener al menos un registro", "warning");
    }

    let formData = new FormData();
    formData.append("idexpediente", idexpediente);
    formData.append("dni", dni);
    formData.append("idusu", idusu);

    $("#tabla_requisito tbody#tbody_tabla_requisito tr").each(function () {
        const idRequisito = $(this).find('td').eq(0).text().trim();
        const fileInput = $(this).find('.file-input')[0];
        const fecha = $(this).find('.fecha-input').val();
        const estado = $(this).find('.estado-text span').text().trim(); // ← AQUÍ se toma el estado

        formData.append("requisitos[]", idRequisito);
        formData.append("fechas[]", fecha ? fecha : "");
        formData.append("estados[]", estado); // ← AQUÍ lo agregas al formulario

        if (fileInput && fileInput.files.length > 0) {
            formData.append("archivos[]", fileInput.files[0]);
        } else {
            formData.append("archivos[]", new File([], ""));
        }
    });

    $.ajax({
        url: "../controller/expedientes/controlador_registrar_detalle_requisitos.php",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (resp) {
        let response = JSON.parse(resp);

        if (response.success) {
            Swal.fire("Éxito", "Requisitos registrados correctamente", "success");
            $("#tabla_requisito tbody#tbody_tabla_requisito").empty();
        } else {
            Swal.fire("Error", response.message, "error");
        }
    }).fail(function () {
        Swal.fire("Error", "Hubo un problema con la conexión, intente nuevamente", "error");
    });
}




// Función para cargar los distritos
function Cargar_Select_Regiones() {
  $.ajax({
      url: "../controller/regiones/controlador_cargar_select_regiones.php",
      type: "POST",
      dataType: "json",
      beforeSend: function () {
          console.log("Cargando regiones...");
      }
  })
  .done(function (data) {
      let opciones = "<option value=''>Seleccionar Región</option>";

      if (data.length > 0) {
          data.forEach(region => {
              // Verificamos si el valor es 1 para ponerlo como seleccionado
              const selected = region[0] === "1" ? " selected" : "";
              opciones += `<option value="${region[0]}"${selected}>${region[1]}</option>`;
          });
      }

      // Seleccionar los elementos por ID
      let $regiones = $("#select_region, #select_region_editar");
      
      // Actualizar HTML
      $regiones.html(opciones);
      
      // Si usa Select2, actualizar correctamente
      $regiones.each(function() {
          let $this = $(this);
          if ($this.hasClass("select2-hidden-accessible")) {
              $this.select2("destroy");
              $this.html(opciones);
              $this.select2({
                  placeholder: "Seleccionar Región",
                  allowClear: true,
                  width: "100%"
              });
              
              // Forzar la actualización del valor seleccionado para Select2
              $this.val("1").trigger("change");
          } else {
              // Para selects normales, establece el valor directamente
              $this.val("1");
          }
          
          // Asegurarse de que tiene la clase form-control
          if (!$this.hasClass("form-control")) {
              $this.addClass("form-control");
          }
      });

      // Cargar provincias cuando se seleccione una región
      $regiones.off("change").on("change", function () {
          let id_region = $(this).val();
          let target = $(this).attr("id");
          Cargar_Select_Provincia(id_region, target);
      });
      
      // Cargar automáticamente las provincias para la región 1 al inicializar
      Cargar_Select_Provincia("1", "select_region");
      if ($("#select_region_editar").length) {
          Cargar_Select_Provincia("1", "select_region_editar");
      }
  })
  .fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Error al cargar regiones:", textStatus, errorThrown);
      $("#select_region, #select_region_editar").html("<option value=''>Error al cargar regiones</option>");
  });
}

// Función para cargar las provincias según la región seleccionada
// Función para cargar las provincias según la región seleccionada
function Cargar_Select_Provincia(id_region, target) {
  // Determinar qué select corresponde al target
  let $select;
  
  if (target === "select_region") {
      $select = $("#txt_provincia");
  } else if (target === "select_region_editar") {
      $select = $("#txt_provincia_editar");
  } else {
      $select = $("#select_provincia_busqueda");
  }
  
  // Limpiar el select si no hay región seleccionada
  if (!id_region) {
      $select.html("<option value=''>Seleccionar Provincia</option>");
      
      // Si usa Select2, actualizar correctamente
      if ($select.hasClass("select2-hidden-accessible")) {
          $select.val("").trigger("change");
      }
      
      // También resetear el select de distritos
      $("#select_distrito").html("<option value=''>Seleccionar Distrito</option>");
      if ($("#select_distrito").hasClass("select2-hidden-accessible")) {
          $("#select_distrito").val("").trigger("change");
      }
      
      return;
  }

  // Cargar provincias
  $.ajax({
      url: "../controller/provincias/controlador_cargar_select_provincias.php",
      type: "POST",
      data: { id_region: id_region },
      dataType: "json",
      beforeSend: function () {
          console.log("Cargando provincias para la región ID:", id_region);
      }
  })
  .done(function (data) {
      // Preparar opciones
      let opciones = "<option value=''>Seleccionar Provincia</option>";
      
      if (data && data.length > 0) {
          data.forEach(provincia => {
              opciones += `<option value="${provincia[0]}">${provincia[1]}</option>`;
          });
      } else {
          console.log("No se encontraron provincias para esta región");
      }
      
      // Actualizar HTML del select
      $select.html(opciones);
      
      // Si usa Select2, actualizar correctamente
      if ($select.hasClass("select2-hidden-accessible")) {
          $select.select2("destroy");
          $select.html(opciones);
          $select.select2({
              placeholder: "Seleccionar Provincia",
              allowClear: true,
              width: "100%"
          });
      }
      
      // Asegurarse de que tiene la clase form-control
      if (!$select.hasClass("form-control")) {
          $select.addClass("form-control");
      }
      
      // Configurar evento para cargar distritos
      $select.off("change").on("change", function() {
          let id_provincia = $(this).val();
          console.log("Provincia seleccionada:", id_provincia);
          
          // Solo cargar distritos si hay un ID de provincia
          if (id_provincia) {
              Cargar_Select_Distrito(id_provincia);
          } else {
              // Limpiar el select de distritos si no hay provincia seleccionada
              $("#select_distrito").html("<option value=''>Seleccionar Distrito</option>");
              if ($("#select_distrito").hasClass("select2-hidden-accessible")) {
                  $("#select_distrito").val("").trigger("change");
              }
          }
      });
  })
  .fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Error al cargar provincias:", textStatus, errorThrown);
      $select.html("<option value=''>Error al cargar provincias</option>");
      
      // Si usa Select2, actualizar correctamente
      if ($select.hasClass("select2-hidden-accessible")) {
          $select.val("").trigger("change");
      }
  });
}



// Función para cargar los distritos según la provincia seleccionada
function Cargar_Select_Distrito(id_provincia) {
  let $select = $("#select_distrito");
  
  if (!id_provincia) {
      if ($select.hasClass("select2-hidden-accessible")) {
          $select.html("<option value=''>Seleccionar Distrito</option>");
          $select.val("").trigger("change");
      } else {
          $select.html("<option value=''>Seleccionar Distrito</option>");
      }
      return;
  }

  $.ajax({
      url: "../controller/distritos/controlador_cargar_select_distritos.php",
      type: "POST",
      data: { id_provincia: id_provincia },
      dataType: "json",
      beforeSend: function () {
          console.log("Cargando distritos para la provincia ID:", id_provincia);
      }
  })
  .done(function (response) {
      let opciones = "<option value=''>Seleccionar Distrito</option>";
      const data = response.data || [];

      if (data.length > 0) {
          data.forEach(distrito => {
              opciones += `<option value="${distrito.id_distritos}">${distrito.nombre}</option>`;
          });
      } else {
          console.log("No se encontraron distritos para esta provincia");
      }

      // Verificar si el select tiene Select2 inicializado
      let isInitialized = $select.hasClass("select2-hidden-accessible");
      
      // Si está inicializado, destruirlo primero
      if (isInitialized) {
          $select.select2("destroy");
      }
      
      // Actualizar HTML
      $select.html(opciones);
      
      // Reinicializar Select2
      $select.select2({
          placeholder: "Seleccionar Distrito",
          allowClear: true,
          width: "100%"
      });
  })
  .fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Error al cargar distritos:", textStatus, errorThrown);
      
      if ($select.hasClass("select2-hidden-accessible")) {
          $select.html("<option value=''>Error al cargar distritos</option>");
          $select.val("").trigger("change");
      } else {
          $select.html("<option value=''>Error al cargar distritos</option>");
      }
  });
}



//ELIMINAR EXPEDIENTE
function Eliminar_Expediente(id) {
  $.ajax({
    url: "../controller/expedientes/controlador_eliminar_expediente.php",
    type: "POST",
    data: {
      id: id
    }
  }).done(function(resp) {
    if (resp > 0) {
      Swal.fire(
        "Mensaje de Confirmación",
        "Se elimino el expediente con éxito",
        "success"
      ).then(value => {
        tbl_expedientes.ajax.reload();
      });
    } else {
      return Swal.fire(
        "Mensaje de Advetencia",
        "No se puede eliminar este expediente por que esta siendo utilizado en el módulo de registro de expedientes, verifique por favor",
        "warning"
      );
    }
  });
}

//ENVIANDO AL BOTON DELETE
$("#tabla_expedientes").on("click", ".eliminar", function() {
  var data = tbl_expedientes.row($(this).parents("tr")).data();

  if (tbl_expedientes.row(this).child.isShown()) {
    var data = tbl_expedientes.row(this).data();
  }
  Swal.fire({
    title: "Desea eliminar el expediente con el Nro: " + data.nro_expediente + "?",
    text: "Una vez aceptado el expediente sera eliminado, lo podras encontrar en EXPEDIENTES ARCHIVADOS!!!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar"
  }).then(result => {
    if (result.isConfirmed) {
      Eliminar_Expediente(data.id_expediente);
    }
  });
});

//LISTA DE EXPEDIENTES ARCHIVADOS
function listar_expedientes_archivados() {
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
      "url": "../controller/expedientes/controlador_listar_expedientes_archivados.php",
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
      {"data":"estado",
        render: function(data,type,row){
                if(data=='ELIMINADO'){
                return '<span class="badge bg-danger">ARCHIVADO</span>';
                }
        }   
    },
     
    {
      "defaultContent": "<button class='historial_estado btn btn-secondary btn-sm' title='Ver historial estado'><i class='fas fa-history'></i> Historial Estado</button>"
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
        "defaultContent": "<button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar definitivamente el expediente'><i class='fa fa-trash'></i> Eliminar definitivamente</button>"
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


function listar_expedientes_filtro_archivados() {
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
        "url": "../controller/expedientes/controlador_listar_expedientes_filtro_archivados.php",
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
        {"data":"estado",
          render: function(data,type,row){
                  if(data=='ELIMINADO'){
                  return '<span class="badge bg-danger">ARCHIVADO</span>';
                  }
          }   
      },
      {
        "defaultContent": "<button class='historial_estado btn btn-secondary btn-sm' title='Ver historial estado'><i class='fas fa-history'></i> Historial Estado</button>"
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
          "defaultContent": "<button class='mirar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar definitivamente el expediente'><i class='fa fa-trash'></i> Eliminar definitivamente</button>"
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

  //MOSTRAR CLIENTES
  $('#tabla_expedientes').on('click','.ver',function(){
    var data = tbl_expedientes.row($(this).parents('tr')).data();
  
    if(tbl_expedientes.row(this).child.isShown()){
        var data = tbl_expedientes.row(this).data();
    }
    $("#modal_mostrar").modal('show');
    document.getElementById('txt_idcliente_mostrar').value=data.id_cliente;
    document.getElementById('select_tipo_doc_mostrar').value=data.tipo_documento;
    document.getElementById('txt_nro_doc_mostrar').value=data.nro_documento;
    document.getElementById('txt_nombre_mostrar').value=data.nombres;
    document.getElementById('txt_apellido_mostrar').value=data.apellidos;
    document.getElementById('txt_celular_mostrar').value=data.apellidos;
    document.getElementById('txt_telefono_mostrar').value=data.telefono;
    document.getElementById('txt_direccion_mostrar').value=data.direccion;
    document.getElementById('txt_email_mostrar').value=data.email;
    document.getElementById('txt_obser_mostrar').value=data.observacion;
  })

  $('#tabla_expedientes').on('click','.cambiar',function(){
    var data = tbl_expedientes.row($(this).parents('tr')).data();
  
    if(tbl_expedientes.row(this).child.isShown()){
        var data = tbl_expedientes.row(this).data();
    }
  $("#modal_estado").modal('show');
  
    document.getElementById('lb_tituloesta').innerHTML="<b>CLIENTE:</b> "+data.CLIENTE+"";
    document.getElementById('lb_titulo2esta').innerHTML="<b>SERVICIO:</b> "+data.nombre+"";
    document.getElementById('id_estado').value=data.id_expediente;
    document.getElementById('select_estado_edit').value=data.estado;
  
  })

  function Modificar_Estado() {
    let id = document.getElementById('id_estado').value;
    let esta = document.getElementById('select_estado_edit').value;
    let motivo = document.getElementById('txt_motivo').value;
    let idusu = document.getElementById('txtprincipalid').value;

    
    if (esta=='OBSERVADO'){
      if (id.length == 0 || esta.length == 0||motivo.length == 0) {
        return Swal.fire("Mensaje de Advertencia", "Tiene campos vacíos", "warning");
    }
  }else if(esta=='FINALIZADO'){
    if (id.length == 0 || esta.length == 0) {
      return Swal.fire("Mensaje de Advertencia", "Tiene campos vacíos", "warning");
  }

  }else{
    if (id.length == 0 || esta.length == 0) {
      return Swal.fire("Mensaje de Advertencia", "Tiene campos vacíos", "warning");
  }
  }


    if (esta=='OBSERVADO'){
        estado='<b style="color:red">' + esta + '</b> '
    }else if(esta=='FINALIZADO'){
        estado='<b style="color:green">' + esta + '</b> '

    }else if(esta=='EN TRAMITE'){
      estado='<b style="color:blue">' + esta + '</b> '

  }else{
        estado='<b style="color:#dcdc00">' + esta + '</b> '

    }
    // Confirmación antes de modificar el estado
    Swal.fire({
        title: '¿Está seguro de modificar el estado del expediente?',
        html: 'El estado del expediente será actualizado al estado de: '+estado+'',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, modificar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Procede con la petición AJAX si el usuario confirma
            $.ajax({
                url: "../controller/expedientes/controlador_modificar_estado.php",
                type: 'POST',
                data: {
                    id: id,
                    esta: esta,
                    motivo: motivo,
                    idusu:idusu
                }
            }).done(function (resp) {
                if (resp > 0) {
                    Swal.fire("Mensaje de Confirmación", "Estado actualizado satisfactoriamente ", "success").then(() => {
                        tbl_expedientes.ajax.reload();
                        $("#modal_estado").modal('hide');
                    });
                } else {
                    Swal.fire("Mensaje de Error", "No se completó la actualización", "error");
                }
            });
        }
    });
}

//VER HISTORIAL DE ESTADO
$('#tabla_expedientes').on('click','.historial_estado',function(){
  var data = tbl_expedientes.row($(this).parents('tr')).data();

  if(tbl_expedientes.row(this).child.isShown()){
      var data = tbl_expedientes.row(this).data();
  }
$("#modal_ver_historial").modal('show');

  document.getElementById('lb_titulo_historial').innerHTML="<b>CLIENTE:</b> "+data.CLIENTE+"";
  document.getElementById('lb_titulo_historial2').innerHTML="<b>SERVICIO:</b> "+data.nombre+"";

  listar_historial(data.id_expediente);

})
// VISTA DE HISTORIAL
var tbl_historial;
function listar_historial(id) {
  tbl_historial = $("#tabla_ver_historial").DataTable({
      "ordering": false,
      "bLengthChange": true,
      "searching": false,  // Deshabilita la barra de búsqueda
      "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
      "pageLength": 5,
      "destroy": true,
      "pagingType": 'full_numbers',
      "scrollCollapse": true,
      "responsive": true,
      "async": false,
      "processing": true,
      "ajax": {
          "url": "../controller/expedientes/controlador_listar_historial_expedientes.php",
          "type": 'POST',
          "data": { id: id },
          "dataSrc": function(json) {
              console.log("Respuesta JSON:", json);
              return json.data;
          }
      },
      "dom": 'Bfrtip', 
      "buttons": [
        {
          extend: 'excelHtml5',
          text: '<i class="fas fa-file-excel"></i> Excel',
          titleAttr: 'Exportar a Excel',
          filename: "LISTA_DE_HISTORIAL",
          title: "LISTA DE HISTORIAL",
          className: 'btn btn-success' 
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> PDF',
          titleAttr: 'Exportar a PDF',
          filename: "LISTA_DE_HISTORIAL",
          title: "LISTA DE HISTORIAL",
          className: 'btn btn-danger'
        },
        {
          extend: 'print',
          text: '<i class="fa fa-print"></i> Imprimir',
          titleAttr: 'Imprimir',
          title: "LISTA DE HISTORIAL",
          className: 'btn btn-primary' 
        }
      ],
      "columns": [
          { "data": null, "render": function(data, type, row, meta) { return meta.row + 1; } }, 
          { "data": "USUARIO" },
          
          {
            "data": "estado",
            render: function(data, type, row) {
                if (data == 'REINGRESADO') {
                    return '<span class="badge bg-warning">REINGRESADO</span>';
                }else if (data == 'FINALIZADO') 
                  {
                  return '<span class="badge bg-success">FINALIZADO</span>';
                } 
              else if (data == 'EN TRAMITE') 
                {
                    return '<span class="badge bg-primary">EN TRAMITE</span>';
                } 
              
                else 
                {
                  return '<span class="badge bg-danger">ARCHIVADA</span>';

                }
            }
        },        
        { "data": "motivo" },

          { "data": "fecha_formateada" }
      ],
      "language": {
          "emptyTable": "No se encontraron datos", // ✅ Mensaje cuando la tabla está vacía
          "zeroRecords": "No se encontraron resultados", // ✅ Mensaje para búsquedas sin coincidencias
          "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
          "infoEmpty": "Mostrando 0 a 0 de 0 registros",
          "infoFiltered": "(filtrado de _MAX_ registros en total)",
          "lengthMenu": "Mostrar _MENU_ registros",
          "loadingRecords": "Cargando...",
          "processing": "Procesando...",
          "search": "Buscar:",
          "paginate": {
              "first": "Primero",
              "last": "Último",
              "next": "Siguiente",
              "previous": "Anterior"
          }
      },
      "select": true
  });
}


//VER HISTORIAL DE ESTADO
$('#tabla_expedientes').on('click','.mostrar',function(){
  var data = tbl_expedientes.row($(this).parents('tr')).data();

  if(tbl_expedientes.row(this).child.isShown()){
      var data = tbl_expedientes.row(this).data();
  }
$("#modal_ver_requisitos").modal('show');

  document.getElementById('lb_titulo_historial_requi').innerHTML="<b>CLIENTE:</b> "+data.CLIENTE+"";
  document.getElementById('lb_titulo_historial2_requi').innerHTML="<b>SERVICIO:</b> "+data.nombre+"";

  listar_requi(data.id_expediente);

})
// VISTA DE REQUISITOS DE EXPEDIENTE
var tbl_requisitos;
function listar_requi(id) {
  tbl_requisitos = $("#tabla_ver_requi").DataTable({
      "ordering": false,
      "bLengthChange": true,
      "searching": false,  // Deshabilita la barra de búsqueda
      "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
      "pageLength": 5,
      "destroy": true,
      "pagingType": 'full_numbers',
      "scrollCollapse": true,
      "responsive": true,
      "async": false,
      "processing": true,
      "ajax": {
          "url": "../controller/expedientes/controlador_listar_requisitos_expedientes.php",
          "type": 'POST',
          "data": { id: id },
          "dataSrc": function(json) {
              console.log("Respuesta JSON:", json);
              return json.data;
          }
      },
      "dom": 'Bfrtip', 
      "buttons": [
        {
          extend: 'excelHtml5',
          text: '<i class="fas fa-file-excel"></i> Excel',
          titleAttr: 'Exportar a Excel',
          filename: "LISTA_DE_REQUISITOS",
          title: "LISTA DE REQUISITOS",
          className: 'btn btn-success' 
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> PDF',
          titleAttr: 'Exportar a PDF',
          filename: "LISTA_DE_REQUISITOS",
          title: "LISTA DE REQUISITOS",
          className: 'btn btn-danger'
        },
        {
          extend: 'print',
          text: '<i class="fa fa-print"></i> Imprimir',
          titleAttr: 'Imprimir',
          title: "LISTA DE REQUISITOS",
          className: 'btn btn-primary' 
        }
      ],
     "columns": [
  { 
    "data": null, 
    "render": function(data, type, row, meta) { 
      return meta.row + 1; 
    } 
  }, 
  {
    "data": "REQUISITO",
    "render": function (data, type, row) {
      return `<strong>${data}</strong>`;
    }
  },
  {
    "data": "archivo",
    "render": function(data, type, row) {
      if (!data) {
        return "<button class='btn btn-danger btn-sm' disabled title='Sin archivo'><i class='fa fa-file-pdf'></i></button>";
      } else {
        return `<a class='btn btn-success btn-sm' href='incocat_abancay/${data}' target='_blank' title='Ver archivo adjunto'><i class='fas fa-eye'></i> Ver archivo</a>`;
      }
    }   
  },
  {
    "data": "estado",
    "render": function(data, type, row) {
      if (data == 'SI') {
        return '<span class="badge bg-success">COMPLETO</span>';
      } else if (data == 'NO' || data == '') {
        return '<span class="badge bg-danger">INCOMPLETO</span>';
      }
    }
  },
  {
    "data": "fecha_formateada",
    "render": function(data, type, row) {
      if (!data || data === '00-00-0000 - 00:00:00') {
        return 'SIN FECHA';
      }
      return data;
    }
  },
  {
    "data": "fecha_formateada2",
    "render": function(data, type, row) {
      if (!data || data === '00-00-0000 - 00:00:00') {
        return 'SIN FECHA';
      }
      return data;
    }
  }
],

      "language": {
          "emptyTable": "No se encontraron datos", // ✅ Mensaje cuando la tabla está vacía
          "zeroRecords": "No se encontraron resultados", // ✅ Mensaje para búsquedas sin coincidencias
          "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
          "infoEmpty": "Mostrando 0 a 0 de 0 registros",
          "infoFiltered": "(filtrado de _MAX_ registros en total)",
          "lengthMenu": "Mostrar _MENU_ registros",
          "loadingRecords": "Cargando...",
          "processing": "Procesando...",
          "search": "Buscar:",
          "paginate": {
              "first": "Primero",
              "last": "Último",
              "next": "Siguiente",
              "previous": "Anterior"
          }
      },
      "select": true
  });
}
