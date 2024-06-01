# Snowflake Happy hours

Component for changing Snowflake warehouse size and parameters.

## Usage

Basic configuration:
```json
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

 - `host` (string) - hostname of your Snowflake warehouse
 - `user` (string) - user with privilege to `ALTER WAREHOUSE`
   - e.g., for role: `GRANT MODIFY ON WAREHOUSE "YOUR_WAREHOUSE" TO ROLE "ROLE_NAME";`
 - `#password` (string) - user's password
 - `warehouse` (string) - name of warehouse to update
 - `min_cluster_count` (int) - min number of clusters
 - `max_cluster_count` (int) - max number of clusters
 - `max_concurrency_level` (int) - max concurrency level
 - `warehouse_size` (string) - warehouse size

Check [ConfigDefinition.php](/src/ConfigDefinition.php) for available values and ranges.

## Development
 
Clone this repository and init the workspace with following command:
```shell
git clone git@github.com:keboola/snowflake-happy-hours.git
cd snowflake-happy-hours
docker-compose build
docker-compose run --rm dev composer install --no-scripts
```

Run the test suite using this command:
```shell
docker-compose run --rm dev composer tests
```
 
## Resources

- [Virtual warehouses](https://docs.snowflake.com/en/user-guide/warehouses)
- [MAX_CONCURRENCY_LEVEL](https://docs.snowflake.com/en/sql-reference/parameters#label-max-concurrency-level)
- [SHOW WAREHOUSES](https://docs.snowflake.com/en/sql-reference/sql/show-warehouses)

