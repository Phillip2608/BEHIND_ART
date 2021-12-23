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
        <link rel="shortcut icon" type="imagex/png" href="../imagens/logoBDa.ico">

		<link rel="stylesheet" href="../css/cadlog.css">
		<link rel="stylesheet" href="../css/reset.css">
		
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
        <div class="area_logo">
            <a class="estilo_link" href="../index.php"><img class="logo" src="../imagens/BDapng.png" width=250 height=80></a>
        </div>

		<section class="center">

			<div class="caixa">

				<form action="cad_perfil.php" method="POST">

					<input type="text" name="nm_perfil" class="barra" placeholder="Nome">
					<input type="email" name="nm_email" class="barra" placeholder="E-mail">
					<input type="password" name="id_senha" class="barra" placeholder="Senha">
					<input type="date" name="dt_nascimento" class="barra" placeholder="Data de nascimento">
                    
                    <div class="termos">

                        Ao clicar em Confirmar, você concorda com nossos <br>
                        <em>Termos</em>, 
                        <em>Política de Dados</em> e 
                        <em>Política de Cookies</em>.
                    
                    </div>

                    <input type="submit" name="enviarCad" class="botao" value="CONFIRMAR">

					<div class="ancora">
						
						<a href="loginPerfil.php">Já tenho uma <em>conta</em>.</a>
					
					</div>
			
				</form>
				
			</div>
			
		</section>	

	</body>
</html>