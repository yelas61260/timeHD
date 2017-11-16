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
			strDAtos["cap"] = $("#act_p #val_contribucion").val();
			strDAtos["cas"] = $("#act_s #val_contribucion").val();
			strDAtos["ctp"] = $("#ter_p #val_contribucion").val();
			strDAtos["cts"] = $("#ter_s #val_contribucion").val();
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
			strDAtos["cap"] = $("#act_p #val_contribucion").val();
			strDAtos["cas"] = $("#act_s #val_contribucion").val();
			strDAtos["ctp"] = $("#ter_p #val_contribucion").val();
			strDAtos["cts"] = $("#ter_s #val_contribucion").val();
		}else if(param_formName=="form_proyecto_view"){
			strDAtos["terceros"] = unirTercerosValor();
		}
		if(datosExtra != ""){
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
		console.log(strDAtos);
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
			var cellRol = $("<td class='col_id'>");
			cellRol.html($("#rol").val());
			filaTemp.append(cellRol);
			var cellRolName = $("<td>");
			cellRolName.html($("#rol option:selected").text());
			filaTemp.append(cellRolName);
			datosArray = data.split("|");
			for(i=0; i<datosArray.length; i++){
				var cellTemp = $("<td>");
				cellTemp.html(datosArray[i]);
				if (i==0 || i==2) {
					cellTemp.addClass('col_id');
				}
				filaTemp.append(cellTemp);
			}
			var cellHora = $("<td>");
			cellHora.html("<input type='text' size='10' value='0' onkeyup='totales_tabla_tiempo_costo();if(event.keyCode == 13) calcularAct(\""+param_ruta+"\", this);'/>");
			filaTemp.append(cellHora);
			filaTemp.append($("<td>").html("0"));
			filaTemp.append($("<td>").html("<button class='button_form' onclick='removeElement(this);'>Quitar</button>"));

			$('#'+param_table).append(filaTemp);
			totales_tabla_tiempo_costo();
		}
	});
}
function read_tercero_cotizacion(param_ruta, param_table){
	var filaTemp = $("<tr>");
	filaTemp.attr("idObj", "0");
	filaTemp.append($("<td>").html($("#ter").val()));
	filaTemp.append($("<td>").html("<input type='text' size='10' value='0' onkeyup='totales_tabla_tiempo_costo();'/>"));
	filaTemp.append($("<td>").html("<button class='button_form' onclick='removeElement(this);'>Quitar</button>"));
	$("#"+param_table).append(filaTemp);
	totales_tabla_tiempo_costo();
}
function removeElement(param_obj){
	if($(param_obj).parent().parent().attr("idObj") != "0"){
		var listaBorrar = $(param_obj).parent().parent().parent().parent().attr("borrar");
		listaBorrar += ","+$(param_obj).parent().parent().attr("idObj");
		$(param_obj).parent().parent().parent().parent().attr("borrar",listaBorrar);
	}
	$(param_obj).parent().parent().remove();
	totales_tabla_tiempo_costo();
}
function read_pcp(param_ruta, id, param_ruta2, notFrame = 1, frame = 'form_proyecto'){
	$.ajax({
		type: "POST",
		url: param_ruta+"/jread",
		datatype: "html",
		data: "id="+id,
		success: function(data) {
			console.log(data);
			var datosJSON = jQuery.parseJSON(data+"");
			console.log(datosJSON);
			if (notFrame != 0) {
				var posForm = 0;
				jQuery.each(datosJSON["datos"], function(i, val){
					if(val != ""){
						document.forms[frame][i].value = val;
						posForm++;
					}
				});
				if (notFrame==1 && datosJSON["contr"] != undefined) {
					$("#act_p #val_contribucion").val(datosJSON["contr"]["cap"]);
					$("#act_s #val_contribucion").val(datosJSON["contr"]["cas"]);
					$("#ter_p #val_contribucion").val(datosJSON["contr"]["ctp"]);
					$("#ter_s #val_contribucion").val(datosJSON["contr"]["cts"]);
				}else if (notFrame == 2) {
					$("#act_p #val_contribucion").html(datosJSON["contr"]["cap"]);
					$("#act_s #val_contribucion").html(datosJSON["contr"]["cas"]);
					$("#ter_p #val_contribucion").html(datosJSON["contr"]["ctp"]);
					$("#ter_s #val_contribucion").html(datosJSON["contr"]["cts"]);
				}
			}
			jQuery.each(datosJSON["act_p"], function(i, val){
				console.log(val);
				var filaTemp = $("<tr>");
				if(notFrame != 0){
					filaTemp.attr("idObj", val["idObj"]);
				}else{
					filaTemp.attr("idObj", 0);
				}
				filaTemp.append($("<td class='col_id'>").html(val["idRol"]));
				filaTemp.append($("<td>").html(val["nombreRol"]));
				filaTemp.append($("<td class='col_id'>").html(val["faseN"]));
				filaTemp.append($("<td>").html(val["fase"]));
				filaTemp.append($("<td class='col_id'>").html(val["actN"]));
				filaTemp.append($("<td>").html(val["actividad"]));
				if (notFrame == 2) {
					filaTemp.append($("<td class='cell_time'>").html(val["tiempo_est"]));
					filaTemp.append($("<td class='cell_time'>").html(val["tiempo_fac"]));
					filaTemp.append($("<td class='cell_number'>").html(formatMoneda(val["costo_est"])));
					filaTemp.append($("<td class='cell_number'>").html(formatMoneda(val["costo_fac"])));
				}else if(notFrame == 0){
					filaTemp.append($("<td class='cell_time'>").html("<input type='text' size='10' value='"+Math.ceil(val["tiempo"]*$("#duracion_est").val()/60)+"' onkeyup='totales_tabla_tiempo_costo();if(event.keyCode == 13) calcularAct(\""+param_ruta2+"\", this);'/>"));
					filaTemp.append($("<td class='cell_number'>").html("0"));
					filaTemp.append($("<td>").html("<button class='button_form' onclick='removeElement(this);'>Quitar</button>"));
				}else{
					filaTemp.append($("<td class='cell_time'>").html("<input type='text' size='10' value='"+(val["tiempo"])+"' onkeyup='totales_tabla_tiempo_costo();if(event.keyCode == 13) calcularAct(\""+param_ruta2+"\", this);'/>"));
					filaTemp.append($("<td class='cell_number'>").html("0"));
					filaTemp.append($("<td>").html("<button class='button_form' onclick='removeElement(this);'>Quitar</button>"));
				}
				$("#act_p").append(filaTemp);
				if (notFrame != 2) {
					calcularAct(param_ruta2, $($(filaTemp).children()[6]).children()[0]);
				}
			});
			jQuery.each(datosJSON["act_s"], function(i, val){
				var filaTemp = $("<tr>");
				if(notFrame != 0){
					filaTemp.attr("idObj", val["idObj"]);
				}else{
					filaTemp.attr("idObj", 0);
				}
				filaTemp.append($("<td class='col_id'>").html(val["idRol"]));
				filaTemp.append($("<td>").html(val["nombreRol"]));
				filaTemp.append($("<td class='col_id'>").html(val["faseN"]));
				filaTemp.append($("<td>").html(val["fase"]));
				filaTemp.append($("<td class='col_id'>").html(val["actN"]));
				filaTemp.append($("<td>").html(val["actividad"]));
				if (notFrame == 2) {
					filaTemp.append($("<td class='cell_time'>").html(val["tiempo_est"]));
					filaTemp.append($("<td class='cell_time'>").html(val["tiempo_fac"]));
					filaTemp.append($("<td class='cell_number'>").html(formatMoneda(val["costo_est"])));
					filaTemp.append($("<td class='cell_number'>").html(formatMoneda(val["costo_fac"])));
				}else if(notFrame == 0){
					filaTemp.append($("<td class='cell_time'>").html("<input type='text' size='10' value='"+Math.ceil(val["tiempo"]*$("#duracion_est").val()/60)+"' onkeyup='totales_tabla_tiempo_costo();if(event.keyCode == 13) calcularAct(\""+param_ruta2+"\", this);'/>"));
					filaTemp.append($("<td class='cell_number'>").html("0"));
					filaTemp.append($("<td>").html("<button class='button_form' onclick='removeElement(this);'>Quitar</button>"));
				}else{
					filaTemp.append($("<td class='cell_time'>").html("<input type='text' size='10' value='"+(val["tiempo"])+"' onkeyup='totales_tabla_tiempo_costo();if(event.keyCode == 13) calcularAct(\""+param_ruta2+"\", this);'/>"));
					filaTemp.append($("<td class='cell_number'>").html("0"));
					filaTemp.append($("<td>").html("<button class='button_form' onclick='removeElement(this);'>Quitar</button>"));
				}
				$("#act_s").append(filaTemp);
				if (notFrame != 2) {
					calcularAct(param_ruta2, $($(filaTemp).children()[6]).children()[0]);
				}
			});

			jQuery.each(datosJSON["ter_p"], function(i, val){
				var filaTemp = $("<tr>");
				if(notFrame != 0){
					filaTemp.attr("idObj", val["id"]);
				}else{
					filaTemp.attr("idObj", 0);
				}
				filaTemp.append($("<td>").html(val["nombre"]));
				filaTemp.append($("<td>").html("<input type='text' size='10' value='"+val["costo"]+"' onkeyup='totales_tabla_tiempo_costo();'/>"));
				if (notFrame==2) {
					filaTemp.append($("<td>").html("<input type='text' size='10' value='"+val["costo_real"]+"' onkeyup='totales_tabla_tiempo_costo();'/>"));
				}
				filaTemp.append($("<td>").html("<button class='button_form' onclick='removeElement(this);'>Quitar</button>"));
				$("#ter_p").append(filaTemp);
			});
			jQuery.each(datosJSON["ter_s"], function(i, val){
				var filaTemp = $("<tr>");
				if(notFrame != 0){
					filaTemp.attr("idObj", val["id"]);
				}else{
					filaTemp.attr("idObj", 0);
				}
				filaTemp.append($("<td>").html(val["nombre"]));
				filaTemp.append($("<td>").html("<input type='text' size='10' value='"+val["costo"]+"' onkeyup='totales_tabla_tiempo_costo();'/>"));
				if (notFrame==2) {
					filaTemp.append($("<td>").html("<input type='text' size='10' value='"+val["costo_real"]+"' onkeyup='totales_tabla_tiempo_costo();'/>"));
				}
				filaTemp.append($("<td>").html("<button class='button_form' onclick='removeElement(this);'>Quitar</button>"));
				$("#ter_s").append(filaTemp);
			});
			totales_tabla_tiempo_costo();

			if (notFrame != 0) {
				document.getElementById("enviar_btn").onclick = function(){update(param_ruta,frame);};
			}
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
			console.log(data);
			$($(param_obj).parent().parent().children()[7]).html(formatMoneda(parseInt(data)*$(param_obj).val()));
			totales_tabla_tiempo_costo();
		}
	});
}
function sumar_tiempo(param_fecha1,param_fecha2){
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
	content += "<td><button class='button_form' onclick='quitar("+document.getElementById("rol").value+", "+0+");'>Quitar</button></td></tr>";
	document.getElementById("cont_roles").innerHTML += content;
}
function read_roles_usuario_edit(id_rol, id_prin){
	var content = "<tr id='ext_"+id_rol+"' valor='"+id_rol+"'><td>"+$("#rol option[value='"+id_rol+"']").text()+"</td>";
	content += "<td><button class='button_form' onclick='quitar("+id_rol+", "+id_prin+");'>Quitar</button></td></tr>";
	document.getElementById("cont_roles").innerHTML += content;
}

