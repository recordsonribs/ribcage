<?php

##################################################
##################################################

// Creative Commons Atrribution/No Derivatives License
// The licensor permits others to copy, distribute,
// display, and perform the work. In return,
// licensees must give the original author credit.
//
// The licensor permits others to copy, distribute,
// display and perform only unaltered copies of the
// work -- not derivative works based on it.

##################################################
##################################################

require_once ('cc_license.php');

$license = new cc_license ('Creative Commons - Attribution & No Derivative Works', 'Creative Commons - by/nd', 'http://creativecommons.org/licenses/by-nd/1.0',
                              'http://creativecommons.org/licenses/by-nd/1.0/legalcode', true, true, false,
                              false, true, true, false, 'http://creativecommons.org/images/public/somerights.gif');

return ($license);

?>