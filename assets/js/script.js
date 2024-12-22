function is_valid_email(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function verifier_mot_de_passe(motDePasse) {
    const longueurMin = 8;
    const contientMajuscule = /[A-Z]/;
    const contientMinuscule = /[a-z]/;
    const contientChiffre = /[0-9]/;
    const contientSpecial = /[!@#$%^&*(),.?":{}|<>]/;

    return (
        motDePasse.length >= longueurMin &&
        contientMajuscule.test(motDePasse) &&
        contientMinuscule.test(motDePasse) &&
        contientChiffre.test(motDePasse) &&
        contientSpecial.test(motDePasse)
    );
}

function validate_Username(username) {
    const minLength = 5; 
    const maxLength = 50; 
    const usernameRegex = /^[a-zA-Z_\s]+$/;
    return (
        username.length >= minLength &&
        username.length <= maxLength &&
        usernameRegex.test(username)
    );
}
