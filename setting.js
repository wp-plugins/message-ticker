// JavaScript Document
function mt_submit()
{
	if(document.form_mt.mt_text.value=="")
	{
		alert("Please enter the text.")
		document.form_mt.mt_text.focus();
		return false;
	}
	else if(document.form_mt.mt_status.value=="")
	{
		alert("Please select the display status.")
		document.form_mt.mt_status.focus();
		return false;
	}
	else if(document.form_mt.mt_order.value=="")
	{
		alert("Please enter the display order, only number.")
		document.form_mt.mt_order.focus();
		return false;
	}
	else if(isNaN(document.form_mt.mt_order.value))
	{
		alert("Please enter the display order, only number.")
		document.form_mt.mt_order.focus();
		return false;
	}
	_mt_escapeVal(document.form_mt.mt_text,'<br>');
}

function _mt_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_hsa.action="options-general.php?page=message-ticker/message-ticker.php&AC=DEL&DID="+id;
		document.frm_hsa.submit();
	}
}	

function _mt_redirect()
{
	window.location = "options-general.php?page=message-ticker/message-ticker.php";
}

function _mt_escapeVal(textarea,replaceWith)
{
textarea.value = escape(textarea.value) //encode textarea strings carriage returns
for(i=0; i<textarea.value.length; i++)
{
	//loop through string, replacing carriage return encoding with HTML break tag
	if(textarea.value.indexOf("%0D%0A") > -1)
	{
		//Windows encodes returns as \r\n hex
		textarea.value=textarea.value.replace("%0D%0A",replaceWith)
	}
	else if(textarea.value.indexOf("%0A") > -1)
	{
		//Unix encodes returns as \n hex
		textarea.value=textarea.value.replace("%0A",replaceWith)
	}
	else if(textarea.value.indexOf("%0D") > -1)
	{
		//Macintosh encodes returns as \r hex
		textarea.value=textarea.value.replace("%0D",replaceWith)
	}
}
textarea.value=unescape(textarea.value) //unescape all other encoded characters
}