<?php

class WC_lpsapi_Payment_Gateway extends WC_Payment_Gateway{

		public function __construct(){
		$this->id = 'lps-api-gateway';
		$this->method_title = __('lpsapi','woocommerce-lpsapi-payment-gateway');
		$this->title = __('lps api gateway','woocommerce-lpsapi-payment-gateway');
		$this->has_fields = true;
		$this->init_form_fields();
		$this->init_settings();
		$this -> merchant_User_Id = $this -> settings['merchant_User_Id'];
		$this -> merchantpwd = $this -> settings['merchantpwd'];
		$this -> process_url_api = $this -> settings['process_url_api'];
		$this -> merchant_ipaddress = $this -> settings['merchant_ipaddress'];
		$this->enabled = $this->get_option('enabled');
		$this->title = $this->get_option('title');
		$this->description = $this->get_option('description');
		$this->icon = apply_filters( 'woocommerce_simplepay_icon', plugins_url( '/images/api-image.png' , __FILE__ ) );
		$this->msg['message'] = "";
		$this->msg['class'] = "";
		add_action('woocommerce_update_options_payment_gateways_'.$this->id, array($this, 'process_admin_options'));
	}

	// make administration field for this payment Gateway
	public function init_form_fields(){
					$this->form_fields = array(
					'enabled' => array(
					'title' 		=> __( 'Enable/Disable', 'woocommerce-lpsapi-payment-gateway' ),
					'type' 			=> 'checkbox',
					'label' 		=> __( 'Enable LPS Payment Gateway (API)', 'woocommerce-lpsapi-payment-gateway' ),
					'default' 		=> 'yes'
					),
					'title' => array(
					'title' 		=> __( 'Method Title', 'woocommerce-lpsapi-payment-gateway' ),
					'type' 			=> 'text',
					'description' 	=> __( 'This controls the title', 'woocommerce-lpsapi-payment-gateway' ),
					'default'		=> __( 'Custom Payment', 'woocommerce-lpsapi-payment-gateway' ),
					'desc_tip'		=> true,
					),
					'merchant_User_Id' => array(
					'title' 		=> __( 'Merchant Id', 'woocommerce-lpsapi-payment-gateway' ),
					'type' 			=> 'text',
					'description' 	=> __( 'This controls the title', 'woocommerce-lpsapi-payment-gateway' ),
					'default'		=> __( '', 'woocommerce-lpsapi-payment-gateway' ),
					'desc_tip'		=> true,
					),
					'merchantpwd' => array(
					'title' 		=> __( 'Merchantpwd', 'woocommerce-lpsapi-payment-gateway' ),
					'type' 			=> 'text',
					'description' 	=> __( 'This controls the title', 'woocommerce-lpsapi-payment-gateway' ),
					'default'		=> __( ' ', 'woocommerce-lpsapi-payment-gateway' ),
					'desc_tip'		=> true,
					),	
					'process_url_api' => array(
					'title' 		=> __( 'Process url', 'woocommerce-lpsapi-payment-gateway' ),
					'type' 			=> 'text',
					'description' 	=> __( 'This controls the title', 'woocommerce-lpsapi-payment-gateway' ),
					'default'		=> __( ' ', 'woocommerce-lpsapi-payment-gateway' ),
						 
					),	
								 
					'merchant_ipaddress' => array(
					'title' 		=> __( 'Merchant ipaddress', 'woocommerce-lpsapi-payment-gateway' ),
					'type' 			=> 'text',
					'description' 	=> __( 'This controls the title', 'woocommerce-lpsapi-payment-gateway' ),
					'default'		=> __( ' ', 'woocommerce-lpsapi-payment-gateway' ),
					'desc_tip'		=> true,
					)
					);
	}
       public function admin_options(){
        echo '<h3>'.__('LPS API Payment Gateway', 'woocommerce-lpsapi-payment-gateway').'</h3>';
        echo '<p>'.__('LPS is most popular payment gateway for online shopping').'</p>';
        echo '<table class="form-table">';
        // Generate the HTML For the settings form.
        $this -> generate_settings_html();
        echo '</table>';

    }
	public function payment_fields(){
		?>
			<style type="text/css">
			.api-container{width:100%!important;}
			.api-cvv{    width: 30%!important;   float: left;  margin-right: 19px;}
			.customer_cc_expyr {width: 100%!important;    height: 32px;}
			.customer_firstname{width: 100%!important;}
			.customer_cc_cvc {width: 100%!important;}
			.customer_cc_expmo  {width: 100%!important;   height: 33px!important;}
			.customer_cc_number{width: 100%!important;}
			.api-month{width: 30%!important;   float: left;margin-right: 9px;}
			.api-year{    width: 33%!important;    float: left;    left: 8px;    position: relative;     }
			.api-cvvcon{width:100%;!important;}
			.api-cardtype{top: 38px;   position: relative;   clear: both;	}
			.logolpsapi{left:-18px;}
			 </style>
		<div class="api-container">
		
		<fieldset>
			<div class="api-cardtype">
				 
				<label>Card Type</label><br>
				 <input id="customer_cc_type" class="customer_cc_type" name="customer_cc_type" type="radio" value="VISA" checked="checked"/><img src="<?PHP echo plugins_url('images/visa.png', __FILE__);?>" class="logolpsapi"height="42" width="42"/>
				<input  id="customer_cc_type" class="customer_cc_type" name="customer_cc_type" type="radio" value="MASTER" /><img src="<?PHP echo plugins_url('images/mastro.png', __FILE__);?>" class="logolpsapi" height="42" width="42"/>
				 
				</div><br><br>
			<p class="form-row form-row-wide">
			<div class="api-name">
				<label>Card Holder Name</label><br>
				<input id="customer_firstname " class="customer_firstname" type="text" name="customer_firstname" value="" ></input>
				</div>
				<div class="api-name">
				<label>Card Number</label><br>
				<input id="customer_cc_number "  class="customer_cc_number" type="text" name="customer_cc_number" value="" ></input>
				</div>
				<div class="api-cvvcon">
				<div class="api-cvv">
				<label>CVV</label><br>
				<input id="customer_cc_cvc " class="customer_cc_cvc" type="text" name="customer_cc_cvc" value=""></input>
				</div>
				<div class="api-month">
				<label>Expiry Month</label><br>
				<select id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="" >
									<option  id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="">--Select Month--</option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="01"  >January </option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="02"  >February</option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="03" >March</option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="04" >April</option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="05" >May</option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="06" >June</option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="07" >July</option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="08" >August </option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="09" >September</option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="10" >October</option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="11" >November</option>
									<option id="customer_cc_expmo " class="customer_cc_expmo" type="text" name="customer_cc_expmo" value="12" >December</option>
			</select>
				</div>
				<div class="api-year">
				<label>Expiry Year</label><br>
<?php
 $already_selected_value = 2016;
$earliest_year = 2031;
print '<select id="customer_cc_expyr " class="customer_cc_expyr" type="text" name="customer_cc_expyr" >';
foreach (range(date('Y'), $earliest_year+1) as $x) {
    print '<option   value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
}
print '</select>';
  ?>
				</div>
				</div>
				
				</p>						
				<div class="clear"></div>
				</fieldset>
			</div>
		
		<?php
	}

