<?php
	include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	
	$form = new XoopsThemeForm($form_title, $form_id, "link-manager.php");
	
	$form->addElement(new XoopsFormText(_LANG_WLA_SUB_URI, "linkurl", 50, 150, $link_url),true);

	$form->addElement(new XoopsFormText(_LANG_WLA_SUB_NAME, "name", 50, 150, $link_name),true);

	$form->addElement(new XoopsFormText(_LANG_WLA_SUB_RSS, "rss_uri", 50, 150, $link_rss_uri));

	$form->addElement(new XoopsFormText(_LANG_WLA_SUB_IMAGE, "image", 50, 150, $link_image));

	$form->addElement(new XoopsFormText(_LANG_WLA_SUB_DESC, "description", 50, 150, $link_description));

	$form->addElement(new XoopsFormText(_LANG_WLA_SUB_REL, "rel", 50, 150, $link_rel));

	$form_xfn = new XoopsFormElementTray('<a href="http://gmpg.org/xfn/">XFN</a>:','<br/>');

	$form_friendship = new XoopsFormRadio(_LANG_WLA_SUB_FRIEND."&nbsp;:&nbsp;", "friendship", $friendship);
	$form_friendship->setExtra('class="valinp"');
	$form_friendship->addOption("acquaintance", _LANG_WLA_CHECK_ACQUA);
	$form_friendship->addOption("friend", _LANG_WLA_CHECK_FRIE);
	$form_friendship->addOption("", _LANG_WLA_CHECK_NONE);
	$form_xfn->addElement($form_friendship);

	$form_physical = new XoopsFormCheckBox(_LANG_WLA_SUB_PHYSICAL."&nbsp;:&nbsp;", "physical", $physical);
	$form_physical->setExtra('class="valinp"');
	$form_physical->addOption("met",_LANG_WLA_CHECK_MET);
	$form_xfn->addElement($form_physical);

	$form_professional = new XoopsFormCheckBox(_LANG_WLA_SUB_PROFESSIONAL."&nbsp;:&nbsp;", "professional", $professional);
	$form_professional->setExtra('class="valinp"');
	$form_professional->addOption("co-worker",_LANG_WLA_CHECK_WORKER);
	$form_professional->addOption("colleague",_LANG_WLA_CHECK_COLL);
	$form_xfn->addElement($form_professional);

	$form_geographical = new XoopsFormRadio(_LANG_WLA_SUB_GEOGRAPH."&nbsp;:&nbsp;", "geographical", $geographical);
	$form_geographical->setExtra('class="valinp"');
	$form_geographical->addOption("co-resident",_LANG_WLA_CHECK_RESI);
	$form_geographical->addOption("neighbor",_LANG_WLA_CHECK_NEIG);
	$form_geographical->addOption("",_LANG_WLA_CHECK_NONE);
	$form_xfn->addElement($form_geographical);

	$form_family = new XoopsFormRadio(_LANG_WLA_SUB_FAMILY."&nbsp;:&nbsp;", "family", $family);
	$form_family->setExtra('class="valinp"');
	$form_family->addOption("child",_LANG_WLA_CHECK_CHILD);
	$form_family->addOption("parent",_LANG_WLA_CHECK_PARENT);
	$form_family->addOption("sibling",_LANG_WLA_CHECK_SIBLING);
	$form_family->addOption("spouse",_LANG_WLA_CHECK_SPOUSE);
	$form_family->addOption("",_LANG_WLA_CHECK_NONE);
	$form_xfn->addElement($form_family);

	$form_romantic = new XoopsFormCheckBox(_LANG_WLA_SUB_ROMANTIC."&nbsp;:&nbsp;", "romantic", $romantic);
	$form_romantic->setExtra('class="valinp"');
	$form_romantic->addOption("muse",_LANG_WLA_CHECK_MUSE);
	$form_romantic->addOption("crush",_LANG_WLA_CHECK_CRUSH);
	$form_romantic->addOption("date",_LANG_WLA_CHECK_DATE);
	$form_romantic->addOption("sweetheart",_LANG_WLA_CHECK_HEART);

	$form_xfn->addElement($form_romantic);

	$form->addElement($form_xfn);

	$form->addElement(new XoopsFormTextArea(_LANG_WLA_SUB_NOTE, "notes", $link_notes, 10,60));

	$form_rating = new XoopsFormSelect(_LANG_WLA_SUB_RATE, "rating", $link_rating);
	$form_rating->setDescription(_LANG_WLA_CHECK_ZERO);
    for ($r = 0; $r < 10; $r++) {
    	$form_rating->addOption($r,$r);
    }
	$form->addElement($form_rating);

	$form_target = new XoopsFormRadio(_LANG_WLA_SUB_TARGET, "target", $link_target);
	$form_target->setDescription(_LANG_WLA_CHECK_STRICT);
	$form_target->addOption('_blank', '_blank');
	$form_target->addOption('_top', '_top');
	$form_target->addOption('', "none");
	$form->addElement($form_target);
    
	$form_visible = new XoopsFormRadio(_LANG_WLA_SUB_VISIBLE, "visible", $link_visible);
	$form_visible->addOption('Y', 'Yes');
	$form_visible->addOption('N', 'No');
	$form->addElement($form_visible);

	$form_category = new XoopsFormSelect(_LANG_WLA_SUB_CAT, "category", $link_category);
	wp_dropdown_linkcat_xoops($form_category);
	$form->addElement($form_category);
	if ($form_id =='addlink') {
		$form->addElement(new XoopsFormButton("", "submit", _LANG_WLA_BUTTON_TEXTNAME, "submit"));
		$form->addElement(new XoopsFormHidden("action", 'Add'));
	} else if ($form_id =='editlink'){
		$form_button = new XoopsFormElementTray("");
		$form_button->addElement(new XoopsFormButton("", "submit", _LANG_WLM_SAVE_CHANGES, "submit"));
		$form_button->addElement(new XoopsFormButton("", "submit", _LANG_WLM_EDIT_CANCEL, "submit"));
		$form->addElement($form_button);

		$form->addElement(new XoopsFormHidden("action", 'editlink'));
		$form->addElement(new XoopsFormHidden("link_id", $link_id));
		$form->addElement(new XoopsFormHidden("order_by", $order_by));
		$form->addElement(new XoopsFormHidden("cat_id", $cat_id));
	}
	$form->display();
?>