<?php

use Illuminate\Database\Seeder;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $templates = [];

	    $templates[0]['email_template_setting_id'] = '1';
	    $templates[0]['code'] = 'forgot_password';
	    $templates[0]['name'] = 'Forgot Password';
	    $templates[0]['subject'] = '{{WEBSITE_NAME}} - Password Reset';
	    $templates[0]['tags'] = 'WEBSITE_NAME|USER_NAME|RESET_URL';
        $templates[0]['contents'] =<<<BLOCK
			Hi {{USER_NAME}},
			<p>
				You recently requested to reset your password for your account {{USER_NAME}} account.
			</p>
			<p>
				<center>
					<a href="{{RESET_URL}}">Click here</a> to reset your password
				</center>
			</p>			
			<p>
				If you did not request a password reset, please ignore this email. 
			</p>			
			<p>
				Thanks,
				{{WEBSITE_NAME}}
			</p>			
			<hr>
			<p>
				If you're having trouble clicking the password reset link, copy and paste the URL below into your web browser.
			</p>
			<a href="{{RESET_URL}}">{{RESET_URL}}</a>
			<br>
BLOCK;

	    DB::table( 'email_templates' )->truncate();
	    foreach ($templates as $template) {
		    DB::table( 'email_templates' )->insert(
			    [
				    'email_template_setting_id'     => $template['email_template_setting_id'],
				    'name'                          => $template['name'],
				    'code'                          => $template['code'],
				    'subject'                       => $template['subject'],
			        'contents'                      => $template['contents'],
				    'tags'                          => $template['tags'], 'active' => 1,
			        'created_at'                    => \Carbon\Carbon::now(),
				    'updated_at'                    => \Carbon\Carbon::now()
			    ]
		    );
	    }
    }
}
