function ajax(url,method,params,container_id){
	try{
		ObjXMLHttpRequest=new XMLHttpRequest;
	
	}catch(e){
		try{
			ObjXMLHttpRequest=new ActiveXObject("Microsoft.XMLHTTP");
		
		}catch(el){
			alert("Navegador no soporta ajax")
		}
	}

	ObjXMLHttpRequest.onreadystatechange=function(){
		if(ObjXMLHttpRequest.readyState==4){
			document.getElementById(container_id).innerHTML=ObjXMLHttpRequest.responseText;
		}
	}
	ObjXMLHttpRequest.open(method,url,true);
	ObjXMLHttpRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ObjXMLHttpRequest.send(params)
}

var fecha = new Date();
var mes = fecha.getMonth()+1; 
var dia = fecha.getDate();
var ano = fecha.getFullYear(); 

if(dia<10)
  dia='0'+dia;
if(mes<10)
  mes='0'+mes;



$(function(){
    $("#registrar-compra").on("click", function(){
		let monto = $("#monto").val();

		if(monto <= 0 || monto == ""){
			let modalregistro = new bootstrap.Modal(document.getElementById('modalregistrar'), {
				keyboard: false
			  })
		
			let titulo = "Error!";
		
			let contenido = "no se ingreso un monto valido.";
		
			document.getElementById("modal-registro-titulo").innerHTML = titulo;
			document.getElementById("modal-registro-descripcion").innerHTML = contenido;
		
			modalregistro.show();

		}else{
			var datos = new FormData();
			datos.append('img',$('#img')[0].files[0]);
			datos.append('idprovee',$('#idproveedor').val());
			datos.append('monto',$('#monto').val());
			datos.append('fecha',$('#fecha').val());
			datos.append('accion',"registrar");

			$("#monto").val("");
			$("#txtidreferencia").val(0);
			$("#txtimg").val("");
			$("#img").val("");
			$("#contenedor-imagen-muestra").hide();
			document.getElementById('fecha').value=ano+"-"+mes+"-"+dia;
			
			$.ajax({
				type: 'POST',
				url: '../../acciones/admin_compra.php',
				data: datos,
				contentType: false,
				cache:false,
				processData:false,
				success: function(respuesta){
					$('#lst-compras').html(respuesta)
				}
			})
		}
		return false;
    })

    $("#modificar-compra").on("click", function(){

		let id = $("#txtidreferencia").val();

		if (id <= 0){
			let modalregistro = new bootstrap.Modal(document.getElementById('modalregistrar'), {
				keyboard: false
			  })
		
			let titulo = "Error!";
		
			let contenido = "no se selecciono ningun registro";
		
			document.getElementById("modal-registro-titulo").innerHTML = titulo;
			document.getElementById("modal-registro-descripcion").innerHTML = contenido;
		
			modalregistro.show();

		}else{
			var datos = new FormData();
			datos.append('img',$('#img')[0].files[0]);
			datos.append('idprovee',$('#idproveedor').val());
			datos.append('monto',$('#monto').val());
			datos.append('fecha',$('#fecha').val());
			datos.append('accion',"modificar");
			datos.append('idreferencia',id);

			$("#monto").val("");
			$("#txtidreferencia").val(0);
			$("#txtimg").val("");
			$("#img").val("");
			$("#contenedor-imagen-muestra").hide();
			document.getElementById('fecha').value=ano+"-"+mes+"-"+dia;
			
			$.ajax({
				type: 'POST',
				url: '../../acciones/admin_compra.php',
				data: datos,
				contentType: false,
				cache:false,
				processData:false,
				success: function(respuesta){
					$('#lst-compras').html(respuesta)
				}
			})
		}
		return false;
    })

    $("#cancelar-compra").on("click", function(){

		document.getElementById('fecha').value=ano+"-"+mes+"-"+dia;

		$("#monto").val("");
		$("#txtidreferencia").val(0);
		$("#txtimg").val("");
		$("#img").val("");
		$("#contenedor-imagen-muestra").hide();

    })

	$("#registrar-empresa").on("click", function(){
		let nombre = $("#nombre").val();

		if(nombre){
			var datos = new FormData();
			datos.append('nombre',nombre);
			datos.append('ruc',$('#ruc').val());
			datos.append('accion',"registrar");

			$("#nombre").val("");
			$("#idreferenciaprovee").val(0);
			$("#ruc").val("");
			
			$.ajax({
				type: 'POST',
				url: '../../acciones/admin_proveedor.php',
				data: datos,
				contentType: false,
				cache:false,
				processData:false,
				success: function(respuesta){
					$('#lst-empresa').html(respuesta)
				}
			})
			setTimeout(()=>{
				actualizar_empresas();
			},1000);

		}else{
			let modalregistro = new bootstrap.Modal(document.getElementById('modalregistrar'), {
				keyboard: false
			  })
		
			let titulo = "Error!";
		
			let contenido = "ingrese un nombre para registrar la empresa.";
		
			document.getElementById("modal-registro-titulo").innerHTML = titulo;
			document.getElementById("modal-registro-descripcion").innerHTML = contenido;
		
			modalregistro.show();
		}
		return false;
	})

	$("#modificar-empresa").on("click", function() {
		let idproveedor = $("#idreferenciaprovee").val();

		if (idproveedor <= 0){
			let modalregistro = new bootstrap.Modal(document.getElementById('modalregistrar'), {
				keyboard: false
			  })
		
			let titulo = "Error!";
		
			let contenido = "no se selecciono ningun registro";
		
			document.getElementById("modal-registro-titulo").innerHTML = titulo;
			document.getElementById("modal-registro-descripcion").innerHTML = contenido;
		
			modalregistro.show();

		}else{
			var datos = new FormData();
			datos.append('nombre',$('#nombre').val());
			datos.append('ruc',$('#ruc').val());
			datos.append('accion',"modificar");
			datos.append('idreferenciaprovee',idproveedor);

			$("#nombre").val("");
			$("#idreferenciaprovee").val(0);
			$("#ruc").val("");
			
			$.ajax({
				type: 'POST',
				url: '../../acciones/admin_proveedor.php',
				data: datos,
				contentType: false,
				cache:false,
				processData:false,
				success: function(respuesta){
					$('#lst-empresa').html(respuesta)
				}
			})
			setTimeout(()=>{
				actualizar_empresas();
			},1000);
		}
		return false;
	})

	$("#cancelar-empresa").on("click", function(){
		$("#nombre").val("");
		$("#idreferenciaprovee").val(0);
		$("#ruc").val("");
    })
});

