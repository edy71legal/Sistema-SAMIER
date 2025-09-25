

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title> RESULTADO INDIVIDUAL DA SUA TURMA/ESCOLA</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: Arial; max-width: 600px; margin: auto; padding: 20px; }
    input, select { width: 100%; margin: 10px 0; padding: 8px; }
    button { padding: 10px; width: 100%; }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #00c6ff, #0072ff);
      color: #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      text-align: center;
      justify-content: center;
      align-items: center;
      padding: 30px 10px;
    }

    h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }

    p {
      font-size: 1.1rem;
      max-width: 600px;
      margin-bottom: 30px;
    }

    .btn-group {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: center;
    }

    .btn {
      background-color: #fff;
      color: #0072ff;
      padding: 12px 24px;
      border-radius: 30px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .btn:hover {
      background-color: #0072ff;
      color: #fff;
      border: 2px solid #fff;
    }

    .logo {
      margin-bottom: 20px;
      width: 100px;
      height: auto;
    }

    footer {
      position: absolute;
      bottom: 10px;
      font-size: 0.8rem;
      opacity: 0.7;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>


  </style>



<?php
$conn = new mysqli("localhost", "root", "", "autoddeclaracao");

$turma = $_GET['turma'] ?? 1;

function percentual($raca, $turma, $conn) {
    $total = $conn->query("SELECT COUNT(*) as total FROM alunos WHERE turma_id=$turma")->fetch_assoc()['total'];
    if ($total == 0) return 0;
    $count = $conn->query("SELECT COUNT(*) as c FROM alunos WHERE raca_cor='$raca' AND turma_id=$turma")->fetch_assoc()['c'];
    return round(($count / $total) * 100, 1);
}

$cores = ['Branca', 'Preta', 'Parda', 'Amarela', 'Indígena', 'Prefere não declarar'];
echo "<h2>Indicadores da Turma</h2>";
foreach ($cores as $cor) {
    echo "$cor: " . percentual($cor, $turma, $conn) . "%<br>";
}

echo "<h2>Indicadores da Unidade Escolar</h2>";
foreach ($cores as $cor) {
    $totalGeral = $conn->query("SELECT COUNT(*) as total FROM alunos")->fetch_assoc()['total'];
    $countGeral = $conn->query("SELECT COUNT(*) as c FROM alunos WHERE raca_cor='$cor'")->fetch_assoc()['c'];
    $percentual = ($totalGeral > 0) ? round(($countGeral / $totalGeral) * 100, 1) : 0;
    echo "$cor: $percentual%<br>";
}


?>
<br>
<br>
<br>
<br>
<div class="btn-group">
<a href="index.html" class="btn"> Voltar a Tela Inicial</a>
  </div>

</body>
</html>
