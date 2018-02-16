<?php if(!defined('ABSPATH')) exit; ?>
<?php $tabs = array('settings'); ?>
<?php $active_tab = (isset($_GET['tab']) ? $_GET['tab'] : 'settings'); ?>
<?php $dssm_sections = get_option('dssm-sections'); ?>
<?php $dssm_settings = get_option('dssm-settings'); ?>
<?php $aligns = array('left' => 'textleft', 'center' => 'textcenter', 'right' => 'textright'); ?>
<?php $positions = array('left' => 'margin-right: auto', 'center' => 'margin: auto', 'right' => 'margin-left: auto'); ?>
<?php $editor = array(
    'content' => (isset($dssm_settings['text']['body']) ? $dssm_settings['text']['body'] : ''),
    'editor_id' => 'dssmsettingsbody',
    'arguments' => array(
        'media_buttons' => false,
        'textarea_name' => 'dssm-settings[text][body]',
        'textarea_rows' => 8
    )
); ?>
<div id="ds-wrapper">
    <h1><?php echo DSSM_TITLE; ?></h1>
    <div class="wrap mt-0">
        <h2 class="pt-0 pb-0"></h2><!-- WP Notices render after the first <h2> tag in class="wrap" -->
        <h2 class="nav-tab-wrapper">
            <?php foreach($tabs as $tab){ ?>
                <a href="?page=dssm-settings&tab=<?php echo $tab; ?>" class="nav-tab<?php echo ($tab == $active_tab ? ' nav-tab-active' : ''); ?>"><?php echo ucfirst($tab); ?></a>
            <?php } ?>
                <a href="<?php echo home_url() . '?dssm-preview'; ?>" class="nav-tab" target="_blank">Preview</a>
        </h2>
        <div class="ds-blocks-container">
            <?php if($active_tab == 'settings'){ ?>
                <form method="post" action="options.php">
                    <?php settings_fields('dssm-settings'); ?>
                    <?php do_settings_sections('dssm-settings'); ?>
                    <div class="ds-row clearfix">
                        <div class="ds-block ds-col ds-col-12 mt-1">
                            <label class="ds-block-title pt-2 pr-2 pb-2 pl-2<?php echo (isset($dssm_sections['general']) ? ' expanded' : ''); ?>">
                                <h2 class="mt-0 mb-0">
                                    <span class="dashicons dashicons-admin-generic"></span>
                                    <?php _e('General'); ?>
                                    <span class="dashicons dashicons-arrow-right-alt2 floatright"></span>
                                    <span class="dashicons dashicons-arrow-down-alt2 floatright"></span>
                                </h2>
                                <input class="ds-section" name="dssm-sections[general]" type="checkbox" value="1"<?php echo (isset($dssm_sections['general']) ? ' checked="checked"' : ''); ?> />
                            </label>
                            <div class="pt-2 pr-2 pb-2 pl-2">
                                <div class="ds-row clearfix pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Enabled'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input name="dssm-settings[general][status]" type="checkbox" value="1"<?php echo (isset($dssm_settings['general']['status']) ? ' checked="checked"' : ''); ?> />
                                    </div>
                                </div>
                                <div class="ds-row clearfix pt-1">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Add temporarily unavailable headers (503):'); ?></label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input id="headers" name="dssm-settings[general][headers]" type="checkbox" value="1"<?php echo (isset($dssm_settings['general']['headers']) ? ' checked="checked"' : ''); ?> />
                                    </div>
                                </div>
                                <div id="retryafter" class="ds-row clearfix pt-1 mt-1 border-top border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Retry-After (in seconds)'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input class="ds-col-12" name="dssm-settings[general][retryafter]" type="number" value="<?php echo (isset($dssm_settings['general']['retryafter']) ? $dssm_settings['general']['retryafter'] : ''); ?>" placeholder="600" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-row clearfix">
                        <div class="ds-block ds-col ds-col-12 mt-1">
                            <label class="ds-block-title pt-2 pr-2 pb-2 pl-2<?php echo (isset($dssm_sections['message']) ? ' expanded' : ''); ?>">
                                <h2 class="mt-0 mb-0">
                                    <span class="dashicons dashicons-text"></span>
                                    <?php _e('Message'); ?>
                                    <span class="dashicons dashicons-arrow-right-alt2 floatright"></span>
                                    <span class="dashicons dashicons-arrow-down-alt2 floatright"></span>
                                </h2>
                                <input class="ds-section" name="dssm-sections[message]" type="checkbox" value="1"<?php echo (isset($dssm_sections['message']) ? ' checked="checked"' : ''); ?> />
                            </label>
                            <div class="pt-2 pr-2 pb-2 pl-2">
                                <div class="ds-row clearfix pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Heading'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input class="ds-col-12" name="dssm-settings[text][heading]" type="text" value="<?php echo (isset($dssm_settings['text']['heading']) ? $dssm_settings['text']['heading'] : ''); ?>" />
                                    </div>
                                </div>
                                <div class="ds-row clearfix pt-1 pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Logo'); ?>:</label>
                                    <div id="logo" class="ds-col ds-col-9 ds-2col<?php echo (isset($dssm_settings['text']['logo']) && $dssm_settings['text']['logo'] ? ' loaded' : ''); ?>">
                                        <div>
                                            <input name="dssm-settings[text][logo]" type="hidden" value="<?php echo (isset($dssm_settings['text']['logo']) && $dssm_settings['text']['logo'] ? $dssm_settings['text']['logo'] : ''); ?>" />
                                            <img width="100%" height="auto" src="<?php echo (isset($dssm_settings['text']['logo']) && $dssm_settings['text']['logo'] ? $dssm_settings['text']['logo'] : ''); ?>" />
                                        </div>
                                        <button id="logo-add" class="button button-primary" type="button"><?php _e('Add logo'); ?></button>
                                        <button id="logo-remove" class="button button-secondary" type="button"><?php _e('Remove logo'); ?></button>
                                    </div>
                                </div>
                                <div class="ds-row clearfix pt-1">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Body'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <?php wp_editor($editor['content'], $editor['editor_id'], $editor['arguments']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-row clearfix">
                        <div class="ds-block ds-col ds-col-12 mt-1">
                            <label class="ds-block-title pt-2 pr-2 pb-2 pl-2<?php echo (isset($dssm_sections['social']) ? ' expanded' : ''); ?>">
                                <h2 class="mt-0 mb-0">
                                    <span class="dashicons dashicons-networking"></span>
                                    <?php _e('Social Media'); ?>
                                    <span class="dashicons dashicons-arrow-right-alt2 floatright"></span>
                                    <span class="dashicons dashicons-arrow-down-alt2 floatright"></span>
                                </h2>
                                <input class="ds-section" name="dssm-sections[social]" type="checkbox" value="1"<?php echo (isset($dssm_sections['social']) ? ' checked="checked"' : ''); ?> />
                            </label>
                            <div class="pt-2 pr-2 pb-2 pl-2">
                                <div class="ds-row clearfix pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Facebook'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input class="ds-col-12" name="dssm-settings[social][facebook][url]" type="text" value="<?php echo (isset($dssm_settings['social']['facebook']['url']) && $dssm_settings['social']['facebook']['url'] ? $dssm_settings['social']['facebook']['url'] : ''); ?>" placeholder="Leave empty to exclude" />
                                        <input class="ds-col-12" name="dssm-settings[social][facebook][icon]" type="hidden" value="fab fa-facebook-f" />
                                    </div>
                                </div>
                                <div class="ds-row clearfix pt-1 pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Twitter'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input class="ds-col-12" name="dssm-settings[social][twitter][url]" type="text" value="<?php echo (isset($dssm_settings['social']['twitter']['url']) && $dssm_settings['social']['twitter']['url'] ? $dssm_settings['social']['twitter']['url'] : ''); ?>" placeholder="Leave empty to exclude" />
                                        <input class="ds-col-12" name="dssm-settings[social][twitter][icon]" type="hidden" value="fab fa-twitter" />
                                    </div>
                                </div>
                                <div class="ds-row clearfix pt-1 pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Instagram'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input class="ds-col-12" name="dssm-settings[social][instagram][url]" type="text" value="<?php echo (isset($dssm_settings['social']['instagram']['url']) && $dssm_settings['social']['instagram']['url'] ? $dssm_settings['social']['instagram']['url'] : ''); ?>" placeholder="Leave empty to exclude" />
                                        <input class="ds-col-12" name="dssm-settings[social][instagram][icon]" type="hidden" value="fab fa-instagram" />
                                    </div>
                                </div>
                                <div class="ds-row clearfix pt-1">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Email'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input class="ds-col-12" name="dssm-settings[social][email][url]" type="text" value="<?php echo (isset($dssm_settings['social']['email']['url']) && $dssm_settings['social']['email']['url'] ? $dssm_settings['social']['email']['url'] : ''); ?>" placeholder="Leave empty to exclude" />
                                        <input class="ds-col-12" name="dssm-settings[social][email][icon]" type="hidden" value="fas fa-envelope" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-row clearfix">
                        <div class="ds-block ds-col ds-col-12 mt-1">
                            <label class="ds-block-title pt-2 pr-2 pb-2 pl-2<?php echo (isset($dssm_sections['styling-font']) ? ' expanded' : ''); ?>">
                                <h2 class="mt-0 mb-0">
                                    <span class="dashicons dashicons-admin-customizer"></span>
                                    <?php _e('Styling: Font'); ?>
                                    <span class="dashicons dashicons-arrow-right-alt2 floatright"></span>
                                    <span class="dashicons dashicons-arrow-down-alt2 floatright"></span>
                                </h2>
                                <input class="ds-section" name="dssm-sections[styling-font]" type="checkbox" value="1"<?php echo (isset($dssm_sections['styling-font']) ? ' checked="checked"' : ''); ?> />
                            </label>
                            <div class="pt-2 pr-2 pb-2 pl-2">
                                <div class="ds-row clearfix pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Color'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col"><input class="ds-col-12" name="dssm-settings[font][color]" type="text" value="<?php echo (isset($dssm_settings['font']['color']) ? $dssm_settings['font']['color'] : ''); ?>" placeholder="#515151" /></div>
                                </div>
                                <div class="ds-row clearfix pt-1 pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Panel'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input id="panel" name="dssm-settings[font][panel]" type="checkbox" value="1"<?php echo (isset($dssm_settings['font']['panel']) ? ' checked="checked"' : ''); ?> />
                                    </div>
                                </div>
                                <div id="panelcolor" class="ds-row clearfix pt-1 pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Panel color'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input class="ds-col-12" name="dssm-settings[font][panelcolor]" type="text" value="<?php echo (isset($dssm_settings['font']['panelcolor']) ? $dssm_settings['font']['panelcolor'] : ''); ?>" placeholder="#000000ad" />
                                    </div>
                                </div>
                                <div class="ds-row clearfix pt-1 pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Text align'); ?>:</label>
                                    <div class="ds-col ds-col-9">
                                        <select class="ds-col-12" name="dssm-settings[font][align]">
                                            <?php foreach($aligns as $key => $align){ ?>
                                            <option<?php echo ' value="' . $align . '"' . (isset($dssm_settings['font']['align']) && $align == $dssm_settings['font']['align'] ? ' selected="selected"' : ''); ?>><?php echo ucfirst($key); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="ds-row clearfix pt-1 pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Message position'); ?>:</label>
                                    <div class="ds-col ds-col-9">
                                        <select class="ds-col-12" name="dssm-settings[font][pos]">
                                            <?php foreach($positions as $key => $pos){ ?>
                                                <option<?php echo ' value="' . $pos . '"' . (isset($dssm_settings['font']['pos']) && $pos == $dssm_settings['font']['pos'] ? ' selected="selected"' : ''); ?>><?php echo ucfirst($key); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-row clearfix">
                        <div class="ds-block ds-col ds-col-12 mt-1">
                            <label class="ds-block-title pt-2 pr-2 pb-2 pl-2<?php echo (isset($dssm_sections['styling-background']) ? ' expanded' : ''); ?>">
                                <h2 class="mt-0 mb-0">
                                    <span class="dashicons dashicons-admin-customizer"></span>
                                    <?php _e('Styling: Background'); ?>
                                    <span class="dashicons dashicons-arrow-right-alt2 floatright"></span>
                                    <span class="dashicons dashicons-arrow-down-alt2 floatright"></span>
                                </h2>
                                <input class="ds-section" name="dssm-sections[styling-background]" type="checkbox" value="1"<?php echo (isset($dssm_sections['styling-background']) ? ' checked="checked"' : ''); ?> />
                            </label>
                            <div class="pt-2 pr-2 pb-2 pl-2">
                                <div class="ds-row clearfix pb-1 border-bottom border-grey">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Color'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col"><input class="ds-col-12" name="dssm-settings[background][color]" type="text" value="<?php echo (isset($dssm_settings['background']['color']) ? $dssm_settings['background']['color'] : ''); ?>" placeholder="#fff" /></div>
                                </div>
                                <div class="ds-row clearfix pt-1">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Image'); ?>:</label>
                                    <div class="ds-col ds-col-9 ds-2col">
                                        <input id="use-background-image" type="checkbox" value="1"<?php echo (isset($dssm_settings['background']['image']) ? ' checked="checked"' : ''); ?> />
                                        <input id="image-name" name="dssm-settings[background][image][name]" type="hidden" value="<?php echo (isset($dssm_settings['background']['image']['name']) ? $dssm_settings['background']['image']['name'] : ''); ?>" />
                                        <input id="image-url" name="dssm-settings[background][image][url]" type="hidden" value="<?php echo (isset($dssm_settings['background']['image']['url']) ? $dssm_settings['background']['image']['url'] : ''); ?>" />
                                        <div id="image-picker" class="ds-row ds-row-auto-height pt-1 mt-1">
                                            <?php foreach($dssm_settings['background']['images'] as $type => $images){ ?>
                                                <?php foreach($images as $key => $image){ ?>
                                                <label<?php echo ($type == 'custom' ? ' id="custom-' . $key . '"' : ''); ?> class="image-radio ds-col ds-col-4 <?php echo $type; ?>">
                                                    <div class="remove">X</div>
                                                    <input name="dssm-settings[background][images][<?php echo $type; ?>][<?php echo $key; ?>][name]" type="hidden" value="<?php echo $image['name']; ?>" />
                                                    <input name="dssm-settings[background][images][<?php echo $type; ?>][<?php echo $key; ?>][url]" type="hidden" value="<?php echo $image['url']; ?>" />
                                                    <input type="radio"<?php echo (isset($dssm_settings['background']['image']) && $dssm_settings['background']['image']['name'] == $image['name'] ? ' checked="checked"' : ''); ?> />
                                                    <img width="100%" height="auto" src="<?php echo $image['url']; ?>" />
                                                </label>
                                                <?php } ?>
                                            <?php } ?>
                                            <button id="image-add" class="image-radio ds-col ds-col-4 mb-1" type="button">+ <?php _e('Upload Image'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-row clearfix">
                        <div class="ds-block ds-col ds-col-12 mt-1">
                            <label class="ds-block-title pt-2 pr-2 pb-2 pl-2<?php echo (isset($dssm_sections['styling-custom']) ? ' expanded' : ''); ?>">
                                <h2 class="mt-0 mb-0">
                                    <span class="dashicons dashicons-carrot"></span>
                                    <?php _e('Styling: Custom'); ?>
                                    <span class="dashicons dashicons-arrow-right-alt2 floatright"></span>
                                    <span class="dashicons dashicons-arrow-down-alt2 floatright"></span>
                                </h2>
                                <input class="ds-section" name="dssm-sections[styling-custom]" type="checkbox" value="1"<?php echo (isset($dssm_sections['styling-custom']) ? ' checked="checked"' : ''); ?> />
                            </label>
                            <div class="pt-2 pr-2 pb-2 pl-2">
                                <div class="ds-row clearfix">
                                    <label class="ds-col ds-col-3 ds-2col"><?php _e('Custom css'); ?>:</label>
                                    <div class="ds-col ds-col-9">
                                        <textarea name="dssm-settings[css][custom]" class="ds-col-12" rows="8"><?php echo (isset($dssm_settings['css']['custom']) ? $dssm_settings['css']['custom'] : ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ds-row clearfix">
                        <div class="ds-block ds-col ds-col-12 mt-1 pt-2 pr-2 pb-2 pl-2">
                            <?php submit_button('', 'button-primary button-hero'); ?>
                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>