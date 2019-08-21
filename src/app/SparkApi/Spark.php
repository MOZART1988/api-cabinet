<?php


namespace App\SparkApi;

use \GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Spark
{
    const DEFAULT_LOGIN = 'тест';
    const DEFAULT_PASSWORD = '123';

    public $token = null;

    /**
     * @var Client
     */
    public $client;

    public static function authorize(Client $client, string $login = null, string $password = null)
    {
        $url = config('app.spark_api_url') . '/authorization';

        $response = null;

        try {
            $response = $client->request(
                'POST', $url,
                [
                    'body' => json_encode(
                        [
                            'login' => $login ? $login : self::DEFAULT_LOGIN,
                            'password' => $password ? $password : self::DEFAULT_PASSWORD
                        ], JSON_FORCE_OBJECT
                    ),
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]
            )->getBody();
        } catch (ClientException $e){

        }

        if ($response !== null) {
            $response = json_decode($response, JSON_FORCE_OBJECT);
        }

        return $response['token'] ? $response['token'] : null;
    }

    public function __construct()
    {
        $this->client = new Client();

        $this->token = self::authorize($this->client);
    }

    public function requestInvoice($invoiceNumber)
    {
        $url = config('app.spark_api_url') . '/invoicestatus?invoice_number=' . $invoiceNumber;

        $result = null;

        try {
            $response = json_decode($this->client->get($url)->getBody(), JSON_FORCE_OBJECT);

            if ($response['Status'] === 'Ошибка') {
                $result = [
                    'success' => false,
                    'msg' => $response['Error']
                ];
            } else {
                $result = [
                    'success' => true,
                    'data' => $response
                ];
            }


        } catch (ClientException $exception) {

        }

        return $result;
    }

    public function requestCatalog($catalogType)
    {
        $url = config('app.spark_api_url') . '/catalog?catalog=' . $catalogType;

        $result = null;

        try {
            $response = json_decode($this->client->get($url)->getBody(), JSON_FORCE_OBJECT);

            if (!empty($response['Status']) && ($response['Status'] === 'Ошибка')) {
                $result = [
                    'success' => false,
                    'msg' => $response['Error']
                ];
            } else {
                $result = [
                    'success' => true,
                    'data' => $response
                ];
            }


        } catch (ClientException $e) {

        }

        return $result;
    }

    public function addOrder($consignor, $shipments)
    {
        /**
         * {
            "consignor": {
                "name": 'Spark',
                "bin": 12345678901,
                "country": 'Kazkahstan',
                "province": 'Almaty oblast',
                "city": 'Алматы',
                "street": 'Tole Bi',
                "post_index": '345345',
                "building": '101',
                "office": 'Block E',
                "contact_person": 'Ivanov',
                "contact_phone": '77777776655'
            },

            "shippings": [
            {

                "receiver": {
                    "type": 'Юридическое лицо',
                    "name": 'Big Tech',
                    "bin": 12345678901,
                    "country": 'Russia',
                    "province": 'Moskovskaya oblast',
                    "city": 'Москва',
                    "post_index": '345345',
                    "street": 'Balchug',
                    "building": '7',
                    "office": '5',
                    "contact_person": 'Petrov',
                    "contact_phone": '79133334455'
                },

                "cargo": {
                    "places": 3,
                    "weight": 100,
                    "volume": 6,
                    "payment_type": 'Отправителем',
                    "payment_method": "Перечислением на счет",

                    "shipment_type": 'Стандарт',
                    "annotation": 'Не слишком длинное примечание',
                    "cod": 30000,
                    "declared_price": 60000
                }
            }
        ]}
        */

        /**
         * В объекте $consignor required
         * contact_person
         * contact_phone
         * city
         * Объект shipments обязателен, тут баг возвращает пустоту если не передать эти штуки
         * Объект receiver обязательны contact_phone, contact_person
         * В объекте cargo обязательны payment_type, payment_method, shipment_type
        */

        $token = $this->token;

        if ($token == null) {
            $token = self::authorize($this->client);
        }

        $url = config('app.spark_api_url') . '/order';

        $response = null;

        $shipmentsResult = [];

        foreach ($shipments as $shipment) {
            $shipmentsResult[] = [
                'receiver' => $shipment['receiver'],
                'cargo' => $shipment['cargo']
            ];
        }

        $body = json_encode([
            'consignor' => $consignor,
            'shippings' => $shipmentsResult
        ]);

        try {
            $response = $this->client->request(
                'POST', $url,
                [
                    'body' => $body,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'token' => $token,
                    ]
                ]
            )->getBody();
        } catch (ClientException $e){
            $response = $e->getResponse()->getBody();
        }

        if ($response !== null) {
            $response = json_decode($response, JSON_FORCE_OBJECT);
        }

        return $response;
    }

    public function listTemplates()
    {
        $token = $this->token;

        if ($token == null) {
            $token = self::authorize($this->client);
        }

        $url = config('app.spark_api_url') . '/template';

        $response = null;

        try {
            $response = json_decode($this->client->get($url,
                ['headers' => [
                    'token' => $token
                ]])->getBody(), JSON_FORCE_OBJECT);


        } catch (ClientException $exception) {

        }

        return $response;
    }

    public function addTemplate($object)
    {
        $token = $this->token;

        if ($token == null) {
            $token = self::authorize($this->client);
        }

        $url = config('app.spark_api_url') . '/template';

        $response = null;
        $body = json_encode(
            $object, JSON_FORCE_OBJECT
        );

        try {
            $response = $this->client->request(
                'POST', $url,
                [
                    'body' => $body,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'token' => $token
                    ]
                ]
            )->getBody();
        } catch (ClientException $e){

        }

        if ($response !== null) {
            $response = json_decode($response, JSON_FORCE_OBJECT);
        }

        return $response;


    }
}