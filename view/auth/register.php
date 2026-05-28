<?php require BASE_PATH . '/view/layout/header.php'; ?>

<style>
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --bg-color: #f9fafb;
        --card-bg: #ffffff;
        --text-color: #111827;
        --muted-color: #6b7280;
        --error-bg: #fef2f2;
        --error-text: #dc2626;
        --border-color: #e5e7eb;
    }

    /* Isolated container preventing conflicting layout inheritance */
    .auth-page {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 120px); /* Adjusts for global header height */
        padding: 40px 20px;
        background-color: var(--bg-color);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        box-sizing: border-box;
    }

    /* Fixed boundaries preventing infinite vertical stretching */
    .auth-card {
        background: var(--card-bg);
        padding: 32px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        width: 100%;
        max-width: 420px;
        box-sizing: border-box;
    }

    .auth-card h2 {
        margin-top: 0;
        margin-bottom: 24px;
        font-size: 26px;
        font-weight: 700;
        color: var(--text-color);
        text-align: center;
    }

    /* Managed sizing for better proximity and readability */
    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 6px;
        color: var(--text-color);
    }

    .form-group input {
        width: 100%;
        padding: 10px 14px;
        font-size: 15px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    /* Clean warning box styling */
    .auth-error {
        background-color: var(--error-bg);
        color: var(--error-text);
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 13px;
        margin-top: 6px;
        border-left: 4px solid var(--error-text);
        line-height: 1.4;
        text-align: left;
    }
    
    .dynamic-margin {
        margin-bottom: 16px;
    }

    /* Button CTA styling */
    .auth-btn {
        width: 100%;
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 12px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
        margin-top: 8px;
    }

    .auth-btn:hover {
        background-color: var(--primary-hover);
    }

    /* Switch view styling */
    .auth-footer {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 0;
        font-size: 14px;
        color: var(--muted-color);
    }

    .auth-footer a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }
</style>

<div class="auth-page">
    <div class="auth-card">
        <h2>Create Account</h2>

        <form method="POST" class="auth-form" novalidate>
            
            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Your name"
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                >
                <?php if (!empty($errors['name'])): ?>
                    <div class="auth-error">
                        <?php foreach ($errors['name'] as $error): ?>
                            <div><?= htmlspecialchars($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Email address"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                >
                <?php if (!empty($errors['email'])): ?>
                    <div class="auth-error">
                        <?php foreach ($errors['email'] as $error): ?>
                            <div><?= htmlspecialchars($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                >
                <?php if (!empty($errors['password'])): ?>
                    <div class="auth-error">
                        <?php foreach ($errors['password'] as $error): ?>
                            <div><?= htmlspecialchars($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($errors['general'])): ?>
                <div class="auth-error dynamic-margin">
                    <?php foreach ($errors['general'] as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="auth-btn">
                Register
            </button>
        </form>

        <p class="auth-footer">
            Already have an account? 
            <a href="?page=login">Login</a>
        </p>
    </div>
</div>

<?php require BASE_PATH . '/view/layout/footer.php'; ?>