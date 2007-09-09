<?php

##################################################
##################################################

// Creative Commons Non-commercial/Share-Alike License
//
// The licensor permits others to copy, distribute,
// display, and perform the work. In return, licensees
// may not use the work for commercial purposes --
// unless they get the licensor's permission.
//
// The licensor permits others to distribute derivative
// works only under a license identical to the one that
// governs the licensor's work.

##################################################
##################################################

require_once ('cc_license.php');

$license = new cc_license ('Creative Commons - Non-Commercial & Share-Alike', 'Creative Commons - nc/sa', 'http://creativecommons.org/licenses/nc-sa/1.0',
                              'http://creativecommons.org/licenses/nc-sa/1.0/legalcode', true, true, true,
                              true, true, false, true, 'http://creativecommons.org/images/public/somerights.gif');

return ($license);

?>