<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>modifier package</title>
</head>

<body>

    <?php 
        require_once '../../config/database.php';
    ?>

    <div class="container py-2">

    <?php 
       $sqlState= $pdo->prepare('SELECT * FROM packages WHERE id=?');
       $id=$_GET['id'];
       $sqlState->execute([$id]);
       $package=$sqlState->fetch(PDO::FETCH_ASSOC);
        if(isset($_POST['modifier'])){
            $name=$_POST['name'];
            $description=$_POST['description'];

            if(!empty($name) && !empty($description)){
                $sqlState=$pdo->prepare('UPDATE packages SET name = ? , description = ? WHERE id = ?');
                $sqlState->execute([$name,$description,$id]);
                header('location:../package.php');
            }else{
                ?>
                    <div class="alert alert-danger" role="alert">
                        username et password sont obligatoire!
                    </div>
                <?php
            }
        }
        if(isset($_POST['annuler'])){
            header('location:../package.php');
        }
    ?>
    <h4>Modifier une Package</h4>
    <form method='post'>

        <div class="mb-3">
            <label class="form-label">Le nom de package js</label>
            <input type="text" class="form-control" name='name' value="<?php echo $package['name'] ?>">
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" value="<?php echo $package['description'] ?>"></input>
        </div>
        <div>
            <button type="submit" class="btn btn-primary" name='modifier'>Modifier</button>
            <button type="submit" class="btn btn-primary" name='annuler'>Annuler</button>
        </div>
    </form>
    </div>
</body>
</html>