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
        <form method="post" id="password-form">
            <input type="hidden" name="update_password" value="1">
            <div class="form-group">
                <label for="current_password">Mot de passe actuel</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">Nouveau mot de passe</label>
                <input type="password" id="new_password" name="new_password" required oninput="checkPassword()">
                <div class="password-strength">
                    <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                    <span class="strength-text" id="strength-text"></span>
                </div>
                <ul class="password-requirements" id="password-requirements">
                    <li id="req-length">12 caractères minimum</li>
                    <li id="req-upper">Une majuscule</li>
                    <li id="req-lower">Une minuscule</li>
                    <li id="req-number">Un chiffre</li>
                    <li id="req-special">Un caractère spécial</li>
                </ul>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required oninput="checkMatch()">
                <span class="match-text" id="match-text"></span>
            </div>
            <button type="submit" id="submit-btn" disabled>Changer le mot de passe</button>
        </form>
    </div>
</div>

<style>
#profil {
    max-width: 500px;
    margin: 0 auto;
    padding: 0 20px;
}

#profil h1 {
    font-size: 20px;
    margin-bottom: 20px;
    color: var(--text-primary);
}

.message {
    padding: 12px 16px;
    margin-bottom: 16px;
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
    padding: 20px;
    margin-bottom: 16px;
}

.profile-section h2 {
    font-size: 14px;
    margin: 0 0 16px 0;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 10px;
}

.form-group {
    margin-bottom: 14px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-size: 11px;
    color: var(--text-muted);
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
    box-sizing: border-box;
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

.profile-section button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.password-strength {
    margin: 8px 0;
}

.strength-bar {
    height: 4px;
    background-color: var(--border-color);
    border-radius: 2px;
    overflow: hidden;
}

.strength-fill {
    height: 100%;
    width: 0%;
    transition: width 0.3s, background-color 0.3s;
}

.strength-fill.weak { width: 20%; background-color: #ef4444; }
.strength-fill.fair { width: 40%; background-color: #f97316; }
.strength-fill.medium { width: 60%; background-color: #eab308; }
.strength-fill.strong { width: 80%; background-color: #22c55e; }
.strength-fill.very-strong { width: 100%; background-color: #16a34a; }

.strength-text {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 4px;
    display: block;
}

.match-text {
    font-size: 11px;
    display: block;
    margin-top: 4px;
}

.match-text.match { color: var(--success); }
.match-text.no-match { color: var(--error); }

.password-requirements {
    list-style: none;
    padding: 0;
    margin: 8px 0;
    font-size: 11px;
    color: var(--text-muted);
}

.password-requirements li {
    padding: 2px 0;
    padding-left: 16px;
    position: relative;
}

.password-requirements li::before {
    content: "○";
    position: absolute;
    left: 0;
}

.password-requirements li.valid {
    color: var(--success);
}

.password-requirements li.valid::before {
    content: "●";
}

</style>

<script>
function checkPassword() {
    const password = document.getElementById('new_password').value;
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');
    const submitBtn = document.getElementById('submit-btn');
    
    const reqLength = document.getElementById('req-length');
    const reqUpper = document.getElementById('req-upper');
    const reqLower = document.getElementById('req-lower');
    const reqNumber = document.getElementById('req-number');
    const reqSpecial = document.getElementById('req-special');
    
    const hasLength = password.length >= 12;
    const hasUpper = /[A-Z]/.test(password);
    const hasLower = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
    
    reqLength.classList.toggle('valid', hasLength);
    reqUpper.classList.toggle('valid', hasUpper);
    reqLower.classList.toggle('valid', hasLower);
    reqNumber.classList.toggle('valid', hasNumber);
    reqSpecial.classList.toggle('valid', hasSpecial);
    
    const validCount = [hasLength, hasUpper, hasLower, hasNumber, hasSpecial].filter(Boolean).length;
    
    strengthFill.className = 'strength-fill';
    if (password.length === 0) {
        strengthText.textContent = '';
    } else if (validCount <= 2) {
        strengthFill.classList.add('weak');
        strengthText.textContent = 'Très faible';
    } else if (validCount === 3) {
        strengthFill.classList.add('fair');
        strengthText.textContent = 'Faible';
    } else if (validCount === 4) {
        strengthFill.classList.add('medium');
        strengthText.textContent = 'Moyen';
    } else if (validCount === 5 && password.length >= 12) {
        strengthFill.classList.add('very-strong');
        strengthText.textContent = 'Très fort';
    } else {
        strengthFill.classList.add('strong');
        strengthText.textContent = 'Fort';
    }
    
    checkMatch();
}

function checkMatch() {
    const password = document.getElementById('new_password').value;
    const confirm = document.getElementById('confirm_password').value;
    const matchText = document.getElementById('match-text');
    const submitBtn = document.getElementById('submit-btn');
    const hasValid = document.querySelectorAll('#password-requirements li.valid').length === 5;
    
    if (confirm.length === 0) {
        matchText.textContent = '';
        matchText.className = 'match-text';
    } else if (password === confirm) {
        matchText.textContent = 'Les mots de passe correspondent';
        matchText.className = 'match-text match';
    } else {
        matchText.textContent = 'Les mots de passe ne correspondent pas';
        matchText.className = 'match-text no-match';
    }
    
    const isMatch = password === confirm && password.length > 0;
    submitBtn.disabled = !(hasValid && isMatch);
}
</script>