	// handel payment process
	public function process_payment( $order_id ) {
	 
		global $woocommerce;
		$order =  new WC_Order( $order_id );
		$merchant_ref_number = trim($order_id);
		 $customer_cc_number_api=$_POST['customer_cc_number'];
		$customer_cc_cvc_api=$_POST['customer_cc_cvc'];
		$customer_cc_expmo_api=$_POST['customer_cc_expmo'];
		$customer_cc_expyr_api=$_POST['customer_cc_expyr'];
		$customer_cc_type_api=$_POST['customer_cc_type'];
		$process_url_api= $this ->process_url_api;
		$merchant_ipaddress= $this ->merchant_ipaddress;
		$payload	 = array(
         'merchant_User_Id' =>$this ->merchant_User_Id,
         'merchantpwd' => $this ->merchantpwd,
         'merchant_ipaddress' =>$merchant_ipaddress,
		 'customer_firstname' => $order -> billing_first_name,
         'customer_lastname' => $order -> billing_last_name,
         'customer_phone' => $order -> billing_phone,
         'customer_email' => $order -> billing_email, 
		'customer_ipaddress' =>$_SERVER['REMOTE_ADDR'],  
     //  'customer_ipaddress' =>'1.1.1.1',   test usage
         'merchant_ref_number' =>$merchant_ref_number,
		 'bill_firstname' => $order -> billing_first_name,
         'bill_lastname' => $order -> billing_last_name,
         'bill_address1' => $order -> billing_address_1,
         'bill_city' => $order -> billing_city,
         'bill_country' => $order -> billing_country,
         'bill_zip' => $order -> billing_postcode,
		 'customer_cc_number' =>$customer_cc_number_api,
		 'customer_cc_expmo' =>$customer_cc_expmo_api,
		 'customer_cc_expyr' =>$customer_cc_expyr_api,
		 'customer_cc_cvc' =>$customer_cc_cvc_api,
		 'customer_cc_type' =>$customer_cc_type_api,
		 'amount' => $order -> order_total,
		 'currencydesc' =>$order->order_currency
                );
     
         
 $response = wp_remote_post( $process_url_api, 
        $params=array(
            'method'    => 'POST',
            'body'      => http_build_query( $payload ),
            'timeout'   => 90,
            'sslverify' => false
			
        ) 
    ); 
	$bank_res = trim(wp_remote_retrieve_body( $response ));
	 
 $classes = explode("&",$bank_res);
	    $arrlength=count($classes);
		  for($x=0;$x<$arrlength;$x++)
   {
	     echo $classes[$x];
   echo "<br>";
   $iparr4 = explode("=", $classes[$x]);
  $iparr4[0];
   
  $iparr4[1];
    
 if ($iparr4[0] == "ResponseType"){
	   $ResponseType=$iparr4[1];
	   
	    
	   
   }
   elseif ($iparr4[0] == "LPS_transaction_id"){

	   $LPS_transaction_id=$iparr4[1];
	   	 
	   
   }elseif ($iparr4[0] == "Lpsid"){
	   $Lpsid=$iparr4[1];
	     	    
	    
	   
   }elseif ($iparr4[0] == "Lpspwd"){
	   $Lpspwd=$iparr4[1];
	   
	    
	   
   }elseif ($iparr4[0] == "Fraudscreening_status"){
	   $Fraudscreening_status=$iparr4[1];
	   
	    
	   
   } elseif ($iparr4[0] == "Bank_status"){
	   $Bank_status=$iparr4[1];
	   
	   
	    
	   
   }
    elseif($iparr4[0] == "Amount"){
	$Amount=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "Currency"){
	$Currency=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "Bank_transaction_no"){
	$Bank_transaction_no=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "Bank_authorisation_no"){
	$Bank_authorisation_no=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "bank_code"){
	$bank_code=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "Bank_date"){
	$Bank_date=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "Bank_time"){
	$Bank_time=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "Bank_original_code"){
	$Bank_original_code=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "ZIP_Result"){
	$ZIP_Result=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "CardBin"){
	$CardBin=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "CardLast4"){
	$CardLast4=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "BankIdentifier"){
	$BankIdentifier=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "bank_code"){
	$bank_code=$iparr4[1];
	   
	    
   }elseif($iparr4[0] == "bank_message"){
	$bank_message=$iparr4[1];
	   
	    
   } elseif($iparr4[0] == "Merchant_ref_number"){
	$Merchant_ref_number=$iparr4[1];
	   
	    
   }
   
		} 
	
		     if ($Fraudscreening_status=='0' ) {
		     if ($Bank_status=='00' ) {
					global $woocommerce;
					$order = new WC_Order($order_id);
					try {
					throw new Exception( __( 'Order completed . It will be shipped very soon.', 'woocommerce-lpsapi-payment-gateway' ) );
					} catch ( Exception $e ) {
					$this->msg['message'] = "You have successfully paid for your order. It will be shipped very soon.";
					$this->msg['class'] = 'woocommerce_message';
					$order-> payment_complete();
					$order-> add_order_note('Payment succeded');
					$order-> add_order_note($this->msg['message']);
					wc_add_notice( $e->getMessage(), 'error' );
					$order->update_status( 'completed', $e->getMessage() );
					$woocommerce->cart->empty_cart();  
					return array(
					'result'   => 'success',
					 'redirect' => $this->get_return_url( $order )
			);
}
}
elseif($Bank_status=='05'){
					global $woocommerce;
					$order = new WC_Order($order_id);
  					try {
					throw new Exception( __( 'Rejected by bank please provide correct card details', 'woocommerce-lpsapi-payment-gateway' ) );
					} catch ( Exception $e ) {
					$this->msg['message'] = "Rejected by bank";
                    $this->msg['class'] = 'woocommerce_message';
                    $order->update_status('failed');
                    $order-> add_order_note('Payment failed');
                    $order-> add_order_note($this->msg['message']);
					wc_add_notice( $e->getMessage(), 'error' );
					$order->update_status( 'failed', $e->getMessage() );
					$woocommerce->cart->empty_cart(true);  
	 
					return array(
					'result' => 'success',
					'redirect' => $this->get_return_url( $order )
	);
 }
}
 elseif($Bank_status=='90'){
					global $woocommerce;
					$order = new WC_Order($order_id);
  					try {
					throw new Exception( __( 'Communication Failure. Please contact LPS', 'woocommerce-lpsapi-payment-gateway' ) );
					} catch ( Exception $e ) {
					$this->msg['message'] = "Communication Failure. Please contact LPS";
                    $this->msg['class'] = 'woocommerce_message';
                    $order->update_status('failed');
                    $order-> add_order_note('Payment failed');
                    $order-> add_order_note($this->msg['message']);
					wc_add_notice( $e->getMessage(), 'error' );
					$order->update_status( 'failed', $e->getMessage() );
					$woocommerce->cart->empty_cart(true);  
	 
					return array(
					'result' => 'success',
					'redirect' => $this->get_return_url( $order )
	);
 }
 }
}

	if ($Fraudscreening_status!='0' ) {
		  if($Bank_status==''){
					global $woocommerce;
					$order = new WC_Order($order_id);
  					try {
					throw new Exception( __( 'Your order cancelled', 'woocommerce-lpsapi-payment-gateway' ) );
					} catch ( Exception $e ) {
					$this->msg['message'] = "Your order cancelled";
                    $this->msg['class'] = 'woocommerce_message';
                    $order->update_status('cancelled');
                    $order-> add_order_note('Payment cancelled');
                    $order-> add_order_note($this->msg['message']);
					wc_add_notice( $e->getMessage(), 'error' );
					$order->update_status( 'cancelled', $e->getMessage() );
					$woocommerce->cart->empty_cart();  
 
					return array(
					'result' => 'success',
					'redirect' => $this->get_return_url( $order )
	);
 }
		  }

 elseif($Bank_status=='90'){
					global $woocommerce;
					$order = new WC_Order($order_id);
  					try {
					throw new Exception( __( 'Communication Failure. Please contact LPS', 'woocommerce-lpsapi-payment-gateway' ) );
					} catch ( Exception $e ) {
					$this->msg['message'] = "Communication Failure. Please contact LPS";
                    $this->msg['class'] = 'woocommerce_message';
                    $order->update_status('failed');
                    $order-> add_order_note('Payment failed');
                    $order-> add_order_note($this->msg['message']);
					wc_add_notice( $e->getMessage(), 'error' );
					$order->update_status( 'failed', $e->getMessage() );
					$woocommerce->cart->empty_cart(true);  
 
					return array(
					'result' => 'success',
					'redirect' => $this->get_return_url( $order )
	);
 }
 }
}
}
 
 
}  
