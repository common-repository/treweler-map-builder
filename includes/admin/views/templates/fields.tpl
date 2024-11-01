{if 'divider' === $field.type}
    <div class="w-100" {$field.style}></div>
{elseif 'hidden' === $field.type}
    <input type="hidden" id="{$field.id}" name="{$field.name}" value="{$field.value}">
{else}
    <div class="{$field.group_class}">

        {if 'select' === $field.type}
            {if !empty($field.label_inline)}
                <label for="{$field.id}">{$field.label_inline}</label>
            {/if}
            {if in_array('multiple', $field.atts)}
                <input type="hidden" name="{$field.name}" value="" {' '|implode:$field.atts}>
                {$field.name="`$field.name`[]"}
                {if in_array('disabled', $field.atts)}
                    {html_options_extended option_hidden=$field.option_hidden option_disabled=$field.option_disabled id=$field.id class=$field.class name=$field.name options=$field.options selected=$field.selected disabled="disabled" multiple="multipe"}
                {else}
                {html_options_extended option_hidden=$field.option_hidden option_disabled=$field.option_disabled id=$field.id class=$field.class name=$field.name options=$field.options selected=$field.selected multiple="multipe"}
                {/if}
            {else}
                {html_options_extended option_hidden=$field.option_hidden option_disabled=$field.option_disabled id=$field.id class=$field.class name=$field.name options=$field.options selected=$field.selected}
            {/if}

            {if !empty($field.spinner)}<span class="twer-input-spinner position-absolute spinner m-0"></span>{/if}
        {/if}

        {if 'selectNew' === $field.type}
            {if !empty($field.label_inline)}
                <label for="{$field.id}">{$field.label_inline}</label>
            {/if}

            {html_select_extended id=$field.id class=$field.class name=$field.name options=$field.options selected=$field.selected multiple=$field.isMultiple}
        {/if}



        {if $field.type === 'text' || $field.type === 'url' || $field.type === 'tel' || $field.type === 'email' || $field.type === 'number'}
            {if !empty($field.label_inline)}
                <label for="{$field.id}">{$field.label_inline}</label>
            {/if}



            {if !empty($field.append)}<div class="input-group flex-nowrap input-group-sm">{/if}
            <input type="{$field.type}" class="{$field.class}" id="{$field.id}" name="{$field.name}" value="{$field.value}" placeholder="{$field.placeholder}" {' '|implode:$field.atts}>
            {if !empty($field.append)}
                <div class="input-group-append">
                    <span class="input-group-text">{$field.append}</span>
                </div>
            {/if}

            {if !empty($field.append)}</div>{/if}

            {if !empty($field.help)}
                <a href="#" class="twer-help-tooltip" data-toggle="tooltip" title="{$field.help}"><span class="dashicons dashicons-editor-help"></span></a>
            {/if}

            {if !empty($field.spinner)}<span class="twer-input-spinner position-absolute spinner m-0"></span>{/if}



        {/if}

        {if 'textarea' === $field.type}
            <textarea class="{$field.class}" name="{$field.name}" id="{$field.id}" placeholder="{$field.placeholder}" {' '|implode:$field.atts}>{$field.value}</textarea>
        {/if}



        {if 'range' === $field.type}
            <input type="range" name="{$field.name}" id="{$field.id}" value="{$field.value}" class="custom-range {$field.class}" {' '|implode:$field.atts}>
        {/if}

        {if 'checkbox' === $field.type}
            {if 'default' === $field.style}
                <div class="form-check">
                    <input type="hidden" name="{$field.name}" value="" {' '|implode:$field.atts}>
                    {html_checkboxes_extended id=$field.id name=$field.name class="form-check-input" labels=false values=[true] checked=$field.checked}
                    {if !empty($field.label_inline)}
                        <label class="form-check-label" for="{$field.id}">
                            {$field.label_inline}
                        </label>
                    {/if}
                </div>
            {else}
                <label for="{$field.id}" class="{$field.class}">
                    <input type="hidden" name="{$field.name}" value="" {' '|implode:$field.atts}>
                    {if !empty($field.label_inline)}
                        <span class="twer-switcher__label">{$field.label_inline}</span>
                    {/if}
                    <span class="twer-switcher__inner">
                        {if in_array('disabled', $field.atts)}
                            {html_checkboxes_extended id=$field.id name=$field.name labels=false values=[true] checked=$field.checked disabled="disabled"}
                        {else}
                            {html_checkboxes_extended id=$field.id name=$field.name labels=false values=[true] checked=$field.checked}
                        {/if}
                        <span class="twer-switcher__slider"></span>
                    </span>
                </label>
            {/if}
        {/if}

        {if 'colorpicker' === $field.type}
            {if !empty($field.label_inline)}
                <label for="{$field.id}">{$field.label_inline}</label>
            {/if}
            <div class="twer-colorpicker js-twer-colorpicker">
                <input type="hidden" class="js-twer-colorpicker-color" id="{$field.id}" name="{$field.name}" value="{$field.value}">
                <input type="hidden" class="js-twer-colorpicker-custom-color" name="default_color" value="{$field.custom_colors}">
                <button type="button" class="btn btn-sm btn-outline-dark js-twer-color-picker-btn"><span class="twer-colorpicker__cell-color js-twer-colorpicker-cell" style="background-color: {$field.value};"></span>{$field.label_colorpicker}</button>
                <div class="twer-colorpicker__palette js-twer-colorpicker-palette" acp-palette="{$field.extends_colors}" data-default-palette="{$field.colors}"></div>
            </div>

            {if !empty($field.note)}
                <p class="twer-note">{$field.note}</p>
            {/if}
        {/if}

        {if 'iconpicker' === $field.type}
            <input type="text" name="{$field.name}" hidden class="js-twer-iconpicker {$field.class}" id="{$field.id}" value="{$field.value}">
        {/if}

        {if 'file' === $field.type}
            <div class="twer-form-group">
                <div class="twer-gpx-upload-panel" id="js-twer-gpx-upload-panel">
                    <p class="hide-if-no-js" id="js-twer-attach-container"
                       style="display: none">
                        <button type="button" class="twer-attach__add-file" id="js-twer-attach__add-file" style="display: none"><a href="#add" id="js-twer-gpx-upload">{$field.label_image_add}</a></button>
                    </p>

                    <div class="twer-attach__actions js-twer-attach-actions"
                         style="display: none;" id="js-twer-attach-actions">
                        <button type="button" class="button js-twer-attach-remove" id="js-twer-attach-remove">{$field.label_image_remove}</button>
                        <button type="button" class="button js-twer-attach-add" id="js-twer-attach-change">{$field.label_image_change}</button>
                    </div>
                </div>
            </div>
            <div class="trew-error-message" id="gpxErrorMessage" style="display: none">
                This type of GPX file is not supported.
            </div>
        {/if}

        {if 'image' === $field.type}
            <div class="twer-attach js-twer-attach-wrap">

                <div class="twer-attach__thumb js-twer-attach-thumb">
                    {if !empty($field.image)}
                        <img src="{$field.image}" alt="">
                    {/if}
                    <button type="button" class="btn btn-outline-light twer-attach__add-media js-twer-attach-add" style="{if !empty($field.value)}display:none;{else}display:block;{/if}">{$field.label_image_add}</button>
                    <input type="hidden" name="{$field.name}" id="{$field.id}" value="{$field.value}">
                </div>

                <div class="twer-attach__actions js-twer-attach-actions" style="{if !empty($field.value)}display:block;{else}display:none;{/if}">
                    <button type="button" class="button js-twer-attach-remove">{$field.label_image_remove}</button>
                    <button type="button" class="button js-twer-attach-add">{$field.label_image_change}</button>
                </div>
            </div>
        {/if}

        {if 'gallery' === $field.type}
            <div class="twer-attach-gallery js-twer-attach-gallery-wrap">
                {if !empty($field.gallery_images)}
                    {foreach $field.gallery_images as $thumb}
                        <div class="twer-attach-gallery__thumb" data-id="{$thumb}">
                            <a href="#" class="twer-attach-gallery__remove js-twer-attach-gallery-remove" title="{$field.label_image_remove}"></a>
                            <img src="{$thumb@key}" alt="{$thumb}">
                        </div>
                    {/foreach}
                {/if}
                <button type="button" class="btn btn-outline-light twer-attach-gallery__add-media js-twer-attach-gallery-add"></button>
                <input type="hidden" name="{$field.name}" value="{$field.value}">
            </div>
        {/if}

        {if 'button' === $field.type}
            <button type="button" class="{$field.class}">{$field.label_inline}</button>
        {/if}

        {if 'radios' === $field.type}
            {html_radios_extended name=$field.name atts=$field.atts options=$field.options label_ids=$field.label_ids selected=$field.selected separator=$field.separator}
        {/if}

        {if 'html' === $field.type}
            {$field.value}
        {/if}


        {if isset($field.extra)}
            <div class="form-extra d-none">
                {foreach $field.extra as $extra}
                    {include file='fields.tpl' field=$extra}
                {/foreach}
            </div>
        {/if}
    </div>

    {if !empty($field.bottom_note)}
        <div class="w-100"></div>

            <div class="col-12">
                <p style="font-size: 14px; margin-bottom: 0; margin-top: -1px;" class="description">{$field.bottom_note}</p>
            </div>
    {/if}
{/if}
