<?php
include 'includes/header.php';

// Récupérer les formules tarifaires depuis la base de données
try {
    $stmt = $db->query("
        SELECT p.id, p.name, p.price, p.period, p.is_featured, p.description
        FROM pricing_plans p
        WHERE p.active = 1
        ORDER BY p.display_order ASC
    ");
    $plans = $stmt->fetchAll();

    // Récupérer les caractéristiques pour chaque formule
    foreach ($plans as &$plan) {
        $stmt = $db->prepare("
            SELECT feature_text
            FROM pricing_features
            WHERE plan_id = ?
            ORDER BY display_order ASC
        ");
        $stmt->execute([$plan['id']]);
        $plan['features'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des formules tarifaires : " . $e->getMessage());
    $plans = [];
}
?>

    <main>
        <section class="page-header">
            <div class="container">
                <h1>Nos tarifs</h1>
                <p>Des formules adaptées à vos besoins, éligibles au crédit d'impôt de 50%.</p>
            </div>
        </section>

        <section class="pricing-section">
            <div class="container">
                <div class="pricing-grid">
                    <?php if (empty($plans)): ?>
                        <p>Aucune formule tarifaire disponible pour le moment.</p>
                    <?php else: ?>
                        <?php foreach ($plans as $plan): ?>
                            <div class="pricing-card <?php echo $plan['is_featured'] ? 'featured' : ''; ?>">
                                <div class="pricing-header">
                                    <h3><?php echo htmlspecialchars($plan['name']); ?></h3>
                                </div>
                                <div class="pricing-content">
                                    <div class="price">
                                        <span class="amount"><?php echo number_format($plan['price'], 2, ',', ' '); ?>€</span>
                                        <span class="period">/<?php echo htmlspecialchars($plan['period']); ?></span>
                                    </div>
                                    <p class="price-note">Soit <?php echo number_format($plan['price'] / 2, 2, ',', ' '); ?>€/<?php echo htmlspecialchars($plan['period']); ?> après crédit d'impôt</p>

                                    <?php if (!empty($plan['features'])): ?>
                                        <ul class="feature-list">
                                            <?php foreach ($plan['features'] as $feature): ?>
                                                <li><?php echo htmlspecialchars($feature); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <a href="contact.php" class="btn-primary full-width">Choisir cette formule</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="info-box">
                    <h2>Crédit d'impôt</h2>
                    <p>Tous nos services sont éligibles au crédit d'impôt de 50% selon l'article 199 sexdecies du Code Général des Impôts.</p>
                    <p>Cela signifie que vous ne payez réellement que la moitié du prix affiché, l'autre moitié étant déduite de vos impôts ou remboursée si vous n'êtes pas imposable.</p>
                </div>

                <div class="cta-center">
                    <p>Vous avez des questions sur nos tarifs ou nos services ?</p>
                    <a href="contact.php" class="btn-primary">Contactez-nous</a>
                </div>
            </div>
        </section>
    </main>

<?php include 'includes/footer.php'; ?>