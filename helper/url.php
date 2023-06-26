<?php

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

$urlAsset = $actual_link . '/assets/';
$urlConfig = $actual_link .  '/config/';
$urlPage = $actual_link . '/page';
$urlAdmin = $actual_link . '/page/admin/';
$urlAdmin = $actual_link . '/page/admin/';
$urlCbt = $actual_link . '/page/cbt/';
$urlExam = $actual_link . '/page/exam/';
$urlLjk = $actual_link . '/page/ljk/';
$urlFinish = $actual_link . '/page/finish/';
$urlTemplate = $actual_link . '/page/template/';
$urlConfirm = $actual_link . '/page/confirm/';

$urlWebsite = 'http://localhost/pramuka/';
$urlSpekta = 'http://localhost/ui_spekta/';