<?php
    session_start();
    ob_start();
    include_once'conexao.php';

    if((!isset($_SESSION['id_perfil'])) AND (!isset($_SESSION['nm_perfil']))){
        $_SESSION['msg'] = "Necessário utilizar um login para acessar!";
        header("Location: login.php");
    }

    $cod = $_SESSION['id_perfil'];

    $sql_update = "UPDATE tb_perfil SET im_fundo=null where id_perfil = $cod";
    $result_update = $con->prepare($sql_update);
    $att_perfil = $result_update->execute();

    header('Location: configPerfil.php');
?>