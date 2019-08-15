<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/xml; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
//enter data
//	array('type'=>['PLC','BYSHR','BYGUAR','BYGUAREXEMPT','LLP','LLPDES']); // variant of type Наша основная константа типа компании
$type = 'BYSHR'; //correct constant BYSHR
//	array('country'=>['EW','SC','WA','NI']); //variant of country EW - константа
$country = 'EW'; //correct const EW
//UK country code.
//	array ('GB-ENG','GB-WLS','GB-SCT','GB-NIR','GBR','UNDEF'); // Константа
$country_code = 'GB-ENG';

// articles
//	array('BYSHRMODEL','BYGUARMODEL','PLCMODEL','BYSHAREAMEND','BYGUARAMEND','PLCAMEND','BESPOKE');//variant of articles
$articles = 'BYSHRMODEL'; //correct

$directorName = $_POST['directorName']; // director name
$directorPremise = $_POST['directorPremise']; // director Premise
$directorPostTown = $_POST['directorPostTown']; // director PostTown
$directorOtherForeignCountry = '';
$directorDOB = $_POST['directorDOB']; //date format 2019-01-07
$directorNationality = $_POST['directorNationality'];
$directorOccupation = $_POST['directorOccupation'];
$directorSameAsServiceAddress = 'true';

//PSC Const
$PSCPersonLawGoverned = 'string';
$PSCPersonLegalForm = 'string';

$RegistersHeldOnPublicRecord_data = array('LLPMembers' => 'false', 'LLPMembersURA' => 'false', 'Directors' => 'true', 'DirectorsURA' => 'false', 'Secretaries' => 'true', 'Members' => 'false', 'StateNoObjection' => 'false');
$RegisteredOfficeAddress_data = array('Premise' => $_POST['directorPremise'], 'PostTown' => $_POST['directorPostTown'], 'County' => '', 'Country' => $country, 'CareofName' => '', 'PoBox' => $_POST['directorPostTown']);

