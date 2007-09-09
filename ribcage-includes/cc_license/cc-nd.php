<?php

##################################################
##################################################

// Creative Commons No Derivatives License
//
// The licensor permits others to copy, distribute,
// display and perform only unaltered copies of the
// work -- not derivative works based on it.

##################################################
##################################################

require_once ('cc_license.php');

$license = new cc_license ('Creative Commons - No Derivatives', 'Creative Commons - nd', 'http://creativecommons.org/licenses/nd/1.0',
                              'http://creativecommons.org/licenses/nd/1.0/legalcode', true, true, false,
                              false, true, false, false, 'http://creativecommons.org/images/public/somerights.gif');

return ($license);

?>