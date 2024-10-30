<?php

/**
 * Plugin Name: ChaletAgent
 * Plugin URI: http://ChaletAgent.com/
 * Description: This plugin integrates ChaletAgent with your WordPress based chalet website.
 * Version: 0.2.17
 * Author: ChaletAgent
 * Author URI: http://ChaletAgent.com/
 * License: GPL2
 */

/*  Copyright 2014  ChaletAgent  (email : info@chaletagent.com)

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License, version 2, as
   published by the Free Software Foundation.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') or die("No script kiddies please!");

include_once 'config.php';
include_once 'class/main.php';
include_once 'class/api.php';

// Installation and un-installation hooks
register_activation_hook(__FILE__, array('ChaletAgent', 'activate'));
register_deactivation_hook(__FILE__, array('ChaletAgent', 'deactivate'));

// Instantiate the plugin class. This is our only global.
$chaletAgent = new ChaletAgent();

include_once 'inc/template-tags.php';
