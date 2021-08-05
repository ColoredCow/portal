## Coding Standards

We enforce best coding practices as recommended by community leaders. This projects uses the following tools to ensure best coding practices are being followed.

  - [Husky & Lint-Staged](#husky--lint-staged)
  - [PHP CS Fixer](#php-cs-fixer)
  - [Larastan](#larastan)
  - [ESLint](#eslint)

### Husky & Lint-Staged
[Husky](https://github.com/typicode/husky) helps to trigger git hooks. We use the pre-commit hook to run code fixers to fix errors that violates our coding standards. [Lint staged](https://github.com/okonet/lint-staged) helps Husky triggers to run only on files modified in the commit and avoid running on the whole codebase. More information can be found in [`package.json`](../package.json) file.

**Note:** Your commit may fail if the automatic fixes fails. In such case, you can fix the errors manually and then commit again.

Run the code fixers on the staged files manually using:
```sh
npx lint-staged
```

### PHP CS Fixer
[PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) is a tool to automatically fix PHP code style issues. PHP CS Fixer coding rules are defined in [`.php-cs-fixer.php`](../.php-cs-fixer.php) file in the root of the project.

:white_check_mark: It is automatically triggered during git commit. The automatic fixer may not resolve 100% of the errors. Manual intervention may be needed.

See the files that violates PHP coding rules using:
```sh
php ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php --dry-run --verbose --diff
```

To trigger automatic fixer manually, run the following command:
```sh
php ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php --diff
```

### Larastan
[Larastan](https://github.com/nunomaduro/larastan/) is a Static Code Analyzer that finds errors in the code without actually running it. Larastan runs on top of PHPStan. Larastan configurations are stored in file [`phpstan.neon`](../phpstan.neon) in the root of the project.

:x: It is NOT automatically triggered during git commit.

Analyze the codebase using:
```sh
./vendor/bin/phpstan analyse
```

### ESLint
[ESLint](https://github.com/eslint/eslint) is used to validate the JS and VueJS files. ESLint rules are defined in [`.eslintrc.json`](../.eslintrc.json) file in the root of the project.

:white_check_mark: It is automatically triggered during git commit. The automatic fixer may not resolve 100% of the errors. Manual intervention may be needed.

Check the ESLint errors in the codebase using:
```sh
./node_modules/.bin/eslint resources/js/ Modules/*/Resources/assets/js/ --ext .js,.vue
```

To trigger automatic fixer manually, use the `--fix` flag:
```sh
./node_modules/.bin/eslint resources/js/ Modules/*/Resources/assets/js/ --ext .js,.vue --fix
```
