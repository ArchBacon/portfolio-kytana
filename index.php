<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

/** @noinspection PhpUnhandledExceptionInspection */
echo $twig->render('gallery/index.html.twig', [
    'controller_name' => 'GalleryController'
]);