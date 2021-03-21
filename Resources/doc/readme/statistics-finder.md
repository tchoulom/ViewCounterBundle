## Step 7: Use of statistical data

###### Trick

For Symfony 4 or 5, inject the service you want to use, instead of going through the container: $this->get('tchoulom.viewcounter.file_stats_finder');

- Example:

```php
use Tchoulom\ViewCounterBundle\Finder\FileStatsFinder;

/**
 * @var FileStatsFinder
 */
protected $fileStatsFinder;

/**
 * @param FileStatsFinder $fileStatsFinder
 */
public function __construct(FileStatsFinder $fileStatsFinder)
{
    $this->fileStatsFinder = $fileStatsFinder;
}
```

### The *FileStatsFinder* service

Use the **FileStatsFinder** service to get statistics of a web page :

```php
   // The "fileStatsFinder" service
   $fileStatsFinder = $this->get('tchoulom.viewcounter.file_stats_finder');
   
   // Get all statistical data
   $contents = $fileStatsFinder->loadContents();
   
   // Finds statistics by page
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Page
   $page = $fileStatsFinder->findByPage($article);
    
   // Finds statistics by year (year number: 2019)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Year
   $year = $fileStatsFinder->findByYear($article, 2019);
     
   // Finds statistics by month (month number: 1)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Month
   $month = $fileStatsFinder->findByMonth($article, 2019, 1);
   
   // Finds statistics by week (week number: 3)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Week
   $week = $fileStatsFinder->findByWeek($article, 2019, 1, 3);
   
   // Finds statistics by day (name of the day: 'thursday')
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Day
   $day = $fileStatsFinder->findByDay($article, 2019, 1, 3, 'thursday');
   
   // Finds statistics by hour (time name: 'h17' => between 17:00 and 17:59)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Hour
   $hour = $fileStatsFinder->findByHour($article, 2019, 1, 3, 'thursday', 'h17');
   
   // Finds statistics by minute (the name of the minute: 'm49' => in the 49th minute)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Minute
   $minute = $fileStatsFinder->findByMinute($article, 2019, 1, 3, 'thursday', 'h17', 'm49');
   
   // Finds statistics by second (the name of the second: 's19' => in the 19th second)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Second
   $second = $fileStatsFinder->findBySecond($article, 2019, 1, 3, 'thursday', 'h17', 'm49', 's19');
   
```

You can also get statistical data of a web page by **year**, **month**, **week**, **day**, **hour**, **minute** and **second**

#### Get the *yearly* statistics

```php
   // Get the yearly statistics
   $yearlyStats = $fileStatsFinder->getYearlyStats($article); 
```

Result:
```php
   [
      [2019,98537215], [2018,95548144], [2017,47882376]
   ]
```

In 2019, there were 98537215 views.

In 2018, there were 95548144 views.

In 2017, there were 47882376 views.

#### Get the *monthly* statistics

```php
   // Get the monthly statistics in 2019
   $monthlyStats = $fileStatsFinder->getMonthlyStats($article, 2019);
```

Result:
```php
   [
      [8,951224], [7,921548], [6,845479]
   ]
```

In the month of August (month number 8) 2019, there were 951224 views.

In the month of July (month number 7) 2019, there were 921548 views.

In the month of June (month number 6) 2019, there were 845479 views.

#### Get the *weekly* statistics

```php
   // Get the weekly statistics of the month of August (month number 8) in 2019
   $weeklyStats = $fileStatsFinder->getWeeklylyStats($article, 2019, 8);
```

Result:
```php
   [
      [34,494214], [33,117649], [32,183254]
   ]
```

In the week number 34 in august (month number 8) 2019, there were 494214 views.

In the week number 33 in august 2019, there were 117649 views.

In the week number 32 in august 2019, there were 183254 views.

#### Get the *daily* statistics

```php
   // Get the daily statistics of the week number 33 in august 2019
   $dailyStats = $fileStatsFinder->getDailyStats($article, 2019, 8, 33);
```

Result:
```php
   [
      ['Monday',16810],['Tuesday',16804],['Wednesday',16807],['Thursday',16807],['Friday',16807],['Saturday',16807],['Sunday',16807]
   ]
```

On Monday of the week number 33 in august (month number 8) 2019, there were 16810 views.

On Tuesday of the week number 33 in august 2019, there were 16804 views.

On Wednesday of the week number 33 in august 2019, there were 16807 views.

...

#### Get the *hourly* statistics

```php
   // Get the hourly statistics for Thursday of the week number 33 in august 2019
   $hourlyStats = $fileStatsFinder->getHourlyStats($article, 2019, 8, 33, 'Thursday');
```

Result:
```php
   [
      ['00',650],['01',750],['02',500],['03',900],['04',700],['05',700],['06',700],['07',700],['08',700],['09',700],['10',700],['11',720],['12',680],['13',700],['14',200],['15',1200],['16',700],['17',700],['18',700],['19',700],['20',100],['21',1300],['22',700],['23',700]
   ]
```

On Thursday of the week number 33 of August (month number 8) 2019:

* At midnight, there were 650 views.

* At 1 hour, there were 750 views.

* At 2 hour, there were 500 views.

* At 3 hour, there were 900 views.

* ...

#### Get the statistics *per minute*

```php
   // Get the statistics per minute on Saturday of the week number 33 in august 2019 at 15h ('h15')
   $statsPerMinute = $this->get('tchoulom.viewcounter.file_stats_finder')->getStatsPerMinute($article, 2019, 8, 33, 'Saturday', 'h15');
```

