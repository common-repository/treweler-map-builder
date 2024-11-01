<?php
/* Smarty version 3.1.48, created on 2023-10-26 08:02:19
  from 'C:\OSPanel\domains\wp.viepico\wp-content\plugins\treweler\includes\admin\views\templates\table.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_653a1d0b059998_92150673',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d3e57c169e433ec741a90b5f51cfc13e5c6b7f1' => 
    array (
      0 => 'C:\\OSPanel\\domains\\wp.viepico\\wp-content\\plugins\\treweler\\includes\\admin\\views\\templates\\table.tpl',
      1 => 1697526446,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:fields.tpl' => 2,
  ),
),false)) {
function content_653a1d0b059998_92150673 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="table-responsive">
    <table class="<?php echo $_smarty_tpl->tpl_vars['settings']->value['table_class'];?>
">
        <tbody>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fields']->value, 'field');
$_smarty_tpl->tpl_vars['field']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->do_else = false;
?>
            <tr data-row-id="<?php echo $_smarty_tpl->tpl_vars['field']->value['row_id'];?>
" <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['row_class'])) {?>class="<?php echo $_smarty_tpl->tpl_vars['field']->value['row_class'];?>
"<?php }?> <?php echo $_smarty_tpl->tpl_vars['field']->value['row_atts'];?>
>
                <?php if ($_smarty_tpl->tpl_vars['field']->value['type'] === 'message') {?>
                    <td class="<?php echo $_smarty_tpl->tpl_vars['settings']->value['table_td_class'];?>
" <?php echo $_smarty_tpl->tpl_vars['field']->value['style'];?>
><?php echo $_smarty_tpl->tpl_vars['field']->value['value'];?>
</td>
                <?php } else { ?>
                    <?php if ((isset($_smarty_tpl->tpl_vars['field']->value['label']))) {?>
                        <th class="<?php echo $_smarty_tpl->tpl_vars['settings']->value['table_th_class'];?>
 <?php echo $_smarty_tpl->tpl_vars['field']->value['labelThClass'];?>
">
                            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['label'])) {?>
                                <div class="twer-cell__label">
                                <?php if ('group' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
                                    <?php echo $_smarty_tpl->tpl_vars['field']->value['label'];?>

                                <?php } else { ?>
                                    <label for="<?php echo $_smarty_tpl->tpl_vars['field']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['field']->value['label'];?>
</label>
                                <?php }?>

                                    <?php if ($_smarty_tpl->tpl_vars['field']->value['labelThDescription']) {?><div class="twer-cell__description"><?php echo $_smarty_tpl->tpl_vars['field']->value['labelThDescription'];?>
</div><?php }?>
                                </div>
                            <?php }?>
                        </th>
                    <?php }?>
                    <td class="<?php echo $_smarty_tpl->tpl_vars['settings']->value['table_td_class'];?>
">
                        <div class="form-row align-items-stretch">
                            <?php if ('group' === $_smarty_tpl->tpl_vars['field']->value['type']) {?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['group'], 'field_in_group');
$_smarty_tpl->tpl_vars['field_in_group']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['field_in_group']->value) {
$_smarty_tpl->tpl_vars['field_in_group']->do_else = false;
?>
                                    <?php $_smarty_tpl->_subTemplateRender('file:fields.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field'=>$_smarty_tpl->tpl_vars['field_in_group']->value), 0, true);
?>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php } else { ?>
                                <?php $_smarty_tpl->_subTemplateRender('file:fields.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field'=>$_smarty_tpl->tpl_vars['field']->value), 0, true);
?>
                            <?php }?>

                            <?php if (!empty($_smarty_tpl->tpl_vars['field']->value['row_controls'])) {?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['field']->value['row_controls'], 'control');
$_smarty_tpl->tpl_vars['control']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['control']->value) {
$_smarty_tpl->tpl_vars['control']->do_else = false;
?>
                                    <?php echo $_smarty_tpl->tpl_vars['control']->value;?>

                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php }?>
                        </div>
                    </td>
                <?php }?>
            </tr>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
</div>
<?php }
}
