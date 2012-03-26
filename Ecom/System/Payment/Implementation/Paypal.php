<?php namespace Ecom\System\Payment\Implementation;

use Ecom\System\Configuration;

class Paypal
{
    public function auth(array $data)
    {
		$auth = '&PAYMENTACTION=AUTHORIZATION&AMT='.$data['amount'].
				'&CREDITCARDTYPE='.$data['card_type'].'&ACCT='.$data['card_num'].
				'&EXPDATE='.  str_pad($data['exp_month'], 2, '0', STR_PAD_LEFT).
				$data['exp_year'].'&CVV2='.$data['cvv'].'&FIRSTNAME='.
				$data['first_name'].'&LASTNAME='.$data['last_name'].'&STREET='.
				$data['line_1'].'&CITY='.$data['city'].'&STATE='.$data['state'].
				'&ZIP='.$data['zip'].'&COUNTRYCODE='.$data['country'].
				'&CURRENCYCODE='.$data['currency'];

        $results = $this->call('DoDirectPayment',$auth);

        $ack = strtoupper($results['ACK']);

        if($ack != 'SUCCESS')
		{
			return $results;
        }
		
		return true;
    }
    
    public function call($call_type, $data_str)
    {
            $config = new Configuration\Configurator();
            $data = $config->paypal;
            
            $head = '&PWD='.urlencode($data['password']).'&USER='.urlencode($data['username']).'&SIGNATURE='.urlencode($data['signature']);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $data['api_url']);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_POST, 1);

            if(!empty($data['token']) && !empty($data['signature']) && !empty($data['timestamp']))
            {
				$headers_array[] = "X-PP-AUTHORIZATION: ".$head;

				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_array);
				curl_setopt($ch, CURLOPT_HEADER, false);
            }
            else 
            {
                    $data_str = $head.$data_str;
            }
            
			if($data['proxy'])
			{
				curl_setopt ($ch, CURLOPT_PROXY, $data['proxy_host'].':'.$data['proxy_post']); 
			}

			$data_str = 'METHOD='.urlencode($call_type).'&VERSION='.urlencode($data['version']).$data_str;	

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);

            $response = curl_exec($ch);

            $response_arr = $this->extract_data($response);

            if (curl_errno($ch)) 
			{
				$_SESSION['curl_error_no']  = curl_errno($ch) ;
				$_SESSION['curl_error_msg'] = curl_error($ch);
            } 
			else 
			{
				curl_close($ch);
            }

		return $response_arr;
    }
	
	private function extract_data($str)
	{
		$data = [];

		while(strlen($str))
		{
			$key_pos   = strpos($str,'=');
			$value_pos = strpos($str,'&') ? strpos($str,'&') : strlen($str);

			$key = substr($str, 0, $key_pos);
			$val = substr($str, $key_pos+1, $value_pos-$key_pos-1);

			$data[urldecode($key)] = urldecode($val);
			$str = substr($str, $value_pos+1);
		}
		
//		$temp_data = explode('&', $str);
//		
//		foreach($temp_data as $temp)
//		{
//			$temp_arr = explode('=', $temp);
//			$data[urldecode($temp_arr[0])] = urldecode($temp_arr[1]);
//		}
		
		return $data;
	}
}