<?php
    session_start();
    ob_start();
    include_once'conexao.php';

    if((!isset($_SESSION['id_perfil'])) AND (!isset($_SESSION['nm_perfil']))){
        $_SESSION['msg'] = "Necessário utilizar um login para acessar!";
        header("Location: login.php");
    }

    $cod_perfil = $_SESSION['id_perfil'];

    $cod_coment = $_GET['cd_coment'];

    $cod_publi = $_GET['cod_publi'];

    $ds_respost = $_POST['ds_respost_coment'];

    $insert_respost = "INSERT INTO tb_respost_coment(
        id_publi_comentario,
        id_publicacao,
        id_perfil,
        ds_respost_coment
    )VALUES(?,?,?,?)";
    $result_respost = $con->prepare($insert_respost);
    $result_respost->bindParam(1,$cod_coment);
    $result_respost->bindParam(2,$cod_publi);
    $result_respost->bindParam(3,$cod_perfil);
    $result_respost->bindParam(4,$ds_respost);

    $result_respost->execute();

    header('Location: feed.php');
?>