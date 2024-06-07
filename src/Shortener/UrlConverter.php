<?php

namespace App\Shortener;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\IUrlDecoder;
use App\Shortener\Interfaces\IUrlEncoder;
use App\Shortener\Interfaces\IRepository;
use App\Shortener\Interfaces\IValidator;
use GuzzleHttp\Exception\InvalidArgumentException;

class UrlConverter implements IUrlEncoder, IUrlDecoder
{

    const PATTERN = '123456789qwertyuiopasdfghjklzxcvbnm';

    public function __construct(
        protected IRepository $repository,
        protected IValidator  $validator,
        protected int         $length = 10,
    )
    {
    }

    public
    function decode(string $code): string
    {
        try {
            $url = $this->repository->getUrl($code);
        } catch (DataNotFoundException $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }

        return $url;
    }

    public
    function encode(string $string): string
    {
        $this->validator->validate($string);

        try {
            $code = $this->repository->getCode($string);
        } catch (DataNotFoundException) {
            $code = substr(str_shuffle(self::PATTERN . strtoupper(self::PATTERN)), 0, $this->length);
            $this->repository->store($string, $code);
        }

        return $code;
    }
}