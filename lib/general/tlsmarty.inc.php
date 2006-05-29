<?php
/**
 * TestLink Open Source Project - http://testlink.sourceforge.net/ 
 *
 * Filename $RCSfile: tlsmarty.inc.php,v $
 *
 * @version $Revision: 1.11 $
 * @modified $Date: 2006/05/29 06:39:11 $ $Author: franciscom $
 *
 * @author Martin Havlat
 *
 * TLSmarty class implementation used in all templates
 *
 * 20060528 - franciscom - added new global var $g_tc_status_for_ui
 *
**/
class TLSmarty extends Smarty
{
    function TLSmarty()
	{
		global $g_tc_status;
		global $g_tc_status_css;
		global $g_bugInterfaceOn;
		global $g_tc_status_for_ui; // 20060528 - franciscom

        $this->Smarty();
        $this->template_dir = TL_ABS_PATH . 'gui/templates/';
        $this->compile_dir = TL_TEMP_PATH;
		
		$testprojectColor = TL_BACKGROUND_DEFAULT;
		if (isset($_SESSION['testprojectColor'])) 
        {
			$testprojectColor =  $_SESSION['testprojectColor'];
        	if (!strlen($testprojectColor))
        		$testprojectColor = TL_BACKGROUND_DEFAULT;
		}
		$this->assign('testprojectColor', $testprojectColor);
    
		$my_locale = isset($_SESSION['locale']) ? $_SESSION['locale'] : TL_DEFAULT_LOCALE;
		$basehref = isset($_SESSION['basehref']) ? $_SESSION['basehref'] : TL_BASE_HREF;

		$this->assign('basehref', $basehref);
		$this->assign('helphref', $basehref . 'gui/help/' . $my_locale . "/");
		$this->assign('css', $basehref . TL_TESTLINK_CSS);
		$this->assign('locale', $my_locale);
		
		$this->assign('gsmarty_tc_status',$g_tc_status);
		$this->assign('g_bugInterfaceOn', $g_bugInterfaceOn);

		$this->assign('gsmarty_tc_status_css',$g_tc_status_css);
	  
	  // 20060528 - franciscom
	  $this->assign('gsmarty_tc_status_for_ui',$g_tc_status_for_ui);
		
	
		$this->assign('pageCharset',TL_TPL_CHARSET);
		$this->assign('tlVersion',TL_VERSION);
		
		// this allows unclosed <head> tag to add more information and link; see inc_head.tpl 
		$this->assign('openHead', 'no');
		
		// there are some variables which should not be assigned for template 
		// but must be initialized
		$this->assign('jsValidate', null);
		$this->assign('jsTree', null);
		$this->assign('sqlResult', null);
		
		//20050831 - scs - changed default action to updated
		$this->assign('action', 'updated');
	
		global $g_locales;
		$this->assign('optLocale',$g_locales);
		$this->register_function("lang_get", "lang_get_smarty");
		
		// 20050828 - fm
		$this->register_function("localize_date", "localize_date_smarty");

	  // 20060303 - franciscom
	  $this->register_function("localize_timestamp", "localize_timestamp_smarty");

    // 20060401 - franciscom
    $this->register_function("localize_tc_status","translate_tc_status_smarty");
		
		// define a select structure for {html_options ...}
		$this->assign('option_yes_no', array(0 => lang_get('No'), 1 => lang_get('Yes')));
	}
}
?>