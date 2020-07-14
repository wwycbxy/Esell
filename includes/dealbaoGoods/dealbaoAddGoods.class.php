<?php
/**
 * Created by PhpStorm.
 * User: BXY
 * Date: 2020/6/5
 * Time: 16:54
 */
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
include 'dealbaoGoodsCurl.class.php';

class dealbaoAddGoods
{
    protected $goodsCurl = [];

    public function __construct()
    {
        set_time_limit(0);
        $this->goodsCurl = new dealbaoGoodsCurl();
        if (isset($_POST['type'])) {

            $this->getGoodsUpload();
        } else {
            $this->getGoodsInfo();
        }


    }

    /**
     * 获取远程商品信息
     */
    public function getGoodsInfo()
    {
        global $wpdb;

        $goodsSpu = rtrim(sanitize_text_field($_POST['goodsSpu']), ",");

        $allGooodsList = $this->goodsCurl->dealbaoGetGoodsInfo(['spu' => $goodsSpu]);




        $msg = '';

        if (isset($allGooodsList['data'])) {

            foreach ($allGooodsList['data'] as $goodsKey => $goodsDate) {
                //判断该商品是否导入

                $post_sql = "SELECT * FROM `{$wpdb->prefix}postmeta` WHERE `meta_value`='dealbao_".$goodsDate['spu']."'";
                $post_row = $wpdb->get_row( $post_sql, ARRAY_A );

                if (!$post_row) {

                $select_sql = "SELECT * FROM `{$wpdb->prefix}dealbao_goods` WHERE `spu`='".$goodsDate['spu']."' AND `goods_upload_type`='0' ";
                $row = $wpdb->get_row( $select_sql, ARRAY_A );

                if(empty($row)){

                    $sql = "REPLACE INTO `{$wpdb->prefix}dealbao_goods` VALUES ('', '".$goodsDate['spu']."', '".$goodsDate['goods_name']."', '".$goodsDate['goods_ad_words']."', '".rtrim(sanitize_text_field($_POST['allCategory']), ",")."','".$goodsDate['spec_name']."', '".$goodsDate['spec_value']."','".$goodsDate['goods_image']."', '".str_replace("'", "\'", str_replace("\\", "\\\\", $goodsDate['goods_body']))."', '', '".serialize($goodsDate['sku_data'])."','".serialize($goodsDate['images_more'])."', '".$goodsDate['goods_price']."','".$goodsDate['goods_marketprice']."', '".$goodsDate['goods_storage']."','".$goodsDate['weight']."', '".$goodsDate['goods_storage_alarm']."','0');";
                    $wpdb->query($sql);
                }else{
                    $msg .= $goodsDate['goods_name']. ',';
                }


                } else {
                    $msg .= $goodsDate['goods_name']. ',';
                }
            }



        }
        $count_sql = "SELECT count(*) as count FROM `{$wpdb->prefix}dealbao_goods` WHERE `goods_upload_type`='0'";
        $count_row = $wpdb->get_row( $count_sql, ARRAY_A );



        $result['count'] = $count_row['count'];
        if (!empty($msg)) {
            $result['msg'] = $msg . '商品已导入，请勿重复添加';
        } else {
            $result['msg'] = '商品导入成功';
        }
        echo json_encode($result);
        wp_die();


//        $post_id = spu_create_product_variation(array(
//            'author'           => '', // optional
//            'title'            => '接口连接阿斯顿',
//            'content'          => '<p>This is the product content <br>A very nice product, soft and clear…<p>',
//            'excerpt'          => 'The product short description…',
//            'regular_price'    => '16', // product regular price
//            'sale_price'       => '', // product sale price (optional)
//            'stock'            => '10', // Set a minimal stock quantity
//            'low_stock_amount' => '5', // Set a minimal stock quantity
//            'image_id'         => '', // optional
//            'gallery_ids'      => array(), // optional
//            'sku'              => '', // optional
//            'tax_class'        => '', // optional
//            'category_id'      => [39], // optional
//            'weight'           => '', // optional
//            // For NEW attributes/values use NAMES (not slugs)
//            'attributes'       => array(
//                '颜色' => array('红', '绿'),
//                '尺码' => array('11', '12', '13'),
//            ),
//        ));
//
//        // Or get the variable product id dynamically
//        $parent_id = $post_id;
//// The variation data
//        $variation_data = array(
//            'attributes'    => array(
//                '颜色' => '红',
//                '尺码' => '11',
//            ),
//            'sku'           => '',
//            'regular_price' => '33334.00',
//            'sale_price'    => '2333.00',
//            'stock_qty'     => 1000,
//        );
//
//// check if variation exists
//        $meta_query = array();
//        foreach ($variation_data['attributes'] as $key => $value) {
//            $meta_query[] = array(
//                'key'   => 'attribute_pa_' . $key,
//                'value' => $value
//            );
//        }
//
//        $variation_post = get_posts(array(
//            'post_type'   => 'product_variation',
//            'numberposts' => 1,
//            'post_parent' => $parent_id,
//            'meta_query'  => $meta_query
//        ));
//
//        if ($variation_post) {
//            $variation_data['variation_id'] = $variation_post[0]->ID;
//        }// The function to be run
//        ;
//
//        var_dump(sku_create_product_variation($parent_id, $variation_data));

    }

