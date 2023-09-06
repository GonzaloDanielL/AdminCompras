document.addEventListener("DOMContentLoaded", function(){
    let ID = [];
    let reportelink = document.getElementById("reporte-link");
    let registrolink = document.getElementById("registro-link");
    let graficolink = document.getElementById("grafico-link");

    $("*").each(function() {
        if (this.id) {
            ID.push(this.id);
        }
    });

    if(ID.includes("contenedor-reporte-principal")) {
        reportelink.style.color = "#2971DE";

    }else if(ID.includes("contenedor-grafico-principal")) {
        graficolink.style.color = "#2971DE";

    }else if(ID.includes("contenedor-registro-principal")) {
        registrolink.style.color = "#2971DE";
    }

});