// $LLPNatureOfControl =''; // below array
// //The nature of control for Limited Liability Partnerships
// $LLPNatureOfControl= "RIGHTTOSHARESURPLUSASSETS_25TO50PERCENT";//The PSC holds, directly or indirectly, the right to share in more than 25% but not more than 50% of any surplus assets of the LLP on a winding up
// $LLPNatureOfControl= "RIGHTTOSHARESURPLUSASSETS_50TO75PERCENT";//The PSC holds, directly or indirectly, the right to share in more than 50% but less than 75% of any surplus assets of the LLP on a winding up
// $LLPNatureOfControl= "RIGHTTOSHARESURPLUSASSETS_75TO100PERCENT";//The PSC holds, directly or indirectly, the right to share in 75% or more of any surplus assets of the LLP on a winding up
// $LLPNatureOfControl= "RIGHTTOSHARESURPLUSASSETS_25TO50PERCENT_AS_TRUST";//The PSC has significant control over a trust and the trustees of that trust hold, directly or indirectly the right to share in more than 25% but not more than 50% of any surplus assets of the LLP on a winding up
// $LLPNatureOfControl= "RIGHTTOSHARESURPLUSASSETS_50TO75PERCENT_AS_TRUST";//The PSC has significant control over a trust and the trustees of that trust hold, directly or indirectly the right to share in more than 50% but less than 75% of any surplus assets of the LLP on a winding up
// $LLPNatureOfControl= "RIGHTTOSHARESURPLUSASSETS_75TO100PERCENT_AS_TRUST";//The PSC has significant control over a trust and the trustees of that trust hold, directly or indirectly the right to share in 75% or more of any surplus assets of the LLP on a winding up
// $LLPNatureOfControl= "RIGHTTOSHARESURPLUSASSETS_25TO50PERCENT_AS_FIRM";//The PSC has significant control over a firm and the members of that firm hold, directly or indirectly the right to share in more than 25% but not more than 50% of any surplus assets of the LLP on a winding up
// $LLPNatureOfControl= "RIGHTTOSHARESURPLUSASSETS_50TO75PERCENT_AS_FIRM";//The PSC has significant control over a firm and the members of that firm hold, directly or indirectly the right to share in more than 50% but less than 75% of any surplus assets of the LLP on a winding up
// $LLPNatureOfControl= "RIGHTTOSHARESURPLUSASSETS_75TO100PERCENT_AS_FIRM";//The PSC has significant control over a firm and the members of that firm hold, directly or indirectly the right to share in 75% or more of any surplus assets of the LLP on a winding up
// $LLPNatureOfControl= "VOTINGRIGHTS_25TO50PERCENT";//The PSC holds, directly or indirectly more than 25% but not more than 50% of the voting rights in the LLP
// $LLPNatureOfControl= "VOTINGRIGHTS_50TO75PERCENT";//The PSC holds, directly or indirectly more than 50% but less than 75% of the voting rights in the LLP
// $LLPNatureOfControl= "VOTINGRIGHTS_75TO100PERCENT";//The PSC holds, directly or indirectly 75% or more of the voting rights in the LLP
// $LLPNatureOfControl= "VOTINGRIGHTS_25TO50PERCENT_AS_TRUST";//The PSC has significant control over a trust and the trustees of that trust hold, directly or indirectly more than 25% but not more than 50% of the voting rights in the LLP
// $LLPNatureOfControl= "VOTINGRIGHTS_50TO75PERCENT_AS_TRUST";//The PSC has significant control over a trust and the trustees of that trust hold, directly or indirectly more than 50% but less than 75% of the voting rights in the LLP
// $LLPNatureOfControl= "VOTINGRIGHTS_75TO100PERCENT_AS_TRUST";//The PSC has significant control over a trust and the trustees of that trust hold, directly or indirectly 75% or more of the voting rights in the LLP
// $LLPNatureOfControl= "VOTINGRIGHTS_25TO50PERCENT_AS_FIRM";//The PSC has significant control over a firm and the members of that firm hold, directly or indirectly more than 25% but not more than 50% of the voting rights in the LLP
// $LLPNatureOfControl= "VOTINGRIGHTS_50TO75PERCENT_AS_FIRM";//The PSC has significant control over a firm and the members of that firm hold, directly or indirectly more than 50% but less than 75% of the voting rights in the LLP
// $LLPNatureOfControl= "VOTINGRIGHTS_75TO100PERCENT_AS_FIRM";//The PSC has significant control over a firm and the members of that firm hold, directly or indirectly 75% or more of the voting rights in the LLP
// $LLPNatureOfControl= "RIGHTTOAPPOINTANDREMOVEMEMBERS";//The PSC has the right to appoint/remove, directly or indirectly, a majority of the members who are entitled to take part in the management of the LLP
// $LLPNatureOfControl= "RIGHTTOAPPOINTANDREMOVEMEMBERS_AS_TRUST";//The PSC has significant control over a trust and the trustees of that trust have the right to appoint/remove, directly or indirectly, a majority of the members who are entitled to take part in the management of the LLP
// $LLPNatureOfControl= "RIGHTTOAPPOINTANDREMOVEMEMBERS_AS_FIRM";//The PSC has significant control over a firm and the members of that firm have the right to appoint/remove, directly or indirectly, a majority of the members who are entitled to take part in the management of the LLP
// $LLPNatureOfControl= "SIGINFLUENCECONTROL";//The PSC has the right to exercise, or actually exercises, significant influence or control over the LLP
// $LLPNatureOfControl= "SIGINFLUENCECONTROL_AS_TRUST";//The PSC has significant control over a trust and the trustees of that trust have the right to exercise, or actually exercises, significant influence or control over the LLP
// $LLPNatureOfControl= "SIGINFLUENCECONTROL_AS_FIRM"; //The PSC has significant control over a firm and the members of that firm have the right to exercise, or actually exercises, significant influence or control over the LLP

// end 	LLPNatureOfControl
//64205 64910 64922 70221
$SICCodes_data = array('64205', '64910', '64922', '70221');
$PERSONS = json_decode($_POST['Appointment'], true);
$companyInfo = json_decode($_POST['CompanyInfo'], true);
$GuarantorsType = 'Person';//Corporate or Person
$fileName = $companyInfo['companyName'] . '.xml';
$path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $companyInfo['id'] . '/';
//create a xml
$dom = new DOMDocument(); // Создаём XML-документ версии 1.0 с кодировкой utf-8

