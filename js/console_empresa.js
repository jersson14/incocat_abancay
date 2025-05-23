var tbl_empresa;
function listar_empresa(){
  tbl_empresa = $("#tabla_empresa").DataTable({
    "ordering":false,   
    "processing": true,
    responsive: true,
    "searching": false ,
    "bPaginate": false,
    "ajax":{
        "url":"../controller/empresa/controlador_listar_empresa.php",
        type:'POST'
    },
   
     
      "columns":[
        {"defaultContent":""},
        {"data":"logo",
            render: function(data,type,row){
                return '<img src="../'+data+'" class="img img-responsive" style="width: 80px">';
            }   
         },
        {"data":"nombre"},
        {"data":"email"},
        {"data":"telefono"},
        {"data":"direccion"},
        {"defaultContent":"<button class='editar btn btn-primary  btn-sm' title='Editar datos de empresa'><i class='fa fa-edit'></i> Editar</button>&nbsp;<button class='foto btn btn-warning btn-sm' title='Cambiar logo'><i class='fa fa-image'></i> Cambiar foto</button>"},

    ],

    "language":idioma_espanol,
    select: true
});
tbl_empresa.on('draw.td',function(){
  var PageInfo = $("#tabla_empresa").DataTable().page.info();
  tbl_empresa.column(0, {page: 'current'}).nodes().each(function(cell, i){
    cell.innerHTML = i + 1 + PageInfo.start;
  });
});
}
$('#tabla_empresa').on('click','.editar',function(){
    var data = tbl_empresa.row($(this).parents('tr')).data();
  
    if(tbl_empresa.row(this).child.isShown()){
        var data = tbl_empresa.row(this).data();
    }
    $("#modal_editar").modal('show');
    document.getElementById('txt_id_empresa').value=data.id_empresa;
    document.getElementById('txt_nombre').value=data.nombre;
    document.getElementById('txt_email').value=data.email;
    document.getElementById('txt_codigo').value=data.codigo;
    document.getElementById('txt_telefono').value=data.telefono;
    document.getElementById('txt_direccion').value=data.direccion;
  })
  function Modificar_Empleado(){
    let id = document.getElementById('txt_id_empresa').value;
    let nom = document.getElementById('txt_nombre').value;
    let email = document.getElementById('txt_email').value;
    let cod = document.getElementById('txt_codigo').value;
    let tel = document.getElementById('txt_telefono').value;
    let dir = document.getElementById('txt_direccion').value;

    if(id.length==0 || nom.length==0 || email.length==0 || cod.length==0 || tel.length==0 || dir.length==0){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }
    if(validar_email(email)){
  
    }else{
      return Swal.fire("Mensaje de Advertencia","El formato de Email es incorrecto","warning");
  
    }
    $.ajax({
      "url":"../controller/empresa/controlador_modificar_empresa.php",
      type:'POST',
      data:{
          id:id,
          nom:nom,
          email:email,
          cod:cod,
          tel:tel,
          dir:dir,

      }
    }).done(function(resp){
      if(resp>0){
          Swal.fire("Mensaje de Confirmación","Datos de la institución Actualizado","success").then((value)=>{
            tbl_empresa.ajax.reload();
          $("#modal_editar").modal('hide');

          });
        
      }else{
        return Swal.fire("Mensaje de Error","No se completo el proceso","error");
  
      }
    })
  }
  function validar_email(email) {
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
  }
  $('#tabla_empresa').on('click','.foto',function(){
    var data = tbl_empresa.row($(this).parents('tr')).data();
  
    if(tbl_empresa.row(this).child.isShown()){
        var data = tbl_empresa.row(this).data();
    }
    $("#modal_editar_foto").modal('show');
    document.getElementById('txt_idempresa_foto').value=data.id_empresa;
    document.getElementById('lb_empresa').innerHTML=data.nombre;
    document.getElementById('fotoactual').value=data.logo;
  
  })
  function Modificar_Foto_Empresa(){
    let id = document.getElementById("txt_idempresa_foto").value
    let foto = document.getElementById("txt_foto").value
    let fotoactual = document.getElementById("fotoactual").value
  
    if(id.length==0 || foto.length==0){
      return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
  }
  
      let extension = foto.split('.').pop();
      let nombrefoto="";
      let f = new Date();
      if(foto.length>0){
        nombrefoto="IMG"+f.getDate()+"-"+(f.getMonth()+1)+"-"+f.getFullYear()+"-"+f.getHours()+"-"+f.getMilliseconds()+"."+extension;
      }
      let formData = new FormData();
      let fotoobj = $("#txt_foto")[0].files[0];
  
      formData.append("id",id);
      formData.append("nombrefoto",nombrefoto);
      formData.append("fotoactual",fotoactual);
      formData.append("foto",fotoobj);
      $.ajax({
        url:"../controller/empresa/controlador_empresa_modificar_foto.php",
        type:'POST',
        data:formData,
        contentType:false,
        processData:false,
        success:function(resp){
          if(resp.length>0){
            Swal.fire("Mensaje de Confirmación","Foto actualizada","success").then((value)=>{
              $("#modal_editar_foto").modal('hide');
              tbl_empresa.ajax.reload();
              document.getElementById('txt_foto').value="";
  
            });
          }else{
            Swal.fire("Mensaje de Advertencia","No se pudo actualizar la foto","warning");
          }
        }
      });
  }