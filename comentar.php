<?php
    session_start();
    ob_start();
    include_once'conexao.php';

    $cod_perfil = $_SESSION['id_perfil'];
    $cod_publi = $_GET['codigo'];
    $ds_comentario = $_POST['ds_comentario'];

    $insert_coment = "INSERT INTO tb_publi_comentario(
        id_perfil,
        id_publicacao,
        ds_comentario
    )VALUES(?,?,?)";

    $result_coment = $con->prepare($insert_coment);
    $result_coment->bindParam(1,$cod_perfil);
    $result_coment->bindParam(2,$cod_publi);
    $result_coment->bindParam(3,$ds_comentario);
    $result_coment->execute();
    
    header('Location: feed.php');
?>