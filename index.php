<?php
include 'includes/header.php';

// Récupérer les services depuis la base de données
try {
    $stmt = $db->query("
        SELECT title, description, icon
        FROM services
        WHERE active = 1
        ORDER BY display_order ASC
    ");
    $services = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des services : " . $e->getMessage());
    $services = [];
}

// Récupérer les témoignages depuis la base de données
try {
    $stmt = $db->query("
        SELECT name, age, text
        FROM testimonials
        WHERE active = 1
        ORDER BY display_order ASC
        LIMIT 2
    ");
    $testimonials = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des témoignages : " . $e->getMessage());
    $testimonials = [];
}
?>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1>Service de maintien à domicile pour vos proches</h1>
                <p>Nous aidons les personnes âgées, en situation de handicap ou en perte d'autonomie à rester chez elles en toute sécurité.</p>
                <a href="contact.php" class="btn-primary">Prendre rendez-vous</a>
                <p class="pricing-note">À partir de 30 €/h ou 390 €/mois.<br>Éligible au crédit d'impôt -50%.</p>
            </div>
        </section>

        <!-- Images Section -->
        <section class="images-section">
            <div class="container">
                <div class="image-grid">
                    <div class="image-card">
                        <img src="https://via.placeholder.com/600x400" alt="Aide à domicile avec une personne âgée">
                    </div>
                    <div class="image-card">
                        <img src="https://via.placeholder.com/600x400" alt="Accompagnement d'une personne âgée">
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section">
            <div class="container">
                <h2>Nos services pour vous aider</h2>

                <div class="services-grid">
                    <?php if (empty($services)): ?>
                        <p>Aucun service disponible pour le moment.</p>
                    <?php else: ?>
                        <?php foreach ($services as $service): ?>
                            <div class="service-card">
                                <div class="service-icon">
                                    <?php
                                    // Afficher l'icône en fonction du nom stocké en base de données
                                    $iconSvg = '';
                                    switch ($service['icon']) {
                                        case 'home':
                                            $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>';
                                            break;
                                        case 'users':
                                            $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>';
                                            break;
                                        case 'calendar':
                                            $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>';
                                            break;
                                        default:
                                            $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>';
                                    }
                                    echo $iconSvg;
                                    ?>
                                </div>
                                <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                                <p><?php echo htmlspecialchars($service['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- For Whom Section -->
        <section class="for-whom-section">
            <div class="container">
                <h2>Un service pour tous les aidants</h2>

                <div class="cards-grid">
                    <div class="feature-card">
                        <h3>Conjoints</h3>
                        <p>Vous soutenez votre partenaire vieillissant ou en perte d'autonomie.</p>
                    </div>

                    <div class="feature-card">
                        <h3>Enfants</h3>
                        <p>Vous jongler entre votre vie personnelle, professionnelle et l'aide à vos parents.</p>
                    </div>

                    <div class="feature-card">
                        <h3>Proches</h3>
                        <p>Vous êtes un frère, une sœur, un ami impliqué pour le bien-être d'un proche.</p>
                    </div>
                </div>

                <div class="cta-center">
                    <a href="contact.php" class="btn-primary">Prendre rendez-vous</a>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials-section">
            <div class="container">
                <h2>Ce que disent nos clients</h2>

                <div class="testimonials-grid">
                    <?php if (empty($testimonials)): ?>
                        <p>Aucun témoignage disponible pour le moment.</p>
                    <?php else: ?>
                        <?php foreach ($testimonials as $testimonial): ?>
                            <div class="testimonial-card">
                                <p class="testimonial-text">"<?php echo htmlspecialchars($testimonial['text']); ?>"</p>
                                <p class="testimonial-author"><?php echo htmlspecialchars($testimonial['name']); ?>, <?php echo htmlspecialchars($testimonial['age']); ?> ans</p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

<?php include 'includes/footer.php'; ?>