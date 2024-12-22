<?php
    require_once '../../config/database.php';
    $id = $_GET['id'];
    $sqlCollaboration = $pdo->prepare('DELETE FROM collaborations WHERE id_user = ?');
    $sqlCollaboration->execute([$id]);
    $sqlCollabo = $pdo->prepare('DELETE FROM user_roles WHERE id_user = ?');
    $sqlCollabo->execute([$id]);
    $sqlStat=$pdo->prepare('INSERT INTO user_roles (id_user, id_role) VALUES (?,?)');
    $sqlStat->execute([$id,1]);
    header('location:../author.php')
?>