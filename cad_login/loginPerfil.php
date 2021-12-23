<?php
    session_start();
    ob_start();
    include_once'../conexao.php';
?>  
<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">

        <title>Behind Art</title>        
        <link rel="stylesheet" href="../css/cadlog.css">
        <link rel="stylesheet" href="../css/reset.css">
        <link rel="shortcut icon" type="imagex/png" href="../imagens/logoBDa.ico">
        
        <!-- Fonte Roboto -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        
        <!-- Fonte Spartan -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@100;400;800&display=swap" rel="stylesheet">
        

        <style>
            .area_logo{
                width:100%;
                display:flex;
                justify-content:center;
                margin-top:5%;
                margin-bottom:3%;
            }

            .estilo_link{
                text-decoration:none ;
            }
        </style>
    </head>
    <body>
        <?php
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $usuario = (isset($_COOKIE['perfil'])) ? $_COOKIE['perfil'] : '';
            
            if (!empty($dados['enviarLogin'])){
                //var_dump($dados);
                $query_usuario = "SELECT id_perfil, nm_perfil, id_senha FROM tb_perfil WHERE nm_perfil =:usuario  LIMIT 1";
                $result_usuario = $con->prepare($query_usuario);
                $result_usuario->bindParam(':usuario', $dados['usuario'], PDO::PARAM_STR);
                $result_usuario->execute();

                if(($result_usuario) AND ($result_usuario->rowCount() != 0)){
                    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                    //var_dump($row_usuario);
                    if(password_verify($dados['senha'], $row_usuario['id_senha'])){
                        $_SESSION['id_perfil'] = $row_usuario['id_perfil'];
                        $_SESSION['nm_perfil'] = $row_usuario['nm_perfil'];
                        if(isset($dados['box'])){
                            setcookie("perfil", $dados['usuario'], (time() + (15 * 24 * 3600)),"/","", false, true);
                        }                        
                        
                        header("Location: ../feed.php");
                    }else{
                        $_SESSION['msg'] = "<p>Erro: Usuário ou senha inválida!</p>";
                        
                    }
                }else{
                   $_SESSION['msg'] = "<p>Erro: Usuário ou senha inválida!</p>";
                }
            }
            
        ?>
        <div class="area_logo">
            <a class="estilo_link" href="../index.php"><img class="logo" src="../imagens/BDapng.png" width=250 height=80></a>
        </div>
        <section class="center">

            <div class="caixa">

                <form action="" method="POST">
                    <?php 
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <input type="text" name="usuario" class="barra" placeholder="E-mail" value="<?php if(isset($dados['usuario'])){echo $dados['usuario'];} echo $usuario; ?>">
                    <input type="password" name="senha" class="barra" placeholder="Senha" value="<?php if(isset($dados['senha'])){echo $dados['senha'];} ?>"><br>
                    <input type="checkbox" name="box" class="box" id="box"><label for="box">Lembrar Usuário</label><br>
                    
                    <input type="submit" name="enviarLogin" class="botao" value="CONFIRMAR">
                    
                    <br>

                    <div class="ancora">

                        <a href="cadastro.php">Não tenho uma <em>conta</em>.</a>

                    </div>
                
                </form>

            </div>

        </section>
            
    </body>
</html>