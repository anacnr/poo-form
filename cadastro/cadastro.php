<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en-usa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="div-form">
        <form action="" method="post">
         <span id="span-name">
             <label for="input-name" id="label-name">Nome:</label>
             <input type="text" id="input-name" name="user-name" minlength="5" maxlength="40" placeholder="Nome">
         </span>
         <span id="span-cpf">
             <label for="input-name" id="label-cpf">Nome:</label>
             <input type="text" id="input-cpf" name="user-cpf" minlength="14" maxlength="14" placeholder="CPF">
         </span>

         <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>

<?php

require('banco/bank.php');

if($mysql->connect_error != null){
    die("Conexão não realizada. \n Erro: " + $mysql->connect_error);
}
else{

    #Verifica se o form está usando o método Post.
    if($_SERVER['REQUEST_METHOD'] == 'POST'){      
        #Verifica se os campos de entrada não estão vazios para passar quem fez o cadastro
        if(!empty($_POST['user-name']) && !empty($_POST['user-cpf'])){ 
            #Se os campos estiverem preenchidos as variáveis superglobais da sessão receberão os dados
             $_SESSION['user-name'] = $_POST['user-name'];
             $_SESSION['user-cpf'] = $_POST['user-cpf'];

            //Criação de um molde para todos os cadastros.
            class User {

                //Atributos
                protected $name;
                protected $cpf;

                //Método público
                public function setDates($mysql){
                    $this->name = $_SESSION['user-name'];
                    $this->cpf = $_SESSION['user-cpf'];

                    //Comando SQL de inserção utilizando Prepared Statements.
                    $insert = "insert into register (name,cpf) values (?,?)";

                    $security = mysqli_stmt_init($mysql);//Inicializa o tratamento e faz o o alocamento dos valores

                    mysqli_stmt_prepare($security,$insert);//Prepara a execução da inserção dos valores

                    $cpf_filter = str_replace(['.','-'],'',$this->cpf);//Remove os caracteres especiais do campo

                    $cpf_split = str_split($cpf_filter);//Picota em pedaço os valores do CPF número por número.

                  /*Incicío do cálculo para validar o CPF
                    Declaração da variável de icremento e o multiplicador*/
                    $sum = 0;
                    $cpf_calc1 = 10;
                    
                    //Loop para calcular os nove primeiros digítos do CPF
                    for ($count1 = 0; $count1 < 9; $count1++) {
                        $cpf_int = intval($cpf_split[$count1]); //Converte string para número int
                        $sum += $cpf_int * $cpf_calc1;//Icremento e multiplicação
                        $cpf_calc1 -= 1;//O cálculo se faz de forma decrescente do 10 até 2 em cada digíto do CPF.
                    }
                    //Depois divide o resultado de sum por 11 e em seguida pega o resto dessa divisão
                    $total1 = $sum % 11;
                    
                    #Verifica se o resto é menor que 11
                    if ($total1 < 2) {
                        $cpf_digit1 = 0;
                    }
                    else {
                        $cpf_digit1 = 11 - $total1;
                    }
                    
                    //Reseta $sum para o cálculo do segundo digito verificador
                    $sum = 0;
                    $cpf_calc2 = 11;
                    
                    //Loop para calcular os dez primeiros digítos do CPF
                    for ($count2 = 0; $count2 < 10; $count2++) {
                        $cpf_int = intval($cpf_split[$count2]);
                        $sum += $cpf_int * $cpf_calc2;
                        $cpf_calc2 -= 1;
                    }
                    
                    $total2 = $sum % 11;
                    
                    if ($total2 < 2) {
                        $cpf_digit2 = 0;
                    } 
                    else {
                        $cpf_digit2 = 11 - $total2;
                    }

                    #Verificação de CPF válido ou inválido
                    if ($cpf_split[9] == $cpf_digit1 && $cpf_split[10] == $cpf_digit2) {
                        
                        echo "CPF válido!";
                        
                        #Atribui a inicialização do P.S., atribui o tipo dos dados e as variáveis que armazenam os dados
                        mysqli_stmt_bind_param($security,'ss', $this->name, $cpf_filter);
                        #Realiza os passos do Prepared Staments.
                        mysqli_stmt_execute($security);
                    } 
                    else {
                        echo "CPF inválido!";
                    }
                   //Finalização do Prepared Statements, o espaço que o PHP utilizou para preparar os dados será liberada.
                   mysqli_stmt_close($security);
                    
                }

            }

            #Instância da classe
            $user = new User();
            #Chama o método de validação dos dados
            $user->setDates($mysql);
            
        }
        else{
            #Caso haja campos sem dados
            "Campos vazios";
        }
    }
    else{
        #Utilizei este else para que o PHP não retorne nada quando a página for carregada no navegador
        echo "";
    }
}

?>