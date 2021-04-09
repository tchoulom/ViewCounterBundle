# Tools

## Command

### Cleanup viewcounter data

You can delete the viewcounter data using the **ViewcounterCleanupCommand** command:

- Delete all the viewcounter data from the database:

```bash
   php bin/console tchoulom:viewcounter:cleanup
```

- Delete all the viewcounter data whose article was viewed at least 1 hour ago:

```bash
   php bin/console tchoulom:viewcounter:cleanup --min=1h
```

- Delete all the viewcounter data whose article was viewed at most 1 day ago:

```bash
   php bin/console tchoulom:viewcounter:cleanup --max=1d
```

- Delete all the viewcounter data whose article was viewed at least 3 years ago:

```bash
   php bin/console tchoulom:viewcounter:cleanup --min=3y
```

- Delete all the viewcounter data whose article was viewed at most 5 months ago:

```bash
   php bin/console tchoulom:viewcounter:cleanup --max=5M
```

- Add the 'auto-approve' option to skip approval questions:

```bash
   php bin/console tchoulom:viewcounter:cleanup --max=5M --auto-approve=true
   
   By default, the value of the 'auto-approve' option is equal to false.
```

- Examples of date interval:

```text
's' => 'second'
'm' => 'minute'
'h' => 'hour'
'd' => 'day'
'w' => 'week'
'M' => 'month'
'y' => 'year'
```