//$doc_type->setUserData('href','http://www.companieshouse.gov.uk/ef/xbrl/uk/fr/gaap/ae/2009-06-21/stylesheet/CH-AE-stylesheet.xsl');
//	$top = $dom->createElement('FormSubmission');
//	$top->setAttribute('xmlns',"http://www.xbrl.org/2003/instance http://www.xbrl.org/2003/xbrl-instance-2003-12-31.xsd"); //
//	$top->setAttribute('xmlns:bs',"http://xmlgw.companieshouse.gov.uk");
//	$top->setAttribute('xmlns:xs',"http://www.w3.org/2001/XMLSchema");
//	$top->setAttribute('xmlns:xsi',"http://www.w3.org/2001/XMLSchema-instance");
//	$top->setAttribute('xsi:schemaLocation',"http://xmlgw.companieshouse.gov.uk/v1-0/schema/forms/FormSubmission-v2-10.xsd");
//	$top->setAttribute('xmlns:xbrli',"http://www.xbrl.org/2003/instance");
//	$top->setAttribute('xmlns:link',"http://www.xbrl.org/2003/linkbase");
//	$top->setAttribute('xmlns:xlink',"http://www.w3.org/1999/xlink");


//	$top->setAttribute("xmlns", 'http://xmlgw.companieshouse.gov.uk');
//	$top->setAttribute("xsi:schemaLocation", 'http://xmlgw.companieshouse.gov.uk http://xmlgw.companieshouse.gov.uk/v1-0/schema/forms/FormSubmission-v2-10.xsd');
//	$top->setAttribute("xmlns:xsi", 'http://www.w3.org/1999/xhtml');
//	$top->setAttribute("xmlns:xbrli", 'http://www.xbrl.org/2003/instance http://www.xbrl.org/2003/xbrl-instance-2003-12-31.xsd');
//		$FormHeader=$dom->createElement('FormHeader');
//			$CompanyName = $dom->createElement('CompanyName',$companyInfo['companyName'].' LTD');
//			$PackageReference = $dom->createElement('PackageReference','1828');
//			$FormIdentifier = $dom->createElement('FormIdentifier','CompanyIncorporation');
//		$FormHeader->appendChild($CompanyName);
//		$FormHeader->appendChild($PackageReference);
//		$FormHeader->appendChild($FormIdentifier);
//	$top->appendChild($FormHeader);
//	$Form=$dom->createElement('Form');
//<xbrl xmlns='http://www.xbrl.org/2003/instance' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:ae='http://www.companieshouse.gov.uk/ef/xbrl/uk/fr/gaap/ae/2009-06-21' xmlns:gc='http://www.xbrl.org/uk/fr/gcd/2004-12-01' xmlns:html='http://www.w3.org/1999/xhtml' xmlns:iso4217='http://www.xbrl.org/2003/iso4217' xmlns:link='http://www.xbrl.org/2003/linkbase' xmlns:pt='http://www.xbrl.org/uk/fr/gaap/pt/2004-12-01' xmlns:xbrli='http://www.xbrl.org/2003/instance' xmlns:xlink='http://www.w3.org/1999/xlink'>
//<link:schemaRef xlink:href='http://www.companieshouse.gov.uk/ef/xbrl/uk/fr/gaap/ae/2009-06-21/uk-gaap-ae-2009- 06-21.xsd' xlink:type='simple' />
$xbrl = $dom->createElement("xbrl"); // Создаём корневой элемент
$root = $dom->createElement("CompanyIncorporation"); // Создаём корневой элемент
$xbrl->setAttribute("xmlns", 'http://www.xbrl.org/2003/instance');
$xbrl->setAttribute("xmlns:xsi", 'http://www.w3.org/2001/XMLSchema-instance');
//	$root->setAttribute('xmlns:xbrli',"http://www.xbrl.org/2003/instance");
$xbrl->setAttribute('xmlns:link', "http://www.xbrl.org/2003/linkbase");
//	$root->setAttribute('xmlns:xlink',"http://www.w3.org/1999/xlink");
//	$xbrl->setAttribute("xsi:schemaLocation", 'http://xmlgw.companieshouse.gov.uk/v1-0/schema/forms/CompanyIncorporation-v3-2.xsd');
$link = $dom->createElement('link:schemaRef');
$link->setAttribute('xlink:href', 'http://www.xbrl.org/2003/XLink'); ///http://resources.companieshouse.gov.uk/ef/xbrl/uk/fr/gaap/ae/2009-06-21/uk-gaap-ae-2009-06-21.xsd
$link->setAttribute('xlink:type', 'simple');
$xbrl->appendChild($link);
$root->setAttribute("xmlns", 'http://www.xbrl.org/2003/instance');
$root->setAttribute("xmlns:xsi", 'http://xmlgw.companieshouse.gov.uk/v1-0/schema');
$root->setAttribute("xsi:schemaLocation", 'http://xmlgw.companieshouse.gov.uk/v1-0/schema/forms/CompanyIncorporation-v3-2.xsd');
$root->setAttribute("id", 'CompanyInc');


