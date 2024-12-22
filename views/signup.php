<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Inscription</title>
</head>
<body>
    <?php include 'includes/nav.php' ?>
    <div class="container py-2">
        <h4>Inscription</h4>
        <div id="message"></div>
        <form id="formElem">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name='username'>
                <div id="username-error" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name='email'>
                <div id="email-error" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name='password'>
                <div id="password-error" class="text-danger"></div>
            </div>
            <button type="submit" class="btn btn-primary" name='submit'>Submit</button>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
    <script>
        formElem.onsubmit = async (e) => {
        e.preventDefault();
        const formData = new FormData(formElem);
        let valide = true;
            if (!validate_Username(formData.get("username"))) {
                valide = false;
                document.getElementById('username-error').innerHTML = "Le nom doit être constitué d'au moins 5 caractères.";
            }
            if (!is_valid_email(formData.get("email"))) {
                valide = false;
                document.getElementById('email-error').innerHTML = "email invalide !";
            }
            if (!verifier_mot_de_passe(formData.get("password"))) {
                valide = false;
                document.getElementById('password-error').innerHTML = "Le mot de passe doit contenir au moins 8 caractères, incluant une majuscule, une minuscule, un chiffre et l'un des symboles suivants : @, #, ou d'autres caractères spéciaux.";
            }

            if (valide) {
                let response = await fetch('../index.php?action=register', {
                    method: 'POST',
                    body: new FormData(formElem)
                });

                let result = await response.json();
                if (result.success) {
                    window.location.href = "connexion.php";
                }else{
                    document.getElementById("message").innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            Erreur 404
                        </div>`;
                }
            }
        };

    </script>
  
</body>
</html>