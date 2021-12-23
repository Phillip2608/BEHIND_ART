<?php
    session_start();
    ob_start();
    include_once'conexao.php';

    $cod_publi = $_GET['codigo'];
    $cod_perfil = $_SESSION['id_perfil'];

    /*SELEC DA CURTIDA*/
    $select_curtir = "SELECT id_publi_like FROM tb_publi_like WHERE id_publicacao = :cd_publi AND id_perfil = :cd_perfil";
    $result_select = $con->prepare($select_curtir);
    $result_select->bindParam(':cd_publi', $cod_publi, PDO::PARAM_STR);
    $result_select->bindParam(':cd_perfil', $cod_perfil, PDO::PARAM_STR);
    $result_select->execute();
    $linhas_select = $result_select->rowCount();
    
    try{
        if($linhas_select == 1){
            $delet_curtir = "DELETE FROM tb_publi_like WHERE id_perfil = :perfil and id_publicacao = :cd_publi";
            $result_delet = $con->prepare($delet_curtir);
            $result_delet->bindParam(':perfil', $cod_perfil);
            $result_delet->bindParam(':cd_publi', $cod_publi);
            $result_delet->execute();

            $select_descurtir = "SELECT id_publicacao FROM tb_publi_like WHERE id_publicacao = :cod_publi_descurtir";
            $result_descurtir = $con->prepare($select_descurtir);
            $result_descurtir->bindParam(':cod_publi_descurtir', $cod_publi);
            $result_descurtir->execute();
            $linhas_descurtir = $result_descurtir->rowCount();

            $update_descurtir = "UPDATE tb_publicacao SET qt_curtida =:descurtir WHERE id_publicacao = :cd_publi_descurtir";
            $result_update = $con->prepare($update_descurtir);
            $result_update->bindParam(':descurtir', $linhas_descurtir);
            $result_update->bindParam(':cd_publi_descurtir', $cod_publi);
            $result_update->execute();

            header('Location: feed.php');
        }else{
            $insert_curtir = "INSERT INTO tb_publi_like(
                id_publicacao,
                id_perfil
            )VALUES(?,?)";
            $result_insert = $con->prepare($insert_curtir);
            $result_insert->bindParam(1,$cod_publi);
            $result_insert->bindParam(2,$cod_perfil);
            $result_insert->execute();

            $select_curtida = "SELECT id_publicacao FROM tb_publi_like WHERE id_publicacao = :cod_publi_like";
            $result_curtida = $con->prepare($select_curtida);
            $result_curtida->bindParam(':cod_publi_like', $cod_publi);
            $result_curtida->execute();
            $linhas_curtida = $result_curtida->rowCount();

            $update_like = "UPDATE tb_publicacao SET qt_curtida =:curtida WHERE id_publicacao = :cod_publi";
            $result_like = $con->prepare($update_like);
            $result_like->bindParam(':cod_publi', $cod_publi);
            $result_like->bindParam(':curtida', $linhas_curtida);
            $result_like->execute();
            
            header('Location: feed.php');
        }
    }catch(PDOExceptiom $e){
        echo "Error: nao foi possivel fazer essa ação!" . $e->getMessage();
    }
?>