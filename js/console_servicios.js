var tbl_servicios;
function listar_servicios() {
  tbl_servicios = $("#tabla_servicios").DataTable({
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
      "url": "../controller/servicios/controlador_listar_servicios.php",
      type: 'POST'
    },
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: 'Exportar a Excel',
        filename: function() {
          return "LISTA DE SERVICIOS";
        },
        title: function() {
          return "LISTA DE SERVICIOS";
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
          return "LISTA DE SERVICIOS";
        },
        title: function() {
          return "LISTA DE SERVICIOS";
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
          return "LISTA DE SERVICIOS";
        },
        className: 'btn btn-print',
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6, 7] // Exportar solo hasta la columna 'estado'
        }
      }
    ],

    "columns": [
      { "defaultContent": "" },
      { "data": "nombre" },
      { 
        "data": "costo",
        "render": function(data, type, row) {
          return "<strong>S/. " + data + "</strong>";
        }
      },
      {
        "defaultContent": "<button class='ver btn btn-warning btn-sm' title='Ver requisitos'><i class='fa fa-eye'></i> Ver requisitos</button>"
      },
  
      { "data": "fecha_formateada" },
      { "data": "fecha_formateada2" },
      { "data": "USUARIO" },
      {
        "data": "estado_ser",
        "render": function(data, type, row) {
          if (data == 'ACTIVO') {
            return '<span class="badge bg-success">ACTIVO</span>';
          } else {
            return '<span class="badge bg-danger">INACTIVO</span>';
          }
        }
      },
      {
        "defaultContent": "<button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>"
      }
    ],

    "language": idioma_espanol,
    select: true
  });

  tbl_servicios.on('draw.td', function() {
    var PageInfo = $("#tabla_servicios").DataTable().page.info();
    tbl_servicios.column(0, { page: 'current' }).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1 + PageInfo.start;
    });
  });
}

$('#tabla_servicios').on('click','.editar',function(){
  var data = tbl_servicios.row($(this).parents('tr')).data();

  if(tbl_servicios.row(this).child.isShown()){
      var data = tbl_servicios.row(this).data();
  }
  $("#modal_editar").modal('show');
  document.getElementById('txt_idservicio').value=data.id_servicios;
  document.getElementById('txt_servicio_editar').value=data.nombre;
  document.getElementById('txt_costo_editar').value=data.costo;
  document.getElementById('txt_descripcion_editar').value=data.descripcion;
  document.getElementById('select_status_editar').value=data.estado_ser;

  listar_detalle_requisitos(data.id_servicios);

})

var tbl_traer_datos;
function listar_detalle_requisitos(id) {

  tbl_traer_datos = $("#tabla_requisito_editar").DataTable({
    "ordering": false,
    "bLengthChange": false,
    "searching": false,
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "pageLength": 10,
    "destroy": true,
    "pagingType": 'full_numbers',
    "scrollCollapse": false,
    "responsive": true,
    "processing": true,
   "ajax": {
    "url": "../controller/servicios/controlador_listar_detalle_requisitos.php",
    "type": 'POST',
    "data": { id: id },
   
    },
    "columns": [
      { "data": "id_requisitos", "visible": false }, // Hace que la columna sea invisible

      {"data": "requisito"},
      {"defaultContent": "<button class='delete btn btn-danger btn-sm' title='Eliminar datos de especialidad'><i class='fa fa-trash'></i> Eliminar</button>"}
    ],
    "language": idioma_espanol,
    "select": true
  });
}

function Eliminar_detalle_requisito(id){
  $.ajax({
    "url":"../controller/servicios/controlador_eliminar_detalle_requisito.php",
    type:'POST',
    data:{
      id:id
    }
  }).done(function(resp){
    if(resp>0){
        Swal.fire("Mensaje de Confirmación","Se elimino el requisito exitosamente","success").then((value)=>{
          tbl_traer_datos.ajax.reload();

        });
    }else{
      return Swal.fire("Mensaje de Advetencia","No se puede eliminar este requisito por que esta siendo utilizado en otros formularios, verifique por favor","warning");

    }
  })
}

