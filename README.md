The View Counter Bundle
========================

Welcome to the "**TchoulomViewCounterBundle**".

This bundle is used to count the number of views of a page (the viewership).

Features include:
--------------

Documentation:
--------------

[The ViewCounter documentation](https://tchoulom.com/fr/tutoriel/the-view-counter-bundle-1)

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
          "tchoulom/view-counter-bundle": "^2.0"
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
       * @ORM\OneToMany(targetEntity="ViewCounter", mappedBy="article")
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
The **ViewCounter** Entity allows to set the **ip** address, the **view_date**, and the **article_id**.

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

Edit The **ViewCounter** Entity with your **Article** Entity:

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
        view_interval:
            daily_view: 1
    #       unique_view: 1
    #       hourly_view: 1
    #       weekly_view: 1
    #       monthly_view: 1

```
* The **unique_view** allows to set to **1**, for a given **IP**, the number of view of an article

* The **daily_view** allows to increment **daily** for each **IP** the number of views of an **Article** (the viewership).
In fact it increments the **$views** property.

* The **hourly_view**, **weekly_view**, **monthly_view** features are not yet implemented.

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
    $views = $this->get('tchoulom.view_counter')->getViews($article);
    $viewcounter = $this->get('tchoulom.view_counter')->getViewCounter($article);
    $viewcounter = (null != $viewcounter ? $viewcounter : new ViewCounter());
    
    $em = $this->getDoctrine()->getEntityManager();
    
    if ($this->get('tchoulom.view_counter')->isNewView($viewcounter)) {
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

You only need to save your **Article** Entity via the **'tchoulom.view_counter'** service:

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
    $page = $this->get('tchoulom.view_counter')->saveView($article);
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

Original Credits
----------------

Created by [Ernest TCHOULOM](https://tchoulom.com) for [tchoulom.com](https://tchoulom.com).

License:
--------

This bundle is released under the MIT license. See the complete license in the
bundle:

```text
LICENSE
```

Enjoy!

Need help or found a bug?
[https://www.tchoulom.com](https://www.tchoulom.com)