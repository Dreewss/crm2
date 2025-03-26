<?php
// Inicia a sessão
session_start();

// Verifica se o usuário já está logado
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php");
    exit;
}

// Variáveis para mensagens de erro
$username_err = $password_err = $login_err = "";

// Processa o formulário quando for submetido
if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "auth.php";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Login</h1>
        </div>
        
        <?php 
        if(!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Entrar">
            </div>
        </form>
    </div>
</body>
</html>
