<?php
	
	// get admin setting data

    $jms_select_sql = "SELECT * FROM `setting`";
    $jms_select_data = $jms_pdo->prepare($jms_select_sql);
    $jms_select_data->execute();
    $jms_row = $jms_select_data->fetchAll(PDO::FETCH_ASSOC);

    $jms_deal_evalution_price = isset($jms_row[0]['jms_deal_evalution_price']) ? $jms_row[0]['jms_deal_evalution_price'] : 0;
    $jms_buy_and_hold_analysis_price = isset($jms_row[0]['jms_buy_and_hold_analysis_price']) ? $jms_row[0]['jms_buy_and_hold_analysis_price'] : 0;


	/* url*/

		// url path
		$jms_token_url_path = "http://localhost/buy-and-hold-calculator/site";

		// sender address
		$jms_sender_from_address = "info@jmswebsolution.com";
		
		// sender name
		$jms_sender_from_name = "Buy and Hold";

	/* Google Recaptcha keys*/

		// site key
		$jms_captcha_site_key = "6LdM75QpAAAAAFlRofphJZgugZHL_yIUJ0qfUtLL";
		
		// secrete key
		$jms_captcha_secrete_key = "6LdM75QpAAAAAON_tmkrcKt3ZR4PyKD_4NKMUhd-";

	/* Stripe Payment keys */

		// Secret key
		$jms_stripe_secret_key = "sk_test_51OY4u8DTqe3AeBX59nNQyQ34nLpB9exWQwpNhVwPvDRX0LrCVIVh2IYyTa3yq0wZxg3uvY8St70kLgQNb7yea6qy00dtHL2utL";

		// Publishable key
		$jms_stripe_publishable_key = "pk_test_51OY4u8DTqe3AeBX5Jeppbo6gzjveGlrW4GOmjZjsAKtUKbdZ6a4vJNCPbOBsBMTcvoDNMlt5bDUhogELNYeZGm1H00XpqfMhsJ";

	/* Paypal Payment keys */

		// Client ID
		$jms_paypal_client_id = "Abv95j9htM5lackVg_ZZUA_DXXu3v6VP5La3n7Ds1uMf3E0n5d9rAzrHwWPaeSryFbqxJFbbCZI7_CAH";

		// Secret Keys
		$jms_paypal_secret_key = "EOQv5xr9yQWVQlDsOVVD5RxHyhFl6016gBCg8Qq_7ak4ShJYkm0KZ257VW7W4TdE4i78YuO8lUPrk-z2";

	/* payment page cards price and save variable */

		/* Access All Calculator */
			$jms_access_all_calculator_price = 25;//$jms_access_all_calculator_price;
			$jms_access_all_calculator_save = 250;//$jms_access_all_calculator_save_no;

		/* Deal Evalution unlimited */
			$jms_deal_evalution_unlimited_price = 30;

		/* Deal Evalution save */
			$jms_deal_evalution_save_price = $jms_deal_evalution_price;
			$jms_deal_evalution_save_no = 1;

		/* Buy and Hold Analysis unlimited */
			$jms_buy_and_hold_analysis_unlimited_price = 15.99;//$jms_buy_and_hold_analysis_unl_price;

		/* Buy and Hold Analysis save */
			$jms_buy_and_hold_analysis_price = $jms_buy_and_hold_analysis_price;
			$jms_buy_and_hold_analysis_no = 1;


	/* Paypal product id */

		/* Access All Calculator (price 25) */
			$JMS_PLAN_ID_ACCESS_ALL_CALCULATOR = "P-9RU0020404868402LM2JGIFA";

		/* Deal Evalution Unlimited Save (price 30) */ 
			$JMS_PLAN_ID_DEAL_EVALUATION_UNLIMITED = "P-60U527625R324090BM2JGJZY";

		/* Buy and Hold Analysis Save (price 15.99) */
			$JMS_PLAN_ID_BUY_AND_HOLD_ANALYSIS = "P-2PG74426H9814562UM2JGKSY";

	/* stripe product id */

		/* Access All Calculator (price 25)*/
			$JMS_PRODUCT_ID_ACCESS_ALL_CALCULATOR = "price_1Pc58QDTqe3AeBX5JS2h2nWU";

		/* Deal Evalution Unlimited Save (price 30)*/
			$JMS_PRODUCT_ID_DEAL_EVALUATION_UNLIMITED = "price_1Pc58pDTqe3AeBX5q0AaPGor";

		/* Buy and Hold Analysis Save (price 15.99) */
			$JMS_PRODUCT_ID_BUY_AND_HOLD_ANALYSIS = "price_1Pc59CDTqe3AeBX5bhcGHz9m";


	// sandbox changes file name

	// path -> user_data_file/get_data_paypal_stripe_api.php 
			// line no 27
			// line no 72

?>