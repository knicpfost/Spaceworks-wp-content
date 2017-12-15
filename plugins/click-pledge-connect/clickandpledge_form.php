<?php
/*
Plugin Name: Click & Pledge Connect
Plugin URI: https://manual.clickandpledge.com/
Description: The Click & Pledge Connect plugin provides a flexible and easy to add process for adding Connect forms to any WordPress template.
Version: 1.1709.4.8.1.00.05
Author: Click & Pledge
Author URI: https://www.clickandpledge.com
*/
global 	$cnp_table_name;
global  $wpdb;
global 	$cnp_formtable_name;
global  $cnpCampaignUrl;
global  $cnp_settingtable_name;
$blogtime = current_time( 'timestamp', false );
$wp_dateformat = get_option('date_format');
$wp_timeformat = get_option('time_format');
$cnp_table_name        = $wpdb->prefix . "cnp_forminfo";
$cnp_formtable_name    = $wpdb->prefix . "cnp_formsdtl";
$cnp_settingtable_name = $wpdb->prefix . "cnp_settingsdtl";
define( 'CFCNP_PLUGIN_CURRENTDATETIMEFORMATPHP',$wp_dateformat." ".$wp_timeformat);

function dateformatphptojs( $sFormat ) {
    switch( $sFormat ) {
        case 'F j, Y':
            return( 'MMMM DD, YYYY' );
            break;
        case 'Y/m/d':
            return( 'YYYY/MM/DD' );
            break;
        case 'm/d/Y':
            return( 'MM/DD/YYYY' );
            break;
        case 'd/m/Y':
            return( 'DD/MM/YYYY' );
            break;
		 case 'Y-m-d':
            return( 'YYYY-MM-DD' );
            break;
        case 'm-d-Y':
            return( 'MM-DD-YYYY' );
            break;
		case 'd-m-Y':
            return( 'DD-MM-YYYY' );
            break;
        case 'M j, Y':
            return( 'MMM dd,YYYY' );
            break;
		case 'l, F jS, Y':
			return( 'dddd, MMMM Do, YYYY' );
            break;
    }
}
$wp_dateformat = dateformatphptojs($wp_dateformat);

$wp_timeformat = str_replace("g","h",$wp_timeformat);
$wp_timeformat = str_replace("i","mm",$wp_timeformat);
$wp_timeformat = str_replace("H","HH",$wp_timeformat);

define( 'CNP_CF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CNP_CF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CFCNP_PLUGIN_NAME', basename(dirname(__FILE__)) );\
define( 'CFCNP_PLUGIN_CURRENTTIME',date("Y-m-d H:i:00",$blogtime));

define( 'CFCNP_PLUGIN_CURRENTDATETIMEFORMAT',$wp_dateformat." ".$wp_timeformat);

/* When plugin is activated */
register_activation_hook(__FILE__,'Install_CNP_DB');


/* When plugin is deactivation*/
register_deactivation_hook( __FILE__, 'Remove_CNP' );


/* Creates the admin menu for the  plugin */
if ( is_admin() ){
	add_action('admin_menu', 'CNP_Plugin_Menu');
	add_action('admin_init', 'Add_CNP_Scripts');
    //add_action('wp_enqueue_scripts', 'add_ajax_script' );
}

/* Admin Page setup */
function CNP_Plugin_Menu() {
	     global $CNP_Menu_page;

	     $CNP_Menu_page =  add_menu_page(__('Click & Pledge Connect'),'Click & Pledge Connect', 8,'cnpcf_formshelp', 'cnpcf_formshelp');
		 $cnpsettingscount = CNPCF_getAccountNumbersCount();
			if($cnpsettingscount > 0){
			 add_submenu_page('cnpcf_formshelp', 'Form Groups', 'Form Groups', 8, 'cnp_formsdetails', 'CNP_formsdetails');
			 add_submenu_page('cnpcf_formshelp', 'Add Form Group', 'Add Form Group', 8, 'cnpforms_add', 'CNPS_addform');
			 add_submenu_page(null, 'View Form', 'View Form', 8, 'cnp_formdetails', 'cnp_formdetails');
			}
	     add_submenu_page('cnpcf_formshelp', 'Settings', 'Settings', 8, 'cnp_formssettings', 'CNP_formssettings');



		 add_action("load-$CNP_Menu_page", "CNP_Screen_Options");
		 add_action( 'view_formsdetails', 'cnpcf_getselactivecampaigns' );

		 wp_enqueue_script('jquery-ui-datepicker');
		 wp_enqueue_style('jquery-ui-css',plugins_url(CFCNP_PLUGIN_NAME."/css/jquery-ui.css"));
}

function CNP_Screen_Options() {
	global $CNP_Menu_page;

	$screen = get_current_screen();

	// get out of here if we are not on our settings page
	if(!is_object($screen) || $screen->id != $CNP_Menu_page)
		return;

	$args = array(
		'label' => __('Products per page', 'UPCP'),
		'default' => 20,
		'option' => 'cnp_products_per_page'
	);

	$screen->add_option( 'per_page', $args );
}
function enqueue_date_picker(){
                wp_enqueue_script(
			'field-date-js',
			'Field_Date.js',
			array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'),
			time(),
			true
		);

		wp_enqueue_style( 'jquery-ui-datepicker' );
}
function CNP_Set_Screen_Options($status, $option, $value) {
	if ('cnp_products_per_page' == $option) return $value;
}