function read_tarea_act(){
	var content = "<tr id='ext_"+document.getElementById("roles").value+"' valor='"+document.getElementById("roles").value+","+document.getElementById("tarea").value+"'><td>"+$("#roles option:selected").html()+"</td>";
	content += "<td>"+document.getElementById("tarea").value+"</td>";
	content += "<td><button class='button_form' onclick='quitar("+document.getElementById("roles").value+", "+0+");'>Quitar</button></td></tr>";
	document.getElementById("cont_roles_tareas").innerHTML += content;
}

function read_tarea_rol(){
	var content = "<tr id='ext_"+document.getElementById("tarea").value+"' valor='"+document.getElementById("tarea").value+"'><td>"+$("#tarea option:selected").html()+"</td>";
	content += "<td><button class='button_form' onclick='quitar("+document.getElementById("tarea").value+", "+0+");'>Quitar</button></td></tr>";
	document.getElementById("cont_tarea").innerHTML += content;
}

function read_tarea_rol_edit(idTarea, nameTarea, idRol){
	var content = "<tr id='ext_"+idTarea+"' valor='"+idTarea+"'><td>"+nameTarea+"</td>";
	content += "<td><button class='button_form' onclick='quitar("+idTarea+", "+idRol+");'>Quitar</button></td></tr>";
	document.getElementById("cont_tarea").innerHTML += content;
}

