<?php

namespace App\Service;

enum OtpCharset
{
    case NUMBER;
    case ALPHA;
    case ALPHA_LC;
    case ALPHA_UC;
}
