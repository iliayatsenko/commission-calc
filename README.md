### Commission-Calc
#### Test application which: 
1. takes list of transactions' data,
2. recalculates its' amounts according to the current exchange rates, 
3. determines country of the transaction by BIN number, 
4. adds appropriate commission fee
5. returns corrected amounts of transactions.

#### To set up the application:
1. Clone the repository
2. Run `export USER_ID=$(id -u)` and `export GROUP_ID=$(id -g)`
3. Run `docker compose -f docker_dev/compose.yml run --rm commission-calc composer install`

#### To run the application's functional tests:
1. Run `docker compose -f docker_dev/compose.yml run --rm commission-calc composer test-functional`

#### To run the application's unit tests:
1. Run `docker compose -f docker_dev/compose.yml run --rm commission-calc composer test-unit`

#### To run the application with custom input file:
1. Run `docker compose -f docker_dev/compose.yml run --rm commission-calc php calc.php <input_filename>`