$CompanyType = $dom->createElement('CompanyType', $type); // only this data
$root->appendChild($CompanyType);
if ($type == 'BYSHR' || $type == 'BYGUAR') {
    $Cic = $dom->createElement('Cic', 'true');
    $root->appendChild($Cic);
}

$RegistersHeldOnPublicRecord = $dom->createElement('RegistersHeldOnPublicRecord');
$LLPMembers = $dom->createElement('LLPMembers', $RegistersHeldOnPublicRecord_data['LLPMembers']);
$LLPMembersURA = $dom->createElement('LLPMembersURA', $RegistersHeldOnPublicRecord_data['LLPMembersURA']);
$Directors = $dom->createElement('Directors', $RegistersHeldOnPublicRecord_data['Directors']);
$DirectorsURA = $dom->createElement('DirectorsURA', $RegistersHeldOnPublicRecord_data['DirectorsURA']);
$Secretaries = $dom->createElement('Secretaries', $RegistersHeldOnPublicRecord_data['Secretaries']);
$Members = $dom->createElement('Members', $RegistersHeldOnPublicRecord_data['Members']);
$PSC = $dom->createElement('PSC');
$StateNoObjection = $dom->createElement('StateNoObjection', $RegistersHeldOnPublicRecord_data['StateNoObjection']);
$PSC->appendChild($StateNoObjection);
$RegistersHeldOnPublicRecord->appendChild($LLPMembers);
$RegistersHeldOnPublicRecord->appendChild($LLPMembersURA);
$RegistersHeldOnPublicRecord->appendChild($Directors);
$RegistersHeldOnPublicRecord->appendChild($DirectorsURA);
$RegistersHeldOnPublicRecord->appendChild($Secretaries);
$RegistersHeldOnPublicRecord->appendChild($Members);
$RegistersHeldOnPublicRecord->appendChild($PSC);
$root->appendChild($RegistersHeldOnPublicRecord);

$CountryOfIncorporation = $dom->createElement('CountryOfIncorporation', $country);
$root->appendChild($CountryOfIncorporation);

$RegisteredOfficeAddress = $dom->createElement('RegisteredOfficeAddress');
$Premise = $dom->createElement('Premise', $RegisteredOfficeAddress_data['Premise']);
$PostTown = $dom->createElement('PostTown', $RegisteredOfficeAddress_data['PostTown']);
$County = $dom->createElement('County', $RegisteredOfficeAddress_data['County']);
$Country = $dom->createElement('Country', $RegisteredOfficeAddress_data['Country']);
$CareofName = $dom->createElement('CareofName', $RegisteredOfficeAddress_data['CareofName']);
$PoBox = $dom->createElement('PoBox', $RegisteredOfficeAddress_data['PoBox']);
$RegisteredOfficeAddress->appendChild($Premise);
$RegisteredOfficeAddress->appendChild($PostTown);
$RegisteredOfficeAddress->appendChild($County);
$RegisteredOfficeAddress->appendChild($Country);
$RegisteredOfficeAddress->appendChild($CareofName);
$RegisteredOfficeAddress->appendChild($PoBox);
$root->appendChild($RegisteredOfficeAddress);

$Articles = $dom->createElement('Articles', $articles);
$root->appendChild($Articles);

