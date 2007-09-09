<?php

##################################################
##################################################

// CREATIVE COMMONS LICENSES
// A class using Creative Commons license primitives
// to define and express content licenses
// By : Blake Watters <sbw@ibiblio.org>
// This software is released under the terms of the LGPL license

##################################################
##################################################

class cc_license {
  // Basic information common to every license
  var $name;                       // A unique name for this license
  var $short_name;                 // A short textual representation of the license name
  var $uri;                        // The URI of this license
  var $full_text;                  // A URI to the full text of this license
  var $logo_uri;                   // An optional logo for this license
  var $logo_link;                  // An optional link to attach to the logo
  var $extra_rdf;                  // A buffer for additional RDF outside the scope of the primitives

  // Permissions for the license
  var $reproduction;               // Do we allow the work to be reproduced?
  var $distribution;               // Do we allow public distribution of the work?
  var $derivatives;                // Do we allow derivative works?

  // Restrictions for the license
  var $noncommercial;              // Can others profit from the work?

  // Requirements of the license
  var $notice;                     // Do we require that copyright notices be maintained?
  var $attribution;                // Do we require attribution?
  var $share_alike;                // Do we require that derivative works use the same license?

  function cc_license ($name, $short_name, $uri, $full_text, $reproduction = 1, $distribution = 1, $derivatives = 1,
                       $noncommercial = 0, $notice = 1, $attribution = 0, $share_alike = 0, $logo_uri = '', $logo_link = "http://creativecommons.org/learn/licenses/") {
    $this->name = $name;
    $this->short_name = $short_name;
    $this->uri = $uri;
    $this->full_text = $full_text;
    $this->logo_uri = $logo_uri;
    $this->logo_link = $logo_link;

    $this->reproduction = $reproduction;
    $this->distribution = $distribution;
    $this->derivatives = $derivatives;

    $this->noncommercial = $noncommercial;

    $this->notice = $notice;
    $this->attribution = $attribution;
    $this->share_alike = $share_alike;
  }

  ##################################################
  ##################################################
  // PERMISSIONS - Rights granted by the license

  function permit_reproduction ($permit = 1) {
    $this->reproduction = $permit;
  }

  function permit_distribution ($permit = 1) {
    $this->distribution = $permit;
  }

  function permit_derivatives ($permit = 1) {
    $this->derivatives = $permit;
  }

  ##################################################
  ##################################################
  // RESTRICTIONS - Rights granted by the license

  // Set the noncommercial requirement
  function require_noncommercial ($require = 1) {
    $this->noncommercial = $require;
  }

  ##################################################
  ##################################################
  // REQUIREMENTS - Requirements imposed by the license

  function require_notice ($require = 1) {
    $this->notice = $require;
  }

  function require_attribution ($require = 1) {
    $this->attribution = $require;
  }

  // Set the share alike requirement
  function require_share_alike ($require = 1) {
    $this->share_alike = $require;
  }

  ##################################################
  ##################################################

  // Set the full text URI for this license
  function set_full_text ($full_text = '') {
    $this->full_text = $full_text;
  }

  // Set the logo for this
  function set_logo ($uri = '', $link = '') {
    $this->logo_uri = $uri;
    $this->logo_link = $link;
  }

  // Fetch the cc:license resource for this license
  function get_resource () {
    $res = "<license rdf:resource=\"".$this->uri."\" />";

    return ($res);
  }

  // Fetch the RDF representation of this license
  function get_rdf () {
    $rdf = "<cc:License rdf:about=\"".$this->uri."\">";

    if ($this->reproduction == true)
      $rdf .= "<cc:permits rdf:resource=\"http://web.resource.org/cc/Reproduction\" />\n";

    if ($this->distribution == true)
      $rdf .= "<cc:permits rdf:resource=\"http://web.resource.org/cc/Distribution\" />\n";

    if ($this->derivatives == true)
      $rdf .= "<cc:permits rdf:resource=\"http://web.resource.org/cc/DerivativeWorks\"/>\n";

    if ($this->noncommercial == true)
      $rdf .= "<cc:prohibits rdf:resource=\"http://web.resource.org/cc/CommercialUse\" />\n";

    if ($this->notice == true)
      $rdf .= "<cc:requires rdf:resource=\"http://web.resource.org/cc/Notice\" />\n";

    if ($this->attribution == true)
      $rdf .= "<cc:requires rdf:resource=\"http://web.resource.org/cc/Attribution\" />\n";

    if ($this->share_alike == true)
      $rdf .= "<cc:requires rdf:resource=\"http://web.resource.org/cc/ShareAlike\"/>\n";

    $rdf .= "</cc:License>\n";

    return ($rdf);
  }

  // Fetch the PHP array representation of this license
  function get_array () {
    $license = array ();

    $license['name'] = $this->name;
    $license['short_name'] = $this->short_name;
    $license['uri'] = $this->uri;
    $license['logo'] = $this->logo_uri;
    $license['full_text'] = $this->full_text;

    $license['reproduction'] = $this->reproduction;
    $license['distribution'] = $this->distribution;
    $license['derivatives'] = $this->derivatives;

    $license['noncommercial'] = $this->noncommercial;

    $license['notice'] = $this->notice;
    $license['attribution'] = $this->attribution;
    $license['share_alike'] = $this->share_alike;

    return ($license);
  }

  // Fetch the logo for this license
  function get_logo () {
    return ($this->logo_uri);
  }

  // Fetch an array of URI's to the appropriate Creative Commons symbols
  function get_symbols () {
    $symbols = array ();

    if ($this->attribution)
      $symbols['attribution'] = "http://creativecommons.org/icon/by/standard.gif";

    if (! $this->derivatives)
      $symbols['no_derivatives'] = "http://creativecommons.org/icon/nd/standard.gif";

    if ($this->share_alike)
      $symbols['share_alike'] = "http://creativecommons.org/icon/sa/standard.gif";

    if ($this->noncommercial)
      $symbols['non_commercial'] = "http://creativecommons.org/icon/nc/standard.gif";

    return ($symbols);
  }

}

// Load all licenses from a specified directory
function get_licenses ($path = '') {
  $licenses = array ();

  // If the path isn't specified, look in the same directory as the library
  if ($path === '') $path = dirname (__FILE__);

  // Load all currently installed licenses into an array
  if ($dir = @opendir ($path)) {
    while (($file = readdir ($dir)) !== false) {
      if ($file != "CVS" && $file != "." && $file != ".."
          && is_file ($path . '/' . $file)
          && strtolower (substr ($file, -4)) == '.php') {
            $license = include_once ($path.'/'.$file);
            if (is_object ($license))
              $licenses[] = $license;
      }
    }

    closedir ($dir);
  }

  return ($licenses);
}

// Utility function to search an array of licenses by URI (full text or abstract)
function find_license_by_uri ($uri, $licenses = '') {

  // Load up the licenses if they aren't provided
  if ($licenses == '') $licenses = get_licenses ();

  foreach ($licenses as $license) {
    if (($license->uri == $uri || $license->full_text == $uri) && $license->uri != '' && $license->full_text != '')
      return ($license);
  }

  return (false);
}

?>