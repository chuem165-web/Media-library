<?php require BASE_PATH . '/view/layout/header.php'; ?>

<div class="auth-page">

    <div class="auth-card">

        <h2>Login</h2>

        <form
            method="POST"
            class="auth-form"
        >

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter email"
                    
                    value="<?= htmlspecialchars(
                        $_POST['email']
                        ?? ''
                    ) ?>"
                >

                <?php if (
                    !empty(
                        $errors['email']
                    )
                ): ?>

                    <div class="auth-error">

                        <?php foreach (

                            $errors['email']

                            as $error

                        ): ?>

                            <?= htmlspecialchars(
                                $error
                            ) ?>

                            <br>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter password"
                    
                >

                <?php if (
                    !empty(
                        $errors['password']
                    )
                ): ?>

                    <div class="auth-error">

                        <?php foreach (

                            $errors['password']

                            as $error

                        ): ?>

                            <?= htmlspecialchars(
                                $error
                            ) ?>

                            <br>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>

            <?php if (
                !empty(
                    $errors['general']
                )
            ): ?>

                <div class="auth-error">

                    <?php foreach (

                        $errors['general']

                        as $error

                    ): ?>

                        <?= htmlspecialchars(
                            $error
                        ) ?>

                        <br>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

            <button
                type="submit"
                class="auth-btn"
            >

                Login

            </button>

        </form>

        <p class="auth-footer">

            Don't have account?

            <a href="?page=register">

                Register

            </a>

        </p>

    </div>

</div>

<?php require BASE_PATH . '/view/layout/footer.php'; ?>