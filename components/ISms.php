<?php

namespace abhimanyu\sms\components;

/**
 * @author Abhimanyu Saharan <abhimanyu@teamvulcans.com>
 */
interface ISMS
{
    /**
     * Sends text message
     *
     * @param string $carrier
     * @param string $phoneNumber
     * @param string $subject
     * @param string $message
     * @param bool $split
     * @return int The number of text messages sent
     */
    public function send($carrier, $phoneNumber, $subject, $message, $split = false);

    /**
     * Splits up messages and add counter at the end
     *
     * @param string $message
     * @param int $splitLength
     * @return array
     */
    public function splitMessage($message, $splitLength);

    /**
     * Wordwrap in UTF-8 supports, return as array
     *
     * @param string $string
     * @param int $width
     * @return array
     */
    public function wordwrapArray($string, $width);
}