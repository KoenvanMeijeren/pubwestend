<?php

namespace App\models;

use App\models\admin\AdminPage;
use App\services\database\DB;
use App\services\parsers\ParserFactory;

abstract class Home extends AdminPage
{
    /**
     * Get all menu categories.
     *
     * @return array
     */
    private function getMenuCategories()
    {
        $menus = DB::table('menu')
            ->select('Menu_category')
            ->where('Menu_is_deleted', '=', '0')
            ->orderBy('ASC', 'Menu_category')
            ->execute()
            ->toArray();

        return $menus;
    }

    /**
     * Get all menu items which are matching with a specific category.
     *
     * @param string $category
     * @return array
     */
    private function getMenuItemsBasedOnCategory(string $category)
    {
        $menus = DB::table('menu')
            ->select('*')
            ->where('Menu_category', '=', $category)
            ->where('Menu_is_deleted', '=', '0')
            ->execute()
            ->toArray();

        return $menus;
    }

    /**
     * Get all the menu items.
     *
     * @return array
     */
    protected function getConvertedMenus()
    {
        $menus = $this->getMenuCategories();
        $categories = [];
        $menuItems = [];
        $previousCategory = '';
        if (!empty($menus)) {
            foreach ($menus as $menu) {
                // set the current category
                $currentCategory = $menu['Menu_category'];

                // check if the current menu category is unique and if so store him in the array
                if ($currentCategory !== $previousCategory && !in_array($menu['Menu_category'], $categories)) {
                    $categories[] = $menu['Menu_category'];
                }

                $menus = $this->getMenuItemsBasedOnCategory($menu['Menu_category']);
                if (!empty($menus)) {
                    $menuItems += [$menu['Menu_category'] => $menus];
                }

                // set the previous category
                $previousCategory = $menu['Menu_category'];
            }
        }

        // set the return array
        $array = [
            'categories' => $categories,
            'items' => $menuItems
        ];

        return $array;
    }

    /**
     * Convert the category into a string.
     *
     * @param string $category
     * @return string
     */
    public static function convertCategory(string $category)
    {
        switch ($category) {
            case '1.1':
                return 'VoorgerechtWarm';
                break;

            case '1.2':
                return 'VoorgerechtKoud';
                break;

            case '2.1':
                return 'HoofdgerechtWarm';
                break;

            case '2.2':
                return 'HoofdgerechtKoud';
                break;

            case '3.1':
                return 'NagerechtWarm';
                break;

            case '3.2':
                return 'NagerechtKoud';
                break;

            case '4.1':
                return 'DrankenWarm';
                break;

            case '4.2':
                return 'DrankenKoud';
                break;

            case '4.3':
                return 'DrankenAlcoholisch';
                break;

            default:
                return "Onbekend";
                break;
        }
    }

    /**
     * Get our story and convert it into an array or string.
     *
     * @return array|string
     */
    protected function getOurStory()
    {
        $ourStoryLeft = $this->getPage('our-story-left');
        $ourStoryRight = $this->getPage('our-story-right');
        if (!empty($ourStoryLeft) && !empty($ourStoryRight)) {
            $ourStory = [
                'title' => $ourStoryLeft->Page_titel,
                'descriptionLeft' => $ourStoryLeft->Page_description,
                'descriptionRight' => $ourStoryRight->Page_description
            ];
        }

        if (!empty($ourStory)) {
            return $ourStory;
        }

        return '';
    }

    /**
     * Get all opening hours and convert into an array.
     *
     * @return array|bool
     */
    protected function getConvertedOpeningHours()
    {
        if (!empty($this->getPage('opening-hours'))) {
            $openingHours = $this->getPage('opening-hours');
            $openingHours = $openingHours->Page_description;
            $openingHours = htmlspecialchars_decode($openingHours);

            $factory = new ParserFactory();
            $json = $factory->createJsonParser();
            $openingHours = $json->parse($openingHours);

            // convert all opening hours to one string per day
            if ($openingHours !== null) {
                $sunday = $this->convertOpeningHours('sunday', $openingHours);
                $monday = $this->convertOpeningHours('monday', $openingHours);
                $tuesday = $this->convertOpeningHours('tuesday', $openingHours);
                $wednesday = $this->convertOpeningHours('wednesday', $openingHours);
                $thursday = $this->convertOpeningHours('thursday', $openingHours);
                $friday = $this->convertOpeningHours('friday', $openingHours);
                $saturday = $this->convertOpeningHours('saturday', $openingHours);

                $newOpeningHours = [
                    'Zondag' => $sunday,
                    'Maandag' => $monday,
                    'Dinsdag' => $tuesday,
                    'Woensdag' => $wednesday,
                    'Donderdag' => $thursday,
                    'Vrijdag' => $friday,
                    'Zaterdag' => $saturday,
                ];

                return $newOpeningHours;
            }

            return 'Gesloten';
        }

        return false;
    }

    /**
     * Convert opening hours per day to string.
     *
     * @param string $day
     * @param array $openingHours
     * @return bool|string
     */
    private function convertOpeningHours(string $day, array $openingHours)
    {
        if (
            isset($openingHours[$day . 'AfternoonOpeningTime']) &&
            isset($openingHours[$day . 'EveningOpeningTime']) &&
            isset($openingHours[$day . 'AfternoonClosingTime']) &&
            isset($openingHours[$day . 'EveningClosingTime'])
        ) {
            // closed
            if (
                empty($openingHours[$day . 'AfternoonOpeningTime']) &&
                empty($openingHours[$day . 'EveningOpeningTime']) &&
                empty($openingHours[$day . 'AfternoonClosingTime']) &&
                empty($openingHours[$day . 'EveningClosingTime'])
            ) {
                return 'Gesloten';
            }

            // 2 of 2 open
            if (
                !empty($openingHours[$day . 'AfternoonOpeningTime']) &&
                !empty($openingHours[$day . 'EveningOpeningTime']) &&
                !empty($openingHours[$day . 'AfternoonClosingTime']) &&
                !empty($openingHours[$day . 'EveningClosingTime'])
            ) {
                return $openingHours[$day . 'AfternoonOpeningTime'] . ' - ' . $openingHours[$day . 'AfternoonClosingTime'] . ' / ' .
                    $openingHours[$day . 'EveningOpeningTime'] . ' - ' . $openingHours[$day . 'EveningClosingTime'];
            }

            // 1 of 2 open, afternoon
            if (
                !empty($openingHours[$day . 'AfternoonOpeningTime']) &&
                !empty($openingHours[$day . 'AfternoonClosingTime']) &&
                empty($openingHours[$day . 'EveningOpeningTime']) &&
                empty($openingHours[$day . 'EveningClosingTime'])
            ) {
                return $openingHours[$day . 'AfternoonOpeningTime'] . ' - ' . $openingHours[$day . 'AfternoonClosingTime'];
            }

            // 1 of 2 open, evening
            if (
                empty($openingHours[$day . 'AfternoonOpeningTime']) &&
                empty($openingHours[$day . 'AfternoonClosingTime']) &&
                !empty($openingHours[$day . 'EveningOpeningTime']) &&
                !empty($openingHours[$day . 'EveningClosingTime'])
            ) {
                return $openingHours[$day . 'EveningOpeningTime'] . ' - ' . $openingHours[$day . 'EveningClosingTime'];
            }
        }

        return false;
    }
}
