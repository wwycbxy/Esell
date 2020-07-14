<?php
/**
 * Created by PhpStorm.
 * User: BXY
 * Date: 2020/5/29
 * Time: 15:43
 */
include 'dealbaoOrderCurl.class.php';
include DEALBAO_PLUGIN_DIR.'/includes/dealbaoPages.php';
class dealbaoOrder
{

    protected $orderCurl = [];
    public function __construct()
    {
        $this->orderCurl = new dealbaoOrderCurl();
        if( isset( $_POST['type'] )){
            check_admin_referer( 'dealbao_order_detail' );
            $this->dealbaoOrderDetail();
        }else{
            $this->dealbaoOrderList();
        }


    }

    public function dealbaoOrderList()
    {


        $orderWhere = [];
        $paged = 1;
        $keyword = '';
        //搜索条件请求列表
        if( !empty( $_POST ) && check_admin_referer( 'dealbao_order_list' ) ) {
            if(strlen($_POST['keyword'])==15){
                $orderWhere['order_sn'] =sanitize_text_field($_POST['keyword']);
            }else{
                $orderWhere['goods_name'] = sanitize_text_field($_POST['keyword']);
            }
            $keyword = sanitize_text_field($_POST['keyword']);
            if(!empty($_POST['page'])){
                $orderWhere['page'] = sanitize_text_field($_POST['page']);
                $paged = sanitize_text_field( $_POST['page']);
            }
        }

            $data =  $this->orderCurl->dealbaoGetOrderList($orderWhere);


        if ($data['code'] != 200) {
            ?>

            <div id="message" class="error notice is-dismissible"><p><?php echo $data['msg']; ?></p></div>

            <?php

        }else{
            $data['data'] = $this->orderDesc($data['data']);
        }


        include_once(dirname(__FILE__) . '\dealbaoOrderList.php');
    }

    public function orderDesc($data){

        foreach ($data as $key => &$value) {


            if ($value['order_state'] == 0) {
                $value['order_step'] = "1";
                $value['order_desc'] = __('Canceled','dealbao');//已取消
            } elseif ($value['order_state'] == 10) {
                $value['order_step'] = "1";
                $value['order_desc'] = __('Obligations','dealbao');//待付款
            } elseif ($value['order_state'] == 20) {
                $value['order_step'] = "2";
                $value['order_desc'] = __('To Be Delivered','dealbao');//待发货
                if ($value['refund_state'] > 0) {
                    if ($value['watting_seller_state'] == 1) {
                        $value['order_desc'] =  __('Applying','dealbao');//申请中
                    } elseif ($value['watting_seller_state'] == 2) {
                        $value['order_desc'] = __('Under Review','dealbao');//审核中
                        if ($value['watting_admin_state'] == 1) {
                            $value['order_desc'] =__('Canceled','dealbao');//已取消
                        } elseif ($value['watting_admin_state'] == 2) {
                            $value['order_desc'] = __('To Be Delivered','dealbao');//待发货
                        } elseif ($value['watting_admin_state'] < 1 && $value['refund_del_state'] == 3) {
                            $value['order_desc'] = __('Canceled','dealbao');//已取消
                        }
                    } elseif ($value['watting_seller_state'] == 3) {
                        $value['order_desc'] = __('To Be Delivered','dealbao');//待发货
                    }
                }
            } elseif ($value['order_state'] == 30) {
                $value['order_step'] = "3";
                $value['order_desc'] = __('Shipped','dealbao');//已发货
                if (!empty($value['shipping_code'])) {
                    $value['order_step'] = "4";
                    $value['order_desc'] = __('In Transit','dealbao');//运输中
                }
            } elseif ($value['order_state'] == 40) {
                $value['order_step'] = "5";
                $value['order_desc'] = __('Completed','dealbao');//已完成
            }
        }

        return $data;
    }


    public function dealbaoOrderDetail()
    {


        $orderWhere = [];

        //搜索条件请求列表

        $orderWhere['orderSn'] = sanitize_text_field($_POST['orderSn']);




        $data =  $this->orderCurl->dealbaoGetOrderDetail($orderWhere);



        if ($data['code'] != 200) {
            ?>

            <div id="message" class="error notice is-dismissible"><p><?php echo $data['msg']; ?></p></div>

            <?php

        }else{
            $data['data'] = $this->orderDescDetail($data['data']);
            $orderdetail =  $data['data'];
        }


        include_once(dirname(__FILE__) . '\dealbaoOrderDetail.php');
    }

    public function orderDescDetail($data){

        $data['reciverInfo'] = unserialize($data['reciverInfo']);

            if ($data['orderState'] == 0) {
                $data['orderStep'] = "1";
                $data['orderDesc'] = __('Canceled','dealbao');//已取消
            } elseif ($data['orderState'] == 10) {
                $data['orderStep'] = "1";
                $data['orderDesc'] = __('Obligations','dealbao');//待付款
            } elseif ($data['orderState'] == 20) {
                $data['orderStep'] = "2";
                $data['orderDesc'] = __('To Be Delivered','dealbao');//待发货
                if ($data['refundState'] > 0) {
                    if ($data['wattingSellerState'] == 1) {
                        $data['orderDesc'] = __('Applying','dealbao');//申请中
                    } elseif ($data['wattingSellerState'] == 2) {
                        $data['orderDesc'] =__('Under Review','dealbao');//审核中
                        if ($data['watting_adminState'] == 1) {
                            $data['orderDesc'] = __('Canceled','dealbao');//已取消
                        } elseif ($data['watting_adminState'] == 2) {
                            $data['orderDesc'] = __('To Be Delivered','dealbao');//待发货
                        } elseif ($data['watting_adminState'] < 1 && $data['refundDelState'] == 3) {
                            $data['orderDesc'] = __('Canceled','dealbao');//已取消
                        }
                    } elseif ($data['wattingSellerState'] == 3) {
                        $data['orderDesc'] = __('To Be Delivered','dealbao');//待发货
                    }
                }
            } elseif ($data['orderState'] == 30) {
                $data['orderStep'] = "3";
                $data['orderDesc'] = __('Shipped','dealbao');//已发货
                if (!empty($data['shipping_code'])) {
                    $data['orderStep'] = "4";
                    $data['orderDesc'] = __('In Transit','dealbao');//运输中
                }
            } elseif ($data['orderState'] == 40) {
                $data['orderStep'] = "5";
                $data['orderDesc'] = __('Completed','dealbao');//已完成
            }


        return $data;
    }
}

new dealbaoOrder();