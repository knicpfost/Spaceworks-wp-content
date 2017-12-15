<?php
ob_start();
if ( ! defined( 'ABSPATH' ) ) exit;
function cnps_addform() {
	
if(isset($_POST["cnpbtnsave"]))
{
	$addform= wp_unslash( sanitize_text_field( $_POST["addformval"]));
	global $wpdb;
	global $cnp_table_name;
   	if($addform==1)
	{
		$cnprtnval = CNPCF_addNewForms($cnp_table_name,$_POST);
		if($cnprtnval == true){$cnpredirectval = "saved";}else{$cnpredirectval = "failed";}
		wp_redirect("admin.php?page=cnp_formsdetails&info=".$cnpredirectval);
		exit;
	}
	else if($addform==2)
	{
		$cnprtnval =CNPCF_updateForms($cnp_table_name,$_POST);
		if($cnprtnval == true){$cnpredirectval = "upd";}else{$cnpredirectval = "failed";}
		wp_redirect("admin.php?page=cnp_formsdetails&info=".$cnpredirectval);
		exit;
	}

}   $dsplycntnt ="";
	$cnpaccountfriendlynams = CNPCF_getAccountIdList();
	$cnpsettingscount = CNPCF_getAccountNumbersCount();
   if($cnpsettingscount==1){$dsplycntnt = 'class="disabled"';}
	$hidval	   = 1;
	$act=wp_unslash( sanitize_text_field( $_REQUEST["cnpviewid"] ) );
	if(isset($act) && $act!="")
	{
		global $wpdb;
		global $cnp_table_name;
		global $cnp_formtable_name;
		$cnpviewid = wp_unslash( sanitize_text_field( $_GET['cnpviewid'] ) );
		$cnpfrmdtresult    = CNPCF_GetCnPGroupDetails($cnp_table_name,'cnpform_ID',$cnpviewid);
		$cnpfrmrtnval      = CNPCF_GetCnPGroupDetails($cnp_formtable_name,'cnpform_cnpform_ID',$cnpviewid);
		foreach ($cnpfrmdtresult as $cnprtnval) {}

	 if (count($cnprtnval)> 0 )
		 {


				$cnpfrmid              = $cnprtnval->cnpform_ID;
				$cnpfrmgroupname       = $cnprtnval->cnpform_groupname;
				$cnpfrmAccountNumber   = $cnprtnval->cnpform_cnpstngs_ID;
				$cnpfrmtype            = $cnprtnval->cnpform_type;
			 	$cnpfrmptype           = $cnprtnval->cnpform_ptype;
				$cnpfrmtext            = $cnprtnval->cnpform_text;
				$cnpfrmimg             = $cnprtnval->cnpform_img;
				$cnpfrmshortcode       = $cnprtnval->cnpform_shortcode;
				$cnpfrmStartDate       = $cnprtnval->cnpform_Form_StartDate;
				$cnpfrmEndDate         = $cnprtnval->cnpform_Form_EndDate;
			    $cnpfrmerrmsg         = $cnprtnval->cnpform_custommsg;
		 		if($cnpfrmEndDate == "0000-00-00 00:00:00") {$cnpfrmEndDate ="";}
				$cnpfrmstatus          = $cnprtnval->cnpform_status;
				$btn	               = "Update form";
				$hidval	               = 2;

				$cnpeditaccountfriendlynams = CNPCF_editgetAccountIdList($cnpfrmAccountNumber);

		}

	$cnpeditdsplycntnt ='

	<div xmlns="http://www.w3.org/1999/xhtml" class="wrap nosubsub">

	<div class="icon32" id="icon-edit"><br/></div>
<h2>Edit Form Group</h2><div class="dataTables_paginate" ><a href="admin.php?page=cnp_formsdetails"><strong>Go back to Form Groups</strong></a></div>
<div id="col-left">
	<div class="col-wrap">
		<div>
			<div class="form-wrap">
				<form class="validate"  method="post" id="addfrm" name="addfrm" enctype="multipart/form-data">
				<input type="hidden" name="cnphdnediturl" id="cnphdnediturl" value="'.CNP_CF_PLUGIN_URL.'getcnpditactivecampaigns.php">
					<input type="hidden" name="hdnfrmid" id="hdnfrmid" value="'.$cnpfrmid .'">
	<input type="hidden" name="hdndatefrmt" id="hdndatefrmt" value="'.CFCNP_PLUGIN_CURRENTDATETIMEFORMAT .'">
	<input type="hidden" name="hdnstrtdt" id="hdnstrtdt" value="'.$cnpfrmStartDate.'">
	<input type="hidden" name="hdnenddt" id="hdnenddt" value="'.$cnpfrmEndDate.'">

				<div class="form-field cnpaccountId">
						<label for="tag-name">Form Group Name*</label>
						<input type="text" size="40" id="txtcnpfrmgrp" name="txtcnpfrmgrp" value="'.$cnpfrmgroupname.'" onkeypress="return AvoidSpace(event)" readonly/>
						<p>Please enter the form group name</p>
					</div>
					<div class="form-field cnplstfrndlyname" >
						<label for="tag-name">Account(s)*</label>
						<select name="lstaccntfrndlynam" id="lstaccntfrndlynam" disabled>
						'.$cnpeditaccountfriendlynams.'</select>
						<p></p>
					</div>

					<div class="input-group date form-field cnpfrmstrtdt" >
						<label for="tag-name">Start Date & Time* [TimeZone : '.  wp_get_timezone_string().']</label>
						<input type="text" size="40" id="txtcnpformstrtdt" name="txtcnpformstrtdt"  />
						<p></p>
					</div>
					<div class="input-group date form-field cnpfrmenddt" >
						<label for="tag-name">End Date & Time</label>
						<input type="text" size="40" id="txtcnpformenddt" name="txtcnpformenddt"/>
						<p></p>
					</div>
					<div class="form-field cnplstfrmtyp" >
						<label for="tag-name">Display Type*</label>
						<select name="lstfrmtyp" id="lstfrmtyp">';
						$cnpeditdsplycntnt .='<option value="inline"'; if($cnpfrmtype == "inline"){$cnpeditdsplycntnt .= 'selected';} $cnpeditdsplycntnt .=' >Inline</option>
						<option value="popup"'; if($cnpfrmtype == "popup"){$cnpeditdsplycntnt .= 'selected';} $cnpeditdsplycntnt .='>Overlay</option></select>
					</div>';
					if($cnpfrmptype == "" || $cnpfrmtype =="inline"){$code = "style='display:none'"; }
					$cnpeditdsplycntnt .=' <div class="form-field popuptyp" '. $code.'>
						<label for="tag-name">Link Type*</label>
						<select name="lstpopuptyp" id="lstpopuptyp">';
						$cnpeditdsplycntnt .='<option value="text"'; if($cnpfrmptype == "text"){$cnpeditdsplycntnt .= 'selected';} $cnpeditdsplycntnt .='>Text</option>
						<option value="image"'; if($cnpfrmptype == "image"){$cnpeditdsplycntnt .= 'selected';}$cnpeditdsplycntnt .='>Image</option>
						<option value="button"'; if($cnpfrmptype == "button"){$cnpeditdsplycntnt .='selected';}
						$cnpeditdsplycntnt .='>Button</option>
						 </select>
						<p></p>
					</div>';
						if($cnpfrmtext =="" || $cnpfrmtype =="inline" || $cnpfrmptype=="image"){$txtcode = "style='display:none'";}
   						$cnpeditdsplycntnt .= ' <div class="form-field popuptyptxt" '.$txtcode.' >
						<label for="tag-name" id="cnplbllink">Link Label*</label>
						<input type="text" size="40" id="txtpopuptxt" name="txtpopuptxt" value="'.$cnpfrmtext.'"  />
						<p></p>
					</div>';
					if($cnpfrmimg =="" || $cnpfrmptype!="image" || $cnpfrmtype =="inline"){$imgcode = "style='display:none'"; $errimg="N";}
					else{$imgcode = "";$errimg="Y";}
					$cnpeditdsplycntnt .= '
					<div class="form-field popuptypimg" '.$imgcode.'>
						<label for="tag-name">Upload Image*</label>
						<input type="file" size="40" id="txtpopupimg" name="txtpopupimg" />
						
						<p><input type="hidden"  id="hdnpopupimg" name="hdnpopupimg" value="'.$errimg.'"/></p>
					</div>
					<div class="form-field cnpfrmerror">
						<label for="tag-name">No Valid Form Message</label>

						<textarea id="txterrortxt" name="txterrortxt">'.$cnpfrmerrmsg.'</textarea>
						<p></p>
					</div>
					<div class="form-field cnplstfrmsts" >
						<label for="tag-name">Status</label>
						<select name="lstfrmsts" id="lstfrmsts">';
						$cnpeditdsplycntnt .='<option value="1"'; if($cnpfrmstatus == "1"){$cnpeditdsplycntnt .= 'selected';} $cnpeditdsplycntnt .=' >Active</option>
						<option value="0"'; if($cnpfrmstatus == "0"){$cnpeditdsplycntnt .= 'selected';} $cnpeditdsplycntnt .='>Inactive</option>
						</select>
						<p></p>
					</div>
					<p class="submit">';

					$frmscount = count($cnpfrmrtnval);
					if($frmscount > 0){

						$cnpimgurl = plugins_url(CFCNP_PLUGIN_NAME."/images/ajax-loader_trans.gif");
					$cnpeditdsplycntnt .='<input type="hidden" name="addformval" id="addformval" value='.$hidval.'>
					<input type="hidden" name="hidnoofforms" id="hidnoofforms" value='.$frmscount.'>

					 <input type="hidden" name="cnphdneditaccountId" id="cnphdneditaccountId" value="'.$cnpfrmAccountNumber.'">
					 <input type="hidden" name="cnphdneditguid" id="cnphdneditguid" value="'.$cnpfrmguid.'">
					</p><div style="float:left"  width="100%">
					<div class=" frmadddiv" >
					<p>Select your Connect campaign, choose a payment form, enter a start date and click SAVE. Copy the shortcode from Click & Pledge Form Groups page to enter on your WordPress page. Multiple forms may be added to display in order by start date. If dates overlap, the first form in the list will show.</p><p></p>
			        <table class="wp-list-table widefat" id="cnpformslist" >
					<thead><tr><th><u>Campaign*</u></th><th><u>Form*</u></th><th><u>Form GUID* </u></th><th><u>Start Date*</u></th><th><u>End Date</u></th><th></th></tr>
						</thead><tbody>';
						$frminc =1;
						foreach($cnpfrmrtnval as $cnpfrmlst){
						 $frmsenddt = $cnpfrmlst->cnpform_FormEndDate;
						if($frmsenddt == "0000-00-00 00:00:00") {$frmsenddt ="";}
						$cnpeditdsplycntnt .=' <tr><td><u><input type="hidden" name="hdncnpformcnt[]" id="hdncnpformcnt[]" value="'.$frminc.'"><input type="hidden" name="hdneditfrmid'.$frminc.'" id="hdneditfrmid'.$frminc.'" value="'.$cnpfrmlst->cnpform_id .'"><input type="hidden" name="cnphdneditlstcnpactivecamp'.$frminc.'" id="cnphdneditlstcnpactivecamp'.$frminc.'" value="'.$cnpfrmlst->cnpform_CampaignName.'"><select name="lstcnpeditactivecamp'.$frminc.'" id="lstcnpeditactivecamp'.$frminc.'" class="cnp_campaigns_select" onchange=getEditActiveForms('.$frminc.',"lstcnpeditactivecamp","");><option value="">Select Campaign</option></select></u><div id="dvldimg'.$frminc.'" class="cnp_loader"><img src="'.$cnpimgurl.'" alt="Loading" /></div><span class=cnperror id="spncampnname'.$frminc.'"></span></td>
						<td><u><input type="hidden" name="cnphdneditlstcnpfrmtyp'.$frminc.'" id="cnphdneditlstcnpfrmtyp'.$frminc.'" value="'.$cnpfrmlst->cnpform_GUID.'"><input type="hidden" name="hdncnpformname'.$frminc.'" id="hdncnpformname'.$frminc.'" ><select name="lstcnpeditfrmtyp'.$frminc.'" id="lstcnpeditfrmtyp'.$frminc.'" class="cnp_forms_select" onchange=getEditActiveGUID('.$frminc.'); ><option value="">Select Forms</option></select></u><div id="dvfdimg'.$frminc.'" class="cnp_loader"><img src="'.$cnpimgurl.'" alt="Loading" /></div><span class=cnperror id="spnformname'.$frminc.'"></span></td>
						<td><u><input type="text" size="20" id="txtcnpguid'.$frminc.'" name="txtcnpguid'.$frminc.'" value="'.$cnpfrmlst->cnpform_GUID.'" readonly/></u></td>
				        <td  ><u>
						<input type="hidden" name="hdncnpformstrtdt'.$frminc.'" id="hdncnpformstrtdt'.$frminc.'" value="'.$cnpfrmlst->cnpform_FormStartDate.'">
						<input type="hidden" name="hdncnpformenddt'.$frminc.'" id="hdncnpformenddt'.$frminc.'" value="'.$frmsenddt.'"><input type="text" size="13" id="txtcnpformstrtdt'.$frminc.'" name="txtcnpformstrtdt'.$frminc.'"/></u><span class=cnperror id="spnstrtdt'.$frminc.'"></span></td>
						<td ><u><input type="text" size="13" id="txtcnpformenddt'.$frminc.'" name="txtcnpformenddt'.$frminc.'" /></u><span class=cnperror id="spnenddt'.$frminc.'"></span></td>
						<td><u>';
						//if($frminc != 1 || $frmscount !=1){
							$cnpeditdsplycntnt .='<input type="button"name="cnpbtndelte" id="cnpbtndelte" value="Delete" onclick="getDeleteFormrows('.$frminc.')" class="add-new-h2">';
							//}
							 $cnpeditdsplycntnt .='</u></td></tr>';
						  $frminc++;
						}
						  $cnpeditdsplycntnt .='</tbody></table>
						  <div><table class="wp-list-table widefat" id="ist" >
						 <tr><td>
						 <div style="float:right">
						 <input type="button" name="cnpbtnadd" id="cnpbtnadd" value="Add Form" class="add-new-h2"><div >
						 </td></tr>
						 </table>
						 </div>
						 <div style="text-align-last:center;">
						 <div>

						 <input type="button" name="cnpbtnedit" id="cnpbtnedit" value="Close" class="add-new-h2" onclick="window.history.go(-1); return false;">
						 <input type="submit" name="cnpbtnsave" id="cnpbtnsave" value="Save" class="add-new-h2">  <div class="dataTables_paginate" ><a href="admin.php?page=cnp_formsdetails"><strong>Go back to Form Groups</strong></a></div>
						 </div></div>
						 </div>';
						 }
						$cnpeditdsplycntnt .='</form>
			</div>
		</div>
	</div>
</div></div>
</div>';
echo $cnpeditdsplycntnt;
	}
	else
	{

$cnpdsplycntnt ='<div xmlns="http://www.w3.org/1999/xhtml" class="wrap nosubsub">
<div class="icon32" id="icon-edit"><br/></div>
<h2>Add Form Group</h2>
<div id="col-left">
	<div class="col-wrap">
		<div>
			<div class="form-wrap">
				<h3>'.$btn.'</h3>
				<form class="validate"  method="post" id="addfrm" name="addfrm" enctype="multipart/form-data">
				<input type="hidden" name="cnphdnurl" id="cnphdnurl" value="'.CNP_CF_PLUGIN_URL.'getcnpactivecampaigns.php">
				<input type="hidden" name="cnphdnaacountid" id="cnphdnaacountid" value="'.CNP_CF_PLUGIN_URL.'">
				<input type="hidden" name="hdndatefrmt" id="hdndatefrmt" value="'.CFCNP_PLUGIN_CURRENTDATETIMEFORMAT .'">
				<div class="form-field cnpfrmgrp">
						<label for="tag-name">Form Group Name*</label>
						<input type="text" size="40" id="txtcnpfrmgrp" name="txtcnpfrmgrp" onkeypress="return AvoidSpace(event)"/>
						<p>Please enter the form group name</p>
					</div>
					<div class="form-field cnplstfrndlyname" >
						<label for="tag-name">Account(s)*</label>
						<select name="lstaccntfrndlynam" id="lstaccntfrndlynam"'.$dsplycntnt.' >
						'.$cnpaccountfriendlynams.'</select>
						<p></p>
					</div>

					<div class="input-group date form-field cnpfrmstrtdt" >
						<label for="tag-name">Start Date & Time* [TimeZone : '. wp_get_timezone_string().']</label>
						<input type="text" size="40" id="txtcnpformstrtdt" name="txtcnpformstrtdt" />
						<p></p>
					</div>
					
					<div class="input-group date form-field cnpfrmenddt" >
						<label for="tag-name">End Date & Time</label>
						<input type="text" size="40" id="txtcnpformenddt" name="txtcnpformenddt" />
						
						<p></p>
					</div>
					<div class="form-field cnplstfrmtyp" >
						<label for="tag-name">Display Type</label>
						<select name="lstfrmtyp" id="lstfrmtyp">
						<option value="inline">Inline</option><option value="popup">Overlay</option></select>
						<p></p>
					</div>
					 <div class="form-field popuptyp" style="display:none">
						<label for="tag-name">Link Type*</label>
						<select name="lstpopuptyp" id="lstpopuptyp">
						<option value="text">Text</option>
						<option value="image">Image</option>
						<option value="button">Button</option>
						 </select>
						<p></p>
					</div>
   					<div class="form-field popuptyptxt" style="display:none">
						<label for="tag-name" id="cnplbllink">Link Label*</label>
						<input type="text" size="40" id="txtpopuptxt" name="txtpopuptxt" />
						<p></p>
					</div>
					<div class="form-field popuptypimg" style="display:none">
						<label for="tag-name">Upload Image*</label>
						<input type="file" size="40" id="txtpopupimg" name="txtpopupimg" />
						<p></p>
					</div>
					<div class="form-field cnplstfrmsts" >
						<label for="tag-name">No Valid Form Message</label>
						<textarea id="txterrortxt" name="txterrortxt" >No donations are accepted at this time</textarea>
					<p></p>
					</div>
					<div class="form-field cnplstfrmsts" >
						<label for="tag-name">Status</label>
						<select name="lstfrmsts" id="lstfrmsts"><option value="">Active</option>
						<option value="inline">Inactive</option></select>
						<p></p>
					</div>
					<p class="submit">

						<input type="button" value="Save" class="button-primary" id="cnpbtnsubmit" name="cnpbtnsubmit" class="add-new-h2"/>
						<input type="button" name="cnpbtncancel" id="cnpbtncancel" value="Cancel" class="button-primary" onclick="window.history.go(-1); return false;">

					<input type="hidden" name="addformval" id="addformval" value='.$hidval.'>
					<input type="hidden" name="hidnoofforms" id="hidnoofforms">
					<input type="hidden" name="hdncnpformname1" id="hdncnpformname1">
					</p>

					<div style="float:left"  width="100%">
					<div class=" frmadddiv" style ="display:none">
					<p>Select your Connect campaign, choose a payment form, enter a start date and click SAVE. Copy the shortcode from Click & Pledge Form Groups page to enter on your WordPress page. Multiple forms may be added to display in order by start date. If dates overlap, the first form in the list will show.</p><p></p>

			              <table class="wp-list-table widefat" id="cnpformslist" >
						  <thead><tr><th><u>Campaign*</u></th><th><u>Form*</u></th><th><u>Form GUID*</u></th><th><u>Start Date*</u></th><th><u>End Date</u></th><th></th></tr>
						  </thead><tbody>
						  <tr><td><u><input type="hidden" name="hdncnpformcnt[]" id="hdncnpformcnt[]" value=1><select name="lstcnpactivecamp1" id="lstcnpactivecamp1" onchange=getActiveForms(1); class="cnp_forms_select"><option value="">Select Campaign</option></select></u><span class=cnperror id="spncampnname1"></span></td>
						  <td><u><select name="lstcnpfrmtyp1" id="lstcnpfrmtyp1" onchange=getActiveGUID(1); class="cnp_forms_select"><option value="">Select Forms</option></select></u><span class=cnperror id="spnformname1"></span></td>
						  <td><u><input type="text" size="20" id="txtcnpguid1" name="txtcnpguid1"  readonly/></u></td>
				          <td><div class="input-group date" id="datetimepicker3"><u><input type="text" size="13" id="txtcnpformstrtdt1" name="txtcnpformstrtdt1"/><span class=cnperror id="spnstrtdt1"></span></u></div></td>
						  <td><div class="input-group date" id="datetimepicker4"><u><input type="text" size="13" id="txtcnpformenddt1" name="txtcnpformenddt1"/><span class=cnperror id="spnenddt1"></span></u></div></td>
						  <td><u><input type="button"name="cnpbtndelte" id="cnpbtndelte" value="Delete" onclick="getDeleteFormrows(1)" class="add-new-h2"></u></td></tr>
						  </tbody></table>
						  <div><table class="wp-list-table widefat" id="ist" >
						 <tr><td>
						 <div style="float:right">
						 <input type="button" name="cnpbtnadd" id="cnpbtnadd" value="Add Form" class="add-new-h2"><div >
						 </td></tr>
						 </table>
						 </div>
						 <div style="text-align-last:center;">
						 <div>

						 <input type="button" name="cnpbtnclose" id="cnpbtnclose" value="Close" class="add-new-h2" onclick="window.history.go(-1); return false;">
						 <input type="submit" name="cnpbtnsave" id="cnpbtnsave" value="Save" class="add-new-h2">

						 </div></div>
						 </div>
						</form>
			        </div>
		        </div>
	         </div>
         </div>
      ';
echo $cnpdsplycntnt;
}
 }
ob_clean();
?>
