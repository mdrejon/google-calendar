<?php
 

class GoogleCalendar{

    public $clientId;
    public $clientSecret;
    public $redirectUrl;

    private $accessToken;

    public $revokeUrl = 'https://oauth2.googleapis.com/revoke';
    public $tokenUrl = 'https://oauth2.googleapis.com/token';
    private $refreshTokenUrl = 'https://www.googleapis.com/oauth2/v3/token';
    public $authUrl = 'https://accounts.google.com/o/oauth2/auth';
 
    public $calendarEvent = 'https://www.googleapis.com/calendar/v3/calendars/primary/events/';

 
    public function __construct($clientId, $clientSecret, $redirectUrl) {

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUrl =  $this->getRedirectUrl();
    }

    // Get Redirect URL
    public function getRedirectUrl(){
        return 'https://sydur.tourfic.site/wp-json/hydra/v1/google-calendar';
    }


    public function generateAuthCode($code)
    {
        $body = [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUrl,
            'grant_type'    => 'authorization_code',
            'code'          => $code
        ];

        $type = 'GET';
        $url = $this->tokenUrl;
        $headers = [
            'Content-Type'              => 'application/http',
            'Content-Transfer-Encoding' => 'binary',
            'MIME-Version'              => '1.0',
        ];

        $args = [
            'headers' => $headers,
            'method'  => $type,
            'timeout' => 20
        ];

        if ($body) {
            
            $url = add_query_arg($body, $url);
        }

        $request = wp_remote_request($url, $args);
 
    }

    public function GetAccessToken( $code){
        $url = $this->tokenUrl;
        $clientId = $this->clientId;
        $clientSecret = $this->clientSecret;
        $redirectUrl = $this->redirectUrl;
        $post_fields = array(
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUrl,
            'grant_type' => 'authorization_code'
        ); 
        // use Wp Remote Request
        $response = wp_remote_post($url, array(
            'body' => $post_fields
        ));
        $body = wp_remote_retrieve_body($response);

        return $body;
        exit;

        return json_decode($body, true);
    }

}