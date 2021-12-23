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
    $_SESSION['im_fundo'] = $row_perfil['im_fundo'];
    
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
            z-index:1;
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
            z-index:2;
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

        .menu_lateral{
            position:fixed;
            top:7%;
            width:40%;
            height:100%;
            background-color:#E9E1F0;
        }

        .area_button_opcoes{
            position:fixed;
            top:48%;
            left:10%;
            width:20%;
        }

        .area_button_opcoes button{
            width:100%;
            padding:2%;
            border-style:none;
            border-radius:50px;
            cursor:pointer;
            font-size:20px;
            font-weight:bold;
            color:#E9E1F0;
            background-color:#1BAE98;
            transition:all .3s;
            margin-top:3%;
        }

        .area_button_opcoes button:hover{
            transform:scale(1.05);
            background-color:#3CDDC0;
        }

        .logo_behind{
            position:fixed;
            top:30%;
            left:45%;
            width:50%;
            height:50%;
            object-fit:contain;
            z-index:-1;
            opacity:45%;
        }

        .painel_fundo{
            width:100%;
            height:28vh;
            background-color:#C7BDCF;
        }

        #img_fundo{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .img_perfil img{
            position:fixed;
            left:15%;
            top:22%;
            background-color:#C7BDCF;
            width:8vw;
            height:8vw;
            object-fit:cover;
            border-radius:100px;
            border-style:solid;
            border-color:#E9E1F0;
            border-width:10px;
        }

        .add_image img{
            position:fixed;
            left:22%;
            top:35%;
            width:2vw;
            height:2vw;
            background-color:#1BAE98;
            border-radius:100px;
            object-fit:contain;
            border-style:solid;
            border-width:4px;
            border-color:#1BAE98;
            cursor:pointer;
            transition: all .3s;
        }

        .add_image img:hover{
            transform: scale(1.1);
            background-color:#3CDDC0;
            border-color:#3CDDC0;
        }

        .add_fundo img{
            position:fixed;
            left:35%;
            top:32%;
            width:2vw;
            height:2vw;
            background-color:#1BAE98;
            border-radius:100px;
            object-fit:contain;
            border-style:solid;
            border-width:4px;
            border-color:#1BAE98;
            cursor:pointer;
            transition: all .3s;
        }

        .add_fundo img:hover{
            transform: scale(1.1);
            background-color:#3CDDC0;
            border-color:#3CDDC0;
        }

        .opcoes_fundo{
            position:fixed;
            left:37%;
            top:37%;
            display:none;
            box-shadow: 0px 2px 2px 2px rgba(0, 0, 0, 0.3);
            background-color:#C7BDCF;
            padding:2px;
        }

        .opcoes_fundo p{
            font-size:1.35vw;
            font-weight:bold;
            padding:2px;
            cursor:pointer;
        }

        .opcoes_fundo p:hover{
            background-color:#E9E1F0;
        }
   
        .form_fundo{
            position:fixed;
            left:38%;
            top:22%;
            width:60vh;
            height:60vh;
            background-color:#E9E1F0;
            display:none;
            border-radius:30px;
        }

        .form_fundo p{
            margin-top:4%;
            font-weight:bold;
        }

        .form_fundo .area_butoes_fundo{
            margin-top:20%;
        }

        .opcoes_image{
            position:fixed;
            left:24%;
            top:40%;
            display:none;
            box-shadow: 0px 2px 2px 2px rgba(0, 0, 0, 0.3);
            background-color:#C7BDCF;
            padding:2px;
        }

        .opcoes_image p{
            font-size:1.35vw;
            font-weight:bold;
            padding:2px;
            cursor:pointer;
        }

        .opcoes_image p:hover{
            background-color:#E9E1F0;
        }

        .espaco_modal{
            width:100%;
            height:100%;
            position:fixed;
            top:0px;
            left:0px;
            background-color: rgba(0,0,0,0.5);
            display:none;
        }

        .form_imagem{
            position:fixed;
            left:38%;
            top:22%;
            width:50vh;
            height:60vh;
            background-color:#E9E1F0;
            display:none;
            border-radius:30px;
        }

        #img_fundo_att{
            width:90%;
            height:30%;
            border-radius:30px;
            margin-top:4%;
            object-fit:cover;
            background-color:#C7BDCF;
            transition: all .3s;
            cursor:pointer;
        }

        #img_fundo_att:hover{
            transform:scale(1.025);
        }

        .form_imagem p{
            margin-top:3%;
            font-size:1.30vw;
            font-weight:bold;
        }

        .centro_att_imagem{
            width:20vh;
            margin-left:auto;
            margin-right:auto;
        }

        #img_att{
            margin-top:5%;
            width:20vh;
            height:20vh;
            border-radius:100px;
            object-fit:cover;
            cursor:pointer;
            transition: all .3s;
            background-color:#C7BDCF;
        }

        #img_att:hover{
            transform:scale(1.05);
        }

        #select_file{
            display:none;
        }

        #select_file_fundo{
            display:none;
        }

        .area_butoes_img{
            margin-top:25%;
        }

        .btn_img{
            margin-top:5%;
            width:85%;
            font-size:18px;
            border-radius:50px;
            outline:none;
            border-style:none;
            cursor:pointer;
            background-color:#1BAE98;
            color:#E9E1F0;
            padding:5px;
            font-weight:bold;
            transition: all .3s;
        }

        #btn_confirm:hover{
            transform:scale(1.05);
            background-color:#3CDDC0;
        }

        #btn_cancel:hover{
            transform:scale(1.05);
            background-color:#F24452;
        }

        .excluir_img{
            width:50vh;
            position:fixed;
            left:38%;
            top:40%;
            background-color:#E9E1F0;
            display:block;
            text-align:center;
            padding:10px;
            border-radius:25px;
            display:none;
        }

        .btns_excluir{
            width:100%;
            margin-top:5%;
        }

        .btn_excluir{
            width:40%;
            font-size:18px;
            border-radius:50px;
            outline:none;
            border-style:none;
            cursor:pointer;
            background-color:#1BAE98;
            color:#E9E1F0;
            padding:5px;
            font-weight:bold;
            transition: all .3s;
        }

        #confirm_excluir:hover{
            transform:scale(1.05);
            background-color:#3CDDC0;
        }

        #cancel_excluir:hover{
            transform:scale(1.05);
            background-color:#F24452;
        }

        #confirm_excluir_fundo:hover{
            transform:scale(1.05);
            background-color:#3CDDC0;
        }

        #cancel_excluir_fundo:hover{
            transform:scale(1.05);
            background-color:#F24452;
        }

        .area_att_dados{
            position:absolute;
            left:40%;
            top:8%;
            width:60%;
            height:90%;
            z-index:0;
            display:none;
            background-color:#181C27;
        }

        .area_att_dados h3{
            text-align:center;
            font-size:35px;
            color:#1BAE98;
        }

        .att_contetudo{
            width:80%;
            margin-left:auto;
            margin-right:auto;
        }

        .att_contetudo #biografia{
            margin-top:4%;
            text-align:center;
            font-size:25px;
            color:#1BAE98;
        }

        .att_ladinho{
            display:flex;
            flex-direction:row;
            justify-content:space-around;
            flex-wrap:wrap;
        }

        .att_ladinho div{
            width:40%;
            display:flex;
            flex-direction:column;
            margin-top:5%;
        }

        .att_ladinho div input{
            margin-top:5%;
            padding:2%;
            border-radius:2px;
            background-color:#181C27;
            border-style:none none solid none;
            border-color:#E9E1F0;
            color:#E9E1F0;
            font-size:18px;
            outline:none;
            font-weight:bold;
        }

        .att_ladinho div h4{
            font-size:25px;
            color:#1BAE98;
        }

        .area_biografia{
            width:90%;
            margin-left:auto;
            margin-right:auto;
            margin-top:2%;
        }

        .area_biografia textarea{
            width:100%;
            resize:none;
            outline:none;
            background-color:#C7BDCF;
            border-radius:10px;
            font-size:18px;
        }

        #enviar_att{
            width:100%;
            outline:none;
            cursor:pointer;
            padding:2%;
            margin-top:3%;
            border-radius:50px;
            border-style:none;
            margin-bottom:4%;
            font-size:20px;
            color:#E9E1F0;
            font-weight:bold;
            background-color:#1BAE98;
            transition: all .3s;
        }

        #enviar_att:hover{
            background-color:#3CDDC0;
            transform:scale(1.05);
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

    <!-- MENU LATERAL -->
    <nav class="menu_lateral">
        <div class="painel_fundo">
            <img id="img_fundo" src="<?php if($_SESSION['im_fundo']){echo $_SESSION['im_fundo'];}else{ echo 'imagens/icones/paisagem_fundo.png';} ?>">
        </div>
        <div class="img_perfil">
            <img src="<?php if($_SESSION['im_perfil']){ echo $_SESSION['im_perfil'];}else{ echo 'imagens/icones/padraoPerfil.png';} ?>">
        </div>
        <div class="add_image">
            <img src="imagens/icones/mais3.png">
        </div>
        <div class="add_fundo">
            <img src="imagens/icones/mais3.png">
        </div>

        <div class="opcoes_fundo">
            <p onclick="mostrarFundo()">Trocar Fundo</p>
            <p onclick="confirmarExcluirFundo()">Remover Fundo</p>
        </div>
        
        <div class="opcoes_image">
            <p onclick="mostrarIMG()">Trocar imagem</p>
            <p onclick="confirmarExcluir()">Remover imagem</p>
        </div>
        <div class="area_button_opcoes">
            <button class="att_dados" onclick="att_perfil()">Atualizar dados</button>
        </div>
        
    </nav>
    <img src="imagens/BDapng.png" class="logo_behind">
    <!-- FIM MENU LATERAL -->

    <!--AREA ATT DADOS-->
    <section class="area_att_dados" id="area_att_dados">
        <h3> Atualizar dados </h3>
        <main class="att_contetudo">
            <form action="attPerfil.php" method="POST">
                <div class="att_ladinho">
                    <div>
                        <h4>Nomes</h4>
                        <input type="text" name="att_name" placeholder="<?php echo $row_perfil['nm_perfil']; ?>" disabled="">
                        <input type="text" name="att_user" value="<?php if($row_perfil['nm_nomeUsuario']){ echo $row_perfil['nm_nomeUsuario'];}else{echo 'Digite um apelido...';} ?>">
                    </div>
                    <div>
                        <h4>Conta</h4>
                        <input type="text" name="att_email" placeholder="<?php echo $row_perfil['nm_email']; ?>" disabled="">
                        <input type="text" name="att_senha" placeholder="<?php echo $row_perfil['id_senha']; ?>" disabled="">
                    </div>
                    <div>
                        <h4>Contato</h4>
                        <input type="text" name="att_telefone" value="<?php if($row_perfil['id_telefone']){echo $row_perfil['id_telefone'];}else{echo 'Digite seu telefone';} ?>">
                    </div>
                    <div>
                        <h4>Aniversário</h4>
                        <input type="date" name="att_nasci" value="<?php echo $row_perfil['dt_nascimento']; ?>" disabled="">
                    </div>
                </div>
                <h4 id="biografia"> Biografia </h4>
                <div class="area_biografia">
                    <textarea rows="8" name="att_bio">
                        <?php
                            if($row_perfil['ds_biografia']){
                                echo $row_perfil['ds_biografia'];
                            }else{
                                echo "Fale um pouco sobre você...";
                            }
                        ?>
                    </textarea>
                    <input type="submit" id="enviar_att" value="Atualizar">
                </div>
            </form>
        </main>
    </section>
    <!--FIM ATT DADOS-->

    <!--VISU DE FUNDO-->
    <section id="espaco_modal_fundo" class="espaco_modal">
        <div class="form_fundo" id="form_fundo">
            <form action="attPerfil.php" method="POST" enctype="multipart/form-data">
                <center>            
                    <img src="<?php if($_SESSION['im_fundo']){ echo $_SESSION['im_fundo'];}else{ echo 'imagens/icones/paisagem_fundo.png';} ?>" id="img_fundo_att">
                    <p>Clique na imagem para alterar</p>
                    <input type="file" id="select_file_fundo" name="att_fundo" accept="image/*">
                    <div class="area_butoes_fundo">
                        <input type="submit" name="att_perfil" class="btn_img" id="btn_confirm" value="Confirmar">
                        <div class="btn_img" onclick="cancelarFUNDO()" id="btn_cancel"> Cancelar </div>
                    </div>
                </center>
            </form>   
        </div>
    </section>    
    <!--FIM VISU FUNDO-->

    <!--VISU EXCLUIR FUNDO-->
    <section id="espaco_modal_excluir_fundo" class="espaco_modal">
        <div class="excluir_img" id="excluir_fundo">
            <h3>Deseja mesmo remover sua capa de fundo?</h3>
            <div class="btns_excluir">
                <button class="btn_excluir" id="confirm_excluir_fundo" onclick="javascript: location.href='remove_imgFundo.php'">Remover</button>
                <button class="btn_excluir" id="cancel_excluir_fundo" onclick="cancel_excluir_fundo()">Cancelar</button>
            </div>
        </div>
    </section>
    <!--FIM EXCLUIR FUNDO-->

    <!--VISU DE IMAGEM -->
    <section id="espaco_modal" class="espaco_modal">
        <div class="form_imagem" id="form_imagem">
            <form action="attPerfil.php" method="POST" enctype="multipart/form-data">
                <center>            
                    <img src="<?php if($_SESSION['im_perfil']){ echo $_SESSION['im_perfil'];}else{ echo 'imagens/icones/padraoPerfil.png';} ?>" id="img_att">
                    <p>Clique na imagem para alterar</p>
                    <input type="file" id="select_file" name="att_imagem" accept="image/*">
                    <div class="area_butoes_img">
                        <input type="submit" name="att_perfil" class="btn_img" id="btn_confirm" value="Confirmar">
                        <div class="btn_img" onclick="cancelarIMG()" id="btn_cancel"> Cancelar </div>
                    </div>
                </center>
            </form>   
        </div>
    </section>
    <!-- FIM VISU IMAGEM -->

    <!-- CONFIRMA EXCLUIR -->
    <section id="espaco_modal_excluir" class="espaco_modal">
        <div class="excluir_img" id="excluir_img">
            <h3>Deseja mesmo remover sua foto de perfil?</h3>
            <div class="btns_excluir">
                <button class="btn_excluir" id="confirm_excluir" onclick="javascript: location.href='remove_img.php'">Remover</button>
                <button class="btn_excluir" id="cancel_excluir" onclick="cancel_excluir()">Cancelar</button>
            </div>
        </div>
    </section>
    <!-- FIM CONFIRMA EXCLUIR -->
    
    <script src="javascript/jquery.js"></script>
    <script>
        /*APARECER FORM ATT_PERFIL*/
        function att_perfil(){
            var area_att_dados = document.getElementById('area_att_dados');

            area_att_dados.style.display="block";
        }

        /*APARECER FORM IMG*/
        function mostrarIMG(){
            var espaco_modal = document.getElementById('espaco_modal');
            var form_imagem = document.getElementById('form_imagem');

            espaco_modal.style.display= "block";
            form_imagem.style.display = "block";
        }

        function cancelarIMG(){
            var espaco_modal = document.getElementById('espaco_modal');
            var form_imagem = document.getElementById('form_imagem');

            espaco_modal.style.display= "none";
            form_imagem.style.display = "none";
        }
        /*TIRAR FUNDO ESCURO*/

        /*APARECER FORM FUNDO*/
        function mostrarFundo(){
            var espaco_modal = document.getElementById('espaco_modal_fundo');
            var form_fundo = document.getElementById('form_fundo');

            espaco_modal.style.display = "block";
            form_fundo.style.display = "block";
        }

        function cancelarFUNDO(){
            var espaco_modal = document.getElementById('espaco_modal_fundo');
            var form_fundo = document.getElementById('form_fundo');

            espaco_modal.style.display = "none";
            form_fundo.style.display="none";
        }

        var img_fundo_att = document.getElementById('img_fundo_att');
        var select_file_fundo = document.getElementById('select_file_fundo');

        img_fundo_att.addEventListener('click', () =>{
            select_file_fundo.click();
        });

        select_file_fundo.addEventListener('change', (event_fundo) => {
            if(select_file_fundo.files.length <= 0){
                return;
            }

            var reader_fundo = new FileReader();

            reader_fundo.onload = () => {
                img_fundo_att.src = reader_fundo.result;
            }

            reader_fundo.readAsDataURL(select_file_fundo.files[0]);
        });

        /*APARECER EXCLUIR*/
        function confirmarExcluirFundo(){
            var espaco_modal = document.getElementById('espaco_modal_excluir_fundo');
            var excluir_fundo = document.getElementById('excluir_fundo');

            espaco_modal.style.display="block";
            excluir_fundo.style.display="block";
        }

        function cancel_excluir_fundo(){
            var espaco_modal = document.getElementById('espaco_modal_excluir_fundo');
            var excluir_fundo = document.getElementById('excluir_fundo');

            espaco_modal.style.display="none";
            excluir_fundo.style.display="none";
        }

        function confirmarExcluir(){
            var espaco_modal = document.getElementById('espaco_modal_excluir');
            var excluir_img = document.getElementById('excluir_img');

            espaco_modal.style.display="block";
            excluir_img.style.display="block";
        }

        function cancel_excluir(){
            var espaco_modal = document.getElementById('espaco_modal_excluir');
            var excluir_img = document.getElementById('excluir_img');

            espaco_modal.style.display="none";
            excluir_img.style.display="none";
        }
        /*FIM EXCLUIR*/

        var viewImage = document.getElementById('img_att')
        var select_file = document.getElementById('select_file');

        viewImage.addEventListener('click', () => {
            select_file.click();
        });

        select_file.addEventListener('change', (event) => {
            if(select_file.files.length <= 0){
                return;
            }

            var reader = new FileReader();

            reader.onload = () => {
                viewImage.src = reader.result;
            }

            reader.readAsDataURL(select_file.files[0]);
        });

        var enviarBusca = document.getElementById('enviarBusca');
        var busca = document.getElementById('busca');

        enviarBusca.addEventListener('click', () => {
            busca.click();
        });

        $(document).ready(function() {
            var botao = $('.barrinhas');
            var dropDown = $('.opcoes_user');

            var add_image = $('.add_image');
            var opcoes_image = $('.opcoes_image');   

            var add_fundo = $('.add_fundo');
            var opcoes_fundo = $('.opcoes_fundo');

            botao.on('click', function(event){
                dropDown.stop(true,true).slideToggle();
                event.stopPropagation();
            });

            add_image.on('click', function(event2){
                opcoes_image.stop(true,true).slideToggle();
                event2.stopPropagation();
            });

            add_fundo.on('click', function(event3){
                opcoes_fundo.stop(true, true).slideToggle();
                event3.stopPropagation();
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
