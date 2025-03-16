var tbl_reuniones;
function listar_reunión() {
//   Cargar_Select_Regiones();

  tbl_reuniones = $("#tabla_reuniones").DataTable({
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
      url: "../controller/reuniones/controlador_listar_reuniones.php",
      type: "POST"
    },
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: "Exportar a Excel",
        filename: function() {
          return "LISTA DE REUNIONES";
        },
        title: function() {
            return "LISTA DE REUNIONES";
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
            return "LISTA DE REUNIONES";
        },
        title: function() {
            return "LISTA DE REUNIONES";
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
            return "LISTA DE REUNIONES";
        },
        className: "btn btn-print",
        exportOptions: {
            columns: [1, 2, 3, 4, 5,6] // Exportar solo hasta la columna 'estado'
        }
      }
    ],
    columns: [
        { defaultContent: "" },
        { "data": "CLIENTE" },
        { "data": "descripcion" },
    
        {
            "data": "fecha_formateada",
            render: function(data, type, row) {
                return '<strong>' + data + '</strong>';
            }
        },
    
        { "data": "fecha_formateada2" },
        { "data": "USUARIO" },
    
        {
            "data": "estado",
            render: function(data, type, row) {
                if (data == 'PENDIENTE') {
                    return '<span class="badge bg-warning">PENDIENTE</span>';
                } else {
                    return '<span class="badge bg-success">REALIZADO</span>';
                }
            }
        },
        {
            "data": "estado",
            render: function(data, type, row) {
                if (data == 'PENDIENTE') {
                    return "<button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button><button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>";
                } else {
                    return "<button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button><button class='eliminar btn btn-danger btn-sm' hidden title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>";
                }
            }
        },
    
    ],
    

    language: idioma_espanol,
    select: true
  });
  tbl_reuniones.on("draw.td", function() {
    var PageInfo = $("#tabla_reuniones").DataTable().page.info();
    tbl_reuniones.column(0, { page: "current" }).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1 + PageInfo.start;
    });
  });
}


function listar_reunion_filtro() {
    let fechainicio = document.getElementById('txtfechainicio').value;
    let fechafin = document.getElementById('txtfechafin').value;

      tbl_reuniones = $("#tabla_reuniones").DataTable({
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
          url: "../controller/reuniones/controlador_listar_reuniones_fechas.php",
          type: "POST",
          data:{
            fechainicio:fechainicio,
            fechafin:fechafin,
          }
        },
        dom: "Bfrtip",
        buttons: [
            {
              extend: "excelHtml5",
              text: '<i class="fas fa-file-excel"></i> Excel',
              titleAttr: "Exportar a Excel",
              filename: function() {
                return "LISTA DE REUNIONES";
              },
              title: function() {
                  return "LISTA DE REUNIONES";
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
                  return "LISTA DE REUNIONES";
              },
              title: function() {
                  return "LISTA DE REUNIONES";
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
                  return "LISTA DE REUNIONES";
              },
              className: "btn btn-print",
              exportOptions: {
                  columns: [1, 2, 3, 4, 5,6] // Exportar solo hasta la columna 'estado'
              }
            }
          ],
          columns: [
              { defaultContent: "" },
              { "data": "CLIENTE" },
              { "data": "descripcion" },
          
              {
                  "data": "fecha_formateada",
                  render: function(data, type, row) {
                      return '<strong>' + data + '</strong>';
                  }
              },
          
              { "data": "fecha_formateada2" },
              { "data": "USUARIO" },
          
              {
                  "data": "estado",
                  render: function(data, type, row) {
                      if (data == 'PENDIENTE') {
                          return '<span class="badge bg-warning">PENDIENTE</span>';
                      } else {
                          return '<span class="badge bg-success">REALIZADO</span>';
                      }
                  }
              },
              {
                "data": "estado",
                render: function(data, type, row) {
                    if (data == 'PENDIENTE') {
                        return "<button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button><button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>";
                    } else {
                        return "<button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button><button class='eliminar btn btn-danger btn-sm' hidden title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>";
                    }
                }
            },
          ],
    
        language: idioma_espanol,
        select: true
      });
      tbl_reuniones.on("draw.td", function() {
        var PageInfo = $("#tabla_reuniones").DataTable().page.info();
        tbl_reuniones.column(0, { page: "current" }).nodes().each(function(cell, i) {
          cell.innerHTML = i + 1 + PageInfo.start;
        });
      });
    }
