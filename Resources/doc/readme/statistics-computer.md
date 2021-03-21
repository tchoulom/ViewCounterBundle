### The *StatsComputer* service

Use the **StatsComputer** service to calculate the min value, max value, average value, range value, mode value, median value and the number of occurrences of the statistics :

First of all, get the stats computer service

```php
   $statsComputer = $this->get('tchoulom.viewcounter.stats_computer');
```

The functions of the **statsComputer** service can take as argument the *$yearlyStats*, *$monthlyStats*, *$weeklyStats*, *$daylyStats*, *$hourlyStats*, *$statsPerMinute*, and *$statsPerSecond*

#### Calculates the *min value*

```php
   // Get the min value of the yearly statistics
   $minValue = $statsComputer->computeMinValue($yearlyStats);
```

Result:
```php
    [2017,47882376]
```

#### Calculates the *max value*

```php
   // Get the max value of the monthly statistics
   $maxValue = $statsComputer->computeMaxValue($monthlyStats);
```

Result:
```php
    [8,951224]
```

#### Calculates the *average*

The **average** is the sum of the values ​​of the statistical series divided by the number of values.

```php
   // Get the average of the weekly statistics
   $average = $statsComputer->computeAverage($weeklyStats);
```

Result:
```php
    265039
```

#### Calculates the *range*

The **range** is the difference between the highest number and the lowest number.

```php
   // Get the range of the daily statistics
   $range = $statsComputer->computeRange($dailyStats);
```

Result:
```php
    6
```

#### Calculates the *mode*

The **mode** is the number that is in the array the most times.

```php
   // Get the mode of the hourly statistics
   $mode = $statsComputer->computeMode($hourlyStats);
```

Result:
```php
    700
```

#### Calculates the *median*

The **median** is the middle value after the numbers are sorted smallest to largest.

```php
   // Get the median of the statistics per minute
   $median = $statsComputer->computeMedian($statsPerMinute);
```

Result:
```php
    75.5
```

#### Count the number of values ​​in the statistical series

```php
   // Get the count of the statistics per second
   $count = $statsComputer->count($statsPerSecond);
```

Result:
```php
    60
```
