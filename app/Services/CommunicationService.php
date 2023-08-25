<?php


namespace App\Services;

use App\Models\Customer;
use App\Models\Email;
use App\Models\Sent;
use ClickSend\ApiException;
use ClickSend\Configuration;
use ClickSend\Api\SMSApi;
use Illuminate\Database\Eloquent\Collection;
use SendGrid\Mail\Attachment;
use SendGrid\Mail\Mail as SendGridMail;

class CommunicationService
{
    /**
     * @param int $customerId
     * @param int $vehicleId
     * @param string $subject
     * @param string $messageType
     * @param string $message
     * @param string $override
     * @return bool
     */
    public function sendMail(
        int $customerId,
        int $vehicleId,
        string $subject,
        string $messageType,
        string $message,
        string $override = ''
    ): bool {
        if ($message == '') {
            return false;
        }

        $account = auth()->user();
        $headers = 'From: <andy@icis.co.uk>';

        if ($override != '') {
            $emailAddress = $override;
        } else {
            $customer = Customer::find($customerId);
            $emailAddress = $customer->email;
        }

        if (strlen($emailAddress) == 0) {
            return false;
        }

        $this->recordSent(
            'email',
            $messageType,
            $account->id,
            $customerId,
            $vehicleId,
            $emailAddress,
            $subject,
            utf8_encode($message),
            $headers
        );

        return true;
    }

    /**
     * @param int $customerId
     * @param int $vehicleId
     * @param string $messageType
     * @param string $message
     * @param string $override
     * @return bool
     */
    public function sendSMS(
        int $customerId,
        int $vehicleId,
        string $messageType,
        string $message,
        string $override = ''
    ): bool {
        if ($message == '') {
            return false;
        }

        $account = auth()->user();
        $headers = 'From: <andy@icis.co.uk>';

        if ($override != '') {
            $mobileNo = $override;
        } else {
            $customer = Customer::find($customerId);
            $mobileNo = $customer->mobile;
        }

        if (substr($mobileNo, 0, 3) == '+44') {
            $mobileNo = '44' . substr($mobileNo, 3);
        } elseif (substr($mobileNo, 0, 1) == '0') {
            $mobileNo = '44' . substr($mobileNo, 1);
        }

        if (strlen($mobileNo) != 12) {
            return false;
        }

        $this->recordSent(
            'sms',
            $messageType,
            $account->id,
            $customerId ?? 0,
            $vehicleId ?? 0,
            $mobileNo,
            $account->company_name ?? "Glass Assist UK Ltd",
            utf8_encode($message),
            $headers
        );

        $noOfTexts = ceil(strlen($message) / 160);

        if ($noOfTexts > 1) {
            for ($i = 1; $i < $noOfTexts; $i++) {
                $this->recordSent(
                    'sms',
                    $messageType,
                    $account->id,
                    $customerId,
                    $vehicleId,
                    $mobileNo,
                    $account->company_name ?? "Glass Assist UK Ltd",
                    '[text continued]',
                    $headers
                );
            }
        }

        return true;
    }

    /**
     * @param string $type
     * @param string $messageType
     * @param int $userId
     * @param int $customerId
     * @param int $vehicleId
     * @param string $recipient
     * @param string $subject
     * @param string $message
     * @param string $headers
     * @param int $daysBefore
     */
    public function recordSent(
        string $type,
        string $messageType,
        int $userId,
        int $customerId,
        int $vehicleId,
        string $recipient,
        string $subject,
        string $message,
        string $headers = '',
        int $daysBefore = 0
    ) {
        $sent = new Sent();

        $sent->user_id = $userId;
        $sent->type = $type;
        $sent->message_type = $messageType;
        $sent->days_before = $daysBefore;
        $sent->customer_id = $customerId;
        $sent->vehicle_id = $vehicleId;
        $sent->recipient = $recipient;
        $sent->subject = $subject;
        $sent->message = $message;
        $sent->headers = $headers;
        $sent->sent = 0;
        $sent->date_sent = NOW();

        $sent->save();
    }

    /**
     * @return Collection
     */
    public function getUnsentMessages(): Collection
    {
        return Sent::where('sent', 0)
            ->where('message', '<>', '[text continued]')
            ->whereIn('type', ['sms', 'email'])
            ->where('date_sent', '>', now()->subDays(7))
            ->limit(60)
            ->get();
    }

    /**
     * @param Sent $message
     */
    public function updateSent(Sent $message)
    {
        $message->sent = 1;
        $message->date_sent = NOW();
        $message->save();
    }

