<?php


namespace App\Upload;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Verot\Upload\Upload;

class UploadManager
{

    private $uploadsDirectory;

    public function __construct(string $uploadsDirectory)
    {
        $this->uploadsDirectory = $uploadsDirectory;
    }

    /**
     * Upload File and return new File name
     * @param UploadedFile $uploadedFile
     * @param string $previousImage
     * @return string
     */
    public function upload(UploadedFile $uploadedFile, string $previousImage = null): string
    {
        # Delete previous image
        if ($previousImage) {
            $this->deleteUploadedFile($previousImage);
            $this->deleteUploadedFile($previousImage, 120);
            $this->deleteUploadedFile($previousImage, 250);
            $this->deleteUploadedFile($previousImage, 320);
            $this->deleteUploadedFile($previousImage, 370);
            $this->deleteUploadedFile($previousImage, 470);
            $this->deleteUploadedFile($previousImage, 730);
        }

        # Set filename
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

        # Upload original file
        $uploadedFile->move(
            $this->uploadsDirectory,
            $newFilename
        );

        # Generate thumbnails
        $file = $this->uploadsDirectory . '/' . $newFilename;
        $this->generateThumbnail($file, 120, 150);
        $this->generateThumbnail($file, 250, 412);
        $this->generateThumbnail($file, 320, 320);
        $this->generateThumbnail($file, 370, 250);
        $this->generateThumbnail($file, 470, 200);
        $this->generateThumbnail($file, 730, 290);

        return $newFilename;

    }

    /**
     * Generate Thumbnail
     * @param string $file
     * @param int $sizeX
     * @param int $sizeY
     */
    private function generateThumbnail(string $file, int $sizeX, int $sizeY)
    {
        $handle = new Upload($file);
        if ($handle->uploaded) {
            $handle->image_resize = true;
            $handle->image_x = $sizeX;
            $handle->image_y = $sizeY;
            $handle->image_ratio_crop = true;
            $handle->process($this->uploadsDirectory . '/' . $sizeX);
        }
    }

    /**
     * Delete file from upload directory.
     * @param string $filename
     * @param string|null $dir
     */
    public function deleteUploadedFile(string $filename, string $dir = null): void
    {
        if ($filename !== 'default.png') {
            $uploadsDir = $dir === null ? $this->uploadsDirectory : $this->uploadsDirectory . '/' . $dir;
            $file = $uploadsDir . '/' . $filename;
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

}