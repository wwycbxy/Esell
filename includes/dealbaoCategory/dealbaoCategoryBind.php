<style>
    .leftRightBottom {
        border-left: 1px solid #e6e6e6;
        border-top: 1px solid #e6e6e6;
        border-bottom: 1px solid #e6e6e6;
    }

    .widefat td {
        padding: 2px;
    }

    .widthHeight {
        height: 50px !important;
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

    .zTreeDemoBackground .button {
        min-height: 16px;
        padding: 0;
    }

    .ztree li span.button:hover {
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

    .children {
        margin-left: 18px;
    }


</style>

<?php
wp_enqueue_style('zTreeStyle',DEALBAO_DIR_URL.'lib/zTree/css/zTreeStyle/zTreeStyle.css');
wp_enqueue_style('demo',DEALBAO_DIR_URL.'css/demo.css');
wp_enqueue_style('style',DEALBAO_DIR_URL.'css/style.css');
wp_enqueue_script('ztree', DEALBAO_DIR_URL . 'lib/zTree/js/jquery.ztree.all.js', array('jquery'));
?>

<div class="wrap">

    <h2><?php _e('Binding Category', 'dealbao') ?></h2>
    <br>
    <div class="zTreeDemoBackground left col-md-4" style="width: 15%;float: left">
        <label><?php _e('Local Classification','dealbao') ?></label>
        <ul id="category" class="ztree"></ul>
    </div>
    <div class="zTreeDemoBackground left col-md-4" style="width: 15%;margin-left: 50px;float: left">
        <label><?php _e('Remote Classification','dealbao') ?></label>
        <ul id="collect" class="ztree"></ul>
    </div>
    <div class="button action" id="dealbaoCategoryBind" style="float: left;margin: 20px;margin-left: 50px;" >   <?php _e('Confirm','dealbao') ?></div>
    <form method="POST" action="" id="categoryBind">

        <?php
        //输出一个验证信息
        wp_nonce_field('dealbao_category_bind');
        ?>

    </form>


</div>


<script>


    var zNodes = <?php echo json_encode($caegoryCollectData);?>;
    var caegoryNodes = <?php echo json_encode($category);?>;
    var cateBind = <?php echo json_encode($cate_bind);?>;

    (function ($) {
        function readyFn() {
        var needChange;

        var collectSetting = {
            edit: {
                prev: true,
                next: true,
                enable: true,
                showRenameBtn: false,
                removeTitle: '删除',
                showRemoveBtn: false,


            },

            view: {
                selectedMulti: true,
            },
            data: {
                simpleData: {
                    enable: true,
                },
                key: {
                    name: "group_name",
                    id: "group_id",
                    children: 'children',

                }
            },
            callback: {
                beforeClick:beforeClick,
                onClick: onCategoryClick,

            }
        };

        var categorySetting = {
            edit: {
                prev: true,
                next: true,
                enable: true,
                showRenameBtn: false,
                removeTitle: '删除',
                showRemoveBtn: false,


            },
            view: {
                selectedMulti: false,
            },
            data: {
                simpleData: {
                    enable: true,
                },
                key: {
                    name: "name",
                    id: "term_id",
                    children: 'children',

                }
            },
            callback: {

                onClick: onCategoryClick,

            }
        };


        function beforeClick( treeId, treeNode, clickFlag) {


            if(!$('#' + treeNode['tId'] + '_a').hasClass('curSelectedNode')){
                treeObj.expandNode(treeNode, true, false, true);
                treeObj.selectNode(treeNode,true);
                $('#' + treeNode['tId'] + '_a').addClass('curSelectedNode');
            }else {
                treeNode.isSelected = false;
                treeObj.cancelSelectedNode(treeNode);
            }

            return false
        }


        function onCategoryClick(event, treeId, treeNode, clickFlag) {
            treeObj.cancelSelectedNode();
                if (cateBind != '') {
                    $.each(cateBind, function (i, item) {
                        if (item.cate_id == treeNode.term_id) {

                            let node = treeObj.getNodeByParam("group_id", item.collect_cate_id);
                            if (node != null) {
                                var treenode = treeObj.getNodeByParam("group_id", item.collect_cate_id, null);
                                treeObj.expandNode(treenode, true, false, true);
                                treeObj.selectNode(treenode,true);
                                $('#' + node['tId'] + '_a').addClass('curSelectedNode');

                            }
                        }

                    })
                }
                categoryObj.selectNode(treeNode);

        }



        $.fn.zTree.init($("#collect"), collectSetting, zNodes);
        var treeObj = $.fn.zTree.getZTreeObj("collect");

        $.fn.zTree.init($("#category"), categorySetting, caegoryNodes);
        var categoryObj = $.fn.zTree.getZTreeObj("category");

        $(document).on('click','#dealbaoCategoryBind',function () {
            var categoryAll = categoryObj.getSelectedNodes();
            var collectAll = treeObj.getSelectedNodes();
            $('.wrap #message').remove();

            if(categoryAll[0] == undefined){

                $('.wrap').prepend(`<div id="message"  class="error notice is-dismissible"><p><?php _e('Please select local classification','dealbao') ?></p></div>`);
                return false;
            }

            if(collectAll == ''){

                $('.wrap').prepend(`<div id="message"  class="error notice is-dismissible"><p><?php _e('Please select remote classification','dealbao') ?></p></div>`);
                return false;
            }


            var categoryId = categoryAll[0].term_id;

            var collectId = '';

            $.each(collectAll,function (i,item) {
                collectId+=item.group_id+',';
            })


            var form = document.getElementById("categoryBind");   //定义一个form表单 

            form.method = 'post';
            form.target = '_self';
            form.class = 'post';
            form.action = '';
            // document.body.appendChild(form);  //将表单放置在web中  

            var typeFile = document.createElement('input');
            typeFile.type = 'hidden';
            typeFile.name = 'categoryId';
            typeFile.class = 'categoryId';
            typeFile.value = categoryId;
            form.appendChild(typeFile);
            var snFile = document.createElement('input');
            snFile.type = 'hidden';
            snFile.name = 'collectId';
            snFile.class = 'collectId';
            snFile.value = collectId;
            form.appendChild(snFile);


            form.submit();  //表单提交  



        })


        }

        $(document).ready(readyFn);
    })(jQuery);


</script>

