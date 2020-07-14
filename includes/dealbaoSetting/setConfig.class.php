<?php
/**
 * 配置处理类
 */
//require 'commonFunc.php';
include 'dealbaoSettingCurl.class.php';

class SetConfig
{

    protected $settingCurl = [];

    public function __construct()
    {
        $this->settingCurl = new dealbaoSettingCurl();
        $this->dealPostData();


    }

    public function dealPostData()
    {
        if (isset($_REQUEST['dealbao_option_name'])) {
            $data = $_REQUEST['dealbao_option_name'];
            $name = 'dealbao_option_name';

            $newdata = $this->settingCurl->dealbaoAccessToken($data);
    ;

                if (empty(get_option($name))) {

                    $res = update_option($name, $newdata);


                    ?>
                    <div id="message" class="updated notice is-dismissible">
                        <p><strong><?php _e('Added Successfully','dealbao') ?>！</strong></p>
                    </div>
                    <?php


                } else {

                    $res = update_option($name, $newdata);
                    ?>
                    <div id="message" class="updated notice is-dismissible">
                        <p><strong><?php _e('Update Successfully','dealbao') ?>！</strong></p>
                    </div>
                    <?php

                }




        }
    }
}

new SetConfig();
//这点是很少的静态数据，直接存储在wordpress的config配置中
