<?php

namespace Vinnige\Events;

/**
 * Class VinnigeEvents
 * @package Vinning\Events
 */
class VinnigeEvents
{
    const AFTER_MIDDLEWARE = 'after.middleware';

    const BEFORE_MIDDLEWARE = 'before.middleware';

    const BEFORE_DISPATCH_ROUTE = 'before.dispatch.route';

    const BEFORE_ROUTE = 'before.route';

    const BEFORE_RUN_SERVER = 'before.run.server';

    const ON_ERROR = 'on.error';
}
