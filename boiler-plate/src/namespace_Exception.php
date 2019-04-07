<?php namespace ${namespace};
/**
 * Please see the included LICENSE.txt with this source code. If no
 * LICENSE.txt was provided, then all rights for the source code in
 * this file are reserved by Khalifah Khalil Shabazz
 */

use Kshabazz\Slib\SlibException;

/**
 * Class ${namespace}Exception
 *
 * @package \Suh
 */
class ${namespace}Exception extends SlibException
{
    /**
     * Generic error code.
     */
    const NO_ACCOUNT = 1;

    const NO_TITLE = 2;

    const BAD_ACCOUNT = 2;

    /**
     * List of error codes and their corresponding messages.
     *
     * @var array
     */
    protected static $errorMap = [
        self::NO_ACCOUNT => 'Tried to perform an operation which requires an account; but an empty account ID was used. %s',
        self::NO_TITLE => 'Cannot add a work with an empty Title. %s',
        self::BAD_ACCOUNT => 'An attempt was made to set a bad account: %s',
    ];
}
