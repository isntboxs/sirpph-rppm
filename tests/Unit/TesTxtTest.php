<?php

$filePath = base_path('tes.txt');

test('tes.txt exists in project root', function () use ($filePath) {
    expect(file_exists($filePath))->toBeTrue();
});

test('tes.txt contains expected content', function () use ($filePath) {
    $content = file_get_contents($filePath);
    expect($content)->toContain('ini percobaan');
});

test('tes.txt content matches exactly', function () use ($filePath) {
    $content = file_get_contents($filePath);
    expect(trim($content))->toBe('ini percobaan');
});

test('tes.txt is a regular file, not a directory', function () use ($filePath) {
    expect(is_file($filePath))->toBeTrue();
});

test('tes.txt is readable', function () use ($filePath) {
    expect(is_readable($filePath))->toBeTrue();
});

test('tes.txt does not have empty content', function () use ($filePath) {
    $content = file_get_contents($filePath);
    expect($content)->not->toBeEmpty();
});