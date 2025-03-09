var tbl_regiones;
function listar_regiones() {
  tbl_regiones = $("#tabla_regiones").DataTable({
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
      url: "../controller/regiones/controlador_listar_regiones.php",
      type: "POST"
    },
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: "Exportar a Excel",
        filename: function() {
          return "LISTA DE REGIONES";
        },
        title: function() {
          return "LISTA DE REGIONES";
        },
        className: "btn btn-excel",
        exportOptions: {
          columns: [1, 2, 3, 4, 5] // Exportar solo hasta la columna 'estado'
        }
      },
      {
        extend: "pdfHtml5",
        text: '<i class="fas fa-file-pdf"></i> PDF',
        titleAttr: "Exportar a PDF",
        filename: function() {
          return "LISTA DE REGIONES";
        },
        title: function() {
          return "LISTA DE REGIONES";
        },
        className: "btn btn-pdf",
        exportOptions: {
          columns: [1, 2, 3, 4, 5] // Exportar solo hasta la columna 'estado'
        }
      },
      {
        extend: "print",
        text: '<i class="fa fa-print"></i> Imprimir',
        titleAttr: "Imprimir",
        title: function() {
          return "LISTA DE REGIONES";
        },
        className: "btn btn-print",
        exportOptions: {
          columns: [1, 2, 3, 4, 5] // Exportar solo hasta la columna 'estado'
        }
      }
    ],
    columns: [
      { defaultContent: "" },
      {
        data: "Nombre",
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
        data: "estado_re",
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
          "<button class='mostrar btn btn-success btn-sm' title='Ver Provincias'><i class='fa fa-eye'></i> Ver Provincias</button> <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>"
      }
    ],

    language: idioma_espanol,
    select: true
  });
  tbl_regiones.on("draw.td", function() {
    var PageInfo = $("#tabla_regiones").DataTable().page.info();
    tbl_regiones.column(0, { page: "current" }).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1 + PageInfo.start;
    });
  });
}
$("#tabla_regiones").on("click", ".editar", function() {
  var data = tbl_regiones.row($(this).parents("tr")).data();

  if (tbl_regiones.row(this).child.isShown()) {
    var data = tbl_regiones.row(this).data();
  }
  $("#modal_editar").modal("show");
  document.getElementById("txt_id_region").value = data.id_region;
  document.getElementById("txt_region_editar").value = data.Nombre;
  document.getElementById("txt_status_editar").value = data.estado_re;
});

function AbrirRegistro() {
  $("#modal_registro").modal({ backdrop: "static", keyboard: false });
  $("#modal_registro").modal("show");
}

