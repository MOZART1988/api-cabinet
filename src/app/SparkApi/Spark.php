<?php


namespace App\SparkApi;

use \GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Spark
{
    /**
     * @var Client
    */
    public $client;
    public $curl;

    public function __construct()
    {
        $this->client = new Client();
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
}