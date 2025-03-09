var tbl_distritos;
function listar_distritos() {
    Cargar_Select_Regiones();
    Cargar_Select_Provincia(null);
  tbl_distritos = $("#tabla_distritos").DataTable({
    ordering: false,
    bLengthChange: true,
    searching: { regex: false },
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    pageLength: 10,
    destroy: true,
    pagingType: "full_numbers",
    scrollCollapse: true,
    responsive: true,
    async: false,
    processing: true,
    ajax: {
      url: "../controller/distritos/controlador_listar_distritos.php",
      type: "POST"
    },
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: "Exportar a Excel",
        filename: function() {
          return "LISTA DE DISTRITOS";
        },
        title: function() {
            return "LISTA DE DISTRITOS";
        },
        className: "btn btn-excel",
        exportOptions: {
            columns: [1, 2, 3, 4, 5,6,7] // Exportar solo hasta la columna 'estado'
        }
      },
      {
        extend: "pdfHtml5",
        text: '<i class="fas fa-file-pdf"></i> PDF',
        titleAttr: "Exportar a PDF",
        filename: function() {
            return "LISTA DE DISTRITOS";
        },
        title: function() {
            return "LISTA DE DISTRITOS";
        },
        className: "btn btn-pdf",
        exportOptions: {
          columns: [1, 2, 3, 4, 5,6,7] // Exportar solo hasta la columna 'estado'
        }
      },
      {
        extend: "print",
        text: '<i class="fa fa-print"></i> Imprimir',
        titleAttr: "Imprimir",
        title: function() {
            return "LISTA DE DISTRITOS";
        },
        className: "btn btn-print",
        exportOptions: {
            columns: [1, 2, 3, 4, 5,6,7] // Exportar solo hasta la columna 'estado'
        }
      }
    ],
    columns: [
      { defaultContent: "" },
      { data: "REGION" },
      { data: "PROVINCIA" },
      {
        data: "DISTRITO",
        render: function(data, type, row) {
          return (
            '<span style="font-weight: bold; font-size: 16px;">' +
            data +
            "</span>"
          );
        }
      },
      { data: "fecha_formateada" },
      { data: "fecha_formateada2" },
      { data: "USUARIO" },
      {
        data: "estado",
        render: function(data, type, row) {
          if (data == "ACTIVO") {
            return '<span class="badge bg-success">ACTIVO</span>';
          } else {
            return '<span class="badge bg-danger">INACTIVO</span>';
          }
        }
      },
      {
        defaultContent:
          "<button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>"
      }
    ],

    language: idioma_espanol,
    select: true
  });
  tbl_distritos.on("draw.td", function() {
    var PageInfo = $("#tabla_distritos").DataTable().page.info();
    tbl_distritos.column(0, { page: "current" }).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1 + PageInfo.start;
    });
  });
}


