<?php
namespace App\Utils\Validators;

use Webmozart\Assert\Assert;

class SendMessageValidator
{
    /**
     * @param array $requestBody
     * @return void
     */
    static function validate(Array $requestBody): void
    {
        Assert::stringNotEmpty($requestBody['clientId']);
        Assert::stringNotEmpty($requestBody['templateKey']);

        Assert::isArray($requestBody['email']);
        foreach ($requestBody['email'] as $email)
        {
            Assert::stringNotEmpty($email);
        }
        Assert::isArray($requestBody['bcc']);
        foreach ($requestBody['bcc'] as $bcc)
        {
            Assert::stringNotEmpty($bcc);
        }

        Assert::isArray($requestBody['bodyData']);

        $body = $requestBody['bodyData'];
        Assert::stringNotEmpty($body['subject']);
        Assert::stringNotEmpty($body['date']);
        Assert::isArray($body['link']);

        $link = $body['link'];
        Assert::stringNotEmpty($link['label']);
        Assert::stringNotEmpty($link['url']);
    }
}