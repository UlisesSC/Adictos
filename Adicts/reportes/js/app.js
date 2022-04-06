var g1label=[];
var g1value=[];

var g2label=[];
var g2color=[];
var g2value=[];

var g3label=[];
var g3value=[];
//capturamos el cambio de fecha de los inputs
$(".fecha").change(function(event){
    //validamos que la fecha de incio sea menor que la de fin
    let inicio=$("#inicio").val().split("-");
    let fin=$("#fin").val().split("-");

    let fecha1 = new Date(inicio[0], inicio[1], inicio[2]); 
    let fecha2 = new Date(fin[0], fin[1], fin[2]); 
    if (fecha1.getTime() > fecha2.getTime()){
        $("#error").slideDown();             
        $("#error").html("Error la fecha de inicio debe de ser menor igual a la fecha de fin");
    }else{
        $("#error").slideUp(); 
        obtenerInfo();
    }
});
$(document).ready(function(){
    obtenerInfo();
});
function obtenerInfo(){
    //obtener vantas totales
    $.post( "data.php", $( "#rango" ).serialize(),function( data ) {
        let info=jQuery.parseJSON(data);
        $("#ventas").html(info.ventas);
        
        g1label=[];
        g1value=[];
        for(i=0;i<info.ticket.length;i++){
            g1label.push(info.ticket[i].fecha);
            g1value.push(info.ticket[i].total);
        }
        cargargrafica1();

        g2label=[];
        g2value=[];
        for(i=0;i<info.ticket.length;i++){
            g2label.push(info.ticket[i].fecha);
            let c=generateRandomCode();
            g2color.push(c);
            g2value.push(info.ticket[i].total);
            $("#lista").append(' <span class="mr-2"><i class="fas fa-circle" style="color:'+c+';"></i>'+info.ticket[i].fecha+'</span>');
        }
        cargargrafica2();

        g3label=[];
        g3value=[];
        for(i=0;i<info.ticket.length;i++){
            g3label.push(info.ticket[i].fecha);
            g3value.push(info.ticket[i].total);
        }
        cargargrafica3();



    });

}
function generateRandomCode() {
    let simbolos = "0123456789ABCDEF";
    let color = "#";

    for(var i = 0; i < 6; i++){
        color = color + simbolos[Math.floor(Math.random() * 16)];
    }
    return color;
}