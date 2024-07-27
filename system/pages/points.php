<?php

$title = 'Pay with Stripe';

if(!defined('INITIALIZED'))
	exit;

if (!$logged) {
	header('Location: ?subtopic=accountmanagement&redirect=?subtopic=points');
	exit;
}

require SYSTEM . 'pages/tibia_coin_balance.php';
require_once('./stripe/config.php');


$main_content .= '<style>
.payment-container {
  position: relative;
  width: 156px;
  height: 156px;
  margin: 3px;
  display: inline-block;
  background-image: url("../images/container_points.png");
  background-size: cover;
  background-position: no-repeat;
}

.payment-container:nth-of-type(6) {
  position: absolute;
  bottom: 65px;
  left: 339px;
}

.inside-container {
  position: absolute;
  left: 10px;
  top: 48px;
  height: 64px;
  width: 128px;
}

.premium-points {
  text-align: center;
  font-style: normal;
  font-weight: normal;
  line-height: 2.5;
}

.money-amount {
  text-align: center;
  font-style: normal;
  font-weight: normal;
  line-height: 13.7;
  height: 5px;
  }

.icon {
  position: absolute;
  left: 0;
  top: 0;
  height: 64px;
  width: 128px;
}

.icon:hover {
  background-image: url(\'' . $template_path . '/images/inside-container.png\');
}

.icon:hover {
  filter: brightness(120%); /* Makes the icon 20% brighter on hover */
}

.payment-link, .payment-link:visited {
  color: white !important; /* Forcefully sets the text color to white */
  text-decoration: none !important; /* Forcefully removes underline */
}

.payment-link:hover, .payment-link:active, .payment-link:focus {
  color: white !important; /* Keeps the text color white on hover, active, and focus states */
  text-decoration: none !important; /* Ensures underline is removed on hover, active, and focus states */
}
</style>';

foreach ($stripe_payments as $offer) {
    $main_content .= "<a href='" . $offer['price_id'] . "?client_reference_id=" . $account_logged->getId() . "' class='payment-link'>";
    $main_content .= '<div class="payment-container">';
    $main_content .= '<p class="premium-points">' . $offer['premium_points'] . ' Coins</p>';
    $main_content .= '<div class="inside-container">';
    $main_content .= '<div class="icon" style="background-image:url(\'' . $offer['image'] . '\');"></div>';
    $main_content .= '</div>';
    $main_content .= '<p class="money-amount">' . $offer['money_amount'] . ' ' . $offer['money_currency'] . '</p>';
    $main_content .= '</a></div>';
}