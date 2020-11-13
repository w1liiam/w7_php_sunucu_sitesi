<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {
	private $user = array();
	public function __construct() {
		parent::__construct();
		$this->load->model('Panel_Model');
		$this->load->model('Payment_Model');
		if($this->session->has_userdata('user')) {
			$this->user = $this->Panel_Model->getUserById($this->session->userdata('user'));
			if(!isset($this->user['id'])) {
				session_destroy();
				redirect(base_url('login'));
				exit;
			}
		}
		else {
			redirect(base_url('login'));
			exit;
		}
	}
	public function card()
	{
		if(!empty($this->input->post('amount')) && !empty($this->input->post('phone'))) {
			$order_id = $this->Payment_Model->insertPayment($this->user['id'], $this->input->post('amount'));
			$order_amount = floatval($this->input->post('amount')) + (floatval($this->input->post('amount'))/100)*floatval($this->config->item('payment_commission'));
			switch($this->config->item('payment_method')) {
				case 'shopier':
					require 'application/libraries/Shopier.php';
					$shopier = new Shopier($this->config->item('shopier_api_key'), $this->config->item('shopier_api_secret'), $this->config->item('shopier_site_index'));
					$shopier->setBuyer([
						'id' => $this->user['id'],
						'first_name' => explode(' ', $this->user['name'])[0],
						'last_name' => count(explode(' ', $this->user['name'])) > 1 ? explode(' ', $this->user['name'])[1] : 'A',
						'email' => $this->user['email'],
						'phone' => $this->input->post('phone')
					]);
					$shopier->setOrderBilling([
						'billing_address' => 'N/A - Dijital Ürün',
						'billing_city' => 'Istanbul',
						'billing_country' => 'Turkey',
						'billing_postcode' => '34200',
					]);
					$shopier->setOrderShipping([
						'shipping_address' => 'N/A - Dijital Ürün',
						'shipping_city' => 'Istanbul',
						'shipping_country' => 'Turkey',
						'shipping_postcode' => '34200',
					]);
					die($shopier->run($order_id, $order_amount, base_url('payment-card/callback')));
				break;
				case 'weepay':
					$weepayArray = array();
					
					$weepayArray['Aut'] = array(
							'bayi-id' => $this->config->item('weepay_seller_id'),
							'api-key' => $this->config->item('weepay_api_key'),
							'secret-key' => $this->config->item('weepay_secret_key')
					);
					$currency = 'TL';
					switch($this->config->item('site_money_sign')) {
						case '$':
							$currency = 'USD';
						break;
						case '€':
							$currency = 'EUR';
						break;
					}
					$weepayArray['Data'] = array(
							'CallBackUrl' => base_url('payment-card/callback'),
							'Price' => $order_amount,
							'Locale' => $this->config->item('site_lang'),
							'IpAddress' => $_SERVER['REMOTE_ADDR'],
							'CustomerNameSurname' => $this->user['name'],
							'CustomerPhone' => $this->input->post('phone'),
							'CustomerEmail' => $this->user['email'],
							'OutSourceID' => $order_id,
							'Description' => $this->config->item('site_name'),
							'Currency' => $currency,
							'Channel' => 'Module'
						);

					$endPointUrl = 'https://api.weepay.co/Payment/PaymentCheckoutFormCreate/';
					$payload = json_encode($weepayArray);
					$ch = curl_init($endPointUrl);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLINFO_HEADER_OUT, true);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Content-Length: ' . strlen($payload))
					);
					$response = json_decode(curl_exec($ch), true);
					curl_close($ch);
					if($response["status"] == "Success"): ?>
						<html>
						<head><title>Weepay Payment</title><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
						<body style="display:flex;align-items:center;justify-content:center;">
						<div>
						<div id='weePay-checkout-form' class='responsive'><?php echo $response['CheckoutFormData']; ?></div>
						</div>
						</body>
						</html>
					<?php endif; ?>
					<?php
				break;
			}
		}
	}
	public function card_callback() {
		switch($this->config->item('payment_method')) {
			case 'shopier':
				require 'application/libraries/Shopier.php';
				$shopier = new Shopier($this->config->item('shopier_api_key'), $this->config->item('shopier_api_secret'), $this->config->item('shopier_site_index'));
				if($shopier->verifyShopierSignature($_POST)) {
					$payment = $this->Payment_Model->getPendingPayment($this->input->post('platform_order_id'));					
					if(isset($payment['id'])) {
						$this->Payment_Model->confirmPayment($payment['id'], $payment['user'], $this->user['name'], $payment['amount']);
						redirect(base_url('add-balance?status=1'));
					}
					else {
						redirect(base_url('add-balance?status=2'));
					}
				}
				else {
					redirect(base_url('add-balance?status=2'));
				}
			break;
			case 'weepay':
				if($this->input->post("isSuccessful") == "True" && $this->input->post("secretKey") == $this->config->item("weepay_secret_key")) {
					$payment_id = $this->input->post("orderId");
					$weepayArray = array();
					$weepayArray['Aut'] = array(
						'bayi-id' => $this->config->item('weepay_seller_id'),
						'api-key' => $this->config->item('weepay_api_key'),
						'secret-key' => $this->config->item('weepay_secret_key')
					);
					$weepayArray['Data'] = array(
						'OrderID' => $this->input->post("paymentId")
					);
					$endPointUrl = "https://api.weepay.co/Payment/GetPaymentDetail";
	
					$payload = json_encode($weepayArray);
					$ch = curl_init($endPointUrl);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLINFO_HEADER_OUT, true);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Content-Length: ' . strlen($payload))
					);
					$response = json_decode(curl_exec($ch), true);
					curl_close($ch);
					if($response['Data']['PaymentDetail']['PaymentStatus'] == 2 && $response['Data']['PaymentDetail']['TrxStatus'] == 1) {
						$payment = $this->Payment_Model->getPendingPayment($payment_id);
						if(isset($payment['id'])) {
							$this->Payment_Model->confirmPayment($payment['id'], $payment['user'], $this->user['name'], $payment['amount']);
							redirect(base_url('add-balance?status=1'));
						}
						else {
							redirect(base_url('add-balance?status=2'));
						}
					}
					else {
						redirect(base_url('add-balance?status=2'));
					}
				}
				else {
					redirect(base_url('add-balance?status=2'));
				}
			break;
		}
	}
}
