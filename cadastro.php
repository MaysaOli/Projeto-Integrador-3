<?php
session_start();  // Iniciar a sessão para acessar as variáveis de sessão

if (isset($_POST['submit'])) {
    include_once('config.php');

    // Protegendo os dados inseridos no formulário
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $data = mysqli_real_escape_string($conexao, $_POST['data']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $curso = mysqli_real_escape_string($conexao, $_POST['curso']);

    // Verificando se o e-mail já está cadastrado
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexao, $query);

    // Se o e-mail já estiver cadastrado
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('E-mail já cadastrado! Tente novamente com outro e-mail.');</script>";
    } else {
        // Hashing a senha para segurança
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Preparando a instrução SQL
        $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, data_nascimento, senha, sexo, cidade, curso) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nome, $email, $data, $senha_hash, $sexo, $cidade, $curso);

        if ($stmt->execute()) {
            // Redirecionando para a página index.php após o cadastro
            header('Location: index.php');
            exit;
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
    }

    mysqli_close($conexao);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Portal Estudantil - Cadastro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("senha");
            var eyeIcon = document.getElementById("eye-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-roboto">
    <header class="bg-blue-500 text-white p-4">
        <div class="container mx-auto flex justify-center items-center">
            <h1 class="text-2xl font-bold">Portal Estudantes</h1>
        </div>
    </header>
    <main class="container mx-auto p-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-center">Cadastro</h2>
            <form action="cadastro.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700" for="nome">Nome Completo</label>
                    <input class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="nome" name="nome" placeholder="Digite seu nome completo" type="text" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700" for="email">E-mail</label>
                    <input class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="email" name="email" placeholder="Digite seu e-mail" type="email" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700" for="dataNascimento">Data de Nascimento</label>
                    <input class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="dataNascimento" name="data" type="date" required/>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700" for="senha">Senha</label>
                    <input class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="senha" name="senha" placeholder="Digite sua senha" type="password" required/>
                    <i id="eye-icon" class="fas fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500" onclick="togglePassword()"></i>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700" for="sexo">Sexo</label>
                    <select class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="sexo" name="sexo" required>
                        <option value="masculino">Masculino</option>
                        <option value="feminino">Feminino</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700" for="cidade">Cidade</label>
                    <input class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="cidade" name="cidade" placeholder="Digite sua cidade" type="text" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700" for="curso">Curso</label>
                    <input class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="curso" name="curso" placeholder="Digite seu curso" type="text" required/>
                </div>
                <button class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600" type="submit" name="submit">Cadastrar</button>
            </form>
            <div class="mt-4 flex justify-between">
                <a class="text-blue-500 hover:underline" href="esqueceusenha.html">Esqueceu a senha?</a>
                <a class="text-blue-500 hover:underline" href="login.php">Já tem uma conta? Entrar</a>
            </div>
        </div>
    </main>
</body>
</html>