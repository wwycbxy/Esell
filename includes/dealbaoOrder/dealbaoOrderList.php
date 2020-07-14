
    <div class="wrap">
        <h2><?php _e('Order List','dealbao')?></h2>
        <form method="POST" action="" id="pageKeyword" style="float: left;width: 79%">
            <table class="form-table">
                <tr valign="top">
                    <td style="width: 20%"><input id="keyword" name="keyword" placeholder="<?php _e('Please enter the order number or product name','dealbao')?>" value="<?php echo $keyword; ?>"
                                                  style="height: 40px;width: 250px;padding: 3px;"/></td>

                    <td><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Search','dealbao')?>" ></td>
                    <td></td>
                </tr>

            </table>
            <?php
            //输出一个验证信息
            wp_nonce_field('dealbao_order_list');
            ?>

        </form>
        <div class="tablenav" style="display: inline-block;line-height: 68px;">
            <?php

            if ($data['code'] == 200) {
                $totalPage = ceil($data['total'] / 10);
                $dealbaoPages = new dealbaoPages($paged, $totalPage, '1', $data['total']);
                echo $dealbaoPages->pagesHtml();

            }
            ?>

        </div>
        <table class="widefat striped">
            <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text"
                                                                                for="cb-select-all-1"><?php _e('Check All','dealbao')?></label><input
                        id="cb-select-all-1" type="checkbox"></td>
                <th><?php _e('Order Number','dealbao')?></th>
                <th><?php _e('Product Name','dealbao')?></th>
                <th><?php _e('Waybill Number','dealbao')?></th>
                <th><?php _e('Order Amount(YUAN)','dealbao')?></th>
                <th><?php _e('Order Status','dealbao')?></th>
                <th><?php _e('Customer Name','dealbao')?></th>
                <th><?php _e('Payment Time','dealbao')?></th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($data['data'])){ foreach ($data['data'] as $value) { ?>
                <tr>
                    <th scope="row" class="check-column"><label class="screen-reader-text"
                                                                for="user_1"></label><input type="checkbox"
                                                                                                     name="users[]"
                                                                                                     id="user_1"
                                                                                                     class="administrator"
                                                                                                     value="1"></th>
                    <td><a href="javascript:;" onclick="dealbaoOrderDetail('<?php echo $value['order_sn'] ?>')" ><?php echo $value['order_sn'] ?></a></td>
                    <td>
                        <?php foreach ($value['order_goods_data'] as $goodsValue) { ?>
                            <p><?php echo $goodsValue['goods_name'] ?></p>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if (empty($value['shipping_code'])) {
                            $shippingCodeTest = __('No Number','dealbao');
                        } else {
                            $shippingCodeTest = $value['shipping_code'];
                        }
                        echo $shippingCodeTest;
                        ?>
                    </td>
                    <td>
                        <?php echo $value['order_amount'] ?>
                    </td>
                    <td>
                        <?php echo $value['order_desc'] ?>
                    </td>
                    <td>
                        <?php echo $value['buyer_name'] ?>
                    </td>
                    <td>
                        <?php if(!empty($value['payment_time']))  echo date('Y-m-d
                    h:i:s',$value['payment_time']); ?>
                    </td>
                </tr>
            <?php } ?>


            </tbody>
            <tfoot>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text"
                                                                                for="cb-select-all-1"><?php _e('Check All','dealbao')?></label><input
                            id="cb-select-all-1" type="checkbox"></td>
                <th><?php _e('Order Number','dealbao')?></th>
                <th><?php _e('Product Name','dealbao')?></th>
                <th><?php _e('Waybill Number','dealbao')?></th>
                <th><?php _e('Order Amount(YUAN)','dealbao')?></th>
                <th><?php _e('Order Status','dealbao')?></th>
                <th><?php _e('Customer Name','dealbao')?></th>
                <th><?php _e('Payment Time','dealbao')?></th>
            </tr>
            </tfoot>
            <?php } ?>
        </table>

        <div class="tablenav">
            <?php

            if ($data['code'] == 200) {
                $totalPage = ceil($data['total'] / 10);
                $dealbaoPages = new dealbaoPages($paged, $totalPage, '2', $data['total']);
                echo $dealbaoPages->pagesHtml();

            }
            ?>

        </div>
        <form method="POST" action="" id="orderDetail">

            <?php
            //输出一个验证信息
            wp_nonce_field('dealbao_order_detail');
            ?>

        </form>


    </div>
<script>

    function keyup_submit(e,type){
        var evt = window.event || e;
        if (evt.keyCode == 13){
            dealbaoPages(type);
        }
    }
    function dealbaoPages(page) {

        if(page=='newpage1'){
            var pageed = document.getElementById('current-page-selector1').value;
            var totelPage = <?php echo $totalPage ?>;
            if(pageed>totelPage){
                pageed = totelPage;
            }
        }else if(page=='newpage2'){
            var pageed = document.getElementById('current-page-selector2').value;
            var totelPage = <?php echo $totalPage ?>;
            if(pageed>totelPage){
                pageed = totelPage;
            }
        }else {
            var pageed = page;
        }

        var info = document.getElementById('keyword').value;
        info = info.replace(/&/g, '&amp;');
        info = info.replace(/</g, '&lt;');
        info = info.replace(/>/g, '&gt;');
        info = info.replace(/"/g, '&quot;');
        info = info.replace(/'/g, '&#039;');

        // var form = document.createElement("form");   //定义一个form表单 
        var form = document.getElementById("pageKeyword");   //定义一个form表单 

        form.method = 'post';
        form.target = '_self';
        form.class = 'post';
        form.action = '';
        // document.body.appendChild(form);  //将表单放置在web中  

        var pageFile = document.createElement('input');
        pageFile.type = 'hidden';
        pageFile.name = 'page';
        pageFile.class = 'page';
        pageFile.value = pageed;
        form.appendChild(pageFile);
        // var keywordFile = document.createElement('input');
        // keywordFile.type = 'hidden';
        // keywordFile.name = 'keyword';
        // keywordFile.value = info;
        // form.appendChild(keywordFile);


        document.getElementById("submit").click();  //表单提交  
        document.getElementsByClassName('page').remove();
    }

    function dealbaoOrderDetail(orderSn) {

    var type = 'detail';



        // var form = document.createElement("form");   //定义一个form表单 
        var form = document.getElementById("orderDetail");   //定义一个form表单 

        form.method = 'post';
        form.target = '_self';
        form.class = 'post';
        form.action = '';
        // document.body.appendChild(form);  //将表单放置在web中  

        var typeFile = document.createElement('input');
        typeFile.type = 'hidden';
        typeFile.name = 'type';
        typeFile.class = 'type';
        typeFile.value = type;
        form.appendChild(typeFile);
        var snFile = document.createElement('input');
        snFile.type = 'hidden';
        snFile.name = 'orderSn';
        snFile.class = 'orderSn';
        snFile.value = orderSn;
        form.appendChild(snFile);


        form.submit();  //表单提交  
        document.getElementsByClassName('type').remove();
        document.getElementsByClassName('orderSn').remove();
    }
</script>