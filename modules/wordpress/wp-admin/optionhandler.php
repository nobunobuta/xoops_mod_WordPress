<?php
/**
** get_option_widget()
** parameters:
** option_result - result set containing option_id, option_name, option_type,
**                 option_value, option_description, option_admin_level
** editable      - flag to determine whether the returned widget will be editable
**/
function &get_option_formElement($option_result, $editable=true, $between="") {
    global $wpdb;
    $disabled = $editable ? '' : 'disabled';
    
    switch ($option_result->option_type) {
        case 1: // integer
        case 3: // string
        case 8: // float
        case 6:  // range -- treat same as integer for now!
			if (($option_result->option_type == 1) || ($option_result->option_type == 6)) {
				$width = 10;
			} elseif ($option_result->option_width < 20) {
				$width = $option_result->option_width;
			} else {
				$width = 50;
			}
			$elem = new XoopsFormText($option_result->option_name, $option_result->option_name, $width, 150, htmlspecialchars($option_result->option_value, ENT_QUOTES));

			break;
        case 2: // boolean
			$elem = new XoopsFormSelect($option_result->option_name, "$option_result->option_name", $option_result->option_value);
			$elem->addOption("1","true");
			$elem->addOption("0","false");
			break;
        case 5: // select
			$elem = new XoopsFormSelect($option_result->option_name, "$option_result->option_name", $option_result->option_value);
			$select = $wpdb->get_results("SELECT optionvalue, optionvalue_desc "
										."FROM ".wp_table('optionvalues')." "
										."WHERE option_id = $option_result->option_id "
										."ORDER BY optionvalue_seq");
			if ($select) {
				foreach($select as $option) {
					$elem->addOption($option->optionvalue,$option->optionvalue_desc);
				}
			}
			break;
        case 7: // SQL select
			$sql = $wpdb->get_var("SELECT optionvalue FROM ".wp_table('optionvalues')." WHERE option_id = $option_result->option_id");
			if (!$sql) {
				$elem = new XoopsFormLabel($option_result->option_nam, $editable);
				break;
			}
			// now we may need to do table name substitution
			eval("include('../wp-config.php');\$sql = \"$sql\";");
			$elem = new XoopsFormSelect($option_result->option_name, "$option_result->option_name", $option_result->option_value);
            $select = $wpdb->get_results("$sql");
            if ($select) {
                foreach($select as $option) {
					$elem->addOption($option->value, $option->label);
                }
            }
			break;
		default:
			$elem = new XoopsFormLabel($option_result->option_nam, $editable);
	}
	if ($option_result->option_description) {
		$elem->setDescription(replace_constant($option_result->option_description));
	}
	$elem->setExtra($disabled);
	
	return $elem;
}

function validate_option($option, $name, $val) {
    global $wpdb;
    $msg = '';
    switch ($option->option_type) {
        case 6: // range
            // get range
            $range = $wpdb->get_row("SELECT optionvalue_max, optionvalue_min FROM ".wp_table('optionvalues')." WHERE option_id = $option->option_id");
            if ($range) {
                if (($val < $range->optionvalue_min) || ($val > $range->optionvalue_max)) {
                    $msg = "$name is outside the valid range ($range->optionvalue_min - $range->optionvalue_max). ";
                }
            }
    } // end switch
    return $msg;
} // end validate_option

// ADD Function ***********************
function replace_constant($constant) {
     if (defined($constant)) {
          return constant($constant);
     } else {
          return $constant;
     }
}
?>