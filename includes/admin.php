<?php
/**
 * Various often used administration creation functions.
 *
 * @todo Make this more clever, extending a higher level abstraction with inheritance.
 * @author Alex Andrews
 * @package Ribcage
 * @subpackage Shared Libraries
 */
 
if (!class_exists('Immaterial_Controls_Metabox')) {
    /**
     * Lightweight library to organise the various easy to use metabox controls for the plugin or 
     * theme backend.
     *
     * @package Immaterial Controls
     * @subpackage Metabox
     * @author Alex Andrews
     * @version 1.0
     */
    class Immaterial_Controls_Metabox {
        /**
         * Name of the metabox - mostly used for saying what variable this will change.
         *
         * @var string
         */
        private $name;
        
        function __construct ($name = null) {
            if ($name) {
                $this->name = $name;
            }
		}
		
		/**
		 * Opens a form up, creating the nonce as appropriate.
		 *
		 * Forms a nonce with value of 
		 *
		 * @param string $post_type The post type of the nonce you wish to create, or nothing to guess it.
		 * @return void
		 * @author Alex Andrews
		 * @package Immaterial Controls
		 * @subpackage Metabox
		 */
		public function start ($name = false, $echo = true) {
		    global $post;
		    
		    if (! $this->name) {
		        if ($name == false) {
    		        $name = $post->post_type;
    		    }
    		    
    		    $this->name = $name;
		    }
		    
		    $content = wp_nonce_field($post_type . '_save_metabox', $this->name . "_nonce", true, false);
		    
		    if ($echo) {
		        echo $content;
		    }
		    
		    return $content;
		}
		
		/**
		 * Adds a small table to the metabox.
		 *
		 * @param array $rows Associative array of the row with field and description.
		 * @param bool $echo Echo out the result if true.
		 * @return string $content The table created.
		 * @author Alex Andrews
 		 * @package Immaterial Controls
 		 * @subpackage Metabox
		 * @version 1.1
		 */
		public function table ($rows, $values = false, $echo = true) {
		    global $post;
		    
		    $content .= '<table>';
            foreach ($rows as $field => $desc) {
                if (! $values) {
                    $value = get_post_meta($post->ID, $field, true);
                }
                else {
                    $values[$field] = $value;
                }
                
                $content .= '<tr><td><label for="' . $field .'">'. $desc .' </label></td><td><input id="'. $field .'" type="text" name="'. $field .'" value="'. $value .'" /></td></tr>';
            }
            $content .= '</table>';
            
            if ($echo) {
                echo $content;
            }
            
            return $content;
		}
		
		/**
		 * Given a list of values gives us a bulleted list to fill in.
		 * This is intended if we have something like a load of meta_tags that will be bundled in one.
		 *
		 * @author Alex
		 */
		public function bulleted_fields ($rows, $type = 'ol', $echo = true) {
		    $content .= "<$type>";
		    
		    $count = 0;
		    foreach ($rows as $value) {
		        $content .= '<li>';
		        $content .= '<input id="'. $this->name . '_' . $count . '" type="text" name="'. $this->name . '_' . $count .'" value="'. $value .'" />';
		        $content .= '</li>';
		        $count ++;
		    }
		    
		    $content .= "</$type>";
		    
		    if ($echo == true) {
		        echo $content; 
		    }
		    return $content;
		}
		
        /**
		 * Adds a select drop down to the metabox.
		 *
		 * @param array $fields List of fields in the format field => label
		 * @param string | int $selected The selected field
		 * @param bool $echo Whether or not to echo out the created select.
		 * @return string $content The content.
		 * @author Alex Andrews
 		 * @package Immaterial Controls
 		 * @subpackage Metabox
		 * @version 1.1
		 */
		public function select ($fields, $selected = false, $echo = true) {
		    $content .= '<select name="' . $this->name . '" id="' . $this->name . '">';
            foreach ($fields as $label => $var) {
                $content .= '<option value = "' . $var . '"';
                if ($var == $selected) {
                    $content .= ' selected ';
                }
                $content .= '>' . $label . '</option>';
            }
            $content .= '</select>';
            
            if ($echo) {
                echo $content;
            }
            
            return $content;
		}
		
		/**
		 * Adds a clutch of checkboxes
		 *
		 * @param array $fields The fields in the format $var => $label
		 * @param mixed $selected The fields that are selected
		 * @param bool $echo Echo out the checkboxes if true
		 * @return string $content The cluck of check boxes
		 * @author Alex Andrews
		 * @package Immaterial Controls
		 * @subpackage Metabox
		 * @version 1.0
		 * @todo Make this work.
		 */
		public function checkboxes ($fields, $selected = false, $echo = true) {
		    global $post;
		    
		    foreach ($fields as $var => $label){
                    $present = get_post_meta($post->ID, $var, true);
                    
                    $content .= '<label for="' . $var . '">' . $label . ' </label>';
            		$content .= '<input type="checkbox" id="' . $var . '" name="' . $var . '" '. checked($present, true, false).'/> ';
            		
            		unset($present);
            }
		    
		    if ($echo) {
		        echo $content;
		    }
		    
		    return $content;
		}
		
		public function radiobuttons ($fields, $checked, $echo = true) {
		    global $post;
		    
		    foreach ($fields as $var => $label) {
		        $content .= '<label for="' . $var . '">' . $label . ' </label>';  
		        $content .= '<input type = "radio" ' . 'id = "' . $var . '" ' . 'name="' . $this->name . '" ' . 'value="' . $var . '"';    
		        if ($var == $checked) {
                    $content .= ' checked';
                }
                $content .= '>';
		    }
		    
		   if ($echo) {
		       echo $content;
		   }
		   
		   return $content;
		}
		
		/**
		 * Add an instructions paragraph, normally used under a metabox.
		 *
		 * @param string $field The instructions.
		 * @param bool $string Echo out our instructions automatically if true.
		 * @return string $content HTML formatted instructions
		 * @author Alex Andrews
		 * @package Immaterial Controls
		 * @subpackage Metabox
		 * @version 1.0
		 */
		public function instructions ($field, $echo = true) {
		    $content .= '<p>' . $field . '</p>';
		    
		    if ($echo) {
		        echo $content;
		    }
		    
		    return $content;
		}
		
		/**
		 * A large textbox (via a textarea tag), similar in size to the extract box.
		 *
		 * @param mixed $field The contents of the textarea.
		 * @param bool $echo True if we want the creation to be echoed.
		 * @return string $content The Textarea HTML
		 * @author Alex Andrews
		 * @package Immaterial Controls
		 * @subpackage Metabox
		 * @version 1.0
		 */
		public function l_textbox ($field, $echo = true) {
		    $content .= '<textarea rows="3" cols="40" name="' . $this->name . '" class="widefat">';
		    $content .= $field;
		    $content .= '</textarea>';
		    
		    if ($echo) {
		        echo $content;
		    }
		    
		    return $content;
		}
    }
}
?>