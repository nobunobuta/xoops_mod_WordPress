<?php
	include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	$form = new XoopsThemeForm($form_title, $form_id, "categories.php");

	$form->addElement(new XoopsFormText(_LANG_C_NAME_SUBCAT, "cat_name", 50, 150, $cat_name), true);

	$formcat = new XoopsFormSelect(_LANG_C_NAME_PARENT, "cat", $category_parent);
	$formcat->addOption("0", 'None');
	wp_dropdown_cats_xoops($formcat, $cat_ID, $category_parent);
	$form->addElement($formcat);

	$form->addElement(new XoopsFormTextArea(_LANG_C_NAME_CATDESC ."(optional)", "category_description", $category_description, 10,80));

	if ($form_id == 'addcat') {
		$form->addElement(new XoopsFormButton("", "submit", _LANG_C_NAME_ADDBTN, "submit"));
		$form->addElement(new XoopsFormHidden("action", "addcat"));
	} elseif ($form_id == 'editcat') {
		$form->addElement(new XoopsFormButton("", "submit", _LANG_C_NAME_EDITBTN, "submit"));
		$form->addElement(new XoopsFormHidden("cat_ID", $cat_ID));
		$form->addElement(new XoopsFormHidden("action", "editedcat"));
	}
	$form->display();
?>