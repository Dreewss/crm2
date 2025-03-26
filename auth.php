<?php
// Configurações do banco de dados (substitua com suas credenciais)
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'seu_usuario');
define('DB_PASSWORD', 'sua_senha');
define('DB_NAME', 'seu_banco');

// Conexão com o banco de dados
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verifica a conexão
if($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Validação dos campos
if(empty(trim($_POST["username"]))) {
    $username_err = "Por favor, insira o nome de usuário.";
} else {
    $username = trim($_POST["username"]);
}

if(empty(trim($_POST["password"]))) {
    $password_err = "Por favor, insira sua senha.";
} else {
    $password = trim($_POST["password"]);
}

// Validação das credenciais
if(empty($username_err) && empty($password_err)) {
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $param_username);
        $param_username = $username;
        
        if($stmt->execute()) {
            $stmt->store_result();
            
            if($stmt->num_rows == 1) {
                $stmt->bind_result($id, $username, $hashed_password);
                if($stmt->fetch()) {
                    if(password_verify($password, $hashed_password)) {
                        // Senha correta, inicia a sessão
                        session_start();
                        
                        // Armazena dados na sessão
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;                            
                        
                        // Redireciona para a página inicial
                        header("location: dashboard.php");
                    } else {
                        // Senha incorreta
                        $login_err = "Nome de usuário ou senha inválidos.";
                    }
                }
            } else {
                // Usuário não existe
                $login_err = "Nome de usuário ou senha inválidos.";
            }
        } else {
            echo "Oops! Algo deu errado. Por favor, tente novamente mais tarde.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
