<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>modifier version</title>
</head>

<body>

    <?php 
        require_once '../../config/database.php';
    ?>

    <div class="container py-2">

    <?php 
       $sqlState= $pdo->prepare('SELECT * FROM versions WHERE id=?');
       $id=$_GET['id'];
       $sqlState->execute([$id]);
       $version=$sqlState->fetch(PDO::FETCH_ASSOC);
        if(isset($_POST['modifier'])){
            $pack=$_POST['package'];
            $ver=$_POST['version'];
            $description=$_POST['description'];

            if(!empty($pack) && !empty($ver)){
                $sqlState=$pdo->prepare('UPDATE versions SET id_package = ? , version_number = ? , release_notes = ? WHERE id = ?');
                $sqlState->execute([$pack,$ver,$description,$id]);
                header('location:../version.php');
            }else{
                ?>
                    <div class="alert alert-danger" role="alert">
                        tout les champs  sont obligatoire!
                    </div>
                <?php
            }
        }
        if(isset($_POST['annuler'])){
            header('location:../version.php');
        }
    ?>
    <h4>Modifier une Package</h4>
    <form method='post'>

        <div class="mb-3">
            <?php
                $packages = $pdo->query('SELECT * FROM packages')->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <label class="form-label">packages</label>
            <select class="form-select" aria-label="Default select example" name = "package" >
                <?php
                    foreach ($packages as $package){
                        if($package['id']==$version['package_id']){
                            echo "<option selected value='".$package['id']."'>".$package['name']."</option>";
                        }else{
                            echo "<option value='".$package['id']."'>".$package['name']."</option>";
                        }
                        
                    }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">entrer le nombre de la version</label>
            <input type="text" class="form-control" name="version" value="<?php echo $version['version_number'] ?>"></input>
        </div>

        <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Description</label>
                <input type="text" class="form-control" name="description" value="<?php echo $version['release_notes'] ?>"></input>
            </div>
        <div>
            <button type="submit" class="btn btn-primary" name='modifier'>Modifier</button>
            <button type="submit" class="btn btn-primary" name='annuler'>Annuler</button>
        </div>
    </form>
    </div>
</body>
</html>