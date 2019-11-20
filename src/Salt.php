<?php
/**
 * MIT License <https://opensource.org/licenses/mit>
 *
 * Copyright (c) 2015 Kerem Güneş
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
declare(strict_types=1);

namespace froq\encryption;

/**
 * Salt.
 * @package froq\encryption
 * @object  froq\encryption\Salt
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   3.0
 * @static
 */
final class Salt
{
    /**
     * Length.
     * @const int
     */
    public const LENGTH = 128;

    /**
     * Characters.
     * @const string
     */
    public const CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+/';

    /**
     * Generate.
     * @param  int|null $length
     * @param  int|null $bitsPerChar
     * @param  bool     $translate
     * @return string
     */
    public static function generate(int $length = null, int $bitsPerChar = null,
        bool $translate = false): string
    {
        $len = $length ?? self::LENGTH; // Output length.
        $bpc = $bitsPerChar ?? 6;       // 4=hex chars, 5=base36 chars, 6=base64 chars.

        $bytes = random_bytes((int) ceil($len * $bpc / 8));

        // Original source https://github.com/php/php-src/blob/master/ext/session/session.c#L267,#L326.
        $p = 0; $q = strlen($bytes);
        $w = 0; $have = 0; $mask = (1 << $bpc) - 1;
        $out = '';

        while ($len--) {
            if ($have < $bpc) {
                if ($p < $q) {
                    $byte = ord($bytes[$p++]);
                    $w |= ($byte << $have);
                    $have += 8;
                } else {
                    break;
                }
            }
            $out .= self::CHARACTERS[$w & $mask];
            $w >>= $bpc;
            $have -= $bpc;
        }

        if ($translate) {
            $out = strtr($out, '+/', '-_');
        }

        return $out;
    }
}
