<?php

namespace Models;

use \PDO;


class DatabaseShell
{	
	private static $iv = "7fc0uo5a3ph4csp8";
	private static $method = "AES-128-CBC";
	private static $key = "e80fU2e1";
	
	private static $pdo = null;
	public function __construct()
	{
		if (!self::$pdo) {
			self::$pdo = new PDO(
				'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
				DB_USER,
				DB_PASS,
				[
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
					PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES   => false
				]
			);
		}
	}


	public function setData($phone, $email)
	{
		/**
		 * поскольку значение $key формируется в том числе md5-хешем e-mail пользователя,
		 * получение злоумышленником доступа к базе данных и всем файлам не позволит ему 
		 * прочитать данные, не зная реальных e-mail пользователей.
		 * 
		 * для некоторых сценариев возможен другой способ, который заключается в том, что $key 
		 * генерируется вообще без привязки к e-mail пользователя, после чего записывается в 
		 * cookie, и дальнейшее шифрование / дешифрование происходит уже с этим $key  
		 */

		$key = self::$key . md5($email);
		$phone = openssl_encrypt($phone, self::$method, $key, 0, self::$iv);
		$email = openssl_encrypt($email, self::$method, $key, 0, self::$iv);

		$query = "INSERT INTO `phones` VALUES (
            0, ?, ? 
            )";

		$stmt = self::$pdo->prepare($query);
		return $stmt->execute(array($phone, $email));
	}

	public function sendEmail($phone, $email)
	{
		$to      = $email;
		$subject = 'Your phone number';
		$message = 'Hello, your phone number: ' . $phone;
		$headers = 'From: bot@example.com' . "\r\n" .
			'Reply-To: bot@example.com' . "\r\n" .
			'X-Mailer: PHP';

		if (mail($to, $subject, $message, $headers)) {
			return 'success';
		}
	}
	
	public function getData($email)
	{
		$key = self::$key . md5($email);
		$encrypt_email = openssl_encrypt($email, self::$method, $key, 0, self::$iv);

		$query = "SELECT `phone` FROM `phones` 
                WHERE `email` = ? 
                LIMIT 1 ";

		$stmt = self::$pdo->prepare($query);
		$stmt->execute(array($encrypt_email));
		$row = $stmt->fetch();
		
		if ($row) {
			$phone = openssl_decrypt($row['phone'], self::$method, $key, 0, self::$iv);
			return $this->sendEmail($phone, $email);
		} 

		return 'absence';
	}

	public function tableMaker()
	{
		$query = "CREATE TABLE IF NOT EXISTS `phones` (
            id INT(11) NOT NULL AUTO_INCREMENT,
            phone CHAR(250) NOT NULL,
            email CHAR(250) NOT NULL,
            PRIMARY KEY (id)
          )";

		$stmt = self::$pdo->prepare($query);
		$stmt->execute();
	}
}
