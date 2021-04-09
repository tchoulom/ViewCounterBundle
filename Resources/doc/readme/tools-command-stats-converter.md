# Tools

## Command

### Converts ViewCounter entities to statistical data

The creation of statistical data after each view count may slow performance of your application.

It is possible to avoid the creation of statistical data after each view count, by proceeding as follows:

- Disable the use of statistics

Set **enabled** to **false** in config :

```yaml

    tchoulom_view_counter:
        ...
        statistics:
            enabled: false
        ...
```

- Run the following command:

This command converts ViewCounter entities to statistical data.

```bash
   php bin/console tchoulom:viewcounter:stats:convert
```

or

```bash
   php bin/console tchoulom:viewcounter:stats:convert --cleanup=true
```

- Add the 'auto-approve' option to skip approval questions:

```bash
   php bin/console tchoulom:viewcounter:stats:convert --cleanup=true --auto-approve=true
   
   By default, the value of the 'auto-approve' option is equal to false.
```

This command can be automated via a cron task.

The **cleanup** option allows to delete or not the ViewCounter entities after the generation of the statistical data.

If the **cleanup** option is equal to **true**, the ViewCounter entities will be deleted after generating the statistical data.

If the **cleanup** option is equal to **false**, the ViewCounter entities will not be deleted after generating the statistical data.

By default the value of the **cleanup** option is equal to **true**.