    /**
     * @param string $to
     * @param string $message
     * @param string $originator
     * @return false|string
     */
    public function sendSMSViaApi(string $to, string $body, string $originator)
    {
        $username = config('services.clicksend.username');
        $apiKey = config('services.clicksend.api_key');

        $config = Configuration::getDefaultConfiguration()->setUsername($username)->setPassword($apiKey);
        $apiInstance = new SMSApi(null, $config);

        try {
            $message = array(
                'to' => $to,
                'from' => str_replace('_', ' ', $originator),
                'body' => $body
            );

            $apiInstance->smsSendPost(["messages" => [$message]]);

            return true;
        } catch (APIException $e) {
            return false;
        }

        /*$url = 'https://api.textmarketer.co.uk/gateway/' . "?username=" .
            env('TEXTMARKETER_USER') . "&password=" .
            env('TEXTMARKETER_PASS') . "&option=xml";
        $url .= "&to=$to&message=" . urlencode($message) . '&orig=' . urlencode(substr($originator, 0, 11));
        $fp = fopen($url, 'r');

        return fread($fp, 1024);*/
    }

    /**
     * @param array $data
     * @param bool $html
     */
    public function sendMailViaSMTP(array $data, bool $html = true)
    {
        $header = '<html><body>';
        $footer = '</body></html>';

        if ($html) {
            $data['body'] = $header . $data['body'] . $footer;
        }

        $mail = new SendGridMail();
        $mail->setFrom(env('APP_EMAIL'), env('APP_NAME'));
        $mail->setSubject(env('APP_NAME') . ' - ' . $data['subject']);
        $mail->addTo(trim($data['to']));
        //$mail->addTo('mlkhamzaawan4210@gmail.com');

        if (isset($data['cc'])) {
            $mail->addCc($data['cc']);
        }
        if (substr($data['subject'], 0, 13) != 'Job Card for ') {
            $mail->addCc(env('APP_EMAIL'));
        }

        if ($html) {
            $mail->addContent("text/html", $data['body']);
        } else {
            $mail->addContent("text/plain", strip_tags($data['body']));
        }

        if (isset($data['filestring']) && isset($data['filename'])) {
            $attachmentContent = $data['filestring'];
            $attachmentFilename = $data['filename'];
            $attachmentContentType = $this->filenameToType($attachmentContent);

            if (file_exists($attachmentContent)) {
                $attachmentContent = base64_encode(file_get_contents($data['filestring']));
            }

            $attachment = new Attachment();
            $attachment->setContent($attachmentContent);
            $attachment->setType($attachmentContentType);
            $attachment->setFilename($attachmentFilename);
            $attachment->setDisposition("attachment");

            $mail->addAttachment($attachment);
        }

        if (isset($data['filephysical']) && isset($data['filename'])) {
            $attachmentContent = base64_encode(file_get_contents(asset('/upload/' . $data['filename'])));
            $attachmentFilename = $data['filename'];
            $attachmentContentType = $this->filenameToType($attachmentContent);

            $attachment = new Attachment();
            $attachment->setContent($attachmentContent);
            $attachment->setType($attachmentContentType);
            $attachment->setFilename($attachmentFilename);
            $attachment->setDisposition("attachment");

            $mail->addAttachment($attachment);
        }

        $email = new Email();
        $email->email_type = (isset($data['email_type']) ? $data['email_type'] : null);
        $email->unique_id = (isset($data['unique_id']) ? $data['unique_id'] : null);
        $email->to = $data['to'];
        $email->subject = $data['subject'];
        $email->body = $data['body'];
        $email->filename = (isset($data['filename']) ? $data['filename'] : null);
        $email->date_added = now();
        $email->save();

        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($mail);

            if ($response->statusCode() == 202) {
                $sent = 1;
            } else {
                print $response->statusCode() . "\n";
                print_r($response->headers());
                print $response->body() . "\n";

                $notes = $response->body();
            }
        } catch (\Exception $e) {
            $notes = 'Failed to send email: ' . $e->getMessage();
        }

