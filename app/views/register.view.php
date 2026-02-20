<div>
    <h1>Créer un compte</h1>
    <?php if (isset($error)): ?>
        <p style="color: var(--error);"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <p style="color: var(--success);"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>
    <form action="index.php?action=register" method="post" id="register-form">
        <div id="register">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required oninput="checkPassword()">
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
            <input type="submit" value="S'inscrire" id="submit-btn" disabled>
        </div>
    </form>
</div>

<style>
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

#register input[type="submit"] {
    margin-top: 16px;
}

#register input[type="submit"]:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>

<script>
function checkPassword() {
    const password = document.getElementById('password').value;
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
    
    submitBtn.disabled = !(hasLength && hasUpper && hasLower && hasNumber && hasSpecial);
}
</script>
