<?php

namespace TLB\Dummy\Calendar;

enum TimeUnit: string
{
    case MICROSECONDS = 'microseconds';
    case MILLISECONDS = 'milliseconds';
    case SECOND = 'second';
    case SECONDS = 'seconds';
    case MINUTE = 'minute';
    case MINUTES = 'minutes';
    case HOUR = 'hour';
    case HOURS = 'hours';
    case DAY = 'day';
    case DAYS = 'days';
    case WEEK = 'week';
    case WEEKS = 'weeks';
    case MONTH = 'month';
    case MONTHS = 'months';
    case YEAR = 'year';
    case YEARS = 'years';
    case FORTNIGHTS = 'fortnights';
    case FORTNIGHT = 'fortnight';
}
