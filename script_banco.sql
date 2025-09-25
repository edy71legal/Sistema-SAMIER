
CREATE DATABASE autoddeclaracao;
USE autoddeclaracao;

CREATE TABLE turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(100),
    cpf VARCHAR(14),
    rg VARCHAR(20),
    data_nascimento DATE,
    idade INT,
    raca_cor ENUM('Branca', 'Preta', 'Parda', 'Amarela', 'Indígena', 'Prefere não declarar'),
    turma_id INT,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (turma_id) REFERENCES turmas(id)
);

--INSERIR O NOME DAS DEMAIS TURMAS DA ESCOLA NO BANCO DE DADOS
INSERT INTO turmas (nome) VALUES ('3º MSI-01');
