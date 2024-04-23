<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WP Database CRUD Admin Class.
 */
class WTDGC_ADMIN {

    public $google_calendar = null; 
    public $clientId = '752228332202-lti8lnai8sh8bb9v1tisrviekhhnimhc.apps.googleusercontent.com';
    public $clientSecret = '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';
    public $redirectUrl = 'https://sydur.tourfic.site/wp-json/hydra/v1/google-calendar';

	/**
	 *  __construct
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {

		// enqueue admin scripts.
		// add_action( 'admin_enqueue_scripts', array( $this, 'wtddb_admin_enqueue_scripts' ) );


        // Load admin class.
		require_once WTDDB_PATH . 'includes/GoogleCalendar/GoogleCalendar.php';
        $this->google_calendar = new GoogleCalendar($this->clientId, $this->clientSecret, $this->redirectUrl);

		// Activation Hook.
		register_activation_hook( WTDDB_PATH . 'wp-database-crud.php', array( $this, 'wtddb_activation_hook' ) );

		// Add admin menu.
		add_action( 'admin_menu', array( $this, 'wtddb_admin_menu' ) );

		// Create a rest api 
		add_action('rest_api_init', array($this, 'register_routes'));
	}

	public function register_routes(){
        register_rest_route('hydra/v1', '/google-calendar', array(
            'methods' => 'GET',
            'callback' => array($this, 'google_calendar_api'),
            // 'permission_callback' => function () {
            //     return current_user_can('edit_others_posts');
            // }
        ));
    }

	public function google_calendar_api(){ 

        // Google passes a parameter 'code' in the Redirect Url
		if(isset($_GET['code'])) {
			try { 
				
				// Get the access token 
				$data = $this->google_calendar->GetAccessToken( $_GET['code']);
				echo $data;
				
				// // Save the access token as a session variable
				// $_SESSION['access_token'] = $data['access_token'];

				// // Redirect to the page where user can create event
				// header('Location: home.php');
				exit();
			}
			catch(Exception $e) {
				echo $e->getMessage();
				exit();
			}
		}
        
    
    }

	/**
	 * Enqueue admin scripts.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function wtddb_admin_enqueue_scripts() {

	 
	} 
	/**
	 * Add admin menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function wtddb_admin_menu() {

		// Add menu page.
		add_menu_page(
			__( 'Google Calendar', 'wp-database-crud' ),
			__( 'Google Calendar', 'wp-database-crud' ),
			'manage_options',
			'wtdgc-google-calendar',
			array( $this, 'wtdgc_admin_page' ),
			'dashicons-admin-tools',
			20
		);
	}

	/**
	 * Admin page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function wtdgc_admin_page() {
        $login_url = $this->google_calendar->authUrl.'?scope=https://www.googleapis.com/auth/calendar&redirect_uri=' . urlencode($this->google_calendar->redirectUrl) . '&response_type=code&client_id=' . $this->google_calendar->clientId . '&access_type=online';

		?>
		<div class="wrap">
			<div class="wtddb-page-title">
				<h1><?php echo esc_html( __( 'WP Database CRUD', 'wp-database-crud' ) ); ?></h1>
				 <!-- Get Acces Token link -->
                 <a target="_blank" href="<?php echo $login_url; ?>" class="button button-primary">Get Access Token</a>
            
			</div>
			<div class="wtddb-content-wrap"> 

			</div>
 
			 
		</div>
		<?php
	}


 
}
