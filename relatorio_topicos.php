<?php
$conn = new mysqli("localhost", "root", "", "autoddeclaracao");

$indicadores = ['raca_cor', 'idade', 'turma_id'];
$labels = ['Raça/Cor', 'Idade', 'Turma'];
$campo = $_GET['campo'] ?? 'raca_cor';

$query = "SELECT $campo as campo, COUNT(*) as total FROM alunos GROUP BY $campo";
$result = $conn->query($query);

$dados = [];
$nomes = [];

while ($row = $result->fetch_assoc()) {
    $nomes[] = $row['campo'];
    $dados[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório por Indicador</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
body {
  font-family: Arial, sans-serif;
  margin: 10px;

  background: #f9f9f9;
  color: #333;
  flex-direction: column;
      min-height: 100vh;
      text-align: center;
      justify-content: center;
      align-items: center;
      padding: 30px 10px;
}

h1, h2 {
  text-align: center;
  margin-bottom: 10px;
}

.chart-container {
  width: 100%;
  max-width: 500px;
  margin: 20px auto;
}

.flex-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}

canvas {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  padding: 10px;
}

 .btn-group {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: center;
    }

    .btn {
      background-color: #fff;
      color: #0b0d0eff;
      padding: 12px 24px;
      border-radius: 30px;
      font-weight: 600;
      border: 1px solid gray;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .btn:hover {
      background-color: #0072ff;
      color: #fff;
      border: 2px solid #fff;
    }

footer {
      position: absolute;
      bottom: 10px;
      font-size: 0.8rem;
      opacity: 0.7;
      justify-content: center;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 2rem;
      }
    }



        /* body { font-family: 'Segoe UI', sans-serif; margin: 20px; background: #f4f4f4; color: #333; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        canvas { max-width: 100%; }
        */
    </style>
</head>
<body>
    <!--<div class="container"> -->

    <div class="flex-container">
  <div class="chart-container">
    <h1>Relatório por Indicador</h1>
    <form method="get">
        <label for="campo">Escolha o Indicador:</label>
        <select name="campo" id="campo">
            <option value="raca_cor" <?= $campo == 'raca_cor' ? 'selected' : '' ?>>Raça/Cor</option>
            <option value="idade" <?= $campo == 'idade' ? 'selected' : '' ?>>Idade</option>
            <option value="turma_id" <?= $campo == 'turma_id' ? 'selected' : '' ?>>Turma</option>
        </select>
        <button type="submit">Gerar</button>
    </form>

    <canvas id="graficoTopico"></canvas>

    <script>
        new Chart(document.getElementById('graficoTopico'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($nomes) ?>,
                datasets: [{
                    label: 'Total',
                    data: <?= json_encode($dados) ?>,
                    backgroundColor: '#42A5F5'
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribuição por <?= ucfirst($campo) ?>'
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutBounce'
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
   </div>
     </div>
     </div>
<br>
<br>
<div class="btn-group">
<a href="index.html" class="btn"> Voltar a Tela Inicial</a>

<footer>
    © 2025 - Desenvolvido por 3º MSI com Prof. Edimilson e Prof. Gerbison
  </footer>

  </div>

</body>
</html>
