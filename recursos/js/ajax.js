var formName="";
var root_ruta="";

function cambiarFormName(param_root_ruta,paramformName){
	formName=paramformName;
	root_ruta = param_root_ruta;
}
function create(){
	alert(document.forms[formName]);
	var strDAtos = "";
	for(i=0; i<document.forms[formName].length; i++){
		strDAtos += document.forms[formName][i].name+"="+document.forms[formName][i].value;
		if(i<document.forms[formName].length-1){
			strDAtos += "&";
		}
	}
	$.ajax({
		type: "POST",
		url: root_ruta+"class/insert.php",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			alert(data);
			//window.location.reload(true);
		}
	});
}
function abrir_edit(param_ruta_padre, id){
	window.location= param_ruta_padre+"/create/edit.php?id="+id;
}
function abrir_nuevo(param_ruta_padre){
	window.location= param_ruta_padre+"/create/";
}
function read(paramId, param_ruta_padre){
	var strDAtos = "id="+paramId;
	var datosArray;
	mostrando = false;
	$.ajax({
		type: "POST",
		url: root_ruta+"class/read.php",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			datosArray = data.split(",");
			for(i=0; i<document.forms[formName].length; i++){
				document.forms[formName][i].value = datosArray[i];
			}
			document.getElementById("enviar_btn").onclick = function(){update(param_ruta_padre);};
		}
	});
}
function read_actividad_cotizacion(){
	var strDAtos = "id="+document.getElementById("act").value+"&cant_est="+document.getElementById("cant_est_act").value;
	strDAtos += "&total_tiempo="+document.getElementById("total_tiempo").innerHTML+"&total_costo="+document.getElementById("total_costo").innerHTML;
	var datosArray;
	$.ajax({
		type: "POST",
		url: "../../actividad/class/read_data_act.php",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			var arreglo_acti = document.getElementById("arreglo_env").value;
			var arreglo = [null];
			var content = "<tr>";

			datosArray = data.split(",");
			for(i=0; i<datosArray.length-2; i++){
				content += "<td>"+datosArray[i]+"</td>";
			}
			content += "</tr>";

			document.getElementById("total_tiempo").innerHTML = datosArray[datosArray.length-2];
			document.getElementById("total_costo").innerHTML = datosArray[datosArray.length-1];

			arreglo.push("0");
			arreglo.push(datosArray[5]);
			arreglo.push(datosArray[6]);
			arreglo.push(datosArray[7]);
			arreglo.push(null);
			arreglo.push(datosArray[2]);

			if(arreglo_acti == ""){
				arreglo_acti += ""+arreglo+"";
			}else{
				arreglo_acti += ";"+arreglo+"";
			}

			document.getElementById("arreglo_env").value = ""+arreglo_acti+"";
			document.getElementById("cont_acti").innerHTML += content;
		}
	});
}
function read_actividad_cotizacion_edit(id_act,cant_est,tiempo_act,val_act){
	var strDAtos = "id="+id_act+"&cant_est="+cant_est+"&tiempo_act="+tiempo_act+"&val_act="+val_act;
	strDAtos += "&total_tiempo="+document.getElementById("total_tiempo").innerHTML+"&total_costo="+document.getElementById("total_costo").innerHTML;
	var datosArray;
	$.ajax({
		type: "POST",
		url: "../../actividad/class/read_data_act.php",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			var arreglo_acti = document.getElementById("arreglo_env").value;
			var arreglo = [null];
			var content = "<tr>";

			datosArray = data.split(",");
			for(i=0; i<datosArray.length-2; i++){
				content += "<td>"+datosArray[i]+"</td>";
			}
			content += "</tr>";

			document.getElementById("total_tiempo").innerHTML = totales_tabla_cotizacion(document.getElementById("total_tiempo").innerHTML, datosArray[6]);
			document.getElementById("total_costo").innerHTML = parseInt(document.getElementById("total_costo").innerHTML)+parseInt(datosArray[7]);

			arreglo.push("0");
			arreglo.push(datosArray[5]);
			arreglo.push(datosArray[6]);
			arreglo.push(datosArray[7]);
			arreglo.push(null);
			arreglo.push(datosArray[2]);

			if(arreglo_acti == ""){
				arreglo_acti += ""+arreglo+"";
			}else{
				arreglo_acti += ";"+arreglo+"";
			}

			document.getElementById("arreglo_env").value = ""+arreglo_acti+"";
			document.getElementById("cont_acti").innerHTML += content;
		}
	});
}
function totales_tabla_cotizacion(param_fecha1,param_fecha2){
	var fecha_sep1 = (param_fecha1+"").split(":");
	var fecha_sep2 = (param_fecha2+"").split(":");
	var fecha_res = [0,0,0];
	var temp = 0;
	for (var i=2; i>=0; i--) {
		fecha_res[i] = (parseInt(fecha_sep1[i])+parseInt(fecha_sep2[i]))+temp;
		if(i>0){
			var temp = Math.floor(fecha_res[i]/60);
			fecha_res[i] = fecha_res[i]-(temp*60);
		}
	}
	return fecha_res.join(":");
}
function read_roles_usuario(){
	var arreglo_acti = document.getElementById("roles").value;
	var content = "<tr><td>"+document.getElementById("rol").options[document.getElementById("rol").value].innerHTML+"</td></tr>";
	if(arreglo_acti == ""){
		arreglo_acti += ""+document.getElementById("rol").value+"";
	}else{
		arreglo_acti += ";"+document.getElementById("rol").value+"";
	}
	document.getElementById("roles").value = ""+arreglo_acti+"";
	document.getElementById("cont_roles").innerHTML += content;
}
function read_roles_usuario_edit(id_rol){
	var arreglo_roles = document.getElementById("roles").value;
	var content = "<tr><td>"+document.getElementById("rol").options[id_rol].innerHTML+"</td></tr>";
	if(arreglo_roles == ""){
		arreglo_roles += ""+id_rol+"";
	}else{
		arreglo_roles += ";"+id_rol+"";
	}
	document.getElementById("roles").value = ""+arreglo_roles+"";
	document.getElementById("cont_roles").innerHTML += content;
}