    public function getGoodsUpload()
    {

        global $wpdb;
        $once_sql = "SELECT * FROM `{$wpdb->prefix}dealbao_goods` WHERE `goods_upload_type`='0' limit 1";
        $goodsDate = $wpdb->get_row( $once_sql, ARRAY_A );




        $msg = '';

        if (isset($goodsDate)) {

                $goodsDateAll = array(
                    'author'           => '', // optional
                    'title'            => $goodsDate['goods_name'],
                    'content'          => $goodsDate['goods_body'],
                    'excerpt'          => $goodsDate['goods_ad_words'],
                    'regular_price'    => $goodsDate['goods_marketprice'], // product regular price
                    'sale_price'       => $goodsDate['goods_price'], // product sale price (optional)
                    'stock'            => $goodsDate['goods_storage'], // Set a minimal stock quantity
                    'low_stock_amount' => $goodsDate['goods_storage_alarm'], // Set a minimal stock quantity
                    'image_id'         => $goodsDate['goods_image'], // optional
                    'gallery_ids'      => unserialize($goodsDate['gallery_ids']), // optional
                    'sku'              => 'dealbao_' . $goodsDate['spu'], // optional
                    'tax_class'        => '', // optional
                    'category_id'      => explode(",", $goodsDate['category_id']), // optional
                    'weight'           => $goodsDate['weight'], // optional
                    // For NEW attributes/values use NAMES (not slugs)
//                    'attributes'       => array(
//                        'cocol' => array('红', '绿'),
//                        'size' => array('11', '12', '13'),
//                    ),
                );
                $goodsDateAll['attributes'] = [];
                $spec_name = array_values(unserialize($goodsDate['spec_name']));

                    if (!empty($spec_name)) {
                        $spec_value = array_values(unserialize($goodsDate['spec_value']));

                        foreach ($spec_name as $specKey => $specValue) {
                            $goodsDateAll['attributes'][$specValue] = array_values($spec_value[$specKey]);
                        }
                    }

                    $post_id = spu_create_product_variation($goodsDateAll);

                    $sku_data = unserialize($goodsDate['sku_data']);

                    if (count($sku_data)>1) {

                        foreach ($sku_data as $skuKey => $skuValue) {

                            if ($skuValue['_source']['spu'] != $skuValue['_source']['goods_sku']) {
                                $sku_spec_name = array_values(unserialize($skuValue['_source']['spec_name']));
                                $sku_spec_value = array_values(unserialize($skuValue['_source']['goods_spec']));
                                if($sku_spec_name){
                                foreach ($sku_spec_name as $specKeySku => $specValueSku) {
                                    $skuSttributes[$specValueSku] = $sku_spec_value[$specKeySku];
                                }
                                $variation_data = array(
                                    'attributes'    => $skuSttributes,
                                    'sku'           => 'dealbao_' . $skuValue['_source']['goods_sku'],
                                    'regular_price' => $skuValue['_source']['goods_marketprice'],
                                    'sale_price'    => $skuValue['_source']['goods_promotion_price'],
                                    'stock_qty'     => $skuValue['_source']['goods_storage'],
                                    'image_id'      => $skuValue['_source']['goods_image'],
                                );

// check if variation exists
                                $meta_query = array();
                                foreach ($variation_data['attributes'] as $key => $value) {
                                    $meta_query[] = array(
                                        'key'   => 'attribute_pa_' . $key,
                                        'value' => $value
                                    );
                                }

                                $variation_post = get_posts(array(
                                    'post_type'   => 'product_variation',
                                    'numberposts' => 1,
                                    'post_parent' => $post_id,
                                    'meta_query'  => $meta_query
                                ));

                                if ($variation_post) {
                                    $variation_data['variation_id'] = $variation_post[0]->ID;
                                }


                              sku_create_product_variation($post_id, $variation_data);
                            }
                        }

                        }
                    }

            $wpdb->update( "{$wpdb->prefix}dealbao_goods", array( 'goods_upload_type' => 1 ), array( 'goods_id' => $goodsDate['goods_id'] ) );

            $count_sql = "SELECT count(*) as count FROM `{$wpdb->prefix}dealbao_goods` WHERE `goods_upload_type`='0'";
            $count_row = $wpdb->get_row( $count_sql, ARRAY_A );

            $percentage =round(((sanitize_text_field($_POST['count'])-$count_row['count'])/sanitize_text_field($_POST['count']))*100);
            $result['count'] = sanitize_text_field($_POST['count']);
            $result['width'] = $percentage==0 ? 100 : $percentage;

        }else{
            $result['count'] = sanitize_text_field($_POST['count']);
            $result['width'] = 100;
        }

        echo json_encode($result);
        wp_die();

    }




}


