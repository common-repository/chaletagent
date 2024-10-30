<?php

class ChaletAgent
{
	/**
	 * @var string
	 */
	protected $plugin_options_url;

	/**
	 * @var string
	 */
	protected $saas_account;

	/**
	 * @var ChaletAgentAPI
	 */
	protected $api;

	public function __construct ()
	{
		// Set options URL
		$this->plugin_options_url = admin_url("options-general.php?page=chaletagent-options");

		// Create the config option if it doesn't already exist.
		add_option('chaletagent_saas_account', '');

		// Get the current value of the option
		$this->saas_account = get_option('chaletagent_saas_account');

		// Show warning message in admin if no saas account is defined
		if (empty($this->saas_account) && @$_GET["page"] != 'chaletagent-options')
		{
			add_action('admin_notices', array($this, 'configure_reminder'));
		}

		$this->api = new ChaletAgentAPI($this->saas_account);

		// Register the admin menu
		add_action('admin_menu', array($this, 'admin_menu'));

		// Define shortcodes
		$this->define_shortcodes();

		// Enqueue custom CSS
		add_action('wp_enqueue_scripts', array($this, 'enqueue_style'));
	}

	/**
     * Activate the plugin
     */
    public static function activate ()
    {
        // Do nothing yet
    }

    /**
     * Deactivate the plugin
     */
    public static function deactivate ()
    {
        // Do nothing yet
    }

	/*#######################################################################################*/

	/**
	 * Define all shortcodes here
	 */
	public function define_shortcodes ()
	{
		add_shortcode('chaletagent_availability', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_transfers', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_testimonials', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_testimonials_catered', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_testimonials_self_catered', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_seasons', array($this, 'chaletops_shortcode'));
		add_shortcode('chaletagent_properties', array($this, 'chaletops_shortcode'));
	}

	/**
	 * Create shortcode
	 *
	 * @param string $name    The API method name to call
     * @param string $content TBC
	 * @param array  $attr    The parameters to send to the method
	 *
	 * @return string
	 */
	public function chaletops_shortcode ($attr, $content = '', $name)
	{
		$name = 'get_' . str_replace('chaletagent_', '', $name);

		$parameters = shortcode_atts(array(
			'season' => null,
			'property' => null,
			'properties' => null,
			'format' => null,
		), $attr );

		return $this->api->{$name}($parameters);
	}

	/**
	 * Create template tag
	 *
	 * @param string $name The API method name to call
	 * @param array  $attr The parameters to send to the method
	 *
	 * @return string
	 */
	public function chaletops_template ($name, $attr)
	{
		$name = 'get_' . $name;

		return $this->api->{$name}($attr);
	}

	/*#######################################################################################*/

	/**
	 * Define the admin navigation entry
	 */
	public function admin_menu ()
	{
		add_options_page(
			'ChaletAgent Options',
			'ChaletAgent',
			'manage_options',
			'chaletagent-options',
			array($this, 'admin_options')
		);
	}

	/**
	 * Define the admin screen that allows setting of options
	 */
	public function admin_options ()
	{
		if (!current_user_can('manage_options'))
		{
			wp_die(__( 'You do not have sufficient permissions to access this page.' ));
		}

		// Variables for the field and option names
		$hidden_field 	= 'chaletagent_submit_hidden';

		// Read in existing option value from database
		$saas_account = get_option('chaletagent_saas_account');
		//$custom_css = get_option('chaletagent_custom_css');

		// See if the user has posted us some information
		// If they did, this hidden field will be set to 'Y'
		if (isset($_POST[$hidden_field]) && $_POST[$hidden_field] == 'Y')
		{
			// Read their posted value
			$saas_account = $_POST['chaletagent_saas_account'];
			//$custom_css = $_POST['chaletagent_custom_css'];

			// Save the posted value in the database
			update_option('chaletagent_saas_account', $saas_account);
			//update_option('chaletagent_custom_css', $custom_css);

			// Put an settings updated message on the screen
			?><div class="updated">
				<p><strong><?php _e('Settings saved OK!', 'menu-test' ); ?></strong></p>
			</div><?php
		}

		// Now display the settings editing screen
		echo '<div class="wrap" style="height: 2000px;">';
		echo "<h2>" . __( 'ChaletAgent Settings', 'menu-test' ) . "</h2>";

			// Settings form
			?>
			<p>Please configure the plugin here before use.</p>

			<form name="form1" method="post" action="">
				<input type="hidden" name="<?php echo $hidden_field; ?>" value="Y">
				<?php if (empty($saas_account))
				{
					echo "<p style='color: #c00; font-weight: bold;'>You must define your account name before you can use the plugin.</p>";
				} ?>
				<p>
					<?php _e("ChaletAgent Account:", 'menu-test' ); ?>
					<input type="text" name="chaletagent_saas_account" value="<?php echo $saas_account; ?>" size="20">
					<b>.chaletagent.com</b>
				</p>
				<!--<p>
					<?php //_e("Custom CSS:", 'menu-test' ); ?>
					<textarea name="chaletagent_custom_css" rows="20" cols="50"><?php //echo $custom_css; ?></textarea>
				</p>-->
				<hr />
				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
				</p>
			</form>

			<?php include __DIR__ . '/../inc/help-text.php'; ?>
			<?php include __DIR__ . '/../inc/error-log.php'; ?>

		</div>

		<?php
	}

	/**
	 * Show a notice in the admin telling user to configure plugin
	 */
	public function configure_reminder ()
	{
		$class = 'error';
		$message = '<b>ChaletAgent:</b> You must define your account name in the <a href="' . $this->plugin_options_url . '">settings</a>.';
        echo "<div class=\"{$class}\"><p>{$message}</p></div>";
	}

	/**
	 * Proper way to enqueue scripts and styles
	 */
	public function enqueue_style ()
	{
		wp_enqueue_style('chalet-agent', plugins_url('../css/chalet-agent.css', __FILE__));
	}

}
