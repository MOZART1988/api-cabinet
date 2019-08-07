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
        $this->curl = curl_init();
    }

    public function requestInvoice($invoiceNumber)
    {
        $url = config('app.spark_api_url') . '/invoicestatus?invoice_number=' . $invoiceNumber;

        curl_setopt_array($this->curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache",
                "content-type: application/json"
            ],
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ]);

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            die();
        } else {
            try {
                $res = $response;
            } catch (\Exception $exception) {
                $res = ['success' => false];
            }
        }

        return $res;
    }
}