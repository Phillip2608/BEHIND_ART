<?php
    session_start();
    ob_start();
    include_once'conexao.php';

    if((!isset($_SESSION['id_perfil'])) AND (!isset($_SESSION['nm_perfil']))){
        $_SESSION['msg'] = "Necessário utilizar um login para acessar!";
        header("Location: login.php");
    }

    $cod = $_SESSION['id_perfil'];

    $query = "SELECT * FROM tb_perfil where id_perfil = $cod";
    $result_select = $con->prepare($query);
    $result_select->execute();
    $rows = $result_select->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST["att_perfil"])){
        $att_uploaddir = 'imagens/uploads/imagemPerfil/';
        $att_uploadfile = $att_uploaddir . basename($_FILES['att_imagem']['name']);
        $att_imagename = $att_uploaddir . basename($_FILES['att_imagem']['name']);

        $att_upFundo = 'imagens/uploads/imgFundoPerfil/';
        $att_upFileFundo = $att_upFundo . basename($_FILES['att_fundo']['name']);
        $att_fundoName = $att_upFundo . basename($_FILES['att_fundo']['name']);

        if(move_uploaded_file($_FILES['att_fundo']['tmp_name'], $att_upFileFundo)){
            $sql_update_fundo = "UPDATE tb_perfil SET im_fundo = :img_fundo WHERE id_perfil = $cod";

            $result_update_fundo = $con->prepare($sql_update_fundo);
            $result_update_fundo->bindParam(':img_fundo', $att_fundoName, PDO::PARAM_STR);
            $att_fundo = $result_update_fundo->execute();
            if(!$att_fundo){
                var_dump($result_update_fundo->errorInfo());
                exit;
            }else{
                echo "<script> alert('Perfil atualizado com sucesso!');</script>";
                header('Location: configPerfil.php');
            }
        }

        if(move_uploaded_file($_FILES['att_imagem']['tmp_name'], $att_uploadfile)){
            $sql_update = "UPDATE tb_perfil SET im_perfil=:imagem where id_perfil = $cod";
            
            $result_update = $con->prepare($sql_update);
            $result_update->bindParam(':imagem', $att_imagename, PDO::PARAM_STR);
            $att_perfil = $result_update->execute();
            if(!$att_perfil){
                var_dump($result_update->errorInfo());
                exit;
            }else{
                echo "<script> alert('Perfil atualizado com sucesso!');</script>";
                header('Location: configPerfil.php');
            }
        }
        
    }else{
        $att_usuario = $_POST['att_user'];
        $att_telefone = $_POST['att_telefone'];
        $att_biografia = $_POST['att_bio'];
    
        $sql_update_user = "UPDATE tb_perfil SET nm_nomeUsuario=:usuario WHERE id_perfil = $cod";
        $result_update_user = $con->prepare($sql_update_user);
        $result_update_user->bindParam(':usuario', $att_usuario, PDO::PARAM_STR);
        $result_update_user->execute();

        $sql_update_tell = "UPDATE tb_perfil SET id_telefone=:telefone WHERE id_perfil = $cod";
        $result_update_tell = $con->prepare($sql_update_tell);
        $result_update_tell->bindParam(':telefone', $att_telefone, PDO::PARAM_STR);
        $result_update_tell->execute();

        $sql_update_bio = "UPDATE tb_perfil SET ds_biografia=:biografia WHERE id_perfil = $cod";
        $result_update_bio = $con->prepare($sql_update_bio);
        $result_update_bio->bindParam(':biografia', $att_biografia, PDO::PARAM_STR);
        $result_update_bio->execute();
    }
    header('Location: configPerfil.php');
?>