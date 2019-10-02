<?php

namespace App\controllers\admin;

use App\models\admin\AdminPage;
use App\services\core\Request;
use App\services\core\Session;
use App\services\core\URL;
use App\services\parsers\ParserFactory;

class adminOpeningHoursController extends AdminPage
{
    /**
     * Show the form to edit or create opening hours.
     *
     * @return mixed
     */
    public function index()
    {
        $title = 'Openingstijden bewerken';
        $openingHours = $this->getPage('opening-hours');
        if (!empty($openingHours)) {
            $openingHours = $openingHours->Page_description;
            $openingHours = htmlspecialchars_decode($openingHours);

            $factory = new ParserFactory();
            $json = $factory->createJsonParser();
            $openingHours = $json->parse($openingHours);
        }

        return view('admin/home/opening-hours', compact('title', 'openingHours'));
    }

    public function storeOrUpdate()
    {
        $request = new Request();
        $parameters = $request->postAll([
            'sundayAfternoonOpeningTime',
            'sundayEveningOpeningTime',
            'sundayAfternoonClosingTime',
            'sundayEveningClosingTime',
            'mondayAfternoonOpeningTime',
            'mondayEveningOpeningTime',
            'mondayAfternoonClosingTime',
            'mondayEveningClosingTime',
            'tuesdayAfternoonOpeningTime',
            'tuesdayEveningOpeningTime',
            'tuesdayAfternoonClosingTime',
            'tuesdayEveningClosingTime',
            'wednesdayAfternoonOpeningTime',
            'wednesdayEveningOpeningTime',
            'wednesdayAfternoonClosingTime',
            'wednesdayEveningClosingTime',
            'thursdayAfternoonOpeningTime',
            'thursdayEveningOpeningTime',
            'thursdayAfternoonClosingTime',
            'thursdayEveningClosingTime',
            'fridayAfternoonOpeningTime',
            'fridayEveningOpeningTime',
            'fridayAfternoonClosingTime',
            'fridayEveningClosingTime',
            'saturdayAfternoonOpeningTime',
            'saturdayEveningOpeningTime',
            'saturdayAfternoonClosingTime',
            'saturdayEveningClosingTime',
        ]);
        $json = json_encode($parameters);

        $result = $this->makeOrUpdatePage('opening-hours', 'Openingstijden', $json);

        if ($result) {
            Session::flash('success', 'Openingstijden zijn succesvol opgeslagen.');
            URL::redirect('/admin/opening-hours');
            exit();
        }

        Session::flash('error', 'Openingstijden opslaan is mislukt.');
        URL::redirect('/admin/opening-hours');
        exit();
    }
}