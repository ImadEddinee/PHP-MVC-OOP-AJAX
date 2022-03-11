<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= ROOT ?>"><?= SITENAME ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= addClass(); ?> " href="<?= ROOT ."pages" ?>">link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= addClass('pages/features'); ?>" href="<?= ROOT."pages/features" ?>">link2</a>
                </li>
            </ul>
            <?php if (!isLoggedIn()) : ?>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= addClass(); ?> " href="<?= ROOT ."pages" ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= addClass('pages/features'); ?>" href="<?= ROOT."pages/features" ?>">Features</a>
                </li>
            </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= addClass('users/register'); ?>" href="<?= ROOT ."users/register" ?>">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= addClass('users/login'); ?>" href="<?= ROOT ."users/login" ?>">Login</a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Menu' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item text-center" href="#">Profile</a></li>
                            <li><a class="dropdown-item text-center" href="<?= ROOT. "users/deconnection" ?>">Déconnecter</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
