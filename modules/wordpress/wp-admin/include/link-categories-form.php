<?php
	include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	$form = new XoopsThemeForm($form_title, $form_id, "");

	$form_name = new XoopsFormElementTray(_LANG_WLC_SUBEDIT_NAME);
	$form->addElement($form_name);

	$form_name->addElement(new XoopsFormText("", "cat_name", 25, 150, $cat_name),true);

	$form_auto_toggle = new XoopsFormCheckBox("", "auto_toggle", $auto_toggle);
	$form_auto_toggle->addOption("Y",_LANG_WLC_SUBEDIT_TOGGLE);
	$form_name->addElement($form_auto_toggle);

	$form_style = new XoopsFormElementTray(_LANG_WLC_SUBEDIT_SHOW);
	$form->addElement($form_style);
	
	$form_show_images = new XoopsFormCheckBox("", "show_images", $show_images);
	$form_show_images->addOption("Y",_LANG_WLC_SUBEDIT_IMAGES);
	$form_style->addElement($form_show_images);
	
	$form_show_description = new XoopsFormCheckBox("", "show_description", $show_description);
	$form_show_description->addOption("Y",_LANG_WLC_SUBEDIT_DESC);
	$form_style->addElement($form_show_description);

	$form_show_rating = new XoopsFormCheckBox("", "show_rating", $show_rating);
	$form_show_rating->addOption("Y",_LANG_WLC_SUBEDIT_RATE);
	$form_style->addElement($form_show_rating);

	$form_show_updated = new XoopsFormCheckBox("", "show_updated", $show_updated);
	$form_show_updated->addOption("Y",_LANG_WLC_SUBEDIT_UPDATE);
	$form_style->addElement($form_show_updated);

	$form_sort = new XoopsFormElementTray(_LANG_WLC_SUBEDIT_SORT);
	$form->addElement($form_sort);
	
	$form_sort_order = new XoopsFormSelect("", "sort_order", $sort_order);
	$form_sort_order->addOption("name",'Name');
	$form_sort_order->addOption("id",'Id');
	$form_sort_order->addOption("url",'URL');
	$form_sort_order->addOption("rating",'Rating');
	$form_sort_order->addOption("updated",'Updated');
	$form_sort_order->addOption("rand",'Random');
	$form_sort_order->addOption("length",'Name Length');
	$form_sort->addElement($form_sort_order);
	
	$form_sort_desc = new XoopsFormCheckBox("", "sort_desc", $sort_desc);
	$form_sort_desc->addOption("Y",_LANG_WLC_SUBEDIT_DESCEND);
	$form_sort->addElement($form_sort_desc);
	
	$form->addElement(new XoopsFormText(_LANG_WLC_SUBEDIT_BEFORE, "text_before_link", 45, 150, $text_before_link));
	$form->addElement(new XoopsFormText(_LANG_WLC_SUBEDIT_BETWEEN, "text_after_link", 45, 150, $text_after_link));
	$form->addElement(new XoopsFormText(_LANG_WLC_SUBEDIT_AFTER, "text_after_all", 45, 150, $text_after_all));

	$form_list_limit = new XoopsFormText(_LANG_WLC_SUBEDIT_LIMIT, "list_limit", 5, 5, $list_limit);
	$form_list_limit->setDescription("("._LANG_WLC_EPAGE_EMPTY.")");
	$form->addElement($form_list_limit);
	
	if ($form_id == 'addcat') {
		$form->addElement(new XoopsFormButton("", "submit", _LANG_WLC_ADDBUTTON_TEXT, "submit"));
		$form->addElement(new XoopsFormHidden("action", 'addcat'));
	} elseif ($form_id == 'editcat') {
		$form_button = new XoopsFormElementTray("");
		$form->addElement($form_button);

		$form_button->addElement(new XoopsFormButton("", "submit", _LANG_WLC_SAVEBUTTON_TEXT, "submit"));
		$form_button->addElement(new XoopsFormButton("", "submit", _LANG_WLC_CANCELBUTTON_TEXT, "submit"));

		$form->addElement(new XoopsFormHidden("action", 'editedcat'));
		$form->addElement(new XoopsFormHidden("cat_id", $row->cat_id));
	}
	$form->display();
?>
