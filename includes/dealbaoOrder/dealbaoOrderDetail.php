
<?php
wp_enqueue_style('orderdetail',DEALBAO_DIR_URL.'css/orderdetail.css');
wp_enqueue_style('detail_extend',DEALBAO_DIR_URL.'css/detail_extend.css');
?>
<style>
    .feiwast-order-condition li {
        display: block;
        margin-bottom: 10px;
    }

    .shipped-order-goods-item-logistics:hover {
        color: #29f;
    }
</style>

<div class="wrap">
    <!-- 订单步骤 -->
    <div class="wp-heading-inline" style="height: 56px;font-size: 13px;background: #fff;line-height: 56px;">

        <a href="" style="padding: 5px;color: #c9356e;margin-left: 10px;">订单列表</a>/ 订单详情</div>



    <hr class="wp-header-end">
    <div class="process wb-flow">
        <ul>
            <li class="wb-flow-item">
                <div class="wb-flow-first">
                    <img src="//neworder.shop.jd.com/static/img/1.png">
                </div>
                <p class="mtb10 text-blue">1.提交订单</p>
                <p class="processlip"><?php echo date('Y-m-d h:i:s', $orderdetail['createTime'])?></p>
            </li>
            <li class="wb-flow-item   <?php if($orderdetail['orderStep']==5){ ?> highlight   <?php } ?>">
                <div class="wb-flow-first">
                    <?php if($orderdetail['orderStep']>=2){ ?>

                    <img src="//neworder.shop.jd.com/static/img/2.png">
                    <?php }else{  ?>

                    <img src="//neworder.shop.jd.com/static/img/2-g.png">
                    <?php } ?>

                </div>
                <p class="mtb10  <?php if($orderdetail['orderStep']>=2){ ?> text-blue   <?php }else{ ?> processlip <?php } ?> ">2.付款成功</p>
                <p class="processlip">
                    <?php if(!empty($orderdetail['paymentTime'])){
              echo   date('Y-m-d
                    h:i:s',$orderdetail['paymentTime']);
                 } ?>
                </p>
            </li>
            <li class="wb-flow-item   <?php if($orderdetail['orderStep']==5){ ?> highlight   <?php } ?>">
                <div class="wb-flow-first">
                    <?php if($orderdetail['orderStep']>=3){ ?>

                        <img src="//neworder.shop.jd.com/static/img/3.png">
                    <?php }else{  ?>

                        <img src="//neworder.shop.jd.com/static/img/3-g.png">
                    <?php } ?>

                </div>
                <p class="mtb10   <?php if($orderdetail['orderStep']>=3){ ?> text-blue   <?php }else{ ?> processlip <?php } ?>">3.正在出库</p>
                <p class="processlip"></p>
            </li>
            <li class="wb-flow-item  <?php if($orderdetail['orderStep']==5){ ?> highlight   <?php } ?>">
                <div class="wb-flow-first">

                    <?php if($orderdetail['orderStep']>=4){ ?>

                        <img src="//neworder.shop.jd.com/static/img/4.png">
                    <?php }else{  ?>

                          <img src="//neworder.shop.jd.com/static/img/4-g.png">
                    <?php } ?>

                </div>
                <p class="mtb10  <?php if($orderdetail['orderStep']>=4){ ?> text-blue   <?php }else{ ?> processlip <?php } ?> ">4.等待收货</p>
                <p class="processlip"></p>
            </li>
            <li class="wb-flow-item  <?php if($orderdetail['orderStep']==5){ ?> highlight   <?php } ?>">
                <div class="wb-flow-first">

                    <?php if($orderdetail['orderStep']==5){ ?>

                        <img src="//neworder.shop.jd.com/static/img/5.png">
                    <?php }else{  ?>

                        <img src="//neworder.shop.jd.com/static/img/5-g.png">
                    <?php } ?>
                </div>
                <p class="mtb10  <?php if($orderdetail['orderStep']>=5){ ?> text-blue   <?php }else{ ?> processlip <?php } ?>">5.完成</p>
                <p class="processlip"></p>
            </li>
        </ul>
    </div>
    <!-- 订单简要 -->
    <div class="state-main" style="min-height: 20px;">
        <p class="state-dis state-orderid-left">
            <span class="state-fs14">订单号:</span> <span class="state-fs18"><?php echo  $orderdetail['orderSn']?></span> <span
                    class="state-fs14 ml20">支付单号:</span> <span class="state-fs18"><?php echo  $orderdetail['paySn']?></span>
            <!-- <img onclick="copyOrderId();" src="//neworder.shop.jd.com/static/img/copyreceive.png" style="margin-left:2px;cursor:pointer;" title="复制" /> -->
            <span class="state-fs14 ml20">订单状态:</span> <span
                    class="wb-green state-fs18"><?php echo  $orderdetail['orderDesc']?></span>
        </p>
        <div class="public-p public-indent state-dis state-operation">
            <!-- <span class="state-fs14 ml20">操作:</span>
            <p class="state-orderid-p"> <a href="//neworder.shop.jd.com/coupon/couponDetail?orderId=99336976207" class="wb-btn-s wb-btn-gray-bd" style="color:#c11;border-color:#c11;" target="_blank">查看订单优惠明细</a> <button id="tjbz" class="wb-btn-s wb-btn-gray-bd" style="display: inline-block;">增加备注</button> <button id="xgbz" class="wb-btn-s wb-btn-gray-bd" style="display:  none;">修改备注</button> </p>  -->
        </div>
        <!--<p class="public-p state-contant">-->
        <!--<span class="public-ftb">商家备注：</span><span id="remark"></span>-->
        <!--<input id="level" type="hidden" name="level" value="1"/></p>-->
    </div>
    <!-- 订单详细 -->
    <div class="order-information">
        <table style="width:100%" id="all-table">
            <tbody>
            <tr>
                <td class="ordinf-td ordinf-td-w" style="width:25% !important;">
                    <p class="orinf-tit">收货人信息 <img id="copyReceive" onclick="copyReceiveData();"
                                                    src="//neworder.shop.jd.com/static/img/copyreceive.png"
                                                    style="margin-left:4px;cursor:pointer; display: none;vertical-align:bottom;"
                                                    title="复制"/></p>
                    <table id="receiveData">
                        <colgroup>
                            <col style=""/>
                            <col style=""/>
                            <col style=""/>
                        </colgroup>
                        <tbody>
                        <!--  <tr>
                             <td class="pubwhite">联系买家:</td>
                             <td colspan="2"> <p id="pin-99336976207" name="dongdongICON">ilovedew <a id="a-99336976207" style="cursor:pointer"><img style="display:inline-block;vertical-align:middle;margin-left:5px;" src="//img10.360buyimg.com/imgzone/jfs/t550/258/1508250935/1456/6eeb7ef4/54cadc67N774b964b.png" /></a></p><a id="a-99336976207" style="cursor:pointer"> </a></td>
                         </tr>  -->
                        <tr class="copyable">
                            <td class="pubwhite">收货人:</td>
                            <td colspan="2"><?php echo  $orderdetail['reciverInfo']['true_name']?></td>
                        </tr>
                        <tr class="copyable">
                            <td class="pubwhite">地址:</td>
                            <td colspan="2"><?php echo  $orderdetail['reciverInfo']['area_info'].$orderdetail['reciverInfo']['address']?>
                            </td>
                        </tr>
                        <tr class="copyable">
                            <td class="pubwhite">固定电话:</td>
                            <td id="tel"><?php if(empty($orderdetail['reciverInfo']['tel_phone'])){
                                    echo $orderdetail['reciverInfo']['mob_phone'];
                                }else{
                                    echo $orderdetail['reciverInfo']['tel_phone'];
                                }  ?>
                            </td>
                        </tr>
                        <tr class="copyable">
                            <td class="pubwhite">手机号:</td>
                            <td><span id="mobile"><?php if(empty($orderdetail['reciverInfo']['mob_phone'])){
                                        echo $orderdetail['reciverInfo']['tel_phone'];
                                    }else{
                                        echo $orderdetail['reciverInfo']['mob_phone'];
                                    }  ?></span>
                            </td>
                        </tr>
                        <tr style="display: none">
                            <td class="pubwhite"></td>
                            <td id="carModels" colspan="2"></td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="public-p state-contant"><span class="public-ftb">买家留言：</span><?php echo  $orderdetail['orderMessage']?>
                    </p>
                </td>
                <td class="ordinf-td ordinf-td-w" style="width:25% !important;"><p class="orinf-tit">配送信息</p>
                    <table>
                        <tbody>
                        <tr>
                            <td class="pubwhite">送货方式:</td>
                            <td colspan="2">普通快递</td>
                        </tr>
                        <tr>
                            <td class="pubwhite">运费:</td>
                            <td colspan="2">￥<?php echo  $orderdetail['shippingFee']?></td>
                        </tr>
                        <tr>
                            <td class="pubwhite">配送日期:</td>
                            <td colspan="2">任意时间</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td class="ordinf-td ordinf-td-w" style="width:25% !important;"><p class="orinf-tit">付款信息</p>
                    <table>
                        <tbody>
                        <tr>
                            <td class="pubwhite">付款方式:</td>
                            <td>在线支付</td>
                        </tr>
                        <tr>
                            <td class="pubwhite">付款时间:</td>
                            <td>  <?php if(!empty($orderdetail['paymentTime'])){
                                    echo   date('Y-m-d
                    h:i:s',$orderdetail['paymentTime']);
                                } ?></td>
                        </tr>
                        <tr>
                            <td class="pubwhite">商品总额:</td>
                            <td>￥<?php echo  $orderdetail['goodsAmount']?></td>
                        </tr>
                        <tr>
                            <td class="pubwhite">运费金额:</td>
                            <td>￥<?php echo  $orderdetail['shippingFee']?></td>
                        </tr>
                        <tr>
                            <td class="pubwhite">应支付金额:</td>
                            <td> ￥<?php echo  $orderdetail['orderAmount']?></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td class="ordinf-td ordinf-td-w" style="width:25% !important;"><p class="orinf-tit">发票信息</p>
                    <table>
                        <colgroup>
                            <col style=""/>
                            <col style=""/>
                            <col style=""/>
                        </colgroup>
                        <tbody>
                        <tr>
                            <td class="pubwhite">发票类型:</td>
                            <td>电子发票</td>
                        </tr>
                        <tr>
                            <td class="pubwhite">发票抬头:</td>
                            <td>个人</td>
                        </tr>
                        <tr>
                            <td class="pubwhite">纳税人识别号:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="pubwhite">发票内容:</td>
                            <td> 商品明细</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- 订单商品 -->

    <div class="mtb20" id="express" style="display: none ;width: 100%;height: 87%;">
        <div style="width: 90%;height: 90%;border: 1px solid #AAAAAA;margin: 0 auto;overflow: hidden ">
            <div class="order-deliver"
                 style="text-align: center; margin-bottom: 10px;/*margin-left: 40px;*/font-size: 18px;margin-top: 10px;height: 10%">
                    <span>物流公司： <a target="_blank" href="http://www.sto.cn"
                                   style="color: #0279B9;position: relative;z-index: 1;">申通快递                                    </a>
                    </span>
                <span style=" margin-left: 10px;" class="express-num">物流单号：3715494507408</span>
            </div>
            <ul id="shipping_ul" style="overflow-x: auto;height: 82%; font-size: 14px; margin: 10px">

            </ul>
        </div>
    </div>

    <div class="mtb20">
        <table class="wb-table-b wb-table" width="100%">
            <thead>
            <tr>
                <th class="t-c" style="text-align: left;padding-left: 20px;">商品编号</th>
                <th class="t-c" style="text-align: left" width="53%">商品名称</th>
                <th class="t-c" style="text-align: left">商品价格</th>
                <th class="t-c" style="text-align: left">商品数量</th>
                <!--<th class="t-c">操作</th>-->
            </tr>
            </thead>
            <tbody>
            {volist name="orderdetail.goods_info" id="goods_info"}
            {egt name="orderdetail['order_state']" value="30"}
            <tr style="background-color: #f5f7ff">
                {if condition="$goods_info['shipping_title_num']==1"}
                <td class="shipped-order-goods-item-title" style="padding: 10px;" colspan="5">
                    <div class="shipped-order-goods-item-review" style="display: inline-block;margin-left: 10px;">
                        包裹{$goods_info.order_num}
                    </div>
                    <!--<div>运单号：4698562131154216516613</div>-->
                    <div class="shipped-order-goods-item-logistics"
                         style="display: inline-block;margin-left: 20px;cursor: pointer" id="info{$key}"
                         data-name="{$goods_info['express']['e_name']|default=''}"
                         data-code="{$goods_info['express']['shipping_code']|default=''}"
                         data-yggc="{$goods_info.yggc_sku|default=''}"
                         data-outer="{$orderdetail['outer_source']|default=''}" onclick="express('info{$key}')">查看物流
                    </div>
                </td>
                {elseif condition="$goods_info['shipping_title_num']==3" }
                <td class="shipped-order-goods-item-title" style="padding: 10px;" colspan="5">
                    <div class="shipped-order-goods-item-review" style="display: inline-block;margin-left: 10px;">
                        包裹{$goods_info.order_num}
                    </div>
                    <!--<div>运单号：4698562131154216516613</div>-->
                    <div class="shipped-order-goods-item-logistics"
                         style="display: inline-block;margin-left: 20px;cursor: pointer" id="info{$key}"
                         data-name="{$goods_info['express']['e_name']|default=''}"
                         data-code="{$goods_info['express']['shipping_code']|default=''}"
                         data-yggc="{$goods_info.yggc_sku|default=''}"
                         data-outer="{$orderdetail['outer_source']|default=''}" onclick="express('info{$key}')">查看物流
                    </div>
                </td>
                {/if}
            </tr>
            {/egt}
            <tr>
                <td class="t-c" style="text-align: left;"><span
                            style="margin-left: 10px;">{$goods_info.goods_sku}</span></td>
                <td class="t-l"><a class="t-l" target="_blank" href=""> {$goods_info.goods_name}</a>
                    <!-- <a id="43351598984" href="//neworder.shop.jd.com/order/wareSnapshot?orderId=99336976207&amp;skuId=43351598984" class="wb-blue wareSnapshot" target="_blank"> <font style="color:#0000FF">[商品快照]</font> </a> -->
                </td>
                <td class="t-c" style="text-align: left">￥{$goods_info.goods_price}</td>
                <td class="t-c" style="text-align: left">{$goods_info.goods_num}</td>
                <!--<td class="t-c v-t" onclick="express()">查看物流</td>-->
            </tr>
            {/volist}
            </tbody>
        </table>
    </div>
    <!-- 订单金额 -->
    <!-- <div class="public-p state-contant">
       <div class="order-amount">
        <p>商品总额:￥45.00</p>
        <p>+运费:￥0.00</p>
        <p>-促销优惠:￥4.50</p>
        <p>-优惠券:￥0.00</p>
        <hr style="width: 12%;display: inline-block;" />
        <p class="oderamo-col"> <span class="oderamo-foncol">应付总额:</span>￥40.50 </p>
       </div>
      </div> -->

</div>
<script>
    function express(id) {


        if ($('#' + id).data('code') != '') {
            if ($('#' + id).data('outer') == '') {


                var expressName = $('#' + id).data('name');
                var expressCode = $('#' + id).data('code');
                var expressSku = $('#' + id).data('yggc');
                var expressOuter = $('#' + id).data('outer');
                var text = '物流单号: ' + expressCode;

                $('.order-deliver span a').text(expressName);
                $('.express-num').text(text);
                var params = {
                    'name': expressName,
                    'code': expressCode,
                    'sku': expressSku,
                    'outer': expressOuter,
                }

                $.ajax({
                    url: 'getExpress',
                    data: params,
                    success: function (res) {
                        if (res['code'] == 0) {
                            var html = '';
                            $('#shipping_ul').empty();
                            if (res.OrderTrack_two != []) {
                                $.each(res.OrderTrack_two, function (i, item) {

                                    if (i == 0) {
                                        html += ` <li>${item.AcceptTime}&nbsp;&nbsp;${item.AcceptStation}</li>`;
                                    } else {
                                        html += `
 <li>${item.AcceptTime}&nbsp;&nbsp;${item.AcceptStation}</li>
`;
                                    }

                                });
                            }
                            if (res.OrderTrack != []) {
                                $.each(res.OrderTrack, function (i, item) {

                                    if (i == 0) {
                                        html += ` <li>${item.oprate_time}&nbsp;&nbsp;${item.content}</li>`;
                                    } else {
                                        html += ` <li>${item.oprate_time}&nbsp;&nbsp;${item.content}</li>`;

                                    }

                                });
                            }


                            $('#shipping_ul').append(html);


                        } else {
                            layer.msg('查询失败', {time: 2000});
                        }
                    }
                })
            } else {


                var text = '物流单号:暂无信息';


                $('.order-deliver span a').text('暂无信息');
                $('.express-num').text(text);
            }
        } else {
            var text = '物流单号:暂无信息';
            $('.order-deliver span a').text('暂无信息');
            $('.express-num').text(text);
        }

        layer.open({
            shadeClose: true,
            area: ['50%', '60%'],
            type: 1,

            shade: 0.5,
            title: '物流信息', //不显示标题
            content: $('#express'), //捕获的元素
            cancel: function (index) {
                layer.close(index);
                $('#shipping_ul').empty();

            }

        });
    }

</script>
