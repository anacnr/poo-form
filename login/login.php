<?php
//Criar uma sessão para o usuário
session_start();
?>

<!DOCTYPE html>
<html lang="en-usa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div>
        <form action="" method="post">
        <span>
            <label for="nickname">Apelido</label> 
        <input type="text" name="nick" id="nickname">
        </span>
        <span>
            <label for="password">Senha</label>
            <input type="text" name="pass" id="password">
        </span>
        <button type="submit">Enviar</button>
        </form>
    </div>
</body>
<script src="./js/login.js"></script>
</html>

<?php
//Requerimento da conexão do banco
require('../bank/bank.php');

if ($mysql->connect_error != null) {
    die("Conexão não realizada." + $mysql->connect_error);
}
else{

    //Checa se o método da requisição é do tipo post para não ocorrer a declaração precoce de variáveis.
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['nick']) && !empty($_POST['pass'])){

            $_SESSION['nick'] = $_POST['nick'];
            $_SESSION['pass'] = $_POST['pass'];

            class User{

                public  $nickname;
                protected $password;
        
                //Chama as propriedades logo que o objeto é instanciado
                public function  __construct()
                {
                    //Declaração das variáveis dentro da classe                    
                     $this->nickname = $_SESSION['nick'];
                     $this->password = $_SESSION['pass'];
                     
                }
        
                public function toCheck($mysql) {
                //Checa se existe caracteres que podem prejudicar a pesquisa em SQL
                $nickname_check = mysqli_real_escape_string($mysql,$this->nickname);
                $password_check = mysqli_real_escape_string($mysql,$this->password);
        
                $select = 'Select * from astro';
        
                $query = mysqli_query($mysql,$select);
        
                while($row = mysqli_fetch_assoc($query)){
                    if($nickname_check == $row['nickname']){
                        if($password_check == $row['pass']){
        
                            //Credenciais: nickname = aninha & pass = rj2019

                            //Adiciona a data que o usuário fez o login e rastreia o id desse usuário.
                           $insert = "insert into astrologin (id_astro) values ('" . $row['id'] . "')";
                           $mysql->query($insert);
        
                           return 'sucesso';
                        }
                        else{
                            return 'senha-incorreta';
                        }
                    }
                    else{
                        return 'sem-sucesso';
                    }
                }
                
            } 
        }
        
        
        $execute = new User();//Instancia a classe
        $request = $execute->toCheck($mysql);//Chama a  função e passa o seu parâmetro. Esta variável vai passar o resultado do status para o JS
        header("Location: login.php?status=$request");
        exit;
        }
        else{
            echo "Campos vazios. " . $_SESSION['nick'] . $_SESSION['pass'];
        }
    }

}

mysqli_close($mysql); //Fecha a conexão
?>