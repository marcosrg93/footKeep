/* global $ jQuery */
$(document).ready(function() {
 //

 // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
 $('.modal').modal();

 $('.materialboxed').materialbox();

 $('input#input_text, textarea#textarea1').characterCounter();


 // Initialize collapse button
 $(".button-collapse").sideNav();



 getEmail();

 //Formulario de registro
 //Comprobamos el tamaño del texto introducido y le mostramos un mensaje en caso de ser menor que el deseado
 $('#nombreR').on('blur', function() {
  if (!checkTam(this, 2)) {
   $(this).next().next().text('Debe ser mayor de 3 caracteres');
   $(this).next().next().css("color", "red");
  }
  else {
   $(this).next().next().text(' ');
  }
 });

 $('#password3').on('blur', function() {
  if (!checkTam(this, 5)) {
   $(this).next().next().text('Debe ser mayor de 5 caracteres');
   $(this).next().next().css("color", "red");
  }
  else {
   $(this).next().next().text(' ');
  }
 });

 $('#password4').on('blur', function() {
  if ($(this).val() != $('#password3').val()) {
   $(this).next().next().text('La clave no coincide');
   $(this).next().next().css("color", "red");
  }
  else {
   $(this).next().next().text(' ');
  }
 });

 //Formulario edit usuario
 $('#passwordNueva').on('blur', function() {
  if (!checkTam(this, 5)) {
   $(this).next().next().text('Debe ser mayor de 5 caracteres');
   $(this).next().next().css("color", "red");
  }
  else {
   $(this).next().next().text(' ');
  }
 });

 $('#passwordNuevaCopia').on('blur', function() {
  if ($(this).val() != $('#passwordNueva').val()) {
   $(this).next().next().text('La clave no coincide');
   $(this).next().next().css("color", "red");
  }
  else {
   $(this).next().next().text(' ');
  }
 });

 $('#password').on('blur', function() {
  if (!checkTam(this, 5)) {
   $(this).next().next().text('Debe ser mayor de 5 caracteres');
   $(this).next().next().css("color", "red");
  }
  else {
   $(this).next().next().text(' ');
  }
 });

 $('#password2').on('blur', function() {
  if ($(this).val() != $('#password').val()) {
   $(this).next().next().text('La clave no coincide');
   $(this).next().next().css("color", "red");
  }
  else {
   $(this).next().next().text(' ');
  }
 });




 $('#formColor').submit(function(event) {
  var color = $('[name=group1]');
  var correcto = false;
  //Comprobamos la color
  if (!checkRadioB(color)) {
   correcto = true;
  }
  else {
   var id = $("input:checked").attr('id');
   $('#color').val(id);
   correcto = false;
  }


  if (correcto) {
   event.preventDefault();
  }
 });


 setColor();





}); //cierre del .ready



/* buscador*/
function doSearch() {
 var tableReg = document.getElementById('datos');
 var searchText = document.getElementById('searchTerm').value.toLowerCase();
 var cellsOfRow = "";
 var found = false;
 var compareWith = "";

 // Recorremos todas las filas con contenido de la tabla
 for (var i = 1; i < tableReg.rows.length; i++) {
  cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
  found = false;
  // Recorremos todas las celdas
  for (var j = 0; j < cellsOfRow.length && !found; j++) {
   compareWith = cellsOfRow[j].innerHTML.toLowerCase();
   // Buscamos el texto en el contenido de la celda
   if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1)) {
    found = true;
   }
  }
  if (found) {
   tableReg.rows[i].style.display = '';
  }
  else {
   // si no ha encontrado ninguna coincidencia, esconde la
   // fila de la tabla
   tableReg.rows[i].style.display = 'none';
  }
 }
}


/*********************************************** Metodos Externos ********************************************/


//Comprueba radiobt
//Pasandole name
//Devuelve true o false
function checkRadioB(nameRadioB) {
 return $(nameRadioB).is(":checked") ? true : false;
}

//Función que comprueba el tamaño del elemento 
//Pasandole id y tamaño a comprobar
//Devuelve true o false
function checkTam(idText, tam) {
 return $(idText).val().length > tam ? true : false;
}



//Obtenemos el email 
function getEmail() {
 var listElements = $("tr");
 var tdmail = $('td.email');
 $(".activarUsuario").on("click", function(event) {
  //var email2 = $(event.target).closest(listElements).prev().prev().html();
  var email = $(event.target).closest(listElements).find(tdmail).html();
  var res;
  if (!checkRadioB(this)) {


   res = window.location.replace("https://keep-marcosrg.c9users.io/index.php?ruta=admin&accion=cambiarEstado&email=" + email);


  }
  else {

   res = window.location.replace("https://keep-marcosrg.c9users.io/index.php?ruta=admin&accion=cambiarEstado&email=" + email);

  }
  return res;


 });

}



function setColor() {

 $(".card").each(function(indice, elemento) {
  if ($(this).attr('id') == 1) {
   $(elemento).removeClass("blue-grey darken-1").addClass("indigo");
  }

  if ($(this).attr('id') == 2) {
   $(elemento).removeClass("blue-grey darken-1").addClass("yellow");
  }

  if ($(this).attr('id') == 3) {
   $(elemento).removeClass("blue-grey darken-1").addClass("green");
  }

  if ($(this).attr('id') == 4) {
   $(elemento).removeClass("blue-grey darken-1").addClass("red lighten-1");
  }
 })

}
