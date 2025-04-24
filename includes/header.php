<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> - <?php echo $site_description; ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<header class="site-header">
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <div class="logo-icon">Y</div>
                <span>esHome</span>
            </a>
        </div>

        <nav class="main-nav">
            <button id="menu-toggle" class="menu-toggle" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-menu" id="nav-menu">
                <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    <a href="index.php">Accueil</a>
                </li>
                <li class="<?php echo ($current_page == 'notre-mission.php') ? 'active' : ''; ?>">
                    <a href="notre-mission.php">Notre mission</a>
                </li>
                <li class="<?php echo ($current_page == 'tarifs.php') ? 'active' : ''; ?>">
                    <a href="tarifs.php">Tarifs</a>
                </li>
                <li class="<?php echo ($current_page == 'blog.php') ? 'active' : ''; ?>">
                    <a href="blog.php">Blog</a>
                </li>
                <li class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
                    <a href="contact.php" class="btn-contact">Contact</a>
                </li>
            </ul>
        </nav>
    </div>
</header>