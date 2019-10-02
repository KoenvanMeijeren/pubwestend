<?php

namespace App\controllers\admin;

use App\models\admin\AdminSettings;
use App\services\core\Request;
use App\services\core\URL;

class AdminSettingsController extends AdminSettings
{
    public function index()
    {
        $title = 'Instellingen';
        $settings = $this->getSettings();

        return view('admin/settings/settings', compact('title', 'settings'));
    }

    public function storeOrUpdate()
    {
        $request = new Request();
        $parameters = $request->postAll([
            'companyName',
            'companyTel',
            'companyEmail',
            'companyAddress',
            'companyPostcode',
            'companyCity',
            'companyBankNumber',
            'companyKVKNumber',
            'facebook',
            'instagram',
            'linkedin',
            'youtube',
            'twitter',
            'capacityRestaurant',
            'spendingTimeRestaurant'
        ]);

        // store or update the settings
        $result = $this->makeOrUpdateSettings($parameters);

        if ($result) {
            URL::redirect('/admin/settings');
            exit();
        }

        URL::redirect('/admin/settings');
        exit();
    }
}