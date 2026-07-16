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
    - [The *FileStatsFinder* service](Resources/doc/readme/statistics-finder.md#the-filestatsfinder-service)
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
- [Powered by Brainveris AI](#powered-by-brainveris-ai)
  - [From your ViewCounter metrics to strategic decisions](#from-your-viewcounter-metrics-to-strategic-decisions)
  - [More than a tool: a partner in your AI journey](#more-than-a-tool-a-partner-in-your-ai-journey)
  - [Stay connected](#stay-connected)
  - [Get started](#get-started)
- [Original Credits](#original-credits)
- [License](#license)

# Features include

    - Viewcounter
    - Statistics
    - Geolocation

# Documentation

[The ViewCounter documentation](https://github.com/tchoulom/ViewCounterBundle)

# Powered by Brainveris AI

<a href="https://brainveris.ai"><img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/brainveris/brainveris-hero.png" alt="Brainveris AI — French AI-augmented strategic intelligence platform" align="center" /></a>

**[Brainveris AI](https://brainveris.ai)** is a **French AI-augmented strategic intelligence platform**.

Upload any strategic document — whatever its size (**100, 500, 1,000 pages or more, with no limit**) — such as an **annual report**, a **business plan**, an **audit** or a **market study**, and automatically generate a **complete ~80-page strategic report in under 10 minutes**:

- **Executive Summary**
- **SWOT**
- **PESTEL**
- **Competitive analysis**
- **Actionable recommendations**
- **KPIs**
- **Roadmap**

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/brainveris/brainveris-workflow.png" alt="How Brainveris AI works: upload any document and get an ~80-page strategic report in under 10 minutes" align="center" />

## From your ViewCounter metrics to strategic decisions

This bundle already captures rich viewership metrics and statistical data — **yearly, monthly, weekly, daily, hourly, per-minute and per-second** views, together with **geolocation** data by **country, region and city**.

**Brainveris AI can analyze and exploit these very metrics** to turn them into a meaningful, decision-ready strategic report. In other words, the data you collect with the ViewCounter Bundle becomes real strategic value — audience trends, geographic reach, actionable recommendations and a data-driven roadmap.

<img src="https://raw.githubusercontent.com/tchoulom/ViewCounterBundle/master/Resources/doc/images/brainveris/brainveris-viewcounter.png" alt="From ViewCounter metrics to a Brainveris AI strategic intelligence report" align="center" />

## More than a tool: a partner in your AI journey

> But the platform is only a gateway. Beyond the tool, Brainveris supports companies more broadly on strategic AI consulting, digital transformation and the automation of their business processes through AI — because giving AI a framework is not just a matter of tooling, it is an organizational project.

## Stay connected

We regularly publish articles on **strategic AI consulting**, **digital transformation** and the **automation of business processes through AI**. Follow Brainveris AI to stay up to date across our social networks:

- 🌐 **Website** — [https://brainveris.ai](https://brainveris.ai)
- 💼 **LinkedIn** — [https://www.linkedin.com/company/brainveris](https://www.linkedin.com/company/brainveris)
- 𝕏 **X (Twitter)** — [https://x.com/ErnestTchoulom](https://x.com/ErnestTchoulom)
- 📘 **Facebook** · 📸 **Instagram** · ▶️ **YouTube** *(and more)*

## Get started

See Brainveris AI in action on your own documents.

- 📅 **Demo availability:** every **Monday, Friday, Saturday and Sunday, 10:00–20:00 (Paris time)**
- 👉 **Book a demo:** [https://cal.com/brainveris/30min](https://cal.com/brainveris/30min) — or via [https://brainveris.ai](https://brainveris.ai)
- 🚀 **Create your account:** [https://brainveris.ai/auth/register](https://brainveris.ai/auth/register)

---

**Dr Ernest TCHOULOM**<br>
Doctor in Business Administration (DBA) — specializing in Artificial Intelligence<br>
Founder – Brainveris<br>
📱 +33 6 29 34 13 02<br>
🌐 [https://brainveris.ai](https://brainveris.ai)

---

# Original Credits

Created by Ernest TCHOULOM

# License

This bundle is released under the MIT license. See the complete license in the
bundle:

```text
LICENSE
```

Enjoy!
