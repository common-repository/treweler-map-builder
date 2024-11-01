<?php
/* Smarty version 3.1.48, created on 2023-10-26 08:01:20
  from 'C:\OSPanel\domains\wp.viepico\wp-content\plugins\treweler\includes\admin\views\templates\goto-pro-message.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_653a1cd0ba9e47_76746177',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ecd5a3c3be1944a633f491c82385d718a9f77e57' => 
    array (
      0 => 'C:\\OSPanel\\domains\\wp.viepico\\wp-content\\plugins\\treweler\\includes\\admin\\views\\templates\\goto-pro-message.tpl',
      1 => 1697526446,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_653a1cd0ba9e47_76746177 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['position']->value === 'tab') {?><div class="twer-gotopro-blank-tab"></div><?php }?>
<div class="twer-gotopro <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
    <div class="twer-gotopro__message">
        <div class="twer-gotopro__message__icon"><img src="<?php echo $_smarty_tpl->tpl_vars['icon']->value;?>
" alt=""></div>
        <div class="twer-gotopro__message__title"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</div>
        <div class="twer-gotopro__message__description"><p><?php echo $_smarty_tpl->tpl_vars['description']->value;?>
</p></div>
        <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value['url'];?>
" class="twer-gotopro__message__link" title="<?php echo $_smarty_tpl->tpl_vars['link']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['link']->value['title'];?>
</a>
    </div>
</div>
<?php }
}
