<! DOCTYPE HTML PUBLIC « -//W3C//DTD HTML 4.01//FR » « http://www.w3.org/TR/html4/strict.dtd">


<html><head><title>Edit Records</title>


</head><body><?php

if ($error != '')
{
echo '<div style="padding:4px; border:1px solid red; color:red; » >'$error.' </div> »;
}
?>

<form action=" » method="post">
<input type="hidden » name="id » value="<?php echo $id; ?>"/>

<table border="1">

<tr><td colspan="2"><b><font color='Red'>Edit

Records</font></b></td></tr><tr>
<td
width="179"><b><font color='#663300'>Name<em>*</em></font></b></td>
<td><label><input type="text » name="name » value="<?php echo $name; ?> » />