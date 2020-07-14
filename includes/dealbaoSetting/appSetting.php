

<!--	<div id="message" class="updated notice is-dismissible"><p>--><?php //_e( 'Plugin resumed.' ); ?><!--</p></div>-->
<!--	<div id="message" class="error notice is-dismissible"><p>--><?php //_e( 'Plugin resumed.' ); ?><!--</p></div>-->


<div class="wrap">
    <h2><?php _e('Supply Chain','dealbao') ?></h2>
    <p><?php _e('Supply Chain Application Settings','dealbao') ?></p>
    <?php settings_errors(); ?>
    <form method="post" action="">
        <?php
        @settings_fields( 'dealbao_option_group' );
        @do_settings_sections( 'dealbao-admin' );
        @submit_button();
        //输出一个验证信息
        wp_nonce_field('dealbao_option_setting');
        ?>

    </form>
</div>