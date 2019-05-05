<?php

// status_id
// page_name

?>
<?php if ($cpy_page->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_cpy_pagemaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($cpy_page->status_id->Visible) { // status_id ?>
		<tr id="r_status_id">
			<td class="col-sm-2"><?php echo $cpy_page->status_id->FldCaption() ?></td>
			<td<?php echo $cpy_page->status_id->CellAttributes() ?>>
<span id="el_cpy_page_status_id">
<span<?php echo $cpy_page->status_id->ViewAttributes() ?>>
<?php echo $cpy_page->status_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cpy_page->page_name->Visible) { // page_name ?>
		<tr id="r_page_name">
			<td class="col-sm-2"><?php echo $cpy_page->page_name->FldCaption() ?></td>
			<td<?php echo $cpy_page->page_name->CellAttributes() ?>>
<span id="el_cpy_page_page_name">
<span<?php echo $cpy_page->page_name->ViewAttributes() ?>>
<?php echo $cpy_page->page_name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