$RestrictedArticles = $dom->createElement('RestrictedArticles', 'true');// variant boolean 'The company has legal restriction on changes to its articles'
$root->appendChild($RestrictedArticles);
//Director
//Secretary
//Member

foreach ($PERSONS as $item) {
    if ($item['Director'] == 'true') {
        $Appointment = $dom->createElement('Appointment');
        $ConsentToAct = $dom->createElement('ConsentToAct', 'false');
        $Director = $dom->createElement('Director');
        $Person = $dom->createElement('Person');
        $Forename = $dom->createElement('Forename', $item['firstName']);
        $Surname = $dom->createElement('Surname', $item['lastName']);
        $ServiceAddress = $dom->createElement('ServiceAddress');
        $Address = $dom->createElement('Address');
        $Premise = $dom->createElement('Premise', $item['apartament']);
        $PostTown = $dom->createElement('PostTown', $item['zip']);
        $OtherForeignCountry = $dom->createElement('OtherForeignCountry', '');
        $Address->appendChild($Premise);
        $Address->appendChild($PostTown);
        $Address->appendChild($OtherForeignCountry);
        $ServiceAddress->appendChild($Address);
        $DOB = $dom->createElement('DOB', $item['dateBirth']);
        $Nationality = $dom->createElement('Nationality', $item['nationality']);
        $Occupation = $dom->createElement('Occupation', $item['occupation']);
        $ResidentialAddress = $dom->createElement('ResidentialAddress');
        $SameAsServiceAddress = $dom->createElement('SameAsServiceAddress', 'true');
        $ResidentialAddress->appendChild($SameAsServiceAddress);
        $Person->appendChild($Forename);
        $Person->appendChild($Surname);
        $Person->appendChild($ServiceAddress);
        $Person->appendChild($DOB);
        $Person->appendChild($Nationality);
        $Person->appendChild($Occupation);
        $Person->appendChild($ResidentialAddress);
        $Director->appendChild($Person);
        $Appointment->appendChild($ConsentToAct);
        $Appointment->appendChild($Director);
        $root->appendChild($Appointment);
    }
    if ($item['Secretary'] == 'true') {
        $Appointment = $dom->createElement('Appointment');
        $ConsentToAct = $dom->createElement('ConsentToAct', 'false');
        $Director = $dom->createElement('Secretary');
        $Person = $dom->createElement('Person');
        $Forename = $dom->createElement('Forename', $item['firstName']);
        $Surname = $dom->createElement('Surname', $item['lastName']);
        $ServiceAddress = $dom->createElement('ServiceAddress');
        $Address = $dom->createElement('Address');
        $Premise = $dom->createElement('Premise', $item['apartament']);
        $PostTown = $dom->createElement('PostTown', $item['zip']);
        $OtherForeignCountry = $dom->createElement('OtherForeignCountry', '');
        $Address->appendChild($Premise);
        $Address->appendChild($PostTown);
        $Address->appendChild($OtherForeignCountry);
        $ServiceAddress->appendChild($Address);
        $DOB = $dom->createElement('DOB', $item['dateBirth']);
        $Nationality = $dom->createElement('Nationality', $item['nationality']);
        $Occupation = $dom->createElement('Occupation', $item['occupation']);
        $ResidentialAddress = $dom->createElement('ResidentialAddress');
        $SameAsServiceAddress = $dom->createElement('SameAsServiceAddress', 'true');
        $ResidentialAddress->appendChild($SameAsServiceAddress);
        $Person->appendChild($Forename);
        $Person->appendChild($Surname);
        $Person->appendChild($ServiceAddress);
        $Person->appendChild($DOB);
        $Person->appendChild($Nationality);
        $Person->appendChild($Occupation);
        $Person->appendChild($ResidentialAddress);
        $Director->appendChild($Person);
        $Appointment->appendChild($ConsentToAct);
        $Appointment->appendChild($Director);
        $root->appendChild($Appointment);
    }
}

