<?php
header('Content-Type: application/json');

$baseDir = 'main'; // Defina o diretório base onde estão as pastas e arquivos de áudio
$dir = isset($_GET['dir']) ? rtrim($_GET['dir'], '/') : ''; // Obtenha o diretório especificado na requisição

function listFiles($baseDir, $dir) {
    $path = $baseDir . '/' . $dir;
    if (!is_dir($path)) {
        return array(); // Retorna uma lista vazia se o diretório não existir
    }

    $files = scandir($path);
    $fileList = array();

    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $filePath = $path . '/' . $file;
            if (is_dir($filePath)) {
                // Se for um diretório, adiciona à lista como uma pasta
                $fileList[] = array(
                    'name' => $file,
                    'path' => $dir ? $dir . '/' . $file : $file,
                    'isDirectory' => true
                );
            } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'mp3') {
                // Se for um arquivo MP3, adiciona à lista como um arquivo de áudio
                $fileList[] = array(
                    'name' => $file,
                    'path' => $dir ? $dir . '/' . $file : $file,
                    'isDirectory' => false
                );
            }
        }
    }
    return $fileList;
}

echo json_encode(listFiles($baseDir, $dir));
?>