//ENVIANDO AL BOTON DELETE
$('#tabla_requisito_editar').on('click','.delete',function(){
  var data = tbl_traer_datos.row($(this).parents('tr')).data();

  if(tbl_traer_datos.row(this).child.isShown()){
      var data = tbl_traer_datos.row(this).data();
  }
  Swal.fire({
    title: 'Desea eliminar el requisito con el nombre: '+data.requisito+' seleccionado?',
    text: "Una vez aceptado el requisito sera eliminada!!!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar'
  }).then((result) => {
    if (result.isConfirmed) {
      Eliminar_detalle_requisito(data.id_requisitos);
    }
  })
})

function AbrirRegistro(){
  $("#modal_registro").modal({backdrop:'static',keyboard:false})
  $("#modal_registro").modal('show');
}

function Registrar_Servicio(){
  let serv = document.getElementById('txt_servicio').value;
  let costo = document.getElementById('txt_costo').value;
  let descripcion = document.getElementById('txt_descripcion').value;
  let idusu = document.getElementById('txtprincipalid').value;

  if(serv.length==0||costo.length==0){
      return Swal.fire("Mensaje de Advertencia","Los campos obligatorios no han sido completados","warning");
  }
  $.ajax({
    "url":"../controller/servicios/controlador_registro_servicios.php",
    type:'POST',
    data:{
      serv:serv,
      costo:costo,
      descripcion:descripcion,
      idusu:idusu
    }
  }).done(function(resp){
    if(resp>0){
      Registrar_Detalle_requisitos(parseInt(resp));
        Swal.fire("Mensaje de Confirmación","Nuevo Servicio registrada con el nombre: <b>"+serv+"</b>","success").then((value)=>{
          tbl_servicios.ajax.reload();
          document.getElementById('txt_servicio').value="";
          document.getElementById('txt_costo').value="";
          document.getElementById('txt_requisitos').value="";
          document.getElementById('txt_descripcion').value="";
        $("#modal_registro").modal('hide');
        });
     
    }else{
      return Swal.fire("Mensaje de Error","No se completo el registro","error");

    }
  })
}

//DETALLE DE REQUISITOS
function Agregar_requisito() {
  var requisito = $("#txt_requisitos").val().trim(); // Se obtiene correctamente el texto

  if (!requisito) {
    return Swal.fire("Mensaje de Advertencia", "Ingrese el requisito", "warning");
  }

  if (verificarid(requisito)) {
    return Swal.fire("Mensaje de Advertencia", "El requisito ya fue agregado a la tabla", "warning");
  }

  var datos_agregar = `
    <tr>
      <td for="id">${requisito}</td>
      <td><button class='btn btn-danger' onclick='remove(this)'><i class='fas fa-trash'></i></button></td>
    </tr>`;

  $("#tbody_tabla_requisito").append(datos_agregar); // Agrega a tbody
  $("#txt_requisitos").val(""); // Limpia el campo después de agregar
}

// BORRAR REGISTRO
function remove(t) {
  $(t).closest("tr").remove();
}


//GUARDAR REQUISITOS
function Registrar_Detalle_requisitos(id) {
  let count = $("#tabla_requisito tbody#tbody_tabla_requisito tr").length;
  if (count === 0) {
      return Swal.fire("Mensaje de Advertencia", "El detalle de los requisitos debe tener al menos un registro", "warning");
  }

  let arreglo_requisito = [];


  $("#tabla_requisito tbody#tbody_tabla_requisito tr").each(function () {
    arreglo_requisito.push($(this).find('td').eq(0).text().trim());

  });

  let requisito = arreglo_requisito.join(",");

  $.ajax({
      url: "../controller/servicios/controlador_detalle_requisitos.php",
      type: 'POST',
      data: {
        id: id,
        requisito: requisito,
      }
  }).done(function (resp) {
      if (resp > 0) {
          tbl_paciente_practica.ajax.reload();
          $("#modal_registro").modal('hide');

          // Limpia la tabla después de registrar
          $("#tabla_requisito tbody#tbody_tabla_requisito").empty();
          
        } else {
          return Swal.fire("Mensaje De Advertencia", "Lo sentimos, no se pudo completar el registro", "warning");
      }
  });
}


