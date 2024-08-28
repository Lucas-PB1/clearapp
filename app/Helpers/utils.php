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


function slug_fix($name, $alt = "_")
{
    // Remove caracteres especiais usando a função clean_slug
    $name = clean_slug($name);

    // Substitui espaços por underscores
    $name = str_replace(' ', $alt, $name);
    
    // Remove múltiplos hífens e os substitui por um único hífen
    $name = preg_replace('/-+/', $alt, $name);
    
    // Converte toda a string para minúsculas
    return strtolower($name);
}

function clean_slug($string)
{
    // Substituição de caracteres acentuados por seus equivalentes não acentuados
    $nova_string = preg_replace(
        array(
            "/(á|à|ã|â|ä)/",  // Substitui 'á', 'à', 'ã', 'â', 'ä' por 'a'
            "/(Á|À|Ã|Â|Ä)/",  // Substitui 'Á', 'À', 'Ã', 'Â', 'Ä' por 'A'
            "/(é|è|ê|ë)/",    // Substitui 'é', 'è', 'ê', 'ë' por 'e'
            "/(É|È|Ê|Ë)/",    // Substitui 'É', 'È', 'Ê', 'Ë' por 'E'
            "/(í|ì|î|ï)/",    // Substitui 'í', 'ì', 'î', 'ï' por 'i'
            "/(Í|Ì|Î|Ï)/",    // Substitui 'Í', 'Ì', 'Î', 'Ï' por 'I'
            "/(ó|ò|õ|ô|ö)/",  // Substitui 'ó', 'ò', 'õ', 'ô', 'ö' por 'o'
            "/(Ó|Ò|Õ|Ô|Ö)/",  // Substitui 'Ó', 'Ò', 'Õ', 'Ô', 'Ö' por 'O'
            "/(ú|ù|û|ü)/",    // Substitui 'ú', 'ù', 'û', 'ü' por 'u'
            "/(Ú|Ù|Û|Ü)/",    // Substitui 'Ú', 'Ù', 'Û', 'Ü' por 'U'
            "/(ñ)/",          // Substitui 'ñ' por 'n'
            "/(Ñ)/",          // Substitui 'Ñ' por 'N'
            "/(ç)/",          // Substitui 'ç' por 'c'
            "/(Ç)/",          // Substitui 'Ç' por 'C'
            "/[^A-Za-z0-9. ]/" // Remove todos os caracteres que não são letras, números, pontos ou espaços
        ),
        explode(" ", "a A e E i I o O u U n N c C"), // Mapeamento de substituição
        $string // String de entrada
    );

    return $nova_string; // Retorna a string "limpa"
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
