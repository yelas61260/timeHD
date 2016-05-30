function create(param_ruta,param_formName){
	var strDAtos = "";
	var datosExtra = unirExtra();
	if(datosExtra != ""){
		strDAtos += "extra="+datosExtra+"&";
	}
	for(i=0; i<document.forms[param_formName].length; i++){
		strDAtos += document.forms[param_formName][i].name+"="+document.forms[param_formName][i].value;
		if(i<document.forms[param_formName].length-1){
			strDAtos += "&";
		}
	}
	$.ajax({
		type: "POST",
		url: param_ruta+"/jinsert",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			//alert(data);
			window.location.reload(true);
		}
	});
}
function update(param_ruta,param_formName){
	var strDAtos = "";
	var datosExtra = unirExtra();
	if(datosExtra != ""){
		strDAtos += "extra="+datosExtra+"&";
	}
	for(i=0; i<document.forms[param_formName].length; i++){
		strDAtos += document.forms[param_formName][i].name+"="+document.forms[param_formName][i].value;
		if(i<document.forms[param_formName].length-1){
			strDAtos += "&";
		}
	}
	$.ajax({
		type: "POST",
		url: param_ruta+"/jupdate",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			//alert(data);
			window.location = param_ruta+"/";
		}
	});
}
function deleted(paramId, param_ruta){
	if (confirm("¿esta seguro de eliminar el registro?")){// validacion de eliminar
		var strDAtos = "id="+paramId;
		$.ajax({
			type: "POST",
			url: param_ruta+"/jdeleted",
			datatype: "html",
			data: strDAtos,
			success: function(data) {
				//alert(data);
				window.location = param_ruta;
			}
		});
	}else{
		window.location = param_ruta;
	}
}
function conv_proy(paramId, param_ruta){
	if (confirm("¿esta seguro de convertir a proyecto?")){// validacion de eliminar
		var strDAtos = "id="+paramId;
		$.ajax({
			type: "POST",
			url: param_ruta+"/jconv_proy",
			datatype: "html",
			data: strDAtos,
			success: function(data) {
				//alert(data);
				window.location = param_ruta;
			}
		});
	}else{
		window.location = param_ruta;
	}	
}
function abrir_ruta(param_ruta){
	window.location= param_ruta;
}
function read(paramId, param_ruta, param_formName){
	var strDAtos = "id="+paramId;
	var datosArray;
	mostrando = false;
	$.ajax({
		type: "POST",
		url: param_ruta+"/jread",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			//alert(data);
			datosArray = data.split(",");
			for(i=0; i<document.forms[param_formName].length; i++){
				if(datosArray[i] != ""){
					document.forms[param_formName][i].value = datosArray[i];
				}
			}
			document.getElementById("enviar_btn").onclick = function(){update(param_ruta,param_formName);};
		}
	});
}
function read_conf(param_ruta, param_formName){
	var strDAtos = "";
	var datosArray;
	mostrando = false;
	$.ajax({
		type: "POST",
		url: param_ruta+"/jread",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			//alert(data);
			datosArray = data.split(",");
			for(i=0; i<document.forms[param_formName].length; i++){
				if(datosArray[i] != ""){
					document.forms[param_formName][i].value = datosArray[i];
				}
			}
		}
	});
}
function update_conf(param_ruta,param_formName){
	var strDAtos = "";
	for(i=0; i<document.forms[param_formName].length; i++){
		strDAtos += document.forms[param_formName][i].name+"="+document.forms[param_formName][i].value;
		if(i<document.forms[param_formName].length-1){
			strDAtos += "&";
		}
	}
	$.ajax({
		type: "POST",
		url: param_ruta+"/jupdate",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			//alert(data);
			window.location = param_ruta+"/";
		}
	});
}
function read_actividad_cotizacion(param_ruta){
	var strDAtos = "id="+document.getElementById("act").value+"&cant_est="+document.getElementById("cant_est_act").value;
	strDAtos += "&total_tiempo="+document.getElementById("total_tiempo").innerHTML+"&total_costo="+document.getElementById("total_costo").innerHTML;
	var datosArray;
	$.ajax({
		type: "POST",
		url: param_ruta+"/read_data_act",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			var arreglo = [null];
			datosArray = data.split(",");

			arreglo.push("0");
			arreglo.push(datosArray[5]);
			arreglo.push(datosArray[6]);
			arreglo.push(datosArray[7]);
			arreglo.push(null);
			arreglo.push(datosArray[2]);

			var content = "<tr id='ext_"+datosArray[2]+"' valor='"+arreglo+"'>";
			for(i=0; i<datosArray.length; i++){
				if(i==5){
					content += "<td style='text-align: center;'><input id='input_ext_"+datosArray[2]+"' name='ext_"+datosArray[2]+"' type='text' size='10' value='"+datosArray[i]+"' required/></td>";
				}else{
					content += "<td>"+datosArray[i]+"</td>";
				}
			}

			content += "<td><button onclick='calcularAct("+datosArray[2]+");'>Recalcular</button></td>";
			content += "<td><button onclick='quitar("+datosArray[2]+", "+0+");'>Quitar</button></td>";
			content += "</tr>";

			document.getElementById("cont_acti").innerHTML += content;

			totales_tabla_tiempo_costo();
		}
	});
}
function read_actividad_cotizacion_edit(id_act,cant_est,tiempo_act,val_act,param_ruta,id_prin){
	var strDAtos = "id="+id_act+"&cant_est="+cant_est+"&tiempo_act="+tiempo_act+"&val_act="+val_act;
	strDAtos += "&total_tiempo="+document.getElementById("total_tiempo").innerHTML+"&total_costo="+document.getElementById("total_costo").innerHTML;
	var datosArray;
	$.ajax({
		type: "POST",
		url: param_ruta+"/read_data_act",
		datatype: "html",
		data: strDAtos,
		success: function(data) {
			var arreglo = [null];

			datosArray = data.split(",");

			arreglo.push("0");
			arreglo.push(datosArray[5]);
			arreglo.push(datosArray[6]);
			arreglo.push(datosArray[7]);
			arreglo.push(null);
			arreglo.push(datosArray[2]);

			var content = "<tr id='ext_"+id_act+"' valor='"+arreglo+"'>";
			for(i=0; i<datosArray.length; i++){
				if(i==5){
					content += "<td style='text-align: center;'><input id='input_ext_"+id_act+"' name='ext_"+id_act+"' type='text' size='10' value='"+datosArray[i]+"' required/></td>";
				}else{
					content += "<td>"+datosArray[i]+"</td>";
				}
			}
			content += "<td><button onclick='calcularAct("+id_act+");'>Recalcular</button></td>";
			content += "<td><button onclick='quitar("+id_act+", "+id_prin+");'>Quitar</button></td>";
			content += "</tr>";

			document.getElementById("total_tiempo").innerHTML = totales_tabla_cotizacion(document.getElementById("total_tiempo").innerHTML, datosArray[6]);
			document.getElementById("total_costo").innerHTML = parseInt(document.getElementById("total_costo").innerHTML)+parseInt(datosArray[7]);

			document.getElementById("cont_acti").innerHTML += content;

			totales_tabla_tiempo_costo();
		}
	});
}
function calcularAct(id_act){
	var datos = ($("#ext_"+id_act).attr("valor")+"").split(",");
	var cant_new = $("#input_ext_"+id_act).val();
	datos[4] = (parseInt(datos[4]+"") * cant_new)/parseInt(datos[2]+"");
	$("#ext_"+id_act+" td")[7].innerHTML = datos[4]+"";

	var fecha_sep1 = (datos[3]+"").split(":");
	var fecha_res = [0,0,0];
	var temp = ((parseInt(fecha_sep1[0])*3600)+(parseInt(fecha_sep1[1])*60)+parseInt(fecha_sep1[2]))*cant_new/parseInt(datos[2]);
	for (var i=2; i>=0; i--) {
		fecha_res[i] = temp;
		if(i>0){
			var temp = Math.floor(fecha_res[i]/60);
			fecha_res[i] = fecha_res[i]-(temp*60);
		}
		if(fecha_res[i]<10){
			fecha_res[i] = "0"+fecha_res[i];
		}
	}
	datos[3] = fecha_res.join(":");
	$("#ext_"+id_act+" td")[6].innerHTML = datos[3]+"";

	datos[2] = cant_new+"";

	$("#ext_"+id_act).attr("valor", datos+"");

	totales_tabla_tiempo_costo();
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
		if(fecha_res[i]<10){
			fecha_res[i] = "0"+fecha_res[i];
		}
	}
	return fecha_res.join(":");
}
function read_roles_usuario(){
	var content = "<tr id='ext_"+document.getElementById("rol").value+"' valor='"+document.getElementById("rol").value+"'><td>"+document.getElementById("rol").options[document.getElementById("rol").value].innerHTML+"</td>";
	content += "<td><button onclick='quitar("+document.getElementById("rol").value+", "+0+");'>Quitar</button></td></tr>";
	document.getElementById("cont_roles").innerHTML += content;
}
function read_roles_usuario_edit(id_rol, id_prin){
	var content = "<tr id='ext_"+id_rol+"' valor='"+id_rol+"'><td>"+document.getElementById("rol").options[id_rol].innerHTML+"</td>";
	content += "<td><button onclick='quitar("+id_rol+", "+id_prin+");'>Quitar</button></td></tr>";
	document.getElementById("cont_roles").innerHTML += content;
}