//CARGAR REGIONES
function Cargar_Select_Clientes() {
  $.ajax({
    url: "../controller/reuniones/controlador_cargar_select_clientes.php",
    type: 'POST',
  }).done(function(resp) {
    let data = JSON.parse(resp);
    let cadena = "<option value=''>Seleccionar Cliente</option>";
    if (data.length > 0) {
      for (let i = 0; i < data.length; i++) {
        cadena += "<option value='" + data[i][0] + "'>DNI: " + data[i][1] + "- Nombre: " + data[i][2] + "</option>";
      }
    } else {
      cadena += "<option value=''>No hay obras disponibles</option>";
    }
    $('#select_cliente').html(cadena);
    $('#select_cliente_editar').html(cadena);

    // Inicializar Select2 después de cargar opciones
    $('#select_cliente').select2({
      placeholder: "Seleccionar Cliente",
      allowClear: true,
      width: '100%' // Asegura que use todo el ancho
    });
  });
}
// Agregar estos event listeners
$('#modal_registro').on('shown.bs.modal', function() {
  $('#select_cliente').select2({
    placeholder: "Seleccionar Cliente",
    allowClear: true,
      dropdownParent: $('#modal_registro')
  });
});

$('#modal_editar').on('shown.bs.modal', function() {
  $('#select_cliente_editar').select2({
      placeholder: "Seleccionar Indicador",
      allowClear: true,
      dropdownParent: $('#modal_editar')
  });
});



$("#tabla_reuniones").on("click", ".editar", function() {
  var data = tbl_reuniones.row($(this).parents("tr")).data();

  if (tbl_reuniones.row(this).child.isShown()) {
    var data = tbl_reuniones.row(this).data();
  }
  $("#modal_editar").modal("show");

  document.getElementById("txt_id_reunion").value = data.id_reuniones;
  $("#select_cliente_editar").select2().val(data.id_cliente).trigger('change.select2');
  document.getElementById("txt_descripcion_editar").value = data.descripcion;
  document.getElementById("txt_fecha_reu_editar").value = data.fecha_reunion;

});





function AbrirRegistro() {
  $("#modal_registro").modal({ backdrop: "static", keyboard: false });
  $("#modal_registro").modal("show");
}

