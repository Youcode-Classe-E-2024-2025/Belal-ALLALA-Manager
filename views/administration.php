<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Authors</title>
</head>

<body>

    <?php 
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: connexion.php");
            exit;
        }
        require_once '../config/database.php';
        $user_id=$_SESSION['user_id'];
        $roles=$pdo->prepare('SELECT id_role FROM user_roles WHERE id_user=?');
        $roles->execute([$user_id]);
        $role= $roles->fetch(PDO::FETCH_ASSOC);
        if (!$role) {
            echo "Vous n'avez pas les autorisations nécessaires pour accéder à cette page.";
            exit;
        } else {
            $id_role = $role['id_role'];
            include 'includes/nav1.php' ;
            ?>

    <div class="container py-2">
        <h4>TABLEAU des nouseau utulisateur</h4>
        <?php
            $users = $pdo->query('SELECT * 
                                        FROM users 
                                        WHERE id NOT IN (SELECT id_user FROM user_roles);
                                        ')->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <?php if ($id_role===3){ ?>
                <th>Opérations</th>
                <?php } ?>

            </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($users as $user){
                        ?>
                        <tr>
                            <td><?php echo $user['id'] ?></td>
                            <td><?php echo $user['username'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <?php if ($id_role===3){ ?>
                            <td>
                            <a href="includes/accepter.php?id=<?php echo $user['id'] ?>" class="btn btn-primary btn-sm" >Accépter</a>
                            <a href="includes/refuser.php?id=<?php echo $user['id'] ?>" onclick="return confirm('Vouler vous vraiment supprimer cette utulisateur <?php echo $user['username'] ?>')" class="btn btn-danger btn-sm" >Refuser</a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</body>
</html>