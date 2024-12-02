<?php

namespace App\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

class OracleDateType extends Type
{
    const ORACLE_DATE = 'oracle_date';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "DATE";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        // Essayer de convertir en utilisant le format attendu
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $value);

        // Si la conversion échoue, essayer le format par défaut d'Oracle
        if (!$dateTime) {
            $dateTime = \DateTime::createFromFormat('d-M-y', $value);
        }

        // Si la conversion échoue encore, lancer une exception
        if (!$dateTime) {
            throw new InvalidArgumentException("Invalid date format: " . $value);
        }

        return $dateTime;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }

        throw new InvalidArgumentException("Invalid date object: " . $value);
    }

    public function getName()
    {
        return self::ORACLE_DATE;
    }
}
