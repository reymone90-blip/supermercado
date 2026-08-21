<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión — <?= NOMBRE_SISTEMA ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>css/estilos.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #12172b 0%, #232a4d 100%);
        }
        .login-card {
            width: 100%;
            max-width: 380px;
            background: #fff;
            border-radius: 18px;
            padding: 2.2rem 2rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.25);
        }
        .login-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .login-brand i {
            background: var(--accent);
            color: #fff;
            font-size: 1.6rem;
            padding: 0.8rem;
            border-radius: 14px;
            margin-bottom: 0.6rem;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-brand">
        <i class="bi bi-shop"></i>
        <h5 class="fw-bold mb-0"><?= NOMBRE_SISTEMA ?></h5>
        <small class="text-muted">Ingresa tus credenciales</small>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2 small"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input type="text" name="usuario" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="clave" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-accent w-100 py-2 mt-2">
            <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
        </button>
    </form>
</div>

</body>
</html>
