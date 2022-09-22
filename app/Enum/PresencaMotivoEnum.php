<?php

namespace App\Enum;

enum PresencaMotivoEnum: string
{
    case FALTA = 'FALTA';
    case HOSPITAL = 'HOSPITAL';
    case M_SERVIÇO = 'M/SERVIÇO';
    case FERIAS = 'FERIAS';
    case DISPENSA =  'DISPENSA';
    case DOENTES =  'DOENTES';
    case TRANSFERENCIA = 'TRANSFERENCIA';
    case DETIDOS = 'DETIDOS';
    case CURSO = 'CURSO';
    case NENHUM = 'NENHUM';
}
