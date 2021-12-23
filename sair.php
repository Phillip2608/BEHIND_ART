<?php
    session_start();
    ob_start();

    $validade = time() - 3600;

    setcookie("perfil", "", $validade,"/","", false, true);

    unset($_SESSION['id_perfil'], $_SESSION['nm_nome']);

    header("Location: cad_login/loginPerfil.php");
?>