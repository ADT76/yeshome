<?php
require_once 'includes/db.php';

// Récupérer les articles de blog depuis la base de données
try {
    $stmt = $db->query("
        SELECT bp.id, bp.title, bp.slug, bp.excerpt, bp.created_at, bp.image_url
        FROM blog_posts bp
        WHERE bp.published = 1
        ORDER BY bp.created_at DESC
        LIMIT 8
    ");
    $blogPosts = $stmt->fetchAll();

    // Formater la date pour chaque article
    foreach ($blogPosts as &$post) {
        $date = new DateTime($post['created_at']);
        $post['date'] = $date->format('j F Y');
    }
} catch (PDOException $e) {
    // Gérer l'erreur
    error_log("Erreur lors de la récupération des articles de blog : " . $e->getMessage());
    $blogPosts = [];
}

include 'includes/header.php';
?>

    <main>
        <section class="page-header">
            <div class="container">
                <h1>Notre blog</h1>
                <p>Retrouvez nos conseils et informations pour vous aider à accompagner vos proches au quotidien.</p>
            </div>
        </section>

        <section class="blog-section">
            <div class="container">
                <div class="blog-grid">
                    <?php if (empty($blogPosts)): ?>
                        <p>Aucun article disponible pour le moment.</p>
                    <?php else: ?>
                        <?php foreach ($blogPosts as $post): ?>
                            <article class="blog-card">
                                <div class="blog-image">
                                    <?php if (!empty($post['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/600x400?text=<?php echo urlencode($post['title']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="blog-content">
                                    <p class="blog-date"><?php echo htmlspecialchars($post['date']); ?></p>
                                    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                                    <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                                    <a href="article.php?slug=<?php echo $post['slug']; ?>" class="btn-secondary">Lire l'article</a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="cta-center">
                    <a href="#" class="btn-primary">Voir tous les articles</a>
                </div>
            </div>
        </section>
    </main>

<?php include 'includes/footer.php'; ?>