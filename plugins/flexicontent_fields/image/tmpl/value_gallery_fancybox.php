<?php  // *** DO NOT EDIT THIS FILE, CREATE A COPY !!

/**
 * (Popup) Gallery layout  --  Fancybox
 *
 * This layout supports inline_info, pretext, posttext
 */


// ***
// *** Values loop
// ***

$i = -1;
foreach ($values as $n => $value)
{
	// Include common layout code for preparing values, but you may copy here to customize
	$result = include( JPATH_ROOT . '/plugins/flexicontent_fields/image/tmpl_common/prepare_value_display.php' );
	if ($result === _FC_CONTINUE_) continue;
	if ($result === _FC_BREAK_) break;

	$title_attr = htmlspecialchars($desc ? '<b>' . $title . '</b><br> ' . $desc : $title, ENT_COMPAT, 'UTF-8');
	$group_str = $group_name ? 'data-fancybox="' . $group_name . '"' : '';

	if (!empty($usemediaurl) && !empty($value['mediaurl']))
	{
		$attribs = 'href="' . $value['mediaurl'] . '"  ';

		if (strpos($value['mediaurl'], 'youtube') === false && strpos($value['mediaurl'], 'vimeo') === false)
		{
			$attribs .= ' data-type="iframe"';
		}
	}
	else
	{
		$attribs = 'href="' . JUri::root(true).'/'.$srcl . '" ';
	}

	$field->{$prop}[] = $pretext.
		'<a style="' . $style . '" ' . $attribs . '" class="fc_image_thumb" ' . $group_str . ' title="' . $title_attr . '" data-caption="' . $title_attr . '">
			' . $img_legend . '
		</a>'
		. $inline_info
		. $posttext;
}



// ***
// *** Add per field custom JS
// ***

if ( !isset(static::$js_added[$field->id][__FILE__]) )
{
	flexicontent_html::loadFramework('fancybox');

	$js = '';

	if ($js) JFactory::getDocument()->addScriptDeclaration($js);

	static::$js_added[$field->id][__FILE__] = true;
}



/**
 * Include common layout code before finalize values
 */

$result = include( JPATH_ROOT . '/plugins/flexicontent_fields/image/tmpl_common/before_values_finalize.php' );
if ($result !== _FC_RETURN_)
{
	// ***
	// *** Add container HTML (if required by current layout) and add value separator (if supported by current layout), then finally apply open/close tags
	// ***

	// Add value separator
	$field->{$prop} = implode($separatorf, $field->{$prop});

	// Apply open/close tags
	$field->{$prop}  = $opentag . $field->{$prop} . $closetag;
}