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
    // const PENDING = 0;
    // const PROCESSING = 1;
    // const ON_HOLD = 2;
    // const COMPLETED = 3;
    // const CANCELLED = 4;
    // const FAILED = 5;

    // social publish
    const PUBLISHED = 1;
    const UNPUBLISH = 0;

    const COOKIE_NAME = 'smionline';


    // 0: equal, 1: Additional guests pay, 2: Guest received back
    const EQUAL = 0;
    const ADDITION_GUEST_PAY = 1;
    const GUEST_RECEIVED_BACK = 2;


    const PENDING = 0;
    const PACKED = 1;
    const DELIVERED = 2;
    const SUCCESS = 3;
    const _EXCHANGE = 4;
    const _RETURN = 5;
    const CANCEL = 6;
    const APPOINTMENT = 7;
    const WAIT = 8;
    const WAITING_RETURN = 9;
    const RETURNED = 10;
    const WAITING_EXCHANGE = 11;
    const EXCHANGING = 12;
    const CREATED_BILL = 13;
}
