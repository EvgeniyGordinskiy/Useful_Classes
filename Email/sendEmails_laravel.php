<?php
namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class SendEmail extends Job implements ShouldQueue
{
	use InteractsWithQueue, SerializesModels;
	private $list = [];
	private $from;
	private $subject;
	private $content;
	private $lists_fields = ['name', 'email'];
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(array $list, $subject, $content,  $from = false, $list_fields = false)
	{
		$this->list = $this->filter($list);
		if ( !$from ) {
			$this->from = getenv('SENDGRID_FROM');
		} else {
			$this->from = $from;
		}
		$this->subject = $subject;
		$this->content = $content;
		if ( $list_fields && is_array($list_fields) ) {
			$this->lists_fields = $list_fields;
		}
	}
	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		if( $this->list ) {
			foreach ($this->list as $recipient) {
				try{
					$from = new \SendGrid\Email('Sender', env('SENDGRID_FROM'));
					$subject = $this->subject;
					$to = new \SendGrid\Email($recipient['name'], $recipient['email']);
					$content = $this->content;
					$content = new \SendGrid\Content("text/html", $content);
					$mail = new \SendGrid\Mail($from, $subject, $to, $content);
					$apiKey = getenv('SENDGRID_API_KEY');
					$sg = new \SendGrid($apiKey);
					$sg->client->mail()->send()->post($mail);
				} catch (\Exception $e) {
					Log::error("$e->getMessage()! File: " . __FILE__ . " on the line: ".__LINE__);
				}
			}
		}
	}
	public function filter(array $list)
	{
		$result = array_filter($list,function ($item) {
			foreach ($this->lists_fields as $field) {
				if(!$item[$field]) {
					return false;
				}
			}
			return true;
		});
		if( !$result ) {
			Log::error("Wrong input data! File: " . __FILE__ . " on the line: ".__LINE__);
		}
		return $result;
	}
}