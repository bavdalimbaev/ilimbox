<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * settings mod form
 * @package   local_edwiserbridge
 * @author    Wisdmlabs
 */

defined('MOODLE_INTERNAL') || die();
require_once("$CFG->libdir/formslib.php");



/**
*form shown while adding activity.
*/
class edwiserbridge_navigation_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        $connection = "";
        $synch      = "";
        $sevice     = '';
        $settings   = '';
        $summary    = '';

        if (isset($_GET["tab"]) && $_GET["tab"] == "connection") {
            $connection = "active-tab";
        } elseif (isset($_GET["tab"]) && $_GET["tab"] == "synchronization") {
            $synch = "active-tab";
        } elseif (isset($_GET["tab"]) && $_GET["tab"] == "service") {
            $sevice = "active-tab";
        } elseif (isset($_GET["tab"]) && $_GET["tab"] == "settings") {
            $settings = "active-tab";
        } elseif (isset($_GET["tab"]) && $_GET["tab"] == "summary") {
            $summary = "active-tab ";
        }



        // CHeck the summary
        $summary_status = eb_get_summary_status();
        $summary .= 'summary_tab_'. $summary_status;

        $mform->addElement(
            'html',
            '<div class="eb-tabs-cont">
                
                <a href="'.$CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=settings".'" class="eb-tabs '.$settings.'">
                    <div id="eb-setting-tab" >
                        '. get_string('tab_mdl_required_settings', 'local_edwiserbridge') .'
                    </div>
                </a>


                <a href="'.$CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=service".'" class="eb-tabs '.$sevice.'">
                    <div id="eb-service-tab" >
                        '. get_string('tab_service', 'local_edwiserbridge') .'
                    </div>
                </a>

                <a href="'.$CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=connection".'" class="eb-tabs '.$connection.'">
                    <div id="eb-conn-tab" >
                        ' . get_string('tab_conn', 'local_edwiserbridge') . '
                    </div>
                </a>
                
                <a href="'.$CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=synchronization".'" class="eb-tabs '.$synch.'">
                    <div id="eb-synch-tab" >
                        '. get_string('tab_synch', 'local_edwiserbridge') .'
                    </div>
                </a>

                <a href="'.$CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=summary".'" class="'.$summary.'">
                    <div id="eb-synch-tab" >
                        '. get_string('summary', 'local_edwiserbridge') .'
                    </div>
                </a>

            </div>'
        );

    }

    public function validation($data, $files)
    {
        return array();
    }
}





