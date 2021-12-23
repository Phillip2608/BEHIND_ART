<?php
    include_once'conexao.php';

    $cod_excluir_publi = $_GET['codigo'];

    $delet_curtir = "DELETE FROM tb_publi_like WHERE id_publicacao = :cod_curtir";
    $result_delet = $con->prepare($delet_curtir);
    $result_delet->bindParam(':cod_curtir', $cod_excluir_publi);
    $result_delet->execute();

    $delet_comentario = "DELETE FROM tb_publi_comentario WHERE id_publicacao = :cod_coment";
    $result_delet = $con->prepare($delet_comentario);
    $result_delet->bindParam(':cod_coment', $cod_excluir_publi, PDO::PARAM_STR);
    $result_delet->execute();

    $delet_publi = "DELETE FROM tb_publicacao WHERE id_publicacao = :cod";
    $result_publi = $con->prepare($delet_publi);
    $result_publi->bindParam(':cod', $cod_excluir_publi, PDO::PARAM_STR);
    $result_publi->execute();
    
    echo "EXCLUSÃO CONCLUIDA!";
    header('Location: feed.php');
?>