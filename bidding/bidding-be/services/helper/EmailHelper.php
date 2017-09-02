	<?php

	namespace com\appstions\biddin\helper;

	use com\appstions\bidding\dataAccess\UserDAO;
	use com\appstions\bidding\entity\User;
	use com\appstions\bidding\exceptions\DAOException;
	use com\appstions\bidding\service\Rest;
	use com\appstions\bidding\exceptions\ServiceException;
	use com\appstions\bidding\helper\ExceptionHelper;

	require_once 'dataAccess/UserDAO.php';
	require_once 'exceptions/DAOException.php';
	require_once 'entity/User.php';
	require_once 'logger/LoggerService.php';
	require_once 'swiftmailer-5.x/lib/swift_required.php';

	final class EmailHelper {
		
		/**
		 * Envia la notificacion del registro exitoso al correo del usuario
		 *
		 * @param User $user        	
		 * @throws \Exception
		 */
		public static function sendRegisterConfirmation(User $user) {
			try {
				
				if ($user->getEmail () == NULL) {
					throw new DAOException ( "El usuario no tiene un correo para enviar notificaciones", 500 );
				}
				
				$subject = "Registro de usuario";
				$fileName = self::getConfigurationValue ( "mail.template.confirm.register" );
				$body = file_get_contents ( $fileName );
				
				$message = str_replace ( ":{name}", $user->getName (), $body );
				
				self::sendMail ( $subject, $message, $user );
			} catch ( \Exception $e ) {
				ExceptionHelper::log ( $e, self );
				// ExceptionHelper::throwException($e, self);
			}
		}
		
		/**
		 * Envia la notificacion del registro exitoso al correo del usuario
		 *
		 * @param Player $player        	
		 * @throws \Exception
		 */
		public static function sendRegeneratePasswordEmail(User $user) {
			try {
				
				if ($user->getEmail () == NULL) {
					throw new DAOException ( "El usuario no tiene un correo para enviar notificaciones", 500 );
				}
				
				$subject = "Generación de contraseña";
				$fileName = self::getConfigurationValue ( "mail.template.confirm.password" );
				$body = file_get_contents ( $fileName );
				
				$message = str_replace ( ":{name}", $user->getName (), $body );
				$message = str_replace ( ":{password}", $user->getPassword (), $message );
				
				self::sendMail ( $subject, $message, $user );
			} catch ( \Exception $e ) {
				ExceptionHelper::log ( $e, self );
				// ExceptionHelper::throwException($e, self);
			}
		}
		
		/**
		 * Lleva a cabo el envio de correos al usuario
		 *
		 * @param unknown $subject        	
		 * @param unknown $body        	
		 * @param Player $player        	
		 * @throws ServiceException
		 */
		public static function sendMail($subject, $body, User $user) {
			try {
				$ssl = null;
				$host = self::getConfigurationValue ( "mail.host" );
				$port = self::getConfigurationValue ( "mail.port" );
				$userName = self::getConfigurationValue ( "mail.user" );
				$password = self::getConfigurationValue ( "mail.password" );
				$fromName = self::getConfigurationValue ( "mail.from.name" );
				$useSsl = self::getConfigurationValue ( "mail.ssl" );
				
				if ($useSsl) {
					$ssl = "ssl";
				}
				
				$transport = \Swift_SmtpTransport::newInstance ( $host, $port, $ssl );
				$transport->setUsername ( $userName );
				$transport->setPassword ( $password );
				
				$mailer = \Swift_Mailer::newInstance ( $transport );
				
				$message = \Swift_Message::newInstance ( $subject )->setFrom ( array (
						"info@appstions.com" => $fromName 
				) )->setTo ( array (
						$user->getEmail () => $user->getName () 
				) )->setBody ( $body, 'text/html' );
				
				$result = $mailer->send ( $message );
				
				if (! $result) {
					throw new ServiceException ( "No se pudo enviar el correo", Rest::CUSTOM_ERROR_CODE );
				}
			} catch ( \Exception $e ) {
				ExceptionHelper::log ( $e, self );
				// ExceptionHelper::throwException($e, $this);
			}
		}
	}