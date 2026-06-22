<?php
/**
 * Strip emoji/decorative icons from view templates (safe — preserves formatting).
 * Usage: php scripts/strip_view_emojis.php
 */
declare(strict_types=1);

$base = dirname(__DIR__) . '/app/views';
$skip = ['layouts/main.php']; // handled manually

$emojiPattern = '/[\x{1F000}-\x{1FAFF}\x{2600}-\x{27BF}\x{FE0F}\x{200D}]+/u';

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
);

$updated = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') {
        continue;
    }

    $rel = str_replace('\\', '/', substr($file->getPathname(), strlen($base) + 1));
    if (in_array($rel, $skip, true)) {
        continue;
    }

    $path = $file->getPathname();
    $content = file_get_contents($path);
    if ($content === false) {
        continue;
    }

    $original = $content;

    $content = preg_replace(
        '/<div class="empty-icon(?:-state)?">[^<]*<\/div>/u',
        '<div class="empty-icon" aria-hidden="true"></div>',
        $content
    );
    $content = preg_replace(
        '/<div class="empty-state-icon">[^<]*<\/div>/u',
        '<div class="empty-icon" aria-hidden="true"></div>',
        $content
    );
    $content = preg_replace('/\s*<span class="alert-icon">[^<]*<\/span>/u', '', $content);
    $content = preg_replace(
        '/<span class="search-icon">[^<]*<\/span>/u',
        '<span class="search-icon" aria-hidden="true"></span>',
        $content
    );
    $content = preg_replace($emojiPattern, '', $content);

    // Trim stray spaces before closing tags in labels/placeholders only
    $content = preg_replace('/placeholder="\s+/u', 'placeholder="', $content);
    $content = preg_replace('/(<label[^>]*>)\s+/u', '$1', $content);

    if ($content !== $original) {
        file_put_contents($path, $content);
        $updated++;
        echo "Updated: {$rel}\n";
    }
}

echo "\nDone. {$updated} file(s) updated.\n";
