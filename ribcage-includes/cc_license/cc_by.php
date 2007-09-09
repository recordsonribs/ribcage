<?php

##################################################
##################################################

// Creative Commons Atrribution License
// The licensor permits others to copy, distribute,
// display, and perform the work. In return,
// licensees must give the original author credit.

##################################################
##################################################

require_once ('cc_license.php');

$license = new cc_license ('Creative Commons - Attribution', 'Creative Commons - by', 'http://creativecommons.org/licenses/by/1.0',
                              'http://creativecommons.org/licenses/by/1.0/legalcode', true, true, true,
                              false, true, true, false, 'http://creativecommons.org/images/public/somerights.gif');

return ($license);

?>