function listar_distritos_filtro() {
  let region = document.getElementById('select_regiones_busqueda').value;
  let provincia = document.getElementById('select_provincia_busqueda').value;

  tbl_distritos = $("#tabla_distritos").DataTable({
    ordering: false,
    bLengthChange: true,
    searching: { regex: false },
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    pageLength: 10,
    destroy: true,
    pagingType: "full_numbers",
    scrollCollapse: true,
    responsive: true,
    async: false,
    processing: true,
    ajax: {
      url: "../controller/distritos/controlador_listar_distritos_filtro.php",
      type: "POST",
      data:{
        region:region,
        provincia:provincia,
      }
    },
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: "Exportar a Excel",
        filename: function() {
          return "LISTA DE DISTRITOS";
        },
        title: function() {
            return "LISTA DE DISTRITOS";
        },
        className: "btn btn-excel",
        exportOptions: {
            columns: [1, 2, 3, 4, 5,6] // Exportar solo hasta la columna 'estado'
        }
      },
      {
        extend: "pdfHtml5",
        text: '<i class="fas fa-file-pdf"></i> PDF',
        titleAttr: "Exportar a PDF",
        filename: function() {
            return "LISTA DE DISTRITOS";
        },
        title: function() {
            return "LISTA DE DISTRITOS";
        },
        className: "btn btn-pdf",
        exportOptions: {
          columns: [1, 2, 3, 4, 5,6] // Exportar solo hasta la columna 'estado'
        }
      },
      {
        extend: "print",
        text: '<i class="fa fa-print"></i> Imprimir',
        titleAttr: "Imprimir",
        title: function() {
            return "LISTA DE DISTRITOS";
        },
        className: "btn btn-print",
        exportOptions: {
            columns: [1, 2, 3, 4, 5,6] // Exportar solo hasta la columna 'estado'
        }
      }
    ],
    columns: [
        { defaultContent: "" },
        { data: "REGION" },
        { data: "PROVINCIA" },
        {
          data: "DISTRITO",
          render: function(data, type, row) {
            return (
              '<span style="font-weight: bold; font-size: 16px;">' +
              data +
              "</span>"
            );
          }
        },
        { data: "fecha_formateada" },
        { data: "fecha_formateada2" },
        { data: "USUARIO" },
        {
          data: "estado",
          render: function(data, type, row) {
            if (data == "ACTIVO") {
              return '<span class="badge bg-success">ACTIVO</span>';
            } else {
              return '<span class="badge bg-danger">INACTIVO</span>';
            }
          }
        },
        {
          defaultContent:
            "<button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>"
        }
      ],

    language: idioma_espanol,
    select: true
  });
  tbl_distritos.on("draw.td", function() {
    var PageInfo = $("#tabla_distritos").DataTable().page.info();
    tbl_distritos.column(0, { page: "current" }).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1 + PageInfo.start;
    });
  });
}
//CARGAR REGIONES
function Cargar_Select_Regiones() {
  $.ajax({
    url: "../controller/regiones/controlador_cargar_select_regiones.php",
    type: 'POST',
  }).done(function(resp) {
    let data = JSON.parse(resp);
    let cadena = "<option value=''>Seleccionar Región</option>";
    if (data.length > 0) {
      for (let i = 0; i < data.length; i++) {
        cadena += "<option value='" + data[i][0] + "'>REGIÓN: " + data[i][1] + "</option>";
      }
    } else {
      cadena += "<option value=''>No hay obras disponibles</option>";
    }
    $('#select_region').html(cadena);
    $('#select_regiones_busqueda').html(cadena);
    $('#select_region_editar').html(cadena);

    // Inicializar Select2 después de cargar opciones
    $('#select_region').select2({
      placeholder: "Seleccionar Región",
      allowClear: true,
      width: '100%' // Asegura que use todo el ancho
    });
  });
}
// Agregar estos event listeners
$('#modal_registro').on('shown.bs.modal', function() {
  $('#select_region').select2({
    placeholder: "Seleccionar Región",
    allowClear: true,
      dropdownParent: $('#modal_registro')
  });
});

$('#modal_editar').on('shown.bs.modal', function() {
  $('#select_region_editar').select2({
      placeholder: "Seleccionar Región",
      allowClear: true,
      dropdownParent: $('#modal_editar')
  });
});

$("#tabla_distritos").on("click", ".editar", function() {
    var data = tbl_distritos.row($(this).parents("tr")).data();

    if (tbl_distritos.row(this).child.isShown()) {
        var data = tbl_distritos.row(this).data();
    }

    $("#modal_editar").modal("show");
    
    // Asignar valores a los campos del modal
    document.getElementById("txt_distrito_id").value = data.id_distritos;
    document.getElementById("txt_distrito_editar").value = data.DISTRITO;
    document.getElementById("txt_status_editar").value = data.estado;
    $("#txt_provincia, #txt_provincia_editar, #select_provincia_busqueda").trigger('change.select2');

    // Seleccionar región y cargar provincias correspondientes
    $("#select_region_editar").val(data.id_region).trigger('change');

    // Esperar a que carguen las provincias antes de seleccionar la correcta
    setTimeout(() => {
        $("#txt_provincia_editar").val(data.id_provincia).trigger('change');
    }, 500); // Ajusta el tiempo si es necesario
});