function read_tarea_act(){
	var arreglo_acti = document.getElementById("roles_tarea").value;
	var content = "<tr><td>"+document.getElementById("roles").options[document.getElementById("roles").value].innerHTML+"</td>";
	content += "<td>"+document.getElementById("tarea").value+"</td></tr>"
	if(arreglo_acti == ""){
		arreglo_acti += ""+document.getElementById("roles").value+","+document.getElementById("tarea").value;
	}else{
		arreglo_acti += ";"+document.getElementById("roles").value+","+document.getElementById("tarea").value;
	}
	document.getElementById("roles_tarea").value = ""+arreglo_acti+"";
	document.getElementById("cont_roles_tareas").innerHTML += content;
}
function read_tarea_act_edit(id_rol){
	var arreglo_roles = document.getElementById("roles").value;
	var content = "<tr><td>"+document.getElementById("rol").options[id_rol].innerHTML+"</td></tr>";
	if(arreglo_roles == ""){
		arreglo_roles += ""+id_rol+"";
	}else{
		arreglo_roles += ";"+id_rol+"";
	}
	document.getElementById("roles").value = ""+arreglo_roles+"";
	document.getElementById("cont_roles").innerHTML += content;
}

function update(param_ruta_padre){
	var strDAtos = "";
	for(i=0; i<document.forms[formName].length; i++){
		strDAtos += document.forms[formName][i].name+"="+document.forms[formName][i].value;
		if(i<document.forms[formName].length-1){
			strDAtos += "&";
		}
	}
	$.ajax({
		type: "POST",
		url: root_ruta+"class/update.php",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			alert(data);
			window.location = param_ruta_padre+"/";
		}
	});
}
function deleted(paramId){
	if (confirm("esta seguro de eliminar el registro")){// validacion de eliminar
		var strDAtos = "id="+paramId;
		$.ajax({
			type: "POST",
			url: root_ruta+"class/deleted.php",
			datatype: "html",
			data: strDAtos,
			success: function(data) {
				//alert(data);
				window.location.reload(true);
			}
		});
	}
}