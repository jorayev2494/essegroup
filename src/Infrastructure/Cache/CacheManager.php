<?php

namespace Project\Infrastructure\Cache;

use Illuminate\Cache\Repository;
use Project\Infrastructure\Cache\Contracts\CacheManagerInterface;

class CacheManager extends Repository implements CacheManagerInterface
{

}
