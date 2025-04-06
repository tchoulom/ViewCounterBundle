# Usage

## Step 1: Interface and Property

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
      * @var integer
      * @ORM\Column(name="id", type="integer")
      * @ORM\Id
      * @ORM\GeneratedValue(strategy="AUTO")
      */
     protected $id;

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
        * Gets id
        *
        * @return integer
        */
        public function getId()
        {
            return $this->id;
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
           $this->viewCounters->removeElement($viewCounter);
       }
      ...
    }
```

## Step 2: ViewCounter

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
    use Tchoulom\ViewCounterBundle\Model\ViewCountable;
    use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
    
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
         * @ORM\ManyToOne(targetEntity="Article", cascade={"persist"}, inversedBy="viewCounters")
         * @ORM\JoinColumn(nullable=true)
         */
        private $article;
       
      // Example of another relation to ViewCounter entity 
//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Product", cascade={"persist"})
//     * @ORM\JoinColumn(nullable=true)
//     */
//    private $product;
    
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
## Step 3: Configuration

###### For symfony version >=4 :
 - Create the file **config/packages/tchoulom_viewcounter.yaml**
 - Add the following viewcounter configuration in the **tchoulom_viewcounter.yaml** file.

###### For version of symfony version lower than 4 :
 - Add the following viewcounter configuration in the **app/config.yml** file.

##### viewcounter configuration:

```yaml

    tchoulom_view_counter:
        view_counter:
            view_strategy: daily_view
        statistics:
            enabled: false
            stats_file_name: stats
            stats_file_extension:
        storage:
            engine: filesystem # filesystem or mongodb or a custom service
        geolocation:
            geolocator_id: App\Service\Geolocator
```
### The "view_counter"

The different values of ***view_strategy*** are : daily_view, unique_view, on_refresh, hourly_view, weekly_view, monthly_view, yearly_view, view_per_minute, view_per_second.

* The **daily_view** allows to increment **daily**, for a given **IP** address, the number of views of an **Article** (the viewership).
In fact it increments the **$views** property.

* The **unique_view** allows to set to **1**, for a given **IP** address, the number of view of an article

* The **on_refresh** allows to increment the number of views of an **Article** each time the user refreshes the page

* The **hourly_view** allows to increment **hourly**, for a given **IP** address, the number of views of an **Article** (the viewership).

* The **weekly_view** allows to increment **weekly**, for a given **IP** address, the number of views of an **Article** (the viewership).

* The **monthly_view** allows to increment **monthly**, for a given **IP** address, the number of views of an **Article** (the viewership).

* The **yearly_view** allows to increment **yearly**, for a given **IP** address, the number of views of an **Article** (the viewership).

* The **view_per_minute** allows to increment **every minute**, for a given **IP** address, the number of views of an **Article** (the viewership).

* The **view_per_second** allows to increment **every second**, for a given **IP** address, the number of views of an **Article** (the viewership).

### The "statistics"

The **enabled** allows to indicate if you want to use statistics.

If **enabled** is set to ***true***, statistics functionality will be used.

The **stats_file_name** allows to define the name of the statistics file.

The default name of **stats_file_name** is **stats**

The **stats_file_extension** allows to define the extension of the statistics file.

**Example :**

If **stats_file_extension: txt**, then the default name of the statistics file will be ***stats.txt***

If **stats_file_extension:**, then the default name of the statistics file will be ***stats***

The full path of the statistics file is ***var/viewcounter*** of your project.

### The "storage"

The Storage defines the service that will allow to store the statistical data.

The **filesystem** engine allows to save the statistical data in a file.

The **mongodb** engine allows to save the statistical data in a mongodb database.

**filesystem :**

```yaml

    tchoulom_view_counter:
        ...
        storage:
            engine: filesystem
```

**mongodb :**

You can choose to save your statistical data in a database such as **mongodb** :

```yaml

    tchoulom_view_counter:
        ...
        storage:
            engine: mongodb
```

If you want to save your statistical data in a mongodb database, you just need to:
   - install a mongodb server
   - [install the doctrine/mongodb-odm-bundle bundle](https://packagist.org/packages/doctrine/mongodb-odm-bundle)
   - [edit the access configuration file to this database](https://symfony.com/doc/current/bundles/DoctrineMongoDBBundle/config.html)

So your statistical data will be saved in the mongodb database.

**A custom service :**

You can also set a custom storage service:

```yaml

    tchoulom_view_counter:
        ...
        storage:
            engine: App\Service\Storer
```

The storage service must implement the interface "Tchoulom\ViewCounterBundle\Adapter\Storage\StorageAdapterInterface".

If **enabled** is **true** and no storage engine is defined, then the default storage service used will be **filesystem**.

### The "geolocation"

The Geolocation defines a service which will allow you to geolocate page visits.

The **geolocator_id** corresponds to the **identifier** or the **name of the class** of your geolocation service, depending on the version of symfony used:

```yaml

    tchoulom_view_counter:
        ...
        geolocation:
            geolocator_id: app.service.geolocator
```
or

```yaml

    tchoulom_view_counter:
        ...
        geolocation:
            geolocator_id: App\Service\Geolocator
```

if your service is declared as such:

```yaml
    app.service.geolocator:
        class: App\Service\Geolocator
```
You must then set up your "Geolocator" service as we will see in this documentation [Step 6: The Geolocation](geolocation.md#step-6-the-geolocation).

###### You must comment on the geolocation configuration if you do not want to use it in your project:

```yaml

    tchoulom_view_counter:
        ...
        # geolocation:
        #    geolocator_id: app.service.geolocator
```

## Step 4: The Controller

2 methods are available:

### Method 1

```php
use App\Entity\ViewCounter;
use Tchoulom\ViewCounterBundle\Counter\ViewCounter as Counter;
...

// For Symfony version >= 4, inject the ViewCounter service

/**
 * @var Counter
 */
protected $viewcounter;

/**
 * @param Counter $viewCounter
 */
public function __construct(Counter $viewCounter)
{
    $this->viewcounter = $viewCounter;
}

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
    // For Symfony version >= 4
    $viewcounter = $this->viewcounter->getViewCounter($article);
    
    $em = $this->getDoctrine()->getEntityManager();
    
    if ($this->viewcounter->isNewView($viewcounter)) {
        $views = $this->viewcounter->getViews($article);
        $viewcounter->setIp($request->getClientIp());
        $viewcounter->setArticle($article);
        $viewcounter->setViewDate(new \DateTime('now'));
    
        $article->setViews($views);
    
        $em->persist($viewcounter);
        $em->persist($article);
        $em->flush();
        ...
    }
 }
...
```

### Method 2

You only need to save your **Article** Entity via the **'tchoulom.viewcounter'** service:

```php
...

use Tchoulom\ViewCounterBundle\Counter\ViewCounter as Counter;

// For Symfony version >= 4, inject the ViewCounter service

/**
 * @var Counter
 */
protected $viewcounter;

/**
 * @param Counter $viewCounter
 */
public function __construct(Counter $viewCounter)
{
    $this->viewcounter = $viewCounter;
}

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
    
    // For Symfony version >= 4
    $page = $this->viewcounter->saveView($article);
    ...
}
```

The second method returns the current page ($article).

You can choose the method that is most appropriate for your situation.

## Step 5: The View

Finally you can display the number of views:

```twig
...
<h1>The number of views of this article :</h1> {{ article.views }}
...
```
