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
    ?>

    <div class="container py-2">

    <?php 
        if(isset($_POST['ajouter'])){
            $author=$_POST['author'];

            if(!empty($author)){
                $sqlState=$pdo->prepare('INSERT INTO user_roles (id_user, id_role) VALUES (?,?)');
                $sqlState->execute([$author,2]);
                ?>
                    <div class="alert alert-success" role="alert">
                        l'author est ajouter avec succée
                    </div>
                <?php
            }else{
                ?>
                    <div class="alert alert-danger" role="alert">
                        le nom et l'email sont obligatoire!
                    </div>
                <?php
            }
        }
    ?>
        <h4>Ajouter un author</h4>
        <form method='post'>
            <div class="mb-3">
                <?php
                    $users = $pdo->query('SELECT * FROM users')->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <label class="form-label">packages</label>
                <select class="form-select" aria-label="Default select example" name = "author">
                    <?php
                        foreach ($users as $user){
                            echo "<option value='".$user['id']."'>".$user['username']."</option>";
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name='ajouter'>Ajouter</button>
        </form>
    </div>
    <div class="container py-2">
        <h4>TABLEAU DES AUTHORS</h4>
        <?php
            $authors = $pdo->query('SELECT *
                                    FROM users
                                    WHERE id IN (
                                    SELECT id_user
                                    FROM user_roles
                                    WHERE id_role = 2
                                    );')->fetchAll(PDO::FETCH_ASSOC);
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
                    foreach($authors as $author){
                        ?>
                        <tr>
                            <td><?php echo $author['id'] ?></td>
                            <td><?php echo $author['username'] ?></td>
                            <td><?php echo $author['email'] ?></td>
                            <?php if ($id_role===3){ ?>
                            <td>
                            <a href="includes/modifier_author.php?id=<?php echo $author['id'] ?>" class="btn btn-primary btn-sm" >Modifier</a>
                            <a href="includes/delete_author.php?id=<?php echo $author['id'] ?>" onclick="return confirm('Vouler vous vraiment supprimer le author <?php echo $author['username'] ?>')" class="btn btn-danger btn-sm" >Supprimer</a>
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