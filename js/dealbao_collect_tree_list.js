(function ($) {
    function readyFn() {
        // Set your code here!!


var needChange;
    var type_id = 0;

    var updateLevel = 0;
    $("#updateLevel").on('click', function () {
        if (updateLevel == 0) {
            updateLevel++;
            $.ajax({
                url: "updateLevel",
                data: "",
                dataType: 'json',
                method: 'post',
                success: function () {
                    updateLevel--;
                },
                error: function () {
                    layer.msg("系统异常");
                    updateLevel--;
                }
            });
        }

    });

    var updateAllGoodsCount = 0;
    $("#updateAllGoodsCount").on('click', function () {
        if (updateAllGoodsCount == 0) {
            updateAllGoodsCount++;
            $.ajax({
                url: "getAllGoodsCount",
                data: {
                    id: $("input[name='id']").val(),
                },
                dataType: 'json',
                method: 'post',
                success: function (res) {
                    if (res.code == 1) {
                        layer.msg(res.msg, {
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function () {
                            window.location.reload();
                        });

                    }

                    updateAllGoodsCount--;
                },
                error: function () {
                    updateAllGoodsCount--;
                    layer.msg("系统异常");
                }
            });
        }
    })

    //更新总数信息
    var getGoodsCount = 0;
    $("#getGoodsCount").on('click', function () {

        if (getGoodsCount == 0) {
            var zTree = $.fn.zTree.getZTreeObj("category");
            getGoodsCount++;
            $.ajax({
                url: "getGoodsCount",
                data: {
                    id: $("input[name='id']").val(),
                },
                dataType: 'json',
                method: 'post',
                success: function (res) {
                    if (res.code == 1) {
                        needChange.goods_count = res.data.goods_count;
                        needChange.count_update_time = res.data.count_update_time;
                        needChange.gc_name_count = res.data.gc_name_count;
                        zTree.updateNode(needChange);
                        $("input[name='goods_count']").val(res.data.goods_count);
                        $("#count_update_time").text("更新时间:" + res.data.count_update_time);
                    }
                    layer.msg(res.msg);
                    getGoodsCount--;
                },
                error: function () {
                    getGoodsCount--;
                    layer.msg("系统异常");
                }
            });
        }

    });



    var cateEditInfo = 0;
    $("button[type='submit']").click(function (e) {
        if ($("input[name='type_id']:checked").val() != undefined) {
            var type_id = $("input[name='type_id']:checked").val();
        }
        var zTree = $.fn.zTree.getZTreeObj("category");
        if (cateEditInfo == 0) {
            cateEditInfo++;
            $.post(
                'cateEditInfo',
                {
                    gc_id: $("input[name='id']").val(),
                    gc_name: $("input[name='name']").val(),
                    commission_rate: $("input[name='commission_rate']").val(),
                    gc_sort: $("input[name='gc_sort']").val(),
                    status: $("select[name='status']").val(),
                    type_id: type_id
                }, function (res) {
                    if (res.code == 1) {
                        needChange.name = res.data.gc_name;
                        needChange.gc_name_count = res.data.gc_name_count;
                        needChange.gc_sort = res.data.gc_sort;
                        needChange.status = res.data.status;
                        needChange.commission_rate = res.data.commission_rate;
                        needChange.commission_rate_name = res.data.commission_rate_name ? res.data.commission_rate_name : "";
                        needChange.commission_rate_parent = res.data.commission_rate_parent ? res.data.commission_rate_parent : "";
                        if (needChange.status == 0) {
                            $("#category").find("#" + needChange.tId + "_a").css('color', 'red');
                        } else {
                            $("#category").find("#" + needChange.tId + "_a").attr('style', '');
                        }
                        zTree.updateNode(needChange);
                        layer.msg(res.msg);
                    } else {
                        layer.msg(res.msg);
                    }
                    cateEditInfo--;
                }
            )
        }

    });

    var newCount = 0;
    var setting = {
        edit: {
            prev: true,
            next: true,
            enable: true,
            showRenameBtn: false,
            removeTitle: '删除',
            showRemoveBtn:false,


        },

        view: {
            expandSpeed: "",
            selectedMulti: false,
            fontCss: setFontCss,
        },
        data: {
            simpleData: {
                enable: true,
            },
            key: {
                name:"group_name",
                id:"group_id",


            }
        },
        callback: {
            beforeDrag: zTreeBeforeDrag,
            onClick: onClick,

        }
    };


    function onClick(event, treeId, treeNode, clickFlag) {

        needChange = treeNode;
        console.log(treeNode);
        $('#keyword').val('');
        $('#cateId').val(needChange['group_id']);
        $('#level').val(needChange['level']+1);

        dealbaoPages(1);




    }
    function zTreeBeforeDrag(treeId, treeNodes) {
        return false;
    };
    function setFontCss(treeId, treeNode) {
        return treeNode.status == 0 ? {color: "red"} : {};
    };

    function removeHoverDom(treeId, treeNode) {
        $("#addBtn_" + treeNode.tId).unbind().remove();
    };


    $.fn.zTree.init($("#category"), setting, zNodes);
    var treeObj = $.fn.zTree.getZTreeObj("category");

    if(cateId.length>0){
        let node = treeObj.getNodeByParam("group_id", cateId);
    if (node != null) {

        // treeObj.checkNode(node, true, true, true);
        // treeObj.expandNode(node,true,true,true); //expand node
        // console.log(node['tId']);

        var treenode = treeObj.getNodeByParam("group_id", cateId, null);
        treeObj.expandNode(treenode, true, false, true);
        treeObj.selectNode(treenode);
        $('#'+node['tId']+'_a').addClass('curSelectedNode');

    }

    // var nodes = treeObj.getNodes();
    //  node = treeObj.getNodeByParam('id', group_default);
    // treeObj.selectNode(node);
    }
    }

    $(document).ready(readyFn);
})(jQuery);