function Registrar_Region() {
  console.log("HOLA");
  let region = document.getElementById("txt_region").value;
  let esta = document.getElementById("txt_status").value;
  let idusu = document.getElementById("txtprincipalid").value;

  if (region.length == 0 || esta.length == 0 || idusu.length == 0) {
    return Swal.fire(
      "Mensaje de Advertencia",
      "Tiene campos vacios, revise los campos que faltan",
      "warning"
    );
  }
  $.ajax({
    url: "../controller/regiones/controlador_registro_region.php",
    type: "POST",
    data: {
      region: region,
      esta: esta,
      idusu: idusu
    }
  }).done(function(resp) {
    if (resp > 0) {
      if (resp == 1) {
        Swal.fire(
          "Mensaje de Confirmación",
          "Nueva Región registrada con el nombre: <b>" + region + "</b>",
          "success"
        ).then(value => {
          tbl_regiones.ajax.reload();
          document.getElementById("txt_region").value = "";
          $("#modal_registro").modal("hide");
        });
      } else {
        Swal.fire(
          "Mensaje de Advertencia",
          "La región ingresada ya se encuentra en la base de datos, revise por favor",
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
function Modificar_Region() {
  let id = document.getElementById("txt_id_region").value;
  let region = document.getElementById("txt_region_editar").value;
  let esta = document.getElementById("txt_status_editar").value;
  let idusu = document.getElementById("txtprincipalid").value;

  if (
    region.length == 0 ||
    esta.length == 0 ||
    idusu.length == 0 ||
    id.length == 0
  ) {
    return Swal.fire(
      "Mensaje de Advertencia",
      "Tiene campos vacios, revise los campos que faltan",
      "warning"
    );
  }
  $.ajax({
    url: "../controller/regiones/controlador_modificar_region.php",
    type: "POST",
    data: {
      id: id,
      region: region,
      esta: esta,
      idusu: idusu
    }
  }).done(function(resp) {
    if (resp > 0) {
      if (resp == 1) {
        Swal.fire(
          "Mensaje de Confirmación",
          "Datos actualizados de la región con el nombre: <b>" +
            region +
            "</b>",
          "success"
        ).then(value => {
          tbl_regiones.ajax.reload();
          $("#modal_editar").modal("hide");
        });
      } else {
        Swal.fire(
          "Mensaje de Advertencia",
          "La región ingresada ya se encuentra en la base de datos, revise por favor",
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

function Eliminar_Region(id) {
  $.ajax({
    url: "../controller/regiones/controlador_eliminar_region.php",
    type: "POST",
    data: {
      id: id
    }
  }).done(function(resp) {
    if (resp > 0) {
      Swal.fire(
        "Mensaje de Confirmación",
        "Se elimino la región con éxito",
        "success"
      ).then(value => {
        tbl_regiones.ajax.reload();
      });
    } else {
      return Swal.fire(
        "Mensaje de Advetencia",
        "No se puede eliminar esta región por que esta siendo utilizado en el módulo de registro de expedientes, verifique por favor",
        "warning"
      );
    }
  });
}

//ENVIANDO AL BOTON DELETE
$("#tabla_regiones").on("click", ".eliminar", function() {
  var data = tbl_regiones.row($(this).parents("tr")).data();

  if (tbl_regiones.row(this).child.isShown()) {
    var data = tbl_regiones.row(this).data();
  }
  Swal.fire({
    title: "Desea eliminar la región con el nombre: " + data.Nombre + "?",
    text: "Una vez aceptado la región sera eliminado!!!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar"
  }).then(result => {
    if (result.isConfirmed) {
      Eliminar_Region(data.id_region);
    }
  });
});

//VER DISTRITOS

//MODAL VER HISTORIAL
$("#tabla_regiones").on("click", ".mostrar", function() {
  var data = tbl_regiones.row($(this).parents("tr")).data();

  if (tbl_regiones.row(this).child.isShown()) {
    var data = tbl_regiones.row(this).data();
  }
  $("#modal_ver_provincia").modal("show");

  document.getElementById("lb_titulo_historial").innerHTML =
    "<b>REGIÓN / DEPARTAMENTO:</b> " + data.Nombre + "";
  document.getElementById("lb_titulo_historial2").innerHTML =
    "<b>ESTADO:</b> " + data.estado_re + "";

  listar_provi(data.id_region);
});
// VISTA DE HISTORIAL
var tbl_provi;
function listar_provi(id) {
  tbl_provi = $("#tabla_ver_provincia").DataTable({
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
      url: "../controller/regiones/controlador_listar_distri_region.php",
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
        filename: "LISTA_DE_PROVINCIAS",
        title: "LISTA DE PROVINCIA",
        className: "btn btn-success"
      },
      {
        extend: "pdfHtml5",
        text: '<i class="fas fa-file-pdf"></i> PDF',
        titleAttr: "Exportar a PDF",
        filename: "LISTA_DE_PROVINCIAS",
        title: "LISTA DE PROVINCIA",
        className: "btn btn-danger"
      },
      {
        extend: "print",
        text: '<i class="fa fa-print"></i> Imprimir',
        titleAttr: "Imprimir",
        title: "LISTA DE PROVINCIA",
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
