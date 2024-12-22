<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Collaboration</title>
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
    <?php
        if ($id_role===2 || $id_role===3){
            ?>

    <div class="container py-2">
        <h4>Ajouter un collaboration</h4>
        <?php 
            if(isset($_POST['ajouter'])){
                $author=$_POST['author'];
                $package=$_POST['package'];

                if(!empty($author) && !empty($package)){
                    $sqlState=$pdo->prepare('INSERT INTO collaborations (id_user, id_package) VALUES (?,?)');
                    $sqlState->execute([$author,$package]);
                    ?>
                        <div class="alert alert-success" role="alert">
                            la collaboration est ajouter avec succée
                        </div>
                    <?php
                }else{
                    ?>
                        <div class="alert alert-danger" role="alert">
                            tout les champs sont obligatoire!
                        </div>
                    <?php
            }
        }
    ?>
        
        <form method='post'>

            <div class="mb-3">
                <?php
                    $authors = $pdo->query('SELECT users.id, users.username
                                                FROM users
                                                INNER JOIN user_roles ON users.id = user_roles.id_user
                                                WHERE user_roles.id_role = 2;
                                            ')->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <label class="form-label">Authors</label>
                <select class="form-select" aria-label="Default select example" name = "author">
                    <?php
                        foreach ($authors as $author){
                            echo "<option value='".$author['id']."'>".$author['username']."</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <?php
                    $packages = $pdo->query('SELECT * FROM packages')->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <label class="form-label">packages</label>
                <select class="form-select" aria-label="Default select example" name = "package">
                    <?php
                        foreach ($packages as $package){
                            echo "<option value='".$package['id']."'>".$package['name']."</option>";
                        }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name='ajouter'>Ajouter</button>
        </form>
        <?php
            }
        ?>
    </div>

    <div class="container py-2">
        <h4>TABLEAU DES COLLABORATIONS</h4>
        <?php
            $collaborations = $pdo->query("SELECT 
                                        collaborations.id AS id, 
                                        users.username AS author, 
                                        packages.name AS package
                                    FROM 
                                        collaborations
                                    INNER JOIN 
                                        users 
                                    ON 
                                        collaborations.id_user = users.id
                                    INNER JOIN 
                                        packages 
                                    ON 
                                        collaborations.id_package = packages.id;
                                    ")->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Packages</th>
                <th>Authors</th>
                <?php
                if ($id_role === 3){
                ?>
                <th>Opérations</th>
                <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($collaborations as $collaboration){
                        ?>
                        <tr>
                            <td><?php echo $collaboration['id'] ?></td>
                            <td><?php echo $collaboration['package'] ?></td>
                            <td><?php echo $collaboration['author'] ?></td>
                            <?php
                                if ($id_role === 3){
                            ?>
                            <td>
                                <a href="includes/modifier_collaboration.php?id=<?php echo $collaboration['id'] ?>" class="btn btn-primary btn-sm" >Modifier</a>
                                <a href="includes/delete_collaboration.php?id=<?php echo $collaboration['id'] ?>" onclick="return confirm('Vouler vous vraiment supprimer la collaboration d id <?php echo $collaboration['id'] ?>')" class="btn btn-danger btn-sm" >Supprimer</a>
                            </td>
                            <?php
                            }
                            ?>
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