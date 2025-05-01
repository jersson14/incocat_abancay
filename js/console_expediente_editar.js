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
  


