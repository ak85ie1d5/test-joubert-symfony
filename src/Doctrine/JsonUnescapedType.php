<?php

namespace App\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

class JsonUnescapedType extends JsonType
{
    const JSON_UNESCAPED = 'json_unescaped';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return json_encode($value, JSON_UNESCAPED_SLASHES);
    }

    public function getName()
    {
        return self::JSON_UNESCAPED;
    }
}
