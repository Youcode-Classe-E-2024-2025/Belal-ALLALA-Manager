<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Connexion</title>
</head>
<body>
  <?php include 'includes/nav.php' ?>
  <div class="container py-2">
    <?php
        if(isset($_POST['connexion'])){
            $email=$_POST['email'];
            $password=$_POST['password'];
            $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            $passwordRegex = '/^.{8,}$/';

            if (!preg_match($emailRegex, $email)) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        Email incorrect!
                    </div>
                <?php 
                exit;
            }
            if (!preg_match($passwordRegex, $password)) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        Le mot de passe doit comporter au moins 8 caractères.
                    </div>
                <?php 
                exit;
            }

            if( !empty($email) && !empty($password)){
                require_once '../config/database.php';
                $sqlState = $pdo->prepare('SELECT * FROM users WHERE email=?');
                $sqlState ->execute([$email]);
                if($sqlState->rowCount() > 0){
                    $user = $sqlState->fetch(PDO::FETCH_ASSOC);
                    if (password_verify($password, $user['password_hash'])) {
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        header('location:collaboration.php');
                        
                    } else {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            Mot de passe incorrect!
                        </div>
                    <?php 
                    }
                }else{
                    ?>
                        <div class="alert alert-danger" role="alert">
                            Email incorrect!
                        </div>
                    <?php 
                }
            }else{
                ?>
                  <div class="alert alert-danger" role="alert">
                  Tous les champs sont obligatoires!
                  </div>
                <?php
            }
        }
    ?>
    <h4>Connexion</h4>
    <form name="loginForm" method="post" onsubmit="return validateForm()">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" oninput="checkFields()">
        <div id="email-error" class="text-danger"></div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" name="password" oninput="checkFields()">
        <div id="password-error" class="text-danger"></div>
      </div>
      <button type="submit" class="btn btn-primary" id="submitBtn" name="connexion" disabled>Connexion</button>
    </form>
  </div>

    <script src="../assets/js/script.js"></script>
    <script>
    function validateForm() {
        var email = document.forms["loginForm"]["email"].value;
        var password = document.forms["loginForm"]["password"].value;
        var submitButton = document.getElementById("submitBtn");
        let valide = true;

        if (!is_valid_email(email)) {
            valide = false;
            document.getElementById('email-error').innerHTML = "Email invalide!";
        }
        if (!verifier_mot_de_passe(password)) {
            valide = false;
            document.getElementById('password-error').innerHTML = "Le mot de passe doit contenir au moins 8 caractères, incluant une majuscule, une minuscule, un chiffre et l'un des symboles suivants : @, #, ou d'autres caractères spéciaux.";
        }

        if (valide) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true; // Désactiver le bouton si la validation échoue
        }
        return valide; // Retourner false pour empêcher la soumission si valide == false
    }

    function checkFields() {
      validateForm(); 
    }

    function verifier_mot_de_passe(password) {
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=]).{8,}$/;
        return passwordRegex.test(password);
    }
    </script>
</body>
</html>
