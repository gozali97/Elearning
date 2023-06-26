<?php

namespace App\Http\Controllers;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

// https://github.com/firebase/quickstart-nodejs/blob/cf70e0298e6a9e3fc55a28ead2e9493b2b7f1785/messaging/index.js
// https://firebase.google.com/docs/cloud-messaging
class NotifikasiController extends Controller
{
    private $projectId;
    private $host;
    private $path;
    private $messagingScope;
    private $scopes;

    public function __construct()
    {
        $this->projectId = 'notifikasi-elearning'; // * '<YOUR-PROJECT-ID>'
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
     * * Send HTTP request to FCM
     * 
     * @param array $fcmMessage
     * 
     * @return json|string
     * @throws GuzzleException
     */
    private function sendFcmMessage($fcmMessage)
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
        $response = $client->post('https://' . $this->host . $this->path, $options);
        $responseData = json_decode($response->getBody(), true);

        return $responseData;
    }

    /**
     * * Construct a JSON object that will be used to define the common parts of a notification message that will be sent to any app instance.
     *
     * @return array
     */
    private function buildCommonMessage($title, $message, $targetDevice = null, $topic = null)
    {
        $message = [
            'message' => [
                'notification' => [
                    'title' => $title,
                    'body' => $message
                ]
            ]
        ];

        // Set the target device
        if ($targetDevice != null) {
            $message['message']['token'] = $targetDevice;
        }

        // Set the topic
        if ($topic != null) {
            $message['message']['topic'] = $topic;
        }

        return $message;
    }

    /**
     * * Set Notifikasi By Topic
     *
     * @param string $title, $message, $topic
     * 
     * @return json|boolean|string terkirim, keterangan
     */
    public function setNotifikasiByTopic($title = 'FCM Notification', $message = 'Notification from Topic', $topic = null)
    {
        if ($topic != null) {
            return [
                'terkirim' => true,
                'keterangan' => $this->sendFcmMessage(
                    $this->buildCommonMessage($title, $message, topic: $topic)
                )
            ];
        } else {
            return [
                'terkirim' => false,
                'keterangan' => "Parameter Topic tidak boleh kosong"
            ];
        }
    }

    /**
     * * Set Notifikasi By Device (Token)
     *
     * @param string $title, $message, $targetDevice
     * * $targetDevice = 'device_token';
     * * Specify the target device (token)
     * 
     * @return json|boolean|string terkirim, keterangan
     */
    public function setNotifikasiByDevice($title = 'FCM Notification', $message = 'Notification from Device', $targetDevice= null)
    {
        if ($targetDevice != null) {
            return [
                'terkirim' => true,
                'keterangan' => $this->sendFcmMessage(
                    $this->buildCommonMessage($title, $message, $targetDevice)
                )
            ];
        } else {
            return [
                'terkirim' => false,
                'keterangan' => "Parameter Device (Token Device) tidak boleh kosong"
            ];
        }
    }
}