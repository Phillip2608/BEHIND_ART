<?php
    session_start();
    ob_start();
    include_once'conexao.php';

    $cod_get_perfil = $_GET['codigo'];
    $cod_perfil_session = $_SESSION['id_perfil'];
    
    $select_seguir = "SELECT id_seguir_perfil FROM tb_seguir_perfil WHERE id_perfil = :cd_perfil_get AND id_seguindo = :cd_perfil_session";
    $result_seguir = $con->prepare($select_seguir);
    $result_seguir->bindParam(':cd_perfil_get', $cod_get_perfil, PDO::PARAM_STR);
    $result_seguir->bindParam(':cd_perfil_session', $cod_perfil_session, PDO::PARAM_STR);
    $result_seguir->execute();
    $linhas_seguir = $result_seguir->rowCount();

    if($linhas_seguir == 1){
        $delet_seguir = "DELETE FROM tb_seguir_perfil WHERE id_seguindo = :perfil_session";
        $result_delet = $con->prepare($delet_seguir);
        $result_delet->bindParam(':perfil_session', $cod_perfil_session);
        $result_delet->execute();

        $update_perfil = "UPDATE tb_perfil SET qt_seguindo = qt_seguindo - 1 WHERE id_perfil = :cd_perfil_session";
        $result_perfil = $con->prepare($update_perfil);
        $result_perfil->bindParam(':cd_perfil_session',$cod_perfil_session);
        $result_perfil->execute();

        $update_get = "UPDATE tb_perfil SET qt_seguidor = qt_seguidor - 1 WHERE id_perfil = :cd_perfil_get";
        $result_get = $con->prepare($update_get);
        $result_get->bindParam(':cd_perfil_get', $cod_get_perfil);
        $result_get->execute();
        
        header('Location: feed.php');
    }else{
        $insert = "INSERT INTO tb_seguir_perfil(
            id_perfil,
            id_seguindo
        )VALUES(?,?)";
        $result_insert = $con->prepare($insert);
        $result_insert->bindParam(1,$cod_get_perfil);
        $result_insert->bindParam(2,$cod_perfil_session);
        $result_insert->execute();

        $select_perfil = "SELECT qt_seguidor, qt_seguindo FROM tb_perfil";
        $result_select = $con->prepare($select_perfil);
        $result_select->execute();
        $row_perfil = $result_select->fetch(PDO::FETCH_ASSOC);
        $row_perfil['qt_seguindo'] = 0;
        $row_perfil['qt_seguidor'] = 0;

        $update_perfil = "UPDATE tb_perfil SET qt_seguindo = :qt_seguindo + 1 WHERE id_perfil = :cd_perfil_session";
        $result_perfil = $con->prepare($update_perfil);
        $result_perfil->bindParam(':cd_perfil_session',$cod_perfil_session);
        $result_perfil->bindParam(':qt_seguindo', $row_perfil['qt_seguindo']);
        $result_perfil->execute();

        $update_get = "UPDATE tb_perfil SET qt_seguidor= :qt_seguidor + 1 WHERE id_perfil = :cd_perfil_get";
        $result_get = $con->prepare($update_get);
        $result_get->bindParam(':cd_perfil_get', $cod_get_perfil);
        $result_get->bindParam(':qt_seguidor', $row_perfil['qt_seguidor']);
        $result_get->execute();

        header('Location: feed.php');
    }
    
?>