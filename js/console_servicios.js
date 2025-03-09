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
      { "data": "requisitos" },
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
        "defaultContent": "<button class='mostrar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>"
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
  document.getElementById('txt_requisitos_editar').value=data.requisitos;
  document.getElementById('txt_descripcion_editar').value=data.descripcion;
  document.getElementById('select_status_editar').value=data.estado_ser;
})

$('#tabla_servicios').on('click','.mostrar',function(){
  var data = tbl_servicios.row($(this).parents('tr')).data();

  if(tbl_servicios.row(this).child.isShown()){
      var data = tbl_servicios.row(this).data();
  }
  $("#modal_mostrar").modal('show');
  document.getElementById('txt_servicio_mostrar').value=data.nombre;
  document.getElementById('txt_costo_mostrar').value=data.costo;
  document.getElementById('txt_requisitos_mostrar').value=data.requisitos;
  document.getElementById('txt_descripcion_mostrar').value=data.descripcion;
  document.getElementById('select_status_mostrar').value=data.estado_ser;
})


function AbrirRegistro(){
  $("#modal_registro").modal({backdrop:'static',keyboard:false})
  $("#modal_registro").modal('show');
}

function Registrar_Servicio(){
  let serv = document.getElementById('txt_servicio').value;
  let costo = document.getElementById('txt_costo').value;
  let requisito = document.getElementById('txt_requisitos').value;
  let descripcion = document.getElementById('txt_descripcion').value;
  let idusu = document.getElementById('txtprincipalid').value;

  if(serv.length==0||costo.length==0||requisito.length==0){
      return Swal.fire("Mensaje de Advertencia","Los campos obligatorios no han sido completados","warning");
  }
  $.ajax({
    "url":"../controller/servicios/controlador_registro_servicios.php",
    type:'POST',
    data:{
      serv:serv,
      costo:costo,
      requisito:requisito,
      descripcion:descripcion,
      idusu:idusu
    }
  }).done(function(resp){
    if(resp>0){
      if(resp==1){
        Swal.fire("Mensaje de Confirmación","Nuevo Servicio registrada con el nombre: <b>"+serv+"</b>","success").then((value)=>{
          tbl_servicios.ajax.reload();
          document.getElementById('txt_servicio').value="";
          document.getElementById('txt_costo').value="";
          document.getElementById('txt_requisitos').value="";
          document.getElementById('txt_descripcion').value="";
        $("#modal_registro").modal('hide');
        });
      }else{
        Swal.fire("Mensaje de Advertencia","El servicio que desea registrar ya se encuentra en la base de datos, revise por favor","warning");
      }
    }else{
      return Swal.fire("Mensaje de Error","No se completo el registro","error");

    }
  })
}
function Modificar_Servicio(){
  let id = document.getElementById('txt_idservicio').value;
  let serv = document.getElementById('txt_servicio_editar').value;
  let costo = document.getElementById('txt_costo_editar').value;
  let requisito = document.getElementById('txt_requisitos_editar').value;
  let descripcion = document.getElementById('txt_descripcion_editar').value;
  let esta = document.getElementById('select_status_editar').value;
  let idusu = document.getElementById('txtprincipalid').value;

  if(serv.length==0||costo.length==0||requisito.length==0||id.length==0||esta.length==0){
    return Swal.fire("Mensaje de Advertencia","Tiene campos vacios, revise los campos que faltan","warning");
  }
  $.ajax({
    "url":"../controller/servicios/controlador_modificar_servicios.php",
    type:'POST',
    data:{
      id:id,
      serv:serv,
      costo:costo,
      requisito:requisito,
      descripcion:descripcion,
      esta:esta,
      idusu:idusu,
    }
  }).done(function(resp){
    if(resp>0){
      if(resp==1){
        Swal.fire("Mensaje de Confirmación","Datos actualizados del servicio de: <b>"+serv+"</b>","success").then((value)=>{
          tbl_servicios.ajax.reload();
        $("#modal_editar").modal('hide');
        });
      }else{
        Swal.fire("Mensaje de Advertencia","El servicio ingresado ya se encuentra en la base de datos, revise por favor","warning");
      }
    }else{
      return Swal.fire("Mensaje de Error","No se completo la actualización","error");

    }
  })
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