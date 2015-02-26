<?php

	namespace abhimanyu\sms\components;

	use Swift_MailTransport;
	use Swift_Message;
	use yii\base\Component;

	/**
	 * Class Sms
	 *
	 * @author  Abhimanyu Saharan <abhimanyu@teamvulcans.com>
	 * @package abhimanyu\sms\components
	 */
	class Sms extends Component implements ISMS
	{
		/**
		 * Transport for mailing
		 *
		 * @var string
		 */
		public $transportType = '';

		/**
		 * Transport options for swift mailer transport (used only for smtp)
		 *
		 * @var array
		 */
		public $transportOptions = [
			'host'       => 'mx1.hostinger.in',
			'username'   => 'abhimanyu@teamvulcans.com',
			'password'   => 'kp171095',
			'port'       => 2525,
			'encryption' => ''
		];

		/**
		 * Variable to separate prefix and suffix in the carriers email address
		 * Format:
		 *      {prefix}{number}{suffix}
		 * You'll need to search online to get the proper email addresses
		 * The prefix is for the rare weird ones, like the "+48" in this:
		 *      Polkomtel       Poland      +48number@text.plusgsm.pl
		 * Would be:
		 *      "Polkomtel" => "+48//text.plusgsm.pl",
		 *
		 * @link http://en.wikipedia.org/wiki/List_of_SMS_gateways
		 * @link http://www.tech-recipes.com/rx/939/sms_email_cingular_nextel_sprint_tmobile_verizon_virgin/
		 * @link http://www.tech-recipes.com/rx/2819/sms_email_us_cellular_suncom_powertel_att_alltel/
		 * @var string
		 */
		private $prefixSuffixSeparator = "//";

		/**
		 * Split length. This is to handle sms limits (160 characters)
		 * (Be sure to leave some padding so we can add in a counter)
		 *
		 * Note: Depending on the type of phone the user has, you may not need to split messages
		 *       Thus, the split variable is false by default
		 *
		 * @var int
		 */
		private $splitLength = 150;

		/**
		 * Swiftmailer object
		 *
		 * @var \Swift_Mailer
		 */
		protected $_mailer;

		/**
		 * Get list of carriers (Check wikipedia for a more complete list)
		 * Use $this->prefixSuffixSeparator if needed, though typically you won't need it
		 *
		 * @return array
		 */
		public static function getCarriers()
		{
			return [
				"AT&T"          => "txt.att.net",
				"Boost Mobile"  => "myboostmobile.com",
				"Cingular"      => "cingularme.com",
				"Metro PCS"     => "mymetropcs.com",
				"Nextel"        => "messaging.nextel.com",
				"Sprint"        => "messaging.sprintpcs.com",
				"T-Mobile"      => "tmomail.net",
				"Verizon"       => "vtext.com",
				"Virgin Mobile" => "vmobl.com",
			];
		}

		/**
		 * Sends text message
		 *
		 * @param string $carrier
		 * @param string $phoneNumber
		 * @param string $subject
		 * @param string $message
		 * @param bool   $split
		 *
		 * @return int The number of text messages sent
		 */
		public function send($carrier, $phoneNumber, $subject, $message, $split = FALSE)
		{
			// Check for valid Carrier
			$carriers = $this->getCarriers();
			if (empty($carriers[$carrier])) {
				return 0;
			}

			// Clean up the phone number
			$phoneNumber = str_replace([' ', '-'], '', $phoneNumber);

			// Calculate the prefix and suffix
			// If separator is not found that means its a suffix
			list($prefix, $suffix) = strpos($carriers[$carrier], $this->prefixSuffixSeparator) !== FALSE
				?
				explode($this->prefixSuffixSeparator, $carriers[$carrier])
				:
				['', $carriers[$carrier]];

			// Calculate Address
			$to = "{$prefix}{$phoneNumber}@{$suffix}";

			// Calculate message
			// Result in an array of count 1
			$messages = $split ? $this->splitMessage($message, $this->splitLength) : [$message];

			// Send Email
			$successCount = 0;
			foreach ($messages as $message) {
				$successCount += $this->_mail($to, $subject, $message);
			}

			return $successCount;
		}

		/**
		 * Sends email in order to send text message
		 *
		 * @param string $to
		 * @param string $subject
		 * @param string $message
		 *
		 * @return int
		 */
		private function _mail($to, $subject, $message)
		{
			// Set up swift mailer if needed
			if (!$this->_mailer) {
				$transport = NULL;
				// Set transport to php
				if (strtolower($this->transportType) == 'php') {
					$transport = Swift_MailTransport::newInstance();
				} // Set transport to smtp
				elseif (strtolower($this->transportType) == 'smtp') {
					$transport = \Swift_SmtpTransport::newInstance();

					foreach ($this->transportOptions as $option => $value) {
						$methodName = 'set' . ucfirst($option);
						$transport->$methodName($value);
					}
				}

				// Create Mailer object
				$this->_mailer = \Swift_Mailer::newInstance($transport);
			}

			// Set up message
			$mailer  = $this->_mailer;
			$message = Swift_Message::newInstance($subject)->setFrom('not@used.com')->setTo($to)->setBody($message);

			return $mailer->send($message);
		}

		/**
		 * Splits up messages and add counter at the end
		 *
		 * @param string $message
		 * @param int    $splitLength
		 *
		 * @return array
		 */
		public function splitMessage($message, $splitLength)
		{
			// Split up
			$messages = $this->wordwrapArray($message, $splitLength);

			// Add counter to each message
			$total = count($messages);
			if ($total > 1) {
				$count = 1;

				foreach ($messages as $key => $currMsgWrapped) {
					$messages[$key] = "$currMsgWrapped ($count/$total)";
					$count++;
				}
			}

			return $messages;
		}

		/**
		 * Wordwrap in UTF-8 supports, return as array
		 *
		 * @param string $string
		 * @param int    $width
		 *
		 * @return array
		 */
		public function wordwrapArray($string, $width)
		{
			if (($len = mb_strlen($string, 'UTF-8')) <= $width) {
				return [$string];
			}
			$return     = [];
			$last_space = FALSE;
			$i          = 0;
			do {
				if (mb_substr($string, $i, 1, 'UTF-8') == ' ') {
					$last_space = $i;
				}
				if ($i > $width) {
					$last_space = ($last_space == 0) ? $width : $last_space;
					$return[]   = trim(mb_substr($string, 0, $last_space, 'UTF-8'));
					$string     = mb_substr($string, $last_space, $len, 'UTF-8');
					$len        = mb_strlen($string, 'UTF-8');
					$i          = 0;
				}
				$i++;
			} while ($i < $len);
			$return[] = trim($string);

			return $return;
		}
	}
