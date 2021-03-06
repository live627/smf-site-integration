# Changelog

### [2.0.1](https://www.github.com/live627/smf-site-integration/compare/v2.0.0...v2.0.1) (2022-04-17)


### Bug Fixes

* Many undefined errors in the spider log ([be2f117](https://www.github.com/live627/smf-site-integration/commit/be2f117f9db7193978d1740227e6b6782d991125))
* Naming mixup on Who's Online page ([e450669](https://www.github.com/live627/smf-site-integration/commit/e450669212acabebf859c4379447331dc4f5f02c))

## [2.0.0](https://www.github.com/live627/smf-site-integration/compare/v1.4.1...v2.0.0) (2021-10-27)


### ⚠ BREAKING CHANGES

* Drop support for SMF v1.1.x
* This now requires PHP 7.0.0.

### Features

* Actions will now show the page title in a title bar, as well as add to the linktree ([698451e](https://www.github.com/live627/smf-site-integration/commit/698451e0c367532f82ccefeaaacc4861919b88f9))
* Drop option to specify file extensions as only php files are used ([698451e](https://www.github.com/live627/smf-site-integration/commit/698451e0c367532f82ccefeaaacc4861919b88f9))
* Drop options for fallback actions when permissions were not satisfied ([698451e](https://www.github.com/live627/smf-site-integration/commit/698451e0c367532f82ccefeaaacc4861919b88f9))
* Drop support for SMF v1.1.x ([698451e](https://www.github.com/live627/smf-site-integration/commit/698451e0c367532f82ccefeaaacc4861919b88f9))
* Show a nice error box detailing illegal action filenames ([698451e](https://www.github.com/live627/smf-site-integration/commit/698451e0c367532f82ccefeaaacc4861919b88f9))
* use English as the fallback language ([698451e](https://www.github.com/live627/smf-site-integration/commit/698451e0c367532f82ccefeaaacc4861919b88f9))


### Bug Fixes

* Remove redirects as it was possible to get stuck in an infinite loop ([698451e](https://www.github.com/live627/smf-site-integration/commit/698451e0c367532f82ccefeaaacc4861919b88f9))


### Code Refactoring

* Use integration hooks where possible to reduce file edits ([698451e](https://www.github.com/live627/smf-site-integration/commit/698451e0c367532f82ccefeaaacc4861919b88f9))
