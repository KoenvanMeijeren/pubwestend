<?php


namespace App\model\admin;


use App\services\core\Session;
use App\services\core\Upload;
use App\services\database\DB;

class AdminDeveloper
{
    /**
     * Make a new item
     *
     * @param array $file
     * @return bool
     */
    public function makeFile(array $file)
    {
        $upload = new Upload($file);

        if ($upload->prepare()) {
            if ($upload->execute()) {
                $insertedPath = DB::table('files')
                    ->insert(['file_path' => $upload->getStoredFilePath()])
                    ->execute()
                    ->getSuccessful();

                if ($insertedPath) {
                    Session::flash('success', 'Het bestand is succesvol geupload.');
                    return true;
                }
            }
        }

        return false;
    }

    public function getFiles()
    {
        $files = DB::table('files')
            ->select('*')
            ->execute()
            ->all();

        return $files;
    }
}