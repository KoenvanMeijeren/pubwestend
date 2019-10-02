<?php


namespace App\services;

use App\models\admin\AdminSettings;

class Settings extends AdminSettings
{
    private static $instance = null;
    private static $settings;

    private function __construct()
    {
        self::$settings = $this->getSettings();
    }

    private static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Settings();
        }

        return self::$instance;
    }

    /**
     * Get a specific setting which is stored in the settings.
     *
     * @param string $key
     * @return bool|mixed|string
     */
    public static function get(string $key)
    {
        self::getInstance();

        if (!empty(self::$settings)) {
            foreach (self::$settings as $settingKey => $setting) {
                if ($key === $setting['settings_name']) {
                    if (isset($setting['settings_value']) && !empty($setting['settings_value'])) {
                        if (is_scalar($setting['settings_value'])) {
                            return sanitize_data($setting['settings_value'], gettype($setting['settings_value']));
                        }

                        return $setting['settings_value'];
                    }
                }
            }
        }

        return '';
    }
}