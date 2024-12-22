<?php
    require_once '../../config/database.php';
    $id = $_GET['id'];
    $sqlState=$pdo->prepare('INSERT INTO user_roles (id_user, id_role) VALUES (?,?)');
    $sqlState->execute([$id,1]);
    header('location:../administration.php')
?>