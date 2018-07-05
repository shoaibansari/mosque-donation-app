<?php
/**
 * Created by Muhammad Adnan
 * Created Time: 7/28/2017 6:16 PM
 */

namespace App\Models\Repositories\Eloquent;

use App\Models\EmailTemplate;
use App\Models\Repositories\EmailTemplateRepositoryInterface;
use App\Models\Settings;

class EmailTemplateRepository extends AbstractRepository implements EmailTemplateRepositoryInterface {

	public function __construct( EmailTemplate $emailTemplate ) {
		parent::__construct( $emailTemplate );
	}


	public function getTemplate( $templateId, $data = [], $array=false ) {


		$template = $this->model->find( $templateId );
		if ( !$template ) {
			toolbox()->log()->error( toolbox()->string()->fillText( 'Email template-id# {id} not found.', ['id' => $template] )
			);

			return false;
		}

		if ( $template->tags ) {
			$missingTags = toolbox()->arrayTool()->compare( $template->tags, array_keys($data) );
			if ( count($missingTags) ) {
				toolbox()->log()->error('Missing tags: '. print_r($missingTags, true ));
				$this->errorMessage = 'Required tags for email template are missing.';
				return false;
			}
		}

		$result = [];
		$result['senderName'] = $template->sender_name ? $template->sender_name : settings()->getAppName();
		$result['senderEmail'] = $template->sender_email ? $template->sender_email : settings()->getNoReplyEmailAddress();
		$result['subject'] = $template->subject ? $template->subject : 'No Subject';
		$result['message'] = $template->contents;
		$result['cc'] = $template->cc;
		$result['bcc'] = $template->bcc;


		// updating placeholders
		if ( is_array( $data ) && $data ) {
			foreach ( $data as $name => $value ) {
				$result[ 'subject' ] = str_replace( '{{' . $name . '}}', strip_tags($value), $result[ 'subject' ] );
				$result[ 'message' ] = str_replace( '{{' . $name . '}}', nl2br( strip_tags( $value ) ), $result[ 'message' ] );
			}
		}

		return $array ? $result : (object)$result;
	}

	public function sendUsingTemplate( $emailTo, $templateId, $data=[] ) {

		if (!$template = $this->getTemplate( $templateId, $data ) ) {
			return false;
		}

		\Mail::send([], [], function($message) use($template, $emailTo) {
			$message->from( $template->senderEmail, $template->senderName );
			$message->subject( $template->subject );
			$message->to( $emailTo );
			$message->setBody( strip_tags($template->message) );
			$message->setBody( $template->message, 'text/html' );
			if ( $template->cc )
				$message->cc( $template->cc );
			if ( $template->bcc )
				$message->bcc( $template->bcc );
		});

		return true;

	}
}