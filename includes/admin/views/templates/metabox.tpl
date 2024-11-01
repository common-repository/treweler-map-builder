<div class="twer-root" id="{$settings.root_id}">
    <div class="twer-settings">
        <div class="twer-settings__body">
            <div class="container-fluid p-0">
                <div class="row">
                    {if !empty($tabs) }
                        <div class="col-md-3 col-lg-3 col-xl-2 pr-md-0">
                            <nav class="twer-tabs h-100">
                                <div class="nav nav-tabs" id="twer-nav-tab" role="tablist">
                                    {foreach $tabs as $tab}
                                        <a class="nav-link {if $tab@first}active{/if}" id="twer-nav-{$tab@key}-tab" data-toggle="tab"
                                           href="#twer-nav-{$tab@key}" role="tab" aria-controls="twer-nav-{$tab@key}"
                                           aria-selected="{if $tab@first}true{else}false{/if}">{$tab}</a>
                                    {/foreach}
                                </div>
                            </nav>
                        </div>
                    {/if}

                    {if !empty($tabs) }
                        <div class="col-md-9 col-lg-9 col-xl-10 pl-md-0">
                            <div class="tab-content" id="twer-nav-tabContent">
                                {foreach $fields as $tab_fields}
                                    <div class="tab-pane {if $tab_fields@first}show active{/if}" id="twer-nav-{$tab_fields@key}" role="tabpanel" aria-labelledby="twer-nav-{$tab_fields@key}-tab">

                                        {if !empty($nestedTabs) && $tab_fields@key === $nestedTabs.rootTab}
                                            <nav class="twer-tabs twer-tabs--horizontal">
                                                <div class="nav nav-tabs" id="twer-nav-tab-nested" role="tablist">
                                                    {foreach $nestedTabs.tabs as $tab}
                                                        <a class="nav-link {if $tab@first}active{/if}" id="twer-nav-{$tab@key}-tab" data-toggle="tab"
                                                           href="#twer-nav-{$tab@key}" role="tab" aria-controls="twer-nav-{$tab@key}"
                                                           aria-selected="{if $tab@first}true{else}false{/if}">{$tab}</a>
                                                    {/foreach}
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="twer-nav-tabNestedContent">
                                                {foreach $nestedFields as $tab_fields1}
                                                    <div class="tab-pane {if $tab_fields1@first}show active{/if}" id="twer-nav-{$tab_fields1@key}" role="tabpanel" aria-labelledby="twer-nav-{$tab_fields1@key}-tab">
                                                        {include file='table.tpl' fields=$tab_fields1 settings=$settings}
                                                    </div>
                                                {/foreach}
                                            </div>
                                        {else}
                                            {include file='table.tpl' fields=$tab_fields settings=$settings}
                                        {/if}
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    {else}
                        <div class="col-12">
                            {include file='table.tpl' fields=$fields settings=$settings}
                        </div>
                    {/if}

                </div>
            </div>
        </div>
    </div>
</div>

