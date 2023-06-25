<?php

namespace App\Http\Controllers;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class NotifikasiController extends Controller
{
    private $projectId;
    private $host;
    private $path;
    private $messagingScope;
    private $scopes;

    public function __construct()
    {
        $this->projectId = 'notifikasi-elearning';
        $this->host = 'fcm.googleapis.com';
        $this->path = '/v1/projects/' . $this->projectId . '/messages:send';
        $this->messagingScope = 'https://www.googleapis.com/auth/firebase.messaging';
        $this->scopes = [$this->messagingScope];
    }

    /**
     * * Get a valid access token.
     *
     * @return string
     * @throws GuzzleException
     */
    private function getAccessToken()
    {
        $key = json_decode(file_get_contents(storage_path('firebase/notifikasi-elearning-firebase.json')), true);
        $jwtClient = new ServiceAccountCredentials($this->scopes, $key);
        $jwtClient->fetchAuthToken();
        return $jwtClient->getLastReceivedToken()['access_token'];
    }

    /**
     * * Send HTTP request to FCM with given message
     *
     * @param array $fcmMessage
     * @param boolean $isCreateGroup
     * 
     * @return string
     * @throws GuzzleException
     */
    private function sendFcmMessage($fcmMessage, $isCreateGroup = false)
    {
        $accessToken = $this->getAccessToken();
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ],
            'json' => $fcmMessage
        ];

        $client = new Client();
        if ($isCreateGroup) {
            $response = $client->post('https://fcm.googleapis.com/fcm/notification', $options);
        } else {
            $response = $client->post('https://' . $this->host . $this->path, $options);
        }

        $responseData = json_decode($response->getBody(), true);

        if ($isCreateGroup) {
            return $responseData['notification_key'];
        }
        return json_encode($responseData, JSON_PRETTY_PRINT) . PHP_EOL;
    }

    /**
     * * Construct a JSON object that will be used to define the common parts of a notification message that will be sent to any app instance.
     *
     * @return array
     */
    private function buildCommonMessage($title, $message, $targetDevices = null, $topic = null, $group = null)
    {
        $message = [
            'message' => [
                'notification' => [
                    'title' => $title,
                    'body' => $message
                ]
            ]
        ];

        // Set the target devices
        if ($targetDevices != null) {
            if (is_array($targetDevices)) {
                $message['message']['token'] = $targetDevices;
            } else {
                $message['message']['token'] = (string) $targetDevices;
            }
        }

        // Set the topic
        if ($topic != null) {
            $message['message']['topic'] = $topic;
        }

        return $message;
    }
    
    /**
    * * Create Group
    *
    * @param array|string $registrationTokens = ['device_token_1', 'device_token_2']
    * * Specify the target devices (Daftar token perangkat anggota grup)
    * @param string $notificationKey = "appUser-Chris"
    * * Nama unik untuk grup
    * 
    * @return string
    */
    public function createGroup($notificationKey, $registrationTokens)
    {
        // Create Group
        $fcmMessage = [
            'operation' => "create",
            'notification_key_name' => $notificationKey,
            'registration_ids' => $registrationTokens
        ];

        if ($notificationKey != null && $registrationTokens != null) {
            return $this->sendFcmMessage($fcmMessage, true);
        } else {
            return "Parameter Notifikasi dan Token Devices tidak boleh kosong";
        }
    }
    
    /**
     * * Set Notifikasi By Group
     *
     * @param string $title, $message, $group
     * 
     * @return string
     */
    public function setNotifikasiByGroup($title = 'FCM Notification', $message = 'Notification from FCM', $group)
    {
        if ($group != null) {
            return $this->sendFcmMessage(
                $this->buildCommonMessage($title, $message, group: $group)
            );
        } else {
            return "Parameter Group tidak boleh kosong";
        }
    }

    /**
     * * Set Notifikasi By Topic
     *
     * @param string $title, $message, $topic
     * 
     * @return string
     */
    public function setNotifikasiByTopic($title = 'FCM Notification', $message = 'Notification from FCM', $topic)
    {
        if ($topic != null) {
            return $this->sendFcmMessage(
                $this->buildCommonMessage($title, $message, topic: $topic)
            );
        } else {
            return "Parameter Topic tidak boleh kosong";
        }
    }

    /**
     * * Set Notifikasi By Devices (Token)
     *
     * @param string $title, $message
     * @param array|string $targetDevices
     * * Specify the target devices (token or list of tokens)
     * * $targetDevices = ['device_token_1', 'device_token_2'];
     * * $targetDevices = 'device_token_1';
     * 
     * @return string
     */
    public function setNotifikasiByDevices($title = 'FCM Notification', $message = 'Notification from FCM', $targetDevices)
    {
        if ($targetDevices != null) {
            return $this->sendFcmMessage(
                $this->buildCommonMessage($title, $message, $targetDevices)
            );
        } else {
            return "Parameter Devices (Token Devices) tidak boleh kosong";
        }
    }
}