function Registrar_Reunion() {
    let cliente = document.getElementById("select_cliente").value;
    let descrip = document.getElementById("txt_descripcion").value;
    let fechahora = document.getElementById("txt_fecha_reu").value;
    let idusu = document.getElementById("txtprincipalid").value;
  
    if (cliente.length == 0 || descrip.length == 0 || fechahora.length == 0 || idusu.length == 0) {
      return Swal.fire(
        "Mensaje de Advertencia",
        "Tiene campos vacíos, revise los campos que faltan",
        "warning"
      );
    }
  
    // Convertir la fecha a formato DD-MM-YYYY HH:MM:SS
    let fechaObj = new Date(fechahora);
    let d = fechaObj.getDate();
    let m = fechaObj.getMonth() + 1;
    let y = fechaObj.getFullYear();
    let h = fechaObj.getHours();
    let min = fechaObj.getMinutes();
    let s = fechaObj.getSeconds();
  
    // Asegurar dos dígitos
    if (d < 10) d = '0' + d;
    if (m < 10) m = '0' + m;
    if (h < 10) h = '0' + h;
    if (min < 10) min = '0' + min;
    if (s < 10) s = '0' + s;
  
    let fechahoraFormateada = d + "-" + m + "-" + y + " " + h + ":" + min + ":" + s;
  
    $.ajax({
      url: "../controller/reuniones/controlador_registro_reunion.php",
      type: "POST",
      data: {
        cliente: cliente,
        descrip: descrip,
        fechahora: fechahora,
        idusu: idusu
      }
    }).done(function(resp) {
      if (resp > 0) {
        if (resp == 1) {
          Swal.fire(
            "Mensaje de Confirmación",
            "Nueva Reunión registrada con la fecha y hora: <b>" + fechahoraFormateada + "</b>",
            "success"
          ).then(value => {
            tbl_reuniones.ajax.reload();
            Cargar_Select_Clientes();
            document.getElementById("txt_descripcion").value = "";
            $("#modal_registro").modal("hide");
          });
        } else {
          Swal.fire(
            "Mensaje de Advertencia",
            "La reunión ingresada con el cliente y la fecha ya está en la base de datos, revise por favor",
            "warning"
          );
        }
      } else {
        return Swal.fire(
          "Mensaje de Error",
          "No se completó el registro",
          "error"
        );
      }
    });
  }
  
  function Modificar_Reunion() {
    let id = document.getElementById("txt_id_reunion").value;
    let cliente = document.getElementById("select_cliente_editar").value;
    let descrip = document.getElementById("txt_descripcion_editar").value;
    let fechahora = document.getElementById("txt_fecha_reu_editar").value;
    let idusu = document.getElementById("txtprincipalid").value;
  
    if (id.length == 0 || cliente.length == 0 || descrip.length == 0 || fechahora.length == 0 || idusu.length == 0) {
      return Swal.fire(
        "Mensaje de Advertencia",
        "Tiene campos vacíos, revise los campos que faltan",
        "warning"
      );
    }
  
    // Convertir la fecha a formato DD-MM-YYYY HH:MM:SS
    let fechaObj = new Date(fechahora);
    let d = fechaObj.getDate();
    let m = fechaObj.getMonth() + 1;
    let y = fechaObj.getFullYear();
    let h = fechaObj.getHours();
    let min = fechaObj.getMinutes();
    let s = fechaObj.getSeconds();
  
    // Asegurar dos dígitos
    if (d < 10) d = '0' + d;
    if (m < 10) m = '0' + m;
    if (h < 10) h = '0' + h;
    if (min < 10) min = '0' + min;
    if (s < 10) s = '0' + s;
  
    let fechahoraFormateada = `${d}-${m}-${y} ${h}:${min}:${s}`;
  
    $.ajax({
      url: "../controller/reuniones/controlador_modificar_reunion.php",
      type: "POST",
      data: {
        id: id,
        cliente: cliente,
        descrip: descrip,
        fechahora: fechahora,
        idusu: idusu
      }
    }).done(function(resp) {
      if (resp > 0) {
        if (resp == 1) {
          Swal.fire(
            "Mensaje de Confirmación",
            "Datos actualizados de la reunión con fecha y hora: <b>" + fechahoraFormateada + "</b>",
            "success"
          ).then(() => {
            Cargar_Select_Clientes();
            tbl_reuniones.ajax.reload();
            $("#modal_editar").modal("hide");
          });
        } else {
          Swal.fire(
            "Mensaje de Advertencia",
            "La reunión que desea modificar ya se encuentra en la base de datos, revise por favor",
            "warning"
          );
        }
      } else {
        return Swal.fire(
          "Mensaje de Error",
          "No se completó la actualización",
          "error"
        );
      }
    });
  }
  

function Eliminar_reunion(id){
    $.ajax({
      "url":"../controller/reuniones/controlador_eliminar_reunion.php",
      type:'POST',
      data:{
        id:id
      }
    }).done(function(resp){
      if(resp>0){
          Swal.fire("Mensaje de Confirmación","Se elimino la reunión con exito","success").then((value)=>{
            tbl_reuniones.ajax.reload();
  
          });
      }else{
        return Swal.fire("Mensaje de Advetencia","No se pudo eliminar esta reunión, verifique por favor","warning");
  
      }
    })
  }
  
  //ENVIANDO AL BOTON DELETE
  $('#tabla_reuniones').on('click','.eliminar',function(){
    var data = tbl_reuniones.row($(this).parents('tr')).data();
  
    if(tbl_reuniones.row(this).child.isShown()){
        var data = tbl_reuniones.row(this).data();
    }
    Swal.fire({
      title: 'Desea eliminar la reunión con la fecha: '+data.fecha_formateada+'?',
      text: "Una vez aceptado la reunión sera eliminada!!!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar'
    }).then((result) => {
      if (result.isConfirmed) {
        Eliminar_reunion(data.id_reuniones);
      }
    })
  })