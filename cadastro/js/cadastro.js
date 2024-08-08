document.addEventListener("DOMContentLoaded", ()=>{
console.log("Script carregado2!");
    
const name = document.querySelectorAll('input')[0].value
const cpf = document.querySelectorAll('input')[1].value

//Preciso fazer com que os dados passem pelo front-end primeiro

document.querySelector('button').addEventListener("click", ()=>{
    if(cpf == '123.456.789-10'){
       //console.log("cpf-certo");

    }
    else{
        console.log("cpf-errado");
        document.querySelector('form').addEventListener("submit", (e)=>{
            e.stopPropagation();
        });//Evento do formulário
    }
})

});//Evento de carregamento