{* $smarty.now|date_format:'%Y-%m-%d %H:%M:%S' *}
<div class="wrap">
    <h1>{null|get_admin_page_title}</h1>
    <hr class="wp-header-end">
    {nocache}
        {null|settings_errors}
    {/nocache}
    <form method="post" action="options.php">
        {'treweler-options'|settings_fields}
        

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
                                                                    {'treweler-settings'|twer_do_settings_sections}
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="twer-nav-css" role="tabpanel" aria-labelledby="twer-nav-popup-tab">
                                                                <textarea id="js-twer-editor-textarea" class="d-none" rows="30" cols="8" name="treweler[css]">{$css}</textarea>
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


        {null|submit_button}
    </form>
</div>
