<div id="profil">
    <h1>Mon Profil</h1>
    
    <?php if (isset($error)): ?>
        <p class="message error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <p class="message success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>
    
    <div class="profile-section">
        <h2>Informations du profil</h2>
        <form method="post">
            <input type="hidden" name="update_profile" value="1">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user["USERNAME"]) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user["EMAIL"]) ?>" required>
            </div>
            <button type="submit">Mettre à jour le profil</button>
        </form>
    </div>
    
    <div class="profile-section">
        <h2>Changer le mot de passe</h2>
        <form method="post">
            <input type="hidden" name="update_password" value="1">
            <div class="form-group">
                <label for="current_password">Mot de passe actuel</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">Nouveau mot de passe</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Changer le mot de passe</button>
        </form>
    </div>
</div>

<style>
#profil {
    max-width: 600px;
    margin: 0 auto;
    padding: 0 20px;
}

#profil h1 {
    font-size: 24px;
    margin-bottom: 24px;
    color: var(--text-primary);
}

.message {
    padding: 12px 16px;
    margin-bottom: 20px;
    border-radius: 4px;
    font-size: 13px;
}

.message.error {
    background-color: rgba(248, 113, 113, 0.1);
    border: 1px solid var(--error);
    color: var(--error);
}

.message.success {
    background-color: rgba(74, 222, 128, 0.1);
    border: 1px solid var(--success);
    color: var(--success);
}

.profile-section {
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
    padding: 24px;
    margin-bottom: 24px;
}

.profile-section h2 {
    font-size: 16px;
    margin: 0 0 20px 0;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 12px;
}

.form-group {
    margin-bottom: 16px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-size: 12px;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.form-group input {
    width: 100%;
    padding: 10px 12px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text-primary);
    background-color: var(--bg-input);
    border: 1px solid var(--border-input);
    outline: none;
}

.form-group input:focus {
    border-color: var(--text-primary);
}

.profile-section button {
    margin-top: 8px;
    padding: 10px 20px;
    font-size: 12px;
    font-family: inherit;
    color: var(--bg-primary);
    background-color: var(--success);
    border: none;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.profile-section button:hover {
    background-color: var(--accent);
}
</style>