// Función para cargar las regiones en los selects
function Cargar_Select_Regiones() {
    $.ajax({
        url: "../controller/regiones/controlador_cargar_select_regiones.php",
        type: "POST",
        dataType: "json",
        beforeSend: function() {
            console.log("Cargando regiones...");
        }
    })
    .done(function(data) {
        let opciones = "<option value=''>Seleccionar Región</option>";

        if (data.length > 0) {
            data.forEach(region => {
                opciones += `<option value="${region[0]}">${region[1]}</option>`;
            });
        }

        $("#select_region, #select_regiones_busqueda, #select_region_editar").html(opciones);

        // Inicializar Select2
        $("#select_region, #select_regiones_busqueda, #select_region_editar").select2({
            placeholder: "Seleccionar Región",
            allowClear: true,
            width: "100%"
        });

        // Cargar provincias cuando se seleccione una región
        $("#select_region, #select_regiones_busqueda, #select_region_editar").on("change", function() {
            let id_region = $(this).val();
            let target = $(this).attr("id");
            Cargar_Select_Provincia(id_region, target);
        });
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error al cargar regiones:", textStatus, errorThrown);
    });
}

// Función para cargar las provincias según la región seleccionada
function Cargar_Select_Provincia(id_region, target) {
    if (!id_region) {
        $("#txt_provincia, #txt_provincia_editar, #select_provincia_busqueda").html("<option value=''>Seleccionar Provincia</option>");
        return;
    }

    $.ajax({
        url: "../controller/provincias/controlador_cargar_select_provincias.php",
        type: "POST",
        data: { id_region: id_region },
        dataType: "json",
        beforeSend: function() {
            console.log("Cargando provincias para la región ID:", id_region);
        }
    })
    .done(function(data) {
        let opciones = "<option value=''>Seleccionar Provincia</option>";

        if (data.length > 0) {
            data.forEach(provincia => {
                opciones += `<option value="${provincia[0]}">${provincia[1]}</option>`;
            });
        } else {
            opciones = "<option value=''>No hay provincias disponibles</option>";
        }

        if (target === "select_region") {
            $("#txt_provincia").html(opciones);
        } else if (target === "select_regiones_busqueda") {
            $("#select_provincia_busqueda").html(opciones);
        } else if (target === "select_region_editar") {
            $("#txt_provincia_editar").html(opciones);
        }

        // Inicializar Select2
        $("#txt_provincia, #txt_provincia_editar, #select_provincia_busqueda").select2({
            placeholder: "Seleccionar Provincia",
            allowClear: true,
            width: "100%"
        });
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error al cargar provincias:", textStatus, errorThrown);
    });
}

// Inicializar select2 dentro de los modales
$("#modal_registro").on("shown.bs.modal", function() {
    $("#txt_provincia").select2({
        placeholder: "Seleccionar Provincia",
        allowClear: true,
        dropdownParent: $("#modal_registro")
    });
});

$("#modal_editar").on("shown.bs.modal", function() {
    $("#txt_provincia_editar").select2({
        placeholder: "Seleccionar Provincia",
        allowClear: true,
        dropdownParent: $("#modal_editar")
    });
});



function AbrirRegistro() {
  $("#modal_registro").modal({ backdrop: "static", keyboard: false });
  $("#modal_registro").modal("show");
}

