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
 * Atto styles - Settings file
 *
 * @package    atto_styles2
 * @copyright  2015 Andrew Davidson, Synergy Learning UK <andrew.davidson@synergy-learning.com>
 *             on behalf of Alexander Bias, Ulm University <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$ADMIN->add('editoratto', new admin_category('atto_styles2', new lang_string('pluginname', 'atto_styles2')));

$settings = new admin_settingpage('atto_styles2_settings', new lang_string('settings', 'atto_styles2'));

if ($ADMIN->fulltree) {
    $a = new stdClass();
    $a->code_example = new lang_string('code_example', 'atto_styles2');
    $a->code_example_bootstrap = new lang_string('code_example_bootstrap', 'atto_styles2');
    $a->code_example_bootstrap_multiple = new lang_string('code_example_bootstrap_multiple', 'atto_styles2');
    $name = new lang_string('config', 'atto_styles2');
    $desc = new lang_string('config_desc', 'atto_styles2', $a);
    $default = '';

    $setting = new \atto_styles2\admin_setting_configtextarea_validatejson('atto_styles2/config', $name, $desc, $default);
    $settings->add($setting);
}
