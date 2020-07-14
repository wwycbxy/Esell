<?php
/**
 * Created by PhpStorm.
 * User: BXY
 * Date: 2020/5/29
 * Time: 15:43
 */
include 'dealbaoGoodsCurl.class.php';
include DEALBAO_PLUGIN_DIR . '/includes/dealbaoPages.php';

class dealbaoGoods
{

    protected $goodsCurl = [];

    public function __construct()
    {

        //判断是否有附属表
        $this->isDealbaoGoods();


        $this->goodsCurl = new dealbaoGoodsCurl();
        if (isset($_POST['type'])) {
            check_admin_referer('dealbao_order_detail');
            $this->dealbaoOrderDetail();
        } else {
            $this->dealbaoGoodsList();
        }

    }

    public function isDealbaoGoods(){
        global $wpdb;
        if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}dealbao_goods'") != "{$wpdb->prefix}dealbao_goods") {
            $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}dealbao_goods`(
              `goods_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品公共表id',
              `spu` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '10位不重复SPU',
              `goods_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称',
              `goods_ad_words` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品广告词',
              `category_id` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品分类',
              `spec_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '规格名称',
              `spec_value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '规格值',
              `goods_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品主图',
              `goods_body` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品内容',
              `mobile_body` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '手机端商品描述',
              `sku_data` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品规格详情',
              `gallery_ids` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品多图片',
              `goods_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '商品价格',
              `goods_marketprice` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '市场价',
              `goods_storage` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品库存',
              `weight` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品重量',
              `goods_storage_alarm` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '库存报警值',
              `goods_upload_type` int(2) UNSIGNED NULL DEFAULT 0 COMMENT '商品上传状态 0是待上传，1是上传成功',
              PRIMARY KEY (`goods_id`) USING BTREE,
              INDEX `category_id`(`category_id`) USING BTREE,
              INDEX `spu`(`spu`) USING BTREE,
              INDEX `goods_stoage`(`goods_storage`) USING BTREE
            )DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
            $wpdb->query($sql);
        }
    }

    public function dealbaoGoodsList()
    {


        $goodsWhere = [];
        $paged = 1;
        $level = '';
        $categoryId = '';
        $keyword = '';

        //搜索条件请求列表
        if (!empty($_POST) && check_admin_referer('dealbao_goods_list')) {

            $goodsWhere['goods_name'] = sanitize_text_field($_POST['keyword']);
            $keyword = sanitize_text_field($_POST['keyword']);
            if (!empty($_POST['page'])) {
                $goodsWhere['page'] = sanitize_text_field($_POST['page']);
                $paged = sanitize_text_field($_POST['page']);
            }

            if (!empty($_POST['level'])) {
                $level = sanitize_text_field($_POST['level']);
                $categoryId = sanitize_text_field($_POST['categoryId']);
                $goodsWhere['level'] = $level;
                $goodsWhere['gc_id'] = sanitize_text_field($_POST['categoryId']);
            }


        }

        $data = $this->goodsCurl->dealbaoGetGoodsList($goodsWhere);

        if ($data['code'] != 200) {
            ?>

            <div id="message" class="error notice is-dismissible"><p><?php echo $data['msg']; ?></p></div>

            <?php

        }

        //获取分类列表
        $caegory = $this->goodsCurl->dealbaoGetGoodsCategory();


        $caegoryData = [];
        if ($caegory['code'] == 200) {
            $caegoryData = $caegory['data'];
        }


        include_once(dirname(__FILE__) . '\dealbaoGoodsList.php');
    }

    public function orderDesc($data)
    {

        foreach ($data as $key => &$value) {


            if ($value['content']['orderState'] == 0) {
                $value['content']['orderStep'] = "1";
                $value['content']['orderDesc'] = "已取消";
            } elseif ($value['content']['orderState'] == 10) {
                $value['content']['orderStep'] = "1";
                $value['content']['orderDesc'] = "待付款";
            } elseif ($value['content']['orderState'] == 20) {
                $value['content']['orderStep'] = "2";
                $value['content']['orderDesc'] = "待发货"; #
                if ($value['content']['refundState'] > 0) {
                    if ($value['content']['wattingSellerState'] == 1) {
                        $value['content']['orderDesc'] = "申请中";
                    } elseif ($value['content']['wattingSellerState'] == 2) {
                        $value['content']['orderDesc'] = "审核中";
                        if ($value['content']['watting_adminState'] == 1) {
                            $value['content']['orderDesc'] = "已取消";
                        } elseif ($value['content']['watting_adminState'] == 2) {
                            $value['content']['orderDesc'] = "待发货";
                        } elseif ($value['content']['watting_adminState'] < 1 && $value['content']['refundDelState'] == 3) {
                            $value['content']['orderDesc'] = "已取消";
                        }
                    } elseif ($value['content']['wattingSellerState'] == 3) {
                        $value['content']['orderDesc'] = "待发货";
                    }
                }
            } elseif ($value['content']['orderState'] == 30) {
                $value['content']['orderStep'] = "3";
                $value['content']['orderDesc'] = "已发货";
                if (!empty($value['content']['shipping_code'])) {
                    $value['content']['orderStep'] = "4";
                    $value['content']['orderDesc'] = "运输中";
                }
            } elseif ($value['content']['orderState'] == 40) {
                $value['content']['orderStep'] = "5";
                $value['content']['orderDesc'] = "已完成";
            }
        }

        return $data;
    }


    public function dealbaoOrderDetail()
    {


        $orderWhere = [];

        //搜索条件请求列表

        $orderWhere['orderSn'] = sanitize_text_field($_POST['orderSn']);


        $data = $this->orderCurl->dealbaoGetOrderDetail($orderWhere);


        if ($data['code'] != 200) {
            ?>

            <div id="message" class="error notice is-dismissible"><p><?php echo $data['msg']; ?></p></div>

            <?php

        } else {
            $data['data'] = $this->orderDescDetail($data['data']);
            $orderdetail = $data['data'];
        }


        include_once(dirname(__FILE__) . '\dealbaoOrderDetail.php');
    }

    public function orderDescDetail($data)
    {

        $data['reciverInfo'] = unserialize($data['reciverInfo']);

        if ($data['orderState'] == 0) {
            $data['orderStep'] = "1";
            $data['orderDesc'] = "已取消";
        } elseif ($data['orderState'] == 10) {
            $data['orderStep'] = "1";
            $data['orderDesc'] = "待付款";
        } elseif ($data['orderState'] == 20) {
            $data['orderStep'] = "2";
            $data['orderDesc'] = "待发货"; #
            if ($data['refundState'] > 0) {
                if ($data['wattingSellerState'] == 1) {
                    $data['orderDesc'] = "申请中";
                } elseif ($data['wattingSellerState'] == 2) {
                    $data['orderDesc'] = "审核中";
                    if ($data['watting_adminState'] == 1) {
                        $data['orderDesc'] = "已取消";
                    } elseif ($data['watting_adminState'] == 2) {
                        $data['orderDesc'] = "待发货";
                    } elseif ($data['watting_adminState'] < 1 && $data['refundDelState'] == 3) {
                        $data['orderDesc'] = "已取消";
                    }
                } elseif ($data['wattingSellerState'] == 3) {
                    $data['orderDesc'] = "待发货";
                }
            }
        } elseif ($data['orderState'] == 30) {
            $data['orderStep'] = "3";
            $data['orderDesc'] = "已发货";
            if (!empty($data['shipping_code'])) {
                $data['orderStep'] = "4";
                $data['orderDesc'] = "运输中";
            }
        } elseif ($data['orderState'] == 40) {
            $data['orderStep'] = "5";
            $data['orderDesc'] = "已完成";
        }


        return $data;
    }



}

new dealbaoGoods();