/**
* Used to create web service.
*/
class edwiserbridge_service_form extends moodleform
{
    public function definition()
    {
        global $CFG;

        $mform            = $this->_form;
        $existingservices = eb_get_existing_services();
        $authusers        = eb_get_administrators();

        $token       = isset($CFG->edwiser_bridge_last_created_token) ? $CFG->edwiser_bridge_last_created_token : ' - ';
        $service     = isset($CFG->ebexistingserviceselect) ? $CFG->ebexistingserviceselect : '';
        $token_field = '';



        /*$sites = get_site_list();
        $site_keys = array_keys($sites);
        $defaultvalues = get_synch_settings($site_keys[0]);*/

        // $mform->addElement('select', 'wp_site_list', get_string('site-list', 'local_edwiserbridge'), $sites);


        

        // 1st Field Service list
        $select = $mform->addElement('select', 'eb_sevice_list', get_string('existing_serice_lbl', 'local_edwiserbridge'), $existingservices);
        $mform->addHelpButton('eb_sevice_list', 'eb_mform_service_desc', 'local_edwiserbridge');
        $select->setMultiple(false);

        // $repeateloptions['wp_name']['helpbutton']  = array("wordpress_site_name", "local_edwiserbridge");

        // 2nd Field Service input name 
        $mform->addElement('text', 'eb_service_inp', get_string('new_service_inp_lbl', 'local_edwiserbridge'), array('class'=>'eb_service_field'));
        $mform->setType('eb_service_inp', PARAM_TEXT);


        // 3rd field Users List.
        $select = $mform->addElement('select', 'eb_auth_users_list', get_string('new_serivce_user_lbl', 'local_edwiserbridge'), $authusers, array('class'=>''));
        $select->setMultiple(false);


        // $mform->addElement('static', 'eb_mform_lang_wrap', get_string('lang_label', 'local_edwiserbridge'), '<div class="eb_copy_txt_wrap"> <div style="width:60%;"> <b class="eb_copy" id="eb_mform_lang">' . $CFG->lang . '</b> </div> <div>  <i class="fa fa-clipboard eb_primary_copy_btn" aria-hidden="true"></i> </div></div>');

        $mform->addElement('static', 'eb_mform_lang_wrap', get_string('lang_label', 'local_edwiserbridge'), '<div class="eb_copy_txt_wrap eb_copy_div"> <div style="width:60%;"> <b class="eb_copy" id="eb_mform_lang">' . $CFG->lang . '</b> </div> <div>  <button class="btn btn-primary eb_primary_copy_btn">'.get_string('copy', 'local_edwiserbridge') .'</button></div></div>');


        // $mform->addElement('static', 'eb_mform_site_url_wrap', get_string('site_url', 'local_edwiserbridge'), '<div class="eb_copy_txt_wrap"> <div style="width:60%;"> <b id="eb_mform_site_url">' . $CFG->wwwroot . '</b> </div> <div> <span style="color:#1177d1">'. get_string('copy', 'local_edwiserbridge') .'</span></div></div>');
        $mform->addHelpButton('eb_mform_lang_wrap', 'eb_mform_lang_desc', 'local_edwiserbridge');



        // 4th field Site Url
        $mform->addElement('static', 'eb_mform_site_url_wrap', get_string('site_url', 'local_edwiserbridge'), '<div class="eb_copy_txt_wrap eb_copy_div"> <div style="width:60%;"> <b class="eb_copy" id="eb_mform_site_url">' . $CFG->wwwroot . '</b> </div> <div> <button class="btn btn-primary eb_primary_copy_btn">'. get_string('copy', 'local_edwiserbridge') .'</button></div></div>');
        // $mform->addElement('static', 'eb_mform_site_url_wrap', get_string('site_url', 'local_edwiserbridge'), '<div class="eb_copy_txt_wrap"> <div style="width:60%;"> <b id="eb_mform_site_url">' . $CFG->wwwroot . '</b> </div> <div> <span style="color:#1177d1">'. get_string('copy', 'local_edwiserbridge') .'</span></div></div>');
        $mform->addHelpButton('eb_mform_site_url_wrap', 'eb_mform_ur_desc', 'local_edwiserbridge');

        if (!empty($service)) {
            //If the token available then show the token
            $token_field = eb_create_token_field($service, $token);
        } else {
            // If service is empty then show just the blank text with dash
            $token_field = $token;
        }




        // 5th field Token
        $mform->addElement('static', 'eb_mform_token_wrap', get_string('token', 'local_edwiserbridge'), '<b id="eb_mform_token">' . $token_field . '</b>');
        $mform->addHelpButton('eb_mform_token_wrap', 'eb_mform_token_desc', 'local_edwiserbridge');



        $mform->addElement('static', 'eb_mform_common_error', '', '<div id="eb_common_err"></div><div id="eb_common_success"></div>');

        $mform->addElement('button', 'eb_mform_create_service', get_string("link", 'local_edwiserbridge'));


        //set default values
        if (!empty($service)) {
            $mform->setDefault("eb_sevice_list", $service);
        }


        $mform->addElement(
            'html',
            '<div class="eb_connection_btns">
                
                <a href="'.$CFG->wwwroot.'/local/edwiserbridge/edwiserbridge.php?tab=connection'.'" class="btn btn-primary eb_setting_btn" > '.get_string("next", 'local_edwiserbridge').'</a>

            </div>
            ');
    }

    public function validation($data, $files)
    {
        return array();
    }
}






/**
*form shown while adding activity.
*/
class edwiserbridge_connection_form extends moodleform
{
    public function definition()
    {
        $defaultvalues = get_connection_settings();
        $mform = $this->_form;
        $repeatarray = array();

        $repeatarray[] = $mform->createElement('header', 'wp_header', get_string('wp_site_settings_title', 'local_edwiserbridge'). "<div class ='test'> </div>");

        $repeatarray[] = $mform->createElement('text', 'wp_name', get_string('wordpress_site_name', 'local_edwiserbridge'), 'size="35"');
        $repeatarray[] = $mform->createElement('text', 'wp_url', get_string('wordpress_url', 'local_edwiserbridge'), 'size="35"');
        $repeatarray[] = $mform->createElement('text', 'wp_token', get_string('wp_token', 'local_edwiserbridge'), 'size="35"');
        $repeatarray[] = $mform->createElement('hidden', 'wp_remove', 'no');


        $buttonarray = array();
        $buttonarray[] = $mform->createElement('button', 'eb_test_connection', get_string("wp_test_conn_btn", "local_edwiserbridge"), "", "");
        $buttonarray[] = $mform->createElement('button', 'eb_remove_site', get_string("wp_test_remove_site", "local_edwiserbridge"));
        $buttonarray[] = $mform->createElement('html', '<div id="eb_test_conne_response"> </div>');

        $repeatarray[] = $mform->createElement("group", "eb_buttons", "", $buttonarray);


        /*
         * Data type of each field.
         */
        $repeateloptions = array();
        $repeateloptions['wp_name']['type']    = PARAM_TEXT;
        $repeateloptions['wp_url']['type']     = PARAM_TEXT;
        $repeateloptions['wp_token']['type']   = PARAM_TEXT;
        $repeateloptions['wp_remove']['type']  = PARAM_TEXT;


        /*
         * Name of each field.
         */
        $repeateloptions['wp_name']['helpbutton']  = array("wordpress_site_name", "local_edwiserbridge");
        $repeateloptions['wp_token']['helpbutton'] = array("token", "local_edwiserbridge");
        $repeateloptions['wp_url']['helpbutton']   = array("wordpress_url", "local_edwiserbridge");

        /*
         * Adding rule for each field.
         */
        /*$repeateloptions['wp_name']['rule']  = 'required';
        $repeateloptions['wp_url']['rule']   = 'required';
        $repeateloptions['wp_token']['rule'] = 'required';*/


        $count = 1;
        if (!empty($defaultvalues) && !empty($defaultvalues["eb_connection_settings"])) {
            $count = count($defaultvalues["eb_connection_settings"]);
            $siteNo = 0;
            foreach ($defaultvalues["eb_connection_settings"] as $key => $value) {
                $mform->setDefault("wp_name[".$siteNo."]", $value["wp_name"]);
                $mform->setDefault("wp_url[".$siteNo."]", $value["wp_url"]);
                $mform->setDefault("wp_token[".$siteNo."]", $value["wp_token"]);
                $siteNo++;
            }
        }


        $this->repeat_elements($repeatarray, $count, $repeateloptions, 'eb_connection_setting_repeats', 'eb_option_add_fields', 1, get_string("add_more_sites", "local_edwiserbridge"), true);

        //closing header section
        $mform->closeHeaderBefore('eb_option_add_fields');


        $mform->addElement(
            'html',
            '<div class="eb_connection_btns">
                <input type="submit" class="btn btn-primary eb_setting_btn" id="conne_submit" name="conne_submit" value="'.get_string("save", "local_edwiserbridge").'">
                <input type="submit" class="btn btn-primary eb_setting_btn" id="conne_submit_continue" name="conne_submit_continue" value="'.get_string("save_cont", "local_edwiserbridge").'">
            </div>');



        //fill form with the existing values
        // $this->add_action_buttons(false);
    }

    public function validation($data, $files)
    {
        $errors = parent::validation($data, $files);

        $processedData = $data;
        for ($i = count($data["wp_name"]) - 1; $i >= 0; $i--) {
            //Delete the current values from the copy of the data array.
            unset($processedData["wp_name"][$i]);
            unset($processedData["wp_url"][$i]);

            if (empty($data["wp_name"][$i])) {
                $errors['wp_name['.$i.']'] = get_string('required', 'local_edwiserbridge');
            } elseif (in_array($data["wp_name"][$i], $processedData["wp_name"])) {
                //checking if the current name value exitsts in array.
                $errors['wp_name['.$i.']'] = get_string('sitename-duplicate-value', 'local_edwiserbridge');
            }


            if (empty($data["wp_url"][$i])) {
                $errors['wp_url['.$i.']'] = get_string('required', 'local_edwiserbridge');
            } elseif (in_array($data["wp_url"][$i], $processedData["wp_url"])) {
                //checking if the current URL value exitsts in array.
                $errors['wp_url['.$i.']'] = get_string('url-duplicate-value', 'local_edwiserbridge');
            }


            if (empty($data["wp_token"][$i])) {
                $errors['wp_token['.$i.']'] = get_string('required', 'local_edwiserbridge');
            }

            //if the site settings is removed then remove the validation errors also.
            if (isset($errors['wp_name['.$i.']']) && isset($errors['wp_url['.$i.']']) && isset($errors['wp_token['.$i.']']) && isset($data['wp_remove'][$i]) && 'yes' == $data['wp_remove'][$i]) {
                unset($errors['wp_name['.$i.']']);
                unset($errors['wp_url['.$i.']']);
                unset($errors['wp_token['.$i.']']);
            }
        }
        return $errors;
    }
}




/**
* form shown while adding activity.
*/
class edwiserbridge_synchronization_form extends moodleform
{
    public function definition()
    {
        $mform = $this->_form;
        $sites = get_site_list();
        $site_keys = array_keys($sites);
        $defaultvalues = get_synch_settings($site_keys[0]);

        $mform->addElement('select', 'wp_site_list', get_string('site-list', 'local_edwiserbridge'), $sites);

        // 1st Field
        $mform->addElement('advcheckbox', 'course_enrollment', get_string('enrollment_checkbox', 'local_edwiserbridge'), get_string("enrollment_checkbox_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));
        
        // 2nd field
        $mform->addElement('advcheckbox', 'course_un_enrollment', get_string('unenrollment_checkbox', 'local_edwiserbridge'), get_string("unenrollment_checkbox_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));
        
        // 3rd field.
        $mform->addElement('advcheckbox', 'user_creation', get_string('user_creation', 'local_edwiserbridge'), get_string("user_creation_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));
        
        // 4th field.
        $mform->addElement('advcheckbox', 'user_deletion', get_string('user_deletion', 'local_edwiserbridge'), get_string("user_deletion_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));

        //fill form with the existing values
        if (!empty($defaultvalues)) {
            $mform->setDefault("course_enrollment", $defaultvalues["course_enrollment"]);
            $mform->setDefault("course_un_enrollment", $defaultvalues["course_un_enrollment"]);
            $mform->setDefault("user_creation", $defaultvalues["user_creation"]);
            $mform->setDefault("user_deletion", $defaultvalues["user_deletion"]);
        }



         $mform->addElement(
            'html',
            '<div class="eb_connection_btns">
                <input type="submit" class="btn btn-primary eb_setting_btn" id="sync_submit" name="sync_submit" value="'.get_string("save", "local_edwiserbridge").'">
                <input type="submit" class="btn btn-primary eb_setting_btn" id="sync_submit_continue" name="sync_submit_continue" value="'.get_string("save_cont", "local_edwiserbridge").'">
            </div>');



        // $this->add_action_buttons();
    }

    public function validation($data, $files)
    {
        return array();
    }
}






/**
* Used to create web service.
*/
class edwiserbridge_settings_form extends moodleform
{
    public function definition()
    {
        global $CFG;

        $mform            = $this->_form;
        // $existingservices = eb_get_existing_services();
        // $authusers        = eb_get_administrators();
        $defaultvalues = get_required_settings();

        // 1st field.
        $mform->addElement('advcheckbox', 'rest_protocol', get_string('web_rest_protocol_cb', 'local_edwiserbridge'), get_string("web_rest_protocol_cb_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));

        // 2nd field.
        $mform->addElement('advcheckbox', 'web_service', get_string('web_service_cb', 'local_edwiserbridge'), get_string("web_service_cb_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));

        // 3rd field.
        $mform->addElement('advcheckbox', 'pass_policy', get_string('password_policy_cb', 'local_edwiserbridge'), get_string("password_policy_cb_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));

        // 4th field.
        $mform->addElement('advcheckbox', 'extended_username', get_string('extended_char_username_cb', 'local_edwiserbridge'), get_string("extended_char_username_cb_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));

        //fill form with the existing values
        if (!empty($defaultvalues)) {
            $mform->setDefault("rest_protocol", $defaultvalues["rest_protocol"]);
            $mform->setDefault("web_service", $defaultvalues["web_service"]);
            $mform->setDefault("pass_policy", $defaultvalues["pass_policy"]);
            $mform->setDefault("extended_username", $defaultvalues["extended_username"]);
        }


        $mform->addElement(
            'html',
            '<div class="eb_connection_btns">
                <input type="submit" class="btn btn-primary eb_setting_btn" id="settings_submit" name="settings_submit" value="'.get_string("save", "local_edwiserbridge").'">

                <input type="submit" class="btn btn-primary eb_setting_btn" id="settings_submit_continue" name="settings_submit_continue" value="'.get_string("save_cont", "local_edwiserbridge").'">
            </div>');


        // $this->add_action_buttons(false);
    }

    public function validation($data, $files)
    {
        return array();
    }
}






/**
* Used to create web service.
*/
class edwiserbridge_summary_form extends moodleform
{
    public function definition()
    {
        global $DB, $CFG;

        $mform            = $this->_form;
        // $existingservices = eb_get_existing_services();
        // $authusers        = eb_get_administrators();
/*        $defaultvalues = get_required_settings();

        $mform->addElement('advcheckbox', 'web_service', get_string('web_service_cb', 'local_edwiserbridge'), get_string("web_service_cb_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));

        $mform->addElement('advcheckbox', 'pass_policy', get_string('password_policy_cb', 'local_edwiserbridge'), get_string("password_policy_cb_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));

        $mform->addElement('advcheckbox', 'extended_username', get_string('extended_char_username_cb', 'local_edwiserbridge'), get_string("extended_char_username_cb_desc", "local_edwiserbridge"), array('group' => 1), array(0, 1));

        //fill form with the existing values
        if (!empty($defaultvalues)) {
            $mform->setDefault("web_service", $defaultvalues["web_service"]);
            $mform->setDefault("pass_policy", $defaultvalues["pass_policy"]);
            $mform->setDefault("extended_username", $defaultvalues["extended_username"]);
        }
*/


        $token        = isset($CFG->edwiser_bridge_last_created_token) ? $CFG->edwiser_bridge_last_created_token : ' - ';
        $service      = isset($CFG->ebexistingserviceselect) ? $CFG->ebexistingserviceselect : '';
        $token_field  = '';
        $service_name = '';


        $result = $DB->get_record_sql(
            "SELECT name  FROM {external_services} WHERE  id = ?",
            array(
                $service
            )
        );

        if (isset($result->name)) {
            $service_name = $result->name;
        }





        if (!empty($service)) {
            //If the token available then show the token
            $token_field = eb_create_token_field($service, $token);
        } else {
            // If service is empty then show just the blank text with dash
            $token_field = $token;
        }





        $summary_array = array(
            'summary_setting_section' => array(
                /*'rest_protocol'       => array(
                    'label'          => get_string('sum_rest_proctocol', 'local_edwiserbridge'),
                    'expected_value' => 1
                    'error_msg'      =>  get_string('sum_error_rest_proctocol', 'local_edwiserbridge'),
                    'error_link'     => $CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=settings"
                ),*/
                'enablewebservices'   => array(
                    'expected_value' => 1,
                    'label'          => get_string('sum_web_services', 'local_edwiserbridge'),
                    'error_msg'      => get_string('sum_error_web_services', 'local_edwiserbridge'),
                    'error_link'     => $CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=settings"
                ),
                'passwordpolicy'     => array(
                    'expected_value' => 0,
                    'label'          => get_string('sum_pass_policy', 'local_edwiserbridge'),
                    'error_msg'      => get_string('sum_error_pass_policy', 'local_edwiserbridge'),
                    'error_link'     => $CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=settings"
                ),
                'extendedusernamechars' => array(
                    'expected_value' => 1,
                    'label'          => get_string('sum_extended_char', 'local_edwiserbridge'),
                    'error_msg'      => get_string('sum_error_extended_char', 'local_edwiserbridge'),
                    'error_link'     => $CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=settings"
                )
            ),
            'summary_connection_section'  => array(
                'url' => array(
                    'label'          => get_string('mdl_url', 'local_edwiserbridge'),
                    'expected_value' => 'static',
                    // 'value'          => '<div class="eb_copy_txt_wrap"> <div style="width:60%;"> <b class="eb_copy" id="eb_mform_site_url">' . $CFG->wwwroot . '</b> </div> <div> <button class="btn btn-primary eb_primary_copy_btn">'. get_string('copy', 'local_edwiserbridge') .'</button></div></div>'
                    'value'          => '<div> <span class="eb_copy_text" title="'. get_string('click_to_copy', 'local_edwiserbridge') .'">'. $CFG->wwwroot .'</span>'.' <span class="eb_copy_btn">'. get_string('copy', 'local_edwiserbridge') .'</span></div>'

                ),
                'service_name' => array(
                    'label'          => get_string('web_service_name', 'local_edwiserbridge'),
                    'expected_value' => 'static',
                    'value'          => '<div> <span class="eb_copy_text" title="'. get_string('click_to_copy', 'local_edwiserbridge') .'">'. $service_name .'</span>'.' <span class="eb_copy_btn">'. get_string('copy', 'local_edwiserbridge') .'</span></div>'

                ),
                'token' => array(
                    'label'          => get_string('token', 'local_edwiserbridge'),
                    'expected_value' => 'static',
                    // 'value'          => '<b id="eb_mform_token">' . $token_field . '</b>'
                    'value'          =>  '<div> <span class="eb_copy_text" title="'. get_string('click_to_copy', 'local_edwiserbridge') .'">'. $token .'</span> <span class="eb_copy_btn">'. get_string('copy', 'local_edwiserbridge') .'</span></div>'

                ),
                'lang_code' => array(
                    'label'          => get_string('lang_label', 'local_edwiserbridge'),
                    'expected_value' => 'static',
                    // 'value'          => '<div class="eb_copy_txt_wrap"> <div style="width:60%;"> <b class="eb_copy" id="eb_mform_lang">' . $CFG->lang . '</b> </div> <div> <button class="btn btn-primary eb_primary_copy_btn">'. get_string('copy', 'local_edwiserbridge') .'</button></div></div>'
                    'value'         => '<div> <span class="eb_copy_text" title="'. get_string('click_to_copy', 'local_edwiserbridge') .'">'. $CFG->lang .'</span> <span class="eb_copy_btn">'. get_string('copy', 'local_edwiserbridge') .'</span></div>'
               ),




                /*'ebexistingserviceselect' => array(
                    'label'          => get_string('sum_service_link', 'local_edwiserbridge'),
                    'expected_value' => 'isset',
                    'error_msg'      => get_string('sum_error_service_link', 'local_edwiserbridge'),
                    'error_link'     => $CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=service"

                ),
                'edwiser_bridge_last_created_token' => array(
                    'label'          => get_string('sum_token_link', 'local_edwiserbridge'),
                    'expected_value' => 'isset',
                    'error_msg'      => get_string('sum_error_token_link', 'local_edwiserbridge'),
                    'error_link'     => $CFG->wwwroot."/local/edwiserbridge/edwiserbridge.php?tab=service"

                )*/
            )
        );





        $error   = 0;
        $warning = 0;
        $html    = '';

        foreach ($summary_array as $section_key => $section) {
            
            $html .= '<div class="summary_section"> <div class="summary_section_title">'. get_string($section_key, 'local_edwiserbridge') .'</div>';

            $html .= '<table class="summary_section_tbl">';

            foreach ($section as $key => $value) {
                $html .= '<tr>
                            <td class="sum_label">';
                $html .= $value['label'];
                $html .= '</td>';


                if ($value['expected_value'] === 'static') {

                    // $html .= '<td class="sum_status"> <span class="summ_success" style="font-weight: bolder; color: #7ad03a; font-size: 22px;">&#10003;</span></td>';

                    $html .= '<td class="sum_status">' . $value['value'] . '<td>';

                } elseif (isset($CFG->$key) && $value['expected_value'] == $CFG->$key) {

                    $success_msg = 'Disabled';
                    if ($value['expected_value']) {
                        $success_msg = 'Enabled';
                    }


                    $html .= '<td class="sum_status">
                                <span class="summ_success" style="font-weight: bolder; color: #7ad03a; font-size: 22px;">&#10003; </span>
                                <span style="color: #7ad03a;"> '. $success_msg .' </span>
                            </td>';
                } else {

                    // $html .= '<td class="sum_status"><span class="summ_error">&#9888; '. $value['error_msg'] .'<a href="'.$value['error_link'].'" target="_blank" >'.get_string('here', 'local_edwiserbridge').'</a> </span></td>';

                     $html .= '<td class="sum_status">
                                <span class="summ_error"> '. $value['error_msg'] .'<a href="'.$value['error_link'].'" target="_blank" >'.get_string('here', 'local_edwiserbridge').'</a> </span>
                            </td>';       
                    $error = 1;
                }
                $html .= '</td>
                        </tr>';
            }

            $html .= '</table>';
            $html .= ' </div>';
        }

        $mform->addElement(
            'html',
            $html
        );


        // $this->add_action_buttons(false);
    }

    public function validation($data, $files)
    {
        return array();
    }
}





