(function ($) {
    function readyFn() {
        // Set your code here!!


    $('#goodsExport').click(function () {

        $('.wrap #message').remove();
        var allSpu='';
       $.each( $('.goodsSpu'),function (k,v) {
           if($(this).is(':checked')){
               allSpu+=$(this).val()+',';
           }

       })

        if(allSpu==''){
            $('.wrap').prepend(`  <div id="message"  class="error notice is-dismissible"><p>`+Please_check_exported_goods+`</p></div>`);
            return false;
        }
     $('.goods_spu').val(allSpu);
        $.ajax({
            type: "POST",
            data: "action=dealbao_get_goods_category",
            url: ajax_object.ajax_url,
            beforeSend: function() {

            },
            success: function( $data ) {
                $('#dealbao_product #dealbao_product_catchecklist').html($data);

                $('.a-GoodsExport').click();

            }
        });

    }) ;


    $('#goodsSpuExport').click(function () {

        $('#categoryMessage').remove();
        var allCategory='';
       $.each( $('.dealbao_category_list'),function (k,v) {
           if($(this).is(':checked')){
               allCategory+=$(this).val()+',';
           }

       })

        var goodsSpu = $('.goods_spu').val();

       if(allCategory=='' || goodsSpu == ''){
           $('#TB_ajaxContent').prepend(`  <div id="categoryMessage"  class="error notice is-dismissible"><p>`+Please_check_exported_category+`</p></div>`);
           return false;
       }
        $('.container').show();
        $('#TB_closeWindowButton').click();
        $('.wrap').prepend(`<div id="message"  class="notice-warning notice is-dismissible"><p>`+Please_do_not_jump_goods+`</p></div>`);

        $.ajax({
            type: "POST",
            data: "goodsSpu="+goodsSpu+"&allCategory="+allCategory+"&action=dealbao_add_goods",
            url: ajax_object.ajax_url,
            dataType:'json',
            beforeSend: function() {

            },
            success: function( $data ) {

                 goodsSpuInfo($data);

            }
        });

    })


}


function goodsSpuInfo($goodsSpuInfo) {


        var num=0;
    if($goodsSpuInfo.count==0){

        $('.progress-bar').css('background-color','#86e01e');
        $('.percentage').html('100%');
        $('.percentage').css('color','#86e01e');
        setTimeout(function(){
            $('.container').hide();
            $('.wrap #message').remove();
            $('.wrap').prepend(`<div id="message"  class="updated notice is-dismissible"><p>`+Export_Success+`</p></div>`);
        },1500);
        return false;
    }
    $.ajax({
        type: "POST",
        dataType:'json',
        timeout:0,
        data: "type=goods_upload&action=dealbao_add_goods&count="+$goodsSpuInfo.count,
        url: ajax_object.ajax_url,
        beforeSend: function() {

        },
        error:function(xhr, textStatus, errorThrown){
            if (num < 1 ) {
                num++;
                    //try again
                    $.ajax(this);
                    return;

            }else {
                $('.progress-bar').css('background-color','#ff0004');
                $('.percentage').css('color','#ff0004');
                $('.progress-bar').css('width','100%');
                $('.percentage').html('导出失败');
                return;
            }

        },
        success: function( $data ) {

            $('.progress-bar').css('width',$data.width+'%');
            $('.percentage').html($data.width+'%');
            if($data.width<=5){
                $('#TB_closeWindowButton').click();
                $('.progress-bar').css('background-color','#f63a0f');
                $('.percentage').css('color','#f63a0f');
                goodsSpuInfo($data);
            }else if($data.width<=25){
                $('.progress-bar').css('background-color','#f27011');
                $('.percentage').css('color','#f27011');
                goodsSpuInfo($data);
            }else if($data.width<=50){
                $('.progress-bar').css('background-color','#f2b01e');
                $('.percentage').css('color','#f2b01e');
                goodsSpuInfo($data);
            }else if($data.width<=75){
                $('.progress-bar').css('background-color','#f2d31b');
                $('.percentage').css('color','#f2d31b');
                goodsSpuInfo($data);
            }else if($data.width<=100){
                $('.progress-bar').css('background-color','#86e01e');
                $('.percentage').css('color','#86e01e');
                if($data.width==100){
                    setTimeout(function(){
                        $('.container').hide();
                        $('.wrap #message').remove();
                        $('.wrap').prepend(`  <div id="message"  class="updated notice is-dismissible"><p>`+Export_Success+`</p></div>`);
                    },1500);
                }else {
                    goodsSpuInfo($data);
                }

            }



        }
    });
}
    $(document).ready(readyFn);
})(jQuery);