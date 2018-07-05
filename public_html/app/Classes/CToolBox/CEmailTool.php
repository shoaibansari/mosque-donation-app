<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 1/12/2018 6:14 AM
 */

namespace App\Classes\CToolBox;
use Illuminate\Support\Facades\Mail;

class CEmailTool {

	protected $data;

	/**
	 * @return CEmailTool
	 */
	public static function instance() {
		static $instance;
		if ( !$instance ) {
			$instance = new CEmailTool();
		}
		$instance->fromNoReply();
		return $instance;
	}

	public function subject( $subject, $data=null ) {
		$subject = toolbox()->string()->fillText( $subject, $data, ['{{', '}}']);
		$this->data[ 'subject' ] = $subject . ' - ' . settings()->getAppName();
		return $this;
	}

	public function to( $to, $name=null ) {
		if ( is_array($to) ) {
			$this->data[ 'to' ] = $to;
		} else {
			$this->data[ 'to' ] = [$to => $name];
		}
		return $this;
	}

	public function toAdmin() {
		$this->data[ 'to' ] = [ settings()->getAdminEmail() => settings()->getAdminName() ];
		return $this;
	}

	public function from( $email, $name=null) {
		$this->data['from'] = [ $email => $name ];
		return $this;
	}

	public function fromNoReply() {
		$this->data[ 'from' ] = [settings()->getNoReplyEmailAddress() => settings()->getAppName()];
		return $this;
	}

	public function fromInfo() {
		$this->data[ 'from' ] = [settings()->getInfoEmailAddress() => settings()->getAppName()];
		return $this;
	}

	public function fromSupport() {
		$this->data[ 'from' ] = [ settings()->getSupportEmailAddress() => settings()->getAppName() ];
		return $this;
	}

	public function message( $viewOrMessageContents, $data=null) {
		$this->data[ 'message' ] = [ $viewOrMessageContents, $data ];
		return $this;
	}

	public function send() {

		// "blade view" or "raw html"
		$viewOrMessageContents = $this->data[ 'message' ][0];

		// data for view or for contents
		$data = $this->data[ 'message' ][ 1 ];

		// sending email using a provided view
		if ( view()->exists($viewOrMessageContents) ) {
			$view = $viewOrMessageContents;
			return Mail::send(
				$view, $data, function ( $message ) {
				$fromName = reset( $this->data[ 'from' ] );
				$fromEmail = key( $this->data[ 'from' ] );
				$message->from( $fromEmail, $fromName );
				$message->to( $this->data[ 'to' ] );
				$message->subject( $this->data[ 'subject' ] );
			});
		}

		// sending content based email
		$contents = toolbox()->string()->fillText( $viewOrMessageContents, $data, ['{{', '}}'] );
		return Mail::send([], [], function ( $message ) use($contents) {
			$fromName = reset( $this->data[ 'from' ] );
			$fromEmail = key( $this->data[ 'from' ] );
			$message->from( $fromEmail, $fromName );
			$message->to( $this->data[ 'to' ] );
			$message->subject( $this->data[ 'subject' ] );
			$message->setBody( $contents, 'text/html');
		});
	}

	/**
	 * Test method
	 */
	public static function test() {
		return
			toolbox()->email()
			->fromNoReply()
			->subject("Subject goes here" )
			->to("adnan@gmail.com")
			//->message('Test <h1>email</h1> goes here')  // using raw html
			->message( toolbox()->frontend()->view('emails.forgot-password'), [
				'resetLink' => env('APP_URL') . '/email/confirmation/'.md5(time())
			]) // using blade view
			->send();
	}
}