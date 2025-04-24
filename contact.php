<?php
require_once 'includes/db.php';

// Traitement du formulaire de contact
$message_sent = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation simple
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error = "Veuillez remplir tous les champs obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Veuillez entrer une adresse email valide.";
    } else {
        // Enregistrer le message dans la base de données
        try {
            $stmt = $db->prepare("
                INSERT INTO contact_messages (name, email, phone, message)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$name, $email, $phone, $message]);

            // Dans un environnement de production, vous pourriez également envoyer un email
            // mail($recipient, "Nouveau message de contact", $message, "From: $name <$email>");

            $message_sent = true;
        } catch (PDOException $e) {
            error_log("Erreur lors de l'enregistrement du message de contact : " . $e->getMessage());
            $error = "Une erreur est survenue lors de l'envoi du message. Veuillez réessayer plus tard.";
        }
    }
}

include 'includes/header.php';
?>

    <main>
        <section class="page-header">
            <div class="container">
                <h1>Contactez-nous</h1>
                <p>Notre équipe est à votre disposition pour répondre à toutes vos questions.</p>
            </div>
        </section>

        <section class="contact-section">
            <div class="container">
                <div class="contact-grid">
                    <div class="contact-info">
                        <h2>Nos coordonnées</h2>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div class="contact-text">
                                <h3>Téléphone</h3>
                                <p><?php echo $phone; ?></p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div class="contact-text">
                                <h3>Email</h3>
                                <p><?php echo $email; ?></p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="contact-text">
                                <h3>Adresse</h3>
                                <p><?php echo $address; ?></p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div class="contact-text">
                                <h3>Horaires</h3>
                                <p>Lundi au vendredi : 9h - 18h<br>Samedi : 9h - 12h</p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-form">
                        <h2>Envoyez-nous un message</h2>

                        <?php if ($message_sent): ?>
                            <div class="success-message">
                                <p>Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.</p>
                            </div>
                        <?php else: ?>
                            <?php if ($error): ?>
                                <div class="error-message">
                                    <p><?php echo $error; ?></p>
                                </div>
                            <?php endif; ?>

                            <form method="post" action="contact.php">
                                <div class="form-group">
                                    <label for="name">Nom complet <span class="required">*</span></label>
                                    <input type="text" id="name" name="name" placeholder="Votre nom" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" placeholder="votre@email.com" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Téléphone</label>
                                    <input type="tel" id="phone" name="phone" placeholder="01 23 45 67 89" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="message">Message <span class="required">*</span></label>
                                    <textarea id="message" name="message" placeholder="Comment pouvons-nous vous aider ?" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                                </div>

                                <button type="submit" class="btn-primary full-width">Envoyer le message</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php include 'includes/footer.php'; ?>