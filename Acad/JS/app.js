/**
 * MENU SECUNDÁRIO
 */
 var menuDoc = document.getElementsByClassName('item-nav')[0];
 var listSecond = document.querySelector('.item-nav');
 var teste = listSecond.classList;
 
 menuDoc.addEventListener('click', function(){
 
     listSecond.classList.toggle('hide');
     menuDoc.classList.toggle('arrow');
     
 });
 
 /*
  ACIONAMENTO DO MENU
  */
 
  var iconMenu = document.querySelector(".icon-menu");

  var content = document.querySelector(".content");
  
  let body = document.querySelector("body");
 
  iconMenu.addEventListener("click", function(){
 
     body.classList.toggle("__move");
  });
 

 /*
  RECOLHIMENTO DO MENU
  CLICANDO NO CONTENT
 */
 
 content.addEventListener("click",function(){
     body.classList.remove("__move");
 })
 

 /*
 MENU ATIVO - INSERINDO A CLASS ACTIVE
 */
 
 let linkNavs = document.querySelectorAll(".link-nav");
 linkNavs.forEach(function(valorCorrente, index, array){
 
     valorCorrente.addEventListener("click", function(){
         for(let i = 0; i < linkNavs.length; i++){
             array[i].classList.remove("active");
         }
 
         valorCorrente.classList.add("active");
     });
 });

function pesquisar(){
    var input,filtro,menu,menuItens,links;
    input = document.getElementById("pesquisa")
    filtro = input.value.toUpperCase();

}