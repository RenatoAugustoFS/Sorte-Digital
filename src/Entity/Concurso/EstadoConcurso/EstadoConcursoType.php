<?php

namespace App\Entity\Concurso\EstadoConcurso;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EstadoConcursoType extends Type
{
    const ENUM_ESTADOCONCURSO = 'enumestadoconcurso';
    const ESTADO_ABERTO = 'aberto';
    const ESTADO_EMANDAMENTO = 'emandamento';
    const ESTADO_FECHADO = 'fechado';


    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return "ENUM('" . self::ESTADO_ABERTO . "', '" . self::ESTADO_EMANDAMENTO . "', '" . self::ESTADO_FECHADO . "') COMMENT '(DC2Type:" . self::ENUM_ESTADOCONCURSO  . ")'";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === Aberto::ESTADO){
            return new Aberto();
        }

        if ($value === EmAndamento::ESTADO){
            return new EmAndamento();
        }

        if ($value === Fechado::ESTADO){
            return new Fechado();
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, array(self::ESTADO_ABERTO, self::ESTADO_EMANDAMENTO, self::ESTADO_FECHADO))) {
            throw new \InvalidArgumentException("Estado Inválido");
        }

        return $value;
    }

    public function getName()
    {
        return self::ENUM_ESTADOCONCURSO;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}