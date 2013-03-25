<?php
/*
 * Omits most of the code in this class
 * Contains only method from() and _sendWebApi() for demo purposes
 *
 * Method from() demonstrates the getter and setter methods combined,
 * and method from() is chainable: $email->from(...)->to(...);
 *
 * Method _sendWebApi() demonstrates the use of PHP CURL library
 */

class Wemail
{


	/*
	 * Get or set the From address of this message
	 * You many pass an array of addresses (multiple people)
	 * Display names can be provided: array('email@address.com' => 'Real Name')
	 */
	public function from($from = NULL)
	{
		if (is_null($from))
		{
			return $this->message->getFrom();
		}
		$this->message->setFrom($from);
		return $this;
	}
	

	/*
	 * Send the Email message out using SendGrid Web API
	 * The return value is the number of recipients who were accepted for delivery
	 * @param:	string $error
	 */
	protected function _sendWebApi(&$error)
	{
		$url = self::$config['url'];

		$recipients = 0;

		// TO must be a string in SendGrid Web API
		$x_smtpapi = array();
		foreach ($this->to() as $to=>$name)
		{
			$x_smtpapi['to'][] = $to;
			$recipients++;
		}

		$params = array(
			'api_user'	=> self::$config['api_user'],
			'api_key'	=> self::$config['api_key'],
			'from'		=> key($this->from()),
			'fromname'	=> current($this->from()),
			'replyto'	=> key($this->replyTo()),
			'x-smtpapi'	=> json_encode($x_smtpapi),
			'to'		=> $to,
			'subject'	=> $this->subject(),
			'html'		=> $this->body(),
			'text'		=> $this->altBody()
		);				

		// Set Email attachments
		foreach ($this->attachments as $attachment)
		{
			if (!empty($attachment['new_filename']))
			{
				$params['files[' . $attachment['new_filename'] . ']'] = '@' . $attachment['file'];
			}
			else
			{
				$filename_array = explode('/', $attachment['file']);
				$params['files[' . array_pop($filename_array) . ']'] = '@' . $attachment['file'];
			}
		}

		$request = $url . '/api/mail.send.json';
		$session = curl_init($request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_POSTFIELDS, $params);
		curl_setopt($session, CURLOPT_HEADER, FALSE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);
		curl_close($session);

		$response = json_decode($response);
		if ($response->message == 'success')
		{
			return $recipients;
		}
		$error = $response->errors[0];
		return 0;
	}
	
}
?>