// VALIDACIÓN
function verificarid(id) {
  let existe = $("#tbody_tabla_requisito td[for='id']").filter(function () {
    return $(this).text() === id;
  }).length > 0;
  
  return existe;
}


function Modificar_Servicio(){
  let id = document.getElementById('txt_idservicio').value;
  let serv = document.getElementById('txt_servicio_editar').value;
  let costo = document.getElementById('txt_costo_editar').value;
  let descripcion = document.getElementById('txt_descripcion_editar').value;
  let esta = document.getElementById('select_status_editar').value;
  let idusu = document.getElementById('txtprincipalid').value;

  if(serv.length==0||costo.length==0||id.length==0||esta.length==0){
    return Swal.fire("Mensaje de Advertencia","Tiene campos vacios, revise los campos que faltan","warning");
  }
  $.ajax({
    "url":"../controller/servicios/controlador_modificar_servicios.php",
    type:'POST',
    data:{
      id:id,
      serv:serv,
      costo:costo,
      descripcion:descripcion,
      esta:esta,
      idusu:idusu,
    }
  }).done(function(resp){
    if(resp>0){
      if(resp==1){
      Modificar_Detalle_requisitos(id);
        Swal.fire("Mensaje de Confirmación","Datos actualizados del servicio de: <b>"+serv+"</b>","success").then((value)=>{
          tbl_servicios.ajax.reload();
        $("#modal_editar").modal('hide');
        });
      }else{
        Swal.fire("Mensaje de Advertencia","El servicio que estas ingresado ya se encuentra en la base de datos, revise por favor, no se puede insertar un DNI repetido","warning");
      }
    }else{
      return Swal.fire("Mensaje de Error","No se completo la actualización","error");

    }
  })
}

function Modificar_Detalle_requisitos(id) {
  let count = $("#tabla_requisito_editar tbody#tbody_tabla_requisito_editar tr").length;
  if (count === 0) {
      return Swal.fire("Mensaje de Advertencia", "El detalle de los requisitos debe tener al menos un registro", "warning");
  }

  let arreglo_requisito = [];


  $("#tabla_requisito_editar tbody#tbody_tabla_requisito_editar tr").each(function () {
    arreglo_requisito.push($(this).find('td').eq(0).text().trim());

  });

  let requisito = arreglo_requisito.join(",");

  $.ajax({
      url: "../controller/servicios/controlador_modificar_detalle_requisitos.php",
      type: 'POST',
      data: {
        id: id,
        requisito: requisito,
      }
  }).done(function (resp) {
      if (resp > 0) {
          tbl_paciente_practica.ajax.reload();
          $("#modal_editar").modal('hide');

          // Limpia la tabla después de registrar
          $("#tabla_requisito_editar tbody#tbody_tabla_requisito_editar").empty();
          
        } else {
          return Swal.fire("Mensaje De Advertencia", "Lo sentimos, no se pudo completar el registro", "warning");
      }
  });
}


//ELIMINAR AREAS
function Eliminar_servicio(id){
  $.ajax({
    "url":"../controller/servicios/controlador_eliminar_servicio.php",
    type:'POST',
    data:{
      id:id
    }
  }).done(function(resp){
    if(resp>0){
        Swal.fire("Mensaje de Confirmación","Se elimino el servicio con exito","success").then((value)=>{
          tbl_servicios.ajax.reload();

        });
    }else{
      return Swal.fire("Mensaje de Advetencia","No se puede eliminar este servicio por que esta siendo utilizado en el módulo de expedientes, verifique por favor","warning");

    }
  })
}

