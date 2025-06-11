<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class LevelEnum extends Enum
{
    const Beginner = 0;
    const Intermediate = 1;
    const Advanced = 2;
}
