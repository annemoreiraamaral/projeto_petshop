<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require "config.php";

// Roteador simples baseado em query string (?rota=...)
$rota = $_GET["rota"] ?? "teste";

function teste() {
    echo json_encode(["mensagem" => "Back-end respondendo"]);
}

// Rota 1: lista todos os animais
function listarAnimais($con) {
    $stmt = $con->query("SELECT * FROM Animais");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Rota 2: filtra animais por espécie
function listarPorEspecie($con) {
    $especie = $_GET["especie"] ?? "";
    $stmt = $con->prepare("SELECT * FROM Animais WHERE especie = ?");
    $stmt->execute([$especie]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Rota 3: filtra animais por raça
function listarPorRaca($con) {
    $raca = $_GET["raca"] ?? "";
    $stmt = $con->prepare("SELECT * FROM Animais WHERE raca = ?");
    $stmt->execute([$raca]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Rota 4: calcula a idade média dos animais
function idadeMedia($con) {
    $stmt = $con->query("SELECT AVG(idade) AS idade_media FROM Animais");
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

// Rota 5: lista todos os serviços
function listarServicos($con) {
    $stmt = $con->query("SELECT * FROM Servicos");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Rota 6: filtra serviços por categoria
function listarServicosPorCategoria($con) {
    $categoria = $_GET["categoria"] ?? "";
    $stmt = $con->prepare("SELECT * FROM Servicos WHERE categoria = ?");
    $stmt->execute([$categoria]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Rota 7: calcula a média dos preços dos serviços
function mediaPrecoServicos($con) {
    $stmt = $con->query("SELECT AVG(preco) AS preco_medio FROM Servicos");
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

// Rota 8: mostra o serviço mais caro
function servicoMaisCaro($con) {
    $stmt = $con->query("SELECT * FROM Servicos ORDER BY preco DESC LIMIT 1");
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

// Roteamento
switch ($rota) {

    case "animais":
        listarAnimais($con);
        break;

    case "animais/especie":
        listarPorEspecie($con);
        break;

    case "animais/raca":
        listarPorRaca($con);
        break;

    case "animais/idade-media":
        idadeMedia($con);
        break;

    case "servicos":
        listarServicos($con);
        break;

    case "servicos/categoria":
        listarServicosPorCategoria($con);
        break;

    case "servicos/media-preco":
        mediaPrecoServicos($con);
        break;

    case "servicos/mais-caro":
        servicoMaisCaro($con);
        break;

    default:
        teste();
        break;
}