//ENVIANDO AL BOTON DELETE
$('#tabla_servicios').on('click','.eliminar',function(){
  var data = tbl_servicios.row($(this).parents('tr')).data();

  if(tbl_servicios.row(this).child.isShown()){
      var data = tbl_servicios.row(this).data();
  }
  Swal.fire({
    title: 'Desea eliminar el servicio con el nombre: '+data.nombre+'?',
    text: "Una vez aceptado el servicio sera eliminado!!!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar'
  }).then((result) => {
    if (result.isConfirmed) {
      Eliminar_servicio(data.id_servicios);
    }
  })
})

//VER REQUISITOS
//MODAL VER PRÁCTICAS
$('#tabla_servicios').on('click','.ver',function(){
  var data = tbl_servicios.row($(this).parents('tr')).data();

  if(tbl_servicios.row(this).child.isShown()){
      var data = tbl_servicios.row(this).data();
  }
$("#modal_ver_requisitos").modal('show');

  document.getElementById('lb_titulo').innerHTML="<b>SERVICIO:</b> "+data.nombre+"";
  document.getElementById('lb_titulo2').innerHTML="<b>COSTO:</b> S/. "+data.costo+"";

  listar_requisitos(data.id_servicios);

})

var tbl_requi;
function listar_requisitos(id) {
  tbl_requi = $("#tabla_ver_requisitos").DataTable({
      "ordering": false,
      "bLengthChange": true,
      "searching": false,
      "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
      "pageLength": 5,
      "destroy": true,
      "pagingType": 'full_numbers',
      "scrollCollapse": true,
      "responsive": true,
      "async": false,
      "processing": true,
      "ajax": {
          "url": "../controller/servicios/controlador_listar_detalle_requisitos.php",
          "type": "POST",
          "data": { id: id },
          "dataSrc": function(json) {
            console.log("Respuesta JSON:", json);
            
            // Asegurar que si no hay datos, devuelva un array vacío
            if (!json.data || json.data.length === 0) {
                return [];
            }
            return json.data;
        }
      },
      "dom": 'Bfrtip',
      "buttons": [
          {
              extend: 'excelHtml5',
              text: '<i class="fas fa-file-excel"></i> Excel',
              titleAttr: 'Exportar a Excel',
              filename: "LISTA DE REQUISITOS",
              title: "LISTA DE REQUISITOS",
              className: 'btn btn-success'
          },
          {
              extend: 'pdfHtml5',
              text: '<i class="fas fa-file-pdf"></i> PDF',
              titleAttr: 'Exportar a PDF',
              filename: "LISTA DE REQUISITOS",
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
                  return meta.row + 1; // Genera números correlativos
              } 
          },
          { "data": "requisito" },
          { "data": "fecha_formateada" }
      ],
      "language": {
          "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/Spanish.json",
          "emptyTable": "No se encontraron datos"
      },
      "select": true
  });
}


//EDITAR REQUISITOS

function Agregar_requisito_editar() {
  var requisito = $("#txt_requisitos_editar").val().trim(); // Se obtiene correctamente el texto

  if (!requisito) {
    return Swal.fire("Mensaje de Advertencia", "Ingrese el requisito", "warning");
  }

  if (verificarid_editar(requisito)) {
    return Swal.fire("Mensaje de Advertencia", "El requisito ya fue agregado a la tabla", "warning");
  }

  var datos_agregar = `
    <tr>
      <td for="id">${requisito}</td>
      <td><button class='btn btn-danger' onclick='remove_editar(this)'><i class='fas fa-trash'></i></button></td>
    </tr>`;

  $("#tbody_tabla_requisito_editar").append(datos_agregar); // Agrega a tbody
  $("#txt_requisitos_editar").val(""); // Limpia el campo después de agregar
}

// BORRAR REGISTRO
function remove_editar(t) {
  $(t).closest("tr").remove();
}

// FUNCIÓN PARA VERIFICAR QUE NO SE INGRESE EL MISMO REQUISITO
function verificarid_editar(requisito) {
  let existe = $("#tbody_tabla_requisito_editar td[for='id']").filter(function () {
    return $(this).text().trim().toLowerCase() === requisito.toLowerCase();
  }).length > 0;

  return existe;
}