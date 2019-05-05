<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(2, "mi_cpy_artwork", $Language->MenuPhrase("2", "MenuText"), "cpy_artworklist.php", -1, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_artwork'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(6, "mi_cpy_bibliography", $Language->MenuPhrase("6", "MenuText"), "cpy_bibliographylist.php", -1, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_bibliography'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(7, "mi_cpy_exhibition", $Language->MenuPhrase("7", "MenuText"), "cpy_exhibitionlist.php", -1, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_exhibition'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(14, "mi_cpy_publication", $Language->MenuPhrase("14", "MenuText"), "cpy_publicationlist.php", -1, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_publication'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(12, "mi_cpy_page", $Language->MenuPhrase("12", "MenuText"), "cpy_pagelist.php", -1, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_page'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(15, "mi_cpy_slider_mst", $Language->MenuPhrase("15", "MenuText"), "cpy_slider_mstlist.php", -1, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_slider_mst'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(21, "mi_cpy_video", $Language->MenuPhrase("21", "MenuText"), "cpy_videolist.php", -1, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_video'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(32, "mci_Management", $Language->MenuPhrase("32", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(1, "mi_cpy_arttype", $Language->MenuPhrase("1", "MenuText"), "cpy_arttypelist.php", 32, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_arttype'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10, "mi_cpy_exhibkind", $Language->MenuPhrase("10", "MenuText"), "cpy_exhibkindlist.php", 32, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_exhibkind'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(11, "mi_cpy_exhibtype", $Language->MenuPhrase("11", "MenuText"), "cpy_exhibtypelist.php", 32, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_exhibtype'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(17, "mi_cpy_subject", $Language->MenuPhrase("17", "MenuText"), "cpy_subjectlist.php", 32, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_subject'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(23, "mi_phs_metta", $Language->MenuPhrase("23", "MenuText"), "phs_mettalist.php", 32, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}phs_metta'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(26, "mi_phs_setting", $Language->MenuPhrase("26", "MenuText"), "phs_settinglist.php", 32, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}phs_setting'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(18, "mi_cpy_subscribe", $Language->MenuPhrase("18", "MenuText"), "cpy_subscribelist.php", 32, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_subscribe'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(31, "mci_Development", $Language->MenuPhrase("31", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(3, "mi_cpy_artwork_exhibtion", $Language->MenuPhrase("3", "MenuText"), "cpy_artwork_exhibtionlist.php?cmd=resetall", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_artwork_exhibtion'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_cpy_artwork_subject", $Language->MenuPhrase("4", "MenuText"), "cpy_artwork_subjectlist.php?cmd=resetall", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_artwork_subject'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(13, "mi_cpy_page_images", $Language->MenuPhrase("13", "MenuText"), "cpy_page_imageslist.php?cmd=resetall", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_page_images'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(8, "mi_cpy_exhibition_images", $Language->MenuPhrase("8", "MenuText"), "cpy_exhibition_imageslist.php?cmd=resetall", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_exhibition_images'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(9, "mi_cpy_exhibition_video", $Language->MenuPhrase("9", "MenuText"), "cpy_exhibition_videolist.php?cmd=resetall", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_exhibition_video'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(16, "mi_cpy_slider_trn", $Language->MenuPhrase("16", "MenuText"), "cpy_slider_trnlist.php?cmd=resetall", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_slider_trn'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(22, "mi_phs_menu", $Language->MenuPhrase("22", "MenuText"), "phs_menulist.php", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}phs_menu'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(24, "mi_phs_perms", $Language->MenuPhrase("24", "MenuText"), "phs_permslist.php", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}phs_perms'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(25, "mi_phs_pgroup", $Language->MenuPhrase("25", "MenuText"), "phs_pgrouplist.php", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}phs_pgroup'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(27, "mi_phs_slider_cols", $Language->MenuPhrase("27", "MenuText"), "phs_slider_colslist.php", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}phs_slider_cols'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(28, "mi_phs_slider_type", $Language->MenuPhrase("28", "MenuText"), "phs_slider_typelist.php", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}phs_slider_type'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(29, "mi_phs_status", $Language->MenuPhrase("29", "MenuText"), "phs_statuslist.php", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}phs_status'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(30, "mi_phs_users", $Language->MenuPhrase("30", "MenuText"), "phs_userslist.php", 31, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}phs_users'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(33, "mci_Views", $Language->MenuPhrase("33", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(19, "mi_cpy_vartwork", $Language->MenuPhrase("19", "MenuText"), "cpy_vartworklist.php", 33, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_vartwork'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(20, "mi_cpy_vartwork_subjects", $Language->MenuPhrase("20", "MenuText"), "cpy_vartwork_subjectslist.php", 33, "", IsLoggedIn() || AllowListMenu('{7F488A10-5B18-4626-9FF1-A34951991D65}cpy_vartwork_subjects'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
