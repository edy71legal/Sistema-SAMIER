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

// Coletar dados da turma
$dados_turma = [];
foreach ($cores as $cor) {
    $dados_turma[] = percentual($cor, $turma, $conn);
}

// Coletar dados da unidade escolar
$totalGeral = $conn->query("SELECT COUNT(*) as total FROM alunos")->fetch_assoc()['total'];
$dados_geral = [];
foreach ($cores as $cor) {
    $countGeral = $conn->query("SELECT COUNT(*) as c FROM alunos WHERE raca_cor='$cor'")->fetch_assoc()['c'];
    $percentual = ($totalGeral > 0) ? round(($countGeral / $totalGeral) * 100, 1) : 0;
    $dados_geral[] = $percentual;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Indicadores de Autodeclaração</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: auto; padding: 20px; }
        h2 { margin-top: 40px; }
        .chart-container { width: 45%; display: inline-block; vertical-align: top; margin: 20px; }
    </style>
</head>
<body>
     <h1>Indicadores de Autodeclaração - Turma <?php echo $turma; ?></h1>


    <h2>Turma</h2>
    <div class="chart-container">
        <canvas id="pizzaTurma"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="barraTurma"></canvas>
    </div>

    <h2>Unidade Escolar</h2>
    <div class="chart-container">
        <canvas id="pizzaGeral"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="barraGeral"></canvas>
    </div>

<script>
    const labels = <?php echo json_encode($cores); ?>;

    // Dados turma
    const dadosTurma = <?php echo json_encode($dados_turma); ?>;
    // Dados geral
    const dadosGeral = <?php echo json_encode($dados_geral); ?>;

    // Cores para gráficos
    const backgroundColors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#8BC34A', '#FF9800', '#9E9E9E'
    ];

    // Gráfico Pizza Turma
    new Chart(document.getElementById('pizzaTurma'), {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dadosTurma,
                backgroundColor: backgroundColors
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Percentual por Raça/Cor (Turma)'
                }
            }
        }
    });

    // Gráfico Barra Turma
    new Chart(document.getElementById('barraTurma'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: '% Turma',
                data: dadosTurma,
                backgroundColor: backgroundColors
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, max: 100 }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Percentual por Raça/Cor (Turma)'
                },
                legend: { display: false }
            }
        }
    });

    // Gráfico Pizza Geral
    new Chart(document.getElementById('pizzaGeral'), {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dadosGeral,
                backgroundColor: backgroundColors
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Percentual por Raça/Cor (Unidade Escolar)'
                }
            }
        }
    });

    // Gráfico Barra Geral
    new Chart(document.getElementById('barraGeral'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: '% Unidade Escolar',
                data: dadosGeral,
                backgroundColor: backgroundColors
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, max: 100 }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Percentual por Raça/Cor (Unidade Escolar)'
                },
                legend: { display: false }
            }
        }
    });
</script>

</body>
</html>
