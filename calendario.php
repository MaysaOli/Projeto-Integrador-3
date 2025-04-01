<?php
// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "lorenzo", "estudante");

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se os dados foram enviados corretamente
    if (isset($_POST['materia']) && isset($_POST['data']) && isset($_POST['resumo'])) {
        $materia = $_POST['materia'];
        $data = $_POST['data'];
        $resumo = $_POST['resumo'];

        // Usando prepared statements para prevenir SQL Injection
        $stmt = $conn->prepare("INSERT INTO calendario (materia, data, resumo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $materia, $data, $resumo);

        if ($stmt->execute()) {
            // Query para pegar todas as provas
            $sql = "SELECT * FROM calendario";
            $result = $conn->query($sql);

            $output = '';
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $output .= "<li class='p-4 border border-gray-300 rounded'>";
                    $output .= "<strong>Matéria:</strong> " . htmlspecialchars($row['materia']) . "<br>";
                    $output .= "<strong>Data:</strong> " . htmlspecialchars($row['data']) . "<br>";
                    $output .= "<strong>Resumo:</strong> " . htmlspecialchars($row['resumo']) . "</li>";
                }
            } else {
                $output .= "<p>Nenhuma prova adicionada ainda.</p>";
            }

            echo json_encode(array('status' => 'success', 'data' => $output));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Erro ao adicionar a prova.'));
        }

        $stmt->close();
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Dados ausentes no formulário.'));
    }
    exit;
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Calendário de Provas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
</head>
<body class="font-roboto bg-gray-100">
<header class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold">Calendário de Provas</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a class="hover:underline" href="index.php">Início</a></li>
                <li><a class="hover:underline" href="areadoestudante.php">Área do Estudante</a></li>
                <li>
                    <form action="login.php" method="POST">
                        <button type="submit" class="hover:underline bg-red-500 text-white px-3 py-1 rounded">Sair</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</header>

<main class="container mx-auto p-4">
    <section class="text-center my-8">
        <h2 class="text-2xl font-bold mb-4">Bem-vindo ao Calendário de Provas</h2>
        <p class="text-lg">Adicione suas provas e receba lembretes e resumos para estudar!</p>
        <img alt="Imagem de um calendário" class="mx-auto mt-4" height="150" src="https://storage.googleapis.com/a1aa/image/-cSytuC8rYCdI93UpP7v_RPkTxubt0ddA7E87-qaqjk.jpg" width="225"/>
    </section>

    <!-- Formulário de Adição de Prova -->
    <section class="bg-white p-6 rounded shadow-md mb-8 max-w-md mx-auto">
        <h3 class="text-xl font-bold mb-4">Adicionar Prova</h3>
        <form id="addExamForm" class="space-y-4">
            <div>
                <label class="block text-lg font-medium" for="subject">Matéria</label>
                <input class="w-full p-2 border border-gray-300 rounded" id="subject" name="materia" placeholder="Ex: Matemática" type="text" required/>
            </div>
            <div>
                <label class="block text-lg font-medium" for="date">Data</label>
                <input class="w-full p-2 border border-gray-300 rounded" id="date" name="data" type="date" required/>
            </div>
            <div>
                <label class="block text-lg font-medium" for="summary">Resumo</label>
                <textarea class="w-full p-2 border border-gray-300 rounded" id="summary" name="resumo" placeholder="Ex: Estude álgebra e geometria" required></textarea>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Adicionar Prova</button>
        </form>
    </section>

    <!-- Lista de Provas -->
    <section class="bg-white p-6 rounded shadow-md mb-8 max-w-md mx-auto">
        <h3 class="text-xl font-bold mb-4">Provas Adicionadas</h3>
        <ul id="examsList" class="space-y-4">
            <!-- As provas serão carregadas dinamicamente aqui -->
        </ul>
    </section>
</main>

<footer class="bg-blue-600 text-white p-4 mt-8">
    <div class="container mx-auto text-center">
        <p>© 2025 Calendário de Provas. Todos os direitos reservados.</p>
    </div>
</footer>

<script>
// Função para enviar dados via AJAX
document.getElementById('addExamForm').addEventListener('submit', function(e) {
    e.preventDefault();  // Impede o envio do formulário de maneira tradicional

    var formData = new FormData(this);  // Cria um objeto FormData com os dados do formulário

    // Envia os dados via AJAX (fetch API)
    fetch('calendario.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())  // Espera a resposta JSON
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('examsList').innerHTML = data.data;  // Atualiza a lista de provas na página
            document.getElementById('addExamForm').reset();  // Limpa o formulário
        } else {
            console.error('Erro:', data.message);
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro inesperado: ' + error.message);
    });
});

// Carregar as provas já adicionadas assim que a página for carregada
window.onload = function() {
    fetch('calendario.php', {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('examsList').innerHTML = data.data;
        }
    });
};
</script>

</body>
</html>
