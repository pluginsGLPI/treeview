# Notes de migration GLPI 12 — plugin TreeView

Migration réalisée sur la branche `feature/glpi-12.0`. Environnement : GLPI
core `main` (`12.0.0-dev`, hôte `glpi-db-v12`), PHP 8.4, plugin
`feature/glpi-12.0` rebasé sur `origin/main` (`722fbf2`, « 1.20.3 » #127).

**Aucun environnement de test / migration Docker disponible** pour cette
session : la Phase 2 (migration réelle 11 → 12 avec BDD isolée) et
l'exécution de la Phase 3 (`phpunit`, qui exige une BDD de test avec le
plugin installé + actif) n'ont **pas** pu être déroulées. Les fichiers de
tests ont été validés statiquement (lint, PHPStan, cohérence avec les
helpers `Glpi\Tests\*` du core 12). Tout le reste (Phases 1, 4, 5) a été
mené à bien.

## Points d'attention rencontrés

- **`vendor/` local requis** : `plugin_treeview_check_prerequisites()`
  échoue tant que `plugins/treeview/vendor/autoload.php` n'existe pas →
  `composer install --no-dev` obligatoire après chaque clone / rebuild.
  `vendor/` est git-ignoré. TreeView n'a aucune dépendance runtime
  (`composer.json require` = `php` seul), `composer install` ne fait que
  générer l'autoloader.
- **`require-dev: glpi-project/tools`** retiré de `composer.json` par la
  branche `feature/glpi-12.0` (évite la collision `symfony/console` /
  `Cannot redeclare CommandLoaderInterface` avec le core). `composer.lock`
  allégé en conséquence (869 lignes de packages-dev supprimées).
- **Protection CSRF sans token en GLPI 12** : `Session::getNewCSRFToken()`
  et la fonction Twig `csrf_token()` sont **dépréciées** (« Csrf protection
  is now handled without tokens », `src/Session.php`). Le core n'utilise
  plus `csrf_token()` dans aucun template. Appeler ces API émettrait une
  déprécation → échec des tests via `GLPITestCase::tearDown()`. D'où la
  suppression des `<input type="hidden" name="_glpi_csrf_token">` des 3
  templates et du token manuel dans l'URL de recherche
  (`inc/config.class.php`).
- **`CacheManager->clearSymfonyCache()`** émet un `CRITICAL` non bloquant en
  fin de `database:update` — bug d'environnement core, indépendant du
  plugin, à ne pas porter dans la PR.
- **Suspension des plugins après MAJ majeure** (non observé ici, pas de
  bascule réelle) : une vraie migration 11 → 12 met
  `core.plugins_execution_mode = suspended_by_update` → toutes les URL
  `/plugins/*/front/*.php` renvoient **404** jusqu'à
  `php bin/console plugin:resume_execution`.

## Phase 1 — Rebase de `feature/glpi-12.0` sur `main`

`feature/glpi-12.0` (`ced8c55`) partait de `b2b679a` ; `main` avait 3
commits d'avance (#123 « item validation when loading trees », #125
« enforce preference check », #127 « 1.20.3 ») → **rebase non trivial**.

Conflits résolus :

