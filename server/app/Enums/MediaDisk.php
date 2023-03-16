<?php

namespace App\Enums;

enum MediaDisk: string
{
    case test = 'test';
    case s3 = 's3';
    case temporaryS3 = 's3-tmp';
    case public = 'public';
}
