<?php
    session_start();
    ob_start();
    include_once'conexao.php';

    if(!isset($_GET['busca_perfil'])){
        header('Location: feed.php');
        exit;
    }

    $cod_perfil = $_SESSION['id_perfil'];

    $query_perfil = "SELECT * FROM tb_perfil WHERE id_perfil =$cod_perfil";
    $result_perfil = $con->query($query_perfil);
    $row_perfil = $result_perfil->fetch(PDO::FETCH_ASSOC);

    $busca_perfil = "%". trim($_GET['busca_perfil']) . "%";

    $query = "SELECT * FROM tb_perfil WHERE nm_perfil LIKE :busca";
    $result_query = $con->prepare($query);
    $result_query->bindParam(':busca', $busca_perfil, PDO::PARAM_STR);
    $result_query->execute();

    $result_busca = $result_query->fetchAll(PDO::FETCH_ASSOC);
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
            top:0.5%;
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
            top:0.5%;
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

        .resultados{
            width:45%;
            float:left;
            margin-top:4%;
            margin-left:10%;
            display:flex;
            flex-direction:column;
        }

        h2{
            color:#1BAE98;
            font-size:30px;
            font-family:Spartan;
        }

        .area_result{
            width:100%;
            display:flex;
            align-items:center;
            flex-direction:row;
            margin-top:5%;
        }

        .espaco_img{
            width:15vh;
            height:15vh;
            background-color:#C7BDCF;
            border-radius:100px;
        }

        .espaco_img img{
            width:15vh;
            height:15vh;
            border-radius:100px;
            object-fit:cover;
        }

        .names{
            width:100%;
            display:flex;
            flex-direction:column;
        }

        .user_name{
            font-size:25px;
            font-weight:bold;
            color:#1BAE98;
            font-family:Spartan;
            margin-left:3%;
        }

        .user_apelido{
            font-size:16px;
            font-weight:bold;
            font-family:Spartan;
            color:#E9E1F0;
            margin-left:3%;
        }
        .view_perfil{
            width:6vh;
            height:6vh;
            border-radius:100px;
            background-color:#1BAE98;
            padding:5px;
            transition: all .3s;
            cursor:pointer;
        }

        .view_perfil:hover{
            background-color:#3CDDC0;
            transform:scale(1.1);
        }

        .view_perfil img{
            width:6vh;
            height:6vh;
            object-fit:contain;
        }

        .qt_seguidores{
            color:#E9E1F0;
            font-size:14px;
            margin-top:3%;
            margin-left:3%;
        }
    </style>
</head>
<body>
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

        <div class="perfil_nameUser">
            <img onclick="javascript: location.href='perfil_usuario/perfilPublicacoes.php?codigo=<?php echo $cod_perfil; ?>'" src="<?php if($_SESSION['im_perfil'] != null){ echo $_SESSION['im_perfil']; }else{?>imagens/icones/padraoPerfil.png<?php }?>" id="addPerfil" >
            <a href="perfil_usuario/perfilPublicacoes.php?codigo=<?php echo $cod_perfil; ?>" id="user_link"><p class="user_topo"><?php if($_SESSION['nm_nomeUsuario'] != null){echo $_SESSION['nm_nomeUsuario'];}else{echo $_SESSION['nm_perfil'];} ?></p></a>
            <ul class="mais_opcoes">
                <li id="barrinhas" class="barrinhas">
                    <img src = "imagens/icones/barras.png">
                </li>
            </ul>
        </div>
    </header>
    <ul id="opcoes_user" class="opcoes_user">
        <a href="perfil_usuario/perfilPublicacoes.php?codigo=<?php echo $cod_perfil; ?>">
        <li id="info_user">
            <img src="<?php if($_SESSION['im_perfil']){echo $_SESSION['im_perfil'];}else{ echo 'imagens/icones/padraoPerfil.png';}  ?>">
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
    
    <div class="resultados">
        <h2>Resultados</h2>
        <?php
            if(count($result_busca)){
                foreach($result_busca as $Resultados){
        ?>
        <div class="area_result">
            <div class="espaco_img">
                <img src="<?php if($Resultados['im_perfil']){echo $Resultados['im_perfil'];}else{ echo 'imagens/icones/padraoPerfil.png';} ?>">
            </div>
            <div class="names">
                <p class="user_name"><?php echo $Resultados['nm_perfil'];?></p>
                <p class="user_apelido"><?php if($Resultados['nm_nomeUsuario']){ echo $Resultados['nm_nomeUsuario'];}else{ echo "Sem apelido";} ?></p>
                <p class="qt_seguidores"><?php if($Resultados['qt_seguidor'] == null){echo "Seguidores: 0";}else{echo "Seguidores: ". $Resultados['qt_seguidor'];}?></p>
            </div>
            <div class="view_perfil" onclick="javascrit: location.href='perfil_usuario/perfilPublicacoes.php?codigo=<?php echo $Resultados['id_perfil'];?>'">
                <img src="imagens/icones/olho.png">
            </div>
        </div>

        <?php
                }
            }else{
        ?>
        <label>Não obtivemos nenhum resultado</label>
        <?php
            }
        ?>
    </div>
    <script src="javascript/jquery.js"></script>
    <script type="text/javascript">
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
    </script>
</body>
</html>