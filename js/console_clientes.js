var tbl_clientes;
function listar_clientes() {
  tbl_clientes = $("#tabla_clientes").DataTable({
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
      "url": "../controller/clientes/controlador_listar_clientes.php",
      type: 'POST'
    },
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="fas fa-file-excel"></i> Excel',
        titleAttr: 'Exportar a Excel',
        filename: function() {
          return "LISTA DE CLIENTES";
        },
        title: function() {
            return "LISTA DE CLIENTES";
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
            return "LISTA DE CLIENTES";
        },
        title: function() {
            return "LISTA DE CLIENTES";
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
            return "LISTA DE CLIENTES";
        },
        className: 'btn btn-print',
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6, 7] // Exportar solo hasta la columna 'estado'
        }
      }
    ],

    "columns": [
      { "defaultContent": "" },
      { "data": "tipo_documento" },
      { "data": "nro_documento" },

      { 
        "data": "CLIENTE",
        "render": function(data, type, row) {
          return "<strong>" + data + "</strong>";
        }
      },
      { "data": "celular" },
      { "data": "direccion" },
      { "data": "email" },

      { "data": "fecha_formateada" },

      {
        "defaultContent": "<button class='mostrar btn btn-success btn-sm' title='Ver datos'><i class='fa fa-eye'></i> Mostrar</button> <button class='editar btn btn-primary btn-sm' title='Editar datos de área'><i class='fa fa-edit'></i> Editar</button> <button class='eliminar btn btn-danger btn-sm' title='Eliminar datos de área'><i class='fa fa-trash'></i> Eliminar</button>"
      }
    ],

    "language": idioma_espanol,
    select: true
  });

  tbl_clientes.on('draw.td', function() {
    var PageInfo = $("#tabla_clientes").DataTable().page.info();
    tbl_clientes.column(0, { page: 'current' }).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1 + PageInfo.start;
    });
  });
}

$('#tabla_clientes').on('click','.editar',function(){
  var data = tbl_clientes.row($(this).parents('tr')).data();

  if(tbl_clientes.row(this).child.isShown()){
      var data = tbl_clientes.row(this).data();
  }
  $("#modal_editar").modal('show');
  document.getElementById('txt_idcliente').value=data.id_cliente;
  document.getElementById('select_tipo_doc').value=data.tipo_documento;
  document.getElementById('txt_nro_doc').value=data.nro_documento;
  document.getElementById('txt_nombre').value=data.nombres;
  document.getElementById('txt_apellido').value=data.apellidos;
  document.getElementById('txt_celular').value=data.apellidos;
  document.getElementById('txt_telefono').value=data.telefono;
  document.getElementById('txt_direccion').value=data.direccion;
  document.getElementById('txt_email').value=data.email;
  document.getElementById('txt_obser').value=data.observacion;
})

$('#tabla_clientes').on('click','.mostrar',function(){
  var data = tbl_clientes.row($(this).parents('tr')).data();

  if(tbl_clientes.row(this).child.isShown()){
      var data = tbl_clientes.row(this).data();
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


function AbrirRegistro(){
  $("#modal_registro").modal({backdrop:'static',keyboard:false})
  $("#modal_registro").modal('show');
}

//EDITAR CLIENTE
function Modificar_Cliente(){
  let id = document.getElementById('txt_idcliente').value;
  let tipo = document.getElementById('select_tipo_doc').value;
  let nro = document.getElementById('txt_nro_doc').value;
  let nombre = document.getElementById('txt_nombre').value;
  let apellido = document.getElementById('txt_apellido').value;
  let celular = document.getElementById('txt_celular').value;
  let telefono = document.getElementById('txt_telefono').value;
  let direccion = document.getElementById('txt_direccion').value;
  let email = document.getElementById('txt_email').value;
  let ober = document.getElementById('txt_obser').value;


  if(tipo.length==0||nro.length==0||nombre.length==0||apellido.length==0||celular.length==0||id.length==0){
    return Swal.fire("Mensaje de Advertencia","Tiene campos vacios, revise los campos obligatorios","warning");
  }
  $.ajax({
    "url":"../controller/clientes/controlador_modificar_clientes.php",
    type:'POST',
    data:{
      id:id,
      tipo:tipo,
      nro:nro,
      nombre:nombre,
      apellido:apellido,
      celular:celular,
      telefono:telefono,
      direccion:direccion,
      email:email,
      ober:ober,
    }
  }).done(function(resp){
    if(resp>0){
      if(resp==1){
        Swal.fire("Mensaje de Confirmación","Datos actualizados del cliente: <b>"+nombre+" "+apellido+"</b>","success").then((value)=>{
          tbl_clientes.ajax.reload();
        $("#modal_editar").modal('hide');
        });
      }else{
        Swal.fire("Mensaje de Advertencia","El DNI del cliente ingresado ya se encuentra en la base de datos, revise por favor, no se puede insertar un DNI repetido","warning");
      }
    }else{
      return Swal.fire("Mensaje de Error","No se completo la actualización","error");

    }
  })
}

//ELIMINAR AREAS
function Eliminar_cliente(id){
  $.ajax({
    "url":"../controller/clientes/controlador_eliminar_clientes.php",
    type:'POST',
    data:{
      id:id
    }
  }).done(function(resp){
    if(resp>0){
        Swal.fire("Mensaje de Confirmación","Se elimino el cliente con exito","success").then((value)=>{
          tbl_clientes.ajax.reload();

        });
    }else{
      return Swal.fire("Mensaje de Advetencia","No se puede eliminar este cliente por que tiene expedientes registrados, verifique por favor","warning");

    }
  })
}

//ENVIANDO AL BOTON DELETE
$('#tabla_clientes').on('click','.eliminar',function(){
  var data = tbl_clientes.row($(this).parents('tr')).data();

  if(tbl_clientes.row(this).child.isShown()){
      var data = tbl_clientes.row(this).data();
  }
  Swal.fire({
    title: 'Desea eliminar al cliente con el nombre: '+data.nombres+' '+data.apellidos+'?',
    text: "Una vez aceptado el cliente sera eliminado!!!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar'
  }).then((result) => {
    if (result.isConfirmed) {
        Eliminar_cliente(data.id_cliente);
    }
  })
})