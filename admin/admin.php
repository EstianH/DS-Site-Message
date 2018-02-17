<?php
if(!defined('ABSPATH')) exit;

$dssm_admin = new dssm_admin();
$dssm_admin->startup();

// Register and handle settings.
require_once DSSM_ROOT . 'admin/inc/dssm-admin-class-settings.php';
$settings_handler = new dssm_admin_settings_handler();
$settings_handler->startup();

// DS Support Mail Submission.
if(!function_exists('ds_support_callback')){
    function ds_support_callback(){
        if(isset($_POST['ds_nonce']) && wp_verify_nonce($_POST['ds_nonce'], 'ds_nonce')){
            $plugin = sanitize_text_field($_POST['ds_plugin']);
            $name = sanitize_text_field($_POST['ds_name']);
            $email = sanitize_email($_POST['ds_email']);
            $message = sanitize_text_field($_POST['ds_message']);
            $headers[] = 'Content-Type: text/html; charset=UTF-8>';
            $headers[] = 'From: ' . $name . ' <' . DS_SUPPORT_EMAIL . '>';
            $headers[] = 'Bcc: ' . $name . ' <x+562194273659582@mail.asana.com>';
            
            $messagePrepared = '<strong>From:</strong><br />' . $name . '(' . $email . ')' . '<br /><br />';
            $messagePrepared .= '<strong>Message:</strong><br />' . $message . '<br /></br />';
            
            // To, Subject, Message, Headers, Attachments.
            wp_mail(DS_SUPPORT_EMAIL, $plugin, $messagePrepared, $headers);
            wp_safe_redirect(admin_url('admin.php') . '?page=ds-general&ds_support_request=sent');
            die();
        } else{
            wp_die(__('Invalid nonce specified', DSSM_TITLE), __('Error', DSSM_TITLE), array(
                'response' => 403,
                'back_link' => 'admin.php?page=' . DSSM_TITLE,
            ));
        }
    }
}
add_action('admin_post_ds_support', 'ds_support_callback');

class dssm_admin{
    private $capability, $brand, $template, $slug, $plugin;
    
    function __construct(){
        $this->capability = 'edit_plugins';
        $this->brand = 'Divspot';
        $this->template = 'load_main';
        $this->slug = 'ds-general';
        $this->plugin = array(
            'name' => DSSM_TITLE,
            'template' => 'load_settings',
            'slug' => 'dssm-settings'
        );
    }
    
    function startup(){
        // Startup admin pages.
        add_action('admin_menu', function(){
            // Setup admin menu
            if(!isset($GLOBALS['admin_page_hooks'][$this->slug])){ // Load general page.
                add_menu_page($this->brand, $this->brand, $this->capability, $this->slug, array($this, $this->template), '', 79);
                add_submenu_page($this->slug, 'General', 'General', $this->capability, $this->slug, array($this, $this->template));
            }
            
            add_submenu_page($this->slug, $this->plugin['name'], $this->plugin['name'], $this->capability, $this->plugin['slug'], array($this, $this->plugin['template']));
        });
        
        // Register styles and scripts.
        if(!wp_style_is('ds-style')) wp_register_style('ds-style', DSSM_ASSETS . 'admin/css/general.css', array(), DSSM_VERSION);
        if(!wp_script_is('ds-script')) wp_register_script('ds-script', DSSM_ASSETS . 'admin/js/general.js', array(), DSSM_VERSION);
        wp_register_style('dssm-style', DSSM_ASSETS . 'admin/css/style.css', array(), DSSM_VERSION);
        wp_register_script('dssm-script', DSSM_ASSETS . 'admin/js/script.js', array(), DSSM_VERSION);

        add_action('admin_enqueue_scripts', function(){
            wp_enqueue_style('ds-style');
            wp_enqueue_style('dssm-style');

            if(get_current_screen()->id === 'toplevel_page_ds-general' ||
                get_current_screen()->id === 'divspot_page_dssm-settings') wp_enqueue_script('ds-script');
            if(get_current_screen()->id === 'divspot_page_dssm-settings'){
                wp_enqueue_script('dssm-script');
                wp_enqueue_media(); // WP Media
            }
        });
        
        // Add plugin list settings link.
        add_filter("plugin_action_links_" . DSSM_BASENAME, function($links){
            $settings_link = '<a href="' . esc_url(admin_url('/admin.php')) . '?page=' . $this->plugin['slug'] . '">' . __('Settings') . '</a>';
            array_push($links, $settings_link);
            return $links;
        });
    }
    
    // Load page templates.
    function load_main(){ load_template(DSSM_ROOT . 'admin/templates/general.php'); }
    function load_settings(){ load_template(DSSM_ROOT . 'admin/templates/settings.php'); }
}