Result:
```php
   [
      ['00',650],['01',740],['02',520],['03',752],['04',700],['05',700],['06',400],['07',400],['08',800],['09',700],['10',700],['11',720],['12',680],['13',700],['14',200],['15',100],['16',105],['17',700],['18',700],['19',700],['20',100],['21',130],['22',700],['23',700],['24',110],['25',210],['26',110],['27',10],['28',110],['29',10],['30',141],['31',148],['32',181],['33',141],['34',141],['35',171],['36',141],['37',181],['38',141],['39',141],['40',191],['41',193],['42',194],['43',194],['44',191],['45',191],['46',148],['47',191],['48',191],['49',191],['50',191],['51',151],['52',131],['53',191],['54',171],['55',191],['56',111],['57',191],['58',254],['59',91]
   ]
```

On Saturday  of the week number 33 of August (month number 8) 2019 at 15h ('h15') :

* At the minute 0, there were 650 views.

* At the minute 1, there were 740 views.

* At the minute 2, there were 520 views.

* At the minute 3, there were 752 views.

* ...

#### Get the statistics *per second*

```php
   // Get the statistics per second on Saturday of the week number 33 in august 2019 at 15H49
   $statsPerSecond = $this->get('tchoulom.viewcounter.file_stats_finder')->getStatsPerSecond($article, 2019, 8, 33, 'Saturday', 'h15', 'm49');
```

Result:
```php
   [
      ['00',60],['01',40],['02',21],['03',72],['04',70],['05',70],['06',50],['07',20],['08',80],['09',70],['10',70],['11',72],['12',68],['13',70],['14',20],['15',10],['16',15],['17',70],['18',70],['19',70],['20',10],['21',13],['22',70],['23',7],['24',11],['25',21],['26',11],['27',10],['28',110],['29',10],['30',14],['31',14],['32',18],['33',14],['34',14],['35',17],['36',14],['37',18],['38',14],['39',14],['40',19],['41',19],['42',19],['43',19],['44',19],['45',19],['46',18],['47',19],['48',19],['49',19],['50',19],['51',15],['52',13],['53',19],['54',17],['55',19],['56',11],['57',19],['58',25],['59',71]
   ]
```

On Saturday  of the week number 33 of August (month number 8) 2019 at 15H49:

* At the second 0, there were 60 views.

* At the second 1, there were 40 views.

* At the second 2, there were 21 views.

* At the second 3, there were 72 views.

* ...


The data in the stats file represents the view statistics, as shown in the following figure:

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/statistical-data-2018.png" alt="Statistical data in 2018" align="center" />

The figure above shows that the statistical data contain 2 "viewcountable" entities: **article** and **news**.

The statistical data of the entity **article** are recorded over 12 months.

Let's zoom in on the statistics for the first week of January:

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/statistical-data-first-week-january-2018.png" alt="the statistical data of the first week of January 2018" align="center" />

#### Search for geolocation data

- ##### Observation

The geolocation data of visitors to your web pages may look like the following figure:

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/geolocation-data.png" alt="the geolocation data" align="center" />

The figure above shows that visitors have viewed the web page (with the identifier ***3***) from ***4*** countries: United States, France, United Kingdom and Ireland.

Let's zoom in on the country "United States" in order to visualize the geolocation data it contains:

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/geolocation-data-washington.png" alt="the geolocation data washington" align="center" />

There are ***5*** views from the ***United States*** including ***4*** in the town of ***Washington*** located in the ***District of Columbia*** region.

These ***5*** views are spread over 2 regions: ***District of Columbia*** and ***New York***.

View date data can also be used:

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/geolocation-view-date.png" alt="the geolocation view date" align="center" />

- ##### Search:

###### Gets country stats

```php
$countryStats = $this->statFinder->getCountryStats($article);
```

Result:
```php
   [
      ["France", 6],["United States", 45],["Ireland", 8],["United Kingdom", 8]
   ]
```

* There are 6 views in France.
* There are 45 views in United States.
* ...

###### Gets region stats

```php
$regionStats = $this->statFinder->getRegionStats($article);
```

Result:
```php
   [
      ["Île-de-France", 3],["Normandy", 3],["District of Columbia", 44],["New York", 1],["Leinster", 8],["England", 2]
   ]
```

* There are 3 views in Île-de-France.
* There are 3 views in Normandy.
* There are 44 views in District of Columbia.
* ...

###### Gets city stats

```php
$cityStats = $this->statFinder->getCityStats($article);
```

Result:
```php
   [
      ["Paris", 3],["Rouen", 3],["Washington", 44],["Buffalo", 1],["Dublin", 8],["London", 2]
   ]
```

* There are 3 views in Paris.
* There are 3 views in Rouen.
* There are 44 views in Washington.
* ...

###### Gets stats by country

```php
$statsByCountry = $this->statFinder->getStatsByCountry($article, 'United States');
```

Result:
```php
  45
```

* There are 45 views in the "united states" country.

###### Gets stats by region

```php
$statsByRegion = $this->statFinder->getStatsByRegion($article, 'United States', 'District of Columbia');
```

Result:
```php
  44
```

* There are 44 views in the "District of Columbia" region.

###### Gets stats by city

```php
$statsByCity = $this->statFinder->getStatsByCity($article, 'United States', 'District of Columbia', 'Washington');
```

Result:
```php
  44
```

* There are 44 views in the "Washington" city.

The **FileStatsFinder** service provides other functions that you can browse.