add_filter('set-screen-option', 'cnp_products_per_page', 10, 3);

function Add_CNP_Scripts() {
		if (isset($_GET['page'])  && ($_GET['page'] == 'cnpform_add' || $_GET['page'] == 'cnpforms_add' || $_GET['page'] == 'cnp_formssettings') )
		{
			$jsurl = plugins_url(CFCNP_PLUGIN_NAME."/js/Admin.js");
			wp_enqueue_script('Page-Builder', $jsurl, array('jquery'));

		if($_GET['page'] == 'cnpforms_add')
		{
			$datamomentjsurl = plugins_url(CFCNP_PLUGIN_NAME."/js/moment.js");
		    wp_enqueue_script('Page-Moment', $datamomentjsurl);
			$bootstrapminurl = plugins_url(CFCNP_PLUGIN_NAME."/js/bootstrap.min.js");

			wp_enqueue_script('Page-Calendar', $bootstrapminurl, array('jquery'));
			

			$bootstrapdtpkrminurl = plugins_url(CFCNP_PLUGIN_NAME."/js/bootstrap-datetimepicker.min.js");
			wp_enqueue_script('Page-DatePickermin', $bootstrapdtpkrminurl, array('jquery'));

			$databtstrapmincssurl = plugins_url(CFCNP_PLUGIN_NAME."/css/bootstrap.min.css");
			wp_enqueue_style('Page-calcss', $databtstrapmincssurl);


			$datadtpkrmincssurl = plugins_url(CFCNP_PLUGIN_NAME."/css/bootstrap-datetimepicker.min.css");
			wp_enqueue_style('Page-dtpkrmincss', $datadtpkrmincssurl);

			$datadtpkrstandalonecssurl = plugins_url(CFCNP_PLUGIN_NAME."/css/bootstrap-datetimepicker-standalone.css");
			wp_enqueue_style('Page-standalonecss', $datadtpkrstandalonecssurl);
		 }
		}

		$datatableurl = plugins_url(CFCNP_PLUGIN_NAME."/js/jquery.dataTables.min.js");
		wp_enqueue_script('Page-Table', $datatableurl, array('jquery'));

		$datatablecssurl = plugins_url(CFCNP_PLUGIN_NAME."/css/cnptable.css");
		wp_enqueue_style('Page-Tablecss', $datatablecssurl);
	    $datatabledcssurl = plugins_url(CFCNP_PLUGIN_NAME."/css/jquery.dataTables.min.css");
		wp_enqueue_style('Page-Tablescss', $datatabledcssurl);

	    $datatablefontcssurl = "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css";
		wp_enqueue_style('Page-Fontcss', $datatablefontcssurl);



		if (isset($_GET['page'])  && ($_GET['page'] == 'cnp_formsdetails' ) )
			{
			wp_add_inline_script( 'jquery-migrate', 'jQuery(document).ready(function(){
			jQuery("#cnpformslist").dataTable();
			jQuery("tr:even").css("background-color", "#f1f1f1");

		});
		');}
		if (isset($_GET['page'])  && $_GET['page'] == 'cnpforms_add' && ($_GET['act'] == 'add' || $_GET['act'] == 'edit'|| !isset($_GET['act']) ))
			{
				if($_GET['act'] == 'add' || !isset($_GET['act'])){
		 wp_add_inline_script('jquery-migrate', '
		jQuery(function () {
		jQuery("#txtcnpformstrtdt").datetimepicker({format: "'.CFCNP_PLUGIN_CURRENTDATETIMEFORMAT.'",defaultDate:new Date()});
		jQuery("#txtcnpformenddt").datetimepicker({format: "'.CFCNP_PLUGIN_CURRENTDATETIMEFORMAT.'"});
		jQuery("#txtcnpformstrtdt1").datetimepicker({format: "'.CFCNP_PLUGIN_CURRENTDATETIMEFORMAT.'"});
		jQuery("#txtcnpformenddt1").datetimepicker({format: "'.CFCNP_PLUGIN_CURRENTDATETIMEFORMAT.'"});
		});');
		}
			elseif($_GET['act'] == 'edit'){
		/*wp_add_inline_script( 'jquery-migrate', '
		jQuery(document).ready(function(){
		//jQuery("#txtcnpformstrtdt").datetimepicker({format: "'.CFCNP_PLUGIN_CURRENTDATETIMEFORMAT.'"});
     //	jQuery("#txtcnpformenddt").datetimepicker({format: "'.CFCNP_PLUGIN_CURRENTDATETIMEFORMAT.'"});

		});');*/

				}
				}

}

require(dirname(__FILE__) . '/Functions/Install_CNP.php');
require(dirname(__FILE__) . '/Functions/functionscnp.php');
require(dirname(__FILE__) . '/cnpSettings.php');
require(dirname(__FILE__) . '/cnpFormDetails.php');
require(dirname(__FILE__) . '/FormDetails.php');
require(dirname(__FILE__) . '/FormAdd.php');
require(dirname(__FILE__) . '/cnphelpmanual.php');

function CNPCF_friendlyname() {
global $wpdb;	global $cnp_settingtable_name;
$scnpSQL = "SELECT * FROM ".$cnp_settingtable_name." where cnpstngs_frndlyname ='".$_POST['param']."'";
$cnpresults  = $wpdb->get_results($scnpSQL);
$cnpformrows = $wpdb->num_rows;
if($cnpformrows > 0)
{
	echo "Friendly Name already exist.";
	wp_die();
}

}
function CNPCF_cnpaccountid() {
global $wpdb;	global $cnp_settingtable_name;
	 				$scnpSQL = "SELECT * FROM ".$cnp_settingtable_name." where cnpstngs_AccountNumber = '".$_POST['param']."'";
						$cnpresults  = $wpdb->get_results($scnpSQL);
					 	$cnpformrows = $wpdb->num_rows;
						if($cnpformrows > 0)
						{
							echo "Account already exist.";
							wp_die();
						}

}
add_action('wp_ajax_CNPCF_friendlyname', 'CNPCF_friendlyname');
add_action('wp_ajax_nopriv_CNPCF_friendlyname', 'CNPCF_friendlyname');
add_action('wp_ajax_CNPCF_cnpaccountid', 'CNPCF_cnpaccountid');
add_action('wp_ajax_nopriv_CNPCF_cnpaccountid', 'CNPCF_cnpaccountid');

function load_jquery() {
    if ( ! wp_script_is( 'jquery', 'enqueued' )) {
       //Enqueue
        wp_enqueue_script( 'jquery' );
	}
	wp_localize_script( 'ajax-js', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'load_jquery' );

function cnpform_GetShortCode($frmid){

	global $wpdb;
	global $cnp_table_name;
	global $rtrnstr;

	$chkshortcodexit = CNPCF_isExistShortcode($frmid[0]);

	if($chkshortcodexit)
	{
		// $cnpshortcodearray = explode("_",$frmid[0]);
		 $cnpgrpnm= str_replace('-', ' ', $frmid[0]);
		 $formid  = CNPCF_getformsofGroup($cnpgrpnm);
		 $formtyp = CNPCF_getFormType($cnpgrpnm);

		if(count($formid) >=1){
		$rtrnstrarr ="";
		for($frminc=0;$frminc <	 count($formid);$frminc++)
		{

    	$attrs = array('class' => 'CnP_formloader', 'data-guid' => $formid[$frminc]) ;
		$attrs_string = '';
		if(!empty( $attrs ) ) {

			foreach ( $attrs as $key => $value ) {
				$attrs_string .= "$key='" . esc_attr( $value ) . "' ";
			}
			$attrs = ltrim( $attrs_string );

	  	 }
		$cnpshortcodearray = explode("--",$formtyp);

		if($cnpshortcodearray[0] == 'inline')
		{
		  $rtrnstr ="<script " . $attrs . "src='https://resources.connect.clickandpledge.com/Library/iframe-1.0.0.min.js'></script>\n";
		  $rtrnstr.='<div id="CnP_inlineform" class="ads"></div>';
		}
		else if($cnpshortcodearray[0] == 'popup')
		{
			$rtrnstr ="<script class = 'CnP_formloader' src='https://resources.connect.clickandpledge.com/Library/iframe-1.0.0.min.js'></script>\n";
			if($cnpshortcodearray[1] == 'text')
			{
				$cnpGetImagesql = $cnpshortcodearray[2];
				$rtrnstrarr.= '<a class="CnP_formlink" data-guid="'.$formid[$frminc].'">'.$cnpGetImagesql.'</a>';
			}
			else if($cnpshortcodearray[1] == 'button')
			{
				$cnpGetbuttontext = $cnpshortcodearray[2];
				$rtrnstrarr.= '<input class="CnP_formlink" type="submit" value="'.$cnpGetbuttontext.'" data-guid="'.$formid[$frminc].'" />';
			}
			else if($cnpshortcodearray[1] == 'image')
			{
			  $cnpGetImage = $cnpshortcodearray[3];
			 $rtrnstrarr.= '<img class="CnP_formlink " src="data:image/jpeg;base64,'.base64_encode($cnpGetImage).'" data-guid="'.$formid[$frminc].'" style="cursor: pointer;">';
			}
		}
			}
	return $rtrnstr." ".$rtrnstrarr;
			}else{
			 $rtrnstr =CNPCF_getGroupCustomerrmsg($frmid[0]);
	 return $rtrnstr;

		}
	}
	else
	{
	 //$rtrnstr ="Shortcode doesn't exist or expired";

	 $rtrnstr =CNPCF_getGroupCustomerrmsg($frmid[0]);
	 return $rtrnstr;
	}
}

add_shortcode('CnPConnect', 'cnpform_GetShortCode');
?>
