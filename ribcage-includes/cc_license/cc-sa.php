<?php

##################################################
##################################################

// Creative Commons Share Alike License
//
// The licensor permits others to distribute derivative
// works only under a license identical to the one that
// governs the licensor's work.

##################################################
##################################################

require_once ('cc_license.php');

$license = new cc_license ('Creative Commons - Share-Alike', 'Creative Commons - sa', 'http://creativecommons.org/licenses/sa/1.0',
                              'http://creativecommons.org/licenses/sa/1.0/legalcode', true, true, true,
                              false, true, false, true, 'http://creativecommons.org/images/public/somerights.gif');

return ($license);

?>