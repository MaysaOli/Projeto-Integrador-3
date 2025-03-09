<?php 
session_start();  // Iniciar a sessão para acessar as variáveis de sessão

// Verificar se o usuário já está logado
$usuario_logado = isset($_SESSION['user_id']);
?>

<html lang="pt-BR">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Portal do Estudante</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
</head>
<body class="font-roboto bg-gray-100">
  <header class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">
        Portal do Estudante
      </h1>
      <nav>
        <ul class="flex space-x-4">
          <li>
            <a class="hover:underline" href="areadoestudante.php">
              Área do Estudante
            </a>
          </li>
          <li>
            <a class="hover:underline" href="calendario.html">
              Calendário
            </a>
          </li>
          
          <!-- Verifica se o usuário está logado. Se estiver, exibe o botão de sair -->
          <?php if (!$usuario_logado): ?>
            <li>
              <a class="hover:underline" href="cadastro.php">
                Cadastre-se
              </a>
            </li>
          <?php else: ?>
            <li>
              <form action="login.php" method="POST">
                <button type="submit" class="hover:underline bg-red-500 text-white px-3 py-1 rounded">
                  Sair
                </button>
              </form>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container mx-auto mt-8">
    <section class="bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-3xl font-bold mb-4">
        Bem-vindo ao Portal do Estudante!
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <p class="text-lg mb-4">
            O Portal do Estudante é a sua plataforma completa para organizar seus estudos, acessar materiais, participar de chats interativos e muito mais. Aqui você encontra todas as ferramentas necessárias para alcançar seus objetivos acadêmicos.
          </p>
          <p class="text-lg mb-4">
            Cadastre-se agora para aproveitar todas as funcionalidades do site, incluindo upload de materiais, acesso a conteúdos exclusivos, personalização do seu perfil, organização de datas de avaliações e um chat interativo para tirar dúvidas e colaborar com outros estudantes.
          </p>
          <p class="text-lg mb-4">
            Na Área do Estudante, você pode personalizar suas informações, adicionar uma foto de perfil e gerenciar suas configurações. Deixe o seu perfil com a sua cara e aproveite todas as funcionalidades que o Portal do Estudante oferece.
          </p>
          <p class="text-lg mb-4">
            O Calendário de Provas permite que você organize suas datas de avaliações de maneira prática e visual. Nunca mais perca uma data importante e mantenha-se sempre preparado para suas provas e trabalhos. Você também pode fazer upload de materiais, acessar conteúdos exclusivos e organizar seus estudos de forma eficiente.
          </p>
          <p class="text-lg mb-4">
            Não perca tempo! Cadastre-se agora e comece a aproveitar todas as vantagens que o Portal do Estudante tem a oferecer. Junte-se a milhares de estudantes que já estão utilizando nossa plataforma para alcançar seus objetivos acadêmicos.
          </p>
        </div>
        <div class="flex items-center justify-center">
          <img alt="Imagem dinâmica de estudantes felizes e colaborando" class="rounded-lg shadow-md animate-bounce" height="400" src="https://storage.googleapis.com/a1aa/image/Y5wlFWtzPKQsXnoXk1Dnchw8xPTaEUpPS-B41kDqvjY.jpg" width="400"/>
        </div>
      </div>
    </section>

    <!-- Seção explicando o site com mais detalhes e imagens -->
    <section class="bg-white p-6 mt-8 rounded-lg shadow-md">
      <h2 class="text-3xl font-bold mb-4">
        Explore o Portal do Estudante
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex items-center justify-center">
          <img alt="Imagem de estudantes estudando juntos" class="rounded-lg shadow-md" height="400" src="https://guiadoconcurso.com.br/wp-content/uploads/2020/05/planeje-se-veja-como-estudar-para-os-vestibulares-de-inverno.jpeg" width="400"/>
        </div>
        <div>
          <p class="text-lg mb-4">
            O Portal do Estudante foi desenvolvido para oferecer uma experiência completa e integrada para estudantes de todas as idades. Nossa plataforma permite que você:
          </p>
          <ul class="list-disc list-inside text-lg mb-4">
            <li>Acesse materiais de estudo de alta qualidade</li>
            <li>Participe de chats interativos com outros estudantes</li>
            <li>Organize suas datas de avaliações no calendário</li>
            <li>Personalize seu perfil com informacões</li>
            <li>Gerencie suas configurações e preferências</li>
          </ul>
          <p class="text-lg mb-4">
            Nossa missão é ajudar você a alcançar seus objetivos acadêmicos da maneira mais eficiente e divertida possível. Com o Portal do Estudante, você terá todas as ferramentas necessárias para se destacar nos estudos e colaborar com outros estudantes.
          </p>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
          <p class="text-lg mb-4">
            O Calendário de Provas é uma das funcionalidades mais populares do nosso portal. Com ele, você pode:
          </p>
          <ul class="list-disc list-inside text-lg mb-4">
            <li>Adicionar datas de provas e trabalhos</li>
            <li>Receber lembretes de avaliações importantes</li>
            <li>Organizar seus estudos de maneira visual e prática</li>
          </ul>
        </div>
        <div class="flex items-center justify-center">
          <img alt="Imagem de calendário de provas" class="rounded-lg shadow-md" height="400" src="https://static.vecteezy.com/system/resources/previews/000/288/043/original/business-calendar-vector-icon.jpg" width="400"/>
        </div>
      </div>
    </section>
  </main>

  <footer class="bg-blue-600 text-white p-4 mt-8">
    <div class="container mx-auto text-center">
      <p>
        © 2025 Portal do Estudante. Todos os direitos reservados.
      </p>
    </div>
  </footer>
</body>
</html>
