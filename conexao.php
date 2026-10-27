<?php
$conn = mysqli_connect("localhost", "root", "", "gestao_cafeteria");

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}
