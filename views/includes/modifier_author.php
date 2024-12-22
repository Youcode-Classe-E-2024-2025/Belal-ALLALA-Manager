<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>modifier author</title>
</head>

<body>

    <?php 
        require_once '../../config/database.php';
    ?>

    <div class="container py-2">

    <?php 
        $sqlState= $pdo->prepare('SELECT * FROM users WHERE id=?');
        $id=$_GET['id'];
        $sqlState->execute([$id]);
        $author=$sqlState->fetch(PDO::FETCH_ASSOC);
        if(isset($_POST['modifier'])){
            $name=$_POST['name'];
            $email=$_POST['email'];

            if(!empty($name) && !empty($email)){
                $sqlState=$pdo->prepare('UPDATE users SET username = ? , email = ? WHERE id = ?');
                $sqlState->execute([$name,$email,$id]);
                header('location:../author.php');
            }else{
                ?>
                    <div class="alert alert-danger" role="alert">
                        tout les champs sont obligatoire!
                    </div>
                <?php
            }
        }
        if(isset($_POST['annuler'])){
            header('location:../author.php');
        }
    ?>
    <h4>Modifier une Package</h4>
    <form method='post'>

        <div class="mb-3">
            <label class="form-label">Le nom d'author</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($author['username']); ?>">
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">email</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($author['email']); ?>">
        </div>
        <div>
            <button type="submit" class="btn btn-primary" name='modifier'>Modifier</button>
            <button type="submit" class="btn btn-primary" name='annuler'>Annuler</button>
        </div>
    </form>
    </div>
</body>
</html>