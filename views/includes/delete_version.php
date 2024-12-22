<?php
    require_once '../../config/database.php';
    $id = $_GET['id'];
    $sqlState = $pdo->prepare('DELETE FROM versions WHERE id=?');
    $supprime = $sqlState->execute([$id]);
    header('location:../version.php')
?>