| Fichier | Résolution |
|---|---|
| `CHANGELOG.md` | nouvelle section `## [1.21.0]` (Added: GLPI 12 compatibility) au-dessus de `## [1.20.3]` |
| `setup.php` | `VERSION` = `1.20.3` (côté main) puis bumpé `1.21.0` en Phase 5 ; `MIN`/`MAX_GLPI` = `12.0.0` / `12.0.99` (côté feature) |
| `templates/preference.html.twig` | `#125` retire `<input name="id">` (l'`id` est désormais résolu côté serveur), `ced8c55` retire `<input name="_glpi_csrf_token">` → **les deux lignes supprimées** |
| `inc/config.class.php` | auto-merge OK : refactor sécurité de `#123` + suppression du token CSRF de l'URL de recherche |

Le commit `ced8c55` rebasé apporte : contraintes GLPI
`12.0.0` / `12.0.99` (`setup.php`), matrice CI `12.0.x`, `Makefile`,
suppression `require-dev` tools + `composer.lock` allégé, retrait des
tokens CSRF manuels (3 templates + `inc/config.class.php`).

## Phase 2 — Migration GLPI 11 → 12

**Non réalisée** (pas d'environnement Docker / BDD isolée). Le plugin crée
3 tables (`glpi_plugin_treeview_configs`, `_profiles`, `_preferences`) via
`hook.php` ; aucun secret chiffré, aucune tâche cron, aucune notification,
et `plugin_treeview_install()` porte déjà toute la chaîne d'upgrade
historique (1.0 → 1.4, renommages de tables inclus). Le risque de
régression de données sur une bascule 11 → 12 est faible, mais **reste à
valider** dans un environnement dédié avant publication — la Phase 1 du
schéma est désormais couverte par `InstallationTest` en CI.

## Phase 3 — Tests fonctionnels automatisés

Harnais **déjà correct** sur `main` (repris tel quel par le rebase), aux
standards GLPI 12 :

- `tests/bootstrap.php` → `require ../../../tests/bootstrap.php` (bootstrap
  core, expose `Glpi\Tests\*`) + `require_once TreeviewTestCase.php` +
  garde `Plugin::isPluginActive('treeview')`.
- `phpunit.xml` → suite unique `<directory>tests</directory>`.
- `tests/TreeviewTestCase.php` : `abstract` sur `Glpi\Tests\DbTestCase`,
  helper `getTreeOutput()` qui capture la sortie JS de
  `PluginTreeviewConfig::getNodesFromDb()`.
- `tests/Units/ConfigTest.php` : la sortie de l'arbre ne montre que les
  données de l'entité active + masque un itemtype sans droit `READ`.
- `tests/Units/PreferenceTest.php` : `checkIfPreferenceExists()` /
  `update()` sont bien cloisonnés au propriétaire connecté.

Ces deux fichiers couvrent les correctifs sécurité #123/#125 mais rien de
spécifique à la migration de version. Ajouté pour cette PR :

- `tests/bootstrap.php` → `require_once ../hook.php` (les routines
  `plugin_treeview_install/uninstall()` ne sont autoloadées que pendant
  l'(dés)installation).
- `tests/Units/InstallationTest.php` (`extends GLPITestCase`, pas de
  transaction car DDL) : contraintes GLPI = `12.0.0`/`12.0.99` ; les 3
  tables + leurs colonnes existent, tables héritées (`_display`,
  `_displayprefs`, `_preference`) absentes ; ligne de conf `id=1` semée ;
  au moins un profil a l'accès `treeview` ; **idempotence** de
  `plugin_treeview_install()` (re-run ⇒ aucun doublon, `clearSchemaCache`).
- `tests/Units/UninstallationTest.php` (`extends GLPITestCase`) :
  `plugin_treeview_uninstall()` réel ⇒ les 3 tables sont supprimées, puis
  **réinstallation dans un `finally`** (BDD de test partagée) ⇒ tables
  recréées + conf `id=1` re-semée.
- `tests/Units/FormRenderingTest.php` (`extends TreeviewTestCase`) : rend
  les 3 formulaires Twig modifiés (`showConfigForm()`,
  `PluginTreeviewProfile::showForm()`, `showFormUserPreference()`) ⇒
  `<form>` présent, champ attendu présent, **aucun `_glpi_csrf_token`**.
  `GLPITestCase::tearDown()` transforme toute déprécation
  (`Session::getNewCSRFToken()`…) en échec ⇒ verrou anti-régression CSRF.

Vérifications effectuées (sans BDD de test) :

- `parallel-lint` sur `tests/` → aucune erreur de syntaxe.
- Helpers utilisés (`login`, `getTestRootEntity`, `createItem`,
  `setEntity`, `removeRightFromProfile`, `addRightToProfile`,
  `getUniqueString`) → tous présents dans `tests/src/{DbTestCase,
  GLPITestCase}.php` du core 12.
- `phpunit --list-tests` s'arrête proprement sur « Plugin treeview is not
  active in the test database » (bootstrap core chargé, autoload plugin OK,
  seule la BDD de test manque) → structure du harnais saine.
- Les modifications de code (résolutions de conflit, Rector) ne touchent
  pas les API couvertes par les tests (`getNodesFromDb`,
  `checkIfPreferenceExists`, `addDefaultPreference`, `update`).

**À faire avant merge** : `make test-setup` (env testing) puis
`php ../../vendor/bin/phpunit` depuis `plugins/treeview/` dans un
environnement disposant d'une BDD de test.

## Phase 4 — Analyse statique / lint

| Outil | Résultat |
|---|---|
| `parallel-lint` (front, inc, public, hook.php, setup.php, tests) | ✅ aucune erreur |
| `php-cs-fixer` (dry-run) | ✅ 0 finding sur le code source (seuls des fichiers de cache `var/rector/`, git-ignorés, sont signalés) |
| `rector` (baseline `../../PluginsRector.php`) | 🔧 6 fichiers corrigés → dry-run ensuite propre |
| PHPStan level 5 | ✅ `No errors` |
| Psalm (+ taint) | ✅ `No errors` |
| `twigcs` (templates/) | ✅ `No violation found` |
| `tools:licence_headers_check --plugin=treeview` | ✅ headers valides |

Correctifs Rector (équivalences sûres en GLPI 12) :

- `ReplaceCommonGlpiGetTypeByClassConstantRector` : `$item->getType()` /
  `$item::getType()` → `$item::class` dans `inc/{config,preference,
  profile}.class.php` (`getTabNameForItem` / `displayTabContentForItem`).
  En GLPI 12 `getType()` renvoie déjà `static::class` ; pour les classes
  core (`Config`, `Preference`, `Profile`, non namespacées) la valeur est
  identique.
- `ReplaceHardcodedRightnameByCommonDBTMRightnamePropertyRector` :
  `'config'` → `Config::$rightname`, `'profile'` → `Profile::$rightname`
  dans `setup.php`, `front/config.form.php`, `front/profile.form.php`,
  `inc/profile.class.php`.

## Phase 5 — Versioning & finalisation

- Bump **`1.20.3` → `1.21.0`** :
  - `setup.php` : `PLUGIN_TREEVIEW_VERSION` = `1.21.0` ;
    `PLUGIN_TREEVIEW_MIN_GLPI` / `MAX_GLPI` = `12.0.0` / `12.0.99`.
  - `treeview.xml` : nouveau bloc `<version>` `1.21.0` /
    `<compatibility>~12.0.0</compatibility>`.
  - `CHANGELOG.md` : `## [1.21.0] - 2026-09-07`.
- `composer install --no-dev` rejoué (autoloader).
