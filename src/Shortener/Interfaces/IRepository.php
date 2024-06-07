<?php

namespace App\Shortener\Interfaces;

use App\Shortener\Exceptions\DataNotFoundException;

interface IRepository
{
    public function store(string $url, string $code): bool;

    /**
     * @param string $url
     * @return string
     */
    public function getCode(string $url): string;
    public function getUrl(string $code): string;

    public function codeIsset(string $code): bool;
}