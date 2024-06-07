<?php

namespace App\Shortener\Interfaces;

interface IUrlEncoder
{
    /**
     * @param string $string
     * @return string
     * @throws \InvalidArgumentException
     */
    public function encode(string $string): string;
}