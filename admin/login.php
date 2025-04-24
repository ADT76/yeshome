<?php
session_start();
require_once '../includes/db.php';

$error = '';

// Si l'utilisateur est déjà connecté, rediriger vers le tableau de bord
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        try {
            $stmt = $db->prepare("SELECT id, username, password, first_name, last_name, role FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Connexion réussie
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['admin_role'] = $user['role'];

                header('Location: index.php');
                exit;
            } else {
                $error = 'Identifiants incorrects.';
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de la connexion : " . $e->getMessage());
            $error = 'Une erreur est survenue. Veuillez réessayer plus tard.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Administration YesHome</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background-color: var(--background-alt);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .login-container {
            background-color: var(--background-color);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo a {
            display: inline-flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.75rem;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-logo">
        <a href="../index.php">
            <div class="logo-icon">Y</div>
            <span>esHome</span>
        </a>
        <h1>Administration</h1>
    </div>

    <?php if ($error): ?>
        <div class="error-message">
            <p><?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn-primary full-width">Se connecter</button>
    </form>

    <p style="text-align: center; margin-top: 1rem;">
        <a href="../index.php">Retour au site</a>
    </p>
</div>
</body>
</html>