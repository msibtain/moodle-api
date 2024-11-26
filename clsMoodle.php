<?php
class clsMoodle
{
    private $token;
    private $api_url;

    function __construct()
    {
        $this->token = $_ENV['MOODLE_API_TOKEN'];
        $this->api_url = $_ENV['MOODLE_BASE_PATH'];
    }

    public function createUser( $data )
    {
        $functionName = 'core_user_create_users';
        $restFormat = 'json';

        $moodledata['users'][] = [
            'createpassword' => 0,
            'username' => $data['username'],
            'auth' => 'manual',
            'password' => $data['password'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'maildisplay'=> 0,
            //'city' => 'New York',
            //'country' => 'US',
            //'timezone' => '99',
            //'description' => 'This is description',
            //'firstnamephonetic' => '',
            //'lastnamephonetic' => '',
            //'middlename' => '',
            //'alternatename' => '',
            //'interests' => '',
            'idnumber' => $data['username'],
            //'institution' => '',
            //'department' => '',
            //'phone1' => '',
            //'phone2' => '',
            //'address' => '',
            'lang' => 'en',
            //'calendartype' => '',
            //'theme' => '',
            'mailformat' => 1
        ];

        $domainName = $this->api_url;
        $token = $this->token;

        $serverUrl = "$domainName/webservice/rest/server.php?wstoken=$token&wsfunction=$functionName&moodlewsrestformat=$restFormat";

        // Initialize cURL
        $ch = curl_init($serverUrl);

        // Configure cURL
        curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($moodledata));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the API call
        $response = curl_exec($ch);

        // Check for cURL errors
        if ($response === false) 
        {
            return 'cURL error: ' . curl_error($ch);
        }
        
        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['exception'])) {
            return "Error: " . $responseData['message'];
        } else {
            return "User created successfully!";
        }

        //echo "<pre>";
        //print_r($responseData);
        //echo "</pre>";
    }
}

global $clsMoodle;
$clsMoodle = new clsMoodle();