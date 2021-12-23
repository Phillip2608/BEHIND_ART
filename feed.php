<?
    session_start();
    ob_start();
    include_once'conexao.php';

    if((!isset($_SESSION['id_perfil'])) AND (!isset($_SESSION['nm_perfil']))){
        $_SESSION['msg'] = "Necessário utilizar um login para acessar!";
        header("Location: login.php");
    }

    $cod_perfil = $_SESSION['id_perfil'];

    $query_perfil = "SELECT * FROM tb_perfil WHERE id_perfil =$cod_perfil";
    $result_perfil = $con->query($query_perfil);
    $row_perfil = $result_perfil->fetch(PDO::FETCH_ASSOC);
    $_SESSION['nm_perfil'] = $row_perfil['nm_perfil'];
    $_SESSION['nm_nomeUsuario'] = $row_perfil['nm_nomeUsuario'];
    $_SESSION['im_perfil'] = $row_perfil['im_perfil'];
    $_SESSION['nm_email'] = $row_perfil['nm_email'];
    
?>
<html>
<head>
    <meta charset="utf-8">
    <title> Behind Art </title>
    

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
            padding:0;
            margin:0;
            font-family:'Roboto',sans-serif;
        }

        body{
            background-color: #181C27;//PRETO DO SITE
        }

        body::-webkit-scrollbar{
            width:12px;
        }
        body::-webkit-scrollbar:hover{
            background-color:#C7BDCF;
        }

        body::-webkit-scrollbar-thumb{
            background-color:#1BAE98;
            border-radius:50px;
        }

        .topo{
	        width: 100%;
	        height: 7vh;
            display:flex;
            flex-direction:row;
            align-items:center;
	        background-color: #E9E1F0;
            position:fixed;
        }

        .espaco_logo{
            width:5%;
            margin-left:5%;
        }

        .area_logo{
            max-width:50px;
            width:100%;
            float:right;
        }

        #logo_topo{
            height:90%;
            width:100%;
            object-fit:contain;
        }

        .link_logo{
            text-decoration:none;
        }

        #busca{
            display:none;
        }
        
        #enviarBusca{
            margin-top:4%;
            max-height:5vh;
            height:100%;
            cursor:pointer;
            object-fit:contain;
            transition: .3s all;
        }

        #enviarBusca:hover{
            transform: scale(1.1);
        }

        .area_busca{
            width:40%;
            margin-left:2%;
        }
    
        .area_busca .busca{
            width:100%;
            height:5vh;
            padding:1.5%;
            background-color:#C7BDCF;/* ROXINHO ESCURO */
            border-radius:100px;
            border-style:none;
            outline:none;
            font-size:2vw;
            font-weight:bold;
        }

        .topo #addPerfil{
            width:15vh;
            height:6vh;
            cursor:pointer;
            object-fit:cover;
            border-radius:100px;
            background-color:#C7BDCF;
            position:fixed;
            left:68%;
        }

        .user_topo{
            max-width:25vh;
            font-family:Spartan;
            font-weight:bold;
            color:#1BAE98;
            font-size:1.35vw;
            position:fixed;
            left:76%;
            top:2%;
        }

        #user_link{
            text-decoration:none;
        }

        .mais_opcoes{
            list-style-type:none;
            position:fixed;
            left:88%;
        }
        
        .mais_opcoes #barrinhas{
            width:6vh;
            height:6vh;
            display:flex;
            justify-content:center;
            border-radius:100px;
            background-color:#1BAE98;
            cursor:pointer;
            transition: .3s all;
        }

        .mais_opcoes #barrinhas:hover{
            transform:scale(1.1);
        }
        
        .mais_opcoes #barrinhas img{
            width:65%;
            object-fit:contain;
            cursor:pointer;
        }

        #opcoes_user{
            position:fixed;
            left:77%;
            top:7%;
            width:23%;
            background-color:#C7BDCF;
            list-style-type:none;
            display:none;
            box-shadow: 0px 2px 2px 2px rgba(0, 0, 0, 0.3);
        }

        #opcoes_user a{
            text-decoration:none;
            color:#181C27;
        }

        #opcoes_user li{
            width:95%;
            display:flex;
            align-items:center;
            flex-direction:row;
            padding:7px;
        }

        #opcoes_user li:hover{
            background-color:#E9E1F0;
        }

        #opcoes_user .funcoes:hover div{
            background-color:#3CDDC0;
            transition: all .3s;
            transform:scale(1.05);
        }

        #opcoes_user .funcoes:hover p{
            transition: all .3s;
            transform:scale(1.05);
        }

        #opcoes_user #info_user{
            display:flex;
            align-items:center;
        }

        #opcoes_user #info_user div{
            margin-left:5%;
        }

        #opcoes_user #info_user #name_user_info{
            color:#1BAE98;
            font-size:20px;
            font-weight:bold;
        }

        #opcoes_user #info_user img{
            width:10vh;
            height:10vh;
            border-radius:100px;
            object-fit:cover;
            box-shadow: 0px 2px 2px 2px rgba(0, 0, 0, 0.3);
        }

        #opcoes_user li p{
            margin-left:5%;
            font-size:20px;
            font-weight:bold;
        }

        .config_perfil{
            width:10%;
            background-color:#1BAE98;
            border-radius:100px;
            padding:5px
        }

        .config_perfil img{
            width:100%;
            object-fit:contain;
        }

        .conteudo_post{
            max-width:70%;
            max-height:100%;
            height:100%;
            width:100%;
            background-color:#C7BDCF;
            position:fixed;
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

        .favoritos_do_mes{
            width:90%;
            margin-left:5%;
            display:flex;
            justify-content:center;
            flex-direction:column;
        }

        .frase_favMes{
            color:#E3E2EF;
            background-color:#1BAE98;/* AZULZINHO NOSSO */
            width:22%;
            text-align:center;
            border-radius:80px;
            font-size:40px;
            font-weight:bold;
            margin-left:auto;
            margin-right:auto;
            margin-top:10%;
            padding-top:5px;
            padding-bottom:5px;
            padding-left:5%;
            padding-right:5%;
        }

        .podio_usuarios{
            width:100%;
            display:flex;
            justify-content:space-between;
            flex-direction:row;
            align-items:center;
        }

        .conteudo_podio{
            margin-left:auto;
            margin-right:auto;
            background-color:#C7BDCF;
            width:90%;
            max-height:20vh;
            height:100%;
        }

        .user_moldura{
            color:#1BAE98;
            margin-left:auto;
            margin-right:auto;
            font-weight:bold;
            font-size:35px;
            padding:4%;
        }

        .imagem_podio{
            width:100%;
            height:20vh;
            object-fit:cover;
        }

        .publicar{
            width:70%;
            background-color:#E9E1F0;
            padding:1%;
            margin-left:15%;
            margin-top:8%;
            border-radius: 40px 40px 0px 0px;
        }

        .area-publicar{
            width:100%;
            height:10vh;
            display:flex;
            flex-direction:row;
            align-items:center;
        }

        .digite{
            width: 50%;
            background-color:#C7BDCF;
            padding:1%;
            border-radius:100px;
            border-style:none;
            outline:none;
            margin-left:10px;
            font-family:'Roboto',sans-serif;
            font-weight:bold;
            font-size:30px;
        }

        .area-publicar #addPerfil{
            width:10vh;
            height:10vh;
            object-fit:cover;
            cursor:pointer;
            border-radius:100px;
            background-color:#C7BDCF;
        }

        .espaco-image{
            max-width:50px;
            width:100%;
            margin-left:2%;
        }

        .preenchimentoImagem{
            width:100%;
            max-width:100px;
        }

        .icon-espacamento{
            width:40%;
            display:flex;
            flex-direction:row;
            justify-content:space-between;
        }

        #enviarPost{
            margin-top:10%;
            width:100%;
            cursor:pointer;
            transition: .3s all;
        }

        #enviarPost:hover{
            transform: scale(1.1);
        }

        #addImage{
            width:100%;
            cursor:pointer;
            transition: .3s all;
        }

        #addImage:hover{
            transform: scale(1.1);
        }

        #addVideo{
            width:100%;
            cursor:pointer;
            transition: .3s all;
        }

        #addVideo:hover{
            transform: scale(1.1);
        }

        .publicar #imagem{
            display:none;
        }
        .publicar #video{
            display:none;
        }
        .publicar #sendPublish{
            display:none;
        }

        .container-post{
            width: 60vh;
            margin-left:12%;
            margin-top:3%;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .moldura{
            width:60vh;
            height:auto;
            background-color: #E9E1F0;
            display:flex;
            justify-content: center;
            flex-direction: column;
            padding-right:20px;
            border-radius: 70px 70px 0px 0px;
            padding-left: 20px;
            padding-bottom:5%;
        }

        .post{
            background-color: #C7BDCF;
            width: 100%;
            height:54vh;
            display: flex;
            justify-content:center;
            align-items: center;
        }

        .ds_publicacao{
            margin-top:4%;
            text-align:center;
            color:#181C27;
            font-weight:bold;
            font-size:18px;
        }

        .link_post{
            width:100%;
        }

        .image-post{
            max-width:100%;
            width: 100%;
            height:100%;
            align-content: center;
            cursor:pointer;
        }

        .imagem_posts{
            width:100%;
            height:100%;
            object-fit: cover;
        }

        .image_moldura{
            width:16vh;
            height:16vh;
            margin-left:10%;
            margin-top:10%;
            background-color:#C7BDCF;
            display:flex;
            justify-content:center;
            border-radius: 100px;
            border-style:solid;
            border-width:10px;
            border-color:#E9E1F0;
        }

        .image_perfil{
            object-fit:cover;
            border-radius:100px;
            cursor:pointer;
        }

        .nome_user{
            text-align:center;
            color:#1BAE98;
            font-weight:bold;
            font-size:25px;
            margin-top:2%;
        }

        .button_seguir{
            width:25%;
            border-radius:50px;
            outline:none;
            border-style:none;
            background-color:#1BAE98;
            cursor:pointer;
            font-size:22px;
            font-weight:bold;
            color:#E9E1F0;
            margin-left:auto;
            margin-right:auto;
            margin-top:5%;
            transition: .3s all;
        }

        .button_seguir:hover{
            transform: scale(1.1);
        }

        .area_comentario{
            width:100%;
            display:flex;
            flex-direction:row;
            align-items:center;
            margin-top:3%;
        }

        .enviarComent{
            display:flex;
            flex-direction:row;
            align-items:center;
        }

        #ds_comentario{
            width:90%;
            padding:8px;
            background-color:#C7BDCF;
            border-radius:50px;
            border-style:none;
            outline:none;
            font-weight:bold;
        }

        .area_img_coment{
            width:10vh;
            height:10vh;
            background-color:#C7BDCF;
            border-radius:100px;
        }

        .img_coment{
            width:10vh;
            height:10vh;
            object-fit:cover;
            border-radius:100px;
            background-color:#C7BDCF;
            cursor:pointer;
        }

        .area_info_coment{
            margin-left:2%;
            width:87%;
        }

        .nm_coment{
            width:45%;
            color:#1BAE98;
            font-size:24px;
            font-weight:bold;
            margin-top:10px;
            border-style: none none solid none;
            border-color:#181C27;
            border-width:1px;
            text-indent:1ch;
            overflow:hidden;
            white-space:nowrap;
            text-overflow:ellipsis;
        }

        .ds_comentario{
            max-width:95%;
            width:100%;
            background-color:#C7BDCF;
            border-style:none;
            border-color:none;
            border-radius:0px 15px 0px 15px;
            font-size:18px;
            padding:5px;
            margin-top:5px;
            cursor:auto;
            resize:none;
        }

        .moldura_podio{
            width:24%;
            display:flex;
            justify-content:center;
            flex-direction:column;
            background-color:#E9E1F0;/*ROXINHO */
            padding-top:3%;
            border-radius:30px 30px 0px 0px;
            margin-top:3%;
        }

        .fundo_modal{
            width:100%;
            height:100%;
            position:fixed;
            top:0px;
            left:0px;
            background-color: rgba(0,0,0,0.5);
            display:none;
        }

        .modal_publi{
            position:fixed;
            left:28%;
            top:15%;
            width:38%;
            padding:3%;
            background-color:#E9E1F0;
            border-radius:25px;
            display:none;
        }

        #img_publicar{
            width:100%;
            height:45vh;
            background-color:#C7BDCF;
            object-fit:scale-down;
            cursor:pointer;
            transition:all .3s;
        }

        #img_publicar:hover{
            transform:scale(1.015);
        }

        .btn_imgs{
            width:40%;
            border-style:none;
            border-radius:50px;
            outline:none;
            background-color:#1BAE98;
            color:#E9E1F0;
            text-align:center;
            font-size:20px;
            font-weight:bold;
            padding:3px;
            cursor:pointer;
            transition: all .3s;
        }

        .btn_imgs:hover{
            transform:scale(1.1);
        }

        #confirmar_publi:hover{
            background-color:#3CDDC0;
        }

        #cancelar_publi:hover{
            background-color:#F24452;
        }

        .area_btn_imgs{
            width:100%;
            display:flex;
            flex-direction:row;
            justify-content:space-around;
            margin-top:5%;
        }

        .titulo_publi{
            font-weight:bold;
            font-size:25px;
            color:#1BAE98;
            text-align:center;
            margin-bottom:3%;
        }

        #btn_file{
            display:none;
        }

        .digite_menorzinho{
            width:100%;
            border-style:none;
            border-radius:50px;
            padding:5px;
            margin-top:4%;
            outline:none;
            font-size:22px;
            font-weight:bold;
            background-color:#C7BDCF;
        }
    </style>
