document.addEventListener("DOMContentLoaded", ()=>{
    const url = new URLSearchParams(window.location.search)//Busca o resultado enviado pelo PHP
    const status = url.get('status')//Armazena o resultado enviado pelo PHP

        /*Validação do usuário por parte do Front-end*/
        if(status === 'sucesso'){
            console.log("Acesso cedido");
        }
        else if(status === 'senha-incorreta'){
            console.log("Senha incorreta");
            setTimeout(()=>{
                console.log("Voltar a aprecer os inputs");
            },3000)
        }
        else if(status === 'sem-sucesso'){
            console.log("Usuário não encontrado");
        }
        else{
            console.log("");
            //Fiz assim para o js não emitir nenhuma mensagem
        }
});//Carregamento