/**
 * Create a new variable product (with new attributes if they are).
 * (Needed functions:
 *
 * @since 3.0.0
 * @param array $data | The data to insert in the product.
 */

function spu_create_product_variation($data)
{
    if (!function_exists('save_product_attribute_from_name')) return;
    global $wpdb;
    $postname = sanitize_title($data['title']);
    $author = empty($data['author']) ? '1' : $data['author'];

    $post_data = array(
        'post_author'  => $author,
        'post_name'    => $postname,
        'post_title'   => $data['title'],
        'post_content' => $data['content'],
        'post_excerpt' => $data['excerpt'],
        'post_status'  => 'publish',
        'ping_status'  => 'closed',
        'post_type'    => 'product',
        'guid'         => home_url('/product/' . $postname . '/'),
    );

    // Creating the product (post data)
    $product_id = wp_insert_post($post_data);

    // Get an instance of the WC_Product_Variable object and save it
    if(count($data['attributes'])>0){
        $product = new WC_Product_Variable($product_id);
    }else{
        $product = new WC_Product_Simple($product_id);
    }

    $product->save();

    ## ---------------------- Other optional data  ---------------------- ##
    ##     (see WC_Product and WC_Product_Variable setters methods)

    // THE PRICES (No prices yet as we need to create product variations)

    //IMAGE
    $image_name = $data['image_id'];

    if (!empty($data['image_id'])) {

        $imag_id = uploadImage($image_name);

     $product->set_image_id($imag_id);
    }


    // IMAGES GALLERY
    if (!empty($data['gallery_ids']) && count($data['gallery_ids']) > 0){
        $gallery_ids = [];
        foreach ($data['gallery_ids'] as $key => $value){
            $gallery_ids[] = uploadImage($value['goods_image']);

        }
         $product->set_gallery_image_ids($gallery_ids);
    }


    // SKU
//    if (!empty($data['sku'])) $product->set_sku($data['sku']);

    // Prices
    if (empty($data['sale_price'])) {
        $product->set_price($data['regular_price']);
    } else {
        $product->set_price($data['sale_price']);
        $product->set_sale_price($data['sale_price']);
    }
    $product->set_regular_price($data['regular_price']);
    // STOCK (stock will be managed in variations)
    $product->set_stock_quantity($data['stock']); // Set a minimal stock quantity
    $product->set_manage_stock(true);
    $product->set_stock_status('');
    $product->set_low_stock_amount($data['low_stock_amount']);

    // Tax class
    if (empty($data['tax_class']))
        $product->set_tax_class($data['tax_class']);

    // WEIGHT
    if (!empty($data['weight']))
        $product->set_weight(''); // weight (reseting)
    else
        $product->set_weight($data['weight']);

    $product->set_category_ids($data['category_id']);
    $product->validate_props(); // Check validation


    ## ---------------------- VARIATION ATTRIBUTES ---------------------- ##
    if(count($data['attributes'])>0){
    $product_attributes = array();

    foreach ($data['attributes'] as $key => $terms) {
        $taxonomy = wc_attribute_taxonomy_name($key); // The taxonomy slug
        $attr_label = ucfirst($key); // attribute label name
        $attr_name = (wc_sanitize_taxonomy_name($key)); // attribute slug

        // NEW Attributes: Register and save them
        if (!taxonomy_exists($taxonomy))
            save_product_attribute_from_name($attr_name, $attr_label);

        $product_attributes[sanitize_title($taxonomy)] = array(
            'name'         => $taxonomy,
            'value'        => '',
            'position'     => '',
            'is_visible'   => 0,
            'is_variation' => 1,
            'is_taxonomy'  => 1
        );

        foreach ($terms as $value) {
            $term_name = ucfirst($value);
            $term_slug = sanitize_title($value);

            // Check if the Term name exist and if not we create it.
            if (!term_exists($value, $taxonomy))
                wp_insert_term($term_name, $taxonomy, array('slug' => $term_slug)) ; // Create the term

            // Set attribute values

            wp_set_post_terms($product_id, $term_name, $taxonomy, true);
        }
    }
    if(!empty($product_attributes)){
        update_post_meta($product_id, '_product_attributes', $product_attributes);
    }
    }
    $post_sql = "SELECT * FROM `{$wpdb->prefix}postmeta` WHERE `meta_value`='".$data['sku']."'";
    $post_row = $wpdb->get_row( $post_sql, ARRAY_A );
    if(empty($post_row)){
        update_post_meta($product_id, '_dealbao_product_sku', $data['sku']);
    }


    $id = $product->save(); // Save the data

    return $id;


}


