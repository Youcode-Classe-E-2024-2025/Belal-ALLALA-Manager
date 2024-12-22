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
        require_once '../../config/database.php';
    ?>
    <div class="container py-2">
        <h4>Modifier un collaboration</h4>
        <?php 
            $sqlState= $pdo->prepare('SELECT * FROM collaborations WHERE id=?');
            $id=$_GET['id'];
            $sqlState->execute([$id]);
            $collaboration=$sqlState->fetch(PDO::FETCH_ASSOC);
            if(isset($_POST['modifier'])){
                $author=$_POST['author'];
                $package=$_POST['package'];

                if(!empty($author) && !empty($package)){
                    $sqlState=$pdo->prepare('UPDATE collaborations SET id_user = ? , id_package = ? WHERE id = ?');
                    $sqlState->execute([$author,$package,$id]);
                    header('location:../collaboration.php');
                }else{
                    ?>
                        <div class="alert alert-danger" role="alert">
                            tout les champs sont obligatoire!
                        </div>
                    <?php
                }
            }
            if(isset($_POST['annuler'])){
                header('location:../index.php');
            }
        ?>
        <form method='post'>

            <div class="mb-3">
                <?php
                    $authors = $pdo->query('SELECT users.id, users.username
                                                FROM users
                                                INNER JOIN user_roles ON users.id = user_roles.id_user
                                                WHERE user_roles.id_role = 2;')->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <label class="form-label">Authors</label>
                <select class="form-select" aria-label="Default select example" name = "author">
                    <?php
                        foreach ($authors as $author){
                            if($author['id']===$collaboration['id_user']){
                                echo "<option selected value='".$author['id']."'>".$author['username']."</option>";
                            }else{
                                echo "<option value='".$author['id']."'>".$author['username']."</option>";
                            }
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
                            if($package['id']==$collaboration['package_id']){
                                echo "<option selected value='".$package['id']."'>".$package['name']."</option>";
                            }else{
                                echo "<option value='".$package['id']."'>".$package['name']."</option>";
                            }
                        }
                    ?>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary" name='modifier'>Modifier</button>
                <button type="submit" class="btn btn-primary" name='annuler'>Annuler</button>
            </div>
        </form>
    </div>

</body>

</html>