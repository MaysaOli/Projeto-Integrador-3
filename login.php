<?php
// login.php
session_start();

if (isset($_POST['submit'])) {
    include_once('config.php');

    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

    // Query para buscar o usuário pelo e-mail
    $result = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email='$email'");

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verificar se a senha informada corresponde à senha armazenada (hash)
        if (password_verify($senha, $user['senha'])) {
            // Iniciar sessão e armazenar informações do usuário
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nome'] = $user['nome'];

            // Redirecionar para a página inicial após login bem-sucedido
            header('Location: index.php');
            exit();
        } else {
            $error_message = "Senha incorreta!";
        }
    } else {
        $error_message = "Email não encontrado!";
    }

    mysqli_close($conexao);
}
?>

<html lang="pt-BR">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Portal Estudantil - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
</head>
<body class="bg-gray-100 font-roboto">
    <header class="bg-blue-500 text-white p-4">
        <div class="container mx-auto flex justify-center items-center">
            <h1 class="text-2xl font-bold">Portal Estudantil</h1>
        </div>
    </header>
    <main class="container mx-auto p-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">Login</h2>

            <?php if (isset($error_message)) { ?>
                <div class="bg-red-500 text-white p-2 rounded-lg mb-4">
                    <?= $error_message; ?>
                </div>
            <?php } ?>

            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700" for="email">Email</label>
                    <input class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="email" name="email" placeholder="Digite seu email" type="email" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700" for="password">Senha</label>
                    <input class="w-full p-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="password" name="senha" placeholder="Digite sua senha" type="password" required/>
                </div>
                <button class="w-full bg-blue-500 text-white p-4 rounded-lg hover:bg-blue-600" type="submit" name="submit">Entrar</button>
            </form>
            <div class="mt-4 flex justify-between">
                <a class="text-blue-500 hover:underline" href="esqueceusenha.html">Esqueceu a senha?</a>
                <a class="text-blue-500 hover:underline" href="cadastro.php">Cadastrar-se</a>
            </div>
        </div>
    </main>
</body>
</html>
