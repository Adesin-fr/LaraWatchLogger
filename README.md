# Larawatch Pro Logger

This package has been heavily inspired by the _Larahawk Watcher_ package. Since the service seems to be dead, I decided to rewrite it almost from scratch.

This watcher package listens for exceptions and log events from your Laravel application and reports them back to your LaraWatchPro account.

## Features

- Automatically reports unhandled exceptions
- Reports helpful log events by default
- Attaches user, browser, and OS information to each event

## Installation

1. Create a LarawatchPro account, or host your own server ! 
2. Install this package using `composer require adesin-fr/larawatchLogger`
3. Add your project's API key and server URL to the application's `.env` file
4. Make any desired adjustments to the watcher using the package's config file

## Contributing and Support

Feel free to [submit any issues](https://github.com/adesin-fr/larawatchLogger/issues/new) you might have with this package, but please search through [previously-added ones](https://github.com/adesin-fr/larawatchLogger/issues) first. All contributions are welcome!

## License

The MIT License (MIT). See [LICENSE.md](https://github.com/larahawk/watcher/blob/master/LICENSE.md) for more details.
