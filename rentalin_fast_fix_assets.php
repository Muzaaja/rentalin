<?php
/**
 * Rentalin Fast Asset Fix
 * Jalankan dari root project Laravel:
 * php rentalin_fast_fix_assets.php
 */

function fail_message(string $message): void
{
    fwrite(STDERR, "ERROR: {$message}\n");
    exit(1);
}

function copy_directory(string $source, string $destination): void
{
    if (!is_dir($source)) {
        fail_message("Folder sumber tidak ditemukan: {$source}");
    }

    if (!is_dir($destination)) {
        mkdir($destination, 0777, true);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        $target = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
        if ($item->isDir()) {
            if (!is_dir($target)) {
                mkdir($target, 0777, true);
            }
        } else {
            copy($item->getPathname(), $target);
        }
    }
}

function normalize_path(string $path): string
{
    return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
}

$root = getcwd();

if (!file_exists($root . DIRECTORY_SEPARATOR . 'artisan')) {
    fail_message('File artisan tidak ditemukan. Jalankan script ini dari root project Laravel.');
}

$legacyAssets = normalize_path($root . '/HTML lama/assets');
$publicAssets = normalize_path($root . '/public/assets');
$viewsPath = normalize_path($root . '/resources/views');

if (!is_dir($legacyAssets)) {
    fail_message("Folder 'HTML lama/assets' tidak ditemukan.");
}

if (!is_dir($viewsPath)) {
    fail_message("Folder 'resources/views' tidak ditemukan.");
}

echo "== Rentalin Fast Asset Fix ==\n";
echo "1. Menyalin HTML lama/assets ke public/assets ...\n";
copy_directory($legacyAssets, $publicAssets);

echo "2. Mengubah path assets/... di resources/views ...\n";

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsPath, FilesystemIterator::SKIP_DOTS)
);

$changedFiles = 0;

foreach ($iterator as $file) {
    if (!$file->isFile()) {
        continue;
    }

    $filename = $file->getFilename();
    if (!str_ends_with($filename, '.blade.php') && !str_ends_with($filename, '.php')) {
        continue;
    }

    $path = $file->getPathname();
    $old = file_get_contents($path);
    $new = $old;

    // Contoh: src="assets/img/logo.png" -> src="{{ asset('assets/img/logo.png') }}"
    $new = preg_replace_callback('/(?<!asset\()"assets\/([^"\r\n]+)"/', function ($match) {
        return '"{{ asset(\'assets/' . $match[1] . '\') }}"';
    }, $new);

    // Contoh: onerror="this.src='assets/img/fallback.png'" -> onerror="this.src='{{ asset("assets/img/fallback.png") }}'"
    $new = preg_replace_callback('/(?<!asset\()\'assets\/([^\'\r\n]+)\'/', function ($match) {
        return '\'{{ asset("assets/' . $match[1] . '") }}\'';
    }, $new);

    if ($new !== $old) {
        file_put_contents($path, $new);
        $changedFiles++;
        echo "UPDATED: " . str_replace($root . DIRECTORY_SEPARATOR, '', $path) . "\n";
    }
}

echo "Total file view yang diubah: {$changedFiles}\n";

echo "3. Membersihkan cache Laravel ...\n";
passthru('php artisan view:clear');
passthru('php artisan route:clear');
passthru('php artisan cache:clear');

echo "\nSelesai.\n";
echo "Langkah berikutnya:\n";
echo "1. Jalankan: npm run build\n";
echo "2. Jalankan: php artisan serve\n";
echo "3. Buka: http://127.0.0.1:8000/assets/css/main.css\n";
echo "4. Buka: http://127.0.0.1:8000/\n";
echo "5. Buka: http://127.0.0.1:8000/login\n";
