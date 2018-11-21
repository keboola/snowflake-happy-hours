# my-component

[![Build Status](https://travis-ci.com/keboola/snowflake-happy-hours.svg?branch=master)](https://travis-ci.com/keboola/my-component)

Component for switching Snowflake's warehouse performance.

# Usage

Basic configuration:
```
{
        "host": "domain.snowflakecomputing.com",
        "user": "USER",
        "#password": "PASS",
        "warehouse": "YOUR_WAREHOUSE",
        "min_cluster_count": 1,
        "max_cluster_count": 4,
        "max_concurrency_level": 8,
        "warehouse_size": "SMALL"
}
```
 - host (string) - hostname of your snowflake warehouse
 - user (string) - user with privilege to ALTER WAREHOUSE
 - \#password (string) - user's password
 - warehouse (string) - name of affected warehouse
 - min_cluster_count (int) - value <= 2
 - max_cluster_count (int) - value >= 3
 - max_concurrency_level (int) - value from interval <4, 12>
 - warehouse_size (string) - enum ["SMALL"|"MEDIUM"|"LARGE"]

## Development
 
Clone this repository and init the workspace with following command:

```
git clone https://github.com/keboola/snowflake-happy-hours
cd snowflake-happy-hours
docker-compose build
docker-compose run --rm dev composer install --no-scripts
```

Run the test suite using this command:

```
docker-compose run --rm dev composer tests
```
 
# Integration

For information about deployment and integration with KBC, please refer to the [deployment section of developers documentation](https://developers.keboola.com/extend/component/deployment/) 
