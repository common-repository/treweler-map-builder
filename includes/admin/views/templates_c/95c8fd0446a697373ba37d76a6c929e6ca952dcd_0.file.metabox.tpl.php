<?php
/* Smarty version 3.1.48, created on 2023-10-26 08:02:19
  from 'C:\OSPanel\domains\wp.viepico\wp-content\plugins\treweler\includes\admin\views\templates\metabox.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_653a1d0b032c92_07861068',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '95c8fd0446a697373ba37d76a6c929e6ca952dcd' => 
    array (
      0 => 'C:\\OSPanel\\domains\\wp.viepico\\wp-content\\plugins\\treweler\\includes\\admin\\views\\templates\\metabox.tpl',
      1 => 1697526446,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:table.tpl' => 3,
  ),
),false)) {
function content_653a1d0b032c92_07861068 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="twer-root" id="<?php echo $_smarty_tpl->tpl_vars['settings']->value['root_id'];?>
">
    <div class="twer-settings">
        <div class="twer-settings__body">
            <div class="container-fluid p-0">
                <div class="row">
                    <?php if (!empty($_smarty_tpl->tpl_vars['tabs']->value)) {?>
                        <div class="col-md-3 col-lg-3 col-xl-2 pr-md-0">
                            <nav class="twer-tabs h-100">
                                <div class="nav nav-tabs" id="twer-nav-tab" role="tablist">
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tabs']->value, 'tab');
$_smarty_tpl->tpl_vars['tab']->index = -1;
$_smarty_tpl->tpl_vars['tab']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value) {
$_smarty_tpl->tpl_vars['tab']->do_else = false;
$_smarty_tpl->tpl_vars['tab']->index++;
$_smarty_tpl->tpl_vars['tab']->first = !$_smarty_tpl->tpl_vars['tab']->index;
$__foreach_tab_0_saved = $_smarty_tpl->tpl_vars['tab'];
?>
                                        <a class="nav-link <?php if ($_smarty_tpl->tpl_vars['tab']->first) {?>active<?php }?>" id="twer-nav-<?php echo $_smarty_tpl->tpl_vars['tab']->key;?>
-tab" data-toggle="tab"
                                           href="#twer-nav-<?php echo $_smarty_tpl->tpl_vars['tab']->key;?>
" role="tab" aria-controls="twer-nav-<?php echo $_smarty_tpl->tpl_vars['tab']->key;?>
"
                                           aria-selected="<?php if ($_smarty_tpl->tpl_vars['tab']->first) {?>true<?php } else { ?>false<?php }?>"><?php echo $_smarty_tpl->tpl_vars['tab']->value;?>
</a>
                                    <?php
$_smarty_tpl->tpl_vars['tab'] = $__foreach_tab_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                </div>
                            </nav>
                        </div>
                    <?php }?>

                    <?php if (!empty($_smarty_tpl->tpl_vars['tabs']->value)) {?>
                        <div class="col-md-9 col-lg-9 col-xl-10 pl-md-0">
                            <div class="tab-content" id="twer-nav-tabContent">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fields']->value, 'tab_fields');
$_smarty_tpl->tpl_vars['tab_fields']->index = -1;
$_smarty_tpl->tpl_vars['tab_fields']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['tab_fields']->key => $_smarty_tpl->tpl_vars['tab_fields']->value) {
$_smarty_tpl->tpl_vars['tab_fields']->do_else = false;
$_smarty_tpl->tpl_vars['tab_fields']->index++;
$_smarty_tpl->tpl_vars['tab_fields']->first = !$_smarty_tpl->tpl_vars['tab_fields']->index;
$__foreach_tab_fields_1_saved = $_smarty_tpl->tpl_vars['tab_fields'];
?>
                                    <div class="tab-pane <?php if ($_smarty_tpl->tpl_vars['tab_fields']->first) {?>show active<?php }?>" id="twer-nav-<?php echo $_smarty_tpl->tpl_vars['tab_fields']->key;?>
" role="tabpanel" aria-labelledby="twer-nav-<?php echo $_smarty_tpl->tpl_vars['tab_fields']->key;?>
-tab">

                                        <?php if (!empty($_smarty_tpl->tpl_vars['nestedTabs']->value) && $_smarty_tpl->tpl_vars['tab_fields']->key === $_smarty_tpl->tpl_vars['nestedTabs']->value['rootTab']) {?>
                                            <nav class="twer-tabs twer-tabs--horizontal">
                                                <div class="nav nav-tabs" id="twer-nav-tab-nested" role="tablist">
                                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['nestedTabs']->value['tabs'], 'tab');
$_smarty_tpl->tpl_vars['tab']->index = -1;
$_smarty_tpl->tpl_vars['tab']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value) {
$_smarty_tpl->tpl_vars['tab']->do_else = false;
$_smarty_tpl->tpl_vars['tab']->index++;
$_smarty_tpl->tpl_vars['tab']->first = !$_smarty_tpl->tpl_vars['tab']->index;
$__foreach_tab_2_saved = $_smarty_tpl->tpl_vars['tab'];
?>
                                                        <a class="nav-link <?php if ($_smarty_tpl->tpl_vars['tab']->first) {?>active<?php }?>" id="twer-nav-<?php echo $_smarty_tpl->tpl_vars['tab']->key;?>
-tab" data-toggle="tab"
                                                           href="#twer-nav-<?php echo $_smarty_tpl->tpl_vars['tab']->key;?>
" role="tab" aria-controls="twer-nav-<?php echo $_smarty_tpl->tpl_vars['tab']->key;?>
"
                                                           aria-selected="<?php if ($_smarty_tpl->tpl_vars['tab']->first) {?>true<?php } else { ?>false<?php }?>"><?php echo $_smarty_tpl->tpl_vars['tab']->value;?>
</a>
                                                    <?php
$_smarty_tpl->tpl_vars['tab'] = $__foreach_tab_2_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="twer-nav-tabNestedContent">
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['nestedFields']->value, 'tab_fields1');
$_smarty_tpl->tpl_vars['tab_fields1']->index = -1;
$_smarty_tpl->tpl_vars['tab_fields1']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['tab_fields1']->key => $_smarty_tpl->tpl_vars['tab_fields1']->value) {
$_smarty_tpl->tpl_vars['tab_fields1']->do_else = false;
$_smarty_tpl->tpl_vars['tab_fields1']->index++;
$_smarty_tpl->tpl_vars['tab_fields1']->first = !$_smarty_tpl->tpl_vars['tab_fields1']->index;
$__foreach_tab_fields1_3_saved = $_smarty_tpl->tpl_vars['tab_fields1'];
?>
                                                    <div class="tab-pane <?php if ($_smarty_tpl->tpl_vars['tab_fields1']->first) {?>show active<?php }?>" id="twer-nav-<?php echo $_smarty_tpl->tpl_vars['tab_fields1']->key;?>
" role="tabpanel" aria-labelledby="twer-nav-<?php echo $_smarty_tpl->tpl_vars['tab_fields1']->key;?>
-tab">
                                                        <?php $_smarty_tpl->_subTemplateRender('file:table.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('fields'=>$_smarty_tpl->tpl_vars['tab_fields1']->value,'settings'=>$_smarty_tpl->tpl_vars['settings']->value), 0, true);
?>
                                                    </div>
                                                <?php
$_smarty_tpl->tpl_vars['tab_fields1'] = $__foreach_tab_fields1_3_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                            </div>
                                        <?php } else { ?>
                                            <?php $_smarty_tpl->_subTemplateRender('file:table.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('fields'=>$_smarty_tpl->tpl_vars['tab_fields']->value,'settings'=>$_smarty_tpl->tpl_vars['settings']->value), 0, true);
?>
                                        <?php }?>
                                    </div>
                                <?php
$_smarty_tpl->tpl_vars['tab_fields'] = $__foreach_tab_fields_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-12">
                            <?php $_smarty_tpl->_subTemplateRender('file:table.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('fields'=>$_smarty_tpl->tpl_vars['fields']->value,'settings'=>$_smarty_tpl->tpl_vars['settings']->value), 0, true);
?>
                        </div>
                    <?php }?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php }
}
