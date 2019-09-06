The View Counter Bundle
========================

Welcome to the "**TchoulomViewCounterBundle**".

This bundle is used to count the number of views of a web page (the viewership).

This bundle can also be used to draw a graphical representation of statistical data of the web pages.

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/monthly-views-2018.png" alt="Monthly views in 2018" align="center" />

Features include:
--------------
    - Viewcounter
    - Statistics
Documentation:
--------------

[The ViewCounter documentation](http://tchoulom.com/fr/tutoriel/the-view-counter-bundle-1)

Installation:
-------------

### Step 1: Download TchoulomViewCounterBundle using composer

 You can install it via Composer:

  ``` bash
  $ php composer.phar update tchoulom/view-counter-bundle
  ```
   or
 ``` bash
  $ composer require tchoulom/view-counter-bundle
  ```
   or
  ``` bash
   $ composer req tchoulom/view-counter-bundle
   ```

  Check that it is recorded in the **composer.json** file
  
  ```js
  {
      "require": {
          ...
          "tchoulom/view-counter-bundle": "^3.0"
          ...
      }
  }
  ```
### Step 2: Enable the Bundle

Edit the **appKernel.php** file

```php
    ...
    $bundles = array(
	     ...
	     new Tchoulom\ViewCounterBundle\TchoulomViewCounterBundle(),
	     ...
      );
     ...
```

Usage:
------

### Step 1: Interface and Property

Suppose that you have an **Article** Entity.

This Entity must implement the **ViewCountable** interface:

```php
   use Tchoulom\ViewCounterBundle\Model\ViewCountable;
   
    ...
    class Article implements ViewCountable
    {
      ...
    }
```
Add the **$views** property and the target Entity **ViewCounter**.

The **$views** property allows to get the number of views:

```php
   use Tchoulom\ViewCounterBundle\Model\ViewCountable;
   use Entity\ViewCounter;
   use Doctrine\Common\Collections\ArrayCollection;
    ...
    class Article implements ViewCountable
    {
      ...
      /**
       * @ORM\OneToMany(targetEntity="Entity\ViewCounter", mappedBy="article")
       */
      protected $viewCounters;
          
      /**
      * @ORM\Column(name="views", type="integer", nullable=true)
      */
       protected $views = 0;
       
       /**
        * Constructor
        */
       public function __construct()
       {
           $this->viewCounters = new ArrayCollection();
       }
       
       /**
        * Sets $views
        *
        * @param integer $views
        *
        * @return $this
        */
       public function setViews($views)
       {
           $this->views = $views;
   
           return $this;
       }
   
       /**
        * Gets $views
        *
        * @return integer
        */
       public function getViews()
       {
           return $this->views;
       }
       
       /**
        * Get $viewCounters
        *
        * @return Collection
        */
       public function getViewCounters()
       {
           return $this->viewCounters;
       }
   
       /**
        * Add $viewCounter
        *
        * @param ViewCounter $viewCounter
        *
        * @return $this
        */
       public function addViewCounter(ViewCounter $viewCounter)
       {
           $this->viewCounters[] = $viewCounter;
   
           return $this;
       }
   
       /**
        * Remove $viewCounter
        *
        * @param ViewCounter $viewCounter
        */
       public function removeViewCounter(ViewCounter $viewCounter)
       {
           $this->comments->removeElement($viewCounter);
       }
      ...
    }
```

### Step 2: ViewCounter

The **ViewCounter** Entity allows to set the IP address, the **view_date**, and the **article_id**.

The **ViewCounter** Entity must extend the **BaseViewCounter**:

```php

    use Tchoulom\ViewCounterBundle\Entity\ViewCounter as BaseViewCounter;
    
    /**
     * ViewCounter.
     *
     * @ORM\Table(name="view_counter")
     * @ORM\Entity()
     */
    class ViewCounter extends BaseViewCounter
    {
        ...
    }

```

Update the doctrine relationship between the **ViewCounter** Entity and your **Article** Entity:

```php

    use Tchoulom\ViewCounterBundle\Entity\ViewCounter as BaseViewCounter;
    
    /**
     * ViewCounter.
     *
     * @ORM\Table(name="view_counter")
     * @ORM\Entity()
     */
    class ViewCounter extends BaseViewCounter
    {
        ...
        
        /**
         * @ORM\ManyToOne(targetEntity="Article", cascade={"persist"})
         * @ORM\JoinColumn(nullable=true)
         */
        private $article;
    
        /**
         * Gets article
         *
         * @return Article
         */
        public function getArticle()
        {
            return $this->article;
        }
    
        /**
         * Sets Article
         *
         * @param Article $article
         *
         * @return $this
         */
        public function setArticle(Article $article)
        {
            $this->article = $article;
    
            return $this;
        }
        
        ...
    }

```
### Step 3: Edit the configuration file

Add the following configuration

```yaml

    tchoulom_view_counter:
        view_counter:
            view_strategy: daily_view
        statistics:
            use_stats: false
            stats_file_name: stats
            stats_file_extension:

```
### The "view_counter"

The different values of ***view_strategy*** are : daily_view, unique_view, increment_each_view, hourly_view, weekly_view, monthly_view, yearly_view, view_per_minute, view_per_second.

* The **daily_view** allows to increment **daily**, for a given **IP** address, the number of views of an **Article** (the viewership).
In fact it increments the **$views** property.

* The **unique_view** allows to set to **1**, for a given **IP** address, the number of view of an article

* The **increment_each_view** allows to increment the number of views of an **Article** every time the user will refresh the page

* The **hourly_view** allows to increment **hourly**, for a given **IP** address, the number of views of an **Article** (the viewership).

* The **weekly_view** allows to increment **weekly**, for a given **IP** address, the number of views of an **Article** (the viewership).

* The **monthly_view** allows to increment **monthly**, for a given **IP** address, the number of views of an **Article** (the viewership).

* The **yearly_view** allows to increment **yearly**, for a given **IP** address, the number of views of an **Article** (the viewership).

* The **view_per_minute** allows to increment **every minute**, for a given **IP** address, the number of views of an **Article** (the viewership).

* The **view_per_second** allows to increment **every second**, for a given **IP** address, the number of views of an **Article** (the viewership).

### The "statistics"

The **use_stats** allows to indicate if you want to use statistics.

If **use_stats** is set to ***true***, statistics functionality will be used (confers the ***Step 6***).

The **stats_file_name** allows to define the name of the statistics file.

The default name of **stats_file_name** is **stats**

The **stats_file_extension** allows to define the extension of the statistics file.

**Example :**

If **stats_file_extension: txt**, then the default name of the statistics file will be ***stats.txt***

If **stats_file_extension:**, then the default name of the statistics file will be ***stats***

The full path of the statistics file is ***var/viewcounter*** of your project.

### Step 4: The Controller

2 methods are available:

**Method 1 :**

Recommendation: You can use the **Symfony kernel terminate listener** to set the Viewcounter

```php
use App\Entity\ViewCounter;
...

/**
 * Reads an existing article
 *
 * @Route("/read/{id}", name="read_article")
 * @ParamConverter("article", options={"mapping": {"id": "id"}})
 * @Method({"GET", "POST"})
 */
 public function readAction(Request $request, Article $article)
 {
    // Viewcounter
    $viewcounter = $this->get('tchoulom.viewcounter')->getViewCounter($article);
    $em = $this->getDoctrine()->getEntityManager();
    
    if ($this->get('tchoulom.viewcounter')->isNewView($viewcounter)) {
        $views = $this->get('tchoulom.viewcounter')->getViews($article);
        $viewcounter->setIp($request->getClientIp());
        $viewcounter->setArticle($article);
        $viewcounter->setViewDate(new \DateTime('now'));
    
        $article->setViews($views);
    
        $em->persist($viewcounter);
        $em->persist($article);
        $em->flush();
    }
 }
...
```

**Method 2 :**

You only need to save your **Article** Entity via the **'tchoulom.viewcounter'** service:

```php
...
/**
 * Reads an existing article
 *
 * @Route("/read/{id}", name="read_article")
 * @ParamConverter("article", options={"mapping": {"id": "id"}})
 * @Method({"GET", "POST"})
 */
public function readAction(Request $request, Article $article)
{
    // Saves the view
    $page = $this->get('tchoulom.viewcounter')->saveView($article);
}
...
```

The second method returns the current page ($article).

You can choose the method that is most appropriate for your situation.

### Step 5: The View

Finally you can display the number of views:

```twig
...
<h1>The number of views of this article :</h1> {{ article.views }}
...
```

### Step 6: Exploitation of statistical data

- Use the **StatsFinder** service to get statistics of a web page :

```php
   // The "statsFinder" service
   $statsFinder = $this->get('tchoulom.viewcounter.stats_finder');
   
   // Get all statistical data
   $contents = $statsFinder->loadContents();
   
   // Finds statistics by page
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Page
   $page = $statsFinder->findByPage($article);
    
   // Finds statistics by year (year number: 2019)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Year
   $year = $statsFinder->findByYear($article, 2019);
     
   // Finds statistics by month (month number: 1)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Month
   $month = $statsFinder->findByMonth($article, 2019, 1);
   
   // Finds statistics by week (week number: 3)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Week
   $week = $statsFinder->findByWeek($article, 2019, 1, 3);
   
   // Finds statistics by day (name of the day: 'thursday')
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Day
   $day = $statsFinder->findByDay($article, 2019, 1, 3, 'thursday');
   
   // Finds statistics by hour (time name: 'h17' => between 17:00 and 17:59)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Hour
   $hour = $statsFinder->findByHour($article, 2019, 1, 3, 'thursday', 'h17');
   
   // Finds statistics by minute (the name of the minute: 'm49' => in the 49th minute)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Minute
   $minute = $statsFinder->findByMinute($course, 2019, 1, 3, 'thursday', 'h17', 'm49');
   
   // Finds statistics by second (the name of the second: 's19' => in the 19th second)
   // Returns an instance of Tchoulom\ViewCounterBundle\Statistics\Second
   $second = $statsFinder->findBySecond($course, 2019, 1, 3, 'thursday', 'h17', 'm49', 's19');
   
    ...
```
- Get statistical data of a web page by **year**, **month**, **week**, **day** and **hour**

##### By *year*

```php
   // Get the yearly statistics
   $yearlyStats = $statsFinder->getYearlyStats($article); 
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

##### By *month*

```php
   // Get the monthly statistics in 2019
   $monthlyStats = $statsFinder->getMonthlyStats($article, 2019);
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

##### By *week*

```php
   // Get the weekly statistics of the month of August (month number 8) in 2019
   $weeklyStats = $statsFinder->getWeeklylyStats($article, 2019, 8);
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

##### By *day*

```php
   // Get the daily statistics of the week number 33 in august 2019
   $dailyStats = $statsFinder->getDailyStats($article, 2019, 8, 33);
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

#### By *hour*

```php
   // Get the hourly statistics for Thursday of the week number 33 in august 2019
   $hourlyStats = $statsFinder->getHourlyStats($article, 2019, 8, 33, 'Thursday');
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

#### By *minute*

```php
   // Get the statistics per minute on Saturday of the week number 33 in august 2019 at 15h ('h15')
   $statsPerMinute = $this->get('tchoulom.viewcounter.stats_finder')->getStatsPerMinute($article, 2019, 8, 33, 'Saturday', 'h15');
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

#### By *second*

```php
   // Get the statistics per second on Saturday of the week number 33 in august 2019 at 15H49
   $statsPerSecond = $this->get('tchoulom.viewcounter.stats_finder')->getStatsPerSecond($article, 2019, 8, 33, 'Saturday', 'h15', 'm49');
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

So you can exploit these statistical data to build a graph, as shown in the following figure:

**Statistics of monthly views in 2018**

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/monthly-views-2018.png" alt="Monthly views in 2018" align="center" />

You can also build the graph on statistics of  **daily view**, **hourly view**, **weekly view** and **yearly view** according to the data in the statistics file.


The data in the stats file represents the view statistics, as shown in the following figure:

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/statistical-data-2018.png" alt="Statistical data in 2018" align="center" />

The figure above shows that the statistical data contain 2 "viewcountable" entities: **article** and **news**.

The statistical data of the entity **article** are recorded over 12 months.

Let's zoom in on the statistics for the first week of January:

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/statistical-data-first-week-january-2018.png" alt="the statistical data of the first week of January 2018" align="center" />

Original Credits
----------------

Created by [Ernest TCHOULOM](http://tchoulom.com) for [tchoulom.com](https://tchoulom.com).

License:
--------

This bundle is released under the MIT license. See the complete license in the
bundle:

```text
LICENSE
```

Enjoy!

Need help or found a bug?
[http://www.tchoulom.com](http://www.tchoulom.com)