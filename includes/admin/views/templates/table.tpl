<div class="table-responsive">
    <table class="{$settings.table_class}">
        <tbody>
        {foreach $fields as $field}
            <tr data-row-id="{$field.row_id}" {if !empty($field.row_class)}class="{$field.row_class}"{/if} {$field.row_atts}>
                {if $field.type === 'message'}
                    <td class="{$settings.table_td_class}" {$field.style}>{$field.value}</td>
                {else}
                    {if isset($field.label)}
                        <th class="{$settings.table_th_class} {$field.labelThClass}">
                            {if !empty($field.label)}
                                <div class="twer-cell__label">
                                {if 'group'=== $field.type}
                                    {$field.label}
                                {else}
                                    <label for="{$field.id}">{$field.label}</label>
                                {/if}

                                    {if $field.labelThDescription}<div class="twer-cell__description">{$field.labelThDescription}</div>{/if}
                                </div>
                            {/if}
                        </th>
                    {/if}
                    <td class="{$settings.table_td_class}">
                        <div class="form-row align-items-stretch">
                            {if 'group'=== $field.type}
                                {foreach $field.group as $field_in_group}
                                    {include file='fields.tpl' field=$field_in_group}
                                {/foreach}
                            {else}
                                {include file='fields.tpl' field=$field}
                            {/if}

                            {if !empty($field.row_controls)}
                                {foreach $field.row_controls as $control}
                                    {$control}
                                {/foreach}
                            {/if}
                        </div>
                    </td>
                {/if}
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
