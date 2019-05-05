<?php

// type_id
// kind_id
// exhib_year
// exhib_title1
// exhib_title2
// exhib_date
// exhib_from
// exhib_to
// exhib_image

?>
<?php if ($cpy_exhibition->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_cpy_exhibitionmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($cpy_exhibition->type_id->Visible) { // type_id ?>
		<tr id="r_type_id">
			<td class="col-sm-2"><?php echo $cpy_exhibition->type_id->FldCaption() ?></td>
			<td<?php echo $cpy_exhibition->type_id->CellAttributes() ?>>
<span id="el_cpy_exhibition_type_id">
<span<?php echo $cpy_exhibition->type_id->ViewAttributes() ?>>
<?php echo $cpy_exhibition->type_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_exhibition->kind_id->Visible) { // kind_id ?>
		<tr id="r_kind_id">
			<td class="col-sm-2"><?php echo $cpy_exhibition->kind_id->FldCaption() ?></td>
			<td<?php echo $cpy_exhibition->kind_id->CellAttributes() ?>>
<span id="el_cpy_exhibition_kind_id">
<span<?php echo $cpy_exhibition->kind_id->ViewAttributes() ?>>
<?php echo $cpy_exhibition->kind_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_year->Visible) { // exhib_year ?>
		<tr id="r_exhib_year">
			<td class="col-sm-2"><?php echo $cpy_exhibition->exhib_year->FldCaption() ?></td>
			<td<?php echo $cpy_exhibition->exhib_year->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_year">
<span<?php echo $cpy_exhibition->exhib_year->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_year->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title1->Visible) { // exhib_title1 ?>
		<tr id="r_exhib_title1">
			<td class="col-sm-2"><?php echo $cpy_exhibition->exhib_title1->FldCaption() ?></td>
			<td<?php echo $cpy_exhibition->exhib_title1->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_title1">
<span<?php echo $cpy_exhibition->exhib_title1->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_title1->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title2->Visible) { // exhib_title2 ?>
		<tr id="r_exhib_title2">
			<td class="col-sm-2"><?php echo $cpy_exhibition->exhib_title2->FldCaption() ?></td>
			<td<?php echo $cpy_exhibition->exhib_title2->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_title2">
<span<?php echo $cpy_exhibition->exhib_title2->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_title2->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_date->Visible) { // exhib_date ?>
		<tr id="r_exhib_date">
			<td class="col-sm-2"><?php echo $cpy_exhibition->exhib_date->FldCaption() ?></td>
			<td<?php echo $cpy_exhibition->exhib_date->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_date">
<span<?php echo $cpy_exhibition->exhib_date->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_date->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_from->Visible) { // exhib_from ?>
		<tr id="r_exhib_from">
			<td class="col-sm-2"><?php echo $cpy_exhibition->exhib_from->FldCaption() ?></td>
			<td<?php echo $cpy_exhibition->exhib_from->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_from">
<span<?php echo $cpy_exhibition->exhib_from->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_from->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_to->Visible) { // exhib_to ?>
		<tr id="r_exhib_to">
			<td class="col-sm-2"><?php echo $cpy_exhibition->exhib_to->FldCaption() ?></td>
			<td<?php echo $cpy_exhibition->exhib_to->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_to">
<span<?php echo $cpy_exhibition->exhib_to->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_to->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_image->Visible) { // exhib_image ?>
		<tr id="r_exhib_image">
			<td class="col-sm-2"><?php echo $cpy_exhibition->exhib_image->FldCaption() ?></td>
			<td<?php echo $cpy_exhibition->exhib_image->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_image">
<span>
<?php echo ew_GetFileViewTag($cpy_exhibition->exhib_image, $cpy_exhibition->exhib_image->ListViewValue()) ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
