<?php
/*
Plugin Name: Wham Bam
Description: Grow your mailing list with Wham Bam! The only push-down email collection widget.
Author: Wham Bam
Version: 1.1.0
Author URI: https://whambam.io/en/
Text Domain: bbpp-whambam
Domain Path: /languages/
*/

/*  Copyright 2017 Brendon Boshell

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function bbpp_whambam_admin_menu() {
  add_options_page(
    "Wham Bam",
    "Wham Bam",
    "manage_options",
    "whambam",
    "bbpp_whambam_options_page"
  );
}

function bbpp_whambam_options_page() {
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
  }
  ?>
    <div class="wrap">
      <h1><?php echo __('Wham Bam', 'bbpp-whambam'); ?></h1>

      <form action="options.php" method="post">
        <?php settings_fields( 'whambam' ); ?>
        <table class="form-table">
          <tr>
            <th scope="row"><label for="bbpp-whambam-apikey"><?php _e('API Key', 'bbpp-whambam') ?></label></th>
            <td><input name="bbpp-whambam-apikey" type="text" value="<?php form_option('bbpp-whambam-apikey'); ?>" class="regular-text" /></td>
          </tr>
        </table>

        <p><strong>Need an API key?</strong> Head to
          <a href="https://whambam.io" target="_blank">whambam.io</a> and create a new widget.</p>

        <?php submit_button(); ?>
      </form>
    </div>
  <?php
}

function bbpp_whambam_admin_init() {
	register_setting( 'whambam', 'bbpp-whambam-apikey', 'strval' );
}

function bbpp_whambam_wp_head() {
  $apikey = get_option('bbpp-whambam-apikey');

  if ($apikey && is_singular()) {
    ?>
    <!-- Start of Wham Bam widget -->
    <script>
    (function (w,h,a,m) {
    h[w]=h[w]||function(){if(!h[w].t){h[w].t=[]}h[w].t.push(arguments)};
    m=a.createElement("script");m.async=true;m.src="https://cdn.whambam.io/javascripts/whambam/bundle.js";
    a.getElementsByTagName("head")[0].appendChild(m);
    })('whambam', window, document);
    whambam(<?php echo json_encode($apikey); ?>);
    </script>
    <!-- End of Wham Bam widget -->
    <?php
  }
}

add_action('admin_init', 'bbpp_whambam_admin_init' );
add_action("admin_menu", "bbpp_whambam_admin_menu");
add_action('wp_head', 'bbpp_whambam_wp_head');
