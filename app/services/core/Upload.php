<?php


namespace App\services\core;

use App\services\exceptions\customException;
use Sirius\Upload\Handler as UploadHandler;

class Upload
{
    private $file;
    private $path;
    private $storedPath;

    public function __construct($file, string $path = STORAGE_PATH . '\media\\')
    {
        $this->file = $file;
        $this->path = $path;
    }

    public function prepare()
    {
        $convertedFileName = $this->convertFileName();

        if ($convertedFileName) {
            return true;
        }

        return false;
    }

    private function convertFileName()
    {
        $randomBytes = bin2hex($this->file['name']);

        switch ($this->file['type']) {
            case 'image/png':
                $this->file['name'] = $randomBytes . '.png';
                return true;
                break;
            case 'image/jpg':
                $this->file['name'] = $randomBytes . '.jpg';
                return true;
                break;
            case 'image/jpeg':
                $this->file['name'] = $randomBytes . '.jpeg';
                return true;
                break;
            default:
                Session::flash('error',
                    'Je probeerde een niet toegestaan bestand te uploaden. Alleen bestanden met .jpg, .jpeg en .png zijn toegestaan.');
                return false;
                break;
        }
    }

    public function execute()
    {
        $uploadHandler = new UploadHandler($this->path);

        // validation rules
        $uploadHandler->addRule('extension', ['allowed' => ['jpg', 'jpeg', 'png']],
            '{label} should be a valid image (jpg, jpeg, png)', 'Profile picture');
        $uploadHandler->addRule('size', ['max' => '20M'], '{label} should have less than {max}', 'Profile picture');

        $result = $uploadHandler->process($this->file); // ex: subdirectory/my_headshot.png
        if ($result->isValid()) {
            // do something with the image like attaching it to a model etc
            try {
                $result->confirm(); // this will remove the .lock file
                $this->setStoredFilePath($this->path . $result->name);
                return true;
            } catch (\Exception $exception) {
                // something wrong happened, we don't need the uploaded files anymore
                $result->clear();
                customException::handle($exception);
                return false;
            }
        }

        // image was not moved to the container, where are error messages
        $messages = $result->getMessages();
        Session::flash('error', 'Het bestand kon niet worden geupload.');
        Log::error('Something went wrong while uploading the file', $messages);
        return false;
    }

    private function setStoredFilePath(string $path)
    {
        $this->storedPath = $path;
    }

    public function getStoredFilePath()
    {
        return $this->storedPath;
    }

    public function __destruct()
    {
        $this->file = null;
        $this->path = null;
    }
}