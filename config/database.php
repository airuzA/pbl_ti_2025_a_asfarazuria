<?php

$host    = 'localhost';
$db_name = 'pbl_ti_2025_a_asfarazuria';
$user    = 'root';
$pass    = '';

$conn = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8mb4", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
