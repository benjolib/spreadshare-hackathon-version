<?php

namespace DS\Component\Mailer\dto;


class BaseEmailDto
{
    protected function isNullOrEmptyString($str){
        return (!isset($str) || trim($str) === '');
    }

    protected function isValidUrl($url){
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return filter_var($url, FILTER_VALIDATE_URL,
            FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED);
    }

    protected function isValidSubUrl($subUrl){
        return substr($subUrl, 0, 1) === "/";
    }
}