$PSCs = $dom->createElement('PSCs');
foreach ($PERSONS as $item) {
    if ($item['Director'] == 'true' || $item['SignaturyAuthorized'] == 'true') {
        $PSC = $dom->createElement('PSC');
        $PSCNotification = $dom->createElement('PSCNotification');
        $LegalPerson = $dom->createElement('LegalPerson');
        $LegalPersonName = $dom->createElement('LegalPersonName', $item['firstName'] . ' ' . $item['lastName']);
        $PSCAddress = $dom->createElement('Address');
        $PSCPremise = $dom->createElement('Premise', $item['apartament']);
        $PSCPostTown = $dom->createElement('PostTown', $item['zip']);
        $PSCOtherForeignCountry = $dom->createElement('OtherForeignCountry', '');
        $PSCAddress->appendChild($PSCPremise);
        $PSCAddress->appendChild($PSCPostTown);
        $PSCAddress->appendChild($PSCOtherForeignCountry);
        $LegalPersonIdentification = $dom->createElement('LegalPersonIdentification');
        $LawGoverned = $dom->createElement('LawGoverned', $PSCPersonLawGoverned);
        $LegalForm = $dom->createElement('LegalForm', $PSCPersonLegalForm);
        $LegalPersonIdentification->appendChild($LawGoverned);
        $LegalPersonIdentification->appendChild($LegalForm);
        $LegalPerson->appendChild($LegalPersonName);
        $LegalPerson->appendChild($PSCAddress);
        $LegalPerson->appendChild($LegalPersonIdentification);
        // $LLPNatureOfControls	= $dom->createElement('LLPNatureOfControls'); // to other company
        // 	$NatureOfControl = $dom->createElement('NatureOfControl', $LLPNatureOfControl); // to other company
        // $LLPNatureOfControls->appendChild($NatureOfControl); // to other company
        $PSCNotification->appendChild($LegalPerson);
        //			$PSCNotification->appendChild($LLPNatureOfControls); // to other company
        $PSC->appendChild($PSCNotification);
        $PSCs->appendChild($PSC);
    }
}
$root->appendChild($PSCs);

$StatementOfCapital = $dom->createElement('StatementOfCapital');
// Capital can be many
$Capital = $dom->createElement('Capital');
$TotalAmountUnpaid = $dom->createElement('TotalAmountUnpaid', '0');
$TotalNumberOfIssuedShares = $dom->createElement('TotalNumberOfIssuedShares', $companyInfo['AuthorizedShareCapital']);
$ShareCurrency = $dom->createElement('ShareCurrency', 'EUR'); //TST,YER,NIO // Not understand were is a normal data, currency format??
$TotalAggregateNominalValue = $dom->createElement('TotalAggregateNominalValue', $companyInfo['OrdinaryShare']);
// Shares can be many
$Shares = $dom->createElement('Shares');
$ShareClass = $dom->createElement('ShareClass', 'default');
$PrescribedParticulars = $dom->createElement('PrescribedParticulars', 'Dividend rights, Redeemable rights, Return of capital, Voting rights');
$NumShares = $dom->createElement('NumShares', $companyInfo['IssuedShareCapital']);
$AggregateNominalValue = $dom->createElement('AggregateNominalValue', ($companyInfo['AuthorizedShareCapital'] * $companyInfo['OrdinaryShare']));
$Shares->appendChild($ShareClass);
$Shares->appendChild($PrescribedParticulars);
$Shares->appendChild($NumShares);
$Shares->appendChild($AggregateNominalValue);
$Capital->appendChild($TotalAmountUnpaid);
$Capital->appendChild($TotalNumberOfIssuedShares);
$Capital->appendChild($ShareCurrency);
$Capital->appendChild($TotalAggregateNominalValue);
$Capital->appendChild($Shares);
$StatementOfCapital->appendChild($Capital);
$root->appendChild($StatementOfCapital);

