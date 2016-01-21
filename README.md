# Composer Fast Update

## Installation

```
git clone https://github.com/webflo/composer-fast-update.git
cd composer-fast-update
composer install
chmod a+x composer-fast-update.php
ln -nfs $(pwd)/composer-fast-update.php ~/bin/composer-fast-update
```

## Usage

```
composer-fast-update vendor/my-package git-branch
```

## Example

```
composer-fast-update drupal/field_group 8.x-1.x
```