function Registrar_Provincia() {
  let provincia = document.getElementById("txt_provincia").value;
  let distrito = document.getElementById("txt_distrito").value;
  let esta = document.getElementById("txt_status").value;
  let idusu = document.getElementById("txtprincipalid").value;

  if (distrito.length == 0 || esta.length == 0 || idusu.length == 0|| provincia.length == 0) {
    return Swal.fire(
      "Mensaje de Advertencia",
      "Tiene campos vacios, revise los campos que faltan",
      "warning"
    );
  }
  $.ajax({
    url: "../controller/distritos/controlador_registro_distritos.php",
    type: "POST",
    data: {
      provincia: provincia,
      distrito: distrito,
      esta: esta,
      idusu: idusu
    }
  }).done(function(resp) {
    if (resp > 0) {
      if (resp == 1) {
        Swal.fire(
          "Mensaje de Confirmación",
          "Nuevo Distrito registrado con el nombre: <b>" + distrito + "</b>",
          "success"
        ).then(value => {
          tbl_distritos.ajax.reload();
          Cargar_Select_Regiones();
          Cargar_Select_Provincia(null);
          document.getElementById("txt_distrito").value = "";
          $("#modal_registro").modal("hide");
        });
      } else {
        Swal.fire(
          "Mensaje de Advertencia",
          "El distrito ingresado ya se encuentra en la base de datos, revise por favor",
          "warning"
        );
      }
    } else {
      return Swal.fire(
        "Mensaje de Error",
        "No se completo el registro",
        "error"
      );
    }
  });
}
function Modificar_Distrito() {
  let id = document.getElementById("txt_distrito_id").value;
  let provincia = document.getElementById("txt_provincia_editar").value;
  let distrito = document.getElementById("txt_distrito_editar").value;
  let esta = document.getElementById("txt_status_editar").value;
  let idusu = document.getElementById("txtprincipalid").value;

  if (distrito.length == 0 || esta.length == 0 || idusu.length == 0|| provincia.length == 0||id.length == 0) {
    return Swal.fire(
      "Mensaje de Advertencia",
      "Tiene campos vacios, revise los campos que faltan",
      "warning"
    );
  }
  $.ajax({
    url: "../controller/distritos/controlador_modificar_distrito.php",
    type: "POST",
    data: {
      id: id,
      provincia: provincia,
      distrito: distrito,
      esta: esta,
      idusu: idusu
    }
  }).done(function(resp) {
    if (resp > 0) {
      if (resp == 1) {
        Swal.fire(
          "Mensaje de Confirmación",
          "Datos actualizados del distrito con el nombre: <b>" +
          distrito +
            "</b>",
          "success"
        ).then(value => {
          tbl_distritos.ajax.reload();
          $("#modal_editar").modal("hide");
        });
      } else {
        Swal.fire(
          "Mensaje de Advertencia",
          "EL distrito ingresado ya se encuentra en la base de datos, revise por favor",
          "warning"
        );
      }
    } else {
      return Swal.fire(
        "Mensaje de Error",
        "No se completo la actualización",
        "error"
      );
    }
  });
}

function Eliminar_Distrito(id) {
  $.ajax({
    url: "../controller/distritos/controlador_eliminar_distrito.php",
    type: "POST",
    data: {
      id: id
    }
  }).done(function(resp) {
    if (resp > 0) {
      Swal.fire(
        "Mensaje de Confirmación",
        "Se elimino el distrito con éxito",
        "success"
      ).then(value => {
        tbl_distritos.ajax.reload();
      });
    } else {
      return Swal.fire(
        "Mensaje de Advetencia",
        "No se puede eliminar este distrito por que esta siendo utilizado en el módulo de registro de expedientes, verifique por favor",
        "warning"
      );
    }
  });
}

//ENVIANDO AL BOTON DELETE
$("#tabla_distritos").on("click", ".eliminar", function() {
  var data = tbl_distritos.row($(this).parents("tr")).data();

  if (tbl_distritos.row(this).child.isShown()) {
    var data = tbl_distritos.row(this).data();
  }
  Swal.fire({
    title: "Desea eliminar el distrito con el nombre: " + data.DISTRITO + "?",
    text: "Una vez aceptado la distrito sera eliminada!!!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar"
  }).then(result => {
    if (result.isConfirmed) {
        Eliminar_Distrito(data.id_distritos);
    }
  });
});

