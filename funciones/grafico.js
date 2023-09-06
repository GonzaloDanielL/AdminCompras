function GraficoAcumulativoMes(){
	let valores = [];

	let fecha = document.querySelector(".fechaactual").value;

	for (var i = 0; i < 12 ; i++) {
		valores.push(parseFloat(document.querySelectorAll(".monto")[i].value));
	  }
	  var data = [{
		x: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
		y: valores,
		type: "bar",
		text: valores.map(String),
		marker:{
			color: ['rgba(204,204,204,1)', 'rgba(204,204,204,1)', 'rgba(204,204,204,1)']
		  },

		marker: {
			color: 'rgb(0,250,154)',
			opacity: 0.6,
			line: {
			  color: 'rgb(8,48,107)',
			  width: 1.5
			}
		  }
	  }];
	  var config = {responsive: true}

	  var layout = {
		title: "Año "+fecha,
		barmode: 'stack',
	  };

	  Plotly.newPlot("grafico-acumulativo-mes",data, layout, config);
}

function GraficoAcumulativoEmpresa(){
	let fecha = document.querySelector(".fechaactual").value;
	let parametros = [];
	let valores = [];

	for (var i = 0; i < document.querySelectorAll('.parametro1').length ; i++) {
		parametros.push(document.querySelectorAll('.parametro1')[i].value);
		valores.push(parseFloat(document.querySelectorAll(".valor1")[i].value));
	  }

	  var data = [{
		x: parametros,
		y: valores,
		type: "bar",
		text: valores.map(String),
		marker:{
			color: ['rgba(204,204,204,1)', 'rgba(204,204,204,1)', 'rgba(204,204,204,1)']
		  },

		marker: {
			color: 'rgb(0,255,255)',
			opacity: 0.6,
			line: {
			  color: 'rgb(8,48,107)',
			  width: 1.5
			}
		  }
	  }];

	  var layout = {
		title: "Año "+fecha,
		barmode: 'stack',
	  };

	  var config = {responsive: true}

	  Plotly.newPlot("grafico-acumulativo-empresa",data, layout, config);
}

function graficoEmpresaPieMes(){
	let fecha = document.querySelector(".fechaactual").value;
	let parametros = [];
	let valores = [];

	for (var i = 0; i < document.querySelectorAll('.parametro2').length ; i++) {
		parametros.push(document.querySelectorAll('.parametro2')[i].value);
		valores.push(parseFloat(document.querySelectorAll(".valor2")[i].value));
	  }

	var data = [{
		values: valores,
		labels: parametros,
		type: 'pie'
	  }];
	  
	  var layout = {
		title: 'Gastos x empresa del mes actual',
		height: 450,
		width: 420
	  };

	  var config = {responsive: true}
	  
	  Plotly.newPlot("grafico-acumulativo-empresa-mes",data, layout, config);
}

function graficoEmpresaPieanual(){
	let fecha = document.querySelector(".fechaactual").value;
	let parametros = [];
	let valores = [];

	for (var i = 0; i < document.querySelectorAll('.parametro3').length ; i++) {
		parametros.push(document.querySelectorAll('.parametro3')[i].value);
		valores.push(parseFloat(document.querySelectorAll(".valor3")[i].value));
	  }

	var data = [{
		values: valores,
		labels: parametros,
		type: 'pie'
	  }];
	  
	  var layout = {
		title: 'Gastos x empresa del año actual',
		height: 450,
		width: 420
	  };
	  var config = {responsive: true}
	  
	  
	  Plotly.newPlot("grafico-acumulativo-empresa-año",data, layout,config);
}

function graficoEmpresaPieanualmensual(){
	let valores = [];

	let fecha = document.querySelector(".fechaactual").value;

	for (var i = 0; i < 12 ; i++) {
		valores.push(parseFloat(document.querySelectorAll(".monto")[i].value));
	  }

	var data = [{
		values: valores,
		labels: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
		type: 'pie'
	  }];
	  
	  var layout = {
		title: 'Gastos x mes del año actual',
		height: 450,
		width: 420
	  };

	  var config = {responsive: true}
	  
	  Plotly.newPlot("grafico-acumulativo-gastos-año",data, layout,config);
}

document.addEventListener("DOMContentLoaded", function() {
	GraficoAcumulativoMes();
	GraficoAcumulativoEmpresa();
	graficoEmpresaPieMes();
	graficoEmpresaPieanual();
	graficoEmpresaPieanualmensual();
});