<?php


namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait SummernoteTrait
{
    /**
     * Converte imagens embutidas no conteúdo.
     *
     * @param string $content Conteúdo contendo imagens.
     * @param int $id ID associado ao conteúdo.
     * @param string $slug Slug associado ao conteúdo.
     */
    public function convertEmbeddedImages($id)
    {
        $content = $this->table->find($id);
        $embeddedImages = $this->getEmbeddedImages($content->texto);

        foreach ($embeddedImages as $imagePath) {
            $newPath = '/storage/' . $this->relocateTemporaryImage($imagePath, $id);
            $content->texto = str_replace($imagePath, $newPath, $content->texto);
        }

        $content->save();
    }

    /**
     * Obtém todos os caminhos das imagens embutidas no conteúdo.
     *
     * @param string $content Conteúdo contendo imagens.
     * @return array Lista de caminhos de imagens.
     */
    private function getEmbeddedImages($content)
    {
        $pattern = '/src="([^"]+)"/';
        preg_match_all($pattern, $content, $matches);
        return $matches[1] ?? [];
    }

    /**
     * Verifica se a imagem é temporária.
     *
     * @param string $imagePath Caminho da imagem.
     * @return bool Verdadeiro se for temporário, falso caso contrário.
     */
    private function isTemporary($imagePath)
    {
        return Storage::exists($imagePath) && str_contains($imagePath, 'temporarios');
    }

    /**
     * Move uma imagem temporária para um diretório permanente.
     *
     * @param string $oldPath Caminho atual da imagem.
     * @param string $slug Slug associado ao conteúdo.
     * @param int $id ID associado ao conteúdo.
     * @return string Novo caminho da imagem.
     */
    private function relocateTemporaryImage($oldPath, $slug)
    {
        $relativeOldPath = str_replace('/storage/', '', $oldPath);

        $imageName = Str::after($relativeOldPath, 'summernote-files/temporarios/temp-');
        $newPath = "summernote-files/content/$slug/$imageName";

        Storage::move($relativeOldPath, $newPath);

        return $newPath;
    }
}

