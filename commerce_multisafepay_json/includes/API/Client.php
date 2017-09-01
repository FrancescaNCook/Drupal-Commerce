<?php

/**
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the MultiSafepay plugin
 * to newer versions in the future. If you wish to customize the plugin for your
 * needs please document your changes and make backups before you update.
 *
 * @category MultiSafepay
 * @package Connect
 * @author TechSupport <techsupport@multisafepay.com>
 * @copyright Copyright (c) 2017 MultiSafepay, Inc. (http://www.multisafepay.com)
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
class API_Client
{

    public $orders;
    public $issuers;
    public $transactions;
    public $gateways;
    public $affiliates;
    protected $api_key;
    public $api_url;
    public $api_endpoint;
    public $request;
    public $response;
    public $debug;

    public function __construct()
    {
        $this->orders = new API_Object_Orders($this);
        $this->issuers = new API_Object_Issuers($this);
        $this->gateways = new API_Object_Gateways($this);
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setApiUrl($url)
    {
        $this->api_url = trim($url);
    }

    public function setDebug($debug)
    {
        $this->debug = trim($debug);
    }

    public function setApiKey($api_key)
    {
        $this->api_key = trim($api_key);
    }

    public function processAPIRequest($http_method, $api_method, $http_body = NULL)
    {
        if (empty($this->api_key)) {
            throw new Exception("Please configure your MultiSafepay API Key.");
        }

        $url = $this->api_url . $api_method;
        $ch = curl_init($url);

        $request_headers = array(
            "Accept: application/json",
            "api_key:" . $this->api_key,
        );

        if ($http_body !== NULL) {
            $request_headers[] = "Content-Type: application/json";
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $http_body);
        }

        /* echo $url;
          print_r($request_headers);
          print_r($http_body);exit; */


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);

        $body = curl_exec($ch);

        if ($this->debug) {
            $this->request = $http_body;
            $this->response = $body;
            $file_hash = substr(hash('sha512', substr($this->api_key, 0, 10)), 0 ,10);
            $this->requestLogger(print_r($this->request,true),print_r($this->response,true), "INFO", realpath(dirname(__FILE__)). DIRECTORY_SEPARATOR ."logs".DIRECTORY_SEPARATOR .$file_hash."-multisafepay_requests.log", $url, $http_method);
        }

        if (curl_errno($ch)) {
            throw new Exception("Unable to communicatie with the MultiSafepay payment server (" . curl_errno($ch) . "): " . curl_error($ch) . ".");
        }

        curl_close($ch);
        return $body;
    }
    
    

    function requestLogger($request, $response, $level='i', $file='request', $url, $method) {
    	error_log(date("[Y-m-d H:i:s]")."\t[".$level."]\t[".$url."]\t[".$method."]\t[".basename(__FILE__)."]\t".$request."\n", 3, $file);
    	error_log(date("[Y-m-d H:i:s]")."\t[".$level."]\t[".$url."]\t[".$method."]\t[".basename(__FILE__)."]\t".$response."\n", 3, $file);
	}
}
