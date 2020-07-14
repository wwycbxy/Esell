<style>
    .leftRightBottom{
       border-left: 1px solid #e6e6e6;border-top:  1px solid #e6e6e6;border-bottom: 1px solid #e6e6e6;
    }
    .widefat td{
        padding: 2px;
    }

    .widthHeight{
         height: 50px!important;
    }
    ul.ztree {
        min-height: 660px;
    }
    .ztree li span.button.add {
        margin-left: 2px;
        margin-right: -1px;
        background-position: -144px 0;
        vertical-align: top;
        *vertical-align: middle
    }
   .zTreeDemoBackground .button{
       min-height: 16px;
       padding: 0;
   }
    .ztree li span.button:hover{
        line-height: 0;
        margin: 0;
        width: 16px;
        height: 16px;
        display: inline-block;
        vertical-align: middle;
        border: 0 none;
        cursor: pointer;
        outline: none;
        background-color: transparent;
        background-repeat: no-repeat;
        background-attachment: scroll;
        background-image: url('<?php echo DEALBAO_DIR_URL?>lib/zTree/css/zTreeStyle/img/zTreeStandard.png');
        *background-image: url('<?php echo DEALBAO_DIR_URL?>lib/zTree/css/zTreeStyle/img/zTreeStandard.gif');
    }
    .children{
        margin-left: 18px;
    }




</style>

<script>
    var Please_check_exported_goods = '<?php _e('Please check exported product','dealbao'); ?>';
    var Please_check_exported_category = '<?php _e('Please check exported category','dealbao'); ?>';
    var Please_do_not_jump_goods = '<?php _e('Please do not jump while exporting product. Keep this page to prevent export failure!','dealbao'); ?>'
    var Export_Success = '<?php _e('Export Success!','dealbao'); ?>';
</script>


