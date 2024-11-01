<?php
/* Smarty version 3.1.48, created on 2023-10-26 08:02:19
  from 'C:\OSPanel\domains\wp.viepico\wp-content\plugins\treweler\includes\admin\views\templates\fields.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_653a1d0b0b7b79_75961364',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '80982de7ca6725e0dfbc4f659d0c7e729a9332a4' => 
    array (
      0 => 'C:\\OSPanel\\domains\\wp.viepico\\wp-content\\plugins\\treweler\\includes\\admin\\views\\templates\\fields.tpl',
      1 => 1697549433,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:fields.tpl' => 2,
  ),
),false)) {
function content_653a1d0b0b7b79_75961364 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\OSPanel\\domains\\wp.viepico\\wp-content\\plugins\\treweler\\includes\\admin\\views\\plugins\\function.html_options_extended.php','function'=>'smarty_function_html_options_extended',),1=>array('file'=>'C:\\OSPanel\\domains\\wp.viepico\\wp-content\\plugins\\treweler\\includes\\admin\\views\\plugins\\function.html_select_extended.php','function'=>'smarty_function_html_select_extended',),2=>array('file'=>'C:\\OSPanel\\domains\\wp.viepico\\wp-content\\plugins\\treweler\\includes\\admin\\views\\plugins\\function.html_checkboxes_extended.php','function'=>'smarty_function_html_checkboxes_extended',),3=>array('file'=>'C:\\OSPanel\\domains\\wp.viepico\\wp-content\\plugins\\treweler\\includes\\admin\\views\\plugins\\function.html_radios_extended.php','function'=>'smarty_function_html_radios_extended',),));
if ('divider' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
    <div class="w-100" <?php echo $_smarty_tpl->tpl_vars['field']->value['style'];?>
></div>
<?php } elseif ('hidden' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
    <input type="hidden" id="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
">
<?php } else { ?>
    <div class="<?php echo $_smarty_tpl->tpl_vars['field']->value['group_class'];?>
">

        <?php if ('select' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['label_inline'])) {?>
                <label for="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_inline'];?>
</label>
            <?php }?>
            <?php if (in_array('multiple',$_smarty_tpl->tpl_vars['field']->value['atts'])) {?>
                <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" value="" <?php echo implode(' ',$_smarty_tpl->tpl_vars['field']->value['atts']);?>
>
                <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['field']) ? $_smarty_tpl->tpl_vars['field']->value : array();
if (!(is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess)) {
settype($_tmp_array, 'array');
}
$_tmp_array['name'] = ((string)$_smarty_tpl->tpl_vars['field']->value['name'])."[]";
$_smarty_tpl->_assignInScope('field', $_tmp_array);?>
                <?php if (in_array('disabled',$_smarty_tpl->tpl_vars['field']->value['atts'])) {?>
                    <?php echo smarty_function_html_options_extended(array('option_hidden'=>$_smarty_tpl->tpl_vars['field']->value['option_hidden'],'option_disabled'=>$_smarty_tpl->tpl_vars['field']->value['option_disabled'],'id'=>$_smarty_tpl->tpl_vars['field']->value['id'],'class'=>$_smarty_tpl->tpl_vars['field']->value['class'],'name'=>$_smarty_tpl->tpl_vars['field']->value['name'],'options'=>$_smarty_tpl->tpl_vars['field']->value['options'],'selected'=>$_smarty_tpl->tpl_vars['field']->value['selected'],'disabled'=>"disabled",'multiple'=>"multipe"),$_smarty_tpl);?>

                <?php } else { ?>
                <?php echo smarty_function_html_options_extended(array('option_hidden'=>$_smarty_tpl->tpl_vars['field']->value['option_hidden'],'option_disabled'=>$_smarty_tpl->tpl_vars['field']->value['option_disabled'],'id'=>$_smarty_tpl->tpl_vars['field']->value['id'],'class'=>$_smarty_tpl->tpl_vars['field']->value['class'],'name'=>$_smarty_tpl->tpl_vars['field']->value['name'],'options'=>$_smarty_tpl->tpl_vars['field']->value['options'],'selected'=>$_smarty_tpl->tpl_vars['field']->value['selected'],'multiple'=>"multipe"),$_smarty_tpl);?>

                <?php }?>
            <?php } else { ?>
                <?php echo smarty_function_html_options_extended(array('option_hidden'=>$_smarty_tpl->tpl_vars['field']->value['option_hidden'],'option_disabled'=>$_smarty_tpl->tpl_vars['field']->value['option_disabled'],'id'=>$_smarty_tpl->tpl_vars['field']->value['id'],'class'=>$_smarty_tpl->tpl_vars['field']->value['class'],'name'=>$_smarty_tpl->tpl_vars['field']->value['name'],'options'=>$_smarty_tpl->tpl_vars['field']->value['options'],'selected'=>$_smarty_tpl->tpl_vars['field']->value['selected']),$_smarty_tpl);?>

            <?php }?>

            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['spinner'])) {?><span class="twer-input-spinner position-absolute spinner m-0"></span><?php }?>
        <?php }?>

        <?php if ('selectNew' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['label_inline'])) {?>
                <label for="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_inline'];?>
</label>
            <?php }?>

            <?php echo smarty_function_html_select_extended(array('id'=>$_smarty_tpl->tpl_vars['field']->value['id'],'class'=>$_smarty_tpl->tpl_vars['field']->value['class'],'name'=>$_smarty_tpl->tpl_vars['field']->value['name'],'options'=>$_smarty_tpl->tpl_vars['field']->value['options'],'selected'=>$_smarty_tpl->tpl_vars['field']->value['selected'],'multiple'=>$_smarty_tpl->tpl_vars['field']->value['isMultiple']),$_smarty_tpl);?>

        <?php }?>



        <?php if ($_smarty_tpl->tpl_vars['field']->value['type'] === 'text' || $_smarty_tpl->tpl_vars['field']->value['type'] === 'url' || $_smarty_tpl->tpl_vars['field']->value['type'] === 'tel' || $_smarty_tpl->tpl_vars['field']->value['type'] === 'email' || $_smarty_tpl->tpl_vars['field']->value['type'] === 'number') {?>
            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['label_inline'])) {?>
                <label for="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_inline'];?>
</label>
            <?php }?>



            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['append'])) {?><div class="input-group flex-nowrap input-group-sm"><?php }?>
            <input type="<?php echo $_smarty_tpl->tpl_vars['field']->value['type'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['field']->value['class'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
" placeholder="<?php echo $_smarty_tpl->tpl_vars['field']->value['placeholder'];?>
" <?php echo implode(' ',$_smarty_tpl->tpl_vars['field']->value['atts']);?>
>
            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['append'])) {?>
                <div class="input-group-append">
                    <span class="input-group-text"><?php echo $_smarty_tpl->tpl_vars['field']->value['append'];?>
</span>
                </div>
            <?php }?>

            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['append'])) {?></div><?php }?>

            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['help'])) {?>
                <a href="#" class="twer-help-tooltip" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['field']->value['help'];?>
"><span class="dashicons dashicons-editor-help"></span></a>
            <?php }?>

            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['spinner'])) {?><span class="twer-input-spinner position-absolute spinner m-0"></span><?php }?>



        <?php }?>

        <?php if ('textarea' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <textarea class="<?php echo $_smarty_tpl->tpl_vars['field']->value['class'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
" placeholder="<?php echo $_smarty_tpl->tpl_vars['field']->value['placeholder'];?>
" <?php echo implode(' ',$_smarty_tpl->tpl_vars['field']->value['atts']);?>
><?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
</textarea>
        <?php }?>



        <?php if ('range' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <input type="range" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
" class="custom-range <?php echo $_smarty_tpl->tpl_vars['field']->value['class'];?>
" <?php echo implode(' ',$_smarty_tpl->tpl_vars['field']->value['atts']);?>
>
        <?php }?>

        <?php if ('checkbox' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <?php if ('default' === $_smarty_tpl->tpl_vars['field']->value['style']) {?>
                <div class="form-check">
                    <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" value="" <?php echo implode(' ',$_smarty_tpl->tpl_vars['field']->value['atts']);?>
>
                    <?php echo smarty_function_html_checkboxes_extended(array('id'=>$_smarty_tpl->tpl_vars['field']->value['id'],'name'=>$_smarty_tpl->tpl_vars['field']->value['name'],'class'=>"form-check-input",'labels'=>false,'values'=>array(true),'checked'=>$_smarty_tpl->tpl_vars['field']->value['checked']),$_smarty_tpl);?>

                    <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['label_inline'])) {?>
                        <label class="form-check-label" for="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
">
                            <?php echo $_smarty_tpl->tpl_vars['field']->value['label_inline'];?>

                        </label>
                    <?php }?>
                </div>
            <?php } else { ?>
                <label for="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['field']->value['class'];?>
">
                    <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" value="" <?php echo implode(' ',$_smarty_tpl->tpl_vars['field']->value['atts']);?>
>
                    <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['label_inline'])) {?>
                        <span class="twer-switcher__label"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_inline'];?>
</span>
                    <?php }?>
                    <span class="twer-switcher__inner">
                        <?php if (in_array('disabled',$_smarty_tpl->tpl_vars['field']->value['atts'])) {?>
                            <?php echo smarty_function_html_checkboxes_extended(array('id'=>$_smarty_tpl->tpl_vars['field']->value['id'],'name'=>$_smarty_tpl->tpl_vars['field']->value['name'],'labels'=>false,'values'=>array(true),'checked'=>$_smarty_tpl->tpl_vars['field']->value['checked'],'disabled'=>"disabled"),$_smarty_tpl);?>

                        <?php } else { ?>
                            <?php echo smarty_function_html_checkboxes_extended(array('id'=>$_smarty_tpl->tpl_vars['field']->value['id'],'name'=>$_smarty_tpl->tpl_vars['field']->value['name'],'labels'=>false,'values'=>array(true),'checked'=>$_smarty_tpl->tpl_vars['field']->value['checked']),$_smarty_tpl);?>

                        <?php }?>
                        <span class="twer-switcher__slider"></span>
                    </span>
                </label>
            <?php }?>
        <?php }?>

        <?php if ('colorpicker' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['label_inline'])) {?>
                <label for="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_inline'];?>
</label>
            <?php }?>
            <div class="twer-colorpicker js-twer-colorpicker">
                <input type="hidden" class="js-twer-colorpicker-color" id="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
">
                <input type="hidden" class="js-twer-colorpicker-custom-color" name="default_color" value="<?php echo $_smarty_tpl->tpl_vars['field']->value['custom_colors'];?>
">
                <button type="button" class="btn btn-sm btn-outline-dark js-twer-color-picker-btn"><span class="twer-colorpicker__cell-color js-twer-colorpicker-cell" style="background-color: <?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
;"></span><?php echo $_smarty_tpl->tpl_vars['field']->value['label_colorpicker'];?>
</button>
                <div class="twer-colorpicker__palette js-twer-colorpicker-palette" acp-palette="<?php echo $_smarty_tpl->tpl_vars['field']->value['extends_colors'];?>
" data-default-palette="<?php echo $_smarty_tpl->tpl_vars['field']->value['colors'];?>
"></div>
            </div>

            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['note'])) {?>
                <p class="twer-note"><?php echo $_smarty_tpl->tpl_vars['field']->value['note'];?>
</p>
            <?php }?>
        <?php }?>

        <?php if ('iconpicker' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" hidden class="js-twer-iconpicker <?php echo $_smarty_tpl->tpl_vars['field']->value['class'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
">
        <?php }?>

        <?php if ('file' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <div class="twer-form-group">
                <div class="twer-gpx-upload-panel" id="js-twer-gpx-upload-panel">
                    <p class="hide-if-no-js" id="js-twer-attach-container"
                       style="display: none">
                        <button type="button" class="twer-attach__add-file" id="js-twer-attach__add-file" style="display: none"><a href="#add" id="js-twer-gpx-upload"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_image_add'];?>
</a></button>
                    </p>

                    <div class="twer-attach__actions js-twer-attach-actions"
                         style="display: none;" id="js-twer-attach-actions">
                        <button type="button" class="button js-twer-attach-remove" id="js-twer-attach-remove"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_image_remove'];?>
</button>
                        <button type="button" class="button js-twer-attach-add" id="js-twer-attach-change"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_image_change'];?>
</button>
                    </div>
                </div>
            </div>
            <div class="trew-error-message" id="gpxErrorMessage" style="display: none">
                This type of GPX file is not supported.
            </div>
        <?php }?>

        <?php if ('image' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <div class="twer-attach js-twer-attach-wrap">

                <div class="twer-attach__thumb js-twer-attach-thumb">
                    <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['image'])) {?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['field']->value['image'];?>
" alt="">
                    <?php }?>
                    <button type="button" class="btn btn-outline-light twer-attach__add-media js-twer-attach-add" style="<?php if (!empty($_smarty_tpl->tpl_vars['field']->value['value'])) {?>display:none;<?php } else { ?>display:block;<?php }?>"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_image_add'];?>
</button>
                    <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
">
                </div>

                <div class="twer-attach__actions js-twer-attach-actions" style="<?php if (!empty($_smarty_tpl->tpl_vars['field']->value['value'])) {?>display:block;<?php } else { ?>display:none;<?php }?>">
                    <button type="button" class="button js-twer-attach-remove"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_image_remove'];?>
</button>
                    <button type="button" class="button js-twer-attach-add"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_image_change'];?>
</button>
                </div>
            </div>
        <?php }?>

        <?php if ('gallery' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <div class="twer-attach-gallery js-twer-attach-gallery-wrap">
                <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['gallery_images'])) {?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['gallery_images'], 'thumb');
$_smarty_tpl->tpl_vars['thumb']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['thumb']->key => $_smarty_tpl->tpl_vars['thumb']->value) {
$_smarty_tpl->tpl_vars['thumb']->do_else = false;
$__foreach_thumb_7_saved = $_smarty_tpl->tpl_vars['thumb'];
?>
                        <div class="twer-attach-gallery__thumb" data-id="<?php echo $_smarty_tpl->tpl_vars['thumb']->value;?>
">
                            <a href="#" class="twer-attach-gallery__remove js-twer-attach-gallery-remove" title="<?php echo $_smarty_tpl->tpl_vars['field']->value['label_image_remove'];?>
"></a>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['thumb']->key;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['thumb']->value;?>
">
                        </div>
                    <?php
$_smarty_tpl->tpl_vars['thumb'] = $__foreach_thumb_7_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                <?php }?>
                <button type="button" class="btn btn-outline-light twer-attach-gallery__add-media js-twer-attach-gallery-add"></button>
                <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
">
            </div>
        <?php }?>

        <?php if ('button' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <button type="button" class="<?php echo $_smarty_tpl->tpl_vars['field']->value['class'];?>
"><?php echo $_smarty_tpl->tpl_vars['field']->value['label_inline'];?>
</button>
        <?php }?>

        <?php if ('radios' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <?php echo smarty_function_html_radios_extended(array('name'=>$_smarty_tpl->tpl_vars['field']->value['name'],'atts'=>$_smarty_tpl->tpl_vars['field']->value['atts'],'options'=>$_smarty_tpl->tpl_vars['field']->value['options'],'label_ids'=>$_smarty_tpl->tpl_vars['field']->value['label_ids'],'selected'=>$_smarty_tpl->tpl_vars['field']->value['selected'],'separator'=>$_smarty_tpl->tpl_vars['field']->value['separator']),$_smarty_tpl);?>

        <?php }?>

        <?php if ('html' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
            <?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>

        <?php }?>


        <?php if ((isset($_smarty_tpl->tpl_vars['field']->value['extra']))) {?>
            <div class="form-extra d-none">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['extra'], 'extra');
$_smarty_tpl->tpl_vars['extra']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['extra']->value) {
$_smarty_tpl->tpl_vars['extra']->do_else = false;
?>
                    <?php $_smarty_tpl->_subTemplateRender('file:fields.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field'=>$_smarty_tpl->tpl_vars['extra']->value), 0, true);
?>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </div>
        <?php }?>
    </div>

    <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['bottom_note'])) {?>
        <div class="w-100"></div>

            <div class="col-12">
                <p style="font-size: 14px; margin-bottom: 0; margin-top: -1px;" class="description"><?php echo $_smarty_tpl->tpl_vars['field']->value['bottom_note'];?>
</p>
            </div>
    <?php }
}
}
}
