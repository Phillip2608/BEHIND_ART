<?php
    session_start();
    ob_start();
    include_once'../conexao.php';

    if((!isset($_SESSION['id_perfil'])) AND (!isset($_SESSION['nm_perfil']))){
        $_SESSION['msg'] = "Necessário utilizar um login para acessar!";
        header("Location: login.php");
    }

    $cod_perfil_session = $_SESSION['id_perfil'];
    $cod_perfil_get = $_GET['codigo'];

    $query_perfil = "SELECT nm_perfil, nm_nomeUsuario, im_perfil, im_fundo FROM tb_perfil WHERE id_perfil =$cod_perfil_session";
    $result_perfil = $con->query($query_perfil);
    $row_perfil = $result_perfil->fetch(PDO::FETCH_ASSOC);
    $_SESSION['nm_perfil'] = $row_perfil['nm_perfil'];
    $_SESSION['nm_nomeUsuario'] = $row_perfil['nm_nomeUsuario'];

    $query_get = "SELECT nm_perfil, nm_nomeUsuario, im_perfil, im_fundo FROM tb_perfil WHERE id_perfil = $cod_perfil_get";
    $result_get = $con->query($query_get);
    $row_get = $result_get->fetch(PDO::FETCH_ASSOC);
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Behind Art</title>
    <link rel="shortcut icon" type="imagex/png" href="../imagens/logoBDa.ico">

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
            padding:0;
            margin:0;
        }

        .topo{
	        width: 100%;
	        height: 7vh;
            display:flex;
            flex-direction:row;
            align-items:center;
	        background-color: #E9E1F0;
            position:fixed;
            z-index: 3;
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

        .painel_fundo{
            max-height:30vh;
            height:100%;
            width:100%;
            position:absolute;
            top:7%;
            background-color:#C7BDCF;
            z-index:-2;
        }

        .painel{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .barra_perfil{
            position:absolute;
            top:37%;
            z-index:1;
            background-color:#E9E1F0;
            width:100%;
            max-height: 11.5vw;
            height:100%;
            display:flex;
            flex-direction:column;
        }

        .area_info{
            position:absolute;
            left:31%;
            top:20%;
            z-index:-2;
            width:35%;
        }

        .info_perfil{
            display:flex;
            justify-content:space-between;
            flex-direction:row;
            font-size:2vw;
            color:#181C27;
            font-weight:bold;
        }

        .img_perfil{
            position:absolute;
            left:43.5%;
            bottom:56%;
            width:10vw;
            height:10vw;
            object-fit:cover;
            border-radius:100px;
            border-style:solid;
            border-width:10px;
            border-color:#E9E1F0;
            z-index:2;
        }

        #nomePerfil{
            text-align:center;
            color:#1BAE98;
            margin-top:5%;
        }
        .numerozinho{
            color:#1BAE98;
        }
        #seguindo{
            text-align:center;
        }

        #seguidores{
            text-align:center;
        }

        .botoes{
            position:absolute;
            top:89%;
            left:16%;
            z-index:-1;
            width:70%;
        }

        .area_botoes{
            display:flex;
            justify-content:center;
        }

        .botao{
            border-style:none;
            outline:none;
            border-radius:100px;
            background-color:#1BAE98;
            margin-left:10px;
            padding-right:3%;
            padding-left:3%;
            padding-bottom:0.5%;
            padding-top:0.5%;
            text-align:center;
            cursor:pointer;
            transition: .3s all;
        }

        .botao:hover{
            transform: scale(1.1);
        }

        .botoes .area_botoes .botao a{
            text-decoration:none;
            color:#E3E2EF;
            font-size:25px;
            font-weight:bold;
            border-radius:100px;
        }

        #grupo{
            margin-right:5%;
            cursor:pointer;
        }

        #seguir{
            margin-right:5%;
            font-size:30px;
        }

        #sobre{
            margin-right:5%;
        }

        #album{
            margin-right:5%;
        }
    </style>
