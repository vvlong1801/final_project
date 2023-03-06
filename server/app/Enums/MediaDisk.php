<?php

namespace App\Enums;

use App\Enums\Traits\Helper;

enum MediaDisk: string
{
    use Helper;
    case test = 'test';
    case s3 = 's3';
    case temporaryS3 = 's3-tmp';
    case public = 'public';
}
