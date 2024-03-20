
<section>


    <h1 style="padding:20px; text-align:center">Finalisez votre paiement</h1>

</section>



<?php
// exit();

    $montantTotal = floatval($_GET['m']) * 100;
    

if (isset($_GET['p']) AND isset($_GET['m'])) {
    

    function req_paiement($montantPaye)
    {

        /*Info given by MIPS - Do not Change*/
        $id_merchant = ' ';  
        $id_entity = '';    
        $operator_id = '';  
        $remote_user_password = ''; 


        $id_merchant = 'rfevVOeldVrg2xG3sS1tETF6swX5OIe1';
        $id_entity = '5Gfu3zPzcjT0LolPofcrvhQCXE7fLS5i';
        $operator_id = 'MXmJPZ7mhe3SvW1tN4nPToUJ7HX8Qmv1';
        $remote_user_password = 'mzQ62v0x45oOo0H0GNNtbIbKNWuEcRWV';


        /*Info given by MIPS - Do not Change*/
        //merchant credentials 

        $auth_username = "my_puff_U3e2c9";  //value set for merchant
        $auth_password = 'yY4F_ThX:6kq';  //value set for merchant


        /*Info given by MIPS - Do not Change*/

        //$order_id = '';                       // set order_id from cart
        // $order_id = 'order_'.rand(0,9999);
        $order_id = $_GET['r'];

        $currency='XOF';						//currency

        //load iframe html
        $complete_array_message = [
            'id_merchant' => $id_merchant,
            'id_entity' => $id_entity,
            'operator_email' => '',
            'operator_id' => $operator_id,
            'remote_user_password' => $remote_user_password,
            'message' =>[
                'operation' => 'load_iframe',
                'order_id' => $order_id, //your order id
                'amount' => $montantPaye,  // value in cents
                'currency' => $currency,
                'width' => '100%',
                'height' => '600',
            ]
        ];



        $complete_array_message = json_encode($complete_array_message);


        $api_url = 'https://api.mips.mu/qp_api/qp_api.php';


        $curl = curl_init();
        $curl_opt = [
            CURLOPT_URL 			=> $api_url,
            CURLOPT_USERAGENT 		=> 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36',
            CURLOPT_RETURNTRANSFER 	=> 1,
            CURLOPT_FOLLOWLOCATION 	=> false,
            CURLOPT_FORBID_REUSE 	=> true,
            CURLOPT_FRESH_CONNECT 	=> true,
            CURLOPT_VERBOSE         => 1,
            CURLOPT_SSL_VERIFYPEER 	=> false,
            CURLOPT_POST 			=> true,
            CURLOPT_POSTFIELDS 		=> 'posted_data='.$complete_array_message,
            CURLOPT_HTTPHEADER 		=> [
                'Authorization: Basic ' . base64_encode($auth_username.":".$auth_password),
                'Cache-Control: no-cache'
            ]
        ];
        curl_setopt_array($curl,$curl_opt);
        $response = curl_exec($curl);

        // var_dump($response);

        $response_decoded = json_decode($response,true);

        return $response_decoded['answer']['payment_iframe'];

    }


    echo req_paiement($montantTotal);


}
else
{
}

?>


