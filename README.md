# Site Migration Tool

This is a web-based tool that was created to automate the necessary database changes for a newly migrated (single tenant => multi tenant) database.  The following are assumptions:

- As a web-based tool, you must use Apache to run the migrations.  The URL is provided below.
- You have the necessary access to the staging database.  Creds will be in the config.php file.
- The target database has been migrated (single tenancy to multi tenancy).

## Requirements

The user must add their own config.php file with their credentials.  Below is an example to use as a template:

```
  <?php
  // staging
  define('HOSTNAME', "mariadb.staging.local");
  define('USERNAME', "<username>");
  define('PASSWORD', "<password>");
```

## Running the Migration

To run a migration, use the following url:

> http://localhost/site-database-migration.php?source=thecolony&target=wm_salida

The URL variables will specify what migration gets processed.  There are two variables:

> **source** - This represents the source database to pull the data.  Presently, it is defaulted to thecolony if not specified.
> 
> **target** - This represents the target database and will be the newly created multi tenancy site.
