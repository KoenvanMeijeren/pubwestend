<?php

namespace App\models\admin;

use App\services\database\DB;
use App\services\core\Session;

abstract class AdminSettings
{
    protected function makeOrUpdateSettings(array $parameters)
    {
        foreach ($parameters as $key => $parameter) {
            if (empty($this->getSetting($key))) {
                $this->makeSetting($key, $parameter);
                continue;
            }

            $this->updateSetting($key, $parameter);
            continue;
        }

        return true;
    }

    protected function makeSetting(string $key, $value)
    {
        $result = DB::table('settings')
            ->insert([
                'settings_name' => $key,
                'settings_value' => $value
            ])
            ->execute()
            ->getSuccessful();

        if ($result && !empty($this->getSetting($key))) {
            Session::flash('success', 'Instellingen zijn succesvol opgeslagen.');
            return true;
        }

        Session::flash('error', 'Instellingen opslaan is mislukt.');
        return false;
    }

    protected function getSetting(string $key)
    {
        $setting = DB::table('settings')
            ->select('*')
            ->where('settings_name', '=', $key)
            ->where('settings_is_deleted', '=', '0')
            ->execute()
            ->first();

        return $setting;
    }

    protected function getSettings()
    {
        $settings = DB::table('settings')
            ->select('*')
            ->where('settings_is_deleted', '=', '0')
            ->execute()->toArray();

        return $settings;
    }

    protected function updateSetting(string $key, $value)
    {
        $result = DB::table('settings')
            ->update([
                'settings_value' => $value
            ])
            ->where('settings_name', '=', $key)
            ->where('settings_is_deleted', '=', '0')
            ->execute()
            ->getSuccessful();

        if ($result) {
            Session::flash('success', 'Instellingen opslaan is gelukt.');
            return true;
        }

        Session::flash('error', 'Instellingen opslaan is mislukt.');
        return false;
    }

    protected function softDeleteSetting(string $key)
    {
        $result = DB::table('settings')
            ->update([
                'settings_is_deleted' => $key
            ])->execute()
            ->getSuccessful();

        if ($result && empty($this->getSetting($key))) {
            return true;
        }

        return false;
    }
}