/**
 * Create a product variation for a defined variable product ID.
 *
 * @since 3.0.0
 * @param int $product_id | Post ID of the product parent variable product.
 * @param array $variation_data | The data to insert in the product.
 */

function sku_create_product_variation($product_id, $variation_data)
{
// Get the Variable product object (parent)
    global $wpdb;
    if (isset($variation_data['variation_id'])) {

        $variation_id = $variation_data['variation_id'];

    } else {
        $product = wc_get_product($product_id);

        $variation_post = array(
            'post_title'  => $product->get_name(),
            'post_name'   => 'product-' . $product_id . '-variation',
            'post_status' => 'publish',
            'post_parent' => $product_id,
            'post_type'   => 'product_variation',
            'guid'        => $product->get_permalink()
        );

// Creating the product variation
        $variation_id = wp_insert_post($variation_post);
    }
    // Get an instance of the WC_Product_Variation object
    $variation = new WC_Product_Variation($variation_id);

    // Iterating through the variations attributes
    foreach ($variation_data['attributes'] as $attribute => $term_name) {
        $taxonomy = wc_attribute_taxonomy_name($attribute); // The attribute taxonomy


        if (!taxonomy_exists($taxonomy)) {
            register_taxonomy(
                $taxonomy,
                'product_variation',
                array(
                    'hierarchical' => false,
                    'label'        => ucfirst($attribute),  //Display name
                    'query_var'    => true,
                    'rewrite'      => array('slug' => sanitize_title($attribute)), 'with_front' => false)
            );

        }

        // Check if the Term name exist and if not we create it.
        if (!term_exists($term_name, $taxonomy))
           wp_insert_term($term_name, $taxonomy); // Create the term

        $term_slug = get_term_by('name', $term_name, $taxonomy)->slug; // Get the term slug

        // Get the post Terms names from the parent variable product.
        $post_term_names = wp_get_post_terms($product_id, $taxonomy, array('fields' => 'names'));

        // Check if the post term exist and if not we set it in the parent variable product.
        if (!in_array($term_name, $post_term_names))
            wp_set_post_terms($product_id, $term_name, $taxonomy, true);

        // Set/save the attribute data in the product variation
        update_post_meta($variation_id, 'attribute_' . sanitize_title($taxonomy), $term_slug);

    }

    $post_sql = "SELECT * FROM `{$wpdb->prefix}postmeta` WHERE `meta_value`='".$variation_data['sku']."'";
    $post_row = $wpdb->get_row( $post_sql, ARRAY_A );
    if(empty($post_row)){
        update_post_meta($variation_id, '_dealbao_product_sku', $variation_data['sku']);
    }

    ## Set/save all other data

    // SKU
//    if (!empty($variation_data['sku'])) $variation->set_sku($variation_data['sku']);


    //IMAGE
    $image_name = $variation_data['image_id'];

//        $imag_id =    media_sideload_image( $image_name, $product_id, '' );

    if (!empty($variation_data['image_id'])) {
        $imag_id = uploadImage($image_name);

        $variation->set_image_id($imag_id);
    }

    // Prices
    if (empty($variation_data['sale_price'])) {
        $variation->set_price($variation_data['regular_price']);
    } else {
        $variation->set_price($variation_data['sale_price']);
        $variation->set_sale_price($variation_data['sale_price']);
    }
    $variation->set_regular_price($variation_data['regular_price']);

    // Stock
    if (!empty($variation_data['stock_qty'])) {
        $variation->set_stock_quantity($variation_data['stock_qty']);
        $variation->set_manage_stock(true);
        $variation->set_stock_status('');
    } else {
        $variation->set_manage_stock(false);
    }

    $variation->set_weight(''); // weight (reseting)

    $variation->save(); // Save the data
}


