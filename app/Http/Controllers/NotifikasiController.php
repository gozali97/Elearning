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
    private function buildCommonMessage($title, $message, $targetDevice = null, $topic = null, $scheduledDatetime = null)
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
        
        // Set the scheduled datetime
        if ($scheduledDatetime != null) {
            $message['message']['android'] = [
                'ttl' => $this->calculateTtl($scheduledDatetime),
                'priority' => 'normal',
                'delivery_priority' => 'high',
                'collapse_key' => 'notifikasi'
            ];
        }

        return $message;
    }

    /**
     * * Calculate the time to live (TTL) value based on the scheduled datetime.
     *
     * @param string $scheduledDatetime
     * @return int
     */
    private function calculateTtl($scheduledDatetime)
    {
        date_default_timezone_set('Asia/Jakarta');
        $scheduledTimestamp = strtotime($scheduledDatetime);
        $currentTimestamp = time();
        $ttl = $scheduledTimestamp - $currentTimestamp;
        return $ttl > 0 ? $ttl : 0;
    }

    /**
     * * Set Scheduled Date-time 
     * 
     * @param string $scheduledDatetime = '2023-06-30 12:00:00'
     * * untuk format schedule yang dikirim adalah 'yyyy-MM-dd HH:mm:ss'
     * 
     * @return json|boolean|string terkirim, keterangan
     */
    public function setScheduledDatetime($title = 'FCM Notification', $message = 'Notification from Scheduled', $topic = null, $scheduledDatetime = null) {
        if ($topic != null && $scheduledDatetime != null) {
            return [
                'terkirim' => true,
                'keterangan' => $this->sendFcmMessage(
                    $this->buildCommonMessage($title, $message, topic: $topic, scheduledDatetime: $scheduledDatetime)
                )
            ];
        } else {
            return [
                'terkirim' => false,
                'keterangan' => "Parameter Topic dan Scheduled tidak boleh kosong"
            ];
        }
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
    public function setNotifikasiByDevice($title = 'FCM Notification', $message = 'Notification from Target Device', $targetDevice= null)
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