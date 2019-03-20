

This project is here to illustrate the memory and execution time differences when using `via()` vs `join()` under certain conditions. To use this repo:

1. Configure the database configuration in `environments/dev/common/config/main-local.php`
2. Run the migrations `./yii migrate`
3. Run the commands to test loading a model `./yii load-test/use-via` or `./yii load-test/use-join`

That's it. You should see output in your command line that indicates the memory used in bytes and the total time taken to execute the test