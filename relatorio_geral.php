<?php
$conn = new mysqli("localhost", "root", "", "autoddeclaracao");

$total = $conn->query("SELECT COUNT(*) as total FROM alunos")->fetch_assoc()['total'];
$cores = ['Branca', 'Preta', 'Parda', 'Amarela', 'Indígena', 'Prefere não declarar'];
$dados = [];

foreach ($cores as $cor) {
    $count = $conn->query("SELECT COUNT(*) as c FROM alunos WHERE raca_cor='$cor'")->fetch_assoc()['c'];
    $dados[] = round(($count / max($total, 1)) * 100, 1);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Geral da Unidade Escolar</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
body {
  font-family: Arial, sans-serif;
  margin: 10px;
  padding: 0;
  background: #f9f9f9;
  color: #333;
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

       /* body { font-family: 'Segoe UI', sans-serif; margin: 20px; background: #f9f9f9; color: #333; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        */
    </style>
</head>
<body>
    <div class="container">

<div class="flex-container">
  <div class="chart-container">


    <h1>Relatório Geral da Unidade Escolar</h1>
    <h2>Total de Estudantes Participantes: <?= $total ?></h2>
    <canvas id="graficoGeral"></canvas>

    <script>
        new Chart(document.getElementById('graficoGeral'), {
            type: 'pie',
            data: {
                labels: <?= json_encode($cores) ?>,
                datasets: [{
                    label: '% por Raça/Cor',
                    data: <?= json_encode($dados) ?>,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#8BC34A', '#FF9800', '#9E9E9E']
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribuição de Raça/Cor na Escola'
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeOutElastic'
                }
            }
        });
    </script>
    
     </div>
</div>

<br>
<br>
<div class="btn-group">
<a href="index.html" class="btn"> Voltar a Tela Inicial</a>
</div>
<br>
<br>
<br>
<center>
      <font size="2"  face="sans-serif" color="gray">

     © 2025 - Desenvolvido por 3º MSI com Prof. Edimilson e Prof. Gerbison </font>
     <center>
      
</body>
</html>
