<?php require BASE_PATH . '/view/layout/header.php'; ?>

<div class="auth-page">

    <div class="auth-card">

        <h2>Create Account</h2>

        <?php if (!empty($error)): ?>
            <div class="auth-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">

            <div class="form-group">
                <label>Name</label>

                <input
                    type="text"
                    name="name"
                    placeholder="Your name"
                    required
                >
            </div>

            <div class="form-group">
                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Email address"
                    required
                >
            </div>

            <div class="form-group">
                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                >
            </div>

            <button type="submit" class="auth-btn">
                Register
            </button>

        </form>

        <p class="auth-footer">
            Already have account?
            <a href="?page=login">Login</a>
        </p>

    </div>

</div>

<?php require BASE_PATH . '/view/layout/footer.php'; ?>