</head>
<body>
<!--CABEÇALHO -->
    <header class="topo"> 

    <!--LOGO-->
    <div class="espaco_logo">
        <div class="area_logo">
            <a href="feed.php" class="link_logo"><img src="imagens/logoBDAredonda.png" id="logo_topo"></a>
        </div>
    </div>

        <!--INTPU DE BUSCA-->
           
        <div class="area_busca">
            <form action="busca.php" method="GET">
                <input type="text" name="busca_perfil" class="busca" placeholder="Faça sua busca...">
                <input type="submit" name="" value="buscar" id="busca">
            </form>
        </div>

        <!--BOTAO DE ENVIAR-->

        <div>
            <div class="espaco-image">
                <div class="preenchimentoImagem">
                    <img src="imagens/icones/enviar.png" id="enviarBusca">
                </div>
            </div>
        </div>

        <!--IMAGEM E NOME DO USER-->

        <img onclick="javascript: location.href='perfil_usuario/perfilPublicacoes.php?codigo=<?php echo $cod_perfil;?>'" src="<?php if($_SESSION['im_perfil'] != null){ echo $_SESSION['im_perfil']; }else{?>imagens/icones/padraoPerfil.png<?php }?>" id="addPerfil" >
        <a href="perfil_usuario/perfilPublicacoes.php?codigo=<?php echo $cod_perfil; ?>" id="user_link"><p class="user_topo"><?php if($_SESSION['nm_nomeUsuario'] != null){echo $_SESSION['nm_nomeUsuario'];}else{echo $_SESSION['nm_perfil'];} ?></p></a>
        <ul class="mais_opcoes">
            <li id="barrinhas" class="barrinhas">
                <img src = "imagens/icones/barras.png">
            </li>
        </ul>
    </header>
    <ul id="opcoes_user" class="opcoes_user">
        <a href="perfil_usuario/perfilPublicacoes.php?codigo=<?php echo $cod_perfil; ?>">
        <li id="info_user">
            <img src="<?php if($_SESSION['im_perfil']){ echo $_SESSION['im_perfil'];}else{ echo 'imagens/icones/padraoPerfil.png';} ?>">
            <div>
                <p id="name_user_info"><?php if($_SESSION['nm_nomeUsuario']){echo $_SESSION['nm_nomeUsuario'];}else{echo $_SESSION['nm_perfil'];} ?></p>
                <p>Ver perfil</p>
            </div>
        </li>
        </a>
        <a href="configPerfil.php">
        <li class="funcoes">
            <div class="config_perfil">
                <img src="imagens/icones/config_icon.png">
            </div>
            <p>Configurações<p>
        </li>
        </a>
        <a href="sair.php">
        <li class="funcoes">
            <div class="config_perfil">
                <img src="imagens/icones/sair.png">
            </div>
            <p>Sair</p>
        </li>
        </a>
    </ul>

