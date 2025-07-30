<?php
namespace Yebto\TransliteratorAPI\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array transliterate(string $lang, string $text, string $type = 'plain', string $delimiter = '-')
 */
class TransliteratorAPI extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'transliteratorapi';
    }
}
