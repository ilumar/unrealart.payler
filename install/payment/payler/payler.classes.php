<?php

class CPayler
{
    function __construct($test) {
        $this->test = $test;
        $host = ($test ? "sandbox" : "secure");
        $this->base_url = "https://" . $host . ".payler.com/gapi/";
    }
    
    /**
     * @desc �������� POST-������� ��� ������ curl.
     *
     * @param $data ������ ������������ ������
     * @result ������������� ������ ������������ ������
     */
    function CurlSendPost ($data) {	
        $headers = array(
            'Content-type: application/x-www-form-urlencoded',
            'Cache-Control: no-cache',
            'charset="utf-8"',
	);
        
        $data = http_build_query($data);

        $options = array (
            CURLOPT_URL => $this->url,
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 45,
            CURLOPT_VERBOSE => 0,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $data,            
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        );
        
        $ch = curl_init();
        curl_setopt_array($ch, $options);
	$json = curl_exec($ch);
        if ($json == false) {
            die ('Curl error: ' . curl_error($ch) . '<br>');
        }
        //����������� JSON � ������������� ������
        $result = json_decode($json, TRUE);
	curl_close($ch);
        
	return $result;
    }    
    
    /**
    * @desc ����� ������� � Gate API Payler
    *
    * @param array $data ������ ������������ ������
    * @param string $method ����� API
    * @result ������������� ������ ������������ ������
    */
    public function POSTtoGateAPI ($data, $method) {
        $this->url = $this->base_url.$method;
        $result = $this->CurlSendPost($data);
        return $result;
    }
    
    /**
    * @desc �������� ������������ �� ������
    *
    * @param $session_id ������ ���������� ������������� ������
    * @result ������������� ������ ������������ ������
    */
    function Pay ($session_id) {
        $this->url = $this->base_url."Pay";
        $result = '<form method ="POST" action="'.$this->url.'">'
                . '<input type="hidden" name="session_id" '
                . 'value="'.$session_id.'">'
                . '<input class="btn" type="submit" name="submit" id="submit" value="Submit this payment" style="display:none">'
                . '</form>';
        return $result;
    }
}

?>
