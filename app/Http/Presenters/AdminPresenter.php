<?php


namespace App\Http\Presenters;

use Psy\VarDumper\Presenter;

class AdminPresenter extends Presenter
{
    /**
     * Gets the menu items indexed by their name with a value of the title.
     *
     * @param array $subMenu (used for recursion)
     *
     * @return array
     */
    public static function getMenu($subMenu = null)
    {
        $menu = array();

        if (!$subMenu) {
            $subMenu = config('administrator.menu');
        }

        //iterate over the menu to build the return array of valid menu items
        foreach ($subMenu as $key => $item) {
            //if the item is a string, find its config
            if (is_string($item)) {
                //fetch the appropriate config file
                $config = require rtrim(config('administrator.model_config_path'), '/').'/'.$item.'.php';

                //if a config object was returned and if the permission passes, add the item to the menu
                $menu[$item] = $config['title'];
            }
            //if the item is an array, recursively run this method on it
            elseif (is_array($item)) {
                $menu[$key] = self::getMenu($item);

                //if the submenu is empty, unset it
                if (empty($menu[$key])) {
                    unset($menu[$key]);
                }
            }
        }

        return $menu;
    }
}