foreach ($PERSONS as $item) {
    if ($item['Shareholder'] == 'true') {
        $Subscribers = $dom->createElement('Subscribers');
        $Person = $dom->createElement('Person');
        $Forename = $dom->createElement('Forename', $item['firstName']);
        $Surname = $dom->createElement('Surname', $item['lastName']);
        $Person->appendChild($Forename);
        $Person->appendChild($Surname);

        $Address = $dom->createElement('Address');
        $Premise = $dom->createElement('Premise', $item['apartament']);
        $PostTown = $dom->createElement('PostTown', $item['zip']);
        $OtherForeignCountry = $dom->createElement('OtherForeignCountry', '');
        $Address->appendChild($Premise);
        $Address->appendChild($PostTown);
        $Address->appendChild($OtherForeignCountry);

        $Authentication = $dom->createElement('Authentication');//may be many
        $PersonalAttribute = $dom->createElement('PersonalAttribute', 'PASSNO'); //PASSNO,DAD,NATINS Пасспорт и прочее
        $PersonalData = $dom->createElement('PersonalData', $item['passport']);
        $Authentication->appendChild($PersonalAttribute);
        $Authentication->appendChild($PersonalData);
        $Authentication = $dom->createElement('Authentication'); //may be many cycle
        $PersonalAttribute = $dom->createElement('PersonalAttribute', 'TEL');
        $PersonalData = $dom->createElement('PersonalData', $item['phone']);
        $Authentication->appendChild($PersonalAttribute);
        $Authentication->appendChild($PersonalData);

        $MemberClass = $dom->createElement('MemberClass', '');
        $Shares = $dom->createElement('Shares');
        $ShareClass = $dom->createElement('ShareClass', 'default');
        $NumShares = $dom->createElement('NumShares', ($companyInfo['AuthorizedShareCapital'] / 100 * $item['share']));
        $AmountPaidDuePerShare = $dom->createElement('AmountPaidDuePerShare', $companyInfo['OrdinaryShare']);
        $AmountUnpaidPerShare = $dom->createElement('AmountUnpaidPerShare', '0');
        $ShareCurrency = $dom->createElement('ShareCurrency', 'EUR'); //cyrrency type of
        $ShareValue = $dom->createElement('ShareValue', ($companyInfo['OrdinaryShare'] * ($companyInfo['AuthorizedShareCapital'] / 100 * $item['share'])));
        $ShareReference = $dom->createElement('ShareReference', '');
        $Shares->appendChild($ShareClass);
        $Shares->appendChild($NumShares);
        $Shares->appendChild($AmountPaidDuePerShare);
        $Shares->appendChild($AmountUnpaidPerShare);
        $Shares->appendChild($ShareCurrency);
        $Shares->appendChild($ShareValue);
        $Shares->appendChild($ShareReference);
        $Subscribers->appendChild($Person);
        $Subscribers->appendChild($Address);
        $Subscribers->appendChild($Authentication);
        $Subscribers->appendChild($MemberClass);
        $Subscribers->appendChild($Shares);

        $root->appendChild($Subscribers);
    }
}

