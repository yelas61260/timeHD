function validateData(param_formName){
	for(i=0; i<document.forms[param_formName].length; i++){
		if(document.forms[param_formName][i].value == "" && document.forms[param_formName][i].hasAttribute('required')){
			return false;
		}
	}
	return true;
}
function create(param_ruta,param_formName){
	if(validateData(param_formName)){
		var strDAtos = {};
		var datosExtra = unirExtra();
		if(param_formName=="form_proyecto"){
			strDAtos["actividades"] = unirActividadesValor();
			strDAtos["terceros"] = unirTercerosValor();
		}else if(datosExtra != ""){
			strDAtos["extra"] = datosExtra+"";
		}
		for(i=0; i<document.forms[param_formName].length; i++){
			if(document.forms[param_formName][i].type != "checkbox"){
				strDAtos[document.forms[param_formName][i].name+""] = document.forms[param_formName][i].value;
			}else{
				if(document.forms[param_formName][i].checked){
					strDAtos[document.forms[param_formName][i].name+""] = 1;
				}else{
					strDAtos[document.forms[param_formName][i].name+""] = 0;
				}
			}
		}
		$.ajax({
			type: "POST",
			url: param_ruta+"/jinsert",
			datatype: "html",
			data: strDAtos,
			success: function(data) {
				if(data == "OK"){
					alertify.alert("Registro exitoso!", function () {
						window.location.reload(true);
					});
				}else{
					alertify.alert("No se pudo guardar el registro<br>"+data);
				}
			}
		});
	}else{
		alertify.alert("Hay campos obligatorios sin completar<br>Por favor llene todos los campos.");
	}
}
function update(param_ruta,param_formName){
	if(validateData(param_formName)){
		var strDAtos = {};
		var datosExtra = unirExtra();
		if(param_formName=="form_proyecto"){
			strDAtos["actividades"] = unirActividadesValor();
			strDAtos["terceros"] = unirTercerosValor();
		}else if(datosExtra != ""){
			strDAtos["extra"] = datosExtra+"";
		}
		for(i=0; i<document.forms[param_formName].length; i++){
			if(document.forms[param_formName][i].type != "checkbox"){
				strDAtos[document.forms[param_formName][i].name+""] = document.forms[param_formName][i].value;
			}else{
				if(document.forms[param_formName][i].checked){
					strDAtos[document.forms[param_formName][i].name+""] = 1;
				}else{
					strDAtos[document.forms[param_formName][i].name+""] = 0;
				}
			}
		}
		$.ajax({
			type: "POST",
			url: param_ruta+"/jupdate",
			datatype: "html",
			data: strDAtos,
			success: function(data) {
				console.log(data);
				if(data == "OK"){
					alertify.alert("Actualización exitosa!", function () {
						window.location.reload(true);
					});
				}else{
					alertify.alert("No se pudo guardar el registro<br>"+data);
				}
			}
		});
	}else{
		alertify.alert("Hay campos obligatorios sin completar<br>Por favor llene todos los campos.");
	}
}
function deleted(paramId, param_ruta){
	alertify.confirm("¿Esta seguro de eliminar el registro?", function (e){
		if (e){// validacion de eliminar
			var strDAtos = "id="+paramId;
			$.ajax({
				type: "POST",
				url: param_ruta+"/jdeleted",
				datatype: "html",
				data: strDAtos,
				success: function(data) {
					window.location.reload(true);
				}
			});
		}else{
		}
	});
}
function conv_proy(paramId, param_ruta){
	alertify.confirm("¿Esta seguro de convertir a proyecto?", function (e){
		if (e){// convertir en proyecto
			var strDAtos = "id="+paramId;
			$.ajax({
				type: "POST",
				url: param_ruta+"/jconv_proy",
				datatype: "html",
				data: strDAtos,
				success: function(data) {
					//alert(data);
					window.location.reload(true);
				}
			});
		}else{
		}
	});
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
function read_actividad_cotizacion(param_ruta, param_table){
	$.ajax({
		type: "POST",
		url: param_ruta+"/read_data_act",
		datatype: "html",
		data: "id="+$("#act").val(),
		success: function(data) {
			var filaTemp = $("<tr>");
			filaTemp.attr("idObj", "0");
			var cellRol = $("<td>");
			cellRol.html($("#rol").val());
			filaTemp.append(cellRol);
			var cellRolName = $("<td>");
			cellRolName.html($("#rol option:selected").text());
			filaTemp.append(cellRolName);
			datosArray = data.split("|");
			for(i=0; i<datosArray.length; i++){
				var cellTemp = $("<td>");
				cellTemp.html(datosArray[i]);
				filaTemp.append(cellTemp);
			}
			var cellHora = $("<td>");
			cellHora.html("<input type='text' size='10' value='0' onkeyup='if(event.keyCode == 13) calcularAct(\""+param_ruta+"\", this);'/>");
			filaTemp.append(cellHora);
			filaTemp.append($("<td>").html("0"));
			filaTemp.append($("<td>").html("<button onclick='removeElement(this);'>Quitar</button>"));

			$('#'+param_table).append(filaTemp);
		}
	});
}
function read_tercero_cotizacion(param_ruta, param_table){
	var filaTemp = $("<tr>");
	filaTemp.attr("idObj", "0");
	filaTemp.append($("<td>").html($("#ter").val()));
	filaTemp.append($("<td>").html("<input type='text' size='10' value='0'/>"));
	filaTemp.append($("<td>").html("<button onclick='removeElement(this);'>Quitar</button>"));
	$("#"+param_table).append(filaTemp);
}
function removeElement(param_obj){
	if($(param_obj).parent().parent().attr("idObj") != "0"){
		var listaBorrar = $(param_obj).parent().parent().parent().parent().attr("borrar");
		listaBorrar += ","+$(param_obj).parent().parent().attr("idObj");
		$(param_obj).parent().parent().parent().parent().attr("borrar",listaBorrar);
	}
	$(param_obj).parent().parent().remove();
}
function read_pcp(param_ruta, id, param_ruta2, notFrame = 1, frame = 'form_proyecto'){
	$.ajax({
		type: "POST",
		url: param_ruta+"/jread",
		datatype: "html",
		data: "id="+id,
		success: function(data) {
			var datosJSON = jQuery.parseJSON(data+"");
			if (notFrame != 0) {
				var posForm = 0;
				jQuery.each(datosJSON["datos"], function(i, val){
					if(val != ""){
						document.forms[frame][i].value = val;
						posForm++;
					}
				});
			}
			jQuery.each(datosJSON["act_p"], function(i, val){
				console.log(val);
				var filaTemp = $("<tr>");
				filaTemp.attr("idObj", val["idObj"]);
				filaTemp.append($("<td>").html(val["idRol"]));
				filaTemp.append($("<td>").html(val["nombreRol"]));
				filaTemp.append($("<td>").html(val["faseN"]));
				filaTemp.append($("<td>").html(val["fase"]));
				filaTemp.append($("<td>").html(val["actN"]));
				filaTemp.append($("<td>").html(val["actividad"]));
				if (notFrame == 2) {
					filaTemp.append($("<td>").html(val["tiempo_est"]));
					filaTemp.append($("<td>").html(val["tiempo_fac"]));
					filaTemp.append($("<td>").html(val["costo_est"]));
					filaTemp.append($("<td>").html(val["costo_fac"]));
					filaTemp.append($("<td>").html("<input type='text' size='10' value='0' />"));
				}else{
					filaTemp.append($("<td>").html("<input type='text' size='10' value='"+(val["tiempo"]*$("#duracion_est").val())+"' onkeyup='if(event.keyCode == 13) calcularAct(\""+param_ruta2+"\", this);'/>"));
					filaTemp.append($("<td>").html("0"));
					filaTemp.append($("<td>").html("<button onclick='removeElement(this);'>Quitar</button>"));
				}
				$("#act_p").append(filaTemp);
				if (notFrame != 2) {
					calcularAct(param_ruta2, $($(filaTemp).children()[6]).children()[0]);
				}
			});
			jQuery.each(datosJSON["act_s"], function(i, val){
				var filaTemp = $("<tr>");
				filaTemp.attr("idObj", val["idObj"]);
				filaTemp.append($("<td>").html(val["idRol"]));
				filaTemp.append($("<td>").html(val["nombreRol"]));
				filaTemp.append($("<td>").html(val["faseN"]));
				filaTemp.append($("<td>").html(val["fase"]));
				filaTemp.append($("<td>").html(val["actN"]));
				filaTemp.append($("<td>").html(val["actividad"]));
				if (notFrame == 2) {
					filaTemp.append($("<td>").html(val["tiempo_est"]));
					filaTemp.append($("<td>").html(val["tiempo_fac"]));
					filaTemp.append($("<td>").html(val["costo_est"]));
					filaTemp.append($("<td>").html(val["costo_fac"]));
					filaTemp.append($("<td>").html("<input type='text' size='10' value='0' />"));
				}else{
					filaTemp.append($("<td>").html("<input type='text' size='10' value='"+(val["tiempo"]*$("#duracion_est").val())+"' onkeyup='if(event.keyCode == 13) calcularAct(\""+param_ruta2+"\", this);'/>"));
					filaTemp.append($("<td>").html("0"));
					filaTemp.append($("<td>").html("<button onclick='removeElement(this);'>Quitar</button>"));
				}
				$("#act_s").append(filaTemp);
				if (notFrame != 2) {
					calcularAct(param_ruta2, $($(filaTemp).children()[6]).children()[0]);
				}
			});

			jQuery.each(datosJSON["ter_p"], function(i, val){
				var filaTemp = $("<tr>");
				filaTemp.attr("idObj", val["id"]);
				filaTemp.append($("<td>").html(val["nombre"]));
				filaTemp.append($("<td>").html("<input type='text' size='10' value='"+val["costo"]+"'/>"));
				filaTemp.append($("<td>").html("<button onclick='removeElement(this);'>Quitar</button>"));
				$("#ter_p").append(filaTemp);
			});
			jQuery.each(datosJSON["ter_s"], function(i, val){
				var filaTemp = $("<tr>");
				filaTemp.attr("idObj", val["id"]);
				filaTemp.append($("<td>").html(val["nombre"]));
				filaTemp.append($("<td>").html("<input type='text' size='10' value='"+val["costo"]+"'/>"));
				filaTemp.append($("<td>").html("<button onclick='removeElement(this);'>Quitar</button>"));
				$("#ter_s").append(filaTemp);
			});
			if (notFrame != 0) {
				document.getElementById("enviar_btn").onclick = function(){update(param_ruta,frame);};
			}
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
					if(datosArray[i] == "1"){
						content += "<td style='text-align: center;'>"+datosArray[i]+"</td>";
					}else{
						content += "<td style='text-align: center;'><input id='input_ext_"+id_act+"' name='ext_"+id_act+"' type='text' size='10' value='"+datosArray[i]+"' required/></td>";
					}
				}else{
					content += "<td>"+datosArray[i]+"</td>";
				}
			}
			if(datosArray[5] != "1"){
				content += "<td><button onclick='calcularAct("+id_act+");'>Recalcular</button></td>";
			}
			content += "<td><button onclick='quitar("+id_act+", "+id_prin+");'>Quitar</button></td>";
			content += "</tr>";

			document.getElementById("total_tiempo").innerHTML = totales_tabla_cotizacion(document.getElementById("total_tiempo").innerHTML, datosArray[6]);
			document.getElementById("total_costo").innerHTML = parseInt(document.getElementById("total_costo").innerHTML)+parseInt(datosArray[7]);

			document.getElementById("cont_acti").innerHTML += content;

			totales_tabla_tiempo_costo();
		}
	});
}
function calcularAct(param_ruta, param_obj){
	$.ajax({
		type: "POST",
		url: param_ruta+"/read_cost_act",
		datatype: "html",
		data: "id="+$($(param_obj).parent().parent().children()[4]).html()+"&rol="+$($(param_obj).parent().parent().children()[0]).html(),
		success: function(data) {
			$($(param_obj).parent().parent().children()[7]).html(parseInt(data)*$(param_obj).val());
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
		if(fecha_res[i]<10){
			fecha_res[i] = "0"+fecha_res[i];
		}
	}
	return fecha_res.join(":");
}
function read_roles_usuario(){
	var content = "<tr id='ext_"+document.getElementById("rol").value+"' valor='"+document.getElementById("rol").value+"'><td>"+$("#rol option:selected").html()+"</td>";
	content += "<td><button onclick='quitar("+document.getElementById("rol").value+", "+0+");'>Quitar</button></td></tr>";
	document.getElementById("cont_roles").innerHTML += content;
}
function read_roles_usuario_edit(id_rol, id_prin){
	var content = "<tr id='ext_"+id_rol+"' valor='"+id_rol+"'><td>"+$("#rol option[value='"+id_rol+"']").text()+"</td>";
	content += "<td><button onclick='quitar("+id_rol+", "+id_prin+");'>Quitar</button></td></tr>";
	document.getElementById("cont_roles").innerHTML += content;
}

function read_tarea_act(){
	var content = "<tr id='ext_"+document.getElementById("roles").value+"' valor='"+document.getElementById("roles").value+","+document.getElementById("tarea").value+"'><td>"+$("#roles option:selected").html()+"</td>";
	content += "<td>"+document.getElementById("tarea").value+"</td>";
	content += "<td><button onclick='quitar("+document.getElementById("roles").value+", "+0+");'>Quitar</button></td></tr>";
	document.getElementById("cont_roles_tareas").innerHTML += content;
}

function read_tarea_rol(){
	alert(document.getElementById("tarea").options);
	var content = "<tr id='ext_"+document.getElementById("tarea").value+"' valor='"+document.getElementById("tarea").value+"'><td>"+$("#tarea option:selected").html()+"</td>";
	content += "<td><button onclick='quitar("+document.getElementById("tarea").value+", "+0+");'>Quitar</button></td></tr>";
	document.getElementById("cont_tarea").innerHTML += content;
}

function read_tarea_act_edit(id_rol, nom_tarea){
	var content = "<tr id='ext_"+id_rol+"' valor='"+id_rol+","+nom_tarea+"'><td>"+$("#roles option[value='"+id_rol+"']").text()+"</td>";
	content += "<td>"+nom_tarea+"</td>";
	content += "<td><button onclick='quitar("+id_rol+", \""+nom_tarea+"\");'>Quitar</button></td></tr>";
	
	document.getElementById("cont_roles_tareas").innerHTML += content;
}
function unirActividadesValor(){
	var returnVal = '{"act_p":[';
	$("#act_p #cont tr").each(function(index){
		returnVal += '{';
		returnVal += '"idObj":'+$(this).attr("idObj");
		returnVal += ',"rolID":'+$($(this).children()[0]).html();
		returnVal += ',"actID":'+$($(this).children()[4]).html();
		if ($("#form_proyecto_view").length) {
			returnVal += ',"costo_fac":'+$($($(this).children()[10]).children()[0]).val();			
		}else{
			returnVal += ',"horas":'+$($($(this).children()[6]).children()[0]).val();
			returnVal += ',"costo":'+$($(this).children()[7]).html();
		}
		returnVal += '}';
		if (index != $(this).parent().children().length-1) {
			returnVal += ',';
		}
	});
	returnVal += '],';
	returnVal += '"act_s":[';
	$("#act_s #cont tr").each(function(index){
		returnVal += '{';
		returnVal += '"idObj":'+$(this).attr("idObj");
		returnVal += ',"rolID":'+$($(this).children()[0]).html();
		returnVal += ',"actID":'+$($(this).children()[4]).html();
		if ($("#form_proyecto_view").length) {
			returnVal += ',"costo_fac":'+$($($(this).children()[10]).children()[0]).val();			
		}else{
			returnVal += ',"horas":'+$($($(this).children()[6]).children()[0]).val();
			returnVal += ',"costo":'+$($(this).children()[7]).html();
		}
		returnVal += '}';
		if (index != $(this).parent().children().length-1) {
			returnVal += ",";
		}
	});
	returnVal += ']}';
	console.log(returnVal);
	return returnVal;
}
function unirTercerosValor(){
	var returnVal = '{"ter_p":[';
	$("#ter_p #cont tr").each(function(index){
		returnVal += '{';
		returnVal += '"idObj":'+$(this).attr("idObj");
		returnVal += ',"nombre":"'+$($(this).children()[0]).html()+'"';
		returnVal += ',"costo":'+$($($(this).children()[1]).children()[0]).val();
		returnVal += '}';
		if (index != $(this).parent().children().length-1) {
			returnVal += ',';
		}
	});
	returnVal += '],';
	returnVal += '"ter_s":[';
	$("#ter_s #cont tr").each(function(index){
		returnVal += '{';
		returnVal += '"idObj":'+$(this).attr("idObj");
		returnVal += ',"nombre":"'+$($(this).children()[0]).html()+'"';
		returnVal += ',"costo":'+$($($(this).children()[1]).children()[0]).val();
		returnVal += '}';
		if (index != $(this).parent().children().length-1) {
			returnVal += ',';
		}
	});
	returnVal += ']}';
	return returnVal;
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
function read_list_act_x_rol(baseUrl, idRol){
	$.ajax({
		type: "POST",
		url: baseUrl+"actividad/read_list_act_x_rol/"+idRol,
		datatype: "html",
		success: function(data) {
			$("#act").html(data);
		}
	});
}
function cargar_Plantilla(param_ruta, param_ruta2){
	$("#act_p #cont").html("");
	$("#act_s #cont").html("");
	$("#ter_p #cont").html("");
	$("#ter_s #cont").html("");
	read_pcp(param_ruta, $("#plantillas").val(), param_ruta2, 0);
}