function read_tarea_act_edit(id_rol, nom_tarea){
	var content = "<tr id='ext_"+id_rol+"' valor='"+id_rol+","+nom_tarea+"'><td>"+$("#roles option[value='"+id_rol+"']").text()+"</td>";
	content += "<td>"+nom_tarea+"</td>";
	content += "<td><button class='button_form' onclick='quitar("+id_rol+", \""+nom_tarea+"\");'>Quitar</button></td></tr>";
	
	document.getElementById("cont_roles_tareas").innerHTML += content;
}
function unirActividadesValor(){
	var returnVal = '{"act_p":[';
	$("#act_p #cont tr").each(function(index){
		returnVal += '{';
		returnVal += '"idObj":'+$(this).attr("idObj");
		returnVal += ',"rolID":'+$($(this).children()[0]).html();
		returnVal += ',"actID":'+$($(this).children()[4]).html();
		returnVal += ',"horas":'+$($($(this).children()[6]).children()[0]).val();
		returnVal += ',"costo":'+$($(this).children()[7]).html().split(".").join("");
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
		returnVal += ',"horas":'+$($($(this).children()[6]).children()[0]).val();
		returnVal += ',"costo":'+$($(this).children()[7]).html().split(".").join("");
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
		returnVal += ',"costo":'+$($($(this).children()[1]).children()[0]).val().split(".").join("");
		if ($($($(this).children()[2]).children()[0]).is("input")) {
			returnVal += ',"costo_real":'+$($($(this).children()[2]).children()[0]).val().split(".").join("");
		}else{
			returnVal += ',"costo_real":0';
		}
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
		returnVal += ',"costo":'+$($($(this).children()[1]).children()[0]).val().split(".").join("");
		if ($($($(this).children()[2]).children()[0]).is("input")) {
			returnVal += ',"costo_real":'+$($($(this).children()[2]).children()[0]).val().split(".").join("");
		}else{
			returnVal += ',"costo_real":0';
		}
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
				console.log(data);
			}
		});
	}
	totales_tabla_tiempo_costo();
}
function totales_tabla_tiempo_costo(){
	if($("#form_proyecto").length){
		var total_tiempo_esti = "00:00:00";
		var total_costo_esti = 0;

		jQuery.each($("#act_p #cont tr"), function(i, val){
			total_tiempo_esti = sumar_tiempo($($($(val).children()[6]).children()[0]).val()+":00:00", total_tiempo_esti);
			total_costo_esti = parseInt($($(val).children()[7]).html().split(".").join("")) + total_costo_esti;
		});
		$("#act_p #total_tiempo").html(total_tiempo_esti);
		$("#act_p #total_costo").html(formatMoneda(total_costo_esti));

		total_tiempo_esti = "00:00:00";
		total_costo_esti = 0;
		jQuery.each($("#act_s #cont tr"), function(i, val){
			total_tiempo_esti = sumar_tiempo($($($(val).children()[6]).children()[0]).val()+":00:00", total_tiempo_esti);
			total_costo_esti = parseInt($($(val).children()[7]).html().split(".").join("")) + total_costo_esti;
		});
		$("#act_s #total_tiempo").html(total_tiempo_esti);
		$("#act_s #total_costo").html(formatMoneda(total_costo_esti));

		var total_tercero = 0;
		jQuery.each($("#ter_p #cont tr"), function(i, val){
			total_tercero = parseInt($($($(val).children()[1]).children()[0]).val().split(".").join("")) + total_tercero;
		});
		$("#ter_p #total_costo").html(formatMoneda(total_tercero));

		total_tercero = 0;
		jQuery.each($("#ter_s #cont tr"), function(i, val){
			total_tercero = parseInt($($($(val).children()[1]).children()[0]).val().split(".").join("")) + total_tercero;
		});
		$("#ter_s #total_costo").html(formatMoneda(total_tercero));
	}else if($("#form_proyecto_view").length){
		var total_tiempo_esti = "00:00:00";
		var total_costo_esti = 0;
		var total_tiempo_prod = "00:00:00";
		var total_costo_prod = 0;

		jQuery.each($("#act_p #cont tr"), function(i, val){
			total_tiempo_esti = sumar_tiempo($($(val).children()[6]).html()+"", total_tiempo_esti);
			total_costo_esti = parseInt($($(val).children()[8]).html().split(".").join("")) + total_costo_esti;
		});
		$("#act_p #total_tiempo_est").html(total_tiempo_esti);
		$("#act_p #total_costo_est").html(formatMoneda(total_costo_esti));

		jQuery.each($("#act_p #cont tr"), function(i, val){
			total_tiempo_prod = sumar_tiempo($($(val).children()[7]).html()+"", total_tiempo_prod);
			total_costo_prod = parseInt($($(val).children()[9]).html().split(".").join("")) + total_costo_prod;
		});
		$("#act_p #total_tiempo").html(total_tiempo_prod);
		$("#act_p #total_costo").html(formatMoneda(total_costo_prod));

//////////////////////////////////////////////////////////////////
		total_tiempo_esti = "00:00:00";
		total_costo_esti = 0;
		total_tiempo_prod = "00:00:00";
		total_costo_prod = 0;
		jQuery.each($("#act_s #cont tr"), function(i, val){
			total_tiempo_esti = sumar_tiempo($($(val).children()[6]).html()+"", total_tiempo_esti);
			total_costo_esti = parseInt($($(val).children()[8]).html().split(".").join("")) + total_costo_esti;
		});
		$("#act_s #total_tiempo_est").html(total_tiempo_esti);
		$("#act_s #total_costo_est").html(formatMoneda(total_costo_esti));

		jQuery.each($("#act_s #cont tr"), function(i, val){
			total_tiempo_prod = sumar_tiempo($($(val).children()[7]).html()+"", total_tiempo_prod);
			total_costo_prod = parseInt($($(val).children()[9]).html().split(".").join("")) + total_costo_prod;
		});
		$("#act_s #total_tiempo").html(total_tiempo_prod);
		$("#act_s #total_costo").html(formatMoneda(total_costo_prod));

///////////////////////////////////////////////////////////////////
		var total_tercero = 0;
		var total_tercero_real = 0;
		jQuery.each($("#ter_p #cont tr"), function(i, val){
			total_tercero = parseInt($($($(val).children()[1]).children()[0]).val().split(".").join("")) + total_tercero;
			total_tercero_real = parseInt($($($(val).children()[2]).children()[0]).val().split(".").join("")) + total_tercero_real;
		});
		$("#ter_p #total_costo").html(formatMoneda(total_tercero));
		$("#ter_p #total_costo_real").html(formatMoneda(total_tercero_real));

		total_tercero = 0;
		total_tercero_real = 0;
		jQuery.each($("#ter_s #cont tr"), function(i, val){
			total_tercero = parseInt($($($(val).children()[1]).children()[0]).val().split(".").join("")) + total_tercero;
			total_tercero_real = parseInt($($($(val).children()[2]).children()[0]).val().split(".").join("")) + total_tercero_real;
		});
		$("#ter_s #total_costo").html(formatMoneda(total_tercero));
		$("#ter_s #total_costo_real").html(formatMoneda(total_tercero_real));
	}
	if($("#val_contribucion").length){
		calcularContribucion($("#act_p #val_contribucion"));
		calcularContribucion($("#act_s #val_contribucion"));
		calcularContribucion($("#ter_p #val_contribucion"));
		calcularContribucion($("#ter_s #val_contribucion"));
	}
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
function calcularContribucion(param_obj){
	var idtableParent = $(param_obj).parent().parent().parent().parent().attr("id");
	if ($("#form_proyecto").length) {
		$("#"+idtableParent+" #val_precio").html( formatMoneda(parseInt($("#"+idtableParent+" #total_costo").html().split(".").join(""))+Math.round(parseInt($(param_obj).val())*parseInt($("#"+idtableParent+" #total_costo").html().split(".").join(""))/100)) );
	}else if ($("#form_proyecto_view").length) {
		$("#"+idtableParent+" #val_precio").html( formatMoneda(parseInt($("#"+idtableParent+" #total_costo").html().split(".").join(""))+Math.round(parseInt($(param_obj).html())*parseInt($("#"+idtableParent+" #total_costo").html().split(".").join(""))/100)) );
	}
	$("#totales #time1").html($("#act_p #total_tiempo").html());
	$("#totales #time2").html(sumar_tiempo($("#act_p #total_tiempo").html(), $("#act_s #total_tiempo").html()));
	$("#totales #cost1").html($("#act_p #val_precio").html());
	$("#totales #cost2").html(formatMoneda(""+(parseInt($("#act_p #val_precio").html().split(".").join("")) + parseInt($("#act_s #val_precio").html().split(".").join("")))));
	if($("#form_proyecto_view").length){
		$("#totales #time1_est").html($("#act_p #total_tiempo_est").html());
		$("#totales #time2_est").html(sumar_tiempo($("#act_p #total_tiempo_est").html(), $("#act_s #total_tiempo_est").html()));
		$("#totales #cost1_est").html($("#act_p #total_costo_est").html());
		$("#totales #cost2_est").html(formatMoneda(""+(parseInt($("#act_p #total_costo_est").html().split(".").join("")) + parseInt($("#act_s #total_costo_est").html().split(".").join("")))));
	}
}
function formatMoneda(inputStr)
{
	inputStr = inputStr+"";
	var num = inputStr.replace(/\./g,'');
	if(!isNaN(num)){
		num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
		num = num.split('').reverse().join('').replace(/^[\.]/,'');
		inputStr = num;
	}else{
		inputStr = inputStr.replace(/[^\d\.]*/g,'');
	}
	return inputStr;
}
function graficReportColumn(titleParam, subtitleParam, titleyParam, categoriesParam, dataParam, containerParam){
	Highcharts.chart(containerParam, {
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: titleParam
        },
        subtitle: {
            text: subtitleParam
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: categoriesParam
        },
        yAxis: {
            title: {
                text: titleyParam
            }
        },
        series: [{
            name: titleyParam,
            data: dataParam
        }]
    });
}
function graficReportLine(titleParam, subtitleParam, titleyParam, categoriesParam, dataParam, containerParam){
	Highcharts.chart(containerParam, {
        title: {
            text: titleParam,
            x: -20 //center
        },
        subtitle: {
            text: subtitleParam,
            x: -20
        },
        xAxis: {
            categories: categoriesParam
        },
        yAxis: {
            title: {
                text: titleyParam
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: dataParam
    });
}
function graficReportColumnSubrecord(titleParam, subtitleParam, titleyParam, dataParam1, dataParam2, containerParam) {
    Highcharts.chart(containerParam, {
        chart: {
            type: 'column'
        },
        title: {
            text: titleParam
        },
        subtitle: {
            text: subtitleParam
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: titleyParam
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y} minutos'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} minutos</b><br/>'
        },

        series: [{
            name: 'Detalle',
            colorByPoint: true,
            data: dataParam1
        }],
        drilldown: {
            series: dataParam2
        }
    });
}