//Statement of Guarantee bellow
//	$Guarantors = $dom->createElement('Guarantors'); //my be many in cycle
//		// if Corporate
//	if($GuarantorsType=='Corporate') {
//		$Corporate = $dom->createElement('Corporate');
//			$CorporateName = $dom->createElement('CorporateName', 'string');
//		$Corporate->appendChild($CorporateName);
//		$Address = $dom->createElement('Address');
//			$Premise = $dom->createElement('Premise', 'string');
//			$PostTown = $dom->createElement('PostTown', 'string');
//			$OtherForeignCountry = $dom->createElement('OtherForeignCountry', 'string');
//		$Address->appendChild($Premise);
//		$Address->appendChild($PostTown);
//		$Address->appendChild($OtherForeignCountry);
//		$Authentication = $dom->createElement('Authentication');
//			$PersonalAttribute = $dom->createElement('PersonalAttribute','string'); //BIRTOWN,NATINS,DAD
//			$PersonalData = $dom->createElement('PersonalData','string');
//		$Authentication->appendChild($PersonalAttribute);
//		$Authentication->appendChild($PersonalData);
//		$MemberClass = $dom->createElement('MemberClass','string');
//		$AmountGuaranteed = $dom->createElement('AmountGuaranteed','string');
//		$Guarantors->appendChild($Corporate);
//		$Guarantors->appendChild($Address);
//		$Guarantors->appendChild($Authentication);
//		$Guarantors->appendChild($MemberClass);
//		$Guarantors->appendChild($AmountGuaranteed);
//	}else if($GuarantorsType =='Person') {
//		// if Person
//		$Person = $dom->createElement('Person');
//			$Surname = $dom->createElement('Surname' ,'string');
//		$Person->appendChild($Surname);
//		$Address = $dom->createElement('Address');
//			$Premise = $dom->createElement('Premise', 'string');
//			$PostTown = $dom->createElement('PostTown', 'string');
//			$Country = $dom->createElement('Country','AUS'); //AUS string
//		$Address->appendChild($Premise);
//		$Address->appendChild($PostTown);
//		$Address->appendChild($Country);
//		$Authentication = $dom->createElement('Authentication');
//			$PersonalAttribute = $dom->createElement('PersonalAttribute','string'); //TEL,BIRTOWN,
//			$PersonalData = $dom->createElement('PersonalData','string');
//		$Authentication->appendChild($PersonalAttribute);
//		$Authentication->appendChild($PersonalData);
//		$AmountGuaranteed = $dom->createElement('AmountGuaranteed','string');
//		$Guarantors->appendChild($Person);
//		$Guarantors->appendChild($Address);
//		$Guarantors->appendChild($Authentication);
//		$Guarantors->appendChild($AmountGuaranteed);
//	}
//	$root->appendChild($Guarantors);
foreach ($PERSONS as $item) {
    if ($item['Director'] == 'true' || $item['SignaturyAuthorized'] == 'true')
        $Authoriser = $dom->createElement('Authoriser');
    $Member = $dom->createElement('Member'); // may be Agent,Solicitor,Member,Subscribers all in Authoriser
    $Person = $dom->createElement('Person');
    $Forename = $dom->createElement('Forename', $item['firstName']);
    $Surname = $dom->createElement('Surname', $item['lastName']);
    $Person->appendChild($Forename);
    $Person->appendChild($Surname);
    $Authentication = $dom->createElement('Authentication'); //may be many cycle
    $PersonalAttribute = $dom->createElement('PersonalAttribute', 'PASSNO');
    $PersonalData = $dom->createElement('PersonalData', $item['passport']);
    $Authentication->appendChild($PersonalAttribute);
    $Authentication->appendChild($PersonalData);
    $Authentication = $dom->createElement('Authentication'); //may be many cycle
    $PersonalAttribute = $dom->createElement('PersonalAttribute', 'TEL');
    $PersonalData = $dom->createElement('PersonalData', $item['phone']);
    $Authentication->appendChild($PersonalAttribute);
    $Authentication->appendChild($PersonalData);
    $Member->appendChild($Person);
    $Member->appendChild($Authentication);
    $Authoriser->appendChild($Member);
    $root->appendChild($Authoriser);
}
//Proposed officers below
$SameDay = $dom->createElement('SameDay', 'true'); //True to request incorporation to be perfomed the same day
$SameName = $dom->createElement('SameName', 'true'); //Indicates if supporting data is included to support the use of an existing name
$NameAuthorisation = $dom->createElement('NameAuthorisation', 'false'); //Indicates if supporting data is attached to support the allocation of a name needing authorisation
$RejectReference = $dom->createElement('RejectReference', '');// link to reject reference
$root->appendChild($SameDay);
$root->appendChild($SameName);
$root->appendChild($NameAuthorisation);
$root->appendChild($RejectReference);
//from test use 64205 64910 64922 70221 change to top
$SICCodes = $dom->createElement('SICCodes'); //minLength value="4" maxLength value="5";
foreach ($SICCodes_data as $code) {
    $SICCode = $dom->createElement('SICCode', $code); //may be many
    $SICCodes->appendChild($SICCode);
}


$root->appendChild($SICCodes);

$StateSingleMemberCompany = $dom->createElement('StateSingleMemberCompany', false); //This information is only required if the company has elected to keep it’s register of members’ information on the public record.
$root->appendChild($StateSingleMemberCompany);

//	$IncDesignation=$dom->createElement('IncDesignation', 'DIR'); //may be DIR,SEC,SOLICITOR

//	$Form->appendChild($root);
//	$top->appendChild($Form);
$xbrl->appendChild($root);
$dom->appendChild($xbrl);
//	$dom->appendChild($IncDesignation);

if (!file_exists($path . $fileName)) {
    mkdir($path);
}
$dom->save($path . $fileName); // save XML to file

echo $dom->saveXML();
