<?php   
session_start();  // Iniciar a sessão para acessar as variáveis de sessão

// Verificar se o usuário está logado
$usuario_logado = isset($_SESSION['user_id']);

if ($usuario_logado) {
    // Exemplo de como buscar dados no banco de dados
    $user_id = $_SESSION['user_id'];  // Obtém o 'user_id' da sessão
    $conn = new mysqli("localhost", "root", "lorenzo", "estudante");

    // Verificar conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Alterando a consulta para buscar dados na tabela 'usuarios'
    $sql = "SELECT id, nome_completo, email, data_nascimento, senha, sexo, cidade, curso FROM usuarios WHERE id = ?";
    // Preparar a consulta para a seleção
    if ($stmt = $conn->prepare($sql)) {
        // Bind dos parâmetros à consulta
        $stmt->bind_param("i", $user_id);

        // Executar a consulta
        $stmt->execute();

        // Obter o resultado da consulta
        $result = $stmt->get_result();

        // Verificar se a consulta retornou algum dado
        if ($result->num_rows > 0) {
            // Caso tenha encontrado o aluno, armazene os dados
            $aluno = $result->fetch_assoc();
        } else {
            echo "Nenhum dado encontrado!";
        }

        // Fechar a consulta
        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }
} else {
    echo "Usuário não está logado.";
    exit;
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $usuario_logado) {
    // Processar o envio do formulário para atualizar os dados
    $nome = $conn->real_escape_string($_POST['nome_completo']);
    $email = $conn->real_escape_string($_POST['email']);
    $data = $conn->real_escape_string($_POST['data_nascimento']);
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $cidade = $conn->real_escape_string($_POST['cidade']);
    $curso = $conn->real_escape_string($_POST['curso']);

    // Alterando a consulta para atualizar dados na tabela 'usuarios'
    $sql = "UPDATE usuarios 
            SET nome_completo = ?, email = ?, data_nascimento = ?, sexo = ?, cidade = ?, curso = ? 
            WHERE id = ?";

    // Preparar a consulta para a atualização
    if ($stmt = $conn->prepare($sql)) {
        // Bind dos parâmetros à consulta
        $stmt->bind_param("ssssssi", $nome, $email, $data, $sexo, $cidade, $curso, $user_id);  // 's' para string, 'i' para inteiro

        // Executar a consulta
        if ($stmt->execute()) {
            echo "<script>alert('Informações atualizadas com sucesso!');</script>";
        } else {
            echo "Erro ao atualizar informações: " . $stmt->error;
        }

        // Fechar a consulta
        $stmt->close();
    } else {
        echo "Erro na preparação da consulta de atualização: " . $conn->error;
    }
}

// Fechar a conexão
$conn->close();
?>

<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Portal Estudantil - Cadastro/Área do Estudante</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
</head>
<body class="bg-gray-100 font-roboto">

  <header class="bg-blue-500 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-lg font-bold">Portal Estudantil</h1>
      <nav>
        <ul class="flex space-x-4">
          <li><a class="hover:underline" href="index.php">Início</a></li>
          <li><a class="hover:underline" href="calendario.html">Calendário</a></li>

          <?php if ($usuario_logado): ?>
            <li>
              <form action="login.php" method="POST">
                <button type="submit" class="hover:underline bg-red-500 text-white p-1 rounded-md">Sair</button>
              </form>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg mx-auto">
      <h2 class="text-lg font-bold mb-4">Área do Estudante</h2>

      <!-- Formulário para cadastro/edição -->
      <form action="" method="POST" class="space-y-4">
        
        <!-- Nome Completo -->
        <div>
          <label class="block text-base font-medium" for="nome_completo">Nome Completo</label>
          <input type="text" id="nome_completo" name="nome_completo" class="w-full p-2 border border-gray-300 rounded" value="<?php echo isset($aluno['nome_completo']) ? $aluno['nome_completo'] : ''; ?>" required>
        </div>

        <!-- Email -->
        <div>
          <label class="block text-base font-medium" for="email">Email</label>
          <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded" value="<?php echo isset($aluno['email']) ? $aluno['email'] : ''; ?>" required>
        </div>

        <!-- Cidade -->
        <div>
          <label class="block text-base font-medium" for="cidade">Cidade</label>
          <input type="text" id="cidade" name="cidade" class="w-full p-2 border border-gray-300 rounded" value="<?php echo isset($aluno['cidade']) ? $aluno['cidade'] : ''; ?>" required>
        </div>

        <!-- Sexo -->
        <div>
          <label class="block text-base font-medium" for="sexo">Sexo</label>
          <select id="sexo" name="sexo" class="w-full p-2 border border-gray-300 rounded" required>
            <option value="Masculino" <?php echo (isset($aluno['sexo']) && $aluno['sexo'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
            <option value="Feminino" <?php echo (isset($aluno['sexo']) && $aluno['sexo'] == 'Feminino') ? 'selected' : ''; ?>>Feminino</option>
            <option value="Outro" <?php echo (isset($aluno['sexo']) && $aluno['sexo'] == 'Outro') ? 'selected' : ''; ?>>Outro</option>
          </select>
        </div>

        <!-- Data de Nascimento -->
        <div>
          <label class="block text-base font-medium" for="data_nascimento">Data de Nascimento</label>
          <input type="date" id="data_nascimento" name="data_nascimento" class="w-full p-2 border border-gray-300 rounded" value="<?php echo isset($aluno['data_nascimento']) ? $aluno['data_nascimento'] : ''; ?>" required>
        </div>

        <!-- Curso -->
        <div>
          <label class="block text-base font-medium" for="curso">Curso</label>
          <input type="text" id="curso" name="curso" class="w-full p-2 border border-gray-300 rounded" value="<?php echo isset($aluno['curso']) ? $aluno['curso'] : ''; ?>" required>
        </div>

        <!-- Botão de submit -->
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Atualizar Informações</button>
      </form>
    </div>
  </main>

</body>
</html>