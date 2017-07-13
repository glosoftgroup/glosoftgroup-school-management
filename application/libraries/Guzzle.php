<?php

    if (!defined('BASEPATH'))
         exit('No direct script access allowed');

    include_once(dirname(__FILE__) . '/vendor/autoload.php');

    class Guzzle
    {

         protected $token;
         protected $end;

         public function __construct()
         {
              $this->token = 'e651448bca3c5768c8acb95959888d92507c285a';
              $this->end = 'http://hub.com/api/v1/';
         }

         function get($slug, $debug = FALSE)
         {
              $client = new \GuzzleHttp\Client();
              try
              {
                   $reqw = $client->request('GET', $this->end . $slug, [
                           'headers' => [
                                   'Content-type' => 'application/json',
                                   'Accept' => 'application/json',
                                   'X-Authorization' => $this->token
                           ], 'debug' => $debug
                   ]);

                   $resp = $reqw->getBody()->getContents();
              }
              catch (RequestException $e)
              {
                   $resp = $e->getResponse()->getBody()->getContents();
              }
              catch (Exception $e)
              {
                   $resp = $e->getResponse()->getBody()->getContents();
              }
              if ($debug)
              {
                   print_r($resp);
              }

              return $resp;
         }

         function post($slug, $data = [], $debug = FALSE)
         {
              $client = new \GuzzleHttp\Client();
              try
              {
                   $reqw = $client->request('POST', $this->end . $slug, [
                           'headers' => [
                                   'Accept' => 'application/json',
                                   'X-Authorization' => $this->token
                           ],
                           'form_params' => $data,
                           'debug' => $debug
                   ]);
                   //$resp = $reqw->getStatusCode();
                   $resp = $reqw->getBody()->getContents();
              }
              catch (RequestException $e)
              {
                   $resp = $e->getResponse()->getBody()->getContents();
              }
              catch (Exception $e)
              {
                   $resp = $e->getResponse()->getBody()->getContents();
              }
              if ($debug)
              {
                   echo '<pre>';
                   print_r($resp);
                   echo '</pre>';
              }

              return $resp;
         }

    }
    