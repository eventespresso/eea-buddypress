<?php
/*
  Plugin Name: Event Espresso - BuddyPress Activity (EE 4.3+)
  Plugin URI: https://eventespresso.com/
  Description: The Event Espresso BuddyPress Integration adds event registrations to the BuddyPress activity timeline. BuddyPress Activity Streams must be active.
  Version: 0.0.1.dev.001
  Author: Event Espresso - Seth Shoultes
  Author URI: http://www.eventespresso.com
  Copyright 2014 Event Espresso (email : support@eventespresso.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA02110-1301USA
 *
 * ------------------------------------------------------------------------
 *
 * Event Espresso
 *
 * Event Registration and Management Plugin for WordPress
 *
 * @ package		Event Espresso
 * @ author			Event Espresso
 * @ copyright	    (c) 2008-2014 Event Espresso  All Rights Reserved.
 * @ license		http://eventespresso.com/support/terms-conditions/   * see Plugin Licensing *
 * @ link			http://www.eventespresso.com
 * @ version	 	EE4
 */
add_action(
    'AHEE__EE_System__load_espresso_addons',
    function () {
        // Don't run if BuddyPress is inactive
        if (function_exists('bp_is_active')) {
            require_once plugin_dir_path(__FILE__) . 'espresso-buddypress-hooks.php';
        }
    }
);



