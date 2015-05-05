<?php
/*
Plugin Name: RdStation
Plugin URI: https://github.com/pixelcake/RdStation
Description: A simple plugin to connect RdStation to WordPress.
Version: 1.0
Author: Marco Gonzaga
Author URI: http://www.pixelcake.com.br
Author Email: contato@pixelcake.com.br
License:
 
  Copyright 2015 Marco Gonzaga (contato@pixelcake.com.br)
 
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
//Disalow access file directly

defined( 'ABSPATH' ) or die( 'Sorry, you can\'t access directly!' );

//add menu to admin panel
if ( is_admin() ) {
	add_action( 'admin_menu', 'rd_menu' );
	add_action( 'admin_init', 'rd_register' );
}

//add sub menu page to the Settings menu
function rd_menu() {
	add_options_page( 'RdStation Connect', 'RdStation', 'manage_options', 'plugin.php',  'rd_rdstation_options' );
}

//register a setting and sanitization callback	
function rd_register() {
	register_setting( 'rd_optiongroup', 'rd_token' );
}

//print the field for token
function rd_rdstation_options() { ?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br/></div>
		<h2>RdStation Connect</h2>
		<p>Adicione seu token RdStation aqui</p>
		<p>Caso não saiba acesse seu <a href="https://www.rdstation.com.br/integracoes" target="_blank"> perfil aqui</a></p>
		<form method="post" action="options.php">
			<?php settings_fields('rd_optiongroup'); ?>
			
			<table class="form-table" style="margin-top: 20px; padding-bottom:10px; border: 1px dotted #ccc; border-width: 1px 0;">
				<tr valign="top">
					<th scope="row">
						<h3 style="margin-top: 10px";>
							Token
						</h3>
					</th>
				</tr>
				<tr>
					<td>
						<input type="password" name="rd_token" value="<?php echo get_option( 'rd_token' ); ?>" style="width: 400px; padding: 10px;">
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" class="button-primary" value="Save Changes"/>
			</p>	
		</form>
	</div>
<?php
}
//create new action hook rd_station
function rd_rdstation() {
	do_action( 'rd_rdstation' );
}
		
add_action( 'rd_rdstation', 'rd_rdstation_output' );

function rd_rdstation_output() {
	//print token
	echo get_option( 'rd_token' );
}


/**
 * RD Station - Integrações
 * addLeadConversionToRdstationCrm()
 * Envio de dados para a API de leads do RD Station
 *
 * Parâmetros:
 *     ($rdstation_token) - token da sua conta RD Station ( encontrado em https://www.rdstation.com.br/docs/api )
 *     ($identifier) - identificador da página ou evento ( por exemplo, 'pagina-contato' )
 *     ($data_array) - um Array com campos do formulário ( por exemplo, array('email' => 'teste@rdstation.com.br', 'name' =>'Fulano') )
 */
 		
function addLeadConversionToRdstationCrm( $rdstation_token, $identifier, $data_array ) {
  $api_url = "http://www.rdstation.com.br/api/1.2/conversions";
 
  try {
    if (empty($data_array["token_rdstation"]) && !empty($rdstation_token)) { $data_array["token_rdstation"] = $rdstation_token; }
    if (empty($data_array["identificador"]) && !empty($identifier)) { $data_array["identificador"] = $identifier; }
    if (empty($data_array["email"])) { $data_array["email"] = $data_array["your-email"]; }
    if (empty($data_array["c_utmz"]) && !empty($data_array["c_utmz"])) { $data_array["c_utmz"] = $_COOKIE["__utmz"]; }
    unset($data_array["password"], $data_array["password_confirmation"], $data_array["senha"], 
          $data_array["confirme_senha"], $data_array["captcha"], $data_array["_wpcf7"], 
          $data_array["_wpcf7_version"], $data_array["_wpcf7_unit_tag"], $data_array["_wpnonce"], 
          $data_array["_wpcf7_is_ajax_call"], $data_array["_wpcf7_locale"], $data_array["your-email"]);

    if ( !empty($data_array["token_rdstation"]) && !( empty($data_array["email"]) && empty($data_array["email_lead"]) ) ) {
      $data_query = http_build_query($data_array);
      if (in_array ('curl', get_loaded_extensions())) {
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_query);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
      } else {
        $params = array('http' => array('method' => 'POST', 'content' => $data_query, 'ignore_errors' => true));
        $ctx = stream_context_create($params); 
        $fp = @fopen($api_url, 'rb', false, $ctx);
      }
    }
  } catch (Exception $e) { }
}
function addLeadConversionToRdstationCrmViaWpCf7( $cf7 ) {
  $token_rdstation = get_option( 'rd_token' );
  $submission = WPCF7_Submission::get_instance();

  if ( $submission ) {
      $form_data = $submission->get_posted_data();
    }
  addLeadConversionToRdstationCrm($token_rdstation, null, $form_data);
}
add_action('wpcf7_mail_sent', 'addLeadConversionToRdstationCrmViaWpCf7');  				
