<?php
// Paramètres de connexion à la base de données
$db_host = 'localhost';
$db_name = 'yeshome_db';
$db_user = 'root';
$db_pass = ''; // À modifier selon votre configuration

// Connexion à la base de données
try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    // Configurer PDO pour qu'il lance des exceptions en cas d'erreur
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configurer PDO pour qu'il retourne les résultats sous forme d'objets
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // En production, vous voudriez logger l'erreur plutôt que de l'afficher
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Fonction pour récupérer les paramètres du site
function getSiteSettings() {
    global $db;
    $settings = [];

    try {
        $stmt = $db->query("SELECT setting_key, setting_value FROM site_settings");
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    } catch (PDOException $e) {
        // Gérer l'erreur
        error_log("Erreur lors de la récupération des paramètres du site : " . $e->getMessage());
    }

    return $settings;
}
?>