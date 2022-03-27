<?php

declare(strict_types=1);

/** @var array<int, string> $images */
$images = glob(__DIR__ . '/public/uploads/*.{png}', GLOB_BRACE);
foreach ($images as $image) {
    $uniqId = uniqid('', false);
    $extension = preg_replace('#\?.*#', '', pathinfo($image, PATHINFO_EXTENSION));

    make_thumbnail_from_png($image, 200, 200, "public/thumbnail/200x200_$uniqId.$extension", 0);
    make_thumbnail_from_png($image, 400, 400, "public/thumbnail/400x400_$uniqId.$extension", 0);
    rename($image, "public/images/$uniqId.$extension");
}

/** @var array<int, string> $images */
$images = glob(__DIR__ . '/public/uploads/*.{jpg,jpeg}', GLOB_BRACE);
foreach ($images as $image) {
    $uniqId = uniqid('', false);
    $extension = preg_replace('#\?.*#', '', pathinfo($image, PATHINFO_EXTENSION));

    make_thumbnail_from_jpeg($image, 200, 200, "public/thumbnail/200x200_$uniqId.$extension", 0);
    make_thumbnail_from_jpeg($image, 400, 400, "public/thumbnail/400x400_$uniqId.$extension", 0);
    rename($image, "public/images/$uniqId.$extension");
}

function make_thumbnail_from_png(string $thumb_target, int $width = 60, ?int $height = null, ?string $SetFileName = null, int $quality = 8): void
{
    if ($height === null) {
        $height = $width;
    }

    $thumbnail = imagecreatefrompng($thumb_target);

    // size from
    [$w, $h] = getimagesize($thumb_target);

    if ($w > $h) {
        $newHeight = $height;
        $newWidth = floor($w * ($newHeight / $h));
        $cropX = ceil(($w - $h) / 2);
        $cropY = 0;
    } else {
        $newWidth = $width;
        $newHeight = floor($h * ($newWidth / $w));
        $cropX = 0;
        $cropY = ceil(($h - $w) / 2);
    }

    // I think this is where you are mainly going wrong
    $tmpImg = imagecreatetruecolor($width, $height);
    imagealphablending($tmpImg, false);
    imagesavealpha($tmpImg, true);
    imagecopyresampled($tmpImg, $thumbnail, 0, 0, (int)$cropX, (int)$cropY, (int)$newWidth, (int)$newHeight, $w, $h);

    imagepng($tmpImg, $SetFileName, $quality);

    imagedestroy($tmpImg);
}

function make_thumbnail_from_jpeg(string $thumb_target, int $width = 60, ?int $height = null, ?string $SetFileName = null, int $quality = 8): void
{
    if ($height === null) {
        $height = $width;
    }

    $thumbnail = imagecreatefromjpeg($thumb_target);

    // size from
    [$w, $h] = getimagesize($thumb_target);

    if ($w > $h) {
        $newHeight = $height;
        $newWidth = floor($w * ($newHeight / $h));
        $cropX = ceil(($w - $h) / 2);
        $cropY = 0;
    } else {
        $newWidth = $width;
        $newHeight = floor($h * ($newWidth / $w));
        $cropX = 0;
        $cropY = ceil(($h - $w) / 2);
    }

    // I think this is where you are mainly going wrong
    $tmpImg = imagecreatetruecolor($width, $height);
    imagealphablending($tmpImg, false);
    imagesavealpha($tmpImg, true);
    imagecopyresampled($tmpImg, $thumbnail, 0, 0, (int)$cropX, (int)$cropY, (int)$newWidth, (int)$newHeight, $w, $h);

    imagejpeg($tmpImg, $SetFileName, $quality);

    imagedestroy($tmpImg);
}