function borrar_compra(id){
	let accion = "borrar";

	let url = '../../acciones/admin_compra.php';
	let method = 'POST';
	let params ='idreferencia='+id;
	params+='&accion='+accion;
	let container_id = 'lst-compras';
	ajax(url,method,params,container_id);
}


function actualizar_empresas(){
	let url = '../../acciones/actualizar_empresa.php';
	let method = 'POST';
	let params ='dato='+"si";
	let container_id = 'listar_empresas';
	ajax(url,method,params,container_id);
}


function borrar_empresa(id){
	let accion = "borrar";

	let url = '../../acciones/admin_proveedor.php';
	let method = 'POST';
	let params ='idreferenciaprovee='+id;
	params+='&accion='+accion;
	let container_id = 'lst-empresa';
	ajax(url,method,params,container_id);

	setTimeout(()=>{
        actualizar_empresas();
    },1000);
}

function mostrar_imagen(img) {
    let modalimg = new bootstrap.Modal(document.getElementById('modalimg'), {
        keyboard: false
      })

    let titulo = img;

    let contenido = "<img src='../../facturas/"+img+"' class='img-fluid' width='800'>";

    document.getElementById("modal-compra-titulo-img").innerHTML = titulo;
    document.getElementById("modal-compra-contenido-img").innerHTML = contenido;

    modalimg.show();


}
