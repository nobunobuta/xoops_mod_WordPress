// smiles 
function bbinsert(formObj, strIns, strInsClose ) {
	theSelection = false; 
	if (document.selection) { 
		//formObj.wp_content.focus(); 
		theSelection = document.selection.createRange().text; // Get text selection 
		// Add tags around selection 
		document.selection.createRange().text = strIns + theSelection + strInsClose; 
		//formObj.wp_content.focus(); 
		theSelection = false; 
		return; 
	} 
	formObj.wp_content.value += strIns + strInsClose; 
	formObj.wp_content.focus(); 
	return; 
}
