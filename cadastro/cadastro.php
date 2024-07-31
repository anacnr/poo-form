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
    die("Conexão não realizada." + $mysql->connect_error);
}
else{

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        if(!empty($_POST['user-name']) && !empty($_POST['user-cpf'])){
             $_SESSION['user-name'] = $_POST['user-name'];
             $_SESSION['user-cpf'] = $_POST['user-cpf'];


            class User {

                protected $name;
                protected $cpf;

                public function setDates($mysql){
                    $this->name = $_SESSION['user-name'];

                    $this->cpf = $_SESSION['user-cpf'];


                    $insert = "insert into register (name,cpf) values (?,?)";

                    $security = mysqli_stmt_init($mysql);

                    mysqli_stmt_prepare($security,$insert);

                    $cpf_filter = str_replace(['.','-'],'',$this->cpf);

                    $cpf_split = str_split($cpf_filter);

                    $sum = 0;
                    $cpf_calc1 = 10;
                    
                    // Calcula o primeiro dígito verificador
                    for ($count1 = 0; $count1 < 9; $count1++) {
                        $cpf_int = intval($cpf_split[$count1]); // Converte string para número int
                        $sum += $cpf_int * $cpf_calc1;
                        $cpf_calc1 -= 1;
                    }
                    
                    $total1 = $sum % 11;
                    
                    if ($total1 < 2) {
                        $cpf_digit1 = 0;
                    } else {
                        $cpf_digit1 = 11 - $total1;
                    }
                    
                    // Reseta $sum para o cálculo do segundo dígito verificador
                    $sum = 0;
                    $cpf_calc2 = 11;
                    
                    // Calcula o segundo dígito verificador, incluindo o primeiro dígito verificador
                    for ($count2 = 0; $count2 < 10; $count2++) {
                        $cpf_int = intval($cpf_split[$count2]);
                        $sum += $cpf_int * $cpf_calc2;
                        $cpf_calc2 -= 1;
                    }
                    
                    $total2 = $sum % 11;
                    
                    if ($total2 < 2) {
                        $cpf_digit2 = 0;
                    } else {
                        $cpf_digit2 = 11 - $total2;
                    }
                    
                    if ($cpf_split[9] == $cpf_digit1 && $cpf_split[10] == $cpf_digit2) {

                        mysqli_stmt_bind_param($security,'ss', $this->name, $cpf_filter);
                        
                        echo "CPF válido! Digito 1: " . $cpf_digit1 . " Digito 2: " . $cpf_digit2;
                    } else {
                        echo "CPF inválido! Digito 1: " . $cpf_digit1 . " Digito-entrada: " . $cpf_split[9] . " Digito 2: " . $cpf_digit2 . " Digito-entrada: " . $cpf_split[10];
                    }
                    
                    /*
                   mysqli_stmt_execute($security);

                   mysqli_stmt_close($security);*/
                    
                }

            }

            $user = new User();
            $user->setDates($mysql);
            
        }
        else{
            "Campos vazios";
        }
    }
    else{
        echo "";
    }
}

?>