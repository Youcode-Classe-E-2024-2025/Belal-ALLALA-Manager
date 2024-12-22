<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">js_package_manager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="collaboration.php">Collaboration</a>
                <a class="nav-link" href="author.php">Authors</a>
                <a class="nav-link" href="package.php">Packages</a>
                <a class="nav-link" href="version.php">version</a>
                <a class="nav-link" href="includes/deconnexion.php">Déconnexion</a>
                <?php if ($id_role === 3) { ?>
                <a class="nav-link" href="administration.php">administration</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>