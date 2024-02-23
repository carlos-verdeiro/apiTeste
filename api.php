<?php

$conn = new PDO("mysql:host=localhost;dbname=usuarios", 'root', '');

$stmt = $conn->query("SELECT * FROM pessoas");

$usuarios = $stmt->fetchAll();

// Verificando qual o método (procura-se GET)
$metodo = $_SERVER['REQUEST_METHOD'];

// Transformando em array
$requisicao = explode('/', trim($_SERVER['PATH_INFO'], '/'));

// Método de resposta
header('Content-Type: application/json');

if ($requisicao[0] == 'usuarios') {
    echo json_encode($usuarios);
} elseif ($requisicao[0] == 'usuario') {
    $id = $requisicao[1];
    $found = false;
    foreach ($usuarios as $usuario) {
        if ($usuario['id'] == $id) {
            echo json_encode($usuario);
            $found = true;
            break;
        }
    }
    if (!$found) {
        echo json_encode(['erro' => 'Usuario não encontrado']);
    }
} else {
    echo json_encode(['erro' => 'Caminho não encontrado']);
}
