<?php
use Coreproc\Dragonpay\DragonpayApi as Dragonpay;
//use Coreproc\Dragonpay\Checkout;
use Coreproc\Dragonpay\DragonpayClient;

class GettTestController extends BaseController {

	protected $pcmsClient;

	public function __construct()
	{
		if (strtolower(App::environment()) === 'production')
		{
			return Redirect::route('home');
		}

		$this->pcmsClient = App::make('pcms');
	}

	public function getTest()
    {
        echo "hi buddy";
        $config = array(
            'merchantId'        => 'TRUEMONEY',
            'merchantPassword'  => 'B4dPuYW2',
            'testing'           => true
        );
        $params = array(
            'transactionId' => Input::get('order_id'),
            'amount'        => '10000.00', // 2 digit after .
            'currency'      => 'PHP',
            'description'   => 'buy itm products',
            'email'         => 'igetter7@gmail.com'
        );
        $payment_channel = array(
            'online Banking' => 1,
            'Over-the-Counter Banking and ATM' => 2,
            'Over-the-Counter non-Bank' => 4,
            'PayPal' => 32,
            'Credit Cards' => 64,
            'Mobile (Gcash)' => 128
        );
        $dragon = new Dragonpay($config);
        $url = $dragon->getUrl($params);


//        $credentials = [
//            'merchantId'        => 'merchant-id',
//            'merchantPassword'  => 'merchant-password',
//        ];

//        $checkout = new Checkout();
//        $logging = true;
//        $logDirectory = 'logs';
//
//        $client = new DragonpayClient($credentials);
//        $client = new DragonpayClient($credentials, $logging, $logDirectory);

//        $checkout = new Checkout($client);
//        $checkout = new Checkout($client, 'SOAP');
//        $url = $checkout->getUrl($params);
//        $checkout->redirect($params);
//        sd($url);
        return Redirect::to($url);
    }

    function requestDragon($paid = true, $error ='',$payment_info)
    {
        if ($paid) {
            if ($error == '') {
                $amount = $payment_info['amount'];
                $ccy = 'currency';
                $description = $payment_info['description'];
                $email = $payment_info['email'];

                $txnid = $payment_info['order_id'];
                $merchant = 'TRUEMONEY';
                $passwd = 'B4dPuYW2';

                $digest_str = "$merchant:$txnid:$amount:$ccy:$description:$email:$passwd";
                $digest = sha1($digest_str);
                $params = "merchantid=" . urlencode($merchant) .
                    "&txnid=" .  urlencode($txnid) .
                    "&amount=" . urlencode($amount) .
                    "&ccy=" . urlencode($ccy) .
                    "&description=" . urlencode($description) .
                    "&email=" . urlencode($email) .
                    "&digest=" . urlencode($digest);
            }
            $url = 'http://test.dragonpay.ph/Pay.aspx';

            header("Location: $url?$params");
        }
    }

}