function read_tarea_act(){
	var content = "<tr id='ext_"+document.getElementById("roles").value+"' valor='"+document.getElementById("roles").value+","+document.getElementById("tarea").value+"'><td>"+document.getElementById("roles").options[document.getElementById("roles").value].innerHTML+"</td>";
	content += "<td>"+document.getElementById("tarea").value+"</td>";
	content += "<td><button onclick='quitar("+document.getElementById("roles").value+", "+0+");'>Quitar</button></td></tr>";
	document.getElementById("cont_roles_tareas").innerHTML += content;
}

function read_tarea_act_edit(id_rol, nom_tarea){
	var content = "<tr id='ext_"+id_rol+"' valor='"+id_rol+","+nom_tarea+"'><td>"+document.getElementById("roles").options[id_rol].innerHTML+"</td>";
	content += "<td>"+nom_tarea+"</td>";
	content += "<td><button onclick='quitar("+id_rol+", \""+nom_tarea+"\");'>Quitar</button></td></tr>";
	
	document.getElementById("cont_roles_tareas").innerHTML += content;
}

function unirExtra(){
	var returnVal = new Array();
	$("#extra tr").each(function(index){
		if($(this).attr("valor") != undefined){
			returnVal.push($(this).attr("valor"));
		}
	});
	return returnVal.join(";");
}
function quitar(id_ext, id_ext_parent){
	$("#ext_"+id_ext).remove();
	if(id_ext_parent != 0){
		strDAtos = "p1_extra="+id_ext_parent+"&p2_extra="+id_ext;
		$.ajax({
			type: "POST",
			url: "../jdextra",
			datatype: "html",
			data: strDAtos,
			success: function(data) {
				//alert(data);
			}
		});
	}
	totales_tabla_tiempo_costo();
}
function totales_tabla_tiempo_costo(){
	var total_costo = 0;
	var total_tiempo = "00:00:00";
	$("#cont_acti tr").each(function(index){
		total_costo += parseInt($(this).children()[7].innerHTML);
		total_tiempo = totales_tabla_cotizacion(total_tiempo, $(this).children()[6].innerHTML);
	});
	$("#total_costo").html(total_costo);
	$("#total_tiempo").html(total_tiempo);
}