-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2024 at 01:41 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_buy_and_hold_calculator_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `jms_first_name` varchar(255) NOT NULL,
  `jms_last_name` varchar(255) NOT NULL,
  `jms_email_id` varchar(255) NOT NULL,
  `jms_password` varchar(255) NOT NULL,
  `jms_verify_token` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `jms_first_name`, `jms_last_name`, `jms_email_id`, `jms_password`, `jms_verify_token`, `created_on`, `updated_on`) VALUES
(1, 'nitin', 'bhattasaniya', 'nitin@jmswebsolution.com', 'eaf729f3c3e90f572348deadad20f094', 'ba45c6bb0b4e9ae482a19a93d0bb7542', '2024-04-22 22:10:38', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `buy-and-hold-analysis-calc`
--

CREATE TABLE `buy-and-hold-analysis-calc` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `calc_data_records` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cancel_subscription`
--

CREATE TABLE `cancel_subscription` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `method` text NOT NULL,
  `purchase` varchar(255) NOT NULL,
  `subscription_id` varchar(255) NOT NULL,
  `nextbilling_date` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cancel_subscription`
--

INSERT INTO `cancel_subscription` (`id`, `users_id`, `method`, `purchase`, `subscription_id`, `nextbilling_date`, `created_on`, `updated_on`) VALUES
(1, 2, 'paypal', 'deal-evalution', 'I-LDSFA1KAG6PN', '07-10-2024', '2024-09-07 12:02:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deal-evaluation-calc`
--

CREATE TABLE `deal-evaluation-calc` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `calc_data_records` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deal-evaluation-calc`
--

INSERT INTO `deal-evaluation-calc` (`id`, `users_id`, `calc_data_records`, `created_on`, `updated_on`) VALUES
(1, 2, '{\"jms_name\":\"nitiin nnnnn\",\"jms_date\":\"2024-09-12\",\"jms_property_cost\":\"5\",\"jms_down_payment\":\"0\",\"jms_down_payment_percentage\":\"5\",\"jms_residential_appraisal\":\"5\",\"jms_inspection\":\"5\",\"jms_closing_percentage\":\"5\",\"jms_annual_interest_rate\":\"5\",\"jms_number_of_years\":\"5\",\"jms_card_annual_apr\":\"5\",\"jms_repairs_annually\":\"5\",\"jms_utilities\":\"5\",\"jms_home_warranty\":\"5\",\"jms_trash_removal\":\"5\",\"jms_landscaping\":\"5\",\"jms_property_management\":\"5\",\"jms_property_taxes\":\"5\",\"jms_home_owners_insurance\":\"5\",\"jms_cap_ex\":\"5\",\"jms_total_units\":\"5\",\"jms_rent_per_unit\":\"5\",\"jms_pets\":\"5\",\"jms_parking\":\"5\",\"jms_laundry\":\"5\",\"jms_storage\":\"5\",\"jms_alarm_systems\":\"5\",\"jms_new_property_appraisal_price\":\"5\",\"jms_ltv_ratio_percentage\":\"5\",\"jms_mortgage_annual_interest_rate\":\"5\",\"jms_mortgage_number_of_years\":\"5\",\"jms_closing_cost_per\":\"5\"}', '2024-09-07 11:43:31', NULL),
(2, 2, '{\"jms_name\":\"1\",\"jms_date\":\"2024-09-24\",\"jms_property_cost\":\"5\",\"jms_down_payment\":\"0\",\"jms_down_payment_percentage\":\"5\",\"jms_residential_appraisal\":\"5\",\"jms_inspection\":\"5\",\"jms_closing_percentage\":\"5\",\"jms_annual_interest_rate\":\"5\",\"jms_number_of_years\":\"5\",\"jms_card_annual_apr\":\"5\",\"jms_repairs_annually\":\"5\",\"jms_utilities\":\"5\",\"jms_home_warranty\":\"5\",\"jms_trash_removal\":\"5\",\"jms_landscaping\":\"5\",\"jms_property_management\":\"5\",\"jms_property_taxes\":\"5\",\"jms_home_owners_insurance\":\"5\",\"jms_cap_ex\":\"5\",\"jms_total_units\":\"5\",\"jms_rent_per_unit\":\"5\",\"jms_pets\":\"5\",\"jms_parking\":\"5\",\"jms_laundry\":\"5\",\"jms_storage\":\"5\",\"jms_alarm_systems\":\"5\",\"jms_new_property_appraisal_price\":\"5\",\"jms_ltv_ratio_percentage\":\"5\",\"jms_mortgage_annual_interest_rate\":\"5\",\"jms_mortgage_number_of_years\":\"5\",\"jms_closing_cost_per\":\"5\"}', '2024-09-07 11:43:54', NULL),
(3, 1, '{\"jms_name\":\"nitiin nnnnn\",\"jms_date\":\"2024-09-10\",\"jms_property_cost\":\"5\",\"jms_down_payment\":\"0\",\"jms_down_payment_percentage\":\"5\",\"jms_residential_appraisal\":\"5\",\"jms_inspection\":\"5\",\"jms_closing_percentage\":\"5\",\"jms_annual_interest_rate\":\"5\",\"jms_number_of_years\":\"5\",\"jms_card_annual_apr\":\"5\",\"jms_repairs_annually\":\"5\",\"jms_utilities\":\"5\",\"jms_home_warranty\":\"5\",\"jms_trash_removal\":\"5\",\"jms_landscaping\":\"5\",\"jms_property_management\":\"5\",\"jms_property_taxes\":\"5\",\"jms_home_owners_insurance\":\"5\",\"jms_cap_ex\":\"5\",\"jms_total_units\":\"5\",\"jms_rent_per_unit\":\"5\",\"jms_pets\":\"5\",\"jms_parking\":\"5\",\"jms_laundry\":\"5\",\"jms_storage\":\"5\",\"jms_alarm_systems\":\"5\",\"jms_new_property_appraisal_price\":\"5\",\"jms_ltv_ratio_percentage\":\"5\",\"jms_mortgage_annual_interest_rate\":\"5\",\"jms_mortgage_number_of_years\":\"5\",\"jms_closing_cost_per\":\"5\"}', '2024-09-07 11:45:32', NULL),
(4, 2, '{\"jms_name\":\"nitiin nnnnn\",\"jms_date\":\"2024-09-11\",\"jms_property_cost\":\"454\",\"jms_down_payment\":\"23\",\"jms_down_payment_percentage\":\"5\",\"jms_residential_appraisal\":\"5\",\"jms_inspection\":\"5\",\"jms_closing_percentage\":\"5\",\"jms_annual_interest_rate\":\"5\",\"jms_number_of_years\":\"5\",\"jms_card_annual_apr\":\"5\",\"jms_repairs_annually\":\"5\",\"jms_utilities\":\"5\",\"jms_home_warranty\":\"5\",\"jms_trash_removal\":\"5\",\"jms_landscaping\":\"5\",\"jms_property_management\":\"5\",\"jms_property_taxes\":\"0\",\"jms_home_owners_insurance\":\"5\",\"jms_cap_ex\":\"5\",\"jms_total_units\":\"5\",\"jms_rent_per_unit\":\"5\",\"jms_pets\":\"5\",\"jms_parking\":\"5\",\"jms_laundry\":\"5\",\"jms_storage\":\"5\",\"jms_alarm_systems\":\"5\",\"jms_new_property_appraisal_price\":\"5\",\"jms_ltv_ratio_percentage\":\"5\",\"jms_mortgage_annual_interest_rate\":\"5\",\"jms_mortgage_number_of_years\":\"5\",\"jms_closing_cost_per\":\"5\"}', '2024-09-07 11:57:22', NULL),
(5, 2, '{\"jms_name\":\"1\",\"jms_date\":\"2024-09-19\",\"jms_property_cost\":\"2\",\"jms_down_payment\":\"0\",\"jms_down_payment_percentage\":\"2\",\"jms_residential_appraisal\":\"2\",\"jms_inspection\":\"2\",\"jms_closing_percentage\":\"5\",\"jms_annual_interest_rate\":\"2\",\"jms_number_of_years\":\"2\",\"jms_card_annual_apr\":\"2\",\"jms_repairs_annually\":\"2\",\"jms_utilities\":\"2\",\"jms_home_warranty\":\"2\",\"jms_trash_removal\":\"0\",\"jms_landscaping\":\"2\",\"jms_property_management\":\"2\",\"jms_property_taxes\":\"2\",\"jms_home_owners_insurance\":\"2\",\"jms_cap_ex\":\"2\",\"jms_total_units\":\"2\",\"jms_rent_per_unit\":\"2\",\"jms_pets\":\"2\",\"jms_parking\":\"2\",\"jms_laundry\":\"2\",\"jms_storage\":\"2\",\"jms_alarm_systems\":\"2\",\"jms_new_property_appraisal_price\":\"2\",\"jms_ltv_ratio_percentage\":\"2\",\"jms_mortgage_annual_interest_rate\":\"2\",\"jms_mortgage_number_of_years\":\"2\",\"jms_closing_cost_per\":\"2\"}', '2024-09-07 11:59:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paypal_payments_purchase`
--

CREATE TABLE `paypal_payments_purchase` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `transation_id` varchar(255) NOT NULL,
  `save_num` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `purchase` text NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paypal_payments_subscription`
--

CREATE TABLE `paypal_payments_subscription` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `purchase` text NOT NULL,
  `is_subscription` varchar(255) NOT NULL,
  `jms_paypal_customer_id` varchar(255) NOT NULL,
  `jms_paypal_email_id` varchar(255) NOT NULL,
  `jms_paypal_name` varchar(255) NOT NULL,
  `jms_paypal_status` varchar(255) NOT NULL,
  `jms_paypal_starts_date` varchar(255) NOT NULL,
  `jms_paypal_subscriptionid` varchar(255) NOT NULL,
  `jms_paypal_orderid` varchar(255) NOT NULL,
  `jms_paypal_plan_id` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paypal_payments_subscription`
--

INSERT INTO `paypal_payments_subscription` (`id`, `users_id`, `purchase`, `is_subscription`, `jms_paypal_customer_id`, `jms_paypal_email_id`, `jms_paypal_name`, `jms_paypal_status`, `jms_paypal_starts_date`, `jms_paypal_subscriptionid`, `jms_paypal_orderid`, `jms_paypal_plan_id`, `created_on`, `updated_on`) VALUES
(1, 1, 'deal-evalution', 'y', '5PQ22RAYVRLQ6', 'sb-8oaok29072089@personal.example.com', 'John Doe', 'ACTIVE', '2024-09-07T05:28:52Z', 'I-1WYVSL0JRR5D', '18T06490B84357906', 'P-60U527625R324090BM2JGJZY', '2024-09-07 10:58:53', NULL),
(2, 2, 'deal-evalution', 'n', '5PQ22RAYVRLQ6', 'sb-8oaok29072089@personal.example.com', 'John Doe', 'CANCELLED', '2024-09-07T06:31:59Z', 'I-LDSFA1KAG6PN', '5B2057118M7988317', 'P-60U527625R324090BM2JGJZY', '2024-09-07 12:02:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `jms_deal_evalution_price` double NOT NULL,
  `jms_buy_and_hold_analysis_price` double NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `admin_id`, `jms_deal_evalution_price`, `jms_buy_and_hold_analysis_price`, `created_on`, `updated_on`) VALUES
(1, 1, 5.99, 3.99, '2024-07-19 12:26:36', '2024-07-24 13:19:33');

-- --------------------------------------------------------

--
-- Table structure for table `stripe_payments_purchase`
--

CREATE TABLE `stripe_payments_purchase` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `transation_id` varchar(255) NOT NULL,
  `save_num` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `purchase` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stripe_payments_purchase`
--

INSERT INTO `stripe_payments_purchase` (`id`, `users_id`, `transation_id`, `save_num`, `amount`, `status`, `purchase`, `created_on`, `updated_on`) VALUES
(1, 2, 'ch_3PwHtMDTqe3AeBX530Mhk4xl', 0, '$11.98', 'succeeded', 'deal-evalution', '2024-09-07 11:43:04', NULL),
(2, 2, 'ch_3PwI6JDTqe3AeBX53MFq4ZV3', 0, '$5.99', 'succeeded', 'deal-evalution', '2024-09-07 11:56:27', NULL),
(3, 2, 'ch_3PwI97DTqe3AeBX52u7XvfXt', 0, '$5.99', 'succeeded', 'deal-evalution', '2024-09-07 11:59:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stripe_payments_subscription`
--

CREATE TABLE `stripe_payments_subscription` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `purchase` text NOT NULL,
  `is_subscription` text NOT NULL,
  `jms_stripe_customer_id` varchar(255) NOT NULL,
  `jms_stripe_email_id` varchar(255) NOT NULL,
  `jms_stripe_name` varchar(255) NOT NULL,
  `jms_stripe_status` varchar(255) NOT NULL,
  `jms_stripe_starts_data` varchar(255) NOT NULL,
  `jms_stripe_subscription_id` varchar(255) NOT NULL,
  `jms_stripe_plan_id` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stripe_payments_subscription`
--

INSERT INTO `stripe_payments_subscription` (`id`, `users_id`, `purchase`, `is_subscription`, `jms_stripe_customer_id`, `jms_stripe_email_id`, `jms_stripe_name`, `jms_stripe_status`, `jms_stripe_starts_data`, `jms_stripe_subscription_id`, `jms_stripe_plan_id`, `created_on`, `updated_on`) VALUES
(1, 3, 'deal-evalution', 'n', 'cus_QnuHmOYCXJZjyR', 'ntn@gmail.com', 'ntn', 'canceled', '2024-09-07', 'sub_1PwIT8DTqe3AeBX5ZkzOxnjH', 'prod_QT1BnJCGgJqd0m', '2024-09-07 12:20:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user-registration`
--

CREATE TABLE `user-registration` (
  `id` int(11) NOT NULL,
  `jms_first_name` varchar(255) NOT NULL,
  `jms_last_name` varchar(255) NOT NULL,
  `jms_email_id` varchar(255) NOT NULL,
  `jms_password` varchar(255) NOT NULL,
  `jms_gender` varchar(255) NOT NULL,
  `jms_birthdate` text NOT NULL,
  `profile_upload` text NOT NULL,
  `request_access` text NOT NULL,
  `is_requested` tinytext NOT NULL DEFAULT 'n',
  `jms_verify_token` varchar(255) NOT NULL,
  `jms_verify_status` tinyint(2) NOT NULL DEFAULT 0,
  `jms_unlimited_deal` text NOT NULL,
  `jms_no_save_deal` float NOT NULL,
  `jms_deal_save_allno` float NOT NULL,
  `jms_unlimited_buy` text NOT NULL,
  `jms_no_save_buy` float NOT NULL,
  `jms_buy_save_allno` float NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user-registration`
--

INSERT INTO `user-registration` (`id`, `jms_first_name`, `jms_last_name`, `jms_email_id`, `jms_password`, `jms_gender`, `jms_birthdate`, `profile_upload`, `request_access`, `is_requested`, `jms_verify_token`, `jms_verify_status`, `jms_unlimited_deal`, `jms_no_save_deal`, `jms_deal_save_allno`, `jms_unlimited_buy`, `jms_no_save_buy`, `jms_buy_save_allno`, `created_on`, `updated_on`) VALUES
(1, 'nitin', 'thakor', 'nitin@jmswebsolution.com', '47eba7b0114de483916b2ba766e02ffc', 'male', '2024-09-05', '', '', 'n', '0a1d50294fad6dd02bdf3a81872a54e8', 1, 'Unlimited', 0, 0, '', 0, 0, '2024-09-07 10:57:56', NULL),
(2, 'sachin', 'thakor', 'sachin@jmswebsolution.com', '47eba7b0114de483916b2ba766e02ffc', 'male', '2024-09-12', '', '', 'n', 'ffc9fbde3304301f46354c341b5c27ef', 1, 'Unlimited', 0, 0, '', 0, 0, '2024-09-07 11:02:22', '2024-09-07 08:40:25'),
(3, 'jash', 'joshi', 'jash@jmswebsolution.com', '47eba7b0114de483916b2ba766e02ffc', 'male', '2024-09-21', '66dbf7d97c39b_owp-people-2.jpg', '', 'n', '18707e56cb5afad4048cef9b98e99e91', 1, '', 0, 0, '', 0, 0, '2024-09-07 12:19:15', '2024-09-07 08:51:05'),
(4, 'samir', 'thakor', 'samir@jmswebsolution.com', '47eba7b0114de483916b2ba766e02ffc', 'male', '2024-09-19', '', '', 'n', '633e7933266fda93325d0d1bd6af5207', 1, '', 0, 0, '', 0, 0, '2024-09-07 16:43:01', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buy-and-hold-analysis-calc`
--
ALTER TABLE `buy-and-hold-analysis-calc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cancel_subscription`
--
ALTER TABLE `cancel_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deal-evaluation-calc`
--
ALTER TABLE `deal-evaluation-calc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paypal_payments_purchase`
--
ALTER TABLE `paypal_payments_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paypal_payments_subscription`
--
ALTER TABLE `paypal_payments_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stripe_payments_purchase`
--
ALTER TABLE `stripe_payments_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stripe_payments_subscription`
--
ALTER TABLE `stripe_payments_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user-registration`
--
ALTER TABLE `user-registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `buy-and-hold-analysis-calc`
--
ALTER TABLE `buy-and-hold-analysis-calc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancel_subscription`
--
ALTER TABLE `cancel_subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deal-evaluation-calc`
--
ALTER TABLE `deal-evaluation-calc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paypal_payments_purchase`
--
ALTER TABLE `paypal_payments_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paypal_payments_subscription`
--
ALTER TABLE `paypal_payments_subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stripe_payments_purchase`
--
ALTER TABLE `stripe_payments_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stripe_payments_subscription`
--
ALTER TABLE `stripe_payments_subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user-registration`
--
ALTER TABLE `user-registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
