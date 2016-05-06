<?php
/**
 * Copyright (c) 2016 Kerem Güneş
 *     <k-gun@mail.com>
 *
 * GNU General Public License v3.0
 *     <http://www.gnu.org/licenses/gpl-3.0.txt>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace Froq\Encryption;

/**
 * @package    Froq
 * @subpackage Froq\Encryption
 * @object     Froq\Encryption\Salt
 * @author     Kerem Güneş <k-gun@mail.com>
 */
abstract class Salt
{
    /**
     * Salt length.
     * @const int
     */
    const LENGTH = 128;

    /**
     * Generate a salt.
     * @param  int $type
     * @param  int $length
     * @return string
     */
    final public static function generate(int $length = self::LENGTH, bool $crop = true): string
    {
        $salt = base64_encode(random_bytes($length));
        if ($crop) {
            $salt = substr($salt, 0, $length);
        }

        return $salt;
    }
}
