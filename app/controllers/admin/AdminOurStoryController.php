<?php

namespace App\controllers\admin;

use App\models\admin\AdminPage;
use App\services\core\Request;
use App\services\core\Session;
use App\services\core\URL;

class adminOurStoryController extends AdminPage
{
    public function index()
    {
        $title = 'Ons verhaal bewerken';

        // get the page our story data
        $ourStoryLeft = $this->getPage('our-story-left');
        $ourStoryRight = $this->getPage('our-story-right');
        if (!empty($ourStoryLeft) && !empty($ourStoryRight)) {
            $ourStory = [
                'title' => $ourStoryLeft->Page_titel,
                'descriptionLeft' => $ourStoryLeft->Page_description,
                'descriptionRight' => $ourStoryRight->Page_description
            ];
        }

        return view('admin/home/our-story', compact('title', 'ourStory'));
    }

    public function storeOrUpdate()
    {
        $request = new Request();
        $title = $request->post('title');
        $contentLeft = $request->post('contentLeft');
        $contentRight = $request->post('contentRight');

        $resultLeft = $this->makeOrUpdatePage('our-story-left', $title, $contentLeft);
        $resultRight = $this->makeOrUpdatePage('our-story-right', $title, $contentRight);

        if ($resultLeft && $resultRight) {
            Session::flash('success', 'Ons verhaal is succesvol opgeslagen.');
            URL::redirect('/admin/our-story');
            exit();
        }

        Session::flash('error', 'Ons verhaal opslaan is mislukt.');
        URL::redirect('/admin/our-story');
        exit();
    }
}