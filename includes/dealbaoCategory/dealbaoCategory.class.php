<?php
/**
 * Created by PhpStorm.
 * User: BXY
 * Date: 2020/7/6
 * Time: 10:19
 */
include 'dealbaoCategoryCurl.class.php';

class dealbaoCategory
{
    protected $categoryCurl = [];

    public function __construct()
    {

        //判断是否有分类绑定表
        $this->isDealbaoCategory();

        $this->categoryCurl = new dealbaoCategoryCurl();
        if (isset($_POST['categoryId'])) {
            check_admin_referer('dealbao_category_bind');
            $this->dealbaoCategoryBind();
        } else {
            $this->dealbaoCategoryTree();
        }

    }

    public function isDealbaoCategory()
    {
        global $wpdb;
        if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}dealbao_category_bind'") != "{$wpdb->prefix}dealbao_category_bind") {
            $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}dealbao_category_bind`(
              `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类绑定表id',
              `cate_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'woocommerce产品分类id',
              `collect_cate_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'dealbao收藏分类id',
               PRIMARY KEY (`id`) USING BTREE
            )DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
            $wpdb->query($sql);
        }
    }

    public function dealbaoCategoryTree()
    {
        global $wpdb;
        //获取dealbao收藏分类列表
        $dealbaoCollect = $this->categoryCurl->dealbaoGetCollectCategory();
        $caegoryCollectData = [];
        if ($dealbaoCollect['code'] == 200) {
            $caegoryCollectData = $dealbaoCollect['data'];
        }
        //获取woocommerce产品分类
        $category = $this->dealbao_get_goods_category();

        //获取绑定信息
        $cate_sql = "SELECT * FROM `{$wpdb->prefix}dealbao_category_bind` ";
        $cate_bind = $wpdb->get_results( $cate_sql, ARRAY_A );

        include_once(dirname(__FILE__) . '\dealbaoCategoryBind.php');
    }

    //分类绑定
    public function dealbaoCategoryBind(){
        global $wpdb;

        $wpdb->delete( "{$wpdb->prefix}dealbao_category_bind", array( 'cate_id' => sanitize_text_field($_POST['categoryId']) ));

        $collect_id = explode(",", rtrim(sanitize_text_field($_POST['collectId']), ","));

        foreach ($collect_id as $key => $value){
            $sql = "REPLACE INTO `{$wpdb->prefix}dealbao_category_bind` VALUES ('', '".sanitize_text_field($_POST['categoryId'])."', '".$value."');";
            $wpdb->query($sql);
        }

        ?>
        <div id="message" class="updated notice is-dismissible">
            <p><strong><?php _e('Binding Success','dealbao') ?>！</strong></p>
        </div>
        <?php

        $this->dealbaoCategoryTree();

    }
    //获取分类产品
    public function dealbao_get_goods_category(){
        $args = array('hide_empty'=> 0);
        $terms =  json_encode(get_terms(
            'product_cat',$args
        ));
        $Allterms =   $this->getNoneKeyCategoryList(json_decode($terms,true),0, 'parent', 'term_id');

        return $Allterms;


    }
    //获取分类树
    public function getNoneKeyCategoryList($data, $pid, $key, $id_key)
    {
        $arr = [];
        foreach ($data as $list_key => $value) {
            if ($value[$key] == $pid) {
                unset($data[$list_key]);
                $res = $this->getNoneKeyCategoryList($data, $value[$id_key], $key, $id_key);
                !empty($res) && $value['children'] = $res;
                $arr[] = $value;
            }
        }
        return $arr;
    }
}

new dealbaoCategory();