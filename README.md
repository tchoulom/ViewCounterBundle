The View Counter Bundle
========================

Welcome to the "**TchoulomViewCounterBundle**".

This bundle is used to count the number of views of web pages (the viewership).

This bundle can also be used to draw a graphical representation of statistical data of the web pages.

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/monthly-views-2018.png" alt="Monthly views in 2018" align="center" />

**Table of contents**

- [Features include](#features-include)
- [Documentation](#documentation)
- [Installation](Resources/doc/readme/installation.md#installation)
  - [Step 1: Download TchoulomViewCounterBundle using composer](Resources/doc/readme/installation.md#step-1-download-tchoulomviewcounterbundle-using-composer)
  - [Step 2: Enable the Bundle](Resources/doc/readme/installation.md#step-2-enable-the-bundle)
- [Usage](Resources/doc/readme/usage-step-1-5.md#usage)
  - [Step 1: Interface and Property](Resources/doc/readme/usage-step-1-5.md#step-1-interface-and-property)
  - [Step 2: ViewCounter](Resources/doc/readme/usage-step-1-5.md#step-2-viewcounter)
  - [Step 3: Configuration](Resources/doc/readme/usage-step-1-5.md#step-3-configuration)
    - [The "view_counter"](Resources/doc/readme/usage-step-1-5.md#the-view_counter)
    - [The "statistics"](Resources/doc/readme/usage-step-1-5.md#the-statistics)
  - [Step 4: The Controller](Resources/doc/readme/usage-step-1-5.md#step-4-the-controller)
    - [Method 1](Resources/doc/readme/usage-step-1-5.md#method-1)
    - [Method 2](Resources/doc/readme/usage-step-1-5.md#method-2)
  - [Step 5: The View](Resources/doc/readme/usage-step-1-5.md#step-5-the-view)
  - [Step 6: The Geolocation](Resources/doc/readme/geolocation.md#step-6-the-geolocation)
  - [Step 7: Use of statistical data](Resources/doc/readme/statistics-finder.md#step-7-use-of-statistical-data)
    - [The *StatsFinder* service](Resources/doc/readme/statistics-finder.md#the-statsfinder-service)
      - [Get the *yearly* statistics](Resources/doc/readme/statistics-finder.md#get-the-yearly-statistics)
      - [Get the *monthly* statistics](Resources/doc/readme/statistics-finder.md#get-the-monthly-statistics)
      - [Get the *weekly* statistics](Resources/doc/readme/statistics-finder.md#get-the-weekly-statistics)
      - [Get the *daily* statistics](Resources/doc/readme/statistics-finder.md#get-the-daily-statistics)
      - [Get the *hourly* statistics](Resources/doc/readme/statistics-finder.md#get-the-hourly-statistics)
      - [Get the statistics *per minute*](Resources/doc/readme/statistics-finder.md#get-the-statistics-per-minute)
      - [Get the statistics *per second*](Resources/doc/readme/statistics-finder.md#get-the-statistics-per-second)
      - [Search for geolocation data](Resources/doc/readme/statistics-finder.md#search-for-geolocation-data)
    - [Build a graph with "Google Charts"](Resources/doc/readme/graph-google-charts.md#build-a-graph-with-google-charts)
    - [The *StatsComputer* service](Resources/doc/readme/statistics-computer.md#the-statscomputer-service)
      - [Calculates the *min value*](Resources/doc/readme/statistics-computer.md#calculates-the-min-value)
      - [Calculates the *max value*](Resources/doc/readme/statistics-computer.md#calculates-the-max-value)
      - [Calculates the *average*](Resources/doc/readme/statistics-computer.md#calculates-the-average)
      - [Calculates the *range*](Resources/doc/readme/statistics-computer.md#calculates-the-range)
      - [Calculates the *mode*](Resources/doc/readme/statistics-computer.md#calculates-the-mode)
      - [Calculates the *median*](Resources/doc/readme/statistics-computer.md#calculates-the-median)
      - [Count the number of values ​​in the statistical series](Resources/doc/readme/statistics-computer.md#count-the-number-of-values-in-the-statistical-series)
 - [Tools](Resources/doc/readme/tools-command-cleanup.md#tools)
   - [Command](Resources/doc/readme/tools-command-cleanup.md#command)
     - [Cleanup ViewCounter data](Resources/doc/readme/tools-command-cleanup.md#cleanup-viewcounter-data)
     - [Converts ViewCounter entities to statistical data](Resources/doc/readme/tools-command-stats-converter.md#converts-viewcounter-entities-to-statistical-data)
- [Original Credits](#original-credits)
- [License](#license)

# Features include

    - Viewcounter
    - Statistics
    - Geolocation

# Documentation

[The ViewCounter documentation](http://tchoulom.com/fr/tutoriel/the-view-counter-bundle-1)

# Original Credits

Created by [Ernest TCHOULOM](http://tchoulom.com) for [tchoulom.com](https://tchoulom.com).

# License

This bundle is released under the MIT license. See the complete license in the
bundle:

```text
LICENSE
```

Enjoy!

Need help or found a bug?
[http://www.tchoulom.com](http://www.tchoulom.com)