<?php

namespace App\Console\Commands;

use App\Services\CommunicationService;
use Exception;
use Illuminate\Console\Command;

class SendUnsentMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:unsent-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends the unsent messages and emails';

    /**
     * @var CommunicationService
     */
    private $communicationService;

    /**
     * Create a new command instance.
     *
     * @param CommunicationService $communicationService
     */
    public function __construct(CommunicationService $communicationService)
    {
        parent::__construct();

        $this->communicationService = $communicationService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $messages = $this->communicationService->getUnsentMessages();

        $emails = 0;
        $sms = 0;
        foreach ($messages as $message) {
            if ($message->type == 'email') {
                $sendArr = array(
                    'subject' => $message->subject,
                    'body'    => $message->message,
                    'to'      => $message->recipient
                );

                try {
                    $this->communicationService->sendMailViaSMTP($sendArr);
                    $this->communicationService->updateSent($message);
                    $emails++;
                } catch (Exception $e) {
                    echo $e->getMessage(); //Boring error messages from anything else!
                }
            } elseif ($message->type == 'sms') {
                $senderId = strtoupper(str_replace(' ', '_', $message->user->company_name));
                $body = $this->removeSpecialCharacters($message->message);

                $response = $this->communicationService->sendSMSViaApi(
                    $message->recipient,
                    $body,
                    $senderId != "" ? $senderId : "GLASS_ASSIST_UK"
                );

                if ($response == true) {
                    $this->communicationService->updateSent($message);
                    $sms++;
                }
            }

            $this->info('Sent: ' . $emails . ' emails | ' . $sms . ' texts');
        }

        return 0;
    }

    /**
     * @param string $message
     * @return string
     */
    private function removeSpecialCharacters(string $message): string
    {
        $message = str_replace('Ã', '', $message);
        $message = str_replace('Â', '', $message);
        $message = str_replace('â', '', $message);
        $message = str_replace('', '', $message);
        $message = str_replace('`', '', $message);

        return $message;
    }
}
