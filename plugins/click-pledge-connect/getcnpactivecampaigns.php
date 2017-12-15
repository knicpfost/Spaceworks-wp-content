<?php
	define( 'CFCNP_PLUGIN_UID', "14059359-D8E8-41C3-B628-E7E030537905");
	define( 'CFCNP_PLUGIN_SKY', "5DC1B75A-7EFA-4C01-BDCD-E02C536313A3");
	$connect  = array('soap_version' => SOAP_1_1, 'trace' => 1, 'exceptions' => 0);
	$client   = new SoapClient('https://resources.connect.clickandpledge.com/wordpress/Auth2.wsdl', $connect);

	if( !isset($_REQUEST['CampaignId']) && isset($_REQUEST['AccountId_val']) && $_REQUEST['AccountId_val']!=""     && isset($_REQUEST['AccountGUId_val']) &&  $_REQUEST['AccountGUId_val']!="")
	{ 
		
		 $accountid            = $_REQUEST['AccountId_val'];
		 $accountguid          = $_REQUEST['AccountGUId_val'];
	$xmlr  = new SimpleXMLElement("<GetActiveCampaignList2></GetActiveCampaignList2>");
	$xmlr->addChild('accountId', $accountid);
	$xmlr->addChild('AccountGUID', $accountguid);
	$xmlr->addChild('username', CFCNP_PLUGIN_UID);
	$xmlr->addChild('password', CFCNP_PLUGIN_SKY);
	$response = $client->GetActiveCampaignList2($xmlr); 
    $responsearr =  $response->GetActiveCampaignList2Result->connectCampaign;
	 $camrtrnval = "<option value=''>Select Campaign Name</option>";
	 if(count($responsearr) == 1)
		{
		 $camrtrnval.= "<option value='".$responsearr->alias."'>".$responsearr->name."</option>";
		}else{
		for($inc = 0 ; $inc < count($responsearr);$inc++)
		{
		 $camrtrnval .= "<option value='".$responsearr[$inc]->alias."'>".$responsearr[$inc]->name."</option>";
		}

	 }echo $camrtrnval;
	

	}
	if( isset($_REQUEST['AccountId_val']) && $_REQUEST['AccountId_val']!="" && 
		isset($_REQUEST['AccountGUId_val']) &&  $_REQUEST['AccountGUId_val']!="" && 
		isset($_REQUEST['CampaignId']) &&  $_REQUEST['CampaignId']!="" )
	{

		$cnpaccountID      = $_REQUEST['AccountId_val'];
		$cnpaccountguidID  = $_REQUEST['AccountGUId_val'];
		$cnpcampaignId     = $_REQUEST['CampaignId'];
		$xmlr  = new SimpleXMLElement("<GetActiveFormList2></GetActiveFormList2>");
		$xmlr->addChild('accountId', $cnpaccountID);
		$xmlr->addChild('AccountGUID', $cnpaccountguidID);
		$xmlr->addChild('username', CFCNP_PLUGIN_UID);
		$xmlr->addChild('password', CFCNP_PLUGIN_SKY);
		$xmlr->addChild('campaignAlias', $cnpcampaignId);

		$frmresponse    =  $client->GetActiveFormList2($xmlr); 	
		$frmresponsearr =  $frmresponse->GetActiveFormList2Result->form;	
		 $rtrnval = "<option value=''>Select Form Name</option>";
		if(count($frmresponsearr) == 1)
		{
			$rtrnval.= "<option value='".$frmresponsearr->formGUID."'>".$frmresponsearr->formName."</option>";
		}else{
		for($finc = 0 ; $finc < count($frmresponsearr);$finc++)
		{
		 $rtrnval.= "<option value='".$frmresponsearr[$finc]->formGUID."'>".$frmresponsearr[$finc]->formName."</option>";
		}

	}
		echo $rtrnval;
	}
	
?>