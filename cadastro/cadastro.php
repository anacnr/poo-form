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

                    $cpf_int = intval($cpf_filter);

                    $cpf_split = str_split($cpf_int);

                    foreach($cpf_split as $position => $cpf_split){
                        /*Fazer os calculos, IA está ajudando*/
                    }

                    mysqli_stmt_bind_param($security,'ss', $this->name, $cpf_int);

                    mysqli_stmt_execute($security);

                    echo "Cadastro feito";

                    mysqli_stmt_close($security);
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