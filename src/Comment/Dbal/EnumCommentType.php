<?php


namespace App\Comment\Dbal;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Class EnumType
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/cookbook/mysql-enums.html#solution-2-defining-a-type
 * https://symfony.com/doc/current/doctrine/dbal.html
 * cf. See declaration in config/packages/doctrine.yaml
 * @package App\Comment\Dbal
 */
class EnumCommentType extends Type
{
    const ENUM_COMMENT = 'enumcomment';
    const STATUS_PUBLIC = 'public';
    const STATUS_PRIVATE = 'private';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "ENUM('public', 'private')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, array(self::STATUS_PUBLIC, self::STATUS_PRIVATE))) {
            throw new \InvalidArgumentException("Invalid comment status");
        }
        return $value;
    }

    public function getName()
    {
        return self::ENUM_COMMENT;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}