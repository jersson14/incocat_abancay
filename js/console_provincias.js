var tbl_distrincias;
function listar_provincias() {
  Cargar_Select_Regiones();

  tbl_distrincias = $("#tabla_provincias").DataTable({
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
      url: "../controller/provincias/controlador_listar_provincias.php",
      type: "POST"
    },
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: "Exportar a Excel",
        filename: function() {
          return "LISTA DE PROVINCIAS";
        },
        title: function() {
            return "LISTA DE PROVINCIAS";
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
            return "LISTA DE PROVINCIAS";
        },
        title: function() {
            return "LISTA DE PROVINCIAS";
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
            return "LISTA DE PROVINCIAS";
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
      {
        data: "PROVINCIA",
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
          "<button class='mostrar btn btn-success btn-sm' title='Ver Distritos'><i class='fa fa-eye'></i> Ver Distritos</button> <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>"
      }
    ],

    language: idioma_espanol,
    select: true
  });
  tbl_distrincias.on("draw.td", function() {
    var PageInfo = $("#tabla_provincias").DataTable().page.info();
    tbl_distrincias.column(0, { page: "current" }).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1 + PageInfo.start;
    });
  });
}


function listar_provincias_filtro() {
  let region = document.getElementById('select_regiones_busqueda').value;

  tbl_distrincias = $("#tabla_provincias").DataTable({
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
      url: "../controller/provincias/controlador_listar_provincias_filtro.php",
      type: "POST",
      data:{
        region:region,

      }
    },
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: "Exportar a Excel",
        filename: function() {
          return "LISTA DE PROVINCIAS";
        },
        title: function() {
            return "LISTA DE PROVINCIAS";
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
            return "LISTA DE PROVINCIAS";
        },
        title: function() {
            return "LISTA DE PROVINCIAS";
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
            return "LISTA DE PROVINCIAS";
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
      {
        data: "PROVINCIA",
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
          "<button class='mostrar btn btn-success btn-sm' title='Ver Distritos'><i class='fa fa-eye'></i> Ver Distritos</button> <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>"
      }
    ],

    language: idioma_espanol,
    select: true
  });
  tbl_distrincias.on("draw.td", function() {
    var PageInfo = $("#tabla_provincias").DataTable().page.info();
    tbl_distrincias.column(0, { page: "current" }).nodes().each(function(cell, i) {
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




$("#tabla_provincias").on("click", ".editar", function() {
  var data = tbl_distrincias.row($(this).parents("tr")).data();

  if (tbl_distrincias.row(this).child.isShown()) {
    var data = tbl_distrincias.row(this).data();
  }
  $("#modal_editar").modal("show");
  document.getElementById("txt_provincia_id").value = data.id_provincia;
  $("#select_region_editar").select2().val(data.id_region).trigger('change.select2');
  document.getElementById("txt_provincia_editar").value = data.PROVINCIA;
  document.getElementById("txt_status_editar").value = data.estado;
});

function AbrirRegistro() {
  $("#modal_registro").modal({ backdrop: "static", keyboard: false });
  $("#modal_registro").modal("show");
}

function Registrar_Provincia() {
  console.log("HOLA");
  let region = document.getElementById("select_region").value;
  let provincia = document.getElementById("txt_provincia").value;
  let esta = document.getElementById("txt_status").value;
  let idusu = document.getElementById("txtprincipalid").value;

  if (region.length == 0 || esta.length == 0 || idusu.length == 0|| provincia.length == 0) {
    return Swal.fire(
      "Mensaje de Advertencia",
      "Tiene campos vacios, revise los campos que faltan",
      "warning"
    );
  }
  $.ajax({
    url: "../controller/provincias/controlador_registro_provincia.php",
    type: "POST",
    data: {
      region: region,
      provincia: provincia,
      esta: esta,
      idusu: idusu
    }
  }).done(function(resp) {
    if (resp > 0) {
      if (resp == 1) {
        Swal.fire(
          "Mensaje de Confirmación",
          "Nueva Provincia registrada con el nombre: <b>" + provincia + "</b>",
          "success"
        ).then(value => {
          tbl_distrincias.ajax.reload();
          Cargar_Select_Regiones();
          document.getElementById("txt_provincia").value = "";
          $("#modal_registro").modal("hide");
        });
      } else {
        Swal.fire(
          "Mensaje de Advertencia",
          "La provincia ingresada ya se encuentra en la base de datos, revise por favor",
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
function Modificar_Provincia() {
  let id = document.getElementById("txt_provincia_id").value;
  let region = document.getElementById("select_region_editar").value;
  let provincia = document.getElementById("txt_provincia_editar").value;
  let esta = document.getElementById("txt_status_editar").value;
  let idusu = document.getElementById("txtprincipalid").value;

  if (region.length == 0 || esta.length == 0 || idusu.length == 0|| provincia.length == 0||id.length == 0) {
    return Swal.fire(
      "Mensaje de Advertencia",
      "Tiene campos vacios, revise los campos que faltan",
      "warning"
    );
  }
  $.ajax({
    url: "../controller/provincias/controlador_modificar_provincia.php",
    type: "POST",
    data: {
      id: id,
      region: region,
      provincia: provincia,
      esta: esta,
      idusu: idusu
    }
  }).done(function(resp) {
    if (resp > 0) {
      if (resp == 1) {
        Swal.fire(
          "Mensaje de Confirmación",
          "Datos actualizados de la provincia con el nombre: <b>" +
          provincia +
            "</b>",
          "success"
        ).then(value => {
          tbl_distrincias.ajax.reload();
          $("#modal_editar").modal("hide");
        });
      } else {
        Swal.fire(
          "Mensaje de Advertencia",
          "La provincia ingresada ya se encuentra en la base de datos, revise por favor",
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

function Eliminar_Provincia(id) {
  $.ajax({
    url: "../controller/provincias/controlador_eliminar_provincia.php",
    type: "POST",
    data: {
      id: id
    }
  }).done(function(resp) {
    if (resp > 0) {
      Swal.fire(
        "Mensaje de Confirmación",
        "Se elimino la provincia con éxito",
        "success"
      ).then(value => {
        tbl_distrincias.ajax.reload();
      });
    } else {
      return Swal.fire(
        "Mensaje de Advetencia",
        "No se puede eliminar esta provincia por que esta siendo utilizado en el módulo de registro de expedientes, verifique por favor",
        "warning"
      );
    }
  });
}

//ENVIANDO AL BOTON DELETE
$("#tabla_provincias").on("click", ".eliminar", function() {
  var data = tbl_distrincias.row($(this).parents("tr")).data();

  if (tbl_distrincias.row(this).child.isShown()) {
    var data = tbl_distrincias.row(this).data();
  }
  Swal.fire({
    title: "Desea eliminar la provincia con el nombre: " + data.PROVINCIA + "?",
    text: "Una vez aceptado la provincia sera eliminada!!!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar"
  }).then(result => {
    if (result.isConfirmed) {
      Eliminar_Provincia(data.id_provincia);
    }
  });
});

//VER DISTRITOS

//MODAL VER HISTORIAL
$("#tabla_provincias").on("click", ".mostrar", function() {
  var data = tbl_distrincias.row($(this).parents("tr")).data();

  if (tbl_distrincias.row(this).child.isShown()) {
    var data = tbl_distrincias.row(this).data();
  }
  $("#modal_ver_distritos").modal("show");

  document.getElementById("lb_titulo_historial").innerHTML =
    "<b>PROVINCIA:</b> " + data.PROVINCIA + "";
  document.getElementById("lb_titulo_historial2").innerHTML =
    "<b>ESTADO:</b> " + data.estado + "";

  listar_distri(data.id_provincia);
});
// VISTA DE HISTORIAL
var tbl_distri;
function listar_distri(id) {
  tbl_distri = $("#tabla_ver_distritos").DataTable({
    ordering: false,
    bLengthChange: true,
    searching: false, // Deshabilita la barra de búsqueda
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
    pageLength: 10,
    destroy: true,
    pagingType: "full_numbers",
    scrollCollapse: true,
    responsive: true,
    async: false,
    processing: true,
    ajax: {
      url: "../controller/provincias/controlador_listar_distri_provincia.php",
      type: "POST",
      data: { id: id },
      dataSrc: function(json) {
        console.log("Respuesta JSON:", json);
        return json.data;
      }
    },
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: "Exportar a Excel",
        filename: "LISTA_DE_DISTRITOS",
        title: "LISTA DE DISTRITOS",
        className: "btn btn-success"
      },
      {
        extend: "pdfHtml5",
        text: '<i class="fas fa-file-pdf"></i> PDF',
        titleAttr: "Exportar a PDF",
        filename: "LISTA_DE_DISTRITOS",
        title: "LISTA DE DISTRITOS",
        className: "btn btn-danger"
      },
      {
        extend: "print",
        text: '<i class="fa fa-print"></i> Imprimir',
        titleAttr: "Imprimir",
        title: "LISTA DE DISTRITOS",
        className: "btn btn-primary"
      }
    ],
    columns: [
      {
        data: null,
        render: function(data, type, row, meta) {
          return meta.row + 1;
        }
      },
      { data: "nombre" },

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

      { data: "fecha_formateada" }
    ],
    language: {
      emptyTable: "No se encontraron datos", // ✅ Mensaje cuando la tabla está vacía
      zeroRecords: "No se encontraron resultados", // ✅ Mensaje para búsquedas sin coincidencias
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 a 0 de 0 registros",
      infoFiltered: "(filtrado de _MAX_ registros en total)",
      lengthMenu: "Mostrar _MENU_ registros",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior"
      }
    },
    select: true
  });
}
