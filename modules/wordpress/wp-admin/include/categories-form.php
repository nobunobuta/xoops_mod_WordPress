<?php
	include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	$_form = new XoopsThemeForm($_form_title, $_form_id, "categories.php");

	$_form->addElement(new XoopsFormText(_LANG_C_NAME_SUBCAT, "cat_name", 50, 150, $_form_cat_name), true);

	$_form_cat = new XoopsFormSelect(_LANG_C_NAME_PARENT, "category_parent", $_form_category_parent);
	$_form_cat->addOptionArray($_form_category_options);
	$_form->addElement($_form_cat);

	$_form->addElement(new XoopsFormTextArea(_LANG_C_NAME_CATDESC ."(optional)", "category_description", $_form_category_description, 10,80));

	if ($_form_id == 'addcat') {
		$_form->addElement(new XoopsFormButton("", "submit", _LANG_C_NAME_ADDBTN, "submit"));
		$_form->addElement(new XoopsFormHidden("action", "addcat"));
	} elseif ($_form_id == 'editcat') {
		$_form->addElement(new XoopsFormButton("", "submit", _LANG_C_NAME_EDITBTN, "submit"));
		$_form->addElement(new XoopsFormHidden("cat_ID", $_form_cat_ID));
		$_form->addElement(new XoopsFormHidden("action", "editedcat"));
	}
	$_form->addElement($GLOBALS['xoopsWPTicket']->getTicketXoopsForm(__LINE__,3600));
?>