<?php

##################################################
##################################################

// Creative Commons No Derivatives/Non-commercial License
//
// The licensor permits others to copy, distribute,
// display and perform only unaltered copies of the
// work -- not derivative works based on it.
//
// The licensor permits others to copy, distribute,
// display, and perform the work. In return, licensees
// may not use the work for commercial purposes --
// unless they get the licensor's permission.

##################################################
##################################################

require_once ('cc_license.php');

$license = new cc_license ('Creative Commons - No Derivatives & Non-Commercial', 'Creative Commons - nd/nc', 'http://creativecommons.org/licenses/nd-nc/1.0',
                              'http://creativecommons.org/licenses/nd-nc/1.0/legalcode', true, true, false,
                              true, true, false, false, 'http://creativecommons.org/images/public/somerights.gif');

return ($license);

?>