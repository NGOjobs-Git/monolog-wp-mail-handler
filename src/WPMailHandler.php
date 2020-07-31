<?php


namespace phylogram\MonologWPMailHandler;


use Monolog\Formatter\HtmlFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class WPMailHandler extends AbstractProcessingHandler
    /**
     * This class connects Monolog Handlers https://github.com/Seldaek/monolog/blob/master/doc/04-extending.md
     * and thw wordpress wp_mail function: https://developer.wordpress.org/reference/functions/wp_mail/
     */
{

    /**
     * @var array list of mail addresses to send to (https://developer.wordpress.org/reference/functions/wp_mail/)
     */
    private array $to;

    /**
     * WPMailHandler constructor.
     * @param string[] $to list of mail addresses to send to (https://developer.wordpress.org/reference/functions/wp_mail/)
     * @param int $level See Parent class
     * @param bool $bubble See Parent class
     */
    public function __construct(array $to, $level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
    }


    protected function write(array $record): void
        /**
         * @todo pass data to wp_mail headers and attachment.
         */
    {
        # easy monolog formatting for mail body
        $htmlFormatter = new HtmlFormatter();
        $message = $htmlFormatter->format($record);

        # generate some subject. have not found a formatter for that
        $channel = $record['channel'];
        $level_name = $record['level_name'];
        $raw_message = $record['message'];
        $subject = "{$channel}: {$level_name} '{$raw_message}'";
        $max_subject_length = 40;
        $subject_length = strlen($subject);
        $subject = substr($subject, 0, $max_subject_length);
        if ($subject_length > $max_subject_length) {
            $subject .= '…';
        }

        # send mail

        wp_mail($this->to, $subject, $message);
    }
}