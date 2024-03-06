# Larawatch Pro Logger

This package has been heavily inspired by the _Larahawk Watcher_ package. Since the service seems to be dead, I decided to rewrite it almost from scratch.

This watcher package listens for exceptions and log events from your Laravel application and reports them back to your LaraWatchPro account.

## Installation

1. Create a LarawatchPro account, or host your own server ! 
2. Install this package using `composer require larawatchpro/logger`
3. Make any desired adjustments to the watcher using the package's config file
4. Declare the logger in your `config/logging.php` file :
   ```
   'channels' => [
        'larawatch' => [
            'driver' => 'custom',
            'via' => LarawatchLogger\Logger::class,
        ],
   ```
5. Add your project's API key and server URL to the application's `.env` file.
6. Change your logger in `.env` to `LOG_CHANNEL=larawatch`

## Contributing and Support

Feel free to [submit any issues](https://github.com/adesin-fr/larawatchLogger/issues/new) you might have with this package, but please search through [previously-added ones](https://github.com/adesin-fr/larawatchLogger/issues) first. All contributions are welcome!

## License

The MIT License (MIT). See [LICENSE.md](https://github.com/larawatch/watcher/blob/master/LICENSE.md) for more details.
