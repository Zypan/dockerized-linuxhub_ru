# Yandex Metrika Extension

An extension for phpBB 3.1 that allows administrators to easily add their Yandex Metrika tracking code to their phpBB forum.

## Quick Install
You can install this on the latest release of phpBB 3.1 by following the steps below:

1. [Download the latest release](https://dmyt.ru/forum/viewtopic.php?f=35&t=518).
2. Unzip the downloaded release, and change the name of the folder to `yandexmetrika`.
3. In the `ext` directory of your phpBB board, create a new directory named `designermix` (if it does not already exist).
4. Copy the `yandexmetrika` directory to `phpBB/ext/designermix/` (if done correctly, you'll have the main composer JSON file at (your forum root)/ext/designermix/yandexmetrika/composer.json).
5. Navigate in the ACP to `Customise -> Manage extensions`.
6. Look for `Yandex Metrika` under the Disabled Extensions list, and click its `Enable` link.
7. Set up and configure Board Rules by navigating in the ACP to `Extensions` -> `Yandex Metrika`.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `Yandex Metrika` under the Enabled Extensions list, and click its `Disable` link.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/phpbb/yandexmetrika` directory.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
