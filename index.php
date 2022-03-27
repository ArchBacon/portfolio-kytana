<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

$images = [];

for ($i = 0; $i < 100; $i++) {
    $images[$i] = sprintf('https://picsum.photos/seed/%d', $i);
}

/** @noinspection PhpUnhandledExceptionInspection */
echo $twig->render('gallery/index.html.twig', [
    'images' => $images,
]);