<?php
wp_enqueue_style('zTreeStyle',DEALBAO_DIR_URL.'lib/zTree/css/zTreeStyle/zTreeStyle.css');
wp_enqueue_style('demo',DEALBAO_DIR_URL.'css/demo.css');
wp_enqueue_style('style',DEALBAO_DIR_URL.'css/style.css');
wp_enqueue_script( 'dealbao_add_goods',DEALBAO_DIR_URL.'js/dealbao_add_goods.js', array('jquery'));
wp_localize_script( 'dealbao_add_goods', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
wp_enqueue_script('ztree', DEALBAO_DIR_URL . 'lib/zTree/js/jquery.ztree.all.js', array('jquery'));
add_thickbox();
?>


    <div class="wrap" >

        <h2><?php _e('Product List','dealbao') ?></h2>
        <div class="zTreeDemoBackground left col-md-4" style="width: 12.5%;float: left">
            <ul id="category" class="ztree"></ul>
        </div>
        <div style="width: 82%;margin-left: 50px;float: left">
        <form method="POST" action="" id="pageKeyword" style="float: left;width: 37%">

            <table class="form-table">
                <tr valign="top">
                    <td style="width: 20%"><input id="keyword" name="keyword" placeholder="<?php _e('Please enter the name of the product','dealbao') ?>" value="<?php echo $keyword; ?>"
                                                  style="height: 40px;width: 250px;padding: 3px;"/></td>

                    <td>
                        <input type="hidden" id="cateId" name="categoryId" value="<?php echo $categoryId ?>">
                        <input type="hidden" id="level" name="level" value="<?php echo $level ?>">
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Search','dealbao') ?>">
                        <div class="button action" id="goodsExport" > <?php _e('Derived','dealbao') ?></div>
                        <a class="thickbox a-GoodsExport" style="display: none" title="<?php _e('Derived classification selection','dealbao') ?>" href="#TB_inline?height=600&width=600&inlineId=dealbao_product"></a>
                        <div id="dealbao_product" style="display:none;">
                            <div>
                                <div style="font-size: 18px;margin-top: 10px;margin-bottom: 10px;font-weight: 500;color: #23282d;">
                                    <?php _e('Select WooCommerce Product Category','dealbao') ?>
                                </div>
                            <ul id="dealbao_product_catchecklist" style="  min-height: 300px;width: 240px;padding: 10px;border: 1px solid #e6e6e6;float: left;" data-wp-lists="list:product_cat" class="categorychecklist form-no-clear">

                            </ul>
                                <input type="hidden" name="goods_spu" class="goods_spu" value="">
                                <div class="button action" id="goodsSpuExport" style="float: left;margin: 20px;" >   <?php _e('Confirm','dealbao') ?></div>
                            </div>
                        </div>
                    </td>
                    <td> </td>
                </tr>

            </table>
            <?php
            //输出一个验证信息
            wp_nonce_field('dealbao_goods_list');
            ?>

        </form>
            <div  style="    width: 30%;display: inline-block;float: left;margin-top: 30px;">
            <section class="container" style="display: none;">
<!--                <input type="radio" class="radio" name="progress" value="five" id="five">-->
<!--                <label for="five" class="label">50%</label>-->

                <div class="progress" style="float: left">
                    <div class="progress-bar"></div>
                </div>
                <label for="five" class="label percentage" style="float: left">0%</label>
            </section>
            </div>
            <div class="tablenav" style="display: inline-block;line-height: 68px;width: 33%;">
                <?php

                if ($data['code'] == 200) {
                    $totalPage = ceil($data['total'] / 10);
                    $dealbaoPages = new dealbaoPages($paged, $totalPage, '1', $data['total']);
                    echo $dealbaoPages->pagesHtml();

                }
                ?>

            </div>

        <table class="widefat striped"  >
            <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text"
                                                                                for="cb-select-all-1"><?php _e('Check All','dealbao') ?></label><input
                        id="cb-select-all-1" type="checkbox"></td>
                <th><?php _e('Picture','dealbao') ?></th>
                <th><?php _e('Product Info','dealbao') ?></th>
                <th><?php _e('State','dealbao') ?></th>
                <th><?php _e('Product Affiliation','dealbao') ?></th>
                <th><?php _e('Action','dealbao') ?></th>

            </tr>
            </thead>
            <tbody>
            <?php if(isset($data['data'])){ foreach ($data['data'] as $value) { ?>
                <tr>
                    <th scope="$value" class="check-column"><label class="screen-reader-text"
                                                                for="goods_<?php echo $value['spu']; ?>"></label><input type="checkbox"
                                                                                                     name="goods_spu[]"
                                                                                                     id="goods_<?php echo $value['spu']; ?>"
                                                                                                     class="goodsSpu"
                                                                                                     value="<?php echo $value['spu']; ?>"></th>
                    <td class="widthHeight" style="width: 50px!important;">
                        <div style="position: relative;padding-top: 4px;"><img  src='<?php echo $value['goods_image'] ?>'   width="50"  height="50" class="img-rounded" >
                    </td>
                    <td class="widthHeight" style="width: 600px!important;">
                        <table class="table table-bordered" style="height: 50px;width: 596px;margin: 2px;">

                            <tbody>
                            <tr>
                                <td colspan="4" align="left" style="border-left: 1px solid #e6e6e6;border-top:  1px solid #e6e6e6;"><a  href="javascrpt:void(0);" title="<?php echo $value['goods_name'] ;?>" style="width: 462px;display: inline-block;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" ><?php echo $value['goods_name']; ?></a> </td>
                                <td width="25px" align="center"  style="border-left: 1px solid #e6e6e6;border-top:  1px solid #e6e6e6;min-width: 0">spu</td>
                                <td  style="border-left: 1px solid #e6e6e6;border-top:  1px solid #e6e6e6;border-right:  1px solid #e6e6e6;"><?php echo $value['spu']; ?></td>
                            </tr>
                            <tr>
                                <td class="leftRightBottom" ><?php _e('Market Price','dealbao') ?>:<?php  echo $value['goods_marketprice'] ;?></td>
                                <td class="leftRightBottom" ><?php _e('Mall Price','dealbao') ?>:<?php echo $value['goods_price'] ;?></td>
                                <td class="leftRightBottom" ><?php _e('Stock','dealbao') ?>:<?php echo $value['goods_storage'] ;?></td>
                                <td class="leftRightBottom" width="100px;" ><?php _e('Hits','dealbao') ?>:<?php echo $value['goods_click'] ;?></td>
                                <td class="leftRightBottom" width="80px;" colspan="2" style="border-right: 1px solid #e6e6e6;b"><?php _e('Sales','dealbao') ?>:<?php echo $value['goods_salenum']; ?></td>

                            </tr>

                            </tbody>
                        </table>
                    </td>
                    <td  class="widthHeight"  style="width: 80px!important;text-align: center;line-height: 60px;border-left:  1px solid #e6e6e6;border-right:  1px solid #e6e6e6;">
                        <?php
                        if ($value['goods_verify'] == 0) {
                            echo __('Not approved','dealbao');
                        } else if ($value['goods_verify'] == 10) {
                            echo __('To Audit','dealbao');
                        } else {
                            if ($value['goods_state'] == 1) {
                                echo __('On Sale','dealbao');
                            } else if ($value['goods_state']  == 0) {
                                echo __('For Sale','dealbao');
                            }else if ($value['goods_state']  == 10) {
                                  echo __('To Audit','dealbao');
                            }
                        }

                        ?>

                    </td>

                    <td  class="widthHeight"  style="width: 450px!important;">
                        <table class="table table-bordered layui-table  "  style="height: 50px;width: 446px;margin: 2px;">

                            <tbody>
                            <tr>
                                <td class="leftRightBottom" style="border-bottom: 0"><?php _e('Category Name','dealbao')?>:</td>
                                <td class="leftRightBottom"  style="border-bottom: 0"><?php echo $value['gc_name'] ;?></td>
                                <td class="leftRightBottom"  style="border-bottom: 0"><?php _e('Brand Name','dealbao')?>:</td>
                                <td style="border-left: 1px solid #e6e6e6;border-top:  1px solid #e6e6e6;border-right:  1px solid #e6e6e6;"><?php echo $value['brand_name'] ;?></td>
                            </tr>
                            <tr>
                                <td class="leftRightBottom"><?php _e('Store Name','dealbao')?>:</td>
                                <td class="leftRightBottom"><?php echo $value['store_name'] ;?></td>
                                <td class="leftRightBottom"><?php _e('Add Time','dealbao')?>:</td>
                                <td class="leftRightBottom" style="border-right:  1px solid #e6e6e6;"><?php echo date('Y-m-d',$value['create_time']) ;?></td>
                            </tr>

                            </tbody>
                        </table>
                    </td>
                    <td class="widthHeight" >      <input style="margin: 15px;" type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Details','dealbao')?>"></td>

                </tr>
            <?php } ?>


            </tbody>
            <tfoot>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text"
                                                                                for="cb-select-all-1"><?php _e('Check All','dealbao') ?></label><input
                        id="cb-select-all-1" type="checkbox"></td>
                <th><?php _e('Picture','dealbao') ?></th>
                <th><?php _e('Product Info','dealbao') ?></th>
                <th><?php _e('State','dealbao') ?></th>
                <th><?php _e('Product Affiliation','dealbao') ?></th>
                <th><?php _e('Action','dealbao') ?></th>
            </tr>
            </tfoot>
            <?php } ?>
        </table>

        <div class="tablenav">
            <?php
            $totalPage = 0;
            if ($data['code'] == 200) {
                $totalPage = ceil($data['total'] / 10);
                $dealbaoPages = new dealbaoPages($paged, $totalPage, '2', $data['total']);
                echo $dealbaoPages->pagesHtml();

            }
            ?>

        </div>
        </div>
        <form method="POST" action="" id="orderDetail">

            <?php
            //输出一个验证信息
            wp_nonce_field('dealbao_order_detail');
            ?>

        </form>


    </div>




<script>


    var zNodes = <?php echo json_encode($caegoryData);?>;
    var cateId = '<?php echo $categoryId;?>';


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
        }
        else {
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

<?php
wp_enqueue_script('dealbao_collect_tree_list', DEALBAO_DIR_URL . 'js/dealbao_tree_list.js', array('jquery'));
?>