<?php
/* Smarty version 3.1.48, created on 2023-10-26 08:01:47
  from 'C:\OSPanel\domains\wp.viepico\wp-content\plugins\treweler\includes\admin\views\templates\settings.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_653a1cebb87df6_52623037',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bc331d5ba4a5953f094b4d487f3f3d275eb9b04c' => 
    array (
      0 => 'C:\\OSPanel\\domains\\wp.viepico\\wp-content\\plugins\\treweler\\includes\\admin\\views\\templates\\settings.tpl',
      1 => 1697526446,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_653a1cebb87df6_52623037 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="wrap">
    <h1><?php echo get_admin_page_title(null);?>
</h1>
    <hr class="wp-header-end">
    
        <?php echo settings_errors(null);?>

    
    <form method="post" action="options.php">
        <?php echo settings_fields('treweler-options');?>

        

        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-1">

                <div id="postbox-container-2" class="postbox-container">
                    <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                        <div class="postbox">
                            <div class="inside">

                                <div class="twer-root">
                                    <div class="twer-settings">
                                        <div class="twer-settings__body">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-3 col-lg-3 col-xl-2 pr-md-0">
                                                        <nav class="twer-tabs h-100">
                                                            <div class="nav nav-tabs" id="twer-nav-tab" role="tablist">

                                                                <a class="nav-link active" id="twer-nav-general-tab" data-toggle="tab" href="#twer-nav-general" role="tab" aria-controls="twer-nav-general" aria-selected="true">General</a>
                                                                <a class="nav-link" id="twer-nav-css-tab" data-toggle="tab" href="#twer-nav-css" role="tab" aria-controls="twer-nav-css" aria-selected="true">Additional CSS</a>

                                                            </div>
                                                        </nav>
                                                    </div>

                                                    <div class="col-md-9 col-lg-9 col-xl-10 pl-md-0">
                                                        <div class="tab-content" id="twer-nav-tabContent">
                                                            <div class="tab-pane show active" id="twer-nav-general" role="tabpanel" aria-labelledby="twer-nav-general-tab">

                                                                <div class="table-responsive">
                                                                    <?php echo twer_do_settings_sections('treweler-settings');?>

                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="twer-nav-css" role="tabpanel" aria-labelledby="twer-nav-popup-tab">
                                                                <textarea id="js-twer-editor-textarea" class="d-none" rows="30" cols="8" name="treweler[css]"><?php echo $_smarty_tpl->tpl_vars['css']->value;?>
</textarea>
                                                                <div id="js-twer-editor"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <br class="clear">
        </div>


        <?php echo submit_button(null);?>

    </form>
</div>
<?php }
}
