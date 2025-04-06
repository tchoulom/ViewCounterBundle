# The View Counter Bundle

Welcome to the "**TchoulomViewCounterBundle**".

This bundle is used to count the number of views of web pages (the viewership).

This bundle can also be used to draw a graphical representation of statistical data of the web pages.

## Dev

composer config repositories.view_counter '{"type": "path", "url": "/home/tac/g/tacman/ViewCounterBundle"}'
composer req tchoulom/view-counter-bundle:dev-tac

        "view_counter_bundle": {
            "type": "vcs",
            "url": "git@github.com:tacman/ViewCounterBundle.git"
        },


<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/doc/images/monthly-views-2018.png" alt="Monthly views in 2018" align="center" />

**Table of contents**

- [Features include](#features-include)
- [Documentation](#documentation)
- [Installation](doc/readme/installation.md#installation)
  - [Step 1: Download TchoulomViewCounterBundle using composer](doc/readme/installation.md#step-1-download-tchoulomviewcounterbundle-using-composer)
  - [Step 2: Enable the Bundle](doc/readme/installation.md#step-2-enable-the-bundle)
- [Usage](doc/readme/usage-step-1-5.md#usage)
  - [Step 1: Interface and Property](doc/readme/usage-step-1-5.md#step-1-interface-and-property)
  - [Step 2: ViewCounter](doc/readme/usage-step-1-5.md#step-2-viewcounter)
  - [Step 3: Configuration](doc/readme/usage-step-1-5.md#step-3-configuration)
    - [The "view_counter"](doc/readme/usage-step-1-5.md#the-view_counter)
    - [The "statistics"](doc/readme/usage-step-1-5.md#the-statistics)
  - [Step 4: The Controller](doc/readme/usage-step-1-5.md#step-4-the-controller)
    - [Method 1](doc/readme/usage-step-1-5.md#method-1)
    - [Method 2](doc/readme/usage-step-1-5.md#method-2)
  - [Step 5: The View](doc/readme/usage-step-1-5.md#step-5-the-view)
  - [Step 6: The Geolocation](doc/readme/geolocation.md#step-6-the-geolocation)
  - [Step 7: Use of statistical data](doc/readme/statistics-finder.md#step-7-use-of-statistical-data)
    - [The *FileStatsFinder* service](doc/readme/statistics-finder.md#the-filestatsfinder-service)
      - [Get the *yearly* statistics](doc/readme/statistics-finder.md#get-the-yearly-statistics)
      - [Get the *monthly* statistics](doc/readme/statistics-finder.md#get-the-monthly-statistics)
      - [Get the *weekly* statistics](doc/readme/statistics-finder.md#get-the-weekly-statistics)
      - [Get the *daily* statistics](doc/readme/statistics-finder.md#get-the-daily-statistics)
      - [Get the *hourly* statistics](doc/readme/statistics-finder.md#get-the-hourly-statistics)
      - [Get the statistics *per minute*](doc/readme/statistics-finder.md#get-the-statistics-per-minute)
      - [Get the statistics *per second*](doc/readme/statistics-finder.md#get-the-statistics-per-second)
      - [Search for geolocation data](doc/readme/statistics-finder.md#search-for-geolocation-data)
    - [Build a graph with "Google Charts"](doc/readme/graph-google-charts.md#build-a-graph-with-google-charts)
    - [The *StatsComputer* service](doc/readme/statistics-computer.md#the-statscomputer-service)
      - [Calculates the *min value*](doc/readme/statistics-computer.md#calculates-the-min-value)
      - [Calculates the *max value*](doc/readme/statistics-computer.md#calculates-the-max-value)
      - [Calculates the *average*](doc/readme/statistics-computer.md#calculates-the-average)
      - [Calculates the *range*](doc/readme/statistics-computer.md#calculates-the-range)
      - [Calculates the *mode*](doc/readme/statistics-computer.md#calculates-the-mode)
      - [Calculates the *median*](doc/readme/statistics-computer.md#calculates-the-median)
      - [Count the number of values ​​in the statistical series](doc/readme/statistics-computer.md#count-the-number-of-values-in-the-statistical-series)
 - [Tools](doc/readme/tools-command-cleanup.md#tools)
   - [Command](doc/readme/tools-command-cleanup.md#command)
     - [Cleanup ViewCounter data](doc/readme/tools-command-cleanup.md#cleanup-viewcounter-data)
     - [Converts ViewCounter entities to statistical data](doc/readme/tools-command-stats-converter.md#converts-viewcounter-entities-to-statistical-data)
- [Original Credits](#original-credits)
- [License](#license)

# Features include

    - Viewcounter
    - Statistics
    - Geolocation

# Documentation

[The ViewCounter documentation](https://github.com/tchoulom/ViewCounterBundle)

# Original Credits

Created by Ernest TCHOULOM

# License

This bundle is released under the MIT license. See the complete license in the
bundle:

```text
LICENSE
```

Enjoy!
