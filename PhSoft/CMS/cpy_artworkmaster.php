<?php

// art_year
// type_id
// art_title1
// art_title2
// art_size
// art_image

?>
<?php if ($cpy_artwork->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_cpy_artworkmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($cpy_artwork->art_year->Visible) { // art_year ?>
		<tr id="r_art_year">
			<td class="col-sm-2"><?php echo $cpy_artwork->art_year->FldCaption() ?></td>
			<td<?php echo $cpy_artwork->art_year->CellAttributes() ?>>
<span id="el_cpy_artwork_art_year">
<span<?php echo $cpy_artwork->art_year->ViewAttributes() ?>>
<?php echo $cpy_artwork->art_year->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_artwork->type_id->Visible) { // type_id ?>
		<tr id="r_type_id">
			<td class="col-sm-2"><?php echo $cpy_artwork->type_id->FldCaption() ?></td>
			<td<?php echo $cpy_artwork->type_id->CellAttributes() ?>>
<span id="el_cpy_artwork_type_id">
<span<?php echo $cpy_artwork->type_id->ViewAttributes() ?>>
<?php echo $cpy_artwork->type_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_artwork->art_title1->Visible) { // art_title1 ?>
		<tr id="r_art_title1">
			<td class="col-sm-2"><?php echo $cpy_artwork->art_title1->FldCaption() ?></td>
			<td<?php echo $cpy_artwork->art_title1->CellAttributes() ?>>
<span id="el_cpy_artwork_art_title1">
<span<?php echo $cpy_artwork->art_title1->ViewAttributes() ?>>
<?php echo $cpy_artwork->art_title1->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_artwork->art_title2->Visible) { // art_title2 ?>
		<tr id="r_art_title2">
			<td class="col-sm-2"><?php echo $cpy_artwork->art_title2->FldCaption() ?></td>
			<td<?php echo $cpy_artwork->art_title2->CellAttributes() ?>>
<span id="el_cpy_artwork_art_title2">
<span<?php echo $cpy_artwork->art_title2->ViewAttributes() ?>>
<?php echo $cpy_artwork->art_title2->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_artwork->art_size->Visible) { // art_size ?>
		<tr id="r_art_size">
			<td class="col-sm-2"><?php echo $cpy_artwork->art_size->FldCaption() ?></td>
			<td<?php echo $cpy_artwork->art_size->CellAttributes() ?>>
<span id="el_cpy_artwork_art_size">
<span<?php echo $cpy_artwork->art_size->ViewAttributes() ?>>
<?php echo $cpy_artwork->art_size->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_artwork->art_image->Visible) { // art_image ?>
		<tr id="r_art_image">
			<td class="col-sm-2"><?php echo $cpy_artwork->art_image->FldCaption() ?></td>
			<td<?php echo $cpy_artwork->art_image->CellAttributes() ?>>
<span id="el_cpy_artwork_art_image">
<span>
<?php echo ew_GetFileViewTag($cpy_artwork->art_image, $cpy_artwork->art_image->ListViewValue()) ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
