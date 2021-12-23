<?php
    ob_start();
    include_once'../conexao.php';

    $nm_perfil = $_POST['nm_perfil'];
    $nm_email = $_POST['nm_email'];
    $id_senha = $_POST['id_senha'];
    $dt_nascimento = $_POST['dt_nascimento'];
    $passCripto = password_hash($id_senha, PASSWORD_DEFAULT);

    $select_perfil = "SELECT id_perfil FROM tb_perfil WHERE nm_email = :email";
    $result_select = $con->prepare($select_perfil);
    $result_select->bindParam('email', $nm_email, PDO::PARAM_STR);
    $result_select->execute();
    $linhas_email = $result_select->rowCount();

    if($linhas_email == 1){
        echo "Não é possível utilizar o mesmo email!";
    }else{
        $insert_perfil ="INSERT INTO tb_perfil(
            nm_perfil,
            nm_email,
            id_senha,
            dt_nascimento
        )VALUES(?,?,?,?)";
        $result_insert = $con->prepare($insert_perfil);
        $result_insert->bindParam(1,$nm_perfil);
        $result_insert->bindParam(2,$nm_email);
        $result_insert->bindParam(3,$passCripto);
        $result_insert->bindParam(4,$dt_nascimento);

        $result_insert->execute();

        header('Location: loginPerfil.php');
    }

?>