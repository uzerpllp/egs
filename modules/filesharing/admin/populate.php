<?php

/**
 * populate.php
 *
 * Author: Steve Bourgeois <owl@bozzit.com>
 * Project Founder: Chris Vincent <cvincent@project802.net>
 *
 * Copyright (c) 1999-2005 The Owl Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 */
                                                                                                                                                                    
global $default;
                                                                                                                                                                    
require_once("../config/owl.php");
require_once("../lib/disp.lib.php");
require_once("../lib/owl.lib.php");

if (!fIsAdmin(true)) die("$owl_lang->err_unauthorized");

fInsertUnzipedFiles($default->owl_FileDir . "/Documents" , 1, $default->owl_def_fold_security, $default->owl_def_file_security, "", $default->owl_def_file_group_owner, $default->owl_def_file_owner, $default->owl_def_file_meta, "", 1, 0, 1);

header("Location: " . "index.php?sess=$sess");
?>