        if ($sent == 1 || $sent == true) {
            $email->date_sent = now();
            $email->sent = 1;
            $email->save();
        } else {
            $email->date_sent = now();
            $email->notes = $notes;
            $email->save();
        }
    }

    public function filenameToType($filename): string
    {
        $qPos = strpos($filename, '?');
        if (false !== $qPos) {
            $filename = substr($filename, 0, $qPos);
        }

        $pathInfo = $this->mbPathInfo($filename);

        return $this->mimeTypes($pathInfo['extension']);
    }

    public function mbPathInfo($path, $options = null): array
    {
        $ret = array('dirname' => '', 'basename' => '', 'extension' => '', 'filename' => '');
        $pathInfo = array();
        if (preg_match('%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im', $path, $pathInfo)) {
            if (array_key_exists(1, $pathInfo)) {
                $ret['dirname'] = $pathInfo[1];
            }
            if (array_key_exists(2, $pathInfo)) {
                $ret['basename'] = $pathInfo[2];
            }
            if (array_key_exists(5, $pathInfo)) {
                $ret['extension'] = $pathInfo[5];
            }
            if (array_key_exists(3, $pathInfo)) {
                $ret['filename'] = $pathInfo[3];
            }
        }
        switch ($options) {
            case PATHINFO_DIRNAME:
            case 'dirname':
                return $ret['dirname'];
            case PATHINFO_BASENAME:
            case 'basename':
                return $ret['basename'];
            case PATHINFO_EXTENSION:
            case 'extension':
                return $ret['extension'];
            case PATHINFO_FILENAME:
            case 'filename':
                return $ret['filename'];
            default:
                return $ret;
        }
    }

    /**
     * Get the MIME type for a file extension.
     * @param string $ext File extension
     * @access public
     * @return string MIME type of file.
     * @static
     */
    public function mimeTypes($ext = ''): string
    {
        $mimes = array(
            'xl'    => 'application/excel',
            'js'    => 'application/javascript',
            'hqx'   => 'application/mac-binhex40',
            'cpt'   => 'application/mac-compactpro',
            'bin'   => 'application/macbinary',
            'doc'   => 'application/msword',
            'word'  => 'application/msword',
            'class' => 'application/octet-stream',
            'dll'   => 'application/octet-stream',
            'dms'   => 'application/octet-stream',
            'exe'   => 'application/octet-stream',
            'lha'   => 'application/octet-stream',
            'lzh'   => 'application/octet-stream',
            'psd'   => 'application/octet-stream',
            'sea'   => 'application/octet-stream',
            'so'    => 'application/octet-stream',
            'oda'   => 'application/oda',
            'pdf'   => 'application/pdf',
            'ai'    => 'application/postscript',
            'eps'   => 'application/postscript',
            'ps'    => 'application/postscript',
            'smi'   => 'application/smil',
            'smil'  => 'application/smil',
            'mif'   => 'application/vnd.mif',
            'xls'   => 'application/vnd.ms-excel',
            'ppt'   => 'application/vnd.ms-powerpoint',
            'wbxml' => 'application/vnd.wap.wbxml',
            'wmlc'  => 'application/vnd.wap.wmlc',
            'dcr'   => 'application/x-director',
            'dir'   => 'application/x-director',
            'dxr'   => 'application/x-director',
            'dvi'   => 'application/x-dvi',
            'gtar'  => 'application/x-gtar',
            'php3'  => 'application/x-httpd-php',
            'php4'  => 'application/x-httpd-php',
            'php'   => 'application/x-httpd-php',
            'phtml' => 'application/x-httpd-php',
            'phps'  => 'application/x-httpd-php-source',
            'swf'   => 'application/x-shockwave-flash',
            'sit'   => 'application/x-stuffit',
            'tar'   => 'application/x-tar',
            'tgz'   => 'application/x-tar',
            'xht'   => 'application/xhtml+xml',
            'xhtml' => 'application/xhtml+xml',
            'zip'   => 'application/zip',
            'mid'   => 'audio/midi',
            'midi'  => 'audio/midi',
            'mp2'   => 'audio/mpeg',
            'mp3'   => 'audio/mpeg',
            'mpga'  => 'audio/mpeg',
            'aif'   => 'audio/x-aiff',
            'aifc'  => 'audio/x-aiff',
            'aiff'  => 'audio/x-aiff',
            'ram'   => 'audio/x-pn-realaudio',
            'rm'    => 'audio/x-pn-realaudio',
            'rpm'   => 'audio/x-pn-realaudio-plugin',
            'ra'    => 'audio/x-realaudio',
            'wav'   => 'audio/x-wav',
            'bmp'   => 'image/bmp',
            'gif'   => 'image/gif',
            'jpeg'  => 'image/jpeg',
            'jpe'   => 'image/jpeg',
            'jpg'   => 'image/jpeg',
            'png'   => 'image/png',
            'tiff'  => 'image/tiff',
            'tif'   => 'image/tiff',
            'eml'   => 'message/rfc822',
            'css'   => 'text/css',
            'html'  => 'text/html',
            'htm'   => 'text/html',
            'shtml' => 'text/html',
            'log'   => 'text/plain',
            'text'  => 'text/plain',
            'txt'   => 'text/plain',
            'rtx'   => 'text/richtext',
            'rtf'   => 'text/rtf',
            'vcf'   => 'text/vcard',
            'vcard' => 'text/vcard',
            'xml'   => 'text/xml',
            'xsl'   => 'text/xml',
            'mpeg'  => 'video/mpeg',
            'mpe'   => 'video/mpeg',
            'mpg'   => 'video/mpeg',
            'mov'   => 'video/quicktime',
            'qt'    => 'video/quicktime',
            'rv'    => 'video/vnd.rn-realvideo',
            'avi'   => 'video/x-msvideo',
            'movie' => 'video/x-sgi-movie'
        );
        return (array_key_exists(strtolower($ext), $mimes) ? $mimes[strtolower($ext)] : 'application/octet-stream');
    }
}