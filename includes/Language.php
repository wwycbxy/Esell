<?php
/**
 * Created by PhpStorm.
 * User: BXY
 * Date: 2020/5/28
 * Time: 14:54
 */

class Language
{
    function getLanguageId()
    {

        if (!current_user_can('manage_options'))
            wp_die(__('You do not have the sufficient permissions to access this page.'));
        $dealbao_options = substr(get_option('WPLANG'), 0,2);
        switch ($dealbao_options) {
            case 'zh':
                $id = 2;
                break;
            case 'ja':
                $id = 3 ;
                break;
            case 'es':
                $id = 4;
                break;
            case 'fr':
                $id = 5;
                break;
            case 'de':
                $id = 6;
                break;
            case 'ru':
                $id = 7;
                break;
            case 'pt':
                $id = 8;
                break;
            default:
                $id = 1;
                break;
        }
        return $id ;


    }
}