<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Register post type
 *
 *
 * */

if(!function_exists('stp_reg_post_type'))
{
    function stp_reg_post_type($post_type, $args)
    {
        register_post_type($post_type, $args);
    }
}
/**
 * Register post type
 *
 *
 * */

if(!function_exists('stp_reg_taxonomy'))
{
    function stp_reg_taxonomy($taxonomy, $object_type, $args )
    {
        register_taxonomy($taxonomy, $object_type, $args );
    }
}
/**
 * Add shortcode
 *
 *
 * */

if(!function_exists('stp_reg_shortcode'))
{
    function stp_reg_shortcode($tag , $func )
    {
        add_shortcode($tag , $func );
    }
}
if(!function_exists('th_shortcode_param'))
{
    function th_shortcode_param( $name, $form_field_callback, $script_url = null ){
        add_shortcode_param( $name, $form_field_callback, $script_url = null );
    }
}
if(!function_exists('th_instagram_api_curl_connect')){
    function th_instagram_api_curl_connect( $api_url ){
        $content = file_get_contents($api_url);
        return json_decode( $content ); // decode and return
    }
}
if(!function_exists('th_scrape_instagram'))
{
function th_scrape_instagram($username, $slice = 9 , $token = '',$size_index= 0) {
    // $key = '3225616123.d90570a.92f2ff44795d4458926300c08c408ea6';
    $username = strtolower($username);
    $instagram = array();
    if($username) {
        if(!empty($token)){
            $api = "https://api.instagram.com/v1/users/self/media/recent?access_token=".$token;
            $all_data = array();
            $i = 1;
            $max_page = (int)($slice/20) + 1;
            while ($api !== NULL && $i <= $max_page) {                
                $data = th_instagram_api_curl_connect($api);
                if(isset($data->data)) $all_data = array_merge($all_data,$data->data);
                if(isset($data->pagination->next_url)) $api = $data->pagination->next_url;
                else $api = NULL;
                $i++;
            }
            $i = 1;
            foreach ($all_data as $value) {
                switch ($size_index) {
                    case '1':
                        $thumbnail_src = $value->images->low_resolution->url;
                        break;

                    case '2':
                        $thumbnail_src = $value->images->low_resolution->url;
                        break;

                    case '3':
                        $thumbnail_src = $value->images->standard_resolution->url;
                        break;
                    
                    default:
                        $thumbnail_src = $value->images->thumbnail->url;
                        break;
                }
                $instagram[] = array(
                    'link' => $value->link,
                    'thumbnail_src' => $thumbnail_src,
                );
                if($i == $slice) break;
                $i++;
            }
        }
        set_transient('instagram-media-'.sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS*2));
    }
    return array_slice($instagram, 0, $slice);
    }
}
if(!function_exists('th_images_only'))
{
    function th_images_only($media_item) {
        if ($media_item['type'] == 'image')
        return true;
        return false;
    }
}
if(!function_exists('th_get_current_url'))
{
    function th_get_current_url() {
        $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        return $url;
    }
}
if(!function_exists('th_get_price_arange')){
    function th_get_price_arange(){
        global $wpdb, $wp_the_query;
        $args       = $wp_the_query->query_vars;
        if ( ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms'    => array( $args['term'] ),
                'field'    => 'slug',
            );
        }
        $tax_query  = array();
        $meta_query  = array();
        foreach ( $meta_query as $key => $query ) {
            if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
                unset( $meta_query[ $key ] );
            }
        }

        $meta_query = new WP_Meta_Query( $meta_query );
        $tax_query  = new WP_Tax_Query( $tax_query );

        $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );
        $sql  = "
        SELECT min( CAST( price_meta.meta_value AS UNSIGNED ) ) as min_price, max( CAST( price_meta.meta_value AS UNSIGNED ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= "   WHERE {$wpdb->posts}.post_type = 'product'
                    AND {$wpdb->posts}.post_status = 'publish'
                    AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
                    AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $prices = $wpdb->get_row( $sql );
        $price = array();
        $price['min'] = floor( $prices->min_price );
        $price['max'] = ceil( $prices->max_price );
        return $price;
    }
}
if(!function_exists('th_load_lib')){
    function th_load_lib($folder)
    {
        //Auto load widget
        $files=glob(get_template_directory()."/"."7upframe/".$folder."/*.php");

        // Auto load all file
        if(!empty($files)){
            foreach ($files as $filename)
            {
                load_template($filename);
            }
        }

    }
}
function th_get_image_by_url($image_src,$size,$class=''){
    global $wpdb;
    $width = $height = '';
    if(is_array($size)){
        $width = $size[0];
        $height = $size[1];
    }
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    if($id) $html = wp_get_attachment_image($id,$size,0,array('class'=>$class));
    else $html = '<img width="'.esc_attr($width).'"  height="'.esc_attr($height).'" class="'.esc_attr($class).'" alt="" src="'.esc_url($image_src).'">';
    return $html;
}
//Add header style
if (!function_exists('th_add_inline_style')) {
    function th_add_inline_style($style) {
        $style = str_replace("'", '"', $style);
        $content ='<script type="text/javascript">
                    (function($) {
                        "use strict";
                        $("head").append('."'".'<style id="sv_add_footer_css">'.$style.'</style>'."'".');
                    })(jQuery);
                    </script>';
        return $content;
    }
}
if(!function_exists('th_fix_decodeb64')){
    function th_fix_decodeb64( $data , $strict = FALSE ){
        return base64_decode( $data , $strict );
    }
}
if(!function_exists('th_reg_widget')){
    function th_reg_widget( $widget_class ){
        register_widget( $widget_class );
    }
}
if(!function_exists('th_check_verify')){
    function th_check_verify(){
        return true;
    }
}