<!-- FIM DO CABEÇALHO-->

    <!--FAVORITOS DO MÊS-->

    <section class="favoritos_do_mes">
        <p class="frase_favMes">FAVORITOS DO MÊS</p>
        <div class="podio_usuarios">
            <?php
                $select_likes = "SELECT id_publicacao, im_publicacao, id_perfil, qt_curtida FROM tb_publicacao WHERE qt_curtida >= 1 ORDER BY qt_curtida DESC LIMIT 4";
                $result_likes = $con->prepare($select_likes);
                $result_likes->execute();
                while($row_fav = $result_likes->fetch(PDO::FETCH_ASSOC)){
                    $select_fav = "SELECT id_perfil, nm_perfil, nm_nomeUsuario, im_perfil FROM tb_perfil WHERE id_perfil =:cod_pp";
                    $result_fav = $con->prepare($select_fav);
                    $result_fav->bindParam(':cod_pp', $row_fav['id_perfil'], PDO::PARAM_STR);
                    $result_fav->execute();
                    $row_name_fav = $result_fav->fetch(PDO::FETCH_ASSOC);

                    if($row_fav['im_publicacao'] != null){

                    
            ?>
                        <div class="moldura_podio">
                            <div class="conteudo_podio">
                                <img src="<?php echo $row_fav['im_publicacao']; ?>" class="imagem_podio">
                            </div>
                            <p class="user_moldura"><?php if($row_name_fav['nm_nomeUsuario']){echo $row_name_fav['nm_nomeUsuario'];}else{echo $row_name_fav['nm_perfil'];} ?></p>   
                        </div>
            <?php
                    }
                }
            ?>
        </div>    
                
                    
                
                
            
        
    </section>

   <!-- /* PUBLICAÇÃO */-->

    <section class="publicar">
        <form action="publicar.php" method="POST">
        <div class="area-publicar">

        <!--/* IMAGEM DO USER */-->
            <img onclick="javascript: location.href='perfil_usuario/perfilPublicacoes.php?codigo=<?php echo $cod_perfil; ?>'" src="<?php if($_SESSION['im_perfil'] != null){ echo $_SESSION['im_perfil']; }else{?>imagens/icones/padraoPerfil.png<?php }?>" id="addPerfil">

           <!-- /* INPUT DE DIGITAÇÃO */-->

            <input type="text" name="ds_publicacao" class="digite" placeholder="Digite algo...">

           <!-- /* ICONES DE ENVIAR E ADD IMAGEM E VIDEO */-->

            <div class="icon-espacamento">
                <div class="espaco-image">
                    <div class="preenchimentoImagem">
                        <img src="imagens/icones/enviar.png" id="enviarPost">
                    </div>
                </div>
                <div class="espaco-image">
                    <div class="preenchimentoImagem">
                        <img src="imagens/icones/addImage.png" id="addImage" onclick="mostrarPubli()">
                    </div>
                </div>
                <div class="espaco-image">
                    <div class="preenchimentoImagem">
                        <img src="imagens/icones/addVideo.png" id="addVideo">
                    </div>
                </div>
            </div>
            
        <!-- BOTOES NÃO VISIVEIS, NAO MEXA!!!! -->
        </div>
            <input type="submit" name="" id="sendPublish" value="publish">               
        </form>
    </section>
    <!--/* FIM DA PUBLICACAO */-->

    <!-- LOGICA, NAO MEXA ATÉ O FINAL-->
    <section class="container-post">
    <?php
        /*SELECT SEGUIDORES*/
        $select_seguidores = "SELECT id_perfil FROM tb_seguir_perfil WHERE id_seguindo =:cod_perfil";
        $result_seguidores = $con->prepare($select_seguidores);
        $result_seguidores->bindParam(':cod_perfil', $cod_perfil, PDO::PARAM_STR);
        $result_seguidores->execute();
        $row_seguidores = $result_seguidores->fetch(PDO::FETCH_ASSOC);

        /*PUBLICACAO*/
        $query_publi = "SELECT * FROM tb_publicacao ORDER BY id_publicacao  DESC";
        $result_publi = $con->query($query_publi);
        $linhas = $result_publi->rowCount();
        try{
            if($linhas == 0){
                echo "Não foi encontrado nenhuma publicação!";
            }else{
                while($row_viewPubli = $result_publi->fetch(PDO::FETCH_ASSOC)){
                    /*FUNCAO DE LIKE*/
                    $select_curtidas = "SELECT id_publicacao FROM tb_publi_like WHERE id_publicacao = :cod_publi";
                    $result_curtidas = $con->prepare($select_curtidas);
                    $result_curtidas->bindParam(':cod_publi', $row_viewPubli['id_publicacao'], PDO::PARAM_STR);
                    $result_curtidas->execute();
                    $linhas_curtida = $result_curtidas->rowCount();

                    /*FUNCAO DE COMENTAR*/
                    $select_comentar = "SELECT * FROM tb_publi_comentario  WHERE id_publicacao =:cod_publi ORDER BY id_publi_comentario DESC";
                    $result_comentar = $con->prepare($select_comentar);
                    $result_comentar->bindParam(':cod_publi', $row_viewPubli['id_publicacao'], PDO::PARAM_STR);
                    $result_comentar->execute();

                    /*NOME DO USER*/
                    $select_nome = "SELECT id_perfil, nm_perfil, nm_nomeUsuario, im_perfil FROM tb_perfil WHERE id_perfil =:cod_pp";
                    $result_name = $con->prepare($select_nome);
                    $result_name->bindParam(':cod_pp', $row_viewPubli['id_perfil'], PDO::PARAM_STR);
                    $result_name->execute();
                    $row_name = $result_name->fetch(PDO::FETCH_ASSOC);
                    $linhas_name = $result_name->rowCount();
    ?>          
                <center>
                    <div class="image_moldura">
                        <img onclick="javascript: location.href='perfil_usuario/perfilPublicacoes.php?codigo=<?php echo $row_viewPubli['id_perfil']; ?>'" class="image_perfil" width='100%' src="<?php if($row_name['im_perfil'] != null){echo $row_name['im_perfil'];}else{ echo 'imagens/icones/padraoPerfil.png';} ?>">
                    </div>
                </center>
                    <div class="moldura">
                        
                        <?php if($linhas_name == 1){if($row_name['nm_nomeUsuario'] != null){echo "<p class='nome_user'>" . $row_name['nm_nomeUsuario'] . "</p>";}else{ echo "<p class='nome_user'>" . $row_name['nm_perfil'] . "</p>";}} ?>

                        <button class="button_seguir" onclick="javascript: location.href='seguir.php?codigo=<?php echo $row_viewPubli['id_perfil']; ?>'">Seguir</button>

                        <?php if($row_viewPubli['im_publicacao'] != null){?>
                        <div class="post">
                            <a class="link_post" onclick="location.href='viewPubli.php?codigo_publi=<?php echo $row_viewPubli['id_publicacao']; ?>?codigo_perfil=<?php echo $row_viewPubli['id_perfil'];?>'">
                                <div class="image-post">
                                    <img class="imagem_posts" width='100%' src="<?php echo $row_viewPubli['im_publicacao']?>"/>
                                </div>
                            </a>
                        </div><?php }?>
                        <?php if($row_viewPubli['ds_publicacao'] != null){?><p class="ds_publicacao"><?php echo $row_viewPubli['ds_publicacao']; ?></p><?php }?>
                        <p>Curtidas:<?php $row_viewPubli['qt_curtida'] = $linhas_curtida; echo $row_viewPubli['qt_curtida']; ?></p>
                        <p><a href="curtir.php?codigo=<?php echo $row_viewPubli['id_publicacao']; ?>">Curtir</a></p>
                        <form action="comentar.php?codigo=<?php echo $row_viewPubli['id_publicacao']; ?>" method="POST">
                            <div class="enviarComent">
                                <input type="text" name="ds_comentario" id="ds_comentario" placeholder="Comente algo">
                                <input type="submit" id="sendComent" value="Comentar">
                            </div>
                        </form>

                        <div>
                            <?php
                                while($row_viewComent = $result_comentar->fetch(PDO::FETCH_ASSOC)){
                                    $select_img_coment = "SELECT id_perfil, nm_perfil, nm_nomeUsuario, im_perfil FROM tb_perfil WHERE id_perfil =:cod_coment";
                                    $result_img = $con->prepare($select_img_coment);
                                    $result_img->bindParam(':cod_coment', $row_viewComent['id_perfil'], PDO::PARAM_STR);
                                    $result_img->execute();
                                    $row_img = $result_img->fetch(PDO::FETCH_ASSOC);
                            ?>      
                                <div class="area_comentario">
                                    <div class="area_img_coment">
                                        <img class="img_coment" src="<?php if($row_img['im_perfil'] != null){ echo $row_img['im_perfil'];}else{?>imagens/icones/padraoPerfil.png<?php }?>" onclick="javascript: location.href='perfil_usuario/perfilPublicacoes.php?codigo=<?php echo $row_viewComent['id_perfil']; ?>'">
                                    </div>
                                    <div class="area_info_coment">
                                        <p class="nm_coment"><?php if($row_img['nm_nomeUsuario'] != null){echo $row_img['nm_nomeUsuario'];}else{ echo $row_img['nm_perfil'];} ?></p>
                                        <textarea class="ds_comentario" maxlength="250" readonly><?php echo $row_viewComent['ds_comentario']; ?></textarea>
                                    </div>
                                </div>
                                <form action="respost_coment.php?cd_coment=<?php echo $row_viewComent['id_publi_comentario']; ?>&cod_publi=<?php echo $row_viewPubli['id_publicacao']; ?> " method="POST">
                                    <input type="text" name="ds_respost_coment" placeholder="Responda o comentário">
                                    <input type="submit">
                                </form>
                                <div>
                                    <?php
                                        $select_respost = "SELECT * FROM tb_respost_coment WHERE id_publicacao = :cod_publi AND id_publi_comentario = :cod_coment";
                                        $result_respost = $con->prepare($select_respost);
                                        $result_respost->bindParam(':cod_publi', $row_viewPubli['id_publicacao']);
                                        $result_respost->bindParam(':cod_coment',$row_viewComent['id_publi_comentario']);
                                        $result_respost->execute();

                                        while($row_respost = $result_respost->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                            <textarea><?php echo $row_respost['ds_respost_coment']; ?></textarea>
                                    <?php
                                        }                                    
                                    ?>
                                </div>
                                    <?php
                                        if($row_viewComent['id_perfil'] == $cod_perfil){
                                    ?>
                                            <a href="excluirComentario.php?codigo=<?php echo $row_viewComent['id_publi_comentario']; ?>">Excluir comentario</a>
                            <?php
                                        }
                                }
                            ?>
                        </div>
                        <?php
                            if($row_viewPubli['id_perfil'] == $cod_perfil){
                        ?>
                                <p><a href="excluirPublicacao.php?codigo=<?php echo $row_viewPubli['id_publicacao']; ?>"> Excluir Publicação </a></p>
                        <?php
                            }
                        ?>
                        
                    </div>
    <?php       
                }
            }   
        }catch(PDOException $e){
            echo 'Error: ' . $e->getMessage();
        }
    ?>
    </section>
    <section class="fundo_modal" id="fundo_modal">
        <div class="modal_publi" id="modal_publi">
            <form action="publicar.php" method="POST" enctype="multipart/form-data">
                <p class="titulo_publi">Clique no mais para adicionar sua arte!</p>
                <img src="imagens/icones/mais_publicar.png" id="img_publicar">
                <input type="text" name="ds_publicacao" class="digite_menorzinho" placeholder="Digite algo...">
                <input type="file" name="img_publicacao" id="btn_file">
                <div class="area_btn_imgs">
                    <input type="submit" name="" id="confirmar_publi" class="btn_imgs" value="Publicar">
                    <p onclick="cancelarPubli()" id="cancelar_publi" class="btn_imgs" >Cancelar</p>
                </div>
            </form>
        </div>
    </sectio>
    <script src="javascript/jquery.js"></script>

    <script type="text/javascript">
    /*FUNCIONALIDADES DOS ICONES*/

        /*MODAL PUBLICAR*/

        function mostrarPubli(){
            var fundo_modal = document.getElementById('fundo_modal');
            var modal_publi = document.getElementById('modal_publi');

            modal_publi.style.display= "block";
            fundo_modal.style.display = "block";
        }

        function cancelarPubli(){
            var fundo_modal = document.getElementById('fundo_modal');
            var modal_publi = document.getElementById('modal_publi');

            modal_publi.style.display= "none";
            fundo_modal.style.display = "none";
        }

        var view_img_publi = document.getElementById('img_publicar')
        var select_file_publi = document.getElementById('btn_file');

        view_img_publi.addEventListener('click', () => {
            select_file_publi.click();
        });

        select_file_publi.addEventListener('change', (event_publi) => {
            if(select_file_publi.files.length <= 0){
                return;
            }

            var reader_publi = new FileReader();

            reader_publi.onload = () => {
                view_img_publi.src = reader_publi.result;
            }

            reader_publi.readAsDataURL(select_file_publi.files[0]);
        });

        /*PEGAR UMA FOTO*/
        var addPhoto = document.getElementById('addImage');
        var filePhoto = document.getElementById('imagem');

        addPhoto.addEventListener('click', () => {
            filePhoto.click();
        });
        
        /*PEGAR UM VIDEO*/
        var addVideo = document.getElementById('addVideo');
        var fileVideo = document.getElementById('video');

        addVideo.addEventListener('click', () =>{
            fileVideo.click();
        });

        /*ENVIAR PUBLICACAO*/
        var enviarPost = document.getElementById('enviarPost');
        var sendPublish = document.getElementById('sendPublish');

        enviarPost.addEventListener('click', () => {
            sendPublish.click();
        });

        /*ENVIAR BUSCA*/
        var enviarBusca = document.getElementById('enviarBusca');
        var busca = document.getElementById('busca');

        enviarBusca.addEventListener('click', () => {
            busca.click();
        });

        $(document).ready(function() {
            var botao = $('.barrinhas');
            var dropDown = $('.opcoes_user');    

            botao.on('click', function(event){
                dropDown.stop(true,true).slideToggle();
                event.stopPropagation();
            });
        });
        
        document.addEventListener('keydown', function(event){
            var mais_opcoes = document.getElementById('opcoes_user');
            if(event.keyCode == 27){
                mais_opcoes.style.display = 'none';
            }
        });
    /*FIM DOS ICONES*/
    </script>

    <!--NAO MEXA ATÉ AQUI!!!!-->
</body>
</html>
