<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader, [
    'debug' => true
]);
$twig->addExtension(new DebugExtension());

/** @var array<int, string> $result */
$result = glob('public/images/*.{jpg,jpeg,png}', GLOB_BRACE);
$images = [];
foreach ($result as $image) {
    $images[] = pathinfo($image)['basename'];
}

/** @noinspection PhpUnhandledExceptionInspection */
echo $twig->render('gallery/index.html.twig', [
    'images' => $images,
]);