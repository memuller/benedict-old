<?php 
	/*
	Plugin Name: Benedict
	Version: 0.0.1
	Plugin URI: http://benedict.com.br
	Description: Manages content on +B main site.
	Author: Matheus Muller
	Author URI: http://memuller.com
	*/

	/*
	Copyright (c) 2012, Matheus Muller

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
	*/


	# Requires vendored libs and base structure.
	require_once 'vendors/haml/HamlParser.class.php' ;
	#require_once 'vendors/recaptcha-php/recaptchalib.php';
	if(!class_exists('Presenter')) require_once 'lib/Presenter.php' ;
	if(!class_exists('BasePost')) require_once 'lib/BasePost.php' ;
	if(!class_exists('DB_Object')) require_once 'lib/DB_Object.php' ;
	if(!class_exists('CustomPost')) require_once 'lib/CustomPost.php' ;

	# Requires WP table/list framework.
	if(!class_exists('WP_List_Table')) require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	
	require 'base/Base.php' ;
	Benedict\Plugin::build();

?>