</head>
<body>
    <!--CABEÇALHO -->
    <header class="topo"> 

    <!--LOGO-->
    <div class="espaco_logo">
        <div class="area_logo">
            <a href="../feed.php" class="link_logo"><img src="../imagens/logoBDAredonda.png" id="logo_topo"></a>
        </div>
    </div>

        <!--INTPU DE BUSCA-->
           
        <div class="area_busca">
            <form action="../busca.php" method="GET">
                <input type="text" name="busca_perfil" class="busca" placeholder="Faça sua busca...">
                <input type="submit" name="" value="buscar" id="busca">
            </form>
        </div>

        <!--BOTAO DE ENVIAR-->

        <div>
            <div class="espaco-image">
                <div class="preenchimentoImagem">
                    <img src="../imagens/icones/enviar.png" id="enviarBusca">
                </div>
            </div>
        </div>

        <!--IMAGEM E NOME DO USER-->
        <?php
            $select_seguindo = "SELECT id_seguindo FROM tb_seguir_perfil WHERE id_seguindo = :cod_get";
            $result_seguindo = $con->prepare($select_seguindo);
            $result_seguindo->bindParam('cod_get', $cod_perfil_get, PDO::PARAM_STR);
            $result_seguindo->execute();
            $linhas_seguindo = $result_seguindo->rowCount();

            $select_seguidor = "SELECT id_perfil FROM tb_seguir_perfil WHERE id_perfil = :cod_get";
            $result_seguidor = $con->prepare($select_seguidor);
            $result_seguidor->bindParam('cod_get', $cod_perfil_get, PDO::PARAM_STR);
            $result_seguidor->execute();
            $linhas_seguidor = $result_seguidor->rowCount();
        ?>

        
        <img onclick="javascript: location.href='perfilPublicacoes.php?codigo=<?php echo $cod_perfil_session;?>'" src="../<?php if($_SESSION['im_perfil'] != null){ echo $_SESSION['im_perfil']; }else{?>../imagens/icones/padraoPerfil.png<?php }?>" id="addPerfil" >
        <a href="perfilPublicacoes.php?codigo=<?php echo $cod_perfil_session; ?>" id="user_link"><p class="user_topo"><?php if($_SESSION['nm_nomeUsuario'] != null){echo $_SESSION['nm_nomeUsuario'];}else{echo $_SESSION['nm_perfil'];} ?></p></a>
        <ul class="mais_opcoes">
            <li id="barrinhas" class="barrinhas">
                <img src = "../imagens/icones/barras.png">
            </li>
        </ul>
    </header>
    <ul id="opcoes_user" class="opcoes_user">
        <a href="perfilPublicacoes.php?codigo=<?php echo $cod_perfil_session; ?>">
        <li id="info_user">
            <img src="../<?php if($_SESSION['im_perfil'] != null){ echo $_SESSION['im_perfil']; }else{?>../imagens/icones/padraoPerfil.png<?php }?>">
            <div>
                <p id="name_user_info"><?php if($_SESSION['nm_nomeUsuario']){echo $_SESSION['nm_nomeUsuario'];}else{echo $_SESSION['nm_perfil'];} ?></p>
                <p>Ver perfil</p>
            </div>
        </li>
        </a>
        <a href="../configPerfil.php">
        <li class="funcoes">
            <div class="config_perfil">
                <img src="../imagens/icones/config_icon.png">
            </div>
            <p>Configurações<p>
        </li>
        </a>
        <a href="../sair.php">
        <li class="funcoes">
            <div class="config_perfil">
                <img src="../imagens/icones/sair.png">
            </div>
            <p>Sair</p>
        </li>
        </a>
    </ul>

<!-- FIM DO CABEÇALHO-->
<!--PAINEL DE FUNDO DO USER-->
    <?php
        $select_seguindo = "SELECT id_seguindo FROM tb_seguir_perfil WHERE id_seguindo = :cod_get";
        $result_seguindo = $con->prepare($select_seguindo);
        $result_seguindo->bindParam('cod_get', $cod_perfil_get, PDO::PARAM_STR);
        $result_seguindo->execute();
        $linhas_seguindo = $result_seguindo->rowCount();

        $select_seguidor = "SELECT id_perfil FROM tb_seguir_perfil WHERE id_perfil = :cod_get";
        $result_seguidor = $con->prepare($select_seguidor);
        $result_seguidor->bindParam('cod_get', $cod_perfil_get, PDO::PARAM_STR);
        $result_seguidor->execute();
        $linhas_seguidor = $result_seguidor->rowCount();
    ?>
    <img class="img_perfil" src="<?php if($row_get['im_perfil']){ echo '../'. $row_get['im_perfil'];}else{ echo '../imagens/icones/padraoPerfil.png';} ?>">

    <section class="painel_fundo">
        <div class="area_painel">
            <img src="<?php if($row_get['im_fundo']){ echo '../'.$row_get['im_fundo'];}else{echo '../imagens/icones/paisagem_fundo.png';} ?>" class="painel">
        </div>
    </section>

    <section class="barra_perfil">
        <div class="area_info">
            <div class="info_perfil">
                <div id="seguidores">
                    <p><b>Seguidores</b></p>
                   <div class="numerozinho" <p><?php echo $linhas_seguidor; ?></p></div>
                </div>
                <div id="nomePerfil">
                    <p><h4><?php if($row_get['nm_nomeUsuario'] != null){echo $row_get['nm_nomeUsuario'];}else{echo $row_get['nm_perfil'];} ?></h4></p>
                </div>  
                <div id="seguindo">
                    <p><b>Seguindo</b></p>
                    <div class="numerozinho"<p><?php echo $linhas_seguindo; ?></p></div>
                </div>
            </div>
        </div>
        <div class="botoes">
            <div class="area_botoes">
                <button class="botao" id="sobre"><a href="perfilSobre.php" >Sobre</a></button>
                <button class="botao"id="grupo"><a href="">Grupos</a></button>
                <button class="botao"id="seguir"><a href="#" >Seguir</a></button>
                <button class="botao"id="album"><a href="album.html" >Álbum</a></button>
                <button class="botao"id="publi"><a href="perfilPublicacoes.php?codigo=<?php echo $cod_perfil_get; ?>">Publicações</a></button>
            </div>
        </div>
    </section>
    <script src="../javascript/jquery.js"></script>

    <script type="text/javascript">
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
    </script>    
</body>
</html>