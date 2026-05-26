<?php require BASE_PATH . '/view/layout/header.php'; ?>

<div class="auth-page">

    <div class="auth-card">

        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <div class="auth-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">

            <div class="form-group">
                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter email"
                    required
                >
            </div>

            <div class="form-group">
                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >
            </div>

            <button type="submit" class="auth-btn">
                Login
            </button>

        </form>

        <p class="auth-footer">
            Don't have account?
            <a href="?page=register">Register</a>
        </p>

    </div>

</div>

<?php require BASE_PATH . '/view/layout/footer.php'; ?>