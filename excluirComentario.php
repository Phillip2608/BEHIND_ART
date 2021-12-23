<?php
    include_once'conexao.php';

    $cod_excluir = $_GET['codigo'];

    $delet_comentario = "DELETE FROM tb_publi_comentario WHERE id_publi_comentario = :cod";
    $result_delet = $con->prepare($delet_comentario);
    $result_delet->bindParam(':cod', $cod_excluir, PDO::PARAM_STR);
    $result_delet->execute();

    echo "COMENTARIO EXCLUIDO!";

    header('Location: feed.php');
?>