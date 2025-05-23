<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{



    public function __construct(
        private SluggerInterface $slugger,
    ) {

    }

    // ce service peut faire de l'upload de fichier mais dans ce projet, il ne sera utilisé que pour de l'upload d'images

      /**
     * Upload un fichier dans un dossier donné.
     *
     * @param UploadedFile $file Le fichier à uploader
     * @param string $targetDirectory Le dossier cible d'upload
     * @return string Le nom du fichier sauvegardé
     */
    public function upload(string $targetDirectory, UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($targetDirectory, $fileName);
            
        } catch (FileException $e) {
            throw new \Exception('Erreur lors du chargement du fichier.');
        }

        return $fileName;
    }


}