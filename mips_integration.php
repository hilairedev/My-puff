
<section>


    <h1 style="padding:20px; text-align:center">Finalisez votre paiement</h1>

</section>



<?php
// exit();
    // include_once 'fonctions.php';


    // Ici je recupere le montant

    $montantTotal = floatval($_GET['m']) * 100;
    

if (isset($_GET['p']) AND isset($_GET['m'])) {
    

    function req_paiement($montantPaye)
    {

        /*Info given by MIPS - Do not Change*/
        $id_merchant = ' ';  
        $id_entity = '';    
        $operator_id = '';  
        $remote_user_password = ''; 




        /*Info given by MIPS - Do not Change*/
        //merchant credentials 

        $auth_username = "";  //value set for merchant
        $auth_password = '';  //value set for merchant


        /*Info given by MIPS - Do not Change*/

        //$order_id = '';                       // set order_id from cart
        // $order_id = 'order_'.rand(0,9999);


        // Ici je recupere la reference

        $order_id = nettoyage($_GET['r']);

        
        $URL_REDIRECTION ='www.mypuffbabi.com'; // Votre URL de redirection DYNAMIQUE ICI';  

        $currency='XOF';                        //currency

        //load iframe html
        $complete_array_message = [
				"authentify"=>[
					"id_merchant" 		=> $id_merchant,
					"id_entity" 		=> $id_entity,
					"id_operator" 		=> $operator_id,
					"operator_password" => $remote_user_password
				],
				"order"=>[
					"id_order" => $order_id,
					"currency" => $currency,
					"amount"   => $montantTotal
				],
				"iframe_behavior"=>[
					"height" => 600,
					"width" => 350,
					"custom_redirection_url"   => $URL_REDIRECTION,
					"language" => "FR"
				],
				"request_mode"=> "simple",
				"touchpoint"=> "web",
		];

        $complete_message_json = json_encode($complete_array_message);


        //$api_url = 'https://api.mips.mu/qp_api/qp_api.php';
        $api_url = 'https://api.mips.mu/api/load_payment_zone';

        $curl = curl_init();
        $curl_opt = [
            CURLOPT_URL             => $api_url,
            CURLOPT_USERAGENT       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36',
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_FOLLOWLOCATION  => false,
            CURLOPT_FORBID_REUSE    => true,
            CURLOPT_FRESH_CONNECT   => true,
            CURLOPT_VERBOSE         => 1,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => $complete_message_json,
            CURLOPT_HTTPHEADER      => [
                'Authorization: Basic ' . base64_encode($auth_username.":".$auth_password),
                'Cache-Control: no-cache'
            ]
        ];
        curl_setopt_array($curl,$curl_opt);
        $response = curl_exec($curl);

        // var_dump($response);

        $response_decoded = json_decode($response,true);

        return $response_decoded['answer']['payment_zone_data'];

    }


    echo req_paiement($montantTotal);


}
else
{
}

?>