/**
 * Save a new product attribute from his name (slug).
 *
 * @since 3.0.0
 * @param string $name | The product attribute name (slug).
 * @param string $label | The product attribute label (name).
 */
function save_product_attribute_from_name($name, $label = '', $set = true)
{
    if (!function_exists('get_attribute_id_from_name')) return;

    global $wpdb;

    $label = $label == '' ? ucfirst($name) : $label;
    $attribute_id = get_attribute_id_from_name($name);

    if (empty($attribute_id)) {
        $attribute_id = NULL;
    } else {
        $set = false;
    }

    $args = array(
        'attribute_id'      => $attribute_id,
        'attribute_name'    => $name,
        'attribute_label'   => $label,
        'attribute_type'    => 'select',
        'attribute_orderby' => 'menu_order',
        'attribute_public'  => 0,
    );

    if (empty($attribute_id)) {
        $wpdb->insert("{$wpdb->prefix}woocommerce_attribute_taxonomies", $args);
//        set_transient( 'wc_attribute_taxonomies', false );

    }


    if ($set) {
//        $attributes = wc_get_attribute_taxonomies();//原版本-----有问题
        $attributes = get_transient('wc_attribute_taxonomies');

        $args['attribute_id'] = get_attribute_id_from_name($name);
        $taxonomies_length = count($attributes);
        if ($taxonomies_length == 0) {
            $attributes[] = (object)$args;
        } else {
            $attributes[$taxonomies_length] = (object)$args;
        }


        set_transient('wc_attribute_taxonomies', $attributes);

    } else {
        return;
    }
}

/**
 * Get the product attribute ID from the name.
 *
 * @since 3.0.0
 * @param string $name | The name (slug).
 */
function get_attribute_id_from_name($name)
{
    global $wpdb;
    $attribute_id = $wpdb->get_col("SELECT attribute_id
    FROM {$wpdb->prefix}woocommerce_attribute_taxonomies
    WHERE attribute_name LIKE '$name'");
    return reset($attribute_id);
}
function mb_unserialize($str)
{
    $str = preg_replace_callback('#s:(\d+):"(.*?)";#s', function ($match) {
        return 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
    }, $str);
    return unserialize($str);
}
function uploadImage($image_url)
{


    $upload_dir = wp_upload_dir();

    $image_data =  wp_remote_retrieve_body( wp_remote_get( $image_url) );

    $filename = basename($image_url);

    if (wp_mkdir_p($upload_dir['path'])) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }

   file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null);

    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title'     => sanitize_file_name($filename),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
//        '/wp-content/uploads/'.date("Y").'/'.date("m").
    $attach_id = wp_insert_attachment($attachment, $file);
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);

    wp_update_attachment_metadata($attach_id, $attach_data);
    return $attach_id;
}

new dealbaoAddGoods();



















