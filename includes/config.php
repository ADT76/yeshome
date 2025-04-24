<?php
// Inclure la connexion à la base de données
require_once 'includes/db.php';

// Récupérer les paramètres du site depuis la base de données
$site_settings = getSiteSettings();

// Configuration du site
$site_name = $site_settings['site_name'] ?? 'YesHome';
$site_description = $site_settings['site_description'] ?? 'Service de maintien à domicile pour les personnes âgées';

// Détermine la page active
$current_page = basename($_SERVER['PHP_SELF']);

// Infos de contact
$phone = $site_settings['phone'] ?? '01 23 45 67 89';
$email = $site_settings['email'] ?? 'contact@yeshome.fr';
$address = $site_settings['address'] ?? '123 rue de Paris, 75000 Paris';
?>