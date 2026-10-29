<?php
$errors = $errors ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Akun</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f0f4f9;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            margin: 0;
            color: #1e293b;
        }
        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 440px;
            border-radius: 12px;
            padding: 40px 36px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04), 0 1px 3px rgba(0, 0, 0, 0.02);
            border: 1px solid #eef2f6;
        }
        .icon-badge {
            width: 58px;
            height: 58px;
            background: #506cf0;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
            color: #ffffff;
            font-size: 26px;
            box-shadow: 0 8px 16px rgba(80, 108, 240, 0.25);
        }
        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e2530;
            text-align: center;
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }
        .login-subtitle {
            font-size: 0.92rem;
            color: #64748b;
            text-align: center;
            margin-bottom: 28px;
        }
        .form-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 0.95rem;
            background-color: #ffffff;
            color: #1e293b;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            outline: none;
        }
        .form-control.is-invalid {
            border-color: #ef4444;
        }
        .btn-login {
            background-color: #2b70f7;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            padding: 11px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            transition: all 0.2s ease;
        }
        .btn-login:hover {
            background-color: #1d5fe6;
            box-shadow: 0 4px 14px rgba(43, 112, 247, 0.35);
        }
        .btn-login:active {
            transform: scale(0.99);
        }
        .alert {
            border-radius: 8px;
            font-size: 0.88rem;
            padding: 10px 14px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <!-- Icon Badge Shield -->
    <div class="icon-badge">
        <i class="bi bi-shield-lock"></i>
    </div>

    <!-- Title & Subtitle -->
    <h1 class="login-title">Manajemen Akun</h1>
    <p class="login-subtitle">Masuk pakai email dan password kamu.</p>

    <!-- Error Alert -->
    <?php if (isset($errors['login'])): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div><?= htmlspecialchars($errors['login']) ?></div>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <form action="<?= BASE_URL ?>/login/authenticate" method="POST" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email"
                   class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                   value="<?= htmlspecialchars($email ?? '') ?>" autofocus>
            <?php if (isset($errors['email'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password"
                   class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>">
            <?php if (isset($errors['password'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-login">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Login</span>
        </button>
    </form>
</div>

</body>
</html>
