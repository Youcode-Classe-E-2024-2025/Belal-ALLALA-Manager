<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Connexion</title>
</head>
<body>
    <div class="container py-4">
        <h4>Connexion</h4>
        <div id="message"></div>
        <form id="loginForm">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Connexion</button>
        </form>
    </div>
    <script src="../assets/js/script.js"></script>
    <script>
        const loginForm = document.getElementById('loginForm');

        loginForm.onsubmit = async (event) => {
            event.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const messageDiv = document.getElementById("message");
            let valide = true;

            if (!verifier_mot_de_passe(password)){
                valide = false;
                messageDiv.innerHTML = `<div class="alert alert-danger">le mode passe est invalide</div>`;
            }
            if (!is_valid_email(email)){
                valide = false;
                messageDiv.innerHTML = `<div class="alert alert-danger">l'email est invalide</div>`;
            }

            const formData = new FormData();
            formData.append('email',email);
            formData.append('password',password);

            if (valide) {
            let response = await fetch('actions/register_connexion.php', {
                method: 'POST',
                body: formData,
            });

            let result = await response.json();
            console.log("belal");
            if (result.success) {
                messageDiv.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
            } else {
                messageDiv.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
            }
            }
        };
    </script>
</body>
</html>
