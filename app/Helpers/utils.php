<?php

// Helper Geral
if (!function_exists('saudacao')) {
    function saudacao()
    {
        $message = 'Bom dia';
        $hora = date("H");

        if ($hora >= 12 && $hora <= 18) {
            $message = 'Boa tarde';
        } elseif ($hora >= 18) {
            $message = 'Boa Noite';
        }

        return $message;
    }
}


function slug_fix($name)
{
    $name = clean_slug($name);

    $name = str_replace(' ', '-', $name);
    $name = preg_replace('/-+/', '-', $name);
    return strtolower($name);
}

function clean_slug($string)
{
    $nova_string = preg_replace(
        array(
            "/(á|à|ã|â|ä)/",
            "/(Á|À|Ã|Â|Ä)/",
            "/(é|è|ê|ë)/",
            "/(É|È|Ê|Ë)/",
            "/(í|ì|î|ï)/",
            "/(Í|Ì|Î|Ï)/",
            "/(ó|ò|õ|ô|ö)/",
            "/(Ó|Ò|Õ|Ô|Ö)/",
            "/(ú|ù|û|ü)/",
            "/(Ú|Ù|Û|Ü)/",
            "/(ñ)/",
            "/(Ñ)/",
            "/(ç)/",
            "/(Ç)/",
            "/[^A-Za-z0-9. ]/"
        ),
        explode(" ", "a A e E i I o O u U n N c C"),
        $string
    );

    return $nova_string;
}


/**
 * Verifica se o arquivo existe no caminho passado
 * @param string $path Caminho do arquivo
 * @return false|string
 */
function file_exist(string $path)
{
    if (file_exists($path)) {
        return $path;
    } else {
        return false;
    }
}

function processLink($url)
{
    // Se parecer com uma chave do YouTube
    if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url))
        return 'https://www.youtube.com/embed/' . $url;

    // URLs do YouTube (padrão, curto ou incorporado)
    if (preg_match('#^(?:https?://)?(?:www\.)?(youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([a-zA-Z0-9_-]{11})#', $url, $matches))
        return 'https://www.youtube.com/embed/' . $matches[2];

    // Garante que URLs de outros sites usem HTTPS
    return strpos($url, 'http://') === 0 ? str_replace('http://', 'https://', $url) : $url;
}


function getConf($config, $slug)
{
    return $config->where('slug', $slug)->first();
}
