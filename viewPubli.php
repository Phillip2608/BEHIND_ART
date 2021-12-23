<?php
    session_start();
    ob_start();
    include_once'conexao.php';

    $cod_publi = $_GET['codigo_publi'];    
    $cod_perfil = $_GET['codigo_perfil'];
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Behind Art</title>
    <link rel="shortcut icon" type="imagex/png" href="imagens/logoBDa.ico">
    <!-- Fonte Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;700&display=swap" rel="stylesheet">
        
    <!-- Fonte Spartan -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@100;400;800&display=swap" rel="stylesheet">
    <style>
        *{
            paddin:0;
            margin:0;
            font-family:'Roboto',sans-serif;
            color:#E9E1F0;
        }

        body{
            background-color:#181C27;
        }

        .container_publi{
            width:100%;
        }

        .conteudo_post{
            max-width:65%;
            max-height:85%;
            height:100%;
            width:100%;
            background-color:#C7BDCF;
            position:fixed;
        }

        .coment_post{
            background-color:red;
            max-width:35%;
            width:100%;
        }

        .image_post{
            width:100%;
            height:100%;
            object-fit:scale-down;
        }

        .voltar_feed{
            position:fixed;
            text-align:center;
            text-decoration:none;
            font-size:40px;
            margin-left:2%;
            color:#181C27;
            padding-right:15px;
            padding-left:15px;
            border-radius:100px;
            transition: .3s all;
        }

        .voltar_feed:hover{
            transform:scale(1.1);
            background-color:#E9E1F0;
        }
    </style>
</head>
<body>
    <?php
        $query_perfil = "SELECT nm_perfil, nm_nomeUsuario, im_perfil FROM tb_perfil WHERE id_perfil = :cod_perfil";
        $result_perfil = $con->prepare($query_perfil);
        $result_perfil->bindParam(':cod_perfil', $cod_perfil, PDO::PARAM_STR);
        $result_perfil->execute();
        $row_perfil = $result_perfil->fetch(PDO::FETCH_ASSOC);

        $query_publi = "SELECT * FROM tb_publicacao WHERE id_publicacao = :cod_publi";
        $result_query = $con->prepare($query_publi);
        $result_query->bindParam(':cod_publi', $cod_publi, PDO::PARAM_STR);
        $result_query->execute();
        $linhas = $result_query->rowCount();
        $row_publi = $result_query->fetch(PDO::FETCH_ASSOC);

        if($linhas == 0){
            echo "PUBLICAÇÃO FORA DO AR OU EXCLUIDA!";
        }else{
    ?>
    
    <section class="container_publi">
    
        <div class="conteudo_post">
            <img class="image_post" width='100%' src='<?php echo $row_publi['im_publicacao']?>'/>
        </div>
        <div class="coment_post">
            <p><?php echo $row_perfil['nm_nomeUsuario']; ?></p>
        </div>
    </section>
    <a href="feed.php" class="voltar_feed">x</a>
    <?php }?>
</body>
</hmtl>