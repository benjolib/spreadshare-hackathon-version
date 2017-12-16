<?php

namespace DS\Controller\Validation;

use Phalcon\Validation;
use Phalcon\ValidationInterface;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller\Validation
 */
class SignupValidation
    extends Validation
    implements ValidationSchema, ValidationInterface
{
    /**
     * @return SignupValidation|Validation
     */
    public static function getSchema()
    {
        return (new self())
            ->add(
                "name",
                new Validation\Validator\PresenceOf(
                    [
                        "message" => "Please provide a valid name",
                    ]
                )
            )
            ->add(
                "handle",
                new Validation\Validator\PresenceOf(
                    [
                        "message" => "Please provide a valid username",
                    ]
                )
            )
            ->add(
                "email",
                new Validation\Validator\PresenceOf(
                    [
                        "message" => "An e-mail address is required",
                    ]
                )
            )
            ->add(
                "email",
                new Validation\Validator\Email(
                    [
                        "message" => "The email address you provided is not valid.",
                    ]
                )
            )
            ->add(
                "password",
                new Validation\Validator\PasswordStrength(
                    [
                        "minScore" => 2,
                        "allowEmpty" => false,
                        "message" => "Your password is not strong enough. Use at least 6 characters, one uppercase, one number, and a special character.",
                    ]
                )
            );
        
    }
}
