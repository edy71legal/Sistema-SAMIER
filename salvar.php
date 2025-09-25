
<?php
$conn = new mysqli("localhost", "root", "", "autoddeclaracao");

$nome = $_POST['nome_completo'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$data = $_POST['data_nascimento'];
$turma = $_POST['turma_id'];
$raca = $_POST['raca_cor'];
$idade = date_diff(date_create($data), date_create('today'))->y;

$sql = "INSERT INTO alunos (nome_completo, cpf, rg, data_nascimento, idade, raca_cor, turma_id) 
        VALUES ('$nome', '$cpf', '$rg', '$data', '$idade', '$raca', $turma)";

if ($conn->query($sql) === TRUE) {
    header("Location: relatorio.php?turma=$turma");
} else {
    echo "Erro: " . $conn->error;
}
?>
