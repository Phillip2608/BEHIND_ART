<?php
    session_start();
    ob_start();
    include_once'conexao.php';

    $cod_perfil = $_SESSION['id_perfil'];

    $ds_publicacao = $_POST['ds_publicacao'];
            
    $uploaddir = 'imagens/uploads/imgPublicacao';
    $uploadfile = $uploaddir . basename($_FILES['img_publicacao']['name']);
    $imagename = $uploaddir . basename($_FILES['img_publicacao']['name']);
    if(move_uploaded_file($_FILES['img_publicacao']['tmp_name'], $uploadfile)){
        $insert_publi ="INSERT INTO tb_publicacao(
            id_perfil,
            ds_publicacao,
            im_publicacao
        )VALUES('$cod_perfil','$ds_publicacao','$imagename')";
        $result_publiComent = $con->query($insert_publi);
        if($result_publiComent){
            header("Location: feed.php");
        }
        
    }else{
        $insert_publi2 ="INSERT INTO tb_publicacao(
            id_perfil,
            ds_publicacao
        )VALUES('$cod_perfil','$ds_publicacao')";
        $result_publiComent2 = $con->query($insert_publi2);
        if($result_publiComent2){
            header("Location: feed.php");
        }
    }
?>