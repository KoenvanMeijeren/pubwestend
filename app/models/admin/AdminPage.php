<?php

namespace App\models\admin;

use App\services\database\DB;

abstract class AdminPage
{
    protected function makeOrUpdatePage(string $slug, string $title, string $description)
    {
        if (empty($this->getPage($slug))) {
            $this->makePage($slug, $title, $description);

            if (!empty($this->getPage($slug))) {
                return true;
            }

            return false;
        }

        $this->updatePage($slug, $title, $description);

        return true;
    }

    protected function makePage(string $slug, string $title, string $description)
    {
        $insertedPage = DB::table('page')
            ->insert([
                'Page_slug' => $slug,
                'Page_titel' => $title,
                'Page_description' => $description
            ])
            ->execute()
            ->getSuccessful();

        if ($insertedPage && !empty($this->getPage($slug))) {
            return true;
        }

        return false;
    }

    protected function getPage(string $slug)
    {
        $page = DB::table('page')
            ->select('*')
            ->where('Page_slug', '=', $slug)
            ->where('Page_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $page;
    }

    protected function getPages()
    {
        $pages = DB::table('page')
            ->select('*')
            ->where('Page_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        return $pages;
    }

    protected function updatePage(string $slug, string $title, string $description)
    {
        $updatedPage = DB::table('page')
            ->update([
                'Page_titel' => $title,
                'Page_description' => $description
            ])
            ->where('Page_slug', '=', $slug)
            ->where('Page_is_deleted', '=', '0')
            ->execute()
            ->getSuccessful();

        if ($updatedPage) {
            return true;
        }

        return false;
    }

    protected function softDeletePage(string $slug)
    {
        $softDeletedPage = DB::table('page')
            ->update([
                'Page_is_deleted' => '1'
            ])
            ->execute()
            ->getSuccessful();

        if ($softDeletedPage && empty($this->getPage($slug))) {
            return true;
        }

        return false;
    }
}