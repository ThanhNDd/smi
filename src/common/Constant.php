<?php


class Constant
{
    // Type of Order
    const SHOP = 0;
    const ONLINE = 1;
    const EXCHANGE = 2;
    const WEBSITE = 3;

    // status of Order
  //  0: pending, 1: processing, 2: on-hold, 3: completed, 4: cancelled, 5: failed
    const PENDING = 0;
    const PROCESSING = 1;
    const ON_HOLD = 2;
    const COMPLETED = 3;
    const CANCELLED = 4;
    const FAILED = 5;

    // social publish
    const PUBLISHED = 1;
    const UNPUBLISH = 0;

    const COOKIE_NAME = 'smisession';
}
