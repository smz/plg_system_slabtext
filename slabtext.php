<?php
/*
 * @package     Joomla.Plugin
 * @subpackage  System.slabtext
 *
 * @copyright   Copyright (C) 2015 Sergio Manzi.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

/**
 * slabText Plugin
 */
class plgSystemSlabtext extends JPlugin
{
	public function onBeforeCompileHead()
	{
		// Perform actions on the frontend only
		if(JFactory::getApplication()->isSite())
		{

			// Dot not load if this is not the right document-class
			$document = JFactory::getDocument();
			if($document->getType() != 'html')
			{
				return false;
			}

			// Get and parse options from the plugin parameters
			$container = trim($this->params->get('container', '.textfill'));
			$fontRatio = trim($this->params->get('fontRatio', '0.78'));
			$forceNewCharCount = $this->params->get('forceNewCharCount', '1');
			$wrapAmpersand = $this->params->get('wrapAmpersand', '1');
			$headerBreakpoint = trim($this->params->get('headerBreakpoint', ''));
			$viewportBreakpoint = trim($this->params->get('viewportBreakpoint', ''));
			$noResizeEvent = $this->params->get('noResizeEvent', '1');
			$resizeThrottleTime = trim($this->params->get('resizeThrottleTime', '300'));
			$maxFontSize = trim($this->params->get('maxFontSize', '999'));
			$postTweak = $this->params->get('postTweak', '1');
			$precision = trim($this->params->get('precision', '3'));
			$minCharsPerLine = trim($this->params->get('minCharsPerLine', ''));

			$options = array();
			if ($fontRatio != '0.78') $options[] = "\t\t\"fontRatio\": $fontRatio";
			if ($forceNewCharCount != '1') $options[] = "\t\t\"forceNewCharCount\": false";
			if ($wrapAmpersand != '1') $options[] = "\t\t\"wrapAmpersand\": false";
			if ($headerBreakpoint != '') $options[] = "\t\t\"headerBreakpoint\": $headerBreakpoint";
			if ($viewportBreakpoint != '') $options[] = "\t\t\"viewportBreakpoint\": $viewportBreakpoint";
			if ($noResizeEvent != '0') $options[] = "\t\t\"noResizeEvent\": true";
			if ($resizeThrottleTime != '300') $options[] = "\t\t\"resizeThrottleTime\": $resizeThrottleTime";
			if ($maxFontSize != '999') $options[] = "\t\t\"maxFontSize\": $maxFontSize";
			if ($postTweak != '1') $options[] = "\t\t\"postTweak\": false";
			if ($precision != '3') $options[] = "\t\t\"precision\": $precision";
			if ($minCharsPerLine != '') $options[] = "\t\t\"minCharsPerLine\": $minCharsPerLine";
			$opts = implode(",\n", $options);


			// Include jQuery
			JHtml::_('jquery.framework');

			// Include the JavaScript and CSS
			JHtml::_('script', 'plg_slabtext/jquery.slabtext.min.js', false, true);
			JHtml::_('stylesheet', 'plg_slabtext/slabtext.css', array(), true);

			// Build the script-lines
			$script_lines = array();
			$script_lines[] = 'jQuery(document).ready(function(){';
			$script_lines[] = "\tjQuery('$container').slabText({";
			if ($opts != '') $script_lines[] = $opts;
			$script_lines[] = "\t});";
			$script_lines[] = '});';

			// Add the script-declaration
			$document->addScriptDeclaration(implode("\